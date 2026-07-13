@extends('layout.app')
@section('title', 'Laporan Anggota')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">Laporan Registrasi Anggota</h1>
                <p class="text-muted mb-0">Laporan Data Member Perpustakaan</p>
            </div>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('admin.report.index') }}" class="btn btn-outline-secondary fw-semibold d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.members.import.form') }}" class="btn btn-primary fw-semibold d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%); border: none;">
                <i class="bi bi-file-earmark-spreadsheet-fill"></i> Import Anggota
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">👥 Total Anggota</p>
                    <h2 class="fw-bold text-primary">{{ number_format($stats['total'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">📚 Total Peminjaman</p>
                    <h2 class="fw-bold text-info">{{ number_format($stats['total_peminjaman'] ?? 0) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted small fw-semibold mb-2">📊 Rata-rata Peminjaman/Anggota</p>
                    <h2 class="fw-bold text-warning">{{ number_format(($stats['total_peminjaman'] ?? 0) / max(($stats['total'] ?? 1), 1), 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 m-4 mb-0" role="alert">
                        <h5 class="alert-heading">❌ Error Export PDF</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="card-header bg-light border-bottom p-4">
                    <h5 class="card-title fw-bold mb-3">🔍 Filter & Export</h5>
                    <form method="GET" action="{{ route('admin.report.anggota') }}">
                        <div class="row g-3">
                            <div class="col-12 col-md-3">
                                <label class="form-label small fw-semibold text-muted">Cari (Nama/Email/ID)</label>
                                <input type="text" class="form-control form-control-sm rounded-lg" name="search" placeholder="Cari anggota..." value="{{ request('search') }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label small fw-semibold text-muted">Dari Tanggal</label>
                                <input type="date" class="form-control form-control-sm rounded-lg" name="dari_tanggal" value="{{ request('dari_tanggal') }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label small fw-semibold text-muted">Sampai Tanggal</label>
                                <input type="date" class="form-control form-control-sm rounded-lg" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}">
                            </div>
                            <div class="col-12 col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary btn-sm flex-fill fw-semibold py-2 rounded-lg">
                                    <i class="bi bi-search me-1"></i> Filter
                                </button>
                                <button type="submit" formaction="{{ route('admin.report.anggota.export') }}" class="btn btn-danger btn-sm flex-fill fw-semibold py-2 rounded-lg">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
                                </button>
                            </div>
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
                                        <th>NIM / ID Anggota</th>
                                        <th>Jumlah Peminjaman</th>
                                        <th>Tanggal Daftar</th>
                                        <th class="text-end pe-4">Aksi</th>
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
                                                <small class="text-muted">{{ $member->nim ?? $member->member_id ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <strong class="text-info">{{ number_format($member->peminjamans_count ?? 0) }}</strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($member->created_at)->translatedFormat('d F Y') }}</small>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('admin.members.edit', $member->id) }}" 
                                                       class="btn btn-sm d-inline-flex align-items-center justify-content-center" 
                                                       style="background-color: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE; border-radius: 8px; width: 32px; height: 32px; transition: all 0.2s;"
                                                       title="Edit"
                                                       onmouseover="this.style.backgroundColor='#DBEAFE'"
                                                       onmouseout="this.style.backgroundColor='#EFF6FF'">
                                                        <i class="bi bi-pencil-square" style="font-size: 0.9rem;"></i>
                                                    </a>
                                                    <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Peringatan: Menghapus data anggota juga bisa berakibat pada hilangnya data referensi peminjaman mereka. Yakin ingin menghapus?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm d-inline-flex align-items-center justify-content-center" 
                                                                style="background-color: #FEF2F2; color: #DC2626; border: 1px solid #FCA5A5; border-radius: 8px; width: 32px; height: 32px; transition: all 0.2s;"
                                                                title="Hapus"
                                                                onmouseover="this.style.backgroundColor='#FEE2E2'"
                                                                onmouseout="this.style.backgroundColor='#FEF2F2'">
                                                            <i class="bi bi-trash-fill" style="font-size: 0.9rem;"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
