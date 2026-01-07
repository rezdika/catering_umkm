@extends('admin.admin')

@section('title', 'Dashboard Keuangan')
@section('page-title', 'Dashboard Keuangan')

@section('content')
<!-- Primary Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card text-white h-100" style="background: linear-gradient(135deg, #8E1616, #B91C1C);">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 opacity-90">Total Pendapatan</h6>
                    <h3 class="mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <small class="opacity-75">Semua waktu</small>
                </div>
                <div class="ms-3">
                    <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card text-white h-100" style="background: linear-gradient(135deg, #D2691E, #FF8C00);">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 opacity-90">Pendapatan Bulan Ini</h6>
                    <h3 class="mb-0 fw-bold">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                    <small class="opacity-75">{{ $monthlyOrders }} pesanan</small>
                </div>
                <div class="ms-3">
                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card text-white h-100" style="background: linear-gradient(135deg, #A0522D, #CD853F);">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 opacity-90">Pendapatan Hari Ini</h6>
                    <h3 class="mb-0 fw-bold">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
                    <small class="opacity-75">{{ $todayPayments }} transaksi</small>
                </div>
                <div class="ms-3">
                    <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card text-white h-100" style="background: linear-gradient(135deg, #B8860B, #DAA520);">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 opacity-90">Rata-rata Order</h6>
                    <h3 class="mb-0 fw-bold">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
                    <small class="opacity-75">Per transaksi</small>
                </div>
                <div class="ms-3">
                    <i class="fas fa-calculator fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Comparison Cards -->
<div class="row mb-4">
    <div class="col-xl-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="text-muted mb-1">Pendapatan Minggu Ini</h6>
                        <h3 class="mb-0 fw-bold text-primary">Rp {{ number_format($thisWeekRevenue, 0, ',', '.') }}</h3>
                        <small class="text-muted">{{ $thisWeekOrders }} pesanan</small>
                    </div>
                    <div class="text-end">
                        @if($revenueGrowth > 0)
                            <span class="badge bg-success"><i class="fas fa-arrow-up"></i> +{{ number_format($revenueGrowth, 1) }}%</span>
                        @elseif($revenueGrowth < 0)
                            <span class="badge bg-danger"><i class="fas fa-arrow-down"></i> {{ number_format($revenueGrowth, 1) }}%</span>
                        @else
                            <span class="badge bg-secondary">0%</span>
                        @endif
                    </div>
                </div>
                <div class="progress mb-2" style="height: 6px;">
                    @php
                        $maxRevenue = max($thisWeekRevenue, $lastWeekRevenue, 1);
                        $thisWeekProgress = ($thisWeekRevenue / $maxRevenue) * 100;
                    @endphp
                    <div class="progress-bar bg-primary" style="width: {{ $thisWeekProgress }}%"></div>
                </div>
                <small class="text-muted">vs Minggu Lalu: Rp {{ number_format($lastWeekRevenue, 0, ',', '.') }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h6 class="text-muted mb-1">Jumlah Order Minggu Ini</h6>
                        <h3 class="mb-0 fw-bold text-success">{{ $thisWeekOrders }}</h3>
                        <small class="text-muted">pesanan baru</small>
                    </div>
                    <div class="text-end">
                        @if($orderGrowth > 0)
                            <span class="badge bg-success"><i class="fas fa-arrow-up"></i> +{{ number_format($orderGrowth, 1) }}%</span>
                        @elseif($orderGrowth < 0)
                            <span class="badge bg-danger"><i class="fas fa-arrow-down"></i> {{ number_format($orderGrowth, 1) }}%</span>
                        @else
                            <span class="badge bg-secondary">0%</span>
                        @endif
                    </div>
                </div>
                <div class="progress mb-2" style="height: 6px;">
                    @php
                        $maxOrders = max($thisWeekOrders, $lastWeekOrders, 1);
                        $thisWeekOrderProgress = ($thisWeekOrders / $maxOrders) * 100;
                    @endphp
                    <div class="progress-bar bg-success" style="width: {{ $thisWeekOrderProgress }}%"></div>
                </div>
                <small class="text-muted">vs Minggu Lalu: {{ $lastWeekOrders }} pesanan</small>
            </div>
        </div>
    </div>
</div>

<!-- Payment Status Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-clock text-warning fa-lg"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="text-muted mb-1">Pembayaran Pending</h6>
                    <h3 class="mb-0 fw-bold text-warning">{{ $pendingPayments }}</h3>
                    <small class="text-muted">Perlu verifikasi</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-check-circle text-success fa-lg"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="text-muted mb-1">Pembayaran Verified</h6>
                    <h3 class="mb-0 fw-bold text-success">{{ $verifiedPayments }}</h3>
                    <small class="text-muted">Sudah diverifikasi</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-times-circle text-danger fa-lg"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="text-muted mb-1">Pembayaran Failed</h6>
                    <h3 class="mb-0 fw-bold text-danger">{{ $failedPayments }}</h3>
                    <small class="text-muted">Ditolak/Gagal</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-chart-pie text-info fa-lg"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="text-muted mb-1">Total Pesanan</h6>
                    <h3 class="mb-0 fw-bold text-info">{{ $totalOrders }}</h3>
                    <small class="text-muted">Semua pesanan</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Metrics Cards -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-coins text-primary fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Rata-rata Harian</h6>
                <h5 class="mb-0 fw-bold">Rp {{ number_format($dailyAverage, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-credit-card text-success fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Bank Transfer</h6>
                <h5 class="mb-0 fw-bold">{{ $paymentMethods['bank_transfer'] }}</h5>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-qrcode text-warning fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">QRIS</h6>
                <h5 class="mb-0 fw-bold">{{ $paymentMethods['qris'] }}</h5>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-info bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-hand-holding-usd text-info fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">COD</h6>
                <h5 class="mb-0 fw-bold">{{ $paymentMethods['cod'] }}</h5>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-secondary bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-percentage text-secondary fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Success Rate</h6>
                <h5 class="mb-0 fw-bold">{{ $verifiedPayments > 0 ? number_format(($verifiedPayments / ($verifiedPayments + $failedPayments)) * 100, 1) : 0 }}%</h5>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="bg-dark bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-shopping-bag text-dark fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Pesanan Bulan Ini</h6>
                <h5 class="mb-0 fw-bold">{{ $monthlyOrders }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0"> Aksi Cepat</h5>
                <small class="text-muted">Navigasi cepat ke fitur utama</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2 col-md-4 col-6 mb-3">
                        <a href="{{ route('admin.finance.payments.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-credit-card fa-2x mb-2"></i>
                            <span class="fw-semibold">Verifikasi</span>
                            <small class="text-muted">Pembayaran</small>
                        </a>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6 mb-3">
                        @if($pendingPayments > 0)
                            <a href="{{ route('admin.finance.payments.index', ['status' => 'pending']) }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <span class="fw-semibold">Pending</span>
                                <small class="text-muted">{{ $pendingPayments }} item</small>
                            </a>
                        @else
                            <div class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="cursor: not-allowed; opacity: 0.6;">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <span class="fw-semibold">No Pending</span>
                                <small class="text-muted">Semua clear</small>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-2 col-md-4 col-6 mb-3">
                        <a href="{{ route('admin.finance.reports.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <span class="fw-semibold">Laporan</span>
                            <small class="text-muted">Keuangan</small>
                        </a>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6 mb-3">
                        <a href="{{ route('admin.finance.reports.export') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-download fa-2x mb-2"></i>
                            <span class="fw-semibold">Export</span>
                            <small class="text-muted">Data</small>
                        </a>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6 mb-3">
                        @if($todayPayments > 0)
                            <a href="{{ route('admin.finance.payments.index', ['date_from' => now()->format('Y-m-d')]) }}" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="fas fa-calendar-day fa-2x mb-2"></i>
                                <span class="fw-semibold">Hari Ini</span>
                                <small class="text-muted">{{ $todayPayments }} transaksi</small>
                            </a>
                        @else
                            <div class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="cursor: not-allowed; opacity: 0.6;">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                <span class="fw-semibold">Hari Ini</span>
                                <small class="text-muted">Belum ada transaksi</small>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-2 col-md-4 col-6 mb-3">
                        <a href="{{ route('admin.finance.payments.create') }}" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-plus fa-2x mb-2"></i>
                            <span class="fw-semibold">Tambah</span>
                            <small class="text-muted">Manual</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Revenue Trend Chart -->
    <div class="col-xl-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <div>
                    <h5 class="mb-0 fw-bold"> Tren Pendapatan</h5>
                    <small class="text-muted">Pendapatan 7 hari terakhir</small>
                </div>
            </div>
            <div class="card-body" style="height: 400px;">
                <canvas id="revenueTrendChart" style="height: 350px !important;"></canvas>
                <div class="mt-2 text-center">
                    <small class="text-muted">Total 7 hari: Rp {{ number_format($revenueTrendTotal ?? 0, 0, ',', '.') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Charts Row -->
<div class="row mb-4">
    <!-- Revenue by Category Chart -->
    <div class="col-xl-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold"> Pendapatan per Kategori</h5>
                <small class="text-muted">Performa kategori menu</small>
            </div>
            <div class="card-body">
                @if(count($categoryData) > 0)
                    <canvas id="categoryRevenueChart" height="100"></canvas>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 300px;">
                        <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Belum Ada Data Kategori</h5>
                        <p class="text-muted text-center mb-0">Grafik akan muncul setelah ada penjualan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Average Order Value Trend -->
    <div class="col-xl-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Rata-rata Nilai Order</h5>
                <small class="text-muted">Trend 7 hari terakhir</small>
            </div>
            <div class="card-body">
                <canvas id="avgOrderChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Revenue & Recent Payments -->
<div class="row mb-4">
    <!-- Monthly Revenue Chart -->
    <div class="col-xl-7 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold"> Pendapatan Bulanan</h5>
                <small class="text-muted">Performa 6 bulan terakhir</small>
            </div>
            <div class="card-body">
                @if(array_sum($monthlyRevenueData) > 0)
                    <canvas id="monthlyRevenueChart" height="100"></canvas>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 300px;">
                        <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Belum Ada Data Bulanan</h5>
                        <p class="text-muted text-center mb-0">Grafik akan muncul setelah ada pendapatan dalam 6 bulan terakhir</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Performance Summary -->
    <div class="col-xl-5 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold"> Ringkasan Performa</h5>
                <small class="text-muted">Metrik kinerja keuangan</small>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            @if(($verifiedPayments + $pendingPayments + $failedPayments) > 0)
                                <h4 class="text-success mb-1">{{ number_format(($verifiedPayments / ($verifiedPayments + $pendingPayments + $failedPayments)) * 100, 1) }}%</h4>
                                <small class="text-muted">Tingkat Verifikasi</small>
                            @else
                                <h4 class="text-muted mb-1">0%</h4>
                                <small class="text-muted">Belum ada data</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        @if($totalOrders > 0)
                            <h4 class="text-primary mb-1">{{ number_format($totalRevenue / $totalOrders, 0) }}</h4>
                            <small class="text-muted">Avg. Order Value</small>
                        @else
                            <h4 class="text-muted mb-1">0</h4>
                            <small class="text-muted">Belum ada order</small>
                        @endif
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h4 class="{{ $pendingPayments > 0 ? 'text-warning' : 'text-muted' }} mb-1">{{ $pendingPayments }}</h4>
                            <small class="text-muted">{{ $pendingPayments > 0 ? 'Perlu Verifikasi' : 'Semua Clear' }}</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        @if($dailyAverage > 0)
                            <h4 class="text-info mb-1">{{ number_format($monthlyRevenue / max($dailyAverage, 1), 0) }}</h4>
                            <small class="text-muted">Hari Aktif</small>
                        @else
                            <h4 class="text-muted mb-1">0</h4>
                            <small class="text-muted">Belum aktif</small>
                        @endif
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="fw-semibold mb-3">Target Bulanan</h6>
                    @php
                        $monthlyTarget = 50000000; // 50 juta target
                        $progressPercentage = $monthlyRevenue > 0 ? min(($monthlyRevenue / $monthlyTarget) * 100, 100) : 0;
                    @endphp
                    @if($monthlyRevenue > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Progress</small>
                            <small class="fw-semibold">{{ number_format($progressPercentage, 1) }}%</small>
                        </div>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-gradient" style="width: {{ $progressPercentage }}%; background: linear-gradient(90deg, #8E1616, #D2691E);"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</small>
                            <small class="text-muted">Rp {{ number_format($monthlyTarget, 0, ',', '.') }}</small>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada pendapatan bulan ini</p>
                            <small class="text-muted">Target: Rp {{ number_format($monthlyTarget, 0, ',', '.') }}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Payments -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold"> Pembayaran Terbaru</h5>
                    <small class="text-muted">10 transaksi pembayaran terbaru</small>
                </div>
                <a href="{{ route('admin.finance.payments.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayments as $payment)
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-semibold">{{ $payment->order->order_number }}</span>
                                        @if($payment->sender_name)
                                            <br><small class="text-muted">{{ $payment->sender_name }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                            {{ strtoupper(substr($payment->order->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="fw-semibold">{{ $payment->order->user->name }}</span>
                                            <br><small class="text-muted">{{ $payment->order->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $payment->payment_method_label }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $payment->status_badge_class }}">{{ ucfirst($payment->status) }}</span>
                                </td>
                                <td>
                                    <div>
                                        <span>{{ $payment->created_at->format('d/m/Y') }}</span>
                                        <br><small class="text-muted">{{ $payment->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.finance.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    Belum ada pembayaran
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Chart Colors
const colors = {
    red: '#8E1616',
    orange: '#D2691E',
    brown: '#A0522D',
    gold: '#B8860B',
    blue: '#2196f3',
    green: '#4caf50',
    purple: '#9c27b0',
    teal: '#009688',
    warning: '#ffc107',
    success: '#198754',
    info: '#0dcaf0'
};

// 1. Revenue Trend Chart (Line) - Fixed 7 days
try {
    const revenueTrendCtx = document.getElementById('revenueTrendChart').getContext('2d');
    
    const revenueTrendChart = new Chart(revenueTrendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($revenueTrendLabels) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($revenueTrendData) !!},
            borderColor: colors.red,
            backgroundColor: colors.red + '20',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: colors.red,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
} catch (error) {
    console.error('Error creating revenue trend chart:', error);
}

// 2. Revenue by Category Chart (Bar)
@if(count($categoryData) > 0)
try {
    const categoryCtx = document.getElementById('categoryRevenueChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($categoryData) !!},
                backgroundColor: [
                    colors.red,
                    colors.orange,
                    colors.brown,
                    colors.gold,
                    colors.blue,
                    colors.green,
                    colors.purple,
                    colors.teal
                ],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
} catch (error) {
    console.error('Error creating category chart:', error);
}
@endif

// 3. Average Order Value Chart (Line)
try {
    const avgOrderCtx = document.getElementById('avgOrderChart').getContext('2d');
    new Chart(avgOrderCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($avgOrderLabels) !!},
            datasets: [{
                label: 'Rata-rata Order (Rp)',
                data: {!! json_encode($avgOrderData) !!},
                borderColor: colors.gold,
                backgroundColor: colors.gold + '20',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: colors.gold,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            return 'Rata-rata: Rp ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
} catch (error) {
    console.error('Error creating avg order chart:', error);
}

// 4. Monthly Revenue Chart (Bar)
@if(array_sum($monthlyRevenueData) > 0)
const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
new Chart(monthlyRevenueCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyRevenueLabels) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($monthlyRevenueData) !!},
            backgroundColor: colors.brown,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
@endif

// Auto refresh every 5 minutes
setInterval(function() {
    location.reload();
}, 300000);
</script>
@endpush