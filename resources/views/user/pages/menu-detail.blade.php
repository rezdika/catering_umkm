@extends('user.main')

@section('title', $menu->name . ' - CateringKu')

@section('content')
<!-- Breadcrumb -->
<nav class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="{{ route('beranda') }}" class="text-gray-500 hover:text-brand-red">Beranda</a></li>
            <li class="text-gray-400">/</li>
            <li><a href="{{ route('menu') }}" class="text-gray-500 hover:text-brand-red">Menu</a></li>
            <li class="text-gray-400">/</li>
            <li><a href="#" class="text-gray-500 hover:text-brand-red">{{ $menu->category->name }}</a></li>
            <li class="text-gray-400">/</li>
            <li class="text-brand-red font-medium">{{ $menu->name }}</li>
        </ol>
    </div>
</nav>

<!-- Product Detail -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Product Image -->
            <div class="lg:col-span-1">
                <div class="aspect-square w-full">
                    <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
                         alt="{{ $menu->name }}" 
                         class="w-full h-full object-cover">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    
                    <!-- Category Badge -->
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-brand-red bg-opacity-10 text-brand-red">
                            {{ $menu->category->name }}
                        </span>
                    </div>
                    
                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $menu->name }}</h1>
                    
                    <!-- Tags -->
                    @if($menu->tags)
                        <div class="flex flex-wrap gap-2 mb-6">
                            @php
                                $tagColors = [
                                    'hot' => 'bg-red-100 text-red-800',
                                    'bestseller' => 'bg-green-100 text-green-800', 
                                    'baru' => 'bg-blue-100 text-blue-800',
                                    'promo' => 'bg-orange-100 text-orange-800',
                                    'sale' => 'bg-purple-100 text-purple-800',
                                    'favorit' => 'bg-pink-100 text-pink-800',
                                    'rekomendasi' => 'bg-yellow-100 text-yellow-800',
                                    'halal' => 'bg-emerald-100 text-emerald-800'
                                ];
                                $tags = is_array($menu->tags) ? $menu->tags : explode(',', $menu->tags);
                            @endphp
                            @foreach($tags as $tag)
                                @php $tagColor = $tagColors[trim($tag)] ?? 'bg-gray-100 text-gray-800'; @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $tagColor }}">
                                    {{ ucfirst(trim($tag)) }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-brand-red">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <span class="text-gray-500 ml-2">per porsi</span>
                    </div>
                    
                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if($menu->stock > 0)
                            <div class="flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">Tersedia ({{ $menu->stock }} porsi)</span>
                            </div>
                        @else
                            <div class="flex items-center text-red-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">Stok Habis</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $menu->description }}</p>
                    </div>
                    
                    <!-- Add to Cart Form -->
                    @auth
                        @if($menu->stock > 0)
                            <form id="addToCartForm" class="space-y-6">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                
                                <!-- Quantity Selector -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Porsi</label>
                                    <div class="flex items-center space-x-3">
                                        <button type="button" id="decreaseQty" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $menu->stock }}" 
                                               class="w-20 text-center border border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                        <button type="button" id="increaseQty" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Total Price -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Total Harga:</span>
                                        <span id="totalPrice" class="text-2xl font-bold text-brand-red">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Add to Cart Button -->
                                <button type="submit" id="addToCartBtn" class="w-full bg-brand-red text-white py-4 px-6 rounded-lg text-lg font-semibold hover:bg-brand-black transition duration-300 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <div class="bg-gray-100 rounded-lg p-6 text-center">
                                <p class="text-gray-600 mb-4">Maaf, menu ini sedang tidak tersedia</p>
                                <a href="{{ route('menu') }}" class="inline-flex items-center text-brand-red hover:text-brand-black">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Lihat Menu Lainnya
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-100 rounded-lg p-6 text-center">
                            <p class="text-gray-600 mb-4">Silakan login untuk menambahkan ke keranjang</p>
                            <a href="{{ route('login') }}" class="bg-brand-red text-white py-3 px-6 rounded-lg hover:bg-brand-black transition duration-300">
                                Login Sekarang
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedMenus->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Menu Serupa</h2>
            <p class="text-gray-600">Produk lain dari kategori {{ $menu->category->name }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedMenus as $relatedMenu)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition duration-300 group">
                <div class="relative">
                    <img src="{{ $relatedMenu->image ? asset('storage/' . $relatedMenu->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                         alt="{{ $relatedMenu->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                    @if($relatedMenu->tags)
                        @php
                            $tags = is_array($relatedMenu->tags) ? $relatedMenu->tags : explode(',', $relatedMenu->tags);
                            $firstTag = $tags[0] ?? '';
                            $tagColors = [
                                'hot' => 'bg-brand-red',
                                'bestseller' => 'bg-green-500', 
                                'baru' => 'bg-blue-500',
                                'promo' => 'bg-orange-500',
                                'sale' => 'bg-red-500'
                            ];
                            $tagColor = $tagColors[trim($firstTag)] ?? 'bg-gray-500';
                        @endphp
                        <div class="absolute top-3 left-3">
                            <span class="{{ $tagColor }} text-white text-xs px-2 py-1 rounded-full">{{ ucfirst(trim($firstTag)) }}</span>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $relatedMenu->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($relatedMenu->description, 60) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold text-brand-red">Rp {{ number_format($relatedMenu->price, 0, ',', '.') }}</span>
                        <a href="{{ route('menu.show', $relatedMenu->slug) }}" class="bg-brand-red text-white px-4 py-2 rounded-lg hover:bg-brand-black transition duration-300 text-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');
    const totalPriceEl = document.getElementById('totalPrice');
    const addToCartForm = document.getElementById('addToCartForm');
    const addToCartBtn = document.getElementById('addToCartBtn');
    
    const basePrice = {{ $menu->price }};
    const maxStock = {{ $menu->stock }};
    
    // Quantity controls
    if (decreaseBtn && increaseBtn && quantityInput) {
        decreaseBtn.addEventListener('click', function() {
            let qty = parseInt(quantityInput.value);
            if (qty > 1) {
                quantityInput.value = qty - 1;
                updateTotalPrice();
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            let qty = parseInt(quantityInput.value);
            if (qty < maxStock) {
                quantityInput.value = qty + 1;
                updateTotalPrice();
            }
        });
        
        quantityInput.addEventListener('input', function() {
            let qty = parseInt(this.value);
            if (qty < 1) this.value = 1;
            if (qty > maxStock) this.value = maxStock;
            updateTotalPrice();
        });
    }
    
    function updateTotalPrice() {
        const qty = parseInt(quantityInput.value);
        const total = basePrice * qty;
        totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    // Add to cart
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const originalText = addToCartBtn.textContent;
            
            // Show loading state
            addToCartBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menambahkan...';
            addToCartBtn.disabled = true;
            
            fetch('/user/cart', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    menu_id: parseInt(formData.get('menu_id')),
                    quantity: parseInt(formData.get('quantity'))
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success || data.message) {
                    showNotification('{{ $menu->name }} berhasil ditambahkan ke keranjang!', 'success');
                    // Update cart counter in header if exists
                    updateCartCounter();
                } else {
                    showNotification(data.error || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.error) {
                    showNotification(error.error, 'error');
                } else if (error.message) {
                    showNotification(error.message, 'error');
                } else {
                    showNotification('Terjadi kesalahan saat menambahkan ke keranjang', 'error');
                }
            })
            .finally(() => {
                // Reset button
                addToCartBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path></svg>Tambah ke Keranjang';
                addToCartBtn.disabled = false;
            });
        });
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white transform translate-x-full transition-transform duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    function updateCartCounter() {
        // Update cart counter in header
        fetch('/user/cart/count', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update cart counter badge in header
            const cartBadge = document.getElementById('cart-counter');
            if (cartBadge) {
                if (data.count > 0) {
                    cartBadge.textContent = data.count;
                    cartBadge.classList.remove('hidden');
                } else {
                    cartBadge.classList.add('hidden');
                }
            }
        })
        .catch(error => {
            console.log('Could not update cart counter:', error);
        });
    }
});
</script>
@endpush