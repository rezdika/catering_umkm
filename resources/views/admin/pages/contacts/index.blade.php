@extends('admin.admin')

@section('title', 'Pesan Kontak')
@section('page-title', 'Pesan Kontak')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-red);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total Pesan</h6>
                        <h3 class="mb-0 fw-bold">{{ $contacts->total() }}</h3>
                    </div>
                    <i class="fas fa-envelope fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-orange);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Belum Dibaca</h6>
                        <h3 class="mb-0 fw-bold">{{ $contacts->where('status', 'new')->count() }}</h3>
                    </div>
                    <i class="fas fa-envelope-open fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-brown);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Sudah Dibalas</h6>
                        <h3 class="mb-0 fw-bold">{{ $contacts->where('status', 'replied')->count() }}</h3>
                    </div>
                    <i class="fas fa-reply fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-gold);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Hari Ini</h6>
                        <h3 class="mb-0 fw-bold">{{ $contacts->where('created_at', '>=', today())->count() }}</h3>
                    </div>
                    <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 fw-bold text-dark">Daftar Pesan Kontak</h5>
        <p class="text-muted mb-0">Kelola pesan dari pelanggan dan berikan balasan</p>
    </div>
</div>

<!-- Contacts Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-dark">Pengirim</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Subjek</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Pesan</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Status</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Tanggal</th>
                        <th class="px-4 py-3 fw-semibold text-dark text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr class="border-bottom">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $contact->name }}</h6>
                                    <small class="text-muted">{{ $contact->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="fw-semibold">{{ $contact->subject }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-muted">{{ Str::limit($contact->message, 50) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-{{ 
                                $contact->status === 'new' ? 'warning' : 
                                ($contact->status === 'replied' ? 'success' : 'secondary')
                            }} bg-opacity-10 text-{{ 
                                $contact->status === 'new' ? 'warning' : 
                                ($contact->status === 'replied' ? 'success' : 'secondary')
                            }} border border-{{ 
                                $contact->status === 'new' ? 'warning' : 
                                ($contact->status === 'replied' ? 'success' : 'secondary')
                            }}">
                                {{ $contact->status === 'new' ? 'Baru' : ($contact->status === 'replied' ? 'Dibalas' : 'Dibaca') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted">{{ $contact->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus pesan ini?')">
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
                                <i class="fas fa-envelope fa-3x mb-3 opacity-50"></i>
                                <p class="mb-0">Belum ada pesan kontak</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($contacts->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $contacts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection