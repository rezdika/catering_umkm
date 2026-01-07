<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('menu')->where('user_id', auth()->id())->get();
        $total = $carts->sum('subtotal');
        return view('user.pages.cart.index', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        try {
            if (!auth()->check()) {
                \Log::warning('Unauthenticated cart store attempt');
                return response()->json(['error' => 'Silakan login terlebih dahulu'], 401);
            }
            
            \Log::info('Cart store request:', $request->all());
            
            $request->validate([
                'menu_id' => 'required|exists:menus,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $menu = Menu::findOrFail($request->menu_id);
            
            if (!$menu->is_active) {
                \Log::warning('Menu not active:', ['menu_id' => $request->menu_id]);
                return response()->json(['error' => 'Menu tidak tersedia'], 400);
            }
            
            if ($menu->stock < $request->quantity) {
                \Log::warning('Insufficient stock:', ['menu_id' => $request->menu_id, 'requested' => $request->quantity, 'available' => $menu->stock]);
                return response()->json(['error' => 'Stok tidak mencukupi'], 400);
            }

            $cart = Cart::where('user_id', auth()->id())
                       ->where('menu_id', $request->menu_id)
                       ->first();

            if ($cart) {
                $newQuantity = $cart->quantity + $request->quantity;
                if ($newQuantity > $menu->stock) {
                    return response()->json(['error' => 'Total quantity melebihi stok yang tersedia'], 400);
                }
                $cart->update(['quantity' => $newQuantity]);
                \Log::info('Cart updated:', ['cart_id' => $cart->id, 'new_quantity' => $newQuantity]);
            } else {
                $cart = Cart::create([
                    'user_id' => auth()->id(),
                    'menu_id' => $request->menu_id,
                    'quantity' => $request->quantity
                ]);
                \Log::info('Cart created:', ['cart_id' => $cart->id]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Cart store error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan sistem'], 500);
        }
    }

    public function getCount()
    {
        $count = Cart::where('user_id', auth()->id())->sum('quantity');
        return response()->json(['count' => $count]);
    }
    
    public function update(Request $request, Cart $cart)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cart->update(['quantity' => $request->quantity]);
        return response()->json(['success' => 'Keranjang diupdate']);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(['success' => 'Item dihapus dari keranjang']);
    }

    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();
        return redirect()->back()->with('success', 'Keranjang dikosongkan');
    }
}