<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function create()
    {
        $orders = Order::with('user')
                     ->whereDoesntHave('payments')
                     ->orWhereHas('payments', function($query) {
                         $query->where('status', 'failed');
                     })
                     ->latest()
                     ->get();
        
        return view('admin.finance.pages.payments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:bank_transfer,qris,cod',
            'sender_name' => 'nullable|string|max:255',
            'status' => 'required|in:pending,verified',
            'notes' => 'nullable|string|max:500'
        ]);

        $order = Order::findOrFail($request->order_id);
        
        Payment::create([
            'order_id' => $order->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'sender_name' => $request->sender_name,
            'status' => $request->status,
            'verified_by' => $request->status === 'verified' ? auth()->id() : null,
            'verified_at' => $request->status === 'verified' ? now() : null,
            'notes' => $request->notes
        ]);

        // Update order payment status
        $order->update([
            'payment_status' => $request->status,
            'status' => $request->status === 'verified' ? 'payment_verified' : $order->status
        ]);

        return redirect()->route('admin.finance.payments.index')
                        ->with('success', 'Pembayaran manual berhasil ditambahkan');
    }

    public function index(Request $request)
    {
        $query = Payment::with(['order.user', 'verifiedBy']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('order', function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $payments = $query->latest()->paginate(20)->withQueryString();
        
        // Statistics for dashboard cards
        $stats = [
            'pending' => Payment::where('status', 'pending')->count(),
            'verified' => Payment::where('status', 'verified')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'today' => Payment::whereDate('created_at', today())->count()
        ];
        
        return view('admin.finance.pages.payments.index', compact('payments', 'stats'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['order.user', 'order.orderItems.menu', 'verifiedBy']);
        return view('admin.finance.pages.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:verified,failed',
            'notes' => 'nullable|string|max:500'
        ]);

        $payment->update([
            'status' => $request->status,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'notes' => $request->notes
        ]);

        // Update order payment status
        if ($request->status === 'verified') {
            $payment->order->update([
                'payment_status' => 'verified',
                'status' => $payment->order->status === 'pending' ? 'payment_verified' : $payment->order->status
            ]);
        } else {
            $payment->order->update(['payment_status' => 'failed']);
        }

        $message = $request->status === 'verified' 
            ? 'Pembayaran berhasil diverifikasi' 
            : 'Pembayaran ditolak';

        return redirect()->back()->with('success', $message);
    }

    public function bulkVerify(Request $request)
    {
        $request->validate([
            'payment_ids' => 'required|array',
            'payment_ids.*' => 'exists:payments,id',
            'status' => 'required|in:verified,failed',
            'notes' => 'nullable|string|max:500'
        ]);

        $payments = Payment::whereIn('id', $request->payment_ids)->get();
        
        foreach ($payments as $payment) {
            $payment->update([
                'status' => $request->status,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'notes' => $request->notes
            ]);

            // Update order status
            if ($request->status === 'verified') {
                $payment->order->update([
                    'payment_status' => 'verified',
                    'status' => $payment->order->status === 'pending' ? 'payment_verified' : $payment->order->status
                ]);
            } else {
                $payment->order->update(['payment_status' => 'failed']);
            }
        }

        $message = $request->status === 'verified' 
            ? count($request->payment_ids) . ' pembayaran berhasil diverifikasi'
            : count($request->payment_ids) . ' pembayaran ditolak';

        return redirect()->back()->with('success', $message);
    }

    public function downloadProof(Payment $payment)
    {
        if (!$payment->payment_proof) {
            return redirect()->back()->with('error', 'Bukti pembayaran tidak tersedia');
        }

        $filePath = storage_path('app/public/' . $payment->payment_proof);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File bukti pembayaran tidak ditemukan');
        }

        return response()->download($filePath, 'bukti-pembayaran-' . $payment->order->order_number . '.jpg');
    }
}