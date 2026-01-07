@extends('admin.admin')

@section('title', 'Laporan Dapur')
@section('page-title', 'Laporan Dapur')

@section('content')
<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">📊 Laporan Dapur</h4>
        <p class="text-muted mb-0">Analisis produksi dan statistik pesanan dapur</p>
    </div>
    <div>
        <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
            <i class="fas fa-print me-1"></i>Cetak Laporan
        </button>
    </div>
</div>

<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <h6 class="text-white mb-0 fw-semibold"><i class="fas fa-filter me-2"></i>Filter Periode Laporan</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.kitchen.reports.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-search me-2"></i>Tampilkan Laporan
                    </button>
                </div>
                <div class="col-md-3 text-end">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Periode: {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} hari
                    </small>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- KPI Cards -->
<div class="row mb-4">
    <div class="col-md-2 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background-color: #8E1616;">
            <div class="card-body text-white text-center">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2">
                        <i class="fas fa-receipt fa-lg text-dark"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1">{{ number_format($stats['total_orders']) }}</h4>
                <small class="opacity-90">Total Pesanan</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background-color: #D2691E;">
            <div class="card-body text-white text-center">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2">
                        <i class="fas fa-utensils fa-lg text-dark"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1">{{ number_format($stats['total_portions']) }}</h4>
                <small class="opacity-90">Total Porsi</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background-color: #F5F5DC;">
            <div class="card-body text-dark text-center">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-dark bg-opacity-10 rounded-circle p-2">
                        <i class="fas fa-clock fa-lg text-dark"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1">{{ number_format($stats['by_status']['payment_verified']) }}</h4>
                <small class="opacity-75">Belum Dimulai</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background-color: #A0522D;">
            <div class="card-body text-white text-center">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2">
                        <i class="fas fa-fire fa-lg text-dark"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1">{{ number_format($stats['by_status']['preparing']) }}</h4>
                <small class="opacity-90">Sedang Diproses</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background-color: #B8860B;">
            <div class="card-body text-white text-center">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2">
                        <i class="fas fa-check-circle fa-lg text-dark"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1">{{ number_format($stats['by_status']['ready']) }}</h4>
                <small class="opacity-90">Siap Dikirim</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card border-0 shadow-sm h-100" style="background-color: #CD853F;">
            <div class="card-body text-white text-center">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-white bg-opacity-20 rounded-circle p-2">
                        <i class="fas fa-truck fa-lg text-dark"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1">{{ number_format($stats['by_status']['delivered']) }}</h4>
                <small class="opacity-90">Terkirim</small>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Section -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-chart-bar text-primary"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Menu Terpopuler</h6>
                        <small class="text-muted">Berdasarkan jumlah porsi yang dipesan</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($stats['popular_menus']->count() > 0)
                    @foreach($stats['popular_menus'] as $menuName => $quantity)
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-hamburger text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $menuName }}</h6>
                                <small class="text-muted">{{ round(($quantity / $stats['total_portions']) * 100, 1) }}% dari total</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary fs-6 px-3 py-2">{{ number_format($quantity) }} porsi</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Belum ada data menu</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-chart-pie text-success"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Ringkasan Produksi</h6>
                        <small class="text-muted">Periode {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Progress Pesanan</span>
                        <span class="fw-bold text-success">{{ $stats['total_orders'] > 0 ? round((($stats['by_status']['ready'] + $stats['by_status']['delivered']) / $stats['total_orders']) * 100, 1) : 0 }}%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $stats['total_orders'] > 0 ? (($stats['by_status']['ready'] + $stats['by_status']['delivered']) / $stats['total_orders']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="row text-center">
                    <div class="col-6 border-end">
                        <h5 class="fw-bold text-primary mb-0">{{ $stats['total_orders'] > 0 ? round($stats['total_orders'] / (\Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1), 1) : 0 }}</h5>
                        <small class="text-muted">Pesanan/Hari</small>
                    </div>
                    <div class="col-6">
                        <h5 class="fw-bold text-info mb-0">{{ $stats['total_portions'] > 0 ? round($stats['total_portions'] / (\Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1), 1) : 0 }}</h5>
                        <small class="text-muted">Porsi/Hari</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                    <i class="fas fa-table text-info"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Detail Pesanan</h6>
                    <small class="text-muted">{{ number_format($orders->count()) }} pesanan ditemukan</small>
                </div>
            </div>
            <div>
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="fas fa-calendar me-1"></i>
                    {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                </span>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold text-dark border-0 ps-4">Tanggal</th>
                            <th class="fw-semibold text-dark border-0">Order</th>
                            <th class="fw-semibold text-dark border-0">Customer</th>
                            <th class="fw-semibold text-dark border-0">Menu</th>
                            <th class="fw-semibold text-dark border-0">Porsi</th>
                            <th class="fw-semibold text-dark border-0 pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="border-bottom">
                            <td class="ps-4">
                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($order->delivery_time)->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-primary">{{ $order->order_number }}</div>
                                <small class="text-muted">{{ $order->orderItems->count() }} menu</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $order->user->name }}</div>
                                        <small class="text-muted">{{ $order->user->phone ?? 'No phone' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @foreach($order->orderItems as $item)
                                    <div class="mb-1">
                                        <span class="fw-semibold">{{ $item->menu->name }}</span>
                                        <span class="badge bg-info ms-1">{{ $item->quantity }}x</span>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <span class="fw-bold text-primary">{{ $order->orderItems->sum('quantity') }}</span>
                            </td>
                            <td class="pe-4">
                                @if($order->status === 'payment_verified')
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>Belum Dimulai
                                    </span>
                                @elseif($order->status === 'preparing')
                                    <span class="badge bg-info-subtle text-info px-3 py-2">
                                        <i class="fas fa-fire me-1"></i>Sedang Diproses
                                    </span>
                                @elseif($order->status === 'ready')
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Siap Dikirim
                                    </span>
                                @elseif($order->status === 'on_delivery')
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                        <i class="fas fa-truck me-1"></i>Dalam Pengiriman
                                    </span>
                                @elseif($order->status === 'delivered')
                                    <span class="badge bg-dark-subtle text-dark px-3 py-2">
                                        <i class="fas fa-check-double me-1"></i>Terkirim
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-utensils fa-4x text-muted opacity-50"></i>
                </div>
                <h5 class="text-muted fw-semibold">Tidak Ada Data Pesanan</h5>
                <p class="text-muted mb-0">Tidak ada pesanan pada periode yang dipilih</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .sidebar, .navbar, .btn { display: none !important; }
    .main-content { margin-left: 0 !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
</style>
@endpush