@extends('layout.app')
@section('title', 'Konfirmasi Peminjaman')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">⏳ Konfirmasi Peminjaman</h1>
                <p class="text-muted mb-0">Daftar permohonan peminjaman buku oleh member yang menunggu persetujuan admin</p>
            </div>
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
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-4 text-dark" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-times-circle me-2"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 p-4 pb-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h5 class="card-title fw-bold mb-1">📝 Peminjaman Menunggu Persetujuan</h5>
                            <p class="text-muted small mb-0">Terima peminjaman untuk mengurangi stok buku, atau tolak dengan alasan.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if($peminjamans->count() > 0)
                        <div class="table-responsive d-none d-md-block">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-3">No. Antrian</th>
                                        <th>Peminjam</th>
                                        <th>Detail Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Batas Kembali</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjamans as $peminjaman)
                                        <tr>
                                            <td class="ps-3 fw-semibold">
                                                <span class="badge bg-primary">{{ $peminjaman->nomor_antrian }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $peminjaman->member?->name ?? 'N/A' }}</div>
                                                <div class="small text-muted">
                                                    <div><strong>NIM:</strong> {{ $peminjaman->member?->nim ?? '-' }}</div>
                                                    <div><strong>Prodi:</strong> {{ $peminjaman->member?->prodi ?? '-' }}</div>
                                                    <div><strong>Email:</strong> {{ $peminjaman->member?->email ?? '-' }}</div>
                                                    <div>
                                                        <span class="badge bg-light text-dark border mt-1">
                                                            {{ $peminjaman->member?->jenis_anggota_label ?? 'Mahasiswa' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-dark">{{ $peminjaman->judul_buku }}</div>
                                                <div>
                                                    <span class="badge bg-{{ $peminjaman->book_type === 'fisik' ? 'info' : 'secondary' }} text-white text-xs">
                                                        {{ ucfirst($peminjaman->book_type) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-muted small">
                                                {{ $peminjaman->tgl_pinjam ? $peminjaman->tgl_pinjam->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td class="text-muted small">
                                                {{ $peminjaman->tgl_kembali ? $peminjaman->tgl_kembali->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                                    <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success btn-sm fw-semibold" onclick="return confirm('Terima peminjaman ini?')">
                                                            <i class="fas fa-check me-1"></i> Terima
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-danger btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $peminjaman->id }}">
                                                        <i class="fas fa-times me-1"></i> Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $peminjaman->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $peminjaman->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="rejectModalLabel{{ $peminjaman->id }}">Tolak Peminjaman</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.peminjaman.tolak', $peminjaman->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <p class="mb-3">
                                                                Anda akan menolak peminjaman <strong>{{ $peminjaman->nomor_antrian }}</strong> oleh <strong>{{ $peminjaman->member?->name }}</strong> untuk buku <strong>{{ $peminjaman->judul_buku }}</strong>.
                                                            </p>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Alasan Penolakan *</label>
                                                                <textarea class="form-control" name="alasan" rows="3" placeholder="Tuliskan alasan penolakan..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger fw-semibold">Tolak Peminjaman</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="d-md-none">
                            @foreach($peminjamans as $peminjaman)
                                <div class="card border border-light shadow-sm mb-3 rounded-4 p-3 bg-white">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-primary px-2.5 py-1.5 fw-semibold">{{ $peminjaman->nomor_antrian }}</span>
                                        <span class="badge bg-{{ $peminjaman->book_type === 'fisik' ? 'info' : 'secondary' }} text-white text-xs">
                                            {{ ucfirst($peminjaman->book_type) }}
                                        </span>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $peminjaman->judul_buku }}</h6>
                                    <hr class="my-2 opacity-50">
                                    <div class="small text-muted mb-3">
                                        <div class="mb-1"><strong>Nama:</strong> {{ $peminjaman->member?->name ?? 'N/A' }}</div>
                                        <div class="mb-1"><strong>NIM:</strong> {{ $peminjaman->member?->nim ?? '-' }}</div>
                                        <div class="mb-1"><strong>Prodi:</strong> {{ $peminjaman->member?->prodi ?? '-' }}</div>
                                        <div class="mb-1"><strong>Email:</strong> {{ $peminjaman->member?->email ?? '-' }}</div>
                                        <div class="mb-1"><strong>Pinjam:</strong> {{ $peminjaman->tgl_pinjam ? $peminjaman->tgl_pinjam->translatedFormat('d M Y') : '-' }}</div>
                                        <div><strong>Kembali:</strong> {{ $peminjaman->tgl_kembali ? $peminjaman->tgl_kembali->translatedFormat('d M Y') : '-' }}</div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" style="flex: 1;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm w-100 fw-semibold" onclick="return confirm('Terima peminjaman ini?')">
                                                <i class="fas fa-check me-1"></i> Terima
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm fw-semibold" style="flex: 1;" data-bs-toggle="modal" data-bs-target="#rejectModalMobile{{ $peminjaman->id }}">
                                            <i class="fas fa-times me-1"></i> Tolak
                                        </button>
                                    </div>
                                </div>

                                <!-- Mobile Reject Modal -->
                                <div class="modal fade" id="rejectModalMobile{{ $peminjaman->id }}" tabindex="-1" aria-labelledby="rejectModalMobileLabel{{ $peminjaman->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content text-start">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold" id="rejectModalMobileLabel{{ $peminjaman->id }}">Tolak Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.peminjaman.tolak', $peminjaman->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <p class="mb-3">
                                                        Anda akan menolak peminjaman <strong>{{ $peminjaman->nomor_antrian }}</strong> oleh <strong>{{ $peminjaman->member?->name }}</strong> untuk buku <strong>{{ $peminjaman->judul_buku }}</strong>.
                                                    </p>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Alasan Penolakan *</label>
                                                        <textarea class="form-control" name="alasan" rows="3" placeholder="Tuliskan alasan penolakan..." required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger fw-semibold">Tolak Peminjaman</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="border-top p-3 mt-3">
                            {{ $peminjamans->links() }}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center py-5 text-muted">
                            <i class="fas fa-check-circle fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">Tidak ada peminjaman baru yang menunggu konfirmasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection