@extends('admin.admin')

@section('title', 'Export Laporan')
@section('page-title', 'Export Laporan Keuangan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Export Laporan Keuangan</h5>
                <small class="text-muted">Pilih format dan periode untuk export data</small>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.finance.reports.export') }}">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Format Export</label>
                                <select name="format" class="form-select" required>
                                    <option value="csv">CSV (Comma Separated Values)</option>
                                    <option value="excel">Excel (.xlsx)</option>
                                    <option value="pdf">PDF Report</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Laporan</label>
                                <select name="report_type" class="form-select" required>
                                    <option value="summary">Summary Report</option>
                                    <option value="detailed">Detailed Transactions</option>
                                    <option value="payment_methods">Payment Methods Analysis</option>
                                    <option value="daily">Daily Revenue</option>
                                    <option value="monthly">Monthly Revenue</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="date_from" class="form-control" value="{{ now()->startOfMonth()->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="date_to" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status Pembayaran</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="verified">Hanya Verified</option>
                                    <option value="pending">Hanya Pending</option>
                                    <option value="failed">Hanya Failed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select name="payment_method" class="form-select">
                                    <option value="">Semua Metode</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="qris">QRIS</option>
                                    <option value="cod">Cash on Delivery</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_customer_info" id="includeCustomer" checked>
                            <label class="form-check-label" for="includeCustomer">
                                Sertakan Informasi Customer
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_order_details" id="includeOrder">
                            <label class="form-check-label" for="includeOrder">
                                Sertakan Detail Pesanan
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_charts" id="includeCharts">
                            <label class="form-check-label" for="includeCharts">
                                Sertakan Grafik (Khusus PDF)
                            </label>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong>
                        <ul class="mb-0 mt-2">
                            <li>CSV: Format terbaik untuk analisis data di Excel/Google Sheets</li>
                            <li>Excel: Format lengkap dengan formatting dan multiple sheets</li>
                            <li>PDF: Format untuk presentasi dan arsip</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.finance.reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-download me-1"></i>Download Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Quick Export Buttons -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Export</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('admin.finance.reports.export', ['format' => 'csv', 'report_type' => 'summary', 'date_from' => now()->startOfMonth()->format('Y-m-d'), 'date_to' => now()->format('Y-m-d')]) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-file-csv me-1"></i>Summary Bulan Ini (CSV)
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('admin.finance.reports.export', ['format' => 'excel', 'report_type' => 'detailed', 'date_from' => now()->startOfMonth()->format('Y-m-d'), 'date_to' => now()->format('Y-m-d')]) }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-file-excel me-1"></i>Detail Bulan Ini (Excel)
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('admin.finance.reports.export', ['format' => 'pdf', 'report_type' => 'summary', 'date_from' => now()->startOfYear()->format('Y-m-d'), 'date_to' => now()->format('Y-m-d')]) }}" class="btn btn-outline-danger w-100">
                            <i class="fas fa-file-pdf me-1"></i>Laporan Tahunan (PDF)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection