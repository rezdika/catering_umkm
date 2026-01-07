@extends('admin.admin')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')

@section('content')
<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Periode</label>
                <select name="period" class="form-select">
                    <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Harian</option>
                    <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Metode Pembayaran</label>
                <select name="payment_method" class="form-select">
                    <option value="">Semua Metode</option>
                    <option value="bank_transfer" {{ $paymentMethod === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="qris" {{ $paymentMethod === 'qris' ? 'selected' : '' }}>QRIS</option>
                    <option value="cod" {{ $paymentMethod === 'cod' ? 'selected' : '' }}>COD</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="verified" {{ $status === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{ route('admin.finance.reports.index') }}" class="btn btn-outline-secondary">Reset Filter</a>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.finance.reports.export', request()->query()) }}" class="btn btn-success">
                    <i class="fas fa-download me-1"></i>Export CSV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-red);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total Pendapatan</h6>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        @if($growthPercentage != 0)
                            <small class="opacity-75">
                                <i class="fas fa-{{ $growthPercentage > 0 ? 'arrow-up text-success' : 'arrow-down text-danger' }}"></i>
                                {{ number_format(abs($growthPercentage), 1) }}% vs periode sebelumnya
                            </small>
                        @endif
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-orange);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total Pesanan</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalOrders) }}</h3>
                        <small class="opacity-75">Dalam periode ini</small>
                    </div>
                    <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-brown);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Rata-rata Order</h6>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
                        <small class="opacity-75">Per transaksi</small>
                    </div>
                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-gold);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total Transaksi</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalTransactions) }}</h3>
                        <small class="opacity-75">Pembayaran</small>
                    </div>
                    <i class="fas fa-credit-card fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Revenue Chart -->
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Tren Pendapatan</h5>
                <small class="text-muted">{{ $period === 'daily' ? 'Harian' : 'Bulanan' }} - {{ $dateFrom }} s/d {{ $dateTo }}</small>
            </div>
            <div class="card-body" style="height: 400px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Analysis Row -->
<div class="row mb-4">
    <!-- Status Analysis -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Analisis Status</h5>
                <small class="text-muted">Distribusi status pembayaran</small>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @foreach($statusStats as $stat)
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: #f8f9fa;">
                    <div>
                        <h6 class="mb-0 fw-semibold">{{ ucfirst($stat->status) }}</h6>
                        <small class="text-muted">{{ $stat->count }} transaksi</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ 
                            $stat->status === 'pending' ? 'warning' : 
                            ($stat->status === 'verified' ? 'success' : 'danger')
                        }} fs-6">{{ $stat->count }}</span>
                        <br><small class="text-muted">Rp {{ number_format($stat->total, 0, ',', '.') }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Top Revenue Days -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Hari Terbaik</h5>
                <small class="text-muted">Pendapatan tertinggi per hari</small>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($topRevenueDays as $index => $day)
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: #f8f9fa;">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width: 30px; height: 30px; font-size: 12px;">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($day->date)->format('d/m/Y') }}</h6>
                            <small class="text-muted">{{ $day->transactions }} transaksi</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-success">Rp {{ number_format($day->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-chart-bar fa-3x mb-3 d-block"></i>
                    Tidak ada data untuk periode ini
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Comparison with Previous Period -->
@if($previousRevenue > 0)
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Perbandingan Periode</h5>
                <small class="text-muted">Perbandingan dengan periode sebelumnya</small>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="p-3">
                            <h6 class="text-muted">Periode Sebelumnya</h6>
                            <h4 class="text-secondary">Rp {{ number_format($previousRevenue, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <h6 class="text-muted">Periode Saat Ini</h6>
                            <h4 class="text-primary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <h6 class="text-muted">Pertumbuhan</h6>
                            <h4 class="text-{{ $growthPercentage >= 0 ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $growthPercentage >= 0 ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                {{ number_format(abs($growthPercentage), 1) }}%
                            </h4>
                        </div>
                    </div>
                </div>
                
                <div class="progress mt-3" style="height: 10px;">
                    @php
                        $maxRevenue = max($totalRevenue, $previousRevenue);
                        $currentPercentage = $maxRevenue > 0 ? ($totalRevenue / $maxRevenue) * 100 : 0;
                        $previousPercentage = $maxRevenue > 0 ? ($previousRevenue / $maxRevenue) * 100 : 0;
                    @endphp
                    <div class="progress-bar bg-secondary" style="width: {{ $previousPercentage }}%"></div>
                    <div class="progress-bar bg-primary" style="width: {{ $currentPercentage - $previousPercentage }}%"></div>
                </div>
                
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted">
                        <span class="badge bg-secondary me-1"></span>Periode Sebelumnya
                    </small>
                    <small class="text-muted">
                        <span class="badge bg-primary me-1"></span>Periode Saat Ini
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
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
    teal: '#009688'
};

// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($revenueChart['labels']) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($revenueChart['data']) !!},
            borderColor: colors.red,
            backgroundColor: colors.red + '20',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: colors.red,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endpush