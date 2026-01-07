<?php

namespace App\Http\Controllers\Admin\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;

class KitchenOrderController extends Controller
{
    public function today()
    {
        $today = now()->format('Y-m-d');
        
        $orders = Order::with(['orderItems.menu', 'user', 'deliveryArea'])
                      ->whereDate('delivery_date', $today)
                      ->whereIn('status', ['payment_verified', 'preparing', 'ready', 'on_delivery', 'delivered'])
                      ->where('payment_status', 'verified')
                      ->orderBy('delivery_time')
                      ->get();

        return view('admin.kitchen.pages.orders.today', compact('orders'));
    }

    public function index(Request $request)
    {
        $query = Order::with(['orderItems.menu', 'user', 'deliveryArea'])
                     ->where('payment_status', 'verified');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['payment_verified', 'preparing', 'ready', 'on_delivery', 'delivered']);
        }

        if ($request->filled('date')) {
            $query->whereDate('delivery_date', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('delivery_date', 'desc')
                       ->orderBy('delivery_time', 'desc')
                       ->paginate(20)
                       ->withQueryString();

        return view('admin.kitchen.pages.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['orderItems.menu.category', 'user', 'deliveryArea', 'deliveryType']);
        return view('admin.kitchen.pages.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:preparing,ready'
        ]);

        $oldStatus = $order->status;
        
        $order->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

        // Kirim notifikasi ke user
        $order->user->notify(new OrderStatusNotification($order, $oldStatus, $request->status));

        $message = $request->status === 'preparing' 
            ? 'Pesanan mulai diproses di dapur' 
            : 'Pesanan sudah siap untuk dikirim';

        return redirect()->back()->with('success', $message . ' dan notifikasi telah dikirim ke customer');
    }
}