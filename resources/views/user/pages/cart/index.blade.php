@extends('user.main')

@section('title', 'Keranjang - CateringKu')

@section('content')
<!-- Hero Section -->
<section class="bg-brand-red text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Keranjang Belanja</h1>
            <p class="text-xl text-brand-light">Review pesanan Anda sebelum checkout</p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<nav class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="{{ route('beranda') }}" class="text-gray-500 hover:text-brand-red">Beranda</a></li>
            <li class="text-gray-400">/</li>
            <li><a href="{{ route('menu') }}" class="text-gray-500 hover:text-brand-red">Menu</a></li>
            <li class="text-gray-400">/</li>
            <li class="text-brand-red font-medium">Keranjang</li>
        </ol>
    </div>
</nav>

<!-- Cart Content -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($carts->isEmpty())
            <div class="text-center py-16">
                <div class="mb-8">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Keranjang Kosong</h3>
                <p class="text-gray-600 mb-8">Belum ada item di keranjang Anda</p>
                <a href="{{ route('menu') }}" class="bg-brand-red text-white px-8 py-3 rounded-lg hover:bg-brand-black transition duration-300">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-900">Item Pesanan ({{ $carts->count() }})</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($carts as $cart)
                            <div class="p-6 cart-item" data-cart-id="{{ $cart->id }}">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $cart->menu->image ? asset('storage/' . $cart->menu->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' }}" 
                                         alt="{{ $cart->menu->name }}" class="w-20 h-20 object-cover rounded-lg">
                                    
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $cart->menu->name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ Str::limit($cart->menu->description, 60) }}</p>
                                        <p class="text-brand-red font-bold mt-1">Rp {{ number_format($cart->menu->price, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <button class="quantity-btn minus-btn bg-gray-200 text-gray-700 w-8 h-8 rounded-full hover:bg-gray-300" data-action="minus">-</button>
                                        <span class="quantity-display font-semibold w-8 text-center">{{ $cart->quantity }}</span>
                                        <button class="quantity-btn plus-btn bg-gray-200 text-gray-700 w-8 h-8 rounded-full hover:bg-gray-300" data-action="plus">+</button>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900 subtotal">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</p>
                                        <button class="remove-btn text-red-500 hover:text-red-700 text-sm mt-1">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="px-6 py-4 border-t border-gray-200">
                            <button id="clearCart" class="text-red-500 hover:text-red-700 text-sm">Kosongkan Keranjang</button>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border sticky top-24">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-900">Ringkasan Pesanan</h2>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Item</span>
                                <span class="font-semibold total-items">{{ $carts->sum('quantity') }} porsi</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="border-t pt-4">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total</span>
                                    <span class="text-brand-red total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">*Belum termasuk ongkos kirim</p>
                            </div>
                            
                            <div class="pt-4">
                                @if($carts->sum('quantity') >= 10)
                                    <a href="{{ route('user.orders.create') }}" class="w-full bg-brand-red text-white py-3 px-4 rounded-lg hover:bg-brand-black transition duration-300 text-center block">
                                        Lanjut ke Checkout
                                    </a>
                                @else
                                    <div class="text-center">
                                        <p class="text-sm text-red-600 mb-2">Minimum order 10 porsi</p>
                                        <p class="text-sm text-gray-500 mb-4">Tambah {{ 10 - $carts->sum('quantity') }} porsi lagi</p>
                                        <a href="{{ route('menu') }}" class="w-full bg-gray-300 text-gray-700 py-3 px-4 rounded-lg text-center block">
                                            Tambah Menu
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update quantity
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const cartId = cartItem.dataset.cartId;
            const action = this.dataset.action;
            const quantityDisplay = cartItem.querySelector('.quantity-display');
            let quantity = parseInt(quantityDisplay.textContent);
            
            if (action === 'plus') {
                quantity++;
            } else if (action === 'minus' && quantity > 1) {
                quantity--;
            }
            
            updateCartQuantity(cartId, quantity, cartItem);
        });
    });
    
    // Remove item
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const cartId = cartItem.dataset.cartId;
            removeCartItem(cartId, cartItem);
        });
    });
    
    // Clear cart
    document.getElementById('clearCart')?.addEventListener('click', function() {
        if (confirm('Yakin ingin mengosongkan keranjang?')) {
            clearCart();
        }
    });
    
    function updateCartQuantity(cartId, quantity, cartItem) {
        fetch(`/user/cart/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cartItem.querySelector('.quantity-display').textContent = quantity;
                updateTotals();
            }
        });
    }
    
    function removeCartItem(cartId, cartItem) {
        fetch(`/user/cart/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cartItem.remove();
                updateTotals();
                if (document.querySelectorAll('.cart-item').length === 0) {
                    location.reload();
                }
            }
        });
    }
    
    function clearCart() {
        fetch('/user/cart', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(() => location.reload());
    }
    
    function updateTotals() {
        let totalItems = 0;
        let totalPrice = 0;
        
        document.querySelectorAll('.cart-item').forEach(item => {
            const quantity = parseInt(item.querySelector('.quantity-display').textContent);
            const price = parseInt(item.querySelector('.subtotal').textContent.replace(/[^\d]/g, ''));
            totalItems += quantity;
            totalPrice += price;
        });
        
        document.querySelector('.total-items').textContent = totalItems + ' porsi';
        document.querySelectorAll('.total-price').forEach(el => {
            el.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
        });
    }
});
</script>
@endpush