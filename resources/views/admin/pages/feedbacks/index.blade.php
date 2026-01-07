@extends('admin.admin')

@section('title', 'Saran & Kritik')
@section('page-title', 'Saran & Kritik')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-red);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total Feedback</h6>
                        <h3 class="mb-0 fw-bold">{{ $feedbacks->total() }}</h3>
                    </div>
                    <i class="fas fa-comments fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-orange);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Saran</h6>
                        <h3 class="mb-0 fw-bold">{{ $feedbacks->filter(function($f) { return stripos($f->subject . ' ' . $f->message, 'saran') !== false; })->count() }}</h3>
                    </div>
                    <i class="fas fa-lightbulb fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-brown);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Kritik</h6>
                        <h3 class="mb-0 fw-bold">{{ $feedbacks->filter(function($f) { return stripos($f->subject . ' ' . $f->message, 'kritik') !== false; })->count() }}</h3>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-gold);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Sudah Ditanggapi</h6>
                        <h3 class="mb-0 fw-bold">{{ $feedbacks->where('status', 'replied')->count() }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 fw-bold text-dark">Daftar Saran & Kritik</h5>
        <p class="text-muted mb-0">Feedback dari pelanggan untuk perbaikan layanan</p>
    </div>
</div>

<!-- Feedbacks Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-dark">Pengirim</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Jenis</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Pesan</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Status</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Tanggal</th>
                        <th class="px-4 py-3 fw-semibold text-dark text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                    <tr class="border-bottom">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $feedback->name }}</h6>
                                    <small class="text-muted">{{ $feedback->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if(stripos($feedback->subject . ' ' . $feedback->message, 'saran') !== false)
                                <span class="badge bg-info bg-opacity-10 text-info border border-info">Saran</span>
                            @elseif(stripos($feedback->subject . ' ' . $feedback->message, 'kritik') !== false)
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Kritik</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">Feedback</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <div class="fw-semibold mb-1">{{ $feedback->subject }}</div>
                                <small class="text-muted">{{ Str::limit($feedback->message, 60) }}</small>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-{{ 
                                $feedback->status === 'new' ? 'warning' : 
                                ($feedback->status === 'replied' ? 'success' : 'secondary')
                            }} bg-opacity-10 text-{{ 
                                $feedback->status === 'new' ? 'warning' : 
                                ($feedback->status === 'replied' ? 'success' : 'secondary')
                            }} border border-{{ 
                                $feedback->status === 'new' ? 'warning' : 
                                ($feedback->status === 'replied' ? 'success' : 'secondary')
                            }}">
                                {{ $feedback->status === 'new' ? 'Baru' : ($feedback->status === 'replied' ? 'Ditanggapi' : 'Dibaca') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted">{{ $feedback->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.contacts.show', $feedback) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $feedback) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus feedback ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-comments fa-3x mb-3 opacity-50"></i>
                                <p class="mb-0">Belum ada saran & kritik</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($feedbacks->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $feedbacks->links() }}
        </div>
        @endif
    </div>
</div>
@endsection