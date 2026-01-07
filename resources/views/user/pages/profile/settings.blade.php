@extends('user.main')

@section('title', 'Pengaturan - CateringKu')

@section('content')
<!-- Hero Section -->
<section class="bg-brand-red text-white py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Pengaturan</h1>
            <p class="text-xl text-brand-light">Kelola preferensi dan pengaturan akun Anda</p>
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
            <li class="text-brand-red font-medium">Pengaturan</li>
        </ol>
    </div>
</nav>

<!-- Settings Content -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            @include('user.partials.profile-sidebar')
            
            <!-- Main Content -->
            <div class="lg:col-span-3">
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('profile.settings.update') }}">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Notifikasi -->
                        <div class="bg-white rounded-lg shadow-sm border">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-bold text-gray-900">Notifikasi</h2>
                                <p class="text-gray-600 text-sm">Kelola preferensi notifikasi Anda</p>
                            </div>
                            
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">Email Notifikasi</h3>
                                        <p class="text-gray-600 text-sm">Terima notifikasi pesanan melalui email</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="email_notifications" value="1" class="sr-only peer" {{ $settings->email_notifications ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-red/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-red"></div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">SMS Notifikasi</h3>
                                        <p class="text-gray-600 text-sm">Terima notifikasi pesanan melalui SMS</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="sms_notifications" value="1" class="sr-only peer" {{ $settings->sms_notifications ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-red/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-red"></div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">Promo & Penawaran</h3>
                                        <p class="text-gray-600 text-sm">Terima informasi promo dan penawaran khusus</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="promo_notifications" value="1" class="sr-only peer" {{ $settings->promo_notifications ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-red/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-red"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Preferensi -->
                        <div class="bg-white rounded-lg shadow-sm border">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-bold text-gray-900">Preferensi</h2>
                                <p class="text-gray-600 text-sm">Sesuaikan pengalaman Anda</p>
                            </div>
                            
                            <div class="p-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bahasa</label>
                                    <select name="language" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                        <option value="id" {{ $settings->language == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                        <option value="en" {{ $settings->language == 'en' ? 'selected' : '' }}>English</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Zona Waktu</label>
                                    <select name="timezone" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                                        <option value="Asia/Jakarta" {{ $settings->timezone == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (UTC+7)</option>
                                        <option value="Asia/Makassar" {{ $settings->timezone == 'Asia/Makassar' ? 'selected' : '' }}>WITA (UTC+8)</option>
                                        <option value="Asia/Jayapura" {{ $settings->timezone == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (UTC+9)</option>
                                    </select>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">Mode Gelap</h3>
                                        <p class="text-gray-600 text-sm">Aktifkan tampilan mode gelap</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="dark_mode" value="1" class="sr-only peer" {{ $settings->dark_mode ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-red/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-red"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Privasi & Keamanan -->
                        <div class="bg-white rounded-lg shadow-sm border">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-bold text-gray-900">Privasi & Keamanan</h2>
                                <p class="text-gray-600 text-sm">Pengaturan keamanan akun Anda</p>
                            </div>
                            
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">Ubah Password</h3>
                                        <p class="text-gray-600 text-sm">Terakhir diubah: {{ $user->updated_at->format('d F Y') }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition duration-300">
                                        Ubah Password
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Save Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-brand-red text-white px-6 py-3 rounded-lg font-medium hover:bg-brand-black transition duration-300">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection