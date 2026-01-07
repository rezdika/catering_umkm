@extends('user.main')

@section('title', 'Beranda - CateringKu')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
@endphp
<!-- Hero Section -->
<section class="text-white relative overflow-hidden" style="background-image: url('{{ asset('assets/img/hero/beranda.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; margin-bottom: 120px;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 h-full flex items-center">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">
            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Pesan Makanan Sehat Dan Segar Kapan Saja
                </h1>
                <p class="text-brand-light text-base mb-8 max-w-lg">
                    Makanan Indonesia membuat orang berpikir tentang makan malam keluarga besar. Jadi Anda mungkin ingin memposisikan restoran Anda sebagai tempat untuk membawa seluruh keluarga.
                </p>
                
                <!-- Search Bar -->
                <div class="mb-8">
                    <div class="flex max-w-md mx-auto lg:mx-0">
                        <input type="text" placeholder="Cari Menu" 
                               class="flex-1 px-4 py-3 rounded-l-lg text-brand-black focus:outline-none focus:ring-2 focus:ring-brand-cream">
                        <button class="bg-yellow-400 hover:bg-yellow-500 px-6 py-3 rounded-r-lg transition duration-300">
                            <svg class="w-5 h-5 text-brand-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Popular Menu -->
                <div class="mb-8">
                    <h3 class="text-white text-lg font-semibold mb-4">Menu Populer</h3>
                    <div class="flex space-x-3 overflow-x-auto">
                        @forelse($popularMenus->take(7) as $menu)
                            <a href="{{ route('menu.show', $menu->slug) }}" class="flex-shrink-0 w-12 h-12 bg-white rounded-lg flex items-center justify-center hover:bg-brand-red hover:scale-105 transition duration-300 group">
                                @if($menu->image)
                                    <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="w-8 h-8 object-cover rounded group-hover:filter group-hover:brightness-0 group-hover:invert">
                                @else
                                    <span class="text-2xl group-hover:filter group-hover:brightness-0 group-hover:invert">🍽️</span>
                                @endif
                            </a>
                        @empty
                            <div class="flex-shrink-0 w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                                <span class="text-2xl">🍗</span>
                            </div>
                            <div class="flex-shrink-0 w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                                <span class="text-2xl">🍛</span>
                            </div>
                            <div class="flex-shrink-0 w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                                <span class="text-2xl">🍜</span>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('menu') }}" class="bg-white text-brand-red px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-light transition duration-300 shadow-lg">
                        LIHAT MENU
                    </a>
                    <a href="{{ route('kontak') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-brand-red transition duration-300">
                        HUBUNGI KAMI
                    </a>
                </div>
            </div>

            <!-- Right Content - Space for image -->
            <div class="relative hidden lg:block">
                <!-- Empty space to let background image show -->
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-8 flex items-center justify-center" style="background-image: url('{{ asset('assets/img/bg-ctaa.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 250px">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Tagline -->
        <div class="mb-8">
           
            <p class="text-2xl text-brand-red mb-2" >
                Makanan segar, cita rasa istimewa, langsung ke rumah Anda
            </p>
            <p class="text-xl text-brand-red" >
                Pengiriman dalam 30 menit! 
            </p>
        </div>
        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('menu') }}" class="bg-white text-brand-red px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-light transition duration-300 shadow-lg transform hover:scale-105">
                 Pesan Sekarang
            </a>
            <a href="tel:+6282126099407" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-brand-red transition duration-300 transform hover:scale-105">
                 Hubungi Kami
            </a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-brand-black mb-4">Keunggulan Kami</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service Cards -->
            <div class="bg-white p-8 text-center">
                <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-brand-red font-subheading">MAKANAN LEZAT</h3>
                <p class="text-brand-black text-sm">Makanan terbaik dengan bahan-bahan segar pilihan</p>
            </div>

            <div class="bg-white p-8 text-center">
                <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-brand-red font-subheading">PENGIRIMAN CEPAT</h3>
                <p class="text-brand-black text-sm">Rata-rata 15 menit waktu pengiriman</p>
            </div>

            <div class="bg-white p-8 text-center">
                <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-brand-red font-subheading">BAHAN SEGAR</h3>
                <p class="text-brand-black text-sm">Hanya bahan-bahan segar dan berkualitas tinggi</p>
            </div>

            <div class="bg-white p-8 text-center">
                <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-brand-red font-subheading">PROMO HARIAN</h3>
                <p class="text-brand-black text-sm">Penawaran spesial dan diskon setiap hari</p>
            </div>

            <div class="bg-white p-8 text-center">
                <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-brand-red font-subheading">KOKI TERBAIK</h3>
                <p class="text-brand-black text-sm">Koki profesional berpengalaman bertahun-tahun</p>
            </div>

            <div class="bg-white p-8 text-center">
                <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-brand-red font-subheading">PELAYANAN TERBAIK</h3>
                <p class="text-brand-black text-sm">Pelayanan ramah dan profesional 24/7</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('menu') }}" class="bg-brand-black text-white px-8 py-3 rounded-full font-bold hover:bg-brand-red transition duration-300">
                LIHAT MENU SEKARANG
            </a>
        </div>
    </div>
