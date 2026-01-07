<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <button class="btn btn-outline-secondary d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Page Title & Breadcrumb -->
        <div class="d-flex flex-column">
            <h4 class="mb-0 text-dark fw-bold">@yield('page-title', 'Dashboard')</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    @if(!request()->routeIs('admin.dashboard'))
                        <li class="breadcrumb-item active" aria-current="page">@yield('page-title')</li>
                    @endif
                </ol>
            </nav>
        </div>
        
        <!-- Right Side Actions -->
        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Quick Actions -->
            <div class="dropdown">
                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.menus.create') }}"><i class="fas fa-hamburger me-2"></i>Menu Baru</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i class="fas fa-tags me-2"></i>Kategori Baru</a></li>
                </ul>
            </div>
            
            <!-- Notifications -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    @if($notifications ?? 0 > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notifications }}
                        </span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                    <li><h6 class="dropdown-header">Notifikasi Terbaru</h6></li>
                    <li><a class="dropdown-item" href="#">
                        <div class="d-flex">
                            <i class="fas fa-shopping-cart text-primary me-2 mt-1"></i>
                            <div>
                                <div class="fw-semibold">Pesanan Baru</div>
                                <small class="text-muted">Ada 3 pesanan menunggu konfirmasi</small>
                            </div>
                        </div>
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center small" href="#">Lihat Semua Notifikasi</a></li>
                </ul>
            </div>
            
            <!-- User Profile -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                    <!-- Avatar dengan inisial nama -->
                    <div class="rounded-circle me-2 d-flex align-items-center justify-content-center" 
                         style="width: 32px; height: 32px; background: var(--stat-red); color: white; font-size: 0.75rem; font-weight: bold;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                    </div>
                    <div class="text-start d-none d-md-block">
                        <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                        <i class="fas fa-user me-2"></i> Profil Saya
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>