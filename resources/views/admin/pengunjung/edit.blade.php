@extends('layout.app')
@section('title', 'Edit Pengunjung')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <h1 class="h2 mb-2 fw-bold">Edit Pengunjung</h1>
            <p class="text-muted mb-0">Perbarui data kunjungan perpustakaan</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.report.pengunjung') }}" class="btn btn-outline-secondary fw-semibold">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('pengunjung.update', $pengunjung->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pengunjung->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nim" class="form-label fw-bold">NIM / NIP / ID</label>
                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $pengunjung->nim) }}">
                    <div class="form-text">Kosongkan jika pengunjung umum.</div>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tipe_pengunjung" class="form-label fw-bold">Tipe Pengunjung</label>
                    <select class="form-select @error('tipe_pengunjung') is-invalid @enderror" id="tipe_pengunjung" name="tipe_pengunjung" required>
                        <option value="mahasiswa" {{ old('tipe_pengunjung', $pengunjung->tipe_pengunjung) === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ old('tipe_pengunjung', $pengunjung->tipe_pengunjung) === 'dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="umum" {{ old('tipe_pengunjung', $pengunjung->tipe_pengunjung) === 'umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                    @error('tipe_pengunjung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light fw-semibold">Reset</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