</section>

<!-- Promo Section -->
<section class="bg-brand-red text-white py-20 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-5xl font-bold mb-4">KABAR GEMBIRA!</h2>
                <h3 class="text-5xl font-black mb-7">ADA PROMO SPESIAL HARI INI</h3>
              
                <a href="{{ route('menu') }}" class="bg-white text-brand-red px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-light transition duration-300">
                    PESAN SEKARANG
                </a>
            </div>
            <div class="relative">
                <div class="slider-container overflow-hidden">
                    <div class="slider-track flex transition-transform duration-500 ease-in-out" id="promoSlider">
                        <div class="slider-item w-full flex-shrink-0">
                            <img src="{{ asset('assets/img/promo/promo1.png') }}" 
                                 alt="Promo Slider 1" class="w-full h-80 object-cover">
                        </div>
                        <div class="slider-item w-full flex-shrink-0">
                            <img src="{{ asset('assets/img/promo/promo2.png') }}" 
                                 alt="Promo Slider 2" class="w-full h-80 object-cover">
                        </div>
                    </div>
                </div>
                
                <!-- Slider Dots -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <button class="w-3 h-3 bg-white bg-opacity-60 rounded-full transition duration-300 dot" onclick="currentSlide(1)"></button>
                    <button class="w-3 h-3 bg-white bg-opacity-60 rounded-full transition duration-300 dot" onclick="currentSlide(2)"></button>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Menu Popular Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-brand-black mb-4">Menu Populer</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($popularMenus->take(3) as $menu)
            <!-- Menu Item {{ $loop->iteration }} -->
            <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                <div class="relative">
                    @if($menu->image)
                        <img src="{{ Storage::url($menu->image) }}" 
                             alt="{{ $menu->name }}" class="w-full h-48 object-cover">
                    @else
                        <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             alt="{{ $menu->name }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-brand-red text-white text-xs px-3 py-1 rounded-full font-bold">POPULER</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-brand-black mb-3">{{ $menu->name }}</h3>
                    <p class="text-brand-black opacity-80 text-sm mb-4">{{ Str::limit($menu->description, 80) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-brand-red font-bold text-lg">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <a href="{{ route('menu.show', $menu->slug) }}" class="bg-brand-red text-white px-4 py-2 rounded-full text-sm hover:bg-brand-black transition duration-300">Pesan</a>
                    </div>
                </div>
            </article>
            @empty
            <!-- Default Menu Items when no popular menus -->
            <div class="col-span-full text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Menu Populer</h3>
                <p class="text-gray-500 mb-6">Menu populer akan muncul berdasarkan penjualan terbanyak</p>
                <a href="{{ route('menu') }}" class="bg-brand-red text-white px-6 py-3 rounded-full font-bold hover:bg-brand-black transition duration-300">
                    Lihat Semua Menu
                </a>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('menu') }}" class="bg-brand-black text-white px-8 py-3 rounded-full font-bold hover:bg-brand-red transition duration-300">
                LIHAT SEMUA MENU
            </a>
        </div>
    </div>
</section>



