@extends('admin.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-red);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total Pengguna</h6>
                        <h3 class="mb-0 fw-bold">{{ $users->total() }}</h3>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-orange);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">User Aktif</h6>
                        <h3 class="mb-0 fw-bold">{{ $users->where('is_active', true)->count() }}</h3>
                    </div>
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-brown);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Admin & Staff</h6>
                        <h3 class="mb-0 fw-bold">{{ $users->whereIn('role', ['admin', 'staff_dapur', 'admin_keuangan', 'kurir'])->count() }}</h3>
                    </div>
                    <i class="fas fa-user-tie fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-gold);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Pelanggan</h6>
                        <h3 class="mb-0 fw-bold">{{ $users->where('role', 'user')->count() }}</h3>
                    </div>
                    <i class="fas fa-user-friends fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 fw-bold text-dark">Daftar Pengguna</h5>
        <p class="text-muted mb-0">Kelola akun pengguna dan hak akses sistem</p>
    </div>
</div>

<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau telepon..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff_dapur" {{ request('role') === 'staff_dapur' ? 'selected' : '' }}>Staff Dapur</option>
                        <option value="admin_keuangan" {{ request('role') === 'admin_keuangan' ? 'selected' : '' }}>Admin Keuangan</option>
                        <option value="kurir" {{ request('role') === 'kurir' ? 'selected' : '' }}>Kurir</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-dark">#</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Pengguna</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Kontak</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Role</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Status</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Bergabung</th>
                        <th class="px-4 py-3 fw-semibold text-dark text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr class="border-bottom">
                        <td class="px-4 py-3">{{ $users->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-muted">{{ $user->phone }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-{{ 
                                $user->role === 'admin' ? 'danger' : 
                                ($user->role === 'user' ? 'primary' : 'info')
                            }} bg-opacity-10 text-{{ 
                                $user->role === 'admin' ? 'danger' : 
                                ($user->role === 'user' ? 'primary' : 'info')
                            }} border border-{{ 
                                $user->role === 'admin' ? 'danger' : 
                                ($user->role === 'user' ? 'primary' : 'info')
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $user->is_active ? 'success' : 'secondary' }} border border-{{ $user->is_active ? 'success' : 'secondary' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                                <p class="mb-0">Belum ada pengguna</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

@foreach($users as $user)
<div class="modal fade" id="editUserModal{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User: {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff_dapur" {{ $user->role === 'staff_dapur' ? 'selected' : '' }}>Staff Dapur</option>
                            <option value="admin_keuangan" {{ $user->role === 'admin_keuangan' ? 'selected' : '' }}>Admin Keuangan</option>
                            <option value="kurir" {{ $user->role === 'kurir' ? 'selected' : '' }}>Kurir</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active{{ $user->id }}" 
                                   value="1" {{ $user->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active{{ $user->id }}">
                                User Aktif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection