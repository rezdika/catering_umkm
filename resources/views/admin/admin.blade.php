<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Catering UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-red: #8E1616;
            --secondary-red: #a91d1d;
            --dark-red: #6b1111;
            --light-red: #f5e6e6;
            --accent-gold: #D4AF37;
            --stat-red: #8E1616;
            --stat-orange: #D2691E;
            --stat-brown: #A0522D;
            --stat-gold: #B8860B;
        }
        
        body { background: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background: var(--primary-red); min-height: 100vh; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .main-content { margin-left: 280px; background: #f8f9fa; }
        .navbar { background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-bottom: 3px solid var(--primary-red); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); background: white; }
        .btn-primary { background: var(--primary-red); border-color: var(--primary-red); border-radius: 8px; }
        .btn-primary:hover { background: var(--dark-red); border-color: var(--dark-red); transform: translateY(-1px); }
        .table th { background: var(--light-red); color: var(--dark-red); font-weight: 600; }
        .content-wrapper { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        
        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; width: 280px; }
            .sidebar.show { transform: translateX(0); }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('admin.partials.sidebar')
    
    <div class="main-content">
        @include('admin.partials.header')
        
        <div class="container-fluid p-4">
            <div class="content-wrapper p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
        
        @include('admin.partials.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>