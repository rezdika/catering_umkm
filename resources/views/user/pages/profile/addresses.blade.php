@extends('user.main')

@section('title', 'Alamat - CateringKu')

@section('content')
<!-- Hero Section -->
<section class="bg-brand-red text-white py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Alamat Pengiriman</h1>
            <p class="text-xl text-brand-light">Kelola alamat pengiriman Anda</p>
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
            <li class="text-brand-red font-medium">Alamat</li>
        </ol>
    </div>
</nav>

<!-- Addresses Content -->
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
                        <a href="{{ route('profile.orders') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Pesanan Saya
                        </a>
                        <a href="{{ route('profile.addresses') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-brand-red rounded-md">
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
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Alamat Pengiriman</h2>
                            <p class="text-gray-600 text-sm">Kelola alamat untuk pengiriman pesanan</p>
                        </div>
                        <button onclick="showAddForm()" class="bg-brand-red text-white px-4 py-2 rounded-lg font-medium hover:bg-brand-black transition duration-300">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Alamat
                        </button>
                    </div>
                    
                    <div class="p-6">
                        @if(session('success'))
                            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($addresses->count() > 0)
                            <div class="space-y-4">
                                @foreach($addresses as $address)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center mb-2">
                                                    <h3 class="font-bold text-gray-900 mr-2">{{ $address->label }}</h3>
                                                    @if($address->is_primary)
                                                        <span class="bg-brand-red text-white text-xs px-2 py-1 rounded-full">Utama</span>
                                                    @endif
                                                </div>
                                                <p class="text-gray-900 font-medium">{{ $address->recipient_name }}</p>
                                                <p class="text-gray-600">{{ $address->phone }}</p>
                                                <p class="text-gray-600 mt-2">{{ $address->address }}, {{ $address->city }} {{ $address->postal_code }}</p>
                                                @if($address->notes)
                                                    <p class="text-gray-500 text-sm mt-1">{{ $address->notes }}</p>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2 ml-4">
                                                <button onclick="editAddress({{ $address->id }})" class="text-brand-red hover:text-brand-black">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <form method="POST" action="{{ route('profile.addresses.delete', $address->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus alamat ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Alamat</h3>
                                <p class="text-gray-600 mb-6">Tambahkan alamat pengiriman untuk memudahkan proses pemesanan</p>
                                <button onclick="showAddForm()" class="bg-brand-red text-white px-6 py-3 rounded-lg font-medium hover:bg-brand-black transition duration-300">
                                    Tambah Alamat Pertama
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Add/Edit Address Modal -->
                <div id="addressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 id="modalTitle" class="text-lg font-bold text-gray-900">Tambah Alamat</h3>
                            </div>
                            
                            <form id="addressForm" method="POST" action="{{ route('profile.addresses.store') }}" class="p-6">
                                @csrf
                                <div id="methodField"></div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                                        <select name="label" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                            <option value="Rumah">Rumah</option>
                                            <option value="Kantor">Kantor</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                                        <input type="text" name="recipient_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                        <input type="text" name="phone" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                        <textarea name="address" required rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red"></textarea>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                                            <input type="text" name="city" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                            <input type="text" name="postal_code" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                                        <input type="text" name="notes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_primary" value="1" class="h-4 w-4 text-brand-red focus:ring-brand-red border-gray-300 rounded">
                                        <label class="ml-2 text-sm text-gray-700">Jadikan alamat utama</label>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-brand-red text-white rounded-lg hover:bg-brand-black">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
             
</section>
@endsection

@push('scripts')
<script>
function showAddForm() {
    document.getElementById('modalTitle').textContent = 'Tambah Alamat';
    document.getElementById('addressForm').action = '{{ route("profile.addresses.store") }}';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('addressForm').reset();
    document.getElementById('addressModal').classList.remove('hidden');
}

function editAddress(id) {
    // This would need AJAX to fetch address data
    document.getElementById('modalTitle').textContent = 'Edit Alamat';
    document.getElementById('addressForm').action = `/profile/addresses/${id}`;
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    document.getElementById('addressModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('addressModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('addressModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush