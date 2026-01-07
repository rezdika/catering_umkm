@extends('admin.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-red);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Total Menu</h6>
                        <h3 class="mb-0 fw-bold">{{ $activeMenus ?? 0 }}</h3>
                        <small class="opacity-75">{{ $lowStockMenus ?? 0 }} stock rendah</small>
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
                        <h6 class="card-title mb-1">Total Pengguna</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalUsers ?? 0 }}</h3>
                        <small class="opacity-75">+{{ $newUsersToday ?? 0 }} hari ini</small>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-brown);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Pesan Masuk</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalContacts ?? 0 }}</h3>
                        <small class="opacity-75">{{ $unreadContacts ?? 0 }} belum dibaca</small>
                    </div>
                    <i class="fas fa-envelope fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: var(--stat-gold);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title mb-1">Kategori Aktif</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalCategories ?? 0 }}</h3>
                        <small class="opacity-75">Data master</small>
                    </div>
                    <i class="fas fa-tags fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="row mb-4">
    <!-- Menu by Category Chart -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Menu per Kategori</h5>
                <small class="text-muted">Distribusi menu berdasarkan kategori</small>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- User Growth Chart -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Pertumbuhan Pengguna</h5>
                <small class="text-muted">Registrasi pengguna 7 hari terakhir</small>
            </div>
            <div class="card-body">
                <canvas id="userGrowthChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="row mb-4">
    <!-- Order Status Chart -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Status Pesanan</h5>
                <small class="text-muted">Distribusi status pesanan saat ini</small>
            </div>
            <div class="card-body">
                <canvas id="orderStatusChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Contact Types Chart -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Jenis Pesan Kontak</h5>
                <small class="text-muted">Kategori pesan dari pelanggan</small>
            </div>
            <div class="card-body">
                <canvas id="contactTypesChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 3 -->
<div class="row mb-4">
    <!-- Menu Stock Chart -->
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Stock Menu</h5>
                <small class="text-muted">Monitoring stock menu aktif</small>
            </div>
            <div class="card-body">
                <canvas id="stockChart" height="150"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Ringkasan Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: #f8f9fa;">
                    <div>
                        <h6 class="mb-0 fw-semibold">Menu Aktif</h6>
                        <small class="text-muted">Total menu tersedia</small>
                    </div>
                    <span class="badge bg-success fs-6">{{ $activeMenus }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: #f8f9fa;">
                    <div>
                        <h6 class="mb-0 fw-semibold">Stock Rendah</h6>
                        <small class="text-muted">Menu < 10 stock</small>
                    </div>
                    <span class="badge bg-warning fs-6">{{ $lowStockMenus }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded" style="background: #f8f9fa;">
                    <div>
                        <h6 class="mb-0 fw-semibold">Pesan Baru</h6>
                        <small class="text-muted">Belum dibaca</small>
                    </div>
                    <span class="badge bg-info fs-6">{{ $unreadContacts }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background: #f8f9fa;">
                    <div>
                        <h6 class="mb-0 fw-semibold">User Baru</h6>
                        <small class="text-muted">Hari ini</small>
                    </div>
                    <span class="badge bg-primary fs-6">{{ $newUsersToday }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- Recent Activities -->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Aktivitas Terbaru</h5>
                <small class="text-muted">Pesanan terbaru</small>
            </div>
            <div class="card-body">
                @forelse($recentOrders ?? [] as $order)
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background: #f8f9fa;">
                    <div>
                        <h6 class="mb-1 fw-semibold">{{ $order->order_number }}</h6>
                        <small class="text-muted d-block">{{ $order->user->name }}</small>
                        <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                    </div>
                    <span class="badge bg-{{ 
                        $order->status === 'pending' ? 'warning' : 
                        ($order->status === 'confirmed' ? 'info' : 'success')
                    }}">{{ ucfirst($order->status) }}</span>
                </div>
                @empty
                <p class="text-muted text-center">Belum ada pesanan</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Pengguna Baru</h5>
                <small class="text-muted">Registrasi terbaru</small>
            </div>
            <div class="card-body">
                @forelse($recentUsers ?? [] as $user)
                <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: #f8f9fa;">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center">Belum ada pengguna baru</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Pesan Terbaru</h5>
                <small class="text-muted">Kontak dari pelanggan</small>
            </div>
            <div class="card-body">
                @forelse($recentContacts ?? [] as $contact)
                <div class="d-flex align-items-center mb-3 p-2 rounded" style="background: #f8f9fa;">
                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-envelope text-info"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-semibold">{{ $contact->name }}</h6>
                        <small class="text-muted d-block">{{ $contact->subject }}</small>
                        <small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center">Belum ada pesan</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Chart Colors
const colors = {
    red: '#8E1616',
    orange: '#D2691E',
    brown: '#A0522D',
    gold: '#B8860B',
    blue: '#2196f3',
    green: '#4caf50',
    purple: '#9c27b0',
    teal: '#009688'
};

// 1. Menu by Category Chart (Doughnut)
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($menusByCategory->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($menusByCategory->pluck('menus_count')) !!},
            backgroundColor: [colors.red, colors.orange, colors.brown, colors.gold, colors.blue],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// 2. User Growth Chart (Line)
const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
new Chart(userGrowthCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($userGrowthLabels) !!},
        datasets: [{
            label: 'Pengguna Baru',
            data: {!! json_encode($userGrowthData) !!},
            borderColor: colors.blue,
            backgroundColor: colors.blue + '20',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 3. Order Status Chart (Polar Area)
const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
new Chart(orderStatusCtx, {
    type: 'polarArea',
    data: {
        labels: ['Pending', 'Confirmed', 'Preparing', 'Ready', 'Delivered', 'Cancelled'],
        datasets: [{
            data: [
                {{ $orderStatusData['pending'] }},
                {{ $orderStatusData['confirmed'] }},
                {{ $orderStatusData['preparing'] }},
                {{ $orderStatusData['ready'] }},
                {{ $orderStatusData['delivered'] }},
                {{ $orderStatusData['cancelled'] }}
            ],
            backgroundColor: [
                '#ffc107', colors.blue, colors.orange, colors.green, colors.teal, '#dc3545'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// 4. Contact Types Chart (Bar)
const contactTypesCtx = document.getElementById('contactTypesChart').getContext('2d');
new Chart(contactTypesCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($contactTypes)) !!},
        datasets: [{
            label: 'Jumlah Pesan',
            data: {!! json_encode(array_values($contactTypes)) !!},
            backgroundColor: [colors.red, colors.orange, colors.green, colors.purple, colors.brown],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// 5. Menu Stock Chart (Horizontal Bar)
const stockCtx = document.getElementById('stockChart').getContext('2d');
new Chart(stockCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($menuStockData->pluck('name')->take(10)) !!},
        datasets: [{
            label: 'Stock',
            data: {!! json_encode($menuStockData->pluck('stock')->take(10)) !!},
            backgroundColor: function(context) {
                const value = context.parsed.x;
                return value < 10 ? '#dc3545' : value < 20 ? '#ffc107' : colors.green;
            },
            borderRadius: 4
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush