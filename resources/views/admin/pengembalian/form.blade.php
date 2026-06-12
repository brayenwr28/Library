@extends('layout.app')
@section('title', 'Form Pengembalian')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <div class="section-header">
                <h1 class="h2 mb-2 fw-bold">📝 Form Pengembalian</h1>
                <p class="text-muted mb-0">Input data pengembalian buku yang sudah dikembalikan member</p>
            </div>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-outline-secondary fw-semibold">
                Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Detail Data Peminjaman --}}
                    <div class="mb-4 rounded-4 border border-primary-subtle bg-light p-4">
                        <p class="text-uppercase small fw-bold text-primary mb-3">📌 Data Peminjaman</p>
                        <h3 class="h5 fw-bold text-dark mb-3">{{ $peminjaman->judul_buku }}</h3>
                        
                        <div class="row g-2 text-muted">
                            <div class="col-12 col-md-6">
                                <span>Member:</span> 
                                <strong class="text-dark d-block d-sm-inline">{{ $peminjaman->member?->name }}</strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <span>No. Antrian:</span> 
                                <strong class="text-dark d-block d-sm-inline">{{ $peminjaman->nomor_antrian }}</strong>
                            </div>
                            <div class="col-12">
                                <span>Tanggal Kembali Rencana:</span> 
                                <strong class="text-dark d-block d-sm-inline">
                                    {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->translatedFormat('d F Y') }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    {{-- Form Input --}}
                    <form action="{{ route('admin.pengembalian.store') }}" method="POST" class="row g-4">
                        @csrf
                        <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Tanggal Kembali Aktual</label>
                            <input type="date" name="tgl_kembali_aktual" 
                                   class="form-control @error('tgl_kembali_aktual') is-invalid @enderror" 
                                   value="{{ old('tgl_kembali_aktual', now()->format('Y-m-d')) }}" required>
                            @error('tgl_kembali_aktual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Kondisi Buku</label>
                            <select name="kondisi_buku" class="form-select @error('kondisi_buku') is-invalid @enderror" required>
                                <option value="">Pilih kondisi</option>
                                <option value="baik" @selected(old('kondisi_buku') === 'baik')>Baik</option>
                                <option value="rusak_ringan" @selected(old('kondisi_buku') === 'rusak_ringan')>Rusak Ringan</option>
                                <option value="rusak_berat" @selected(old('kondisi_buku') === 'rusak_berat')>Rusak Berat</option>
                            </select>
                            @error('kondisi_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Catatan Petugas</label>
                            <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" 
                                      rows="4" placeholder="Opsional: kondisi tambahan, nomor rak, atau catatan lain">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2 pt-2">
                            <button type="submit" class="btn btn-primary fw-semibold px-4">Simpan Pengembalian</button>
                            <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-light border fw-semibold px-4">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection