@extends('admin.admin')

@section('title', 'Laporan Kurir')
@section('page-title', 'Laporan Kurir')

@section('content')
<!-- Filter Tanggal -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.kurir.reports.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary">
            <div class="card-body text-white text-center">
                <h4 class="mb-0">{{ $stats['total_deliveries'] }}</h4>
                <small>Total Pengiriman</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success">
            <div class="card-body text-white text-center">
                <h4 class="mb-0">{{ $stats['completed_deliveries'] }}</h4>
                <small>Selesai Dikirim</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning">
            <div class="card-body text-white text-center">
                <h4 class="mb-0">{{ $stats['on_delivery'] }}</h4>
                <small>Dalam Pengiriman</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info">
            <div class="card-body text-white text-center">
                <h4 class="mb-0">{{ $stats['total_areas'] }}</h4>
                <small>Area Pengiriman</small>
            </div>
        </div>
    </div>
</div>

<!-- Area Populer & Ringkasan -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">🚚 Area Pengiriman Terpopuler</h6>
            </div>
            <div class="card-body">
                @if($stats['popular_areas']->count() > 0)
                    @foreach($stats['popular_areas'] as $areaName => $count)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $areaName }}</span>
                        <span class="badge bg-primary">{{ $count }} pengiriman</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">Tidak ada data area</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">📊 Ringkasan Periode</h6>
            </div>
            <div class="card-body">
                <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                <p><strong>Total Hari:</strong> {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} hari</p>
                <p><strong>Rata-rata per Hari:</strong> {{ $stats['total_deliveries'] > 0 ? round($stats['total_deliveries'] / (\Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1), 1) : 0 }} pengiriman</p>
                <p><strong>Tingkat Penyelesaian:</strong> {{ $stats['total_deliveries'] > 0 ? round(($stats['completed_deliveries'] / $stats['total_deliveries']) * 100, 1) : 0 }}%</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Pengiriman -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-bold">📋 Detail Pengiriman</h6>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Area Pengiriman</th>
                            <th>Alamat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>
                                <div>{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->user->phone ?? 'No phone' }}</small>
                            </td>
                            <td>{{ $order->deliveryArea->name ?? 'Area tidak diketahui' }}</td>
                            <td>
                                <div style="max-width: 200px;">
                                    <small>{{ Str::limit($order->delivery_address, 50) }}</small>
                                </div>
                            </td>
                            <td>
                                @if($order->status === 'ready')
                                    <span class="badge bg-info">Siap Dikirim</span>
                                @elseif($order->status === 'on_delivery')
                                    <span class="badge bg-warning">Dalam Pengiriman</span>
                                @elseif($order->status === 'delivered')
                                    <span class="badge bg-success">Terkirim</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-truck fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak Ada Data</h5>
                <p class="text-muted">Tidak ada pengiriman pada periode yang dipilih</p>
            </div>
        @endif
    </div>
</div>
@endsection