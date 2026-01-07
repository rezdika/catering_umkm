<?php

namespace App\Http\Controllers\Admin\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;

class KurirOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['orderItems.menu', 'user', 'deliveryArea'])
                     ->where('payment_status', 'verified')
                     ->whereIn('status', ['ready', 'on_delivery', 'completed']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('delivery_date', $request->date);
        }

        if ($request->filled('kurir') && $request->kurir === 'mine') {
            $query->where('assigned_kurir_id', auth()->id());
        }

        $orders = $query->orderBy('delivery_date', 'desc')
                       ->orderBy('delivery_time', 'desc')
                       ->paginate(20)
                       ->withQueryString();

        return view('admin.kurir.pages.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['orderItems.menu.category', 'user', 'deliveryArea', 'deliveryType', 'kurir']);
        return view('admin.kurir.pages.orders.show', compact('order'));
    }

    public function takeOrder(Order $order)
    {
        if ($order->status !== 'ready') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat diambil');
        }

        $oldStatus = $order->status;
        
        $order->update([
            'assigned_kurir_id' => auth()->id(),
            'status' => 'on_delivery'
        ]);

        // Kirim notifikasi ke user
        $order->user->notify(new OrderStatusNotification($order, $oldStatus, 'on_delivery'));

        return redirect()->back()->with('success', 'Pesanan berhasil diambil untuk pengiriman dan notifikasi telah dikirim ke customer');
    }

    public function completeDelivery(Request $request, Order $order)
    {
        if ($order->assigned_kurir_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berwenang menyelesaikan pesanan ini');
        }

        $request->validate([
            'delivery_notes' => 'nullable|string|max:500',
            'delivery_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $photoPath = null;
        if ($request->hasFile('delivery_photo')) {
            $photoPath = $request->file('delivery_photo')->store('delivery-photos', 'public');
        }

        $oldStatus = $order->status;
        
        $order->update([
            'status' => 'completed',
            'delivery_photo' => $photoPath,
            'notes' => $order->notes . "\n\nCatatan Pengiriman: " . ($request->delivery_notes ?? 'Pesanan berhasil dikirim')
        ]);

        // Kirim notifikasi ke user
        $order->user->notify(new OrderStatusNotification($order, $oldStatus, 'completed'));

        return redirect()->back()->with('success', 'Pesanan berhasil diselesaikan dan notifikasi telah dikirim ke customer!');
    }
}