@extends('layout.app')
@section('title', 'Laporan Pengunjung')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">👥 Laporan Pengunjung</h1>
                <p class="text-muted mb-0">Laporan statistik pengunjung perpustakaan</p>
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
                    <p class="text-muted small fw-semibold mb-2">📈 Total Pengunjung</p>
                    <h2 class="fw-bold text-primary">{{ number_format($stats['total'] ?? 0) }}</h2>
                    <small class="text-muted">Sejak awal tahun</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">🎓 Mahasiswa</p>
                    <h2 class="fw-bold text-info">{{ number_format($stats['mahasiswa'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">👨‍🏫 Dosen</p>
                    <h2 class="fw-bold text-success">{{ number_format($stats['dosen'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">🌐 Umum</p>
                    <h2 class="fw-bold text-warning">{{ number_format($stats['umum'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">📅 Hari Ini</p>
                    <h2 class="fw-bold text-cyan">{{ number_format($stats['hari_ini'] ?? 0) }}</h2>
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
                            <label class="form-label small fw-semibold">Tipe Pengunjung</label>
                            <select class="form-select form-select-sm" name="tipe_pengunjung">
                                <option value="">-- Semua Tipe --</option>
                                <option value="mahasiswa" {{ request('tipe_pengunjung') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="dosen" {{ request('tipe_pengunjung') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="umum" {{ request('tipe_pengunjung') === 'umum' ? 'selected' : '' }}>Umum</option>
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
                        <div class="col-12">
                            <form action="{{ route('admin.report.pengunjung.export') }}" method="GET" style="display: inline;">
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
                    @if($pengunjungs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4">Nama</th>
                                        <th>NIM / NIDN</th>
                                        <th>Tipe Pengunjung</th>
                                        <th>Tanggal Kunjung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengunjungs as $pengunjung)
                                        <tr>
                                            <td class="ps-4 fw-semibold">{{ $pengunjung->nama }}</td>
                                            <td>{{ $pengunjung->nim ?? $pengunjung->nidn ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $typeClass = match($pengunjung->tipe_pengunjung) {
                                                        'mahasiswa' => 'info',
                                                        'dosen' => 'success',
                                                        'umum' => 'warning',
                                                        default => 'secondary'
                                                    };
                                                    $typeLabel = match($pengunjung->tipe_pengunjung) {
                                                        'mahasiswa' => 'Mahasiswa',
                                                        'dosen' => 'Dosen',
                                                        'umum' => 'Umum',
                                                        default => 'Tidak Diketahui'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $typeClass }}">{{ $typeLabel }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $pengunjung->created_at->translatedFormat('d F Y H:i') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top p-3">
                            {{ $pengunjungs->links() }}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center p-5 text-muted">
                            <i class="fas fa-inbox fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">Tidak ada data pengunjung</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
