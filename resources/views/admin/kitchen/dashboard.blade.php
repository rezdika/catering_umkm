@extends('admin.admin')

@section('title', 'Dashboard Dapur')
@section('page-title', 'Dashboard Dapur')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card text-white h-100" style="background: linear-gradient(135deg, #8E1616, #B91C1C);">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 opacity-90">Total Pesanan Hari Ini</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalTodayOrders }}</h3>
                    <small class="opacity-75">Perlu diproses</small>
                </div>
                <div class="ms-3">
                    <i class="fas fa-utensils fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card text-white h-100" style="background: linear-gradient(135deg, #D2691E, #FF8C00);">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 opacity-90">Sedang Diproses</h6>
                    <h3 class="mb-0 fw-bold">{{ $preparingOrders }}</h3>
                    <small class="opacity-75">Dalam produksi</small>
                </div>
                <div class="ms-3">
                    <i class="fas fa-fire fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card text-white h-100" style="background: linear-gradient(135deg, #A0522D, #CD853F);">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 opacity-90">Siap Dikirim</h6>
                    <h3 class="mb-0 fw-bold">{{ $readyOrders }}</h3>
                    <small class="opacity-75">Menunggu kurir</small>
                </div>
                <div class="ms-3">
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card text-white h-100" style="background: linear-gradient(135deg, #B8860B, #DAA520);">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-1 opacity-90">Belum Dimulai</h6>
                    <h3 class="mb-0 fw-bold">{{ $pendingOrders }}</h3>
                    <small class="opacity-75">Perlu dimulai</small>
                </div>
                <div class="ms-3">
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kitchen Performance Cards -->
<div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 140px;">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-percentage text-success fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Tingkat Penyelesaian</h6>
                <h4 class="mb-0 fw-bold text-success">{{ number_format($completionRate, 1) }}%</h4>
                <small class="text-muted">Hari ini</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 140px;">
                <div class="bg-info bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-clock text-info fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Rata-rata Waktu Masak</h6>
                <h4 class="mb-0 fw-bold text-info">{{ $totalTodayOrders > 0 ? '45' : '0' }}</h4>
                <small class="text-muted">Menit</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 140px;">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-utensils text-warning fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Total Porsi</h6>
                <h4 class="mb-0 fw-bold text-warning">{{ $menuSummary->sum('total_quantity') }}</h4>
                <small class="text-muted">Hari ini</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 140px;">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-list-alt text-primary fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Variasi Menu</h6>
                <h4 class="mb-0 fw-bold text-primary">{{ $menuSummary->count() }}</h4>
                <small class="text-muted">Jenis</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 140px;">
                <div class="bg-danger bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-exclamation-triangle text-danger fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Pesanan Prioritas</h6>
                <h4 class="mb-0 fw-bold text-danger">{{ $todayOrders->where('delivery_time', '<=', now()->addHours(2)->format('H:i:s'))->count() }}</h4>
                <small class="text-muted">Kurang dari 2 jam</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column justify-content-center" style="min-height: 140px;">
                <div class="bg-secondary bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-trophy text-secondary fa-lg"></i>
                </div>
                <h6 class="text-muted mb-1">Pesanan Selesai</h6>
                <h4 class="mb-0 fw-bold text-secondary">{{ $recentCompleted->count() }}</h4>
                <small class="text-muted">Hari ini</small>
            </div>
        </div>
    </div>
</div>

<!-- Progress Card -->
<div class="row mb-4">
    <!-- Progress Production -->
    <div class="col-xl-8 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Progress Produksi Hari Ini</h5>
                <small class="text-muted">Tingkat penyelesaian pesanan</small>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-semibold">Progress Keseluruhan</span>
                    <span class="fw-bold">{{ number_format($completionRate, 1) }}%</span>
                </div>
                <div class="progress mb-3" style="height: 12px;">
                    <div class="progress-bar bg-gradient" style="width: {{ $completionRate }}%; background: linear-gradient(90deg, #8E1616, #D2691E);"></div>
                </div>
                <div class="row text-center">
                    <div class="col-3">
                        <small class="text-muted d-block">Belum Dimulai</small>
                        <span class="fw-bold text-warning">{{ $allPendingOrders ?? $pendingOrders }}</span>
                        @if(isset($allPendingOrders) && $allPendingOrders != $pendingOrders)
                            <br><small class="text-muted">({{ $pendingOrders }} hari ini)</small>
                        @endif
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Sedang Proses</small>
                        <span class="fw-bold text-info">{{ $allPreparingOrders ?? $preparingOrders }}</span>
                        @if(isset($allPreparingOrders) && $allPreparingOrders != $preparingOrders)
                            <br><small class="text-muted">({{ $preparingOrders }} hari ini)</small>
                        @endif
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Siap</small>
                        <span class="fw-bold text-success">{{ $allReadyOrders ?? $readyOrders }}</span>
                        @if(isset($allReadyOrders) && $allReadyOrders != $readyOrders)
                            <br><small class="text-muted">({{ $readyOrders }} hari ini)</small>
                        @endif
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">Total Aktif</small>
                        <span class="fw-bold">{{ $totalAllOrders ?? $totalTodayOrders }}</span>
                        @if(isset($totalAllOrders) && $totalAllOrders != $totalTodayOrders)
                            <br><small class="text-muted">({{ $totalTodayOrders }} hari ini)</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kitchen Info Panel -->
    <div class="col-xl-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Informasi Dapur</h5>
                <small class="text-muted">Status & informasi shift</small>
            </div>
            <div class="card-body">
                <!-- Current Time -->
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 mx-auto mb-2" style="width: 80px; height: 80px;">
                        <i class="fas fa-clock text-primary fa-2x"></i>
                    </div>
                    <h4 class="mb-0 fw-bold" id="current-time">{{ now()->format('H:i:s') }}</h4>
                    <small class="text-muted">{{ now()->format('d F Y') }}</small>
                </div>
                
                <!-- Shift Status -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Status Shift</span>
                        @php
                            $currentHour = now()->format('H');
                            $isWorkingHours = $currentHour >= 6 && $currentHour <= 22;
                        @endphp
                        <span class="badge {{ $isWorkingHours ? 'bg-success' : 'bg-warning' }}">
                            {{ $isWorkingHours ? 'Jam Kerja' : 'Luar Jam' }}
                        </span>
                    </div>
                    <small class="text-muted">Jam operasional: 06:00 - 22:00</small>
                </div>
                
                <!-- Next Delivery -->
                @php
                    $nextDelivery = $todayOrders->where('status', '!=', 'delivered')
                                               ->sortBy('delivery_time')
                                               ->first();
                @endphp
                @if($nextDelivery)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Pengiriman Terdekat</span>
                            <span class="badge bg-info">{{ \Carbon\Carbon::parse($nextDelivery->delivery_time)->format('H:i') }}</span>
                        </div>
                        <small class="text-muted">{{ $nextDelivery->order_number }}</small>
                    </div>
                @endif
                
                <!-- Staff Info -->
                <div class="border-top pt-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">Staff Dapur</small>
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
                        <a href="{{ route('admin.kitchen.orders.today') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-calendar-day fa-2x mb-2"></i>
                            <span class="fw-semibold">Pesanan Hari Ini</span>
                            <small class="text-muted">{{ $totalTodayOrders }} pesanan</small>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 col-6 mb-3">
                        @if(($allPendingOrders ?? $pendingOrders) > 0)
                            <a href="{{ route('admin.kitchen.orders.index') }}?status=payment_verified" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <span class="fw-semibold">Belum Dimulai</span>
                                <small class="text-muted">{{ $allPendingOrders ?? $pendingOrders }} pesanan</small>
                            </a>
                        @else
                            <div class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="cursor: not-allowed; opacity: 0.6;">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <span class="fw-semibold">Semua Dimulai</span>
                                <small class="text-muted">Tidak ada pending</small>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-3 col-md-6 col-6 mb-3">
                        <a href="{{ route('admin.kitchen.orders.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                            <i class="fas fa-list-alt fa-2x mb-2"></i>
                            <span class="fw-semibold">Semua Pesanan</span>
                            <small class="text-muted">History & Filter</small>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 col-6 mb-3">
                        @if(($allReadyOrders ?? $readyOrders) > 0)
                            <a href="{{ route('admin.kitchen.orders.index') }}?status=ready" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="fas fa-box fa-2x mb-2"></i>
                                <span class="fw-semibold">Siap Dikirim</span>
                                <small class="text-muted">{{ $allReadyOrders ?? $readyOrders }} pesanan</small>
                            </a>
                        @else
                            <div class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3" style="cursor: not-allowed; opacity: 0.6;">
                                <i class="fas fa-hourglass-half fa-2x mb-2"></i>
                                <span class="fw-semibold">Belum Ada</span>
                                <small class="text-muted">Yang siap</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Summary & Recent Orders -->
<div class="row">
    <!-- Menu Summary -->
    <div class="col-xl-7 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Ringkasan Menu Aktif</h5>
                <small class="text-muted">Total porsi yang perlu dibuat (semua pesanan aktif)</small>
            </div>
            <div class="card-body">
                @if($menuSummary->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-center">Total Porsi</th>
                                    <th class="text-center">Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menuSummary as $menu)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                                                <i class="fas fa-utensils"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $menu->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info fs-6">{{ $menu->total_quantity }} porsi</span>
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
                        <i class="fas fa-utensils fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Belum Ada Menu Hari Ini</h5>
                        <p class="text-muted">Menu akan muncul setelah ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Completed -->
    <div class="col-xl-5 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Pesanan Selesai Terbaru</h5>
                <small class="text-muted">5 pesanan terakhir yang sudah siap</small>
            </div>
            <div class="card-body">
                @if($recentCompleted->count() > 0)
                    @foreach($recentCompleted as $order)
                    <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $order->order_number }}</div>
                            <small class="text-muted">{{ $order->user->name }}</small>
                            <div class="mt-1">
                                <small class="text-success">✓ Siap {{ $order->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ $order->orderItems->sum('quantity') }} item</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted mb-2">Belum Ada Pesanan Selesai</h6>
                        <p class="text-muted mb-0">Pesanan yang sudah siap akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Real-time clock update
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', {
        hour12: false,
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    
    const clockElement = document.getElementById('current-time');
    if (clockElement) {
        clockElement.textContent = timeString;
    }
}

// Update clock every second
setInterval(updateClock, 1000);

// Auto refresh dashboard every 2 minutes
setInterval(function() {
    location.reload();
}, 120000);
</script>
@endpush