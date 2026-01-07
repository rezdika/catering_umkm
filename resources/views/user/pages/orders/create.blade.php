@extends('user.main')

@section('title', 'Checkout - CateringKu')

@section('content')
<!-- Hero Section -->
<section class="bg-brand-red text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Checkout</h1>
            <p class="text-xl text-brand-light">Lengkapi data pengiriman Anda</p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<nav class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="{{ route('beranda') }}" class="text-gray-500 hover:text-brand-red">Beranda</a></li>
            <li class="text-gray-400">/</li>
            <li><a href="{{ route('user.cart.index') }}" class="text-gray-500 hover:text-brand-red">Keranjang</a></li>
            <li class="text-gray-400">/</li>
            <li class="text-brand-red font-medium">Checkout</li>
        </ol>
    </div>
</nav>

<!-- Checkout Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('user.orders.store') }}">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Delivery Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Pengiriman</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pengiriman</label>
                                <select name="delivery_type_id" id="deliveryType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red" required>
                                    <option value="">Pilih jenis pengiriman</option>
                                    @foreach($deliveryTypes as $type)
                                    <option value="{{ $type->id }}" data-base-price="{{ $type->base_price }}" data-price-per-km="{{ $type->price_per_km }}">
                                        {{ $type->name }} ({{ $type->min_quantity }}{{ $type->max_quantity ? '-'.$type->max_quantity : '+' }} porsi)
                                    </option>
                                    @endforeach
                                </select>
                                @error('delivery_type_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Area Pengiriman</label>
                                <select name="delivery_area_id" id="deliveryArea" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red" required>
                                    <option value="">Pilih area pengiriman</option>
                                    @foreach($deliveryAreas as $area)
                                    <option value="{{ $area->id }}" data-distance="{{ $area->distance_km }}">
                                        {{ $area->area_name }} ({{ $area->distance_km }} km)
                                    </option>
                                    @endforeach
                                </select>
                                @error('delivery_area_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        @if($addresses->count() > 0)
                        <!-- Pilih Alamat Tersimpan -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                                <a href="{{ route('profile.addresses') }}" class="inline-flex items-center text-sm text-brand-red hover:text-brand-black">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Alamat Baru
                                </a>
                            </div>
                            <select name="address_id" id="addressSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red" required>
                                <option value="">Pilih alamat pengiriman</option>
                                @foreach($addresses as $address)
                                <option value="{{ $address->id }}" 
                                        data-full-address="{{ $address->address }}, {{ $address->city }} {{ $address->postal_code }}" 
                                        {{ $primaryAddress && $primaryAddress->id == $address->id ? 'selected' : '' }}>
                                    {{ $address->label }} - {{ $address->recipient_name }} ({{ $address->address }}, {{ $address->city }})
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="delivery_address" id="deliveryAddressHidden" value="{{ $primaryAddress ? $primaryAddress->address . ', ' . $primaryAddress->city . ' ' . $primaryAddress->postal_code : '' }}">
                            @error('address_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @else
                        <!-- Belum Ada Alamat -->
                        <div class="mt-6">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Alamat Tersimpan</h3>
                                <p class="text-gray-600 mb-4">Tambahkan alamat pengiriman terlebih dahulu untuk melanjutkan pesanan</p>
                                <a href="{{ route('profile.addresses') }}" class="inline-flex items-center bg-brand-red text-white px-4 py-2 rounded-lg hover:bg-brand-black transition duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Alamat
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengiriman</label>
                                <input type="date" name="delivery_date" id="deliveryDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red" min="{{ $minDeliveryDate }}" value="{{ old('delivery_date', $minDeliveryDate) }}" required>
                                <p class="text-sm text-gray-500 mt-1">
                                    Minimal pengiriman: {{ \Carbon\Carbon::parse($minDeliveryDate)->format('d/m/Y') }}<br>
                                    <span class="text-xs">Waktu sekarang: {{ now('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB</span>
                                </p>
                                @error('delivery_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Pengiriman</label>
                                <select name="delivery_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red" required>
                                    <option value="">Pilih waktu</option>
                                    <option value="08:00" {{ old('delivery_time') == '08:00' ? 'selected' : '' }}>08:00 - 10:00</option>
                                    <option value="10:00" {{ old('delivery_time') == '10:00' ? 'selected' : '' }}>10:00 - 12:00</option>
                                    <option value="12:00" {{ old('delivery_time') == '12:00' ? 'selected' : '' }}>12:00 - 14:00</option>
                                    <option value="14:00" {{ old('delivery_time') == '14:00' ? 'selected' : '' }}>14:00 - 16:00</option>
                                    <option value="16:00" {{ old('delivery_time') == '16:00' ? 'selected' : '' }}>16:00 - 18:00</option>
                                </select>
                                @error('delivery_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red" placeholder="Catatan khusus untuk pesanan...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm sticky top-24">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-900">Ringkasan Pesanan</h2>
                        </div>
                        
                        <div class="p-6">
                            <!-- Cart Items -->
                            <div class="space-y-3 mb-6">
                                @foreach($carts as $cart)
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $cart->menu->image ? asset('storage/' . $cart->menu->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=60&q=80' }}" 
                                         alt="{{ $cart->menu->name }}" class="w-12 h-12 object-cover rounded">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $cart->menu->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $cart->quantity }}x</p>
                                    </div>
                                    <span class="text-sm font-medium">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Totals -->
                            <div class="space-y-3 border-t pt-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total Item</span>
                                    <span>{{ $totalQuantity }} porsi</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span id="subtotal">Rp {{ number_format($carts->sum('subtotal'), 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ongkos Kirim</span>
                                    <span id="deliveryFee">Rp 0</span>
                                </div>
                                
                                <div class="flex justify-between text-lg font-bold border-t pt-3">
                                    <span>Total</span>
                                    <span class="text-brand-red" id="totalAmount">Rp {{ number_format($carts->sum('subtotal'), 0, ',', '.') }}</span>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full py-3 px-4 rounded-lg transition duration-300 mt-6 {{ $addresses->count() > 0 ? 'bg-brand-red text-white hover:bg-brand-black' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}" {{ $addresses->count() == 0 ? 'disabled' : '' }}>
                                {{ $addresses->count() > 0 ? 'Buat Pesanan' : 'Tambah Alamat Dulu' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryTypeSelect = document.getElementById('deliveryType');
    const deliveryAreaSelect = document.getElementById('deliveryArea');
    const addressSelect = document.getElementById('addressSelect');
    const deliveryAddressHidden = document.getElementById('deliveryAddressHidden');
    const subtotalAmount = {{ $carts->sum('subtotal') }};
    
    // Address selection functionality
    if (addressSelect && deliveryAddressHidden) {
        addressSelect.addEventListener('change', function() {
            const selectedOption = this.selectedOptions[0];
            if (selectedOption && selectedOption.dataset.fullAddress) {
                deliveryAddressHidden.value = selectedOption.dataset.fullAddress;
            } else {
                deliveryAddressHidden.value = '';
            }
        });
    }
    
    function calculateDeliveryFee() {
        const selectedType = deliveryTypeSelect.selectedOptions[0];
        const selectedArea = deliveryAreaSelect.selectedOptions[0];
        
        if (selectedType && selectedArea) {
            const basePrice = parseFloat(selectedType.dataset.basePrice);
            const pricePerKm = parseFloat(selectedType.dataset.pricePerKm);
            const distance = parseFloat(selectedArea.dataset.distance);
            
            const deliveryFee = basePrice + (pricePerKm * distance);
            const total = subtotalAmount + deliveryFee;
            
            document.getElementById('deliveryFee').textContent = 'Rp ' + deliveryFee.toLocaleString('id-ID');
            document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
        } else {
            document.getElementById('deliveryFee').textContent = 'Rp 0';
            document.getElementById('totalAmount').textContent = 'Rp ' + subtotalAmount.toLocaleString('id-ID');
        }
    }
    
    deliveryTypeSelect.addEventListener('change', calculateDeliveryFee);
    deliveryAreaSelect.addEventListener('change', calculateDeliveryFee);
});
</script>
@endpush