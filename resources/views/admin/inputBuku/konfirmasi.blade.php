@extends('layout.app')
@section('title', 'Dashboard Admin')

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm animate-fade-in-up delay-800">
            <div class="card-header bg-white border-bottom-0 p-4 pb-0">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h5 class="card-title fw-bold mb-1">📝 Peminjaman Menunggu Tindakan</h5>
                        <p class="text-muted small mb-0">Terima langsung atau tolak dengan catatan alasan dari
                            dashboard.</p>
                    </div>
                    <a href="{{ route('admin.peminjaman.menunggu') }}"
                        class="btn btn-outline-primary btn-sm fw-semibold">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                @php
                    $pendingBorrowItems = $pendingPeminjamanItems ?? collect();
                @endphp

                @if($pendingBorrowItems->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Antrian</th>
                                    <th>Member</th>
                                    <th>Judul Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingBorrowItems as $peminjaman)
                                    <tr>
                                        <td class="fw-semibold">{{ $peminjaman->nomor_antrian }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $peminjaman->member?->name ?? '-' }}</div>
                                            <small class="text-muted">{{ $peminjaman->member?->email }}</small>
                                        </td>
                                        <td>{{ $peminjaman->judul_buku }}</td>
                                        <td class="text-muted small">
                                            {{ $peminjaman->created_at->translatedFormat('d F Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                                <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm fw-semibold"
                                                        onclick="return confirm('Terima peminjaman ini?')">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                </form>

                                                <button type="button" class="btn btn-danger btn-sm fw-semibold"
                                                    onclick="toggleRejectForm('{{ $peminjaman->id }}')">
                                                    <i class="fas fa-times me-1"></i> Tolak
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="rejectForm{{ $peminjaman->id }}" class="d-none">
                                        <td colspan="5" class="p-0 border-0 bg-light">
                                            <div class="p-4">
                                                <form action="{{ route('admin.peminjaman.tolak', $peminjaman->id) }}"
                                                    method="POST"
                                                    class="rounded-3 border border-danger-subtle bg-white p-4 shadow-sm">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="alasan-{{ $peminjaman->id }}"
                                                            class="form-label fw-semibold">Alasan Penolakan</label>
                                                        <textarea id="alasan-{{ $peminjaman->id }}" name="alasan"
                                                            class="form-control" rows="4"
                                                            placeholder="Contoh: stok buku sedang tidak tersedia..."
                                                            required></textarea>
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <button type="submit" class="btn btn-danger fw-semibold">Kirim
                                                            Penolakan</button>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="toggleRejectForm('{{ $peminjaman->id }}')">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center py-5 text-muted">
                        <i class="fas fa-check-circle fa-3x opacity-25 mb-3"></i>
                        <p class="mb-0 fw-semibold">Tidak ada peminjaman yang perlu ditindaklanjuti</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>