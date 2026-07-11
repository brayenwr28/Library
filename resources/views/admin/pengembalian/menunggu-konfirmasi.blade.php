@extends('layout.app')
@section('title', 'Konfirmasi Pengembalian')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">📦 Pengembalian Menunggu Konfirmasi</h1>
                <p class="text-muted mb-0">Daftar pengembalian buku yang perlu dikonfirmasi oleh admin</p>
            </div>
        </div>
        <div class="col-auto">
            <span class="badge bg-warning text-dark fw-semibold">
                <i class="fas fa-clock"></i> {{ $pengembalians->total() }} menunggu
            </span>
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

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if($pengembalians->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="ps-4">No. Antrian</th>
                                        <th>Peminjam</th>
                                        <th>Judul Buku</th>
                                        <th>Tgl Kembali Rencana</th>
                                        <th>Tgl Kembali Aktual</th>
                                        <th>Kondisi</th>
                                        <th>Denda</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengembalians as $pengembalian)
                                        <tr>
                                            <td class="ps-4 fw-semibold">
                                                <span class="badge bg-primary">{{ $pengembalian->peminjaman?->nomor_antrian }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $pengembalian->peminjaman?->member?->name ?? 'N/A' }}</div>
                                            </td>
                                            <td>
                                                {{ $pengembalian->peminjaman?->judul_buku }}
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $pengembalian->peminjaman?->tgl_kembali->translatedFormat('d F Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $pengembalian->tgl_kembali_aktual->translatedFormat('d F Y') }}
                                                </small>
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
                                                <strong class="text-danger">
                                                    Rp {{ number_format($pengembalian->denda ?? 0, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex flex-column gap-1 align-items-center" style="max-width: 140px; margin: 0 auto;">
                                                    <div class="btn-group btn-group-sm w-100" role="group">
                                                        <form action="{{ route('admin.pengembalian.terima', $pengembalian->id) }}" method="POST" style="display: inline;" class="w-50">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-sm w-100 fw-semibold" onclick="return confirm('Konfirmasi penerimaan pengembalian?')">
                                                                <i class="fas fa-check"></i> Terima
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-warning btn-sm w-50 fw-semibold text-dark" data-bs-toggle="modal" data-bs-target="#editModal{{ $pengembalian->id }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </div>
                                                    <button type="button" class="btn btn-danger btn-sm w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $pengembalian->id }}">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $pengembalian->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Tolak Pengembalian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.pengembalian.tolak', $pengembalian->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <p class="mb-3">
                                                                Anda akan menolak pengembalian dari <strong>{{ $pengembalian->peminjaman?->member?->name }}</strong> 
                                                                untuk buku <strong>{{ $pengembalian->peminjaman?->judul_buku }}</strong>
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
                                                            <button type="submit" class="btn btn-danger fw-semibold">Tolak Pengembalian</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $pengembalian->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $pengembalian->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="editModalLabel{{ $pengembalian->id }}">📝 Edit Data Pengembalian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.pengembalian.update', $pengembalian->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="p-3 mb-3 bg-light rounded-3 border">
                                                                <p class="text-uppercase small fw-bold text-primary mb-2">📌 Info Peminjaman</p>
                                                                <div class="small">
                                                                    <div class="mb-1"><strong>Member:</strong> {{ $pengembalian->peminjaman?->member?->name }} ({{ $pengembalian->peminjaman?->member?->nim ?? '-' }})</div>
                                                                    <div class="mb-1"><strong>Buku:</strong> {{ $pengembalian->peminjaman?->judul_buku }}</div>
                                                                    <div><strong>Batas Kembali:</strong> {{ $pengembalian->peminjaman?->tgl_kembali->translatedFormat('d F Y') }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Tanggal Kembali Aktual</label>
                                                                <input type="date" name="tgl_kembali_aktual" 
                                                                       class="form-control" 
                                                                       value="{{ old('tgl_kembali_aktual', $pengembalian->tgl_kembali_aktual->format('Y-m-d')) }}" 
                                                                       max="{{ now()->format('Y-m-d') }}"
                                                                       required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Kondisi Buku</label>
                                                                <select name="kondisi_buku" class="form-select" required>
                                                                    <option value="baik" @selected($pengembalian->kondisi_buku === 'baik')>Baik</option>
                                                                    <option value="rusak_ringan" @selected($pengembalian->kondisi_buku === 'rusak_ringan')>Rusak Ringan</option>
                                                                    <option value="rusak_berat" @selected($pengembalian->kondisi_buku === 'rusak_berat')>Rusak Berat</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Catatan</label>
                                                                <textarea class="form-control" name="catatan" rows="3" placeholder="Opsional: kondisi tambahan atau catatan denda...">{{ old('catatan', $pengembalian->catatan) }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary fw-semibold">Simpan Perubahan</button>
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
                            {{ $pengembalians->links() }}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center p-5 text-muted">
                            <i class="fas fa-check-circle fa-3x opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">Tidak ada pengembalian yang menunggu konfirmasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
