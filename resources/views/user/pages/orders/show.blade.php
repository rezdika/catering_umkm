@extends('user.main')

@section('title', 'Detail Pesanan - CateringKu')

@section('content')
<!-- Hero Section -->
<section class="bg-brand-red text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Detail Pesanan</h1>
            <p class="text-xl text-brand-light">{{ $order->order_number }}</p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<nav class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="{{ route('beranda') }}" class="text-gray-500 hover:text-brand-red">Beranda</a></li>
            <li class="text-gray-400">/</li>
            <li><a href="{{ route('profile.orders') }}" class="text-gray-500 hover:text-brand-red">Pesanan</a></li>
            <li class="text-gray-400">/</li>
            <li class="text-brand-red font-medium">{{ $order->order_number }}</li>
        </ol>
    </div>
</nav>

<!-- Order Details -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Order Info -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Status Tracking -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Status Pesanan</h2>
                    
                    <div class="relative">
                        @php
                        $statuses = [
                            'pending' => ['label' => 'Menunggu Pembayaran', 'icon' => 'clock'],
                            'payment_verified' => ['label' => 'Pembayaran Terverifikasi', 'icon' => 'check-circle'],
                            'preparing' => ['label' => 'Sedang Dipersiapkan', 'icon' => 'cog'],
                            'ready' => ['label' => 'Siap Dikirim', 'icon' => 'check'],
                            'on_delivery' => ['label' => 'Dalam Pengiriman', 'icon' => 'truck'],
                            'delivered' => ['label' => 'Terkirim', 'icon' => 'check-circle'],
                            'completed' => ['label' => 'Selesai', 'icon' => 'check-circle'],
                            'cancelled' => ['label' => 'Dibatalkan', 'icon' => 'x-circle']
                        ];
                        
                        $currentStatusIndex = array_search($order->status, array_keys($statuses));
                        @endphp
                        
                        <div class="flex items-center justify-between mb-4">
                            @foreach($statuses as $key => $status)
                                @if($key !== 'cancelled')
                                    @php $isActive = array_search($key, array_keys($statuses)) <= $currentStatusIndex && $order->status !== 'cancelled'; @endphp
                                    <div class="flex flex-col items-center {{ $isActive ? 'text-brand-red' : 'text-gray-400' }}">
                                        <div class="w-10 h-10 rounded-full border-2 {{ $isActive ? 'border-brand-red bg-brand-red text-white' : 'border-gray-300' }} flex items-center justify-center mb-2">
                                            @if($status['icon'] === 'clock')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @elseif($status['icon'] === 'check-circle')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @elseif($status['icon'] === 'cog')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            @elseif($status['icon'] === 'truck')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-xs text-center">{{ $status['label'] }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        @if($order->status === 'cancelled')
                            <div class="text-center py-4">
                                <div class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full mb-3">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pesanan Dibatalkan
                                </div>
                                @if($order->cancellation_reason)
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 max-w-md mx-auto">
                                        <p class="text-sm text-red-800"><strong>Alasan:</strong> {{ $order->cancellation_reason }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Item Pesanan</h2>
                    
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                        <div class="flex items-center space-x-4 py-4 border-b border-gray-200 last:border-b-0">
                            <img src="{{ $item->menu->image ? asset('storage/' . $item->menu->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=80&q=80' }}" 
                                 alt="{{ $item->menu->name }}" class="w-16 h-16 object-cover rounded-lg">
                            
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $item->menu->name }}</h3>
                                <p class="text-gray-600">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="text-right">
                                <span class="text-lg font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Payment Section -->
                @if($order->status === 'pending' && $order->payments->isEmpty())
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Pembayaran</h2>
                    
                        <div class="space-y-6">
                            <!-- Payment Methods -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Metode Pembayaran</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <!-- Bank Transfer -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-brand-red cursor-pointer payment-method" data-method="bank_transfer">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Transfer Bank</h4>
                                                    <p class="text-sm text-gray-600">BCA, BNI, BRI, Mandiri</p>
                                                </div>
                                            </div>
                                            <input type="radio" name="payment_method" value="bank_transfer" class="text-brand-red">
                                        </div>
                                    </div>
                                    
                                    <!-- QRIS -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-brand-red cursor-pointer payment-method" data-method="qris">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">QRIS</h4>
                                                    <p class="text-sm text-gray-600">GoPay, OVO, DANA, ShopeePay</p>
                                                </div>
                                            </div>
                                            <input type="radio" name="payment_method" value="qris" class="text-brand-red">
                                        </div>
                                    </div>
                                    
                                    <!-- COD -->
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-brand-red cursor-pointer payment-method" data-method="cod">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">Cash on Delivery (COD)</h4>
                                                    <p class="text-sm text-gray-600">Bayar saat barang diterima</p>
                                                </div>
                                            </div>
                                            <input type="radio" name="payment_method" value="cod" class="text-brand-red">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button id="continuePayment" class="w-full bg-gray-300 text-gray-500 py-3 px-4 rounded-lg cursor-not-allowed" disabled>
                                Pilih Metode Pembayaran
                            </button>
                        </div>
                </div>
                @endif
                
                <!-- Payment Status -->
                @if($order->payments->isNotEmpty())
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Status Pembayaran</h2>
                    
                    @php $payment = $order->payments->first(); @endphp
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-900">Metode Pembayaran</h3>
                                <p class="text-sm text-gray-600">
                                    @switch($payment->payment_method)
                                        @case('bank_transfer')
                                            Transfer Bank
                                            @break
                                        @case('qris')
                                            QRIS
                                            @break
                                        @case('cod')
                                            Cash on Delivery
                                            @break
                                    @endswitch
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $payment->status === 'verified' ? 'bg-green-100 text-green-800' : 
                                       ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    @switch($payment->status)
                                        @case('verified')
                                            Terkonfirmasi
                                            @break
                                        @case('pending')
                                            Menunggu Verifikasi
                                            @break
                                        @default
                                            Ditolak
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        
                        @if($payment->sender_name)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Pengirim:</span>
                            <span class="font-medium">{{ $payment->sender_name }}</span>
                        </div>
                        @endif
                        
                        @if($payment->payment_proof)
                        <div>
                            <span class="text-gray-600 block mb-2">Bukti Pembayaran:</span>
                            <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-xs rounded-lg border">
                        </div>
                        @endif
                        
                        @if($payment->notes)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <p class="text-sm text-blue-800">{{ $payment->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm sticky top-24">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Ringkasan</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Informasi Pesanan</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">No. Pesanan</span>
                                    <span class="font-medium">{{ $order->order_number }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal</span>
                                    <span class="font-medium">{{ $order->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status</span>
                                    <span class="font-medium capitalize">{{ str_replace('_', ' ', $order->status) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-gray-900 mb-2">Pengiriman</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jenis</span>
                                    <span class="font-medium">{{ $order->deliveryType->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Area</span>
                                    <span class="font-medium">{{ $order->deliveryArea->area_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Waktu</span>
                                    <span class="font-medium">{{ $order->delivery_time }}</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="text-gray-600 text-sm">Alamat:</span>
                                <p class="text-sm font-medium mt-1">{{ $order->delivery_address }}</p>
                            </div>
                        </div>
                        
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-gray-900 mb-2">Total Pembayaran</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ongkos Kirim</span>
                                    <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t pt-2">
                                    <span>Total</span>
                                    <span class="text-brand-red">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($order->notes)
                        <div class="border-t pt-4">
                            <h3 class="font-semibold text-gray-900 mb-2">Catatan</h3>
                            <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                        </div>
                        @endif
                        
                        @if($order->status === 'pending')
                        <div class="border-t pt-4">
                            <button onclick="showCancelModal()" class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 text-sm">
                                Batalkan Pesanan
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-lg w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold" id="modalTitle">Pembayaran</h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Bank Transfer Info -->
            <div id="bankInfo" class="mb-6 hidden">
                <h4 class="font-semibold mb-3">Transfer ke Rekening:</h4>
                <div class="grid grid-cols-1 gap-3">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="flex items-center mb-1">
                            <span class="font-semibold text-blue-800">BCA</span>
                        </div>
                        <p class="text-sm font-mono">{{ \App\Models\Setting::get('bank_account_bca', '1234567890') }}</p>
                        <p class="text-sm font-medium">{{ \App\Models\Setting::get('bank_account_bca_name', 'D\'Yummy Catering') }}</p>
                    </div>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                        <div class="flex items-center mb-1">
                            <span class="font-semibold text-orange-800">BNI</span>
                        </div>
                        <p class="text-sm font-mono">{{ \App\Models\Setting::get('bank_account_bni', '0987654321') }}</p>
                        <p class="text-sm font-medium">{{ \App\Models\Setting::get('bank_account_bni_name', 'D\'Yummy Catering') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- QRIS Info -->
            <div id="qrisInfo" class="mb-6 hidden">
                <h4 class="font-semibold mb-3">Scan QRIS:</h4>
                <div class="text-center bg-gray-50 rounded-lg p-6">
                    <div class="w-32 h-32 bg-white border-2 border-dashed border-gray-300 rounded-lg mx-auto flex items-center justify-center mb-3">
                        <span class="text-gray-500 text-sm">QR Code</span>
                    </div>
                    <p class="text-sm text-gray-600">Scan dengan aplikasi e-wallet Anda</p>
                </div>
            </div>
            
            <!-- COD Info -->
            <div id="codInfo" class="mb-6 hidden">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="font-semibold text-yellow-800 mb-2">Cash on Delivery</h4>
                    <p class="text-sm text-yellow-700">Pembayaran akan dilakukan saat barang diterima. Pastikan menyiapkan uang pas sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                </div>
            </div>
            
            <form action="{{ route('user.payment.store', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_method" id="selectedMethod">
                
                <div class="space-y-4">
                    <div id="uploadSection">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengirim/Payer</label>
                            <input type="text" name="sender_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red" placeholder="Nama sesuai akun pembayaran">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</label>
                            <input type="file" name="payment_proof" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                            <p class="text-sm text-gray-500 mt-1">Upload screenshot/foto bukti pembayaran (JPG, PNG - Max: 2MB)</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex space-x-3 mt-6">
                    <button type="button" onclick="closePaymentModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-brand-red text-white rounded-lg hover:bg-brand-black">
                        Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-red-600">Batalkan Pesanan</h3>
                <button onclick="closeCancelModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-red-800 font-medium">Peringatan!</span>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">Apakah Anda yakin ingin membatalkan pesanan <strong>{{ $order->order_number }}</strong>?</p>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Pembatalan *</label>
                    <select name="cancellation_reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        <option value="">Pilih alasan pembatalan</option>
                        <option value="Harga terlalu mahal">Harga terlalu mahal</option>
                        <option value="Produk tidak sesuai ekspektasi">Produk tidak sesuai ekspektasi</option>
                        <option value="Berubah pikiran">Berubah pikiran</option>
                        <option value="Menemukan alternatif yang lebih baik">Menemukan alternatif yang lebih baik</option>
                        <option value="Masalah jadwal pengiriman">Masalah jadwal pengiriman</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                
                <div id="customReasonDiv" class="mb-4 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Lainnya</label>
                    <textarea id="customReason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="Jelaskan alasan pembatalan..."></textarea>
                </div>
                
                <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            
            <div class="flex space-x-3">
                <button onclick="closeCancelModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form action="{{ route('user.orders.cancel', $order) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="cancellation_reason" id="hiddenReason">
                    <button type="submit" id="cancelSubmitBtn" class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed" disabled>
                        Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedPaymentMethod = null;

document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection
    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function() {
            const methodValue = this.dataset.method;
            const radio = this.querySelector('input[type="radio"]');
            
            // Clear previous selections
            document.querySelectorAll('.payment-method').forEach(m => {
                m.classList.remove('border-brand-red', 'bg-red-50');
                m.querySelector('input[type="radio"]').checked = false;
            });
            
            // Select current method
            this.classList.add('border-brand-red', 'bg-red-50');
            radio.checked = true;
            selectedPaymentMethod = methodValue;
            
            // Enable continue button
            const continueBtn = document.getElementById('continuePayment');
            continueBtn.disabled = false;
            continueBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            continueBtn.classList.add('bg-brand-red', 'text-white', 'hover:bg-brand-black', 'cursor-pointer');
            continueBtn.textContent = 'Lanjutkan Pembayaran';
        });
    });
    
    // Continue payment button
    document.getElementById('continuePayment').addEventListener('click', function() {
        if (selectedPaymentMethod) {
            showPaymentModal(selectedPaymentMethod);
        }
    });
});

function showPaymentModal(method) {
    const modal = document.getElementById('paymentModal');
    const modalTitle = document.getElementById('modalTitle');
    const selectedMethodInput = document.getElementById('selectedMethod');
    const bankInfo = document.getElementById('bankInfo');
    const qrisInfo = document.getElementById('qrisInfo');
    const codInfo = document.getElementById('codInfo');
    const uploadSection = document.getElementById('uploadSection');
    
    // Reset visibility
    bankInfo.classList.add('hidden');
    qrisInfo.classList.add('hidden');
    codInfo.classList.add('hidden');
    
    // Set method
    selectedMethodInput.value = method;
    
    // Show appropriate content
    switch(method) {
        case 'bank_transfer':
            modalTitle.textContent = 'Transfer Bank';
            bankInfo.classList.remove('hidden');
            uploadSection.style.display = 'block';
            break;
        case 'qris':
            modalTitle.textContent = 'Pembayaran QRIS';
            qrisInfo.classList.remove('hidden');
            uploadSection.style.display = 'block';
            break;
        case 'cod':
            modalTitle.textContent = 'Cash on Delivery';
            codInfo.classList.remove('hidden');
            uploadSection.style.display = 'none';
            break;
    }
    
    modal.classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

function showCancelModal() {
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    // Reset form
    document.querySelector('select[name="cancellation_reason"]').value = '';
    document.getElementById('customReasonDiv').classList.add('hidden');
    document.getElementById('customReason').value = '';
    // Reset button
    const submitBtn = document.getElementById('cancelSubmitBtn');
    submitBtn.disabled = true;
    submitBtn.className = 'w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed';
}

// Handle custom reason visibility and button state
document.addEventListener('DOMContentLoaded', function() {
    const reasonSelect = document.querySelector('select[name="cancellation_reason"]');
    const customReasonDiv = document.getElementById('customReasonDiv');
    const customReasonTextarea = document.getElementById('customReason');
    const submitBtn = document.getElementById('cancelSubmitBtn');
    
    function checkFormValidity() {
        const reasonValue = reasonSelect.value;
        const customValue = customReasonTextarea.value.trim();
        
        let isValid = false;
        if (reasonValue && reasonValue !== 'Lainnya') {
            isValid = true;
        } else if (reasonValue === 'Lainnya' && customValue) {
            isValid = true;
        }
        
        if (isValid) {
            submitBtn.disabled = false;
            submitBtn.className = 'w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600';
        } else {
            submitBtn.disabled = true;
            submitBtn.className = 'w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed';
        }
    }
    
    if (reasonSelect) {
        reasonSelect.addEventListener('change', function() {
            if (this.value === 'Lainnya') {
                customReasonDiv.classList.remove('hidden');
                customReasonTextarea.required = true;
            } else {
                customReasonDiv.classList.add('hidden');
                customReasonTextarea.required = false;
                customReasonTextarea.value = '';
            }
            checkFormValidity();
        });
    }
    
    if (customReasonTextarea) {
        customReasonTextarea.addEventListener('input', checkFormValidity);
    }
    
    // Handle form submission with loading state
    const cancelForm = document.querySelector('form[action*="cancel"]');
    if (cancelForm) {
        cancelForm.addEventListener('submit', function(e) {
            const reasonSelect = document.querySelector('select[name="cancellation_reason"]');
            const customReason = document.getElementById('customReason');
            const hiddenReason = document.getElementById('hiddenReason');
            
            if (reasonSelect.value === 'Lainnya' && !customReason.value.trim()) {
                e.preventDefault();
                return;
            }
            
            // Set final reason value to hidden input
            if (reasonSelect.value === 'Lainnya') {
                hiddenReason.value = customReason.value.trim();
            } else {
                hiddenReason.value = reasonSelect.value;
            }
            
            // Show loading state
            submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Membatalkan...';
            submitBtn.disabled = true;
        });
    }
});
</script>
@endpush