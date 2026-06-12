@extends('layout.app')
@section('title', 'Laporan Pengembalian')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">📦 Laporan Pengembalian</h1>
                <p class="text-muted mb-0">Laporan lengkap data pengembalian buku dan denda terlambat</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">📈 Total Pengembalian</p>
                    <h2 class="fw-bold text-primary">{{ number_format($stats['total'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">⏳ Menunggu Konfirmasi</p>
                    <h2 class="fw-bold text-warning">{{ number_format($stats['menunggu_konfirmasi'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">✅ Diterima</p>
                    <h2 class="fw-bold text-success">{{ number_format($stats['diterima'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">💰 Total Denda</p>
                    <h2 class="fw-bold text-danger">Rp {{ number_format($stats['total_denda'] ?? 0, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <!-- Filter Section -->
                <div class="card-header bg-light border-bottom p-4">
                    <h5 class="card-title fw-bold mb-3">🔍 Filter & Export</h5>
                    <div class="row g-3">
                        <form method="GET" class="col-12">
                            <div class="row g-3">
                                <div class="col-12 col-md-3">
                                    <label class="form-label small fw-semibold">Status</label>
                                    <select class="form-select form-select-sm" name="status">
                                        <option value="">-- Semua Status --</option>
                                        <option value="menunggu_konfirmasi" {{ request('status') === 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                        <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label small fw-semibold">Dari Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" name="dari_tanggal" value="{{ request('dari_tanggal') }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label small fw-semibold">Sampai Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label small fw-semibold">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('admin.report.pengembalian.export') }}" method="GET" class="col-12">
                            @foreach(request()->query() as $key => $value)
                                @if($key !== '_token')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body p-0">
                    @if($pengembalians->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 table-sm">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4">No. Antrian</th>
                                        <th>Member</th>
                                        <th>Judul Buku</th>
                                        <th>Tgl Kembali Rencana</th>
                                        <th>Tgl Kembali Aktual</th>
                                        <th>Kondisi</th>
                                        <th>Denda</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengembalians as $pengembalian)
                                        <tr>
                                            <td class="ps-4 fw-semibold">
                                                <span class="badge bg-primary">{{ $pengembalian->peminjaman?->nomor_antrian }}</span>
                                            </td>
                                            <td>{{ $pengembalian->peminjaman?->member?->name }}</td>
                                            <td>{{ $pengembalian->peminjaman?->judul_buku }}</td>
                                            <td>
                                                <small class="text-muted">{{ $pengembalian->peminjaman?->tgl_kembali->translatedFormat('d F Y') }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $pengembalian->tgl_kembali_aktual->translatedFormat('d F Y') }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $kondisiClass = match($pengembalian->kondisi_buku) {
                                                        'baik' => 'success',
                                                        'rusak_ringan' => 'warning',
                                                        'rusak_berat' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                    $kondisiLabel = match($pengembalian->kondisi_buku) {
                                                        'baik' => 'Baik',
                                                        'rusak_ringan' => 'Rusak Ringan',
                                                        'rusak_berat' => 'Rusak Berat',
                                                        default => 'Tidak Diketahui'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $kondisiClass }}">{{ $kondisiLabel }}</span>
                                            </td>
                                            <td>
                                                <strong class="text-danger">Rp {{ number_format($pengembalian->denda ?? 0, 0, ',', '.') }}</strong>
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = match($pengembalian->status) {
                                                        'menunggu_konfirmasi' => 'warning',
                                                        'diterima' => 'success',
                                                        'ditolak' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $pengembalian->status)) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top p-3">
                            {{ $pengembalians->links() }}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center p-5 text-muted">
                            <i class="fas fa-inbox fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">Tidak ada data pengembalian</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
