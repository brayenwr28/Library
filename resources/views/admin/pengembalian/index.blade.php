@extends('layout.app')
@section('title', 'Input Pengembalian')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">📥 Input Pengembalian</h1>
                <p class="text-muted mb-0">Pilih peminjaman aktif yang sudah dikembalikan oleh member untuk diinput ke sistem</p>
            </div>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.pengembalian.menunggu') }}" class="btn btn-warning fw-semibold shadow-sm text-dark">
                ⏳ Lihat Konfirmasi Menunggu
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($peminjamans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light border-bottom text-uppercase fs-7 tracking-wider text-muted">
                            <tr>
                                <th class="ps-4 py-3">No. Antrian</th>
                                <th class="py-3">Member</th>
                                <th class="py-3">Judul Buku</th>
                                <th class="py-3">Tgl Pinjam</th>
                                <th class="py-3">Tgl Kembali</th>
                                <th class="text-center py-3 pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $peminjaman)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">
                                        #{{ $peminjaman->nomor_antrian }}
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $peminjaman->member?->name ?? '-' }}</div>
                                        <small class="text-muted d-block" style="font-size: 0.85rem;">{{ $peminjaman->member?->email }}</small>
                                    </td>
                                    <td class="fw-semibold text-secondary">
                                        {{ $peminjaman->judul_buku }}
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('d M Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->translatedFormat('d M Y') }}</span>
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="{{ route('admin.pengembalian.create', $peminjaman->id) }}" class="btn btn-success btn-sm fw-semibold px-3 py-1.5 shadow-sm">
                                            ✓ Input Kembali
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="border-top p-3 d-flex justify-content-between align-items-center bg-light-subtle rounded-bottom">
                    <span class="small text-muted">Menampilkan {{ $peminjamans->count() }} data aktif</span>
                    <div>
                        {{ $peminjamans->links() }}
                    </div>
                </div>
            @else
                {{-- Modern Empty State --}}
                <div class="text-center p-5 my-4">
                    <div class="avatar avatar-xl bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <span class="fs-1 text-muted">📚</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">Semua Beres!</h5>
                    <p class="text-muted max-w-md mx-auto mb-0">Tidak ada data peminjaman aktif yang menunggu pengembalian saat ini.</p>
                </div>
            @endif
        </div>
    </div>
@endsection