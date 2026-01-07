@extends('admin.admin')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran - ' . $payment->order->order_number)

@section('content')
<div class="row">
    <!-- Payment Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Pembayaran</h5>
                <span class="badge bg-{{ 
                    $payment->status === 'pending' ? 'warning' : 
                    ($payment->status === 'verified' ? 'success' : 'danger')
                }} fs-6">{{ ucfirst($payment->status) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Order Number:</td>
                                <td>{{ $payment->order->order_number }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Jumlah Pembayaran:</td>
                                <td class="text-success fw-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Metode Pembayaran:</td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Nama Pengirim:</td>
                                <td>{{ $payment->sender_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Tanggal Upload:</td>
                                <td>{{ $payment->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Status:</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $payment->status === 'pending' ? 'warning' : 
                                        ($payment->status === 'verified' ? 'success' : 'danger')
                                    }}">{{ ucfirst($payment->status) }}</span>
                                </td>
                            </tr>
                            @if($payment->verifiedBy)
                            <tr>
                                <td class="fw-semibold">Diverifikasi oleh:</td>
                                <td>{{ $payment->verifiedBy->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Tanggal Verifikasi:</td>
                                <td>{{ $payment->verified_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            @endif
                            @if($payment->notes)
                            <tr>
                                <td class="fw-semibold">Catatan:</td>
                                <td>{{ $payment->notes }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Proof -->
        @if($payment->payment_proof)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bukti Pembayaran</h5>
                <a href="{{ route('admin.finance.payments.download-proof', $payment) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-download me-1"></i>Download
                </a>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $payment->payment_proof) }}" 
                     alt="Bukti Pembayaran" 
                     class="img-fluid rounded shadow"
                     style="max-height: 500px; cursor: pointer;"
                     onclick="showImageModal(this.src)">
                <p class="text-muted mt-2">Klik gambar untuk memperbesar</p>
            </div>
        </div>
        @endif

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment->order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->menu->image)
                                            <img src="{{ asset('storage/' . $item->menu->image) }}" 
                                                 alt="{{ $item->menu->name }}" 
                                                 class="rounded me-3"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <span class="fw-semibold">{{ $item->menu->name }}</span>
                                            <br><small class="text-muted">{{ $item->menu->category->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Subtotal</th>
                                <th>Rp {{ number_format($payment->order->subtotal, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="3">Biaya Pengiriman</th>
                                <th>Rp {{ number_format($payment->order->delivery_fee, 0, ',', '.') }}</th>
                            </tr>
                            <tr class="table-success">
                                <th colspan="3">Total</th>
                                <th>Rp {{ number_format($payment->order->total_amount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions & Customer Info -->
    <div class="col-md-4">
        <!-- Verification Actions -->
        @if($payment->status === 'pending')
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Aksi Verifikasi</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.finance.payments.verify', $payment) }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <select name="status" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="verified">Verifikasi (Terima)</option>
                            <option value="failed">Tolak</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan verifikasi..."></textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i>Proses Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Customer</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold" style="width: 60px; height: 60px; font-size: 24px;">
                        {{ strtoupper(substr($payment->order->user->name, 0, 1)) }}
                    </div>
                </div>
                
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="fw-semibold">Nama:</td>
                        <td>{{ $payment->order->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Email:</td>
                        <td>{{ $payment->order->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Telepon:</td>
                        <td>{{ $payment->order->user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Bergabung:</td>
                        <td>{{ $payment->order->user->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pengiriman</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="fw-semibold">Tipe:</td>
                        <td>{{ $payment->order->deliveryType->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Area:</td>
                        <td>{{ $payment->order->deliveryArea->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Alamat:</td>
                        <td>{{ $payment->order->delivery_address }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Tanggal:</td>
                        <td>{{ $payment->order->delivery_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Waktu:</td>
                        <td>{{ $payment->order->delivery_time }}</td>
                    </tr>
                </table>
                
                @if($payment->order->notes)
                <div class="mt-3">
                    <strong>Catatan Pesanan:</strong>
                    <p class="text-muted mb-0">{{ $payment->order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.finance.payments.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                    @if($payment->payment_proof)
                    <a href="{{ route('admin.finance.payments.download-proof', $payment) }}" class="btn btn-outline-info">
                        <i class="fas fa-download me-1"></i>Download Bukti
                    </a>
                    @endif
                    <a href="{{ route('admin.finance.payments.index', ['search' => $payment->order->user->email]) }}" class="btn btn-outline-primary">
                        <i class="fas fa-search me-1"></i>Pembayaran Customer Ini
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showImageModal(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endpush