@extends('layout.app')
@section('title', 'Konfirmasi Peminjaman')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">⏳ Peminjaman Menunggu Konfirmasi</h1>
                <p class="text-muted mb-0">Daftar permintaan peminjaman yang perlu dikonfirmasi oleh admin</p>
            </div>
        </div>
        <div class="col-auto">
            <span class="badge bg-warning text-dark fw-semibold">
                <i class="fas fa-clock"></i> {{ $peminjamans->total() }} menunggu
            </span>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
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
                                        <th>Tanggal Request</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjamans as $peminjaman)
                                        <tr>
                                            <td class="ps-4 fw-semibold">
                                                <span class="badge bg-primary">{{ $peminjaman->nomor_antrian }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $peminjaman->member?->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $peminjaman->member?->email }}</small>
                                            </td>
                                            <td>
                                                {{ $peminjaman->judul_buku }}
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $peminjaman->tgl_pinjam->translatedFormat('d F Y') }} - {{ $peminjaman->tgl_kembali->translatedFormat('d F Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $peminjaman->created_at->translatedFormat('d F Y H:i') }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi peminjaman ini?')">
                                                            <i class="fas fa-check"></i> Terima
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $peminjaman->id }}">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $peminjaman->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Tolak Peminjaman</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.peminjaman.tolak', $peminjaman->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <p class="mb-3">
                                                                Anda akan menolak peminjaman <strong>{{ $peminjaman->nomor_antrian }}</strong> 
                                                                oleh <strong>{{ $peminjaman->member?->name }}</strong>
                                                            </p>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Alasan Penolakan *</label>
                                                                <textarea class="form-control" name="alasan" rows="3" placeholder="Tuliskan alasan penolakan..." required></textarea>
                                                                @error('alasan')
                                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Tolak Peminjaman</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="border-top p-3">
                            {{ $peminjamans->links() }}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center p-5 text-muted">
                            <i class="fas fa-check-circle fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">Tidak ada peminjaman yang menunggu konfirmasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
