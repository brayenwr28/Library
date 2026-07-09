@extends('layout.app')
@section('title', 'Edit Anggota')

@section('content-header')
    <div class="row align-items-center gy-3">
        <div class="col">
            <h1 class="h2 mb-2 fw-bold">Edit Anggota</h1>
            <p class="text-muted mb-0">Perbarui profil dan identitas anggota perpustakaan</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.report.anggota') }}" class="btn btn-outline-secondary fw-semibold">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">ID Member</label>
                    <input type="text" class="form-control bg-light" value="{{ $member->member_id }}" readonly>
                    <div class="form-text">ID Member tidak dapat diubah karena merupakan identitas unik sistem.</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $member->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $member->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="jenis_anggota" class="form-label fw-bold">Jenis Anggota</label>
                        <select class="form-select @error('jenis_anggota') is-invalid @enderror" id="jenis_anggota" name="jenis_anggota" required>
                            <option value="mahasiswa" {{ old('jenis_anggota', $member->jenis_anggota) === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen" {{ old('jenis_anggota', $member->jenis_anggota) === 'dosen' ? 'selected' : '' }}>Dosen</option>
                        </select>
                        @error('jenis_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="nim" class="form-label fw-bold">NIM / NIDN</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $member->nim) }}">
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="prodi" class="form-label fw-bold">Program Studi</label>
                        <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi', $member->prodi) }}">
                        @error('prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-light fw-semibold">Reset</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
