@extends('layout.app')
@section('title', 'Laporan Denda')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold"><i class="fas fa-money-bill-wave text-danger me-2"></i>Laporan Denda</h1>
                <p class="text-muted mb-0">Laporan transaksi pengembalian dengan denda keterlambatan</p>
            </div>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.report.index') }}" class="btn btn-outline-secondary fw-semibold">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.report.denda') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-muted small fw-bold text-uppercase">Dari Tanggal</label>
                    <input type="date" name="dari_tanggal" class="form-control form-control-lg bg-light border-0" value="{{ request('dari_tanggal') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small fw-bold text-uppercase">Sampai Tanggal</label>
                    <input type="date" name="sampai_tanggal" class="form-control form-control-lg bg-light border-0" value="{{ request('sampai_tanggal') }}">
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1 fw-semibold">
                            <i class="fas fa-filter me-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.report.denda') }}" class="btn btn-light btn-lg text-muted">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body p-4">
                    <h6 class="text-white-50 text-uppercase fw-bold mb-2">Total Transaksi Denda</h6>
                    <h2 class="fw-bold mb-0">{{ number_format($stats['total_transaksi']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white h-100">
                <div class="card-body p-4">
                    <h6 class="text-white-50 text-uppercase fw-bold mb-2">Total Akumulasi Denda</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($stats['total_denda'], 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                <div class="card-body p-4">
                    <h6 class="text-dark-50 text-uppercase fw-bold mb-2">Denda Bulan Ini</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($stats['denda_bulan_ini'], 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="card-title fw-bold mb-0">Data Denda Keterlambatan</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.report.denda.export', request()->all()) }}" class="btn btn-danger fw-semibold" target="_blank">
                    <i class="fas fa-file-pdf me-2"></i> Export PDF
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase">ID / Tanggal</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase">Peminjam</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase">Buku</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase">Tgl Target</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase">Tgl Kembali</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase text-end">Total Denda</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase text-center">Status</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $pengembalian)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="fw-bold d-block text-primary">#{{ $pengembalian->id }}</span>
                                    <small class="text-muted">{{ $pengembalian->created_at->format('d M Y') }}</small>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                        <div>
                                            <span class="fw-semibold d-block">{{ $pengembalian->peminjaman->member->name ?? 'User Terhapus' }}</span>
                                            <small class="text-muted">{{ $pengembalian->peminjaman->member->nim ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="fw-semibold">{{ Str::limit($pengembalian->peminjaman->book->judul ?? 'Buku Terhapus', 30) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark border">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_kembali)->format('d M Y') }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-danger-subtle text-danger">{{ \Carbon\Carbon::parse($pengembalian->tgl_kembali_aktual)->format('d M Y') }}</span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <span class="fw-bold text-danger">Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($pengembalian->status_denda === 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-end">
                                    @if($pengembalian->status_denda === 'belum_lunas')
                                        <form action="{{ route('admin.report.denda.lunas', $pengembalian->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menandai denda ini sebagai LUNAS?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success fw-semibold">
                                                <i class="fas fa-check me-1"></i> Tandai Lunas
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small"><i class="fas fa-check-circle text-success me-1"></i> Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-5 text-center">
                                    <div class="text-muted mb-2"><i class="fas fa-box-open fa-3x"></i></div>
                                    <h5 class="fw-bold">Tidak Ada Data Denda</h5>
                                    <p class="mb-0">Belum ada transaksi pengembalian yang terlambat/memiliki denda pada periode ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($pengembalians->hasPages())
            <div class="card-footer bg-white border-top p-4">
                {{ $pengembalians->links() }}
            </div>
        @endif
    </div>
@endsection
