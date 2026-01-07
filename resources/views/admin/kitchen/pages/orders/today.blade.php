@extends('admin.admin')

@section('title', 'Pesanan Hari Ini')
@section('page-title', 'Pesanan Hari Ini')

@section('content')
<!-- Header Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-warning bg-opacity-10 rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                    <i class="fas fa-clock text-warning fa-lg"></i>
                </div>
                <h5 class="mb-1">{{ $orders->where('status', 'payment_verified')->count() }}</h5>
                <small class="text-muted">Belum Dimulai</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-info bg-opacity-10 rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                    <i class="fas fa-fire text-info fa-lg"></i>
                </div>
                <h5 class="mb-1">{{ $orders->where('status', 'preparing')->count() }}</h5>
                <small class="text-muted">Sedang Diproses</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-success bg-opacity-10 rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                    <i class="fas fa-check-circle text-success fa-lg"></i>
                </div>
                <h5 class="mb-1">{{ $orders->where('status', 'ready')->count() }}</h5>
                <small class="text-muted">Siap Dikirim</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                    <i class="fas fa-truck text-primary fa-lg"></i>
                </div>
                <h5 class="mb-1">{{ $orders->whereIn('status', ['on_delivery', 'delivered'])->count() }}</h5>
                <small class="text-muted">Dalam Pengiriman/Terkirim</small>
            </div>
        </div>
    </div>
</div>

<!-- Orders List -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">📋 Daftar Pesanan Hari Ini</h5>
                <small class="text-muted">{{ now()->format('d F Y') }} - {{ $orders->count() }} pesanan</small>
            </div>
            <div>
                <a href="{{ route('admin.kitchen.orders.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-list me-1"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Menu & Porsi</th>
                            <th>Waktu Kirim</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <div>
                                    <span class="fw-semibold">{{ $order->order_number }}</span>
                                    <br><small class="text-muted">{{ $order->deliveryArea->name ?? 'Area tidak diketahui' }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="fw-semibold">{{ $order->user->name }}</span>
                                        <br><small class="text-muted">{{ $order->user->phone ?? 'No phone' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    @foreach($order->orderItems as $item)
                                        <div class="mb-1">
                                            <span class="fw-semibold">{{ $item->menu->name }}</span>
                                            <span class="badge bg-info ms-1">{{ $item->quantity }}x</span>
                                        </div>
                                    @endforeach
                                    <small class="text-muted">Total: {{ $order->orderItems->sum('quantity') }} porsi</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($order->delivery_time)->format('H:i') }}</span>
                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</small>
                                </div>
                            </td>
                            <td>
                                @if($order->notes)
                                    <div class="bg-light p-2 rounded" style="max-width: 200px;">
                                        <small>{{ Str::limit($order->notes, 50) }}</small>
                                    </div>
                                @else
                                    <small class="text-muted">Tidak ada catatan</small>
                                @endif
                            </td>
                            <td>
                                @if($order->status === 'payment_verified')
                                    <span class="badge bg-warning text-dark">Belum Dimulai</span>
                                @elseif($order->status === 'preparing')
                                    <span class="badge bg-info">Sedang Diproses</span>
                                @elseif($order->status === 'ready')
                                    <span class="badge bg-success">Siap Dikirim</span>
                                @elseif($order->status === 'on_delivery')
                                    <span class="badge bg-primary">Dalam Pengiriman</span>
                                @elseif($order->status === 'delivered')
                                    <span class="badge bg-dark">Terkirim</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.kitchen.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
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
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">Tidak Ada Pesanan Hari Ini</h5>
                <p class="text-muted">Pesanan untuk hari ini akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>
@endsection