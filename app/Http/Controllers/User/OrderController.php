<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\DeliveryType;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.menu', 'deliveryType', 'deliveryArea'])
                      ->where('user_id', auth()->id())
                      ->latest()
                      ->paginate(10);
        return view('user.pages.orders.index', compact('orders'));
    }

    public function create()
    {
        $carts = Cart::with('menu')->where('user_id', auth()->id())->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang kosong');
        }

        $totalQuantity = $carts->sum('quantity');
        
        // Filter delivery types based on quantity
        $deliveryTypes = DeliveryType::where('is_active', true)
                                   ->where(function($query) use ($totalQuantity) {
                                       $query->where('min_quantity', '<=', $totalQuantity)
                                             ->where(function($q) use ($totalQuantity) {
                                                 $q->whereNull('max_quantity')
                                                   ->orWhere('max_quantity', '>=', $totalQuantity);
                                             });
                                   })
                                   ->get();
        
        $deliveryAreas = DeliveryArea::where('is_active', true)->get();
        
        // Get user addresses
        $addresses = auth()->user()->addresses()->get();
        $primaryAddress = $addresses->where('is_primary', true)->first();
        
        // Calculate minimum delivery date based on cutoff time
        $cutoffTime = \App\Models\Setting::get('order_cutoff_time', '15:00');
        $minDeliveryDays = (int) \App\Models\Setting::get('min_delivery_days', 1);
        
        $now = now('Asia/Jakarta');
        $cutoffDateTime = $now->copy()->setTimeFromTimeString($cutoffTime);
        
        // If current time is after cutoff, add extra day
        if ($now->gt($cutoffDateTime)) {
            $minDeliveryDays++;
        }
        
        $minDeliveryDate = $now->copy()->addDays($minDeliveryDays)->format('Y-m-d');
        
        return view('user.pages.orders.create', compact(
            'carts', 'deliveryTypes', 'deliveryAreas', 'totalQuantity', 
            'addresses', 'primaryAddress', 'minDeliveryDate'
        ));
    }

    public function store(Request $request)
    {
        // Calculate minimum delivery date
        $cutoffTime = \App\Models\Setting::get('order_cutoff_time', '15:00');
        $minDeliveryDays = (int) \App\Models\Setting::get('min_delivery_days', 1);
        
        $now = now('Asia/Jakarta');
        $cutoffDateTime = $now->copy()->setTimeFromTimeString($cutoffTime);
        
        if ($now->gt($cutoffDateTime)) {
            $minDeliveryDays++;
        }
        
        $minDeliveryDate = $now->copy()->addDays($minDeliveryDays)->format('Y-m-d');
        
        $request->validate([
            'delivery_type_id' => 'required|exists:delivery_types,id',
            'delivery_area_id' => 'required|exists:delivery_areas,id',
            'address_id' => 'required|exists:addresses,id',
            'delivery_address' => 'required|string',
            'delivery_date' => 'required|date|after_or_equal:' . $minDeliveryDate,
            'delivery_time' => 'required',
            'notes' => 'nullable|string'
        ], [
            'address_id.required' => 'Silakan pilih alamat pengiriman',
            'delivery_date.after_or_equal' => 'Tanggal pengiriman minimal ' . Carbon::parse($minDeliveryDate)->format('d/m/Y') . ' (H+' . $minDeliveryDays . ')'
        ]);

        $carts = Cart::with('menu')->where('user_id', auth()->id())->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang kosong');
        }

        $deliveryType = DeliveryType::findOrFail($request->delivery_type_id);
        $deliveryArea = DeliveryArea::findOrFail($request->delivery_area_id);
        
        $subtotal = $carts->sum('subtotal');
        $deliveryFee = $deliveryType->base_price + ($deliveryType->price_per_km * $deliveryArea->distance_km);

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
            'total_quantity' => $carts->sum('quantity'),
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total_amount' => $subtotal + $deliveryFee,
            'delivery_type_id' => $request->delivery_type_id,
            'delivery_area_id' => $request->delivery_area_id,
            'delivery_address' => $request->delivery_address,
            'delivery_date' => $request->delivery_date,
            'delivery_time' => $request->delivery_time,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $cart->menu_id,
                'quantity' => $cart->quantity,
                'price' => $cart->menu->price,
                'subtotal' => $cart->subtotal
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('user.orders.show', $order)->with('success', 'Pesanan berhasil dibuat');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load(['orderItems.menu', 'deliveryType', 'deliveryArea', 'payments']);
        return view('user.pages.orders.show', compact('order'));
    }

    public function cancel(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ], [
            'cancellation_reason.required' => 'Alasan pembatalan wajib diisi'
        ]);

        $order->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason
        ]);

        return redirect()->route('user.orders.show', $order)->with('success', 'Pesanan berhasil dibatalkan. Alasan: ' . $request->cancellation_reason);
    }
}