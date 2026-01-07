@extends('user.main')

@section('title', 'Kontak - CateringKu')

@php
$breadcrumbs = [
    ['title' => 'Kontak', 'url' => route('kontak')]
];
@endphp

@section('content')
    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center text-white overflow-hidden"
        style="background-image: url('{{ asset('assets/img/hero/kontak.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-6xl font-bold mb-4 font-playfair">HUBUNGI KAMI</h1>
                <p class="text-xl mb-6 font-poppins">Kami siap membantu kebutuhan catering Anda</p>

                <nav class="flex justify-center items-center space-x-2 text-white opacity-90">
                    <a href="{{ route('beranda') }}" class="hover:text-brand-cream transition duration-300">Home</a>
                    <span>></span>
                    <span class="text-brand-cream">Kontak</span>
                </nav>
            </div>
        </div>
    </section>

@include('user.partials.breadcrumb')

    <!-- Contact Info & Form Section -->
    <section class="py-16 bg-brand-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-bold text-brand-black mb-8">Informasi Kontak</h2>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-brand-cream p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-brand-black mb-1">Alamat</h3>
                                <p class="text-brand-black opacity-80">Jl. Sindangsari 4 No.48, Sukamulya<br>Kec. Cinambo,
                                    Kota Bandung<br>Jawa Barat 40614</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-brand-cream p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-brand-black mb-1">Telepon</h3>
                                <p class="text-brand-black opacity-80">+62 821-2609-9407</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-brand-cream p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-brand-black mb-1">Email</h3>
                                <p class="text-brand-black opacity-80">rezdika31@gmail.com</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-brand-cream p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-brand-black mb-1">Jam Operasional</h3>
                                <p class="text-brand-black opacity-80">Senin - Jumat: 08:00 - 20:00<br>Sabtu - Minggu: 09:00
                                    - 18:00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-brand-black mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="bg-brand-red text-white p-3 rounded-full hover:bg-brand-black transition duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="bg-brand-red text-white p-3 rounded-full hover:bg-brand-black transition duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-brand-black mb-6">Kirim Pesan</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kontak') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-brand-black mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-brand-black mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red @error('email') border-red-500 @enderror"
                                    placeholder="nama@email.com">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-brand-black mb-2">Nomor Telepon</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red @error('phone') border-red-500 @enderror"
                                    placeholder="+62 812-3456-7890">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-brand-black mb-2">Subjek</label>
                                <select name="subject" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red @error('subject') border-red-500 @enderror">
                                    <option value="">Pilih subjek</option>
                                    <option value="Pertanyaan Menu" {{ old('subject') == 'Pertanyaan Menu' ? 'selected' : '' }}>Pertanyaan Menu</option>
                                    <option value="Pemesanan Catering" {{ old('subject') == 'Pemesanan Catering' ? 'selected' : '' }}>Pemesanan Catering</option>
                                    <option value="Saran" {{ old('subject') == 'Saran' ? 'selected' : '' }}>Saran</option>
                                    <option value="Kritik" {{ old('subject') == 'Kritik' ? 'selected' : '' }}>Kritik</option>
                                    <option value="Keluhan" {{ old('subject') == 'Keluhan' ? 'selected' : '' }}>Keluhan</option>
                                    <option value="Lainnya" {{ old('subject') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('subject')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-brand-black mb-2">Pesan</label>
                            <textarea name="message" rows="5" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red @error('message') border-red-500 @enderror"
                                placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-brand-red text-white py-3 px-6 rounded-lg font-semibold hover:bg-brand-black transition duration-300">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-brand-black mb-4">Lokasi Kami</h2>
                <p class="text-brand-black opacity-80">Kunjungi langsung dapur kami untuk melihat proses pembuatan</p>
            </div>

            <!-- Google Maps -->
            <div class="rounded-lg overflow-hidden shadow-lg">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.055191622854!2d107.68157955541994!3d-6.9188169999999936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dd315d362899%3A0xc30ef81545cdfb16!2sD%27Yummy%20Catering%20(Kantor)!5e0!3m2!1sid!2sid!4v1766814070400!5m2!1sid!2sid"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <!-- FAQ List -->
                <div>
                    <h2 class="text-3xl font-bold text-brand-black mb-8">Frequently Ask Question</h2>

                    <div class="space-y-4">
                        <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                            <button
                                class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                                <span class="text-brand-black font-medium">Apa itu D'Yummy Catering?</span>
                                <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold faq-icon">+</span>
                                </div>
                            </button>
                            <div class="faq-content hidden px-6 pb-4">
                                <p class="text-gray-600">D'Yummy Catering adalah layanan catering yang menyediakan makanan
                                    berkualitas tinggi untuk berbagai acara, mulai dari acara kantor, pernikahan, hingga
                                    acara keluarga dengan cita rasa autentik Indonesia.</p>
                            </div>
                        </div>

                        <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                            <button
                                class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                                <span class="text-brand-black font-medium">Mengapa harus memilih D'Yummy Catering?</span>
                                <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold faq-icon">+</span>
                                </div>
                            </button>
                            <div class="faq-content hidden px-6 pb-4">
                                <p class="text-gray-600">Kami menggunakan bahan-bahan segar berkualitas tinggi, memiliki
                                    koki berpengalaman, pengiriman cepat dalam 30 menit, dan harga yang terjangkau dengan
                                    pelayanan terbaik 24/7.</p>
                            </div>
                        </div>

                        <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                            <button
                                class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                                <span class="text-brand-black font-medium">Bagaimana cara menghubungi kami?</span>
                                <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold faq-icon">+</span>
                                </div>
                            </button>
                            <div class="faq-content hidden px-6 pb-4">
                                <p class="text-gray-600">Anda dapat menghubungi kami melalui telepon di +62 821-2609-9407,
                                    email ke rezdika31@gmail.com, atau mengisi form kontak di website ini. Kami siap
                                    melayani Anda 24/7.</p>
                            </div>
                        </div>

                        <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                            <button
                                class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                                <span class="text-brand-black font-medium">Berapa minimum order untuk catering?</span>
                                <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold faq-icon">+</span>
                                </div>
                            </button>
                            <div class="faq-content hidden px-6 pb-4">
                                <p class="text-gray-600">Minimum order untuk layanan catering adalah 10 porsi. Untuk paket
                                    khusus acara besar, silakan hubungi kami untuk mendapatkan penawaran terbaik.</p>
                            </div>
                        </div>

                        <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                            <button
                                class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                                <span class="text-brand-black font-medium">Apakah ada promo atau diskon?</span>
                                <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold faq-icon">+</span>
                                </div>
                            </button>
                            <div class="faq-content hidden px-6 pb-4">
                                <p class="text-gray-600">Ya! Kami memiliki promo harian dan paket gratis untuk pembelian di
                                    atas Rp 100.000. Ikuti media sosial kami untuk mendapatkan update promo terbaru.</p>
                            </div>
                        </div>

                        <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200">
                            <button
                                class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition duration-300">
                                <span class="text-brand-black font-medium">Bagaimana sistem pembayaran?</span>
                                <div class="w-6 h-6 bg-brand-red rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold faq-icon">+</span>
                                </div>
                            </button>
                            <div class="faq-content hidden px-6 pb-4">
                                <p class="text-gray-600">Kami menerima pembayaran tunai, transfer bank, e-wallet (OVO,
                                    GoPay, DANA), dan kartu kredit. Pembayaran dapat dilakukan saat pemesanan atau cash on
                                    delivery.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Illustration & CTA -->
                <div class="flex flex-col items-center justify-center space-y-8">
                    <!-- Illustration -->
                    <div class="text-center">
                        <img src="{{ asset('assets/img/ilustration1.png') }}" alt="FAQ Illustration"
                            class="w-full max-w-md mx-auto">
                    </div>


                </div>

            </div>
        </div>
    </section>
    <!-- CTA Section -->
    <section class="mb-10  mt-2" style="background-image: url('{{ asset('assets/img/bg-ctaa2.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 250px">
        <div class="text-center">
            <h3 class="text-2xl font-bold text-brand-black mb-4">Masih Ada Pertanyaan?</h3>
            <p class="text-gray-600 mb-6">Jika pertanyaan Anda belum terjawab, silakan hubungi kami melalui form kontak</p>
            <button onclick="scrollToContactForm()"
                class="bg-brand-red text-white py-3 px-8 rounded-lg font-semibold hover:bg-brand-black transition duration-300 shadow-lg">
                Hubungi Kami
            </button>
        </div>
    </section>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/kontak.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/kontak.js') }}"></script>
@endpush
@endsection