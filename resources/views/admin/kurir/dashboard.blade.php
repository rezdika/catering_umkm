@extends('admin.admin')

@section('title', 'Dashboard Kurir')
@section('page-title', 'Dashboard Kurir')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-8 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">📊 Statistik Pengiriman</h5>
                <small class="text-muted">Ringkasan pesanan hari ini</small>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-3">
                        <small class="text-muted d-block">Siap Kirim</small>
                        <span class="fw-bold text-success">{{ $readyOrders }}</span>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Dalam Perjalanan</small>
                        <span class="fw-bold text-info">{{ $onDeliveryOrders }}</span>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Selesai Hari Ini</small>
                        <span class="fw-bold text-primary">{{ $deliveredToday }}</span>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Total Hari Ini</small>
                        <span class="fw-bold">{{ $totalTodayOrders }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kurir Info Panel -->
    <div class="col-xl-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Informasi Kurir</h5>
                <small class="text-muted">Status & informasi shift</small>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3 mx-auto mb-2" style="width: 80px; height: 80px;">
                        <i class="fas fa-motorcycle text-success fa-2x"></i>
                    </div>
                    <h4 class="mb-0 fw-bold" id="current-time">{{ now()->format('H:i:s') }}</h4>
                    <small class="text-muted">{{ now()->format('d F Y') }}</small>
                </div>
                
                <div class="border-top pt-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">Kurir</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
                <small class="text-muted">Navigasi cepat ke fitur utama</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-6 mb-3">
                        <a href="{{ route('admin.kurir.orders.index') }}?status=ready" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-box fa-2x mb-2"></i>
                            <span class="fw-semibold">Siap Kirim</span>
                            <small class="text-muted">{{ $readyOrders }} pesanan</small>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 col-6 mb-3">
                        <a href="{{ route('admin.kurir.orders.index') }}?kurir=mine&status=on_delivery" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-motorcycle fa-2x mb-2"></i>
                            <span class="fw-semibold">Pesanan Saya</span>
                            <small class="text-muted">{{ $myOrders->count() }} pesanan</small>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 col-6 mb-3">
                        <a href="{{ route('admin.kurir.orders.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-list-alt fa-2x mb-2"></i>
                            <span class="fw-semibold">Semua Pesanan</span>
                            <small class="text-muted">History & Filter</small>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 col-6 mb-3">
                        <a href="{{ route('admin.kurir.orders.index') }}?status=completed" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <span class="fw-semibold">Selesai</span>
                            <small class="text-muted">{{ $deliveredToday }} hari ini</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Area Summary & My Orders -->
<div class="row">
    <!-- Area Summary -->
    <div class="col-xl-7 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Ringkasan Area Pengiriman</h5>
                <small class="text-muted">Pesanan per area hari ini</small>
            </div>
            <div class="card-body">
                @if($areasSummary->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Area</th>
                                    <th class="text-center">Total Pesanan</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($areasSummary as $area)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $area->area_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info fs-6">{{ $area->total_orders }} pesanan</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: {{ rand(20, 100) }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-map-marker-alt fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Belum Ada Pesanan Hari Ini</h5>
                        <p class="text-muted">Pesanan akan muncul setelah ada yang siap kirim</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- My Orders -->
    <div class="col-xl-5 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Pesanan Saya</h5>
                <small class="text-muted">Pesanan yang sedang saya tangani</small>
            </div>
            <div class="card-body">
                @if($myOrders->count() > 0)
                    @foreach($myOrders as $order)
                    <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $order->order_number }}</div>
                            <small class="text-muted">{{ $order->user->name }} - {{ $order->deliveryArea->area_name }}</small>
                            <div class="mt-1">
                                <small class="text-info">🚚 {{ \Carbon\Carbon::parse($order->delivery_time)->format('H:i') }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ $order->orderItems->sum('quantity') }} item</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted mb-2">Belum Ada Pesanan</h6>
                        <p class="text-muted small">Ambil pesanan yang siap kirim</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection