<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CateringKu - Catering UMKM Terbaik')</title>
    
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
    @yield('content')
    
    @stack('scripts')
</body>
</html>