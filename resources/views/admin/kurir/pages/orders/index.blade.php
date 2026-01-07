@extends('admin.admin')

@section('title', 'Daftar Pesanan Kurir')
@section('page-title', 'Daftar Pesanan Kurir')

@section('content')
<!-- Filter & Search -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.kurir.orders.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>Siap Kirim</option>
                        <option value="on_delivery" {{ request('status') === 'on_delivery' ? 'selected' : '' }}>Dalam Pengiriman</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kurir</label>
                    <select name="kurir" class="form-select">
                        <option value="">Semua Kurir</option>
                        <option value="mine" {{ request('kurir') === 'mine' ? 'selected' : '' }}>Pesanan Saya</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Kirim</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Pilih tanggal...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.kurir.orders.index') }}" class="btn btn-outline-secondary btn-sm">
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
                <h5 class="mb-0 fw-bold">🚚 Daftar Pesanan</h5>
                <small class="text-muted">{{ $orders->total() }} pesanan ditemukan</small>
            </div>
            <div>
                <a href="{{ route('admin.kurir.dashboard') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
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
                            <th>Area & Alamat</th>
                            <th>Tanggal & Waktu</th>
                            <th>Status</th>
                            <th>Kurir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <div>
                                    <span class="fw-semibold">{{ $order->order_number }}</span>
                                    <br><small class="text-muted">{{ $order->orderItems->sum('quantity') }} item</small>
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
                                    <span class="fw-semibold">{{ $order->deliveryArea->name ?? 'Area tidak diketahui' }}</span>
                                    <br><small class="text-muted">{{ Str::limit($order->delivery_address, 30) }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span>
                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($order->delivery_time)->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                @if($order->status === 'ready')
                                    <span class="badge bg-success">Siap Kirim</span>
                                @elseif($order->status === 'on_delivery')
                                    <span class="badge bg-info">Dalam Pengiriman</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge bg-dark">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($order->kurir)
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 24px; height: 24px; font-size: 10px;">
                                            {{ strtoupper(substr($order->kurir->name, 0, 1)) }}
                                        </div>
                                        <small>{{ $order->kurir->name }}</small>
                                    </div>
                                @else
                                    <small class="text-muted">Belum ditugaskan</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.kurir.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->status === 'ready')
                                        <form action="{{ route('admin.kurir.orders.take', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" title="Ambil Pesanan">
                                                <i class="fas fa-hand-paper"></i>
                                            </button>
                                        </form>
                                    @elseif($order->status === 'on_delivery' && $order->assigned_kurir_id === auth()->id())
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#completeModal{{ $order->id }}" title="Selesaikan Pengiriman">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Complete Delivery Modal -->
                        @if($order->status === 'on_delivery' && $order->assigned_kurir_id === auth()->id())
                        <div class="modal fade" id="completeModal{{ $order->id }}" tabindex="-1">
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