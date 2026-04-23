@extends('layout.app')
@section('title', 'Laporan Anggota')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">👤 Laporan Anggota</h1>
                <p class="text-muted mb-0">Laporan lengkap data member perpustakaan dengan statistik peminjaman</p>
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
                    <p class="text-muted small fw-semibold mb-2">👥 Total Anggota</p>
                    <h2 class="fw-bold text-primary">{{ number_format($stats['total'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">✅ Aktif</p>
                    <h2 class="fw-bold text-success">{{ number_format($stats['aktif'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">❌ Nonaktif</p>
                    <h2 class="fw-bold text-danger">{{ number_format($stats['nonaktif'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">📚 Total Peminjaman</p>
                    <h2 class="fw-bold text-info">{{ number_format($stats['total_peminjaman'] ?? 0) }}</h2>
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
                            <label class="form-label small fw-semibold">Cari (Nama/Email/ID)</label>
                            <input type="text" class="form-control form-control-sm" name="search" placeholder="Cari anggota..." value="{{ request('search') }}">
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
                        <div class="col-12">
                            <form action="{{ route('admin.report.anggota.export') }}" method="GET" style="display: inline;">
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
                    @if($members->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4">Nama Anggota</th>
                                        <th>Email</th>
                                        <th>No. Identitas</th>
                                        <th>Tipe</th>
                                        <th>Jumlah Peminjaman</th>
                                        <th>Tgl Daftar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $member)
                                        <tr>
                                            <td class="ps-4 fw-semibold">{{ $member->name }}</td>
                                            <td>
                                                <small>{{ $member->email }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $member->no_identitas ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <small class="badge bg-light text-dark">{{ $member->tipe_member ?? 'Regular' }}</small>
                                            </td>
                                            <td>
                                                <strong class="text-info">{{ number_format($member->peminjamans_count ?? 0) }}</strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $member->created_at->translatedFormat('d F Y') }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = match($member->status) {
                                                        'aktif' => 'success',
                                                        'nonaktif' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($member->status ?? 'aktif') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top p-3">
                            {{ $members->links() }}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center p-5 text-muted">
                            <i class="fas fa-inbox fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">Tidak ada data anggota</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
