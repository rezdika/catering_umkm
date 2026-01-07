<div class="sidebar position-fixed top-0 start-0" style="width: 280px; z-index: 1000;">
    <div class="p-4 text-white">
        <!-- Logo & Brand -->
        <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-white border-opacity-25">
            <div>
                <img src="{{ asset('assets/img/logo/logocpanel.png') }}" alt="Catering Logo" class="" style="width: 50px; height: 60px; object-fit: contain; margin-right: 10px;">
            </div>
            <div>
                <h5 class="mb-0 fw-bold">Catering UMKM</h5>
                <small class="opacity-75">Admin Panel</small>
            </div>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="nav flex-column">
            @if(auth()->user()->role === 'admin')
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Dashboard</small>
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-tachometer-alt me-3"></i> Overview
                </a>
            </div>
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Data Master</small>
                <a href="{{ route('admin.categories.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.categories.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-tags me-3"></i> Kategori
                </a>
                <a href="{{ route('admin.menus.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.menus.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-hamburger me-3"></i> Menu
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.users.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-users me-3"></i> Pengguna
                </a>
            </div>
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Komunikasi</small>
                <a href="{{ route('admin.contacts.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.contacts.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-envelope me-3"></i> Pesan Kontak
                </a>
                <a href="{{ route('admin.feedbacks.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.feedbacks.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-comments me-3"></i> Saran & Kritik
                </a>
            </div>
            @endif
            
            @if(auth()->user()->role === 'admin_keuangan')
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Dashboard</small>
                <a href="{{ route('admin.finance.dashboard') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.finance.dashboard') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-chart-pie me-3"></i> Dashboard Keuangan
                </a>
            </div>
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Pembayaran</small>
                <a href="{{ route('admin.finance.payments.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.finance.payments.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-credit-card me-3"></i> Verifikasi Pembayaran
                </a>
                <a href="{{ route('admin.finance.payments.index', ['status' => 'pending']) }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.finance.payments.*') && request('status') === 'pending' ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-clock me-3"></i> Pembayaran Pending
                </a>
            </div>
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Laporan & Analisis</small>
                <a href="{{ route('admin.finance.reports.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.finance.reports.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-chart-bar me-3"></i> Laporan Keuangan
                </a>
                <a href="{{ route('admin.finance.reports.export') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.finance.reports.export') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-download me-3"></i> Export Laporan
                </a>
            </div>
            @endif
            
            @if(auth()->user()->role === 'staff_dapur')
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Dashboard</small>
                <a href="{{ route('admin.kitchen.dashboard') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kitchen.dashboard') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-chart-pie me-3"></i> Dashboard Dapur
                </a>
            </div>
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Manajemen Pesanan</small>
                <a href="{{ route('admin.kitchen.orders.today') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kitchen.orders.today') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-calendar-day me-3"></i> Pesanan Hari Ini
                </a>
                <a href="{{ route('admin.kitchen.orders.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kitchen.orders.index') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-list-alt me-3"></i> Semua Pesanan
                </a>
            </div>
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Laporan</small>
                <a href="{{ route('admin.kitchen.reports.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kitchen.reports.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-chart-bar me-3"></i> Laporan Dapur
                </a>
            </div>
            @endif
            
            @if(auth()->user()->role === 'kurir')
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Dashboard</small>
                <a href="{{ route('admin.kurir.dashboard') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kurir.dashboard') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-motorcycle me-3"></i> Dashboard Kurir
                </a>
            </div>
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Manajemen Pengiriman</small>
                <a href="{{ route('admin.kurir.orders.index') }}?status=ready" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kurir.orders.index') && request('status') === 'ready' ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-box me-3"></i> Siap Kirim
                </a>
                <a href="{{ route('admin.kurir.orders.index') }}?kurir=mine" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kurir.orders.index') && request('kurir') === 'mine' ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-user-check me-3"></i> Pesanan Saya
                </a>
                <a href="{{ route('admin.kurir.orders.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kurir.orders.index') && !request('status') && !request('kurir') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-list-alt me-3"></i> Semua Pesanan
                </a>
            </div>
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Laporan</small>
                <a href="{{ route('admin.kurir.reports.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.kurir.reports.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-chart-bar me-3"></i> Laporan Pengiriman
                </a>
            </div>
            @endif
            
            <div class="mb-3">
                <small class="text-white-50 text-uppercase fw-semibold ls-1 mb-2 d-block">Sistem</small>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.settings.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.settings.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-cog me-3"></i> Pengaturan
                </a>
                @endif
                <a href="{{ route('admin.profile.index') }}" class="nav-link text-white mb-1 rounded {{ request()->routeIs('admin.profile.*') ? 'bg-white bg-opacity-25' : '' }}">
                    <i class="fas fa-user me-3"></i> Profil Saya
                </a>
            </div>
        </nav>
    </div>
</div>