@extends('admin.admin')

@section('title', 'Kelola Menu')
@section('page-title', 'Kelola Menu')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-red);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total Menu</h6>
                        <h3 class="mb-0 fw-bold">{{ $menus->total() }}</h3>
                    </div>
                    <i class="fas fa-hamburger fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-orange);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Menu Aktif</h6>
                        <h3 class="mb-0 fw-bold">{{ $menus->where('is_active', true)->count() }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-brown);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Harga Rata-rata</h6>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($menus->avg('price') ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-gold);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Menu Tidak Aktif</h6>
                        <h3 class="mb-0 fw-bold">{{ $menus->where('is_active', false)->count() }}</h3>
                    </div>
                    <i class="fas fa-eye-slash fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1 fw-bold text-dark">Daftar Menu</h5>
        <p class="text-muted mb-0">Kelola menu makanan dan minuman untuk pelanggan</p>
    </div>
    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Menu
    </a>
</div>

<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.menus.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama menu atau deskripsi..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Tersedia</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Tersedia</option>
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

<!-- Menus Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-dark">Menu</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Kategori</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Harga</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Stock</th>
                        <th class="px-4 py-3 fw-semibold text-dark">Status</th>
                        <th class="px-4 py-3 fw-semibold text-dark text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr class="border-bottom">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                @if($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $menu->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($menu->description, 50) }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">{{ $menu->category->name }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="fw-semibold text-success">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-{{ $menu->stock > 10 ? 'success' : ($menu->stock > 0 ? 'warning' : 'danger') }} bg-opacity-10 text-{{ $menu->stock > 10 ? 'success' : ($menu->stock > 0 ? 'warning' : 'danger') }} border border-{{ $menu->stock > 10 ? 'success' : ($menu->stock > 0 ? 'warning' : 'danger') }}">
                                {{ $menu->stock ?? 0 }} pcs
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="badge bg-{{ $menu->is_active ? 'success' : 'danger' }} bg-opacity-10 text-{{ $menu->is_active ? 'success' : 'danger' }} border border-{{ $menu->is_active ? 'success' : 'danger' }}">
                                {{ $menu->is_active ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus menu ini?')">
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
                                <i class="fas fa-hamburger fa-3x mb-3 opacity-50"></i>
                                <p class="mb-0">Belum ada menu</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($menus->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $menus->links() }}
        </div>
        @endif
    </div>
</div>
@endsection