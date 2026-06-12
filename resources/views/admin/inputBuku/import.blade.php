@extends('layout.app')
@section('title', 'Import Buku')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="bi bi-file-earmark-arrow-up me-2"></i>Import Buku via CSV
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert alert-info border-0 bg-light text-dark mb-4">
                        <h6 class="fw-bold text-info-emphasis mb-2">
                            <i class="bi bi-info-circle me-1"></i> Aturan & Format CSV:
                        </h6>
                        <p class="small mb-2">Pastikan file CSV Anda memiliki struktur *header* kolom seperti berikut:</p>
                        <div class="bg-white p-2 rounded border font-monospace small text-muted overflow-auto" style="white-space: nowrap;">
                            title, author, publisher, publication_year, category, summary, isbn, stock, cover_url, reference_url, status
                        </div>
                        <p class="small mt-2 mb-0">Format yang didukung: <strong>CSV (UTF-8)</strong> dan <strong>Excel (.xlsx/.xls)</strong>. Jika ingin pakai Excel, simpan sebagai <em>Excel Workbook</em> atau ekspor ke CSV UTF-8.</p>
                    </div>

                    <form action="{{ route('admin.books.import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="csv_file" class="form-label fw-semibold text-secondary">Pilih File CSV</label>
                            <input type="file" name="csv_file" id="csv_file" accept=".csv,.xlsx,.xls" class="form-control @error('csv_file') is-invalid @enderror" required>
                            @error('csv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ url()->previous() }}" class="btn btn-light border">Kembali</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-upload me-1"></i> Mulai Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection