@extends('layout.app')

@section('title', 'Import Buku Perpustakaan - Excel')

@section('content')
<div class="py-4">
	<div class="row justify-content-center">
		<div class="col-lg-10 col-xl-9">

			<!-- Header -->
			<div class="mb-4">
				<div class="d-flex align-items-center gap-2 mb-2">
					<span class="badge bg-success-subtle text-success fw-semibold px-3 py-2 rounded-pill">
						<i class="bi bi-file-earmark-excel me-1"></i> Import Excel
					</span>
				</div>
				<h1 class="h3 fw-bold text-dark mb-1">📥 Import Buku via Excel</h1>
				<p class="text-muted small mb-0">Upload file Excel untuk menambahkan banyak buku sekaligus. Preview data sebelum disimpan ke database.</p>
			</div>

			<!-- Alerts -->
			@if (session('success'))
				<div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
					<i class="bi bi-check-circle-fill"></i>
					<span>{{ session('success') }}</span>
					<button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
				</div>
			@endif
			@if (session('warning'))
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
			@endif
			@if ($errors->any())
				<div class="alert alert-danger" role="alert">
					<p class="fw-semibold mb-2">⚠️ Terjadi Kesalahan:</p>
					<ul class="mb-0 ps-3">
						@foreach ($errors->all() as $error)
							<li class="small">{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<!-- STEP 1: Download Template -->
			<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
				<div class="card-header text-white py-3" style="background: linear-gradient(135deg, #2563eb, #4f46e5);">
					<div class="d-flex align-items-center gap-2">
						<span class="badge bg-white text-primary fw-bold rounded-circle px-2">1</span>
						<div>
							<h5 class="mb-0 fw-bold">Download Template Excel</h5>
							<p class="mb-0 small opacity-75">Download terlebih dahulu template, lalu isi data buku sesuai format</p>
						</div>
					</div>
				</div>
				<div class="card-body p-4">
					<!-- Format Preview -->
					<div class="border rounded-3 overflow-hidden mb-4">
						<div class="bg-light px-3 py-2 border-bottom">
							<p class="small fw-semibold text-muted mb-0 text-uppercase">
								<i class="bi bi-table me-1"></i> Format Kolom Template
							</p>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-sm mb-0 small text-nowrap">
								<thead class="table-primary">
									<tr>
										<th class="px-2 py-2">no</th>
										<th class="px-2 py-2">registration_number</th>
										<th class="px-2 py-2">title *</th>
										<th class="px-2 py-2">author *</th>
										<th class="px-2 py-2">isbn</th>
										<th class="px-2 py-2">publisher</th>
										<th class="px-2 py-2">publication_year</th>
										<th class="px-2 py-2">klasifikasi</th>
										<th class="px-2 py-2">edisi</th>
										<th class="px-2 py-2">category</th>
										<th class="px-2 py-2">stock</th>
									</tr>
								</thead>
								<tbody>
									<tr class="text-muted fst-italic">
										<td class="px-2 py-2">1</td>
										<td class="px-2 py-2">1.000176</td>
										<td class="px-2 py-2">Mengupas Tuntas Formula Excel</td>
										<td class="px-2 py-2">Adi Kusrianto</td>
										<td class="px-2 py-2">979-20-1828-X</td>
										<td class="px-2 py-2">ELEX MEDIA</td>
										<td class="px-2 py-2">2000</td>
										<td class="px-2 py-2">5.3</td>
										<td class="px-2 py-2">Edisi 1</td>
										<td class="px-2 py-2">APLIKASI</td>
										<td class="px-2 py-2">1</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="d-flex flex-wrap align-items-center gap-3">
						<a href="{{ route('admin.books.library.export.template') }}" class="btn btn-primary px-4">
							<i class="bi bi-download me-2"></i> Download Template (.xlsx)
						</a>
						<div class="alert alert-warning d-inline-flex align-items-center gap-2 py-2 px-3 mb-0 small">
							<i class="bi bi-exclamation-triangle-fill text-warning"></i>
							<span>* = wajib diisi.</span>
						</div>
					</div>
				</div>
			</div>

			<!-- STEP 2: Upload & Preview -->
			<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
				<div class="card-header text-white py-3" style="background: linear-gradient(135deg, #059669, #0d9488);">
					<div class="d-flex align-items-center gap-2">
						<span class="badge bg-white text-success fw-bold rounded-circle px-2">2</span>
						<div>
							<h5 class="mb-0 fw-bold">Upload & Preview Data</h5>
							<p class="mb-0 small opacity-75">Upload file Excel, lalu cek preview sebelum menyimpan ke database</p>
						</div>
					</div>
				</div>
				<div class="card-body p-4">

					<!-- Upload Form -->
					<form id="preview-form" action="{{ route('admin.books.library.import.preview') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="mb-4">
							<label for="excel_file" class="form-label fw-semibold small text-uppercase text-secondary">
								Pilih File Excel
							</label>
							<!-- Drop Zone -->
							<div class="border border-2 border-dashed rounded-3 p-4 text-center position-relative"
								id="drop-zone"
								style="border-color: #cbd5e1 !important; cursor: pointer; transition: all 0.2s;"
								onclick="document.getElementById('excel_file').click()"
								ondragover="event.preventDefault(); this.style.borderColor='#059669'; this.style.background='#f0fdf4'"
								ondragleave="this.style.borderColor='#cbd5e1'; this.style.background=''"
								ondrop="handleDrop(event)">
								<div id="drop-content">
									<i class="bi bi-cloud-upload display-5 text-muted d-block mb-2"></i>
									<p class="fw-semibold text-muted mb-1">Klik untuk memilih file atau drag & drop</p>
									<p class="small text-muted">Format: .xlsx, .xls, .csv — Max 10MB</p>
								</div>
								<div id="file-selected" class="d-none">
									<i class="bi bi-file-earmark-check display-5 text-success d-block mb-2"></i>
									<p class="fw-semibold text-success mb-0" id="file-name-display">File dipilih</p>
								</div>
							</div>
							<input type="file" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv"
								class="d-none" required onchange="handleFileSelect(this)">
							<!-- Tip for XLS compatibility -->
							<div class="alert alert-info d-flex align-items-start gap-2 mt-3 mb-0 py-2 px-3 small">
								<i class="bi bi-info-circle-fill text-info flex-shrink-0 mt-0"></i>
								<div>
									<strong>Tips:</strong> Format <strong>.xlsx</strong> paling direkomendasikan. Jika file <strong>.xls</strong> Anda gagal dibaca (HTML-based export), buka di Microsoft Excel → <em>Save As → Excel Workbook (.xlsx)</em> → upload ulang.
								</div>
							</div>
						</div>

						<button type="submit" class="btn btn-success px-4">
							<i class="bi bi-eye me-2"></i> Preview Data
						</button>
					</form>

					<!-- PREVIEW SECTION (shown after upload) -->
					@if(session('preview_data'))
					<div class="mt-5 pt-4 border-top" id="preview-section">
						<div class="d-flex align-items-center gap-3 mb-3">
							<h5 class="fw-bold text-dark mb-0">
								<i class="bi bi-eye me-2 text-primary"></i>Preview Data Import
							</h5>
							<span class="badge bg-primary rounded-pill">{{ count(session('preview_data')) }} baris</span>
						</div>

						<div class="border rounded-3 overflow-hidden mb-4">
							<div class="table-responsive" style="max-height: 360px; overflow-y: auto;">
								<table class="table table-bordered table-hover table-sm align-middle mb-0 small text-nowrap">
									<thead class="table-light sticky-top">
										<tr>
											<th class="px-3 py-2">No</th>
											<th class="px-3 py-2">No. Reg</th>
											<th class="px-3 py-2">Judul</th>
											<th class="px-3 py-2">Penulis / Pengarang</th>
											<th class="px-3 py-2">ISBN</th>
											<th class="px-3 py-2">Penerbit</th>
											<th class="px-3 py-2">Tahun</th>
											<th class="px-3 py-2">Klasifikasi</th>
											<th class="px-3 py-2">Edisi</th>
											<th class="px-3 py-2">Subjek / Kategori</th>
											<th class="px-3 py-2 text-center">Jumlah</th>
										</tr>
									</thead>
									<tbody>
										@foreach(session('preview_data') as $i => $row)
										<tr class="{{ isset($row['_error']) ? 'table-danger' : '' }}">
											<td class="px-3 text-muted font-monospace">{{ $row['no'] ?? ($i + 1) }}</td>
											<td class="px-3">{{ $row['registration_number'] ?? '—' }}</td>
											<td class="px-3 fw-semibold" style="white-space:normal; min-width: 180px;">
												{{ $row['title'] ?? '—' }}
												@if(isset($row['_error']))
													<br><small class="text-danger">⚠ {{ $row['_error'] }}</small>
												@endif
											</td>
											<td class="px-3">{{ $row['author'] ?? '—' }}</td>
											<td class="px-3 font-monospace">{{ $row['isbn'] ?? '—' }}</td>
											<td class="px-3">{{ $row['publisher'] ?? '—' }}</td>
											<td class="px-3 text-center">{{ $row['publication_year'] ?? '—' }}</td>
											<td class="px-3">{{ $row['klasifikasi'] ?? '—' }}</td>
											<td class="px-3">{{ $row['edisi'] ?? '—' }}</td>
											<td class="px-3">{{ $row['category'] ?? '—' }}</td>
											<td class="px-3 text-center fw-semibold">{{ $row['stock'] ?? 1 }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

						<!-- Confirm Form -->
						<form action="{{ route('admin.books.library.import.confirm') }}" method="POST">
							@csrf
							<input type="hidden" name="preview_key" value="{{ session('preview_key') }}">
							<div class="d-flex flex-wrap gap-2 align-items-center">
								<button type="submit" class="btn btn-primary px-4">
									<i class="bi bi-check-lg me-2"></i>
									Konfirmasi & Simpan ke Database
									<span class="badge bg-white text-primary ms-1">{{ count(session('preview_data')) }} buku</span>
								</button>
								<a href="{{ route('admin.books.library.import.form') }}" class="btn btn-outline-secondary px-4">
									<i class="bi bi-x-lg me-1"></i> Batal
								</a>
							</div>
						</form>
					</div>
					@endif

				</div>
			</div>

			<!-- Nav Links -->
			<div class="d-flex align-items-center gap-3 mt-4 text-sm">
				<a href="{{ route('admin.books.library.show') }}" class="text-muted text-decoration-none small">
					<i class="bi bi-arrow-left me-1"></i> Daftar Buku
				</a>
				<span class="text-muted">|</span>
				<a href="{{ route('admin.books.library.create') }}" class="text-muted text-decoration-none small">
					<i class="bi bi-plus me-1"></i> Input Manual
				</a>
			</div>

		</div>
	</div>
</div>

<script>
function handleFileSelect(input) {
	const dropContent = document.getElementById('drop-content');
	const fileSelected = document.getElementById('file-selected');
	const fileNameDisplay = document.getElementById('file-name-display');
	if (input.files && input.files[0]) {
		dropContent.classList.add('d-none');
		fileSelected.classList.remove('d-none');
		fileNameDisplay.textContent = input.files[0].name;
	}
}
function handleDrop(e) {
	e.preventDefault();
	const dz = document.getElementById('drop-zone');
	dz.style.borderColor = '#cbd5e1';
	dz.style.background = '';
	const fileInput = document.getElementById('excel_file');
	fileInput.files = e.dataTransfer.files;
	handleFileSelect(fileInput);
}
</script>
@endsection