@extends('layout.app')
@section('title', 'Laporan & Statistik')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">📊 Laporan & Statistik</h1>
                <p class="text-muted mb-0">Dashboard laporan perpustakaan dengan statistik real-time</p>
            </div>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary fw-semibold">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row g-4">
        <!-- Laporan Peminjaman -->
        <div class="col-12 col-md-6 col-lg-3 animate-fade-in-up">
            <a href="{{ route('admin.report.peminjaman') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-reset overflow-hidden hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-circle bg-primary-subtle p-3 flex-shrink-0">
                            <i class="fas fa-clipboard-list fa-lg text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title fw-bold mb-0">Laporan Peminjaman</h5>
                            <small class="text-muted">Riwayat peminjaman buku</small>
                        </div>
                    </div>
                    <p class="text-muted mb-0 small">Lihat data peminjaman dengan filter status, member, dan tanggal. Export ke PDF tersedia.</p>
                    <div class="mt-3 pt-3 border-top border-primary border-opacity-10">
                        <small class="text-primary fw-semibold">Buka Laporan <i class="fas fa-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Laporan Pengembalian -->
        <div class="col-12 col-md-6 col-lg-3 animate-fade-in-up delay-1">
            <a href="{{ route('admin.report.pengembalian') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-reset overflow-hidden hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-circle bg-success-subtle p-3 flex-shrink-0">
                            <i class="fas fa-undo fa-lg text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title fw-bold mb-0">Laporan Pengembalian</h5>
                            <small class="text-muted">Data pengembalian & denda</small>
                        </div>
                    </div>
                    <p class="text-muted mb-0 small">Pantau pengembalian buku, denda keterlambatan, dan status konfirmasi pengembalian.</p>
                    <div class="mt-3 pt-3 border-top border-success border-opacity-10">
                        <small class="text-success fw-semibold">Buka Laporan <i class="fas fa-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Laporan Pengunjung -->
        <div class="col-12 col-md-6 col-lg-3 animate-fade-in-up delay-2">
            <a href="{{ route('admin.report.pengunjung') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-reset overflow-hidden hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-circle bg-info-subtle p-3 flex-shrink-0">
                            <i class="fas fa-users fa-lg text-info"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title fw-bold mb-0">Laporan Pengunjung</h5>
                            <small class="text-muted">Statistik pengunjung</small>
                        </div>
                    </div>
                    <p class="text-muted mb-0 small">Analisis pengunjung harian, mingguan, bulanan. Filter berdasarkan tipe pengunjung dan tanggal.</p>
                    <div class="mt-3 pt-3 border-top border-info border-opacity-10">
                        <small class="text-info fw-semibold">Buka Laporan <i class="fas fa-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <!-- Laporan Anggota -->
        <div class="col-12 col-md-6 col-lg-3 animate-fade-in-up delay-3">
            <a href="{{ route('admin.report.anggota') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-reset overflow-hidden hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-circle bg-warning-subtle p-3 flex-shrink-0">
                            <i class="fas fa-user-tie fa-lg text-warning"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title fw-bold mb-0">Laporan Anggota</h5>
                            <small class="text-muted">Data member perpustakaan</small>
                        </div>
                    </div>
                    <p class="text-muted mb-0 small">Kelola data anggota, status keanggotaan, dan statistik peminjaman per member.</p>
                    <div class="mt-3 pt-3 border-top border-warning border-opacity-10">
                        <small class="text-warning fw-semibold">Buka Laporan <i class="fas fa-arrow-right ms-2"></i></small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom p-4">
                    <h5 class="card-title fw-bold mb-0">📈 Ringkasan Cepat</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 text-center">
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex flex-column align-items-center">
                                <h3 class="fw-bold text-primary mb-1" data-count="0">0</h3>
                                <small class="text-muted">Total Peminjaman</small>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex flex-column align-items-center">
                                <h3 class="fw-bold text-success mb-1" data-count="0">0</h3>
                                <small class="text-muted">Total Pengembalian</small>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex flex-column align-items-center">
                                <h3 class="fw-bold text-info mb-1" data-count="0">0</h3>
                                <small class="text-muted">Total Pengunjung</small>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex flex-column align-items-center">
                                <h3 class="fw-bold text-warning mb-1" data-count="0">0</h3>
                                <small class="text-muted">Total Anggota Aktif</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
