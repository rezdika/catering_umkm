<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CateringKu - Catering UMKM Terbaik')</title>
    <meta name="description" content="@yield('description', 'Solusi catering terpercaya untuk kebutuhan makanan rumahan dan acara Anda dengan cita rasa autentik dan pelayanan terbaik.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,700|poppins:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'sans': ['Poppins', 'ui-sans-serif', 'system-ui'],
                            'serif': ['Playfair Display', 'ui-serif', 'Georgia'],
                            'heading': ['Playfair Display', 'ui-serif', 'Georgia']
                        },
                        colors: {
                            'brand': {
                                'black': '#000000',
                                'red': '#8E1616', 
                                'cream': '#E8C999',
                                'light': '#F8EEDF'
                            }
                        }
                    }
                }
            }
        </script>
    @endif
    
    @stack('styles')
</head>
<body class="bg-white font-sans antialiased">
    <!-- Loading Spinner -->
    <div id="loading" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-red"></div>
    </div>

    @include('user.partials.header')
    
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    @include('user.partials.footer')
    
    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-6 right-6 bg-brand-red text-white p-3 rounded-full shadow-lg hover:bg-brand-black transition-all duration-300 opacity-0 invisible">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- Scripts -->
    <script>
        // Loading Screen
        window.addEventListener('load', function() {
            document.getElementById('loading').style.display = 'none';
        });
        
        // Back to Top
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.remove('opacity-0', 'invisible');
                backToTop.classList.add('opacity-100', 'visible');
            } else {
                backToTop.classList.add('opacity-0', 'invisible');
                backToTop.classList.remove('opacity-100', 'visible');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
    
    @stack('scripts')
</body>
</html>