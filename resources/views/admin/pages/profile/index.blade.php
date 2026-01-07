@extends('admin.admin')

@section('title', 'Profil')
@section('page-title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="mb-4">
                    <!-- Avatar dengan inisial nama -->
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" 
                         style="width: 120px; height: 120px; background: var(--stat-red); color: white; font-size: 2.5rem; font-weight: bold;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                    </div>
                    <h5 class="mb-1 fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                    <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $user->is_active ? 'success' : 'secondary' }} border border-{{ $user->is_active ? 'success' : 'secondary' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                
                <div class="row text-center mb-4">
                    <div class="col-6">
                        <div class="border-end">
                            <h6 class="mb-0 fw-bold">Bergabung</h6>
                            <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6 class="mb-0 fw-bold">Login Terakhir</h6>
                        <small class="text-muted">{{ $user->updated_at->format('d M Y') }}</small>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="d-grid gap-2">
                    <a href="{{ route('beranda') }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt me-2"></i>Lihat Website
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changeAvatarModal">
                        <i class="fas fa-camera me-2"></i>Ubah Avatar
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold">Statistik Saya</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Menu Dikelola</span>
                    <span class="fw-bold">{{ App\Models\Menu::count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Kategori Aktif</span>
                    <span class="fw-bold">{{ App\Models\Category::where('is_active', true)->count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Pesan Dijawab</span>
                    <span class="fw-bold">{{ App\Models\Contact::where('status', 'replied')->count() }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                        </div>
                    </div>
                    
                    <hr>
                    <h6 class="mb-3">Ubah Password</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection