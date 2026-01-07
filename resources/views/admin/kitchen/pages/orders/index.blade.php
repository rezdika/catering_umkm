@extends('admin.admin')

@section('title', 'Semua Pesanan')
@section('page-title', 'Semua Pesanan')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning">
            <div class="card-body text-white">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Belum Dimulai</h6>
                        <h3 class="mb-0 fw-bold">{{ $orders->where('status', 'payment_verified')->count() }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info">
            <div class="card-body text-white">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Sedang Diproses</h6>
                        <h3 class="mb-0 fw-bold">{{ $orders->where('status', 'preparing')->count() }}</h3>
                    </div>
                    <i class="fas fa-utensils fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success">
            <div class="card-body text-white">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Siap Dikirim</h6>
                        <h3 class="mb-0 fw-bold">{{ $orders->where('status', 'ready')->count() }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary">
            <div class="card-body text-white">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Dalam Pengiriman</h6>
                        <h3 class="mb-0 fw-bold">{{ $orders->where('status', 'on_delivery')->count() }}</h3>
                    </div>
                    <i class="fas fa-truck fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.kitchen.orders.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="payment_verified" {{ request('status') === 'payment_verified' ? 'selected' : '' }}>Belum Dimulai</option>
                        <option value="preparing" {{ request('status') === 'preparing' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>Siap Dikirim</option>
                        <option value="on_delivery" {{ request('status') === 'on_delivery' ? 'selected' : '' }}>Dalam Pengiriman</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Terkirim</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Kirim</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Pilih tanggal...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Order number atau nama customer..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.kitchen.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Orders List -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">📋 Daftar Pesanan</h5>
                <small class="text-muted">{{ $orders->total() }} pesanan ditemukan</small>
            </div>
            <div>
                <a href="{{ route('admin.kitchen.orders.today') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-calendar-day me-1"></i>Hari Ini
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
a                <table class="table table-hover align-middle table-sm">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 15%;">Order</th>
                            <th style="width: 20%;">Customer</th>
                            <th style="width: 25%;">Menu & Porsi</th>
                            <th style="width: 15%;">Tanggal & Waktu</th>
                            <th style="width: 12%;">Status</th>
                            <th style="width: 13%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr style="height: 60px;">
                            <td class="align-middle">
                                <div class="fw-semibold text-truncate" style="max-width: 120px;" title="{{ $order->order_number }}">{{ $order->order_number }}</div>
                                <small class="text-muted text-truncate d-block" style="max-width: 120px;" title="{{ $order->deliveryArea->name ?? 'Area tidak diketahui' }}">{{ $order->deliveryArea->name ?? 'Area tidak diketahui' }}</small>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2 flex-shrink-0" style="width: 28px; height: 28px; font-size: 11px;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-semibold text-truncate" style="max-width: 100px;" title="{{ $order->user->name }}">{{ $order->user->name }}</div>
                                        <small class="text-muted text-truncate d-block" style="max-width: 100px;" title="{{ $order->user->phone ?? 'No phone' }}">{{ $order->user->phone ?? 'No phone' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div>
                                    @php
                                        $firstItem = $order->orderItems->first();
                                        $totalItems = $order->orderItems->count();
                                        $totalQuantity = $order->orderItems->sum('quantity');
                                    @endphp
                                    @if($firstItem)
                                        <span class="fw-semibold text-truncate d-inline-block" style="max-width: 120px;" title="{{ $firstItem->menu->name }}">{{ Str::limit($firstItem->menu->name, 15) }}</span>
                                        <span class="badge bg-info ms-1">{{ $firstItem->quantity }}x</span>
                                        @if($totalItems > 1)
                                            <br><small class="text-muted">+{{ $totalItems - 1 }} menu lainnya</small>
                                        @endif
                                        <br><small class="text-muted">Total: {{ $totalQuantity }} porsi</small>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($order->delivery_time)->format('H:i') }}</small>
                            </td>
                            <td class="align-middle">
                                @if($order->status === 'payment_verified')
                                    <span class="badge bg-warning text-dark">Belum Dimulai</span>
                                @elseif($order->status === 'preparing')
                                    <span class="badge bg-info">Sedang Diproses</span>
                                @elseif($order->status === 'ready')
                                    <span class="badge bg-success">Siap Dikirim</span>
                                @elseif($order->status === 'on_delivery')
                                    <span class="badge bg-primary">Dalam Pengiriman</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge bg-dark">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.kitchen.orders.show', $order) }}" class="btn btn-outline-primary btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->status === 'payment_verified')
                                        <form action="{{ route('admin.kitchen.orders.update-status', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="preparing">
                                            <button type="submit" class="btn btn-warning btn-sm" title="Mulai Proses">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                    @elseif($order->status === 'preparing')
                                        <form action="{{ route('admin.kitchen.orders.update-status', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ready">
                                            <button type="submit" class="btn btn-success btn-sm" title="Tandai Siap">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links('pagination.admin') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">Tidak Ada Pesanan Ditemukan</h5>
                <p class="text-muted">Coba ubah filter atau kata kunci pencarian</p>
            </div>
        @endif
    </div>
</div>
@endsection