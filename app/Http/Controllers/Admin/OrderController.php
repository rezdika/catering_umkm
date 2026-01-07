<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'deliveryType', 'deliveryArea']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->latest()->paginate(15);
        return view('admin.pages.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.menu', 'payments', 'statusLogs.changedBy']);
        return view('admin.pages.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
            'notes' => 'nullable|string'
        ]);

        $order->update(['status' => $request->status]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'notes' => $request->notes,
            'changed_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Status order berhasil diupdate');
    }

    public function assignKurir(Request $request, Order $order)
    {
        $request->validate([
            'kurir_id' => 'required|exists:users,id'
        ]);

        $order->update(['assigned_kurir_id' => $request->kurir_id]);
        return redirect()->back()->with('success', 'Kurir berhasil ditugaskan');
    }
}