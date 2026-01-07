@extends('user.main')

@section('title', 'Menu - CateringKu')

@php
$breadcrumbs = [
    ['title' => 'Menu', 'url' => route('menu')]
];
@endphp

@section('content')
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center text-white overflow-hidden" style="background-image: url('{{ asset('assets/img/hero/menu.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-6xl font-bold mb-4 font-playfair">MENU KAMI</h1>
            <p class="text-xl mb-6 font-poppins">Pilihan terbaik untuk setiap acara Anda</p>
            
            <!-- Search Bar -->
            <div class="max-w-md mx-auto mb-8">
                <div class="relative">
                    <input type="text" id="heroSearch" placeholder="Cari menu favorit Anda..." class="w-full px-6 py-4 text-lg text-brand-black rounded-full border-0 focus:ring-4 focus:ring-white focus:ring-opacity-30 shadow-lg">
                    <button class="absolute right-2 top-2 bg-brand-red text-white p-2 rounded-full hover:bg-brand-black transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <nav class="flex justify-center items-center space-x-2 text-white opacity-90">
                <a href="{{ route('beranda') }}" class="hover:text-brand-cream transition duration-300">Home</a>
                <span>></span>
                <span class="text-brand-cream">Menu</span>
            </nav>
        </div>
    </div>
</section>

@include('user.partials.breadcrumb')

<!-- Menu Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    
                    <!-- Search -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="sidebarSearch" placeholder="Cari menu..." class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-brand-black mb-4">Semua Menu</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="#" data-category="all" class="category-filter flex items-center justify-between py-2 px-3 text-brand-black hover:bg-brand-light hover:text-brand-red rounded-lg transition duration-200 bg-brand-red text-white">
                                    <span>Semua Menu</span>
                                    <span class="text-sm opacity-80">({{ $menus->count() }})</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li>
                                <a href="#" data-category="{{ $category->slug }}" class="category-filter flex items-center justify-between py-2 px-3 text-brand-black hover:bg-brand-light hover:text-brand-red rounded-lg transition duration-200">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-sm text-gray-500">({{ $category->menus_count }})</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Price Filter -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-brand-black mb-4">Filter Harga</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <input type="number" id="minPrice" placeholder="Min" step="10000" class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <span class="text-gray-500">-</span>
                                <input type="number" id="maxPrice" placeholder="Max" step="10000" class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                            <button id="applyPriceFilter" class="w-full bg-brand-red text-white py-2 px-4 rounded-lg hover:bg-brand-black transition duration-300">
                                Filter Harga
                            </button>
                        </div>
                    </div>

                    <!-- Popular Tags -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-brand-black mb-4">Tag Populer</h3>
                        <div class="flex flex-wrap gap-2">
                            <span data-tag="hot" class="tag-filter px-3 py-1 bg-gray-100 text-brand-black text-sm rounded-full cursor-pointer hover:bg-brand-red hover:text-white transition duration-300">Hot</span>
                            <span data-tag="baru" class="tag-filter px-3 py-1 bg-gray-100 text-brand-black text-sm rounded-full cursor-pointer hover:bg-brand-red hover:text-white transition duration-300">Baru</span>
                            <span data-tag="favorit" class="tag-filter px-3 py-1 bg-gray-100 text-brand-black text-sm rounded-full cursor-pointer hover:bg-brand-red hover:text-white transition duration-300">Favorit</span>
                            <span data-tag="bestseller" class="tag-filter px-3 py-1 bg-gray-100 text-brand-black text-sm rounded-full cursor-pointer hover:bg-brand-red hover:text-white transition duration-300">Best Seller</span>
                            <span data-tag="promo" class="tag-filter px-3 py-1 bg-gray-100 text-brand-black text-sm rounded-full cursor-pointer hover:bg-brand-red hover:text-white transition duration-300">Promo</span>
                            <span data-tag="sale" class="tag-filter px-3 py-1 bg-gray-100 text-brand-black text-sm rounded-full cursor-pointer hover:bg-brand-red hover:text-white transition duration-300">Sale</span>
                            <span data-tag="rekomendasi" class="tag-filter px-3 py-1 bg-gray-100 text-brand-black text-sm rounded-full cursor-pointer hover:bg-brand-red hover:text-white transition duration-300">Rekomendasi</span>
                            <span data-tag="halal" class="tag-filter px-3 py-1 bg-gray-100 text-brand-black text-sm rounded-full cursor-pointer hover:bg-brand-red hover:text-white transition duration-300">Halal</span>
                        </div>
                    </div>

                    <!-- Food Collections Banner -->
                    <div class="bg-brand-red rounded-lg p-6 text-white text-center">
                        <h4 class="text-lg font-semibold mb-2">Koleksi Makanan</h4>
                        <p class="text-sm text-brand-light mb-4">Paket hemat untuk acara besar</p>
                        <button class="bg-white text-brand-red px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-light">
                            Lihat Paket
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:w-3/4">
                
                <!-- Results Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <p id="resultsCount" class="text-brand-black mb-4 sm:mb-0 bg-white px-4 py-2 rounded-lg shadow-sm flex-1 mr-4">Menampilkan 1-{{ $menus->count() }} dari {{ $menus->count() }} hasil</p>
                    <div class="flex items-center space-x-4">
                        <select id="sortSelect" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-red focus:border-brand-red">
                            <option value="default">Urutkan</option>
                            <option value="price-low">Harga: Rendah ke Tinggi</option>
                            <option value="price-high">Harga: Tinggi ke Rendah</option>
                            <option value="popular">Paling Populer</option>
                            <option value="newest">Terbaru</option>
                        </select>
                        <div class="flex border border-gray-300 rounded-lg">
                            <button id="gridView" class="p-2 bg-brand-red text-white rounded-l-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button id="listView" class="p-2 text-brand-black hover:bg-brand-light rounded-r-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Grid -->
                <div id="menuGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($menus as $menu)
                    <div class="menu-item bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition duration-300 group" data-category="{{ $menu->category->slug }}" data-price="{{ $menu->price }}" data-tags="{{ is_array($menu->tags) ? implode(',', $menu->tags) : $menu->tags }}">
                        <div class="relative">
                            <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" alt="{{ $menu->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                            @if($menu->tags)
                                <div class="absolute top-3 left-3">
                                    @php
                                        $tagColors = [
                                            'hot' => 'bg-brand-red',
                                            'bestseller' => 'bg-green-500', 
                                            'baru' => 'bg-blue-500',
                                            'promo' => 'bg-orange-500',
                                            'sale' => 'bg-red-500'
                                        ];
                                        $tags = is_array($menu->tags) ? $menu->tags : explode(',', $menu->tags);
                                        $firstTag = $tags[0] ?? '';
                                        $tagColor = $tagColors[$firstTag] ?? 'bg-gray-500';
                                    @endphp
                                    <span class="{{ $tagColor }} text-white text-xs px-2 py-1 rounded-full">{{ ucfirst($firstTag) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-brand-black mb-2">{{ $menu->name }}</h3>
                            <p class="text-sm text-brand-black opacity-80 mb-3">{{ $menu->description }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-brand-red">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <a href="{{ route('menu.show', $menu->slug) }}" class="bg-brand-red text-white px-4 py-2 rounded-lg hover:bg-brand-black transition duration-300">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-12">
                    <nav class="flex items-center space-x-2">
                        <button class="px-3 py-2 text-brand-black hover:text-brand-red">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button class="px-4 py-2 bg-brand-red text-white rounded-lg">1</button>
                        <button class="px-4 py-2 text-brand-black hover:bg-brand-light rounded-lg">2</button>
                        <button class="px-4 py-2 text-brand-black hover:bg-brand-light rounded-lg">3</button>
                        <button class="px-3 py-2 text-brand-black hover:text-brand-red">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="py-16 relative" style="background-image: url('{{ asset('assets/img/bg-ctaa2.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white bg-opacity-90 rounded-lg p-8 text-center backdrop-blur-sm">
            <h3 class="text-2xl font-bold text-brand-black mb-4">Minimum Pemesanan</h3>
            <p class="text-brand-black opacity-80 mb-4">Untuk pemesanan catering, minimum order adalah 10 porsi</p>
            <p class="text-sm text-brand-black opacity-60">Hubungi kami untuk paket khusus acara besar</p>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/menu.js') }}"></script>
@endpush