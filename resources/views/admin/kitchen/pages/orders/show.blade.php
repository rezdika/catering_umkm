@extends('admin.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
<!-- Order Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="fw-bold mb-2">{{ $order->order_number }}</h4>
                        <div class="d-flex align-items-center mb-2">
                            @if($order->status === 'payment_verified')
                                <span class="badge bg-warning me-2">Belum Dimulai</span>
                            @elseif($order->status === 'preparing')
                                <span class="badge bg-info me-2">Sedang Diproses</span>
                            @elseif($order->status === 'ready')
                                <span class="badge bg-success me-2">Siap Dikirim</span>
                            @elseif($order->status === 'on_delivery')
                                <span class="badge bg-primary me-2">Dalam Pengiriman</span>
                            @elseif($order->status === 'delivered')
                                <span class="badge bg-dark me-2">Terkirim</span>
                            @endif
                            <small class="text-muted">Dibuat {{ $order->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($order->delivery_date)->format('d F Y') }} - 
                            {{ \Carbon\Carbon::parse($order->delivery_time)->format('H:i') }}
                        </div>
                    </div>
                    <div class="text-end">
                        @if($order->status === 'payment_verified')
                            <form action="{{ route('admin.kitchen.orders.update-status', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-play me-1"></i>Mulai Proses
                                </button>
                            </form>
                        @elseif($order->status === 'preparing')
                            <form action="{{ route('admin.kitchen.orders.update-status', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-1"></i>Tandai Siap
                                </button>
                            </form>
                        @elseif($order->status === 'ready')
                            <span class="btn btn-outline-success disabled">
                                <i class="fas fa-check-circle me-1"></i>Sudah Siap
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Order Items -->
    <div class="col-xl-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">🍽️ Menu yang Harus Dibuat</h5>
                <small class="text-muted">{{ $order->orderItems->sum('quantity') }} porsi total</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Menu</th>
                                <th>Kategori</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-utensils"></i>
                                        </div>
                                        <div>
                                            <span class="fw-semibold">{{ $item->menu->name }}</span>
                                            @if($item->menu->description)
                                                <br><small class="text-muted">{{ Str::limit($item->menu->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $item->menu->category->name }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info fs-6">{{ $item->quantity }} porsi</span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-semibold">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="2">Total</th>
                                <th class="text-center">{{ $order->orderItems->sum('quantity') }} porsi</th>
                                <th></th>
                                <th class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Info -->
    <div class="col-xl-4 mb-4">
        <!-- Customer Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0">
                <h6 class="mb-0 fw-bold">👤 Informasi Customer</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 50px; height: 50px;">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $order->user->name }}</div>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </div>
                </div>
                @if($order->user->phone)
                    <div class="mb-2">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <span>{{ $order->user->phone }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Delivery Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0">
                <h6 class="mb-0 fw-bold">🚚 Informasi Pengiriman</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Tipe Pengiriman</small>
                    <span class="fw-semibold">{{ $order->deliveryType->name ?? 'Tidak diketahui' }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Area Pengiriman</small>
                    <span class="fw-semibold">{{ $order->deliveryArea->name ?? 'Tidak diketahui' }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Alamat Lengkap</small>
                    <span>{{ $order->delivery_address }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Jadwal Pengiriman</small>
                    <span class="fw-semibold">
                        {{ \Carbon\Carbon::parse($order->delivery_date)->format('d F Y') }}<br>
                        <small>Pukul {{ \Carbon\Carbon::parse($order->delivery_time)->format('H:i') }}</small>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Special Notes -->
        @if($order->notes)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h6 class="mb-0 fw-bold">📝 Catatan Khusus</h6>
            </div>
            <div class="card-body">
                <div class="bg-light p-3 rounded">
                    <i class="fas fa-quote-left text-muted me-2"></i>
                    <span>{{ $order->notes }}</span>
                    <i class="fas fa-quote-right text-muted ms-2"></i>
                </div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                    Harap perhatikan catatan khusus dari customer
                </small>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Back Button -->
<div class="row">
    <div class="col-12">
        <a href="{{ route('admin.kitchen.orders.today') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Pesanan Hari Ini
        </a>
    </div>
</div>
@endsection