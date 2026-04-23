@extends('layout.app')
@section('title', 'Laporan Peminjaman')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">📊 Laporan Peminjaman</h1>
                <p class="text-muted mb-0">Laporan lengkap data peminjaman buku dengan filter dan export</p>
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
                    <p class="text-muted small fw-semibold mb-2">📈 Total Peminjaman</p>
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
                    <p class="text-muted small fw-semibold mb-2">📚 Sedang Dipinjam</p>
                    <h2 class="fw-bold text-info">{{ number_format($stats['diambil'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">✅ Dikembalikan</p>
                    <h2 class="fw-bold text-success">{{ number_format($stats['dikembalikan'] ?? 0) }}</h2>
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
                    <form method="GET" class="row g-3">
                        <div class="col-12 col-md-3">
                            <label class="form-label small fw-semibold">Status</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="">-- Semua Status --</option>
                                <option value="menunggu_konfirmasi" {{ request('status') === 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="diambil" {{ request('status') === 'diambil' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label small fw-semibold">Member</label>
                            <select class="form-select form-select-sm" name="member_id">
                                <option value="">-- Semua Member --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label small fw-semibold">Dari Tanggal</label>
                            <input type="date" class="form-control form-control-sm" name="dari_tanggal" value="{{ request('dari_tanggal') }}">
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label small fw-semibold">Sampai Tanggal</label>
                            <input type="date" class="form-control form-control-sm" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}">
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label small fw-semibold">&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                        <div class="col-12">
                            <form action="{{ route('admin.report.peminjaman.export') }}" method="GET" style="display: inline;">
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
                    </form>
                </div>

                <!-- Table -->
                <div class="card-body p-0">
                    @if($peminjamans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4">No. Antrian</th>
                                        <th>Member</th>
                                        <th>Judul Buku</th>
                                        <th>Tgl Pinjam - Kembali</th>
                                        <th>Status</th>
                                        <th>Tanggal Request</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjamans as $peminjaman)
                                        <tr>
                                            <td class="ps-4 fw-semibold">
                                                <span class="badge bg-primary">{{ $peminjaman->nomor_antrian }}</span>
                                            </td>
                                            <td>{{ $peminjaman->member?->name ?? 'N/A' }}</td>
                                            <td>{{ $peminjaman->judul_buku }}</td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $peminjaman->tgl_pinjam->translatedFormat('d F Y') }} - {{ $peminjaman->tgl_kembali->translatedFormat('d F Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = match($peminjaman->status) {
                                                        'menunggu_konfirmasi' => 'warning',
                                                        'diambil' => 'info',
                                                        'dikembalikan' => 'success',
                                                        'ditolak' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">{{ $peminjaman->statusLabel }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $peminjaman->created_at->translatedFormat('d F Y H:i') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top p-3">
                            {{ $peminjamans->links() }}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center p-5 text-muted">
                            <i class="fas fa-inbox fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">Tidak ada data peminjaman</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
