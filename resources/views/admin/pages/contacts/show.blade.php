@extends('admin.admin')

@section('title', 'Detail Pesan Kontak')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 fw-bold text-dark">Detail Pesan Kontak</h5>
        <p class="text-muted mb-0">Lihat dan balas pesan dari pelanggan</p>
    </div>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Contact Message Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">{{ $contact->subject }}</h6>
                    <span class="badge bg-{{ 
                        $contact->status === 'new' ? 'warning' : 
                        ($contact->status === 'replied' ? 'success' : 'secondary')
                    }}">
                        {{ $contact->status === 'new' ? 'Baru' : ($contact->status === 'replied' ? 'Dibalas' : 'Dibaca') }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-user text-primary fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-semibold">{{ $contact->name }}</h6>
                        <small class="text-muted">{{ $contact->email }}</small>
                        @if($contact->phone)
                        <small class="text-muted d-block">{{ $contact->phone }}</small>
                        @endif
                    </div>
                </div>
                
                <div class="bg-light rounded p-3 mb-3">
                    <p class="mb-0">{{ $contact->message }}</p>
                </div>
                
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Dikirim pada {{ $contact->created_at->format('d F Y, H:i') }}
                </small>
            </div>
        </div>

        <!-- Reply Section -->
        @if($contact->reply_message)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-success bg-opacity-10 border-bottom border-success">
                <h6 class="mb-0 fw-bold text-success">
                    <i class="fas fa-reply me-2"></i>Balasan Anda
                </h6>
            </div>
            <div class="card-body">
                <div class="bg-white border border-success rounded p-3 mb-3">
                    <p class="mb-0">{{ $contact->reply_message }}</p>
                </div>
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Dibalas pada {{ $contact->replied_at->format('d F Y, H:i') }}
                </small>
            </div>
        </div>
        @else
        <!-- Reply Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-bold">Balas Pesan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="reply_message" class="form-label fw-semibold">Pesan Balasan</label>
                        <textarea name="reply_message" id="reply_message" class="form-control" rows="5" 
                                  placeholder="Tulis balasan Anda di sini..." required>{{ old('reply_message') }}</textarea>
                        @error('reply_message')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Balasan
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('reply_message').value=''">
                            <i class="fas fa-eraser me-2"></i>Bersihkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Contact Info Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-bold">Informasi Kontak</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">NAMA</label>
                    <p class="mb-0">{{ $contact->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">EMAIL</label>
                    <p class="mb-0">{{ $contact->email }}</p>
                </div>
                @if($contact->phone)
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">TELEPON</label>
                    <p class="mb-0">{{ $contact->phone }}</p>
                </div>
                @endif
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">SUBJEK</label>
                    <p class="mb-0">{{ $contact->subject }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted small">STATUS</label>
                    <p class="mb-0">
                        <span class="badge bg-{{ 
                            $contact->status === 'new' ? 'warning' : 
                            ($contact->status === 'replied' ? 'success' : 'secondary')
                        }}">
                            {{ $contact->status === 'new' ? 'Baru' : ($contact->status === 'replied' ? 'Dibalas' : 'Dibaca') }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="form-label fw-semibold text-muted small">TANGGAL</label>
                    <p class="mb-0">{{ $contact->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-bold">Aksi</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if(!$contact->reply_message)
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('reply_message').focus()">
                        <i class="fas fa-reply me-2"></i>Balas Pesan
                    </button>
                    @endif
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100" 
                                onclick="return confirm('Yakin hapus pesan ini?')">
                            <i class="fas fa-trash me-2"></i>Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection