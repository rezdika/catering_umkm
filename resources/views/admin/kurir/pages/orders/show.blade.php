@extends('admin.admin')

@section('title', 'Detail Pesanan - ' . $order->order_number)
@section('page-title', 'Detail Pesanan')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="row">
    <!-- Order Info -->
    <div class="col-xl-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $order->order_number }}</h5>
                        <small class="text-muted">Detail pesanan untuk pengiriman</small>
                    </div>
                    <div>
                        @if($order->status === 'ready')
                            <span class="badge bg-success fs-6">Siap Kirim</span>
                        @elseif($order->status === 'on_delivery')
                            <span class="badge bg-info fs-6">Dalam Pengiriman</span>
                        @elseif($order->status === 'completed')
                            <span class="badge bg-dark fs-6">Selesai</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Customer Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">👤 Informasi Customer</h6>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </div>
                        </div>
                        @if($order->user->phone)
                            <p class="mb-1"><i class="fas fa-phone text-muted me-2"></i>{{ $order->user->phone }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">📍 Informasi Pengiriman</h6>
                        <p class="mb-1"><strong>Area:</strong> {{ $order->deliveryArea->name }}</p>
                        <p class="mb-1"><strong>Tipe:</strong> {{ $order->deliveryType->name }}</p>
                        <p class="mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->delivery_date)->format('d F Y') }}</p>
                        <p class="mb-1"><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($order->delivery_time)->format('H:i') }}</p>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">🏠 Alamat Pengiriman</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $order->delivery_address }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">🍽️ Item Pesanan</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->menu->name }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $item->menu->category->name }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $item->quantity }}x</span>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="4">Subtotal</th>
                                    <th class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Ongkir</th>
                                    <th class="text-end">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Notes -->
                @if($order->notes)
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">📝 Catatan</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Delivery Photo -->
                @if($order->delivery_photo && $order->status === 'completed')
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">📸 Bukti Pengiriman</h6>
                    <div class="text-center">
                        <img src="{{ Storage::url($order->delivery_photo) }}" alt="Bukti Pengiriman" class="img-fluid rounded shadow" style="max-height: 300px;">
                        <br><small class="text-muted mt-2 d-block">Foto diambil saat pengiriman selesai</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="col-xl-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Aksi Pengiriman</h5>
            </div>
            <div class="card-body">
                @if($order->status === 'ready')
                    <div class="alert alert-success">
                        <i class="fas fa-box me-2"></i>
                        <strong>Pesanan Siap Kirim!</strong><br>
                        <small>Pesanan sudah siap dari dapur dan menunggu untuk dikirim.</small>
                    </div>
                    
                    <form action="{{ route('admin.kurir.orders.take', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success w-100 mb-3">
                            <i class="fas fa-hand-paper me-2"></i>Ambil Pesanan Ini
                        </button>
                    </form>
                @elseif($order->status === 'on_delivery')
                    <div class="alert alert-info">
                        <i class="fas fa-motorcycle me-2"></i>
                        <strong>Dalam Pengiriman</strong><br>
                        <small>Kurir: {{ $order->kurir->name ?? 'Tidak diketahui' }}</small>
                    </div>
                    
                    @if($order->assigned_kurir_id === auth()->id())
                        <button type="button" class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#completeModal">
                            <i class="fas fa-check me-2"></i>Selesaikan Pengiriman
                        </button>
                    @else
                        <div class="alert alert-warning">
                            <small>Pesanan ini sedang ditangani oleh kurir lain.</small>
                        </div>
                    @endif
                @elseif($order->status === 'completed')
                    <div class="alert alert-dark">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Pesanan Selesai</strong><br>
                        <small>Kurir: {{ $order->kurir->name ?? 'Tidak diketahui' }}</small>
                    </div>
                @endif

                <!-- Navigation -->
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.kurir.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                    <a href="{{ route('admin.kurir.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Delivery Info -->
        @if($order->kurir)
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white border-0">
                <h6 class="mb-0 fw-bold">Info Kurir</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                        {{ strtoupper(substr($order->kurir->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $order->kurir->name }}</div>
                        <small class="text-muted">Kurir</small>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Complete Delivery Modal -->
@if($order->status === 'on_delivery' && $order->assigned_kurir_id === auth()->id())
<div class="modal fade" id="completeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Selesaikan Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kurir.orders.complete', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Apakah Anda yakin pesanan <strong>{{ $order->order_number }}</strong> sudah berhasil dikirim?</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Foto Bukti Pengiriman <span class="text-danger">*</span></label>
                        <input type="file" name="delivery_photo" class="form-control" accept="image/*" required>
                        <small class="text-muted">Upload foto sebagai bukti pengiriman (JPG, PNG, max 2MB)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan Pengiriman (Opsional)</label>
                        <textarea name="delivery_notes" class="form-control" rows="3" placeholder="Contoh: Diterima langsung oleh customer, kondisi baik"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Selesaikan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection