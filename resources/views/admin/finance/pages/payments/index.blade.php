@extends('admin.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Pending</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['pending'] }}</h3>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Verified</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['verified'] }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Failed</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['failed'] }}</h3>
                    </div>
                    <i class="fas fa-times-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Hari Ini</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['today'] }}</h3>
                    </div>
                    <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter & Pencarian</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="payment_method" class="form-select">
                    <option value="">Semua Metode</option>
                    <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="qris" {{ request('payment_method') === 'qris' ? 'selected' : '' }}>QRIS</option>
                    <option value="cod" {{ request('payment_method') === 'cod' ? 'selected' : '' }}>COD</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
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
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari order number atau nama customer..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.finance.payments.index') }}" class="btn btn-outline-secondary">Reset Filter</a>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Actions -->
<div class="card mb-4">
    <div class="card-body">
        <form id="bulkForm" method="POST" action="{{ route('admin.finance.payments.bulk-verify') }}">
            @csrf
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Aksi Massal</label>
                    <select name="status" class="form-select" required>
                        <option value="">Pilih Aksi</option>
                        <option value="verified">Verifikasi</option>
                        <option value="failed">Tolak</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Catatan (Opsional)</label>
                    <input type="text" name="notes" class="form-control" placeholder="Catatan untuk aksi massal...">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-warning w-100" onclick="return confirmBulkAction()">
                        <i class="fas fa-check-double me-1"></i>Proses Terpilih
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Payments Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pembayaran</h5>
        <div>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">
                <i class="fas fa-check-square me-1"></i>Pilih Semua
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                <i class="fas fa-square me-1"></i>Batal Pilih
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleAll()">
                        </th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Verifikator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>
                            <input type="checkbox" name="payment_ids[]" value="{{ $payment->id }}" class="payment-checkbox">
                        </td>
                        <td>
                            <div>
                                <span class="fw-semibold">{{ $payment->order->order_number }}</span>
                                @if($payment->sender_name)
                                    <br><small class="text-muted">Pengirim: {{ $payment->sender_name }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                <span class="fw-semibold">{{ $payment->order->user->name }}</span>
                                <br><small class="text-muted">{{ $payment->order->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ 
                                $payment->status === 'pending' ? 'warning' : 
                                ($payment->status === 'verified' ? 'success' : 'danger')
                            }}">{{ ucfirst($payment->status) }}</span>
                        </td>
                        <td>
                            <div>
                                <span>{{ $payment->created_at->format('d/m/Y') }}</span>
                                <br><small class="text-muted">{{ $payment->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            @if($payment->verifiedBy)
                                <small class="text-muted">
                                    {{ $payment->verifiedBy->name }}
                                    <br>{{ $payment->verified_at->format('d/m/Y H:i') }}
                                </small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.finance.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($payment->payment_proof)
                                    <a href="{{ route('admin.finance.payments.download-proof', $payment) }}" class="btn btn-sm btn-outline-info" title="Download Bukti">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                                @if($payment->status === 'pending')
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="quickVerify({{ $payment->id }}, 'verified')" title="Verifikasi">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="quickVerify({{ $payment->id }}, 'failed')" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Tidak ada data pembayaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Quick Verify Modal -->
<div class="modal fade" id="quickVerifyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="quickVerifyForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" id="quickVerifyStatus">
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan verifikasi..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <span id="quickVerifyMessage"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="quickVerifySubmit">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleAll() {
    const selectAll = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.payment-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function selectAll() {
    document.getElementById('selectAllCheckbox').checked = true;
    toggleAll();
}

function deselectAll() {
    document.getElementById('selectAllCheckbox').checked = false;
    toggleAll();
}

function confirmBulkAction() {
    const selected = document.querySelectorAll('.payment-checkbox:checked');
    if (selected.length === 0) {
        alert('Pilih minimal satu pembayaran untuk diproses');
        return false;
    }
    
    const action = document.querySelector('select[name="status"]').value;
    if (!action) {
        alert('Pilih aksi yang akan dilakukan');
        return false;
    }
    
    const actionText = action === 'verified' ? 'memverifikasi' : 'menolak';
    return confirm(`Apakah Anda yakin ingin ${actionText} ${selected.length} pembayaran terpilih?`);
}

function quickVerify(paymentId, status) {
    const form = document.getElementById('quickVerifyForm');
    const statusInput = document.getElementById('quickVerifyStatus');
    const message = document.getElementById('quickVerifyMessage');
    const submitBtn = document.getElementById('quickVerifySubmit');
    
    form.action = `/admin/finance/payments/${paymentId}/verify`;
    statusInput.value = status;
    
    if (status === 'verified') {
        message.textContent = 'Pembayaran akan diverifikasi dan status order akan diupdate.';
        submitBtn.textContent = 'Verifikasi';
        submitBtn.className = 'btn btn-success';
    } else {
        message.textContent = 'Pembayaran akan ditolak dan status order akan diupdate.';
        submitBtn.textContent = 'Tolak';
        submitBtn.className = 'btn btn-danger';
    }
    
    new bootstrap.Modal(document.getElementById('quickVerifyModal')).show();
}

// Add selected payment IDs to bulk form
document.getElementById('bulkForm').addEventListener('submit', function(e) {
    const selected = document.querySelectorAll('.payment-checkbox:checked');
    
    // Remove existing hidden inputs
    this.querySelectorAll('input[name="payment_ids[]"]').forEach(input => input.remove());
    
    // Add selected IDs
    selected.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'payment_ids[]';
        input.value = checkbox.value;
        this.appendChild(input);
    });
});
</script>
@endpush