<!-- Event Videos Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-brand-black mb-4">Acara yang Sudah Terlaksana</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Lihat dokumentasi acara-acara yang telah kami layani dengan kepuasan pelanggan yang luar biasa</p>
        </div>
        
        <!-- Featured Video -->
        <div class="mb-12">
            <div class="relative w-full" style="padding-bottom: 56.25%; /* 16:9 aspect ratio */">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg"
                    src="https://www.youtube.com/embed/e9lqHITTLfM" 
                    title="Acara Catering Utama"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
        
        <!-- Video Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Video 1 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative" style="padding-bottom: 56.25%;">
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/Dk9PQ5evHtA" 
                        title="Acara Catering 1"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-brand-black mb-2">Acara Pernikahan</h4>
                    <p class="text-sm text-gray-600">Dokumentasi layanan catering untuk acara pernikahan yang meriah</p>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative" style="padding-bottom: 56.25%;">
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/mWBcoin8anQ" 
                        title="Acara Catering 2"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-brand-black mb-2">Acara Perusahaan</h4>
                    <p class="text-sm text-gray-600">Layanan catering untuk acara corporate dan meeting</p>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative" style="padding-bottom: 56.25%;">
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/8BN8ny8zv3U" 
                        title="Acara Catering 3"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-brand-black mb-2">Acara Keluarga</h4>
                    <p class="text-sm text-gray-600">Dokumentasi acara keluarga dengan menu spesial</p>
                </div>
            </div>

            <!-- Video 4 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative" style="padding-bottom: 56.25%;">
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/5W-ZdKEApjk" 
                        title="Acara Catering 4"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-brand-black mb-2">Acara Ulang Tahun</h4>
                    <p class="text-sm text-gray-600">Perayaan ulang tahun dengan menu catering terbaik</p>
                </div>
            </div>

            <!-- Video 5 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative" style="padding-bottom: 56.25%;">
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/ps72kKwt6LA" 
                        title="Acara Catering 5"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-brand-black mb-2">Acara Seminar</h4>
                    <p class="text-sm text-gray-600">Layanan catering untuk acara seminar dan workshop</p>
                </div>
            </div>

            <!-- Video 6 -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                <div class="relative" style="padding-bottom: 56.25%;">
                    <iframe 
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/P7RHWIOpfOs" 
                        title="Acara Catering 6"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-brand-black mb-2">Acara Komunitas</h4>
                    <p class="text-sm text-gray-600">Dokumentasi acara komunitas dengan berbagai menu pilihan</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('kontak') }}" class="bg-brand-red text-white px-8 py-3 rounded-full font-bold hover:bg-brand-black transition duration-300">
                PESAN CATERING UNTUK ACARA ANDA
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-16">
            <h2 class="text-4xl font-bold text-brand-black mb-4">— Kata Pelanggan Bahagia Kami</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Testimonial 1 -->
            <div class="text-center">
                <div class="mb-4">
                    <img src="{{ asset('assets/img/testimonial/testimonial1.png') }}" 
                         alt="Pelanggan" class="w-full h-64 object-cover rounded-lg">
                </div>
                <p class="text-sm text-gray-600 italic mb-3">"Makanan di D'Yummy Catering selalu segar dan lezat. Pelayanannya juga sangat memuaskan!"</p>
                <h4 class="font-bold text-brand-black mb-1">Budi Santoso</h4>
                <p class="text-sm text-gray-500">Pengusaha</p>
            </div>

            <!-- Testimonial 2 -->
            <div class="text-center">
                <div class="mb-4">
                    <img src="{{ asset('assets/img/testimonial/testimonial2.png') }}" 
                         alt="Pelanggan" class="w-full h-64 object-cover rounded-lg">
                </div>
                <p class="text-sm text-gray-600 italic mb-3">"Pengiriman cepat dan makanan masih hangat. Sangat cocok untuk acara kantor kami."</p>
                <h4 class="font-bold text-brand-black mb-1">Ahmad Wijaya</h4>
                <p class="text-sm text-gray-500">CEO Startup</p>
            </div>

            <!-- Testimonial 3 - Active -->
              <div class="text-center">
                <div class="mb-4">
                    <img src="{{ asset('assets/img/testimonial/testimonial3.png') }}" 
                         alt="Pelanggan" class="w-full h-64 object-cover rounded-lg">
                </div>
                <p class="text-sm text-gray-600 italic mb-3">"Pengiriman cepat dan makanan masih hangat. Sangat cocok untuk acara kantor kami."</p>
                <h4 class="font-bold text-brand-black mb-1">sari dewi</h4>
                <p class="text-sm text-gray-500">Entrepreneur</p>
            </div>

            <!-- Testimonial 4 -->
            <div class="text-center">
                <div class="mb-4">
                    <img src="{{ asset('assets/img/testimonial/testimonial4.png') }}" 
                         alt="Pelanggan" class="w-full h-64 object-cover rounded-lg">
                </div>
                <p class="text-sm text-gray-600 italic mb-3">"Harga terjangkau dengan kualitas premium. Sudah langganan sejak 2 tahun!"</p>
                <h4 class="font-bold text-brand-black mb-1">Maya Putri</h4>
                <p class="text-sm text-gray-500">Entrepreneur</p>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/beranda.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/beranda.js') }}"></script>
@endpush
@endsection