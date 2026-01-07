@extends('admin.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Aplikasi')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pengaturan Umum</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Aplikasi</label>
                        <input type="text" name="app_name" class="form-control" 
                               value="{{ $settings['app_name'] ?? 'Catering UMKM' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email Kontak</label>
                        <input type="email" name="contact_email" class="form-control" 
                               value="{{ $settings['contact_email'] ?? 'admin@catering.com' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp_number" class="form-control" 
                               value="{{ $settings['whatsapp_number'] ?? '081234567890' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="3">{{ $settings['address'] ?? '' }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jam Operasional</label>
                        <input type="text" name="operating_hours" class="form-control" 
                               value="{{ $settings['operating_hours'] ?? '08:00 - 22:00' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Minimum Order (Rp)</label>
                        <input type="number" name="minimum_order" class="form-control" 
                               value="{{ $settings['minimum_order'] ?? 50000 }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Biaya Pengiriman Default (Rp)</label>
                        <input type="number" name="default_delivery_fee" class="form-control" 
                               value="{{ $settings['default_delivery_fee'] ?? 10000 }}">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="maintenance_mode" class="form-check-input" id="maintenance_mode" 
                                   value="1" {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="maintenance_mode">
                                Mode Maintenance
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Sistem</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Versi Laravel</small>
                    <div class="fw-bold">{{ app()->version() }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Versi PHP</small>
                    <div class="fw-bold">{{ PHP_VERSION }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Environment</small>
                    <div class="fw-bold">{{ app()->environment() }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Debug Mode</small>
                    <div class="fw-bold">{{ config('app.debug') ? 'Aktif' : 'Nonaktif' }}</div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Timezone</small>
                    <div class="fw-bold">{{ config('app.timezone') }}</div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Cache & Storage</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-sync me-2"></i>Clear Cache
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-broom me-2"></i>Clear View Cache
                    </button>
                    <button type="button" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-route me-2"></i>Clear Route Cache
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection