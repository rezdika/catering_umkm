@extends('user.main')

@section('title', 'Pesanan Saya - CateringKu')

@section('content')
<!-- Hero Section -->
<section class="bg-brand-red text-white py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Pesanan Saya</h1>
            <p class="text-xl text-brand-light">Riwayat dan status pesanan Anda</p>
        </div>
    </div>
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-20 h-20 border-2 border-white rounded-full"></div>
        <div class="absolute top-32 right-20 w-16 h-16 border-2 border-white rounded-full"></div>
        <div class="absolute bottom-20 left-1/4 w-12 h-12 border-2 border-white rounded-full"></div>
    </div>
</section>

<!-- Breadcrumb -->
<nav class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('beranda') }}" class="text-gray-500 hover:text-brand-red">Beranda</a>
            </li>
            <li class="text-gray-400">/</li>
            <li>
                <a href="{{ route('profile.index') }}" class="text-gray-500 hover:text-brand-red">Profile</a>
            </li>
            <li class="text-gray-400">/</li>
            <li class="text-brand-red font-medium">Pesanan Saya</li>
        </ol>
    </div>
</nav>

<!-- Orders Content -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <!-- Profile Avatar -->
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-brand-red rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ ucfirst($user->role) }}</p>
                    </div>
                    
                    <!-- Navigation Menu -->
                    <nav class="space-y-2">
                        <a href="{{ route('profile.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Profile
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                        <a href="{{ route('profile.orders') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-brand-red rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Pesanan Saya
                        </a>
                        <a href="{{ route('profile.addresses') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat
                        </a>
                        <a href="{{ route('profile.settings') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pengaturan
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm border">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Riwayat Pesanan</h2>
                        <p class="text-gray-600 text-sm">Daftar semua pesanan yang pernah Anda buat</p>
                    </div>
                    
                    <div class="p-6">
                        @if(isset($orders) && $orders->count() > 0)
                            <div class="space-y-6">
                                @foreach($orders as $order)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 class="font-bold text-lg text-gray-900">Order #{{ $order->id }}</h3>
                                                <p class="text-gray-600 text-sm">{{ $order->created_at->format('d F Y, H:i') }}</p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800
                                                @elseif($order->status == 'preparing') bg-orange-100 text-orange-800
                                                @elseif($order->status == 'ready') bg-purple-100 text-purple-800
                                                @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        
                                        @if($order->orderItems)
                                            <div class="space-y-2 mb-4">
                                                @foreach($order->orderItems as $item)
                                                    <div class="flex justify-between items-center">
                                                        <div class="flex items-center">
                                                            <span class="text-gray-900">{{ $item->menu->name ?? 'Menu tidak tersedia' }}</span>
                                                            <span class="text-gray-500 ml-2">x{{ $item->quantity }}</span>
                                                        </div>
                                                        <span class="text-gray-900 font-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <div class="border-t pt-4 flex justify-between items-center">
                                            <div class="text-sm text-gray-600">
                                                <p>Alamat: {{ $order->delivery_address }}</p>
                                                <p>Tanggal Kirim: {{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-gray-900 mb-2">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('user.orders.show', $order) }}" class="bg-brand-red text-white px-3 py-1 rounded text-sm hover:bg-brand-black transition duration-300">
                                                        Detail
                                                    </a>
                                                    @if($order->status === 'pending')
                                                        <button onclick="showCancelModal({{ $order->id }}, '{{ $order->order_number }}')" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition duration-300">
                                                            Batalkan
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pesanan</h3>
                                <p class="text-gray-600 mb-6">Anda belum pernah melakukan pesanan. Mulai pesan sekarang!</p>
                                <a href="{{ route('menu') }}" class="bg-brand-red text-white px-6 py-3 rounded-lg font-medium hover:bg-brand-black transition duration-300">
                                    Lihat Menu
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                <p class="text-gray-600 mb-4">Apakah Anda yakin ingin membatalkan pesanan <strong id="orderNumber"></strong>?</p>
                
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
                <p class="text-sm text-gray-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            
            <div class="flex space-x-3">
                <button onclick="closeCancelModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <form id="cancelForm" method="POST" class="flex-1">
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
let currentOrderId = null;

function showCancelModal(orderId, orderNumber) {
    currentOrderId = orderId;
    document.getElementById('orderNumber').textContent = orderNumber;
    document.getElementById('cancelForm').action = `/user/orders/${orderId}/cancel`;
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    currentOrderId = null;
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
    const cancelForm = document.querySelector('#cancelForm');
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