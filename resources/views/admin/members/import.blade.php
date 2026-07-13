@extends('layout.app')
@section('title', 'Import Anggota')

@push('styles')
<style>
    .import-card {
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 4px 24px 0 rgba(30, 64, 175, 0.07);
    }
    .import-card-header {
        background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%);
        border-radius: 16px 16px 0 0;
        padding: 1.25rem 1.75rem;
    }
    .stat-card {
        border-radius: 12px;
        padding: 1rem 1.25rem;
        border: 1px solid transparent;
        transition: transform .15s;
    }
    .stat-card:hover { transform: translateY(-2px); }
    .stat-valid   { background: #F0FDF4; border-color: #BBF7D0; }
    .stat-error   { background: #FFF1F2; border-color: #FECDD3; }
    .stat-dup     { background: #FFFBEB; border-color: #FDE68A; }
    .stat-total   { background: #EFF6FF; border-color: #BFDBFE; }
    .badge-valid   { background: #D1FAE5; color: #065F46; font-weight: 600; }
    .badge-error   { background: #FFE4E6; color: #9F1239; font-weight: 600; }
    .badge-duplikat{ background: #FEF3C7; color: #92400E; font-weight: 600; }
    .preview-table thead th {
        background: #1E40AF;
        color: #fff;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        vertical-align: middle;
    }
    .preview-table tbody tr.row-valid   { background: #F0FDF4; }
    .preview-table tbody tr.row-error   { background: #FFF1F2; }
    .preview-table tbody tr.row-duplikat{ background: #FFFBEB; }
    .preview-table tbody tr:hover { filter: brightness(.97); }
    .upload-zone {
        border: 2.5px dashed #93C5FD;
        border-radius: 14px;
        background: #EFF6FF;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
    }
    .upload-zone:hover, .upload-zone.drag-over {
        border-color: #3B82F6;
        background: #DBEAFE;
    }
    .upload-zone input[type=file] { display: none; }
    .btn-download {
        background: linear-gradient(135deg, #059669 0%, #10B981 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: .55rem 1.25rem;
        font-weight: 600;
        font-size: .875rem;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: box-shadow .2s, transform .15s;
    }
    .btn-download:hover {
        color: #fff;
        box-shadow: 0 4px 14px rgba(5, 150, 105, .3);
        transform: translateY(-1px);
    }
    .btn-preview {
        background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: .55rem 1.5rem;
        font-weight: 600;
        font-size: .875rem;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: box-shadow .2s, transform .15s;
    }
    .btn-preview:hover {
        color: #fff;
        box-shadow: 0 4px 14px rgba(30, 64, 175, .3);
        transform: translateY(-1px);
    }
    .btn-confirm {
        background: linear-gradient(135deg, #059669 0%, #10B981 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: .65rem 2rem;
        font-weight: 700;
        font-size: .95rem;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: box-shadow .2s, transform .15s;
    }
    .btn-confirm:hover {
        color: #fff;
        box-shadow: 0 4px 18px rgba(5, 150, 105, .35);
        transform: translateY(-1px);
    }
    .btn-confirm:disabled {
        background: #D1D5DB;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }
    .error-detail { font-size: .78rem; color: #991B1B; margin-top: .25rem; }
    #file-name-display {
        font-size: .85rem;
        color: #374151;
        font-weight: 500;
        margin-top: .75rem;
        min-height: 1.2em;
    }
</style>
@endpush

@section('content')
<div class="py-4">

    {{-- ── Page Header ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0" style="font-size:1.5rem">
                <i class="bi bi-people-fill me-2 text-primary"></i>Import Anggota
            </h2>
            <p class="text-muted mb-0 mt-1" style="font-size:.875rem">
                Upload file Excel atau CSV — preview & validasi sebelum menyimpan ke database.
            </p>
        </div>
        <a href="{{ route('admin.members.template') }}" class="btn-download">
            <i class="bi bi-file-earmark-excel-fill"></i> Download Template Excel
        </a>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i>Terjadi kesalahan:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- ── SECTION 1: Upload Form ── --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <div class="import-card mb-4">
        <div class="import-card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:32px;height:32px;background:rgba(255,255,255,.2);">
                    <span class="text-white fw-bold">1</span>
                </div>
                <span class="text-white fw-semibold fs-6">Upload File</span>
            </div>
            <span class="badge bg-white text-primary">Excel / CSV</span>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.members.import.process') }}" method="POST"
                  enctype="multipart/form-data" id="uploadForm">
                @csrf
                <input type="hidden" name="mode" value="preview">

                {{-- Panduan kolom --}}
                <div class="rounded-3 p-3 mb-4" style="background:#F0F9FF;border:1px solid #BAE6FD;">
                    <p class="fw-semibold text-info-emphasis mb-2" style="font-size:.875rem">
                        <i class="bi bi-info-circle me-1"></i>Kolom yang dibutuhkan:
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['NIM', 'Nama Lengkap', 'NIK', 'Program Studi', 'Tempat Lahir', 'Tanggal Lahir'] as $col)
                            <span class="badge rounded-pill"
                                  style="background:#E0F2FE;color:#0369A1;font-size:.8rem;padding:.35rem .75rem;">
                                {{ $col }}
                            </span>
                        @endforeach
                    </div>
                    <p class="mb-0 mt-2 text-muted" style="font-size:.8rem">
                        Kolom <strong>Nama Lengkap</strong> wajib diisi. Isi kolom <strong>NIM</strong> jika Anggota adalah Mahasiswa, atau kolom <strong>NIK</strong> jika Anggota adalah Dosen/Staf.
                        Email, Username, ID Member, dan Password default (<code>password123</code>) akan di-generasi otomatis oleh sistem.
                    </p>
                </div>

                {{-- Upload Zone --}}
                <div class="upload-zone" id="uploadZone" onclick="document.getElementById('csv_file').click()">
                    <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size:2.5rem;"></i>
                    <p class="fw-semibold text-dark mt-2 mb-1">Klik untuk memilih file atau seret ke sini</p>
                    <p class="text-muted mb-0" style="font-size:.825rem">Format: .xlsx, .xls, .csv &bull; Maks. 10 MB</p>
                    <input type="file" name="csv_file" id="csv_file"
                           accept=".csv,.xlsx,.xls"
                           onchange="handleFileSelect(this)">
                </div>
                <div id="file-name-display" class="text-center text-muted">Belum ada file dipilih</div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold" id="btnPreview" disabled
                            style="background:linear-gradient(135deg,#1E40AF,#3B82F6);border:none;">
                        <i class="bi bi-search me-1"></i> Analisa &amp; Preview
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- ── SECTION 2: Preview & Analisis (jika ada data di session) ── --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    @if($preview)
    <div class="import-card" id="previewSection">
        <div class="import-card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                     style="width:32px;height:32px;background:rgba(255,255,255,.2);">
                    <span class="text-white fw-bold">2</span>
                </div>
                <span class="text-white fw-semibold fs-6">Preview & Analisis Data</span>
            </div>
            <span class="text-white" style="font-size:.85rem;opacity:.85;">
                <i class="bi bi-file-earmark-check me-1"></i>{{ $preview['count_total'] }} baris ditemukan
            </span>
        </div>

        <div class="card-body p-4">

            {{-- Statistik ── --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card stat-total">
                        <div class="fw-bold" style="font-size:1.75rem;color:#1E40AF;">{{ $preview['count_total'] }}</div>
                        <div class="text-muted" style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Total Baris</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card stat-valid">
                        <div class="fw-bold" style="font-size:1.75rem;color:#059669;">{{ $preview['count_valid'] }}</div>
                        <div class="text-muted" style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">✓ Valid</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card stat-error">
                        <div class="fw-bold" style="font-size:1.75rem;color:#DC2626;">{{ $preview['count_error'] }}</div>
                        <div class="text-muted" style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">✗ Error</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card stat-dup">
                        <div class="fw-bold" style="font-size:1.75rem;color:#D97706;">{{ $preview['count_duplikat'] }}</div>
                        <div class="text-muted" style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">⚠ Duplikat</div>
                    </div>
                </div>
            </div>

            {{-- Info bar --}}
            @if($preview['count_valid'] > 0)
                <div class="alert rounded-3 mb-4 d-flex align-items-center gap-2"
                     style="background:#F0FDF4;border:1px solid #BBF7D0;color:#065F46;">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span>
                        <strong>{{ $preview['count_valid'] }} baris valid</strong> siap diimport ke database.
                        {{ ($preview['count_error'] + $preview['count_duplikat']) > 0 ? ($preview['count_error'] + $preview['count_duplikat']) . ' baris akan dilewati.' : '' }}
                    </span>
                </div>
            @else
                <div class="alert rounded-3 mb-4 d-flex align-items-center gap-2"
                     style="background:#FFF1F2;border:1px solid #FECDD3;color:#9F1239;">
                    <i class="bi bi-x-circle-fill fs-5"></i>
                    <span>Tidak ada baris yang valid. Periksa kembali file Anda.</span>
                </div>
            @endif

            {{-- Tabel Preview --}}
            <div class="table-responsive rounded-3" style="border:1px solid #E5E7EB;max-height:460px;overflow-y:auto;">
                <table class="table table-sm preview-table mb-0">
                    <thead style="position:sticky;top:0;z-index:10;">
                        <tr>
                            <th style="width:60px;">Baris</th>
                            <th style="width:90px;">Status</th>
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>Prodi</th>
                            <th>Tempat/Tgl Lahir</th>
                            <th>Role</th>
                            <th>Info Sistem (ID/Email)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($preview['rows'] as $row)
                        <tr class="row-{{ $row['status'] }}">
                            <td class="text-center text-muted fw-semibold" style="font-size:.8rem;">
                                {{ $row['row_num'] }}
                            </td>
                            <td class="text-center">
                                @if($row['status'] === 'valid')
                                    <span class="badge badge-valid rounded-pill px-2 py-1">
                                        <i class="bi bi-check-lg"></i> Valid
                                    </span>
                                @elseif($row['status'] === 'error')
                                    <span class="badge badge-error rounded-pill px-2 py-1">
                                        <i class="bi bi-x-lg"></i> Error
                                    </span>
                                @else
                                    <span class="badge badge-duplikat rounded-pill px-2 py-1">
                                        <i class="bi bi-exclamation-triangle"></i> Duplikat
                                    </span>
                                @endif
                            </td>
                            <td style="font-size:.825rem;">{{ $row['data']['nim'] ?: '—' }}</td>
                            <td style="font-size:.85rem; font-weight: 500;">{{ $row['data']['name'] ?: '—' }}</td>
                            <td style="font-size:.825rem;">{{ $row['data']['nik'] ?: '—' }}</td>
                            <td style="font-size:.825rem;">{{ $row['data']['prodi'] ?: '—' }}</td>
                            <td style="font-size:.825rem;">
                                @if(!empty($row['data']['tempat_lahir']) || !empty($row['data']['tanggal_lahir']))
                                    {{ $row['data']['tempat_lahir'] ?: '—' }}, 
                                    {{ $row['data']['tanggal_lahir'] ? \Carbon\Carbon::parse($row['data']['tanggal_lahir'])->format('d-m-Y') : '—' }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill px-2"
                                      style="background:{{ $row['data']['jenis_anggota'] === 'dosen' ? '#EDE9FE' : '#DBEAFE' }};
                                             color:{{ $row['data']['jenis_anggota'] === 'dosen' ? '#5B21B6' : '#1D4ED8' }};
                                             font-size:.78rem;font-weight:600;">
                                    {{ ucfirst($row['data']['jenis_anggota']) }}
                                </span>
                            </td>
                            <td style="font-size:.75rem; color:#4B5563;">
                                <div>ID: <code style="font-size:.75rem;">{{ $row['data']['member_id'] }}</code></div>
                                <div>Email: <span>{{ $row['data']['email'] }}</span></div>
                            </td>
                            <td style="font-size:.78rem;">
                                @if(!empty($row['errors']))
                                    @foreach($row['errors'] as $err)
                                        <div class="error-detail">• {{ $err }}</div>
                                    @endforeach
                                @else
                                    <span class="text-success" style="font-size:.8rem;">
                                        <i class="bi bi-check-circle me-1"></i>Siap diimport
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">

                {{-- Upload Ulang: POST ke route clear session lalu redirect --}}
                <form action="{{ route('admin.members.import.form') }}" method="GET" id="resetForm">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4 fw-semibold"
                            onclick="clearPreviewAndReset()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Upload Ulang
                    </button>
                </form>

                @if($preview['count_valid'] > 0)
                    <form action="{{ route('admin.members.import.process') }}" method="POST" id="confirmForm">
                        @csrf
                        <input type="hidden" name="mode" value="confirm">
                        <button type="submit" class="btn btn-success px-4 rounded-3 fw-bold d-inline-flex align-items-center gap-2"
                                id="btnConfirm"
                                style="background:linear-gradient(135deg,#059669,#10B981);border:none;"
                                onclick="return confirmImport({{ $preview['count_valid'] }})">
                            <i class="bi bi-cloud-check-fill"></i>
                            Konfirmasi Import
                            <span class="badge bg-white text-success ms-1" style="font-size:.8rem;">
                                {{ $preview['count_valid'] }} Anggota
                            </span>
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary px-4 rounded-3 fw-semibold" disabled>
                        <i class="bi bi-x-circle me-1"></i> Tidak Ada Data Valid
                    </button>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // ── Drag & Drop Upload Zone ──
    const zone = document.getElementById('uploadZone');
    const input = document.getElementById('csv_file');
    const btnPreview = document.getElementById('btnPreview');
    const display = document.getElementById('file-name-display');

    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            input.files = files;
            handleFileSelect(input);
        }
    });

    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeKB = (file.size / 1024).toFixed(1);
            const ext = file.name.split('.').pop().toUpperCase();
            display.innerHTML = `<i class="bi bi-file-earmark-spreadsheet text-success me-1"></i>
                <strong>${file.name}</strong>
                <span class="badge ms-2 rounded-pill" style="background:#D1FAE5;color:#065F46;">${ext}</span>
                <span class="text-muted ms-2">${sizeKB} KB</span>`;
            btnPreview.disabled = false;
        } else {
            display.textContent = 'Belum ada file dipilih';
            btnPreview.disabled = true;
        }
    }

    // ── Loading state saat submit ──
    document.getElementById('uploadForm')?.addEventListener('submit', function() {
        btnPreview.disabled = true;
        btnPreview.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menganalisa...';
    });

    // ── Auto-scroll ke preview jika ada ──
    @if($preview)
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                document.getElementById('previewSection')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        });
    @endif

    // ── Upload Ulang: hapus session preview via request, lalu reload ──
    function clearPreviewAndReset() {
        // Kirim request GET biasa — session akan dihapus oleh controller jika tidak ada file baru
        // Cukup redirect ke form (session preview tidak ikut terbawa karena bukan redirect POST)
        window.location.href = '{{ route('admin.members.import.form') }}?reset=1';
    }

    // ── Konfirmasi dialog sebelum import ──
    function confirmImport(count) {
        return confirm(`Konfirmasi import ${count} anggota ke database?\n\nData yang sudah ada di database tidak akan ditimpa.`);
    }

    // ── Loading state saat konfirmasi ──
    document.getElementById('confirmForm')?.addEventListener('submit', function () {
        const btn = document.getElementById('btnConfirm');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        }
    });
</script>
@endpush