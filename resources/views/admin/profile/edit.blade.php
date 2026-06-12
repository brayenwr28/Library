@extends('layout.app')

@section('title', 'Profil Admin')

@section('content-header')
<div class="container-fluid px-0">
    <div class="row align-items-center mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small fw-medium">
                    <li class="breadcrumb-item"><a href="#" class="text-muted text-decoration-none opacity-75">Sistem</a></li>
                    <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Profil Admin</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 fw-bold text-dark letter-spacing-tight">Pengaturan Profil</h1>
            <p class="text-muted small mb-0">Kelola informasi identitas dan keamanan akun administrator Anda.</p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid px-0">
    
    <!-- Toast/Alert Status yang Elegan -->
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center p-3 mb-4 rounded-3" role="alert" style="background-color: #e8f5e9;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#2e7d32" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <div class="text-dark small fw-medium">{{ session('status') }}</div>
            <button type="button" class="btn-close small shadow-none" data-bs-dismiss="alert" aria-label="Close" style="padding: 1.25rem;"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Kolom Kiri: Kartu Identitas Utama -->
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm overflow-hidden rounded-3 position-relative" style="transition: all 0.3s ease;">
                <!-- Decorative Top Bar -->
                <div class="bg-primary position-absolute top-0 start-0 w-100" style="height: 6px;"></div>
                
                <div class="card-body text-center pt-5 pb-4">
                    <div class="mb-3 position-relative d-inline-block">
                        <!-- Avatar Bulat Premium dengan Inisial -->
                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm fw-bold" 
                             style="width: 96px; height: 96px; font-size: 2.5rem; letter-spacing: -1px; border: 4px solid #fff; box-shadow: 0 0 20px rgba(0,0,0,0.05) !important;">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                    </div>
                    
                    <h5 class="fw-bold text-dark mb-1">{{ $admin->name }}</h5>
                    <p class="text-muted small mb-3 fw-medium">{{ $admin->email }}</p>
                    
                    <div class="d-inline-flex align-items-center gap-1.5 bg-light px-3 py-1.5 rounded-pill text-primary small fw-bold" style="font-size: 0.75rem; uppercase;">
                        <span class="d-inline-block rounded-circle bg-primary me-1" style="width: 6px; height: 6px;"></span>
                        System Administrator
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Data & Keamanan -->
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-md-5">
                    
                    <form method="POST" action="{{ route('admin.profile.update') }}" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <!-- Section: Informasi Dasar -->
                        <div class="d-flex align-items-center mb-4 text-dark">
                            <span class="p-2 bg-light rounded-2 text-primary me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                            </span>
                            <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
                        </div>

                        <div class="row g-3 mb-4.5">
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-control form-control-lg fs-6 @error('name') is-invalid @enderror" placeholder="Contoh: John Doe" required style="border-radius: 8px;" />
                                @error('name')
                                    <div class="invalid-feedback small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Username ID</label>
                                <input type="text" name="username" value="{{ old('username', $admin->username) }}" class="form-control form-control-lg fs-6 @error('username') is-invalid @enderror" placeholder="Contoh: johndoe123" required style="border-radius: 8px;" />
                                @error('username')
                                    <div class="invalid-feedback small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold text-secondary">Alamat Email Terdaftar</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zM0 8a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1zm4-3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1zm4 3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1z"/></svg>
                                    </span>
                                    <input type="email" value="{{ $admin->email }}" class="form-control form-control-lg fs-6 bg-light text-muted border-start-0" readonly style="cursor: not-allowed; border-top-right-radius: 8px; border-bottom-right-radius: 8px;" data-bs-toggle="tooltip" title="Email tidak dapat diubah" />
                                </div>
                                <div class="form-text text-muted" style="font-size: 0.75rem;"><i class="bi bi-info-circle"></i> Hubungi Super Admin jika ingin merubah alamat email utama.</div>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <!-- Section: Keamanan Akun -->
                        <div class="d-flex align-items-center mb-4 text-dark">
                            <span class="p-2 bg-light rounded-2 text-primary me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/></svg>
                            </span>
                            <h5 class="fw-bold mb-0">Ubah Kata Sandi</h5>
                        </div>

                        <div class="row g-3 mb-5">
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Password Baru</label>
                                <input type="password" name="password" class="form-control form-control-lg fs-6 @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah" style="border-radius: 8px;" />
                                @error('password')
                                    <div class="invalid-feedback small fw-medium">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg fs-6" placeholder="Ulangi password baru" style="border-radius: 8px;" />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top border-light">
                            <button type="reset" class="btn btn-light px-4 py-2.5 fw-semibold text-secondary small" style="border-radius: 8px;">Batalkan</button>
                            <button type="submit" class="btn btn-primary px-4 py-2.5 fw-semibold small shadow-sm" style="border-radius: 8px; background-image: linear-gradient(180deg, rgba(255,255,255,0.15), rgba(255,255,255,0));">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom utility untuk menyempurnakan Bootstrap */
    .form-control:focus {
        border-color: #5c60f5 !important;
        box-shadow: 0 0 0 4px rgba(92, 96, 245, 0.1) !important;
    }
    .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
    .btn-primary:hover {
        background-color: #4338ca;
        border-color: #4338ca;
    }
    .text-primary {
        color: #4f46e5 !important;
    }
    .bg-primary {
        background-color: #4f46e5 !important;
    }
</style>
@endsection