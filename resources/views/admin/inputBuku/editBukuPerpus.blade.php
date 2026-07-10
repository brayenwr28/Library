@extends('layout.app')

@section('title', 'Edit Buku Perpustakaan')

@section('content')
	<div class="py-4">
		<div class="row justify-content-center">
			<div class="col-lg-9 col-xl-8">

				<!-- Header -->
				<div class="mb-4">
					<div class="d-flex align-items-center gap-2 mb-2">
						<span class="badge bg-warning-subtle text-warning fw-semibold px-3 py-2 rounded-pill">
							<i class="bi bi-pencil me-1"></i> Edit Buku
						</span>
					</div>
					<h1 class="h3 fw-bold text-dark mb-1">✏️ Edit Buku Perpustakaan</h1>
					<p class="text-muted small mb-0">Perbarui informasi buku: <strong>{{ $perpuss->title }}</strong></p>
				</div>

				<!-- Success Alert -->
				@if (session('success'))
					<div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
						<i class="bi bi-check-circle-fill"></i>
						<span>{{ session('success') }}</span>
						<button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
					</div>
				@endif

				<!-- Error Alert -->
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

				<!-- Form Card -->
				<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
					<!-- Card Header -->
					<div class="card-header text-white py-3" style="background: linear-gradient(135deg, #d97706, #b45309);">
						<h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Perbarui Data Buku</h5>
						<p class="mb-0 small opacity-75">Ubah informasi yang ingin diperbarui</p>
					</div>

					<div class="card-body p-4">
						<form action="{{ route('admin.books.library.update', $perpuss) }}" method="POST"
							enctype="multipart/form-data" novalidate>
							@csrf
							@method('PUT')

							<!-- Row 1: No. Registrasi + Judul Buku -->
							<div class="row g-3 mb-3">
								<div class="col-md-5">
									<label for="registration_number"
										class="form-label fw-semibold small text-uppercase text-secondary">
										No. Registrasi
									</label>
									<input type="text" id="registration_number" name="registration_number"
										value="{{ old('registration_number', $perpuss->registration_number) }}"
										placeholder="Contoh: 1.000176" class="form-control">
								</div>
								<div class="col-md-7">
									<label for="title" class="form-label fw-semibold small text-uppercase text-secondary">
										Judul Buku <span class="text-danger">*</span>
									</label>
									<input type="text" id="title" name="title" value="{{ old('title', $perpuss->title) }}"
										required class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
									@error('title')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>

							<!-- Row 2: Penulis / Pengarang + ISBN -->
							<div class="row g-3 mb-3">
								<div class="col-md-7">
									<label for="author" class="form-label fw-semibold small text-uppercase text-secondary">
										Penulis / Pengarang <span class="text-danger">*</span>
									</label>
									<input type="text" id="author" name="author"
										value="{{ old('author', $perpuss->author) }}" required
										class="form-control {{ $errors->has('author') ? 'is-invalid' : '' }}">
									@error('author')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-5">
									<label for="isbn" class="form-label fw-semibold small text-uppercase text-secondary">
										ISBN
									</label>
									<input type="text" id="isbn" name="isbn" value="{{ old('isbn', $perpuss->isbn) }}"
										placeholder="Contoh: 979-20-1828-X"
										class="form-control {{ $errors->has('isbn') ? 'is-invalid' : '' }}">
									@error('isbn')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>

							<!-- Row 3: Penerbit + Tahun -->
							<div class="row g-3 mb-3">
								<div class="col-md-8">
									<label for="publisher"
										class="form-label fw-semibold small text-uppercase text-secondary">
										Penerbit <span class="text-danger">*</span>
									</label>
									<input type="text" id="publisher" name="publisher"
										value="{{ old('publisher', $perpuss->publisher) }}" required
										class="form-control {{ $errors->has('publisher') ? 'is-invalid' : '' }}">
									@error('publisher')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-4">
									<label for="publication_year"
										class="form-label fw-semibold small text-uppercase text-secondary">
										Tahun
									</label>
									<input type="number" id="publication_year" name="publication_year"
										value="{{ old('publication_year', $perpuss->publication_year) }}" min="1900"
										max="2100"
										class="form-control {{ $errors->has('publication_year') ? 'is-invalid' : '' }}">
									@error('publication_year')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>

							<!-- Row 4: Klasifikasi + Edisi -->
							<div class="row g-3 mb-3">
								<div class="col-md-6">
									<label for="klasifikasi"
										class="form-label fw-semibold small text-uppercase text-secondary">
										Klasifikasi
									</label>
									<input type="text" id="klasifikasi" name="klasifikasi"
										value="{{ old('klasifikasi', $perpuss->klasifikasi) }}" placeholder="Contoh: 5.3"
										class="form-control">
								</div>
								<div class="col-md-6">
									<label for="edisi" class="form-label fw-semibold small text-uppercase text-secondary">
										Edisi
									</label>
									<input type="text" id="edisi" name="edisi" value="{{ old('edisi', $perpuss->edisi) }}"
										placeholder="Contoh: Edisi Revisi, Cetakan 2" class="form-control">
								</div>
							</div>

							<!-- Row 5: Subjek / Kategori + Jumlah -->
							<div class="row g-3 mb-4">
								<div class="col-md-7">
									<label for="category"
										class="form-label fw-semibold small text-uppercase text-secondary">
										Subjek / Kategori
									</label>
									<input type="text" id="category" name="category"
										value="{{ old('category', $perpuss->category) }}"
										placeholder="Contoh: APLIKASI SOFTWARE DAN INTERNET" class="form-control">
								</div>
								<div class="col-md-5">
									<label for="stock" class="form-label fw-semibold small text-uppercase text-secondary">
										Jumlah <span class="text-danger">*</span>
									</label>
									<input type="number" id="stock" name="stock"
										value="{{ old('stock', $perpuss->stock ?? 1) }}" min="0" max="9999" required
										class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}">
									@error('stock')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>

							<!-- Row 6: Status + Sampul Buku -->
							<div class="row g-3 mb-4">
								<div class="col-md-6">
									<label for="status" class="form-label fw-semibold small text-uppercase text-secondary">
										Status Ketersediaan <span class="text-danger">*</span>
									</label>
									<select id="status" name="status" required
										class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}">
										<option value="available" @selected(old('status', $perpuss->status) === 'available')>✓
											Tersedia</option>
										<option value="unavailable" @selected(old('status', $perpuss->status) === 'unavailable')>✗ Tidak Tersedia</option>
									</select>
									@error('status')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-6">
									<label class="form-label fw-semibold small text-uppercase text-secondary">
										Upload Sampul Buku <span class="text-muted fw-normal">(opsional)</span>
									</label>
									@if ($perpuss->cover_path)
										<div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light border rounded-3">
											<img src="{{ asset('storage/' . $perpuss->cover_path) }}"
												alt="{{ $perpuss->title }}" class="rounded-2 shadow-sm border"
												style="height: 80px; width: auto; object-fit: cover;">
											<div>
												<p class="fw-semibold mb-0 small text-dark">Sampul saat ini</p>
												<p class="text-muted small mb-0">Upload gambar baru untuk mengganti</p>
											</div>
										</div>
									@endif
									<input type="file" name="cover_image" id="cover_image"
										accept="image/png,image/jpeg,image/jpg"
										class="form-control {{ $errors->has('cover_image') ? 'is-invalid' : '' }}">
									@error('cover_image')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>

							<hr class="my-4">

							<!-- Action Buttons -->
							<div class="d-flex flex-wrap gap-2 align-items-center">
								<button type="submit" class="btn btn-warning px-4 text-dark fw-semibold">
									<i class="bi bi-floppy me-1"></i> Perbarui Buku
								</button>
								<a href="{{ route('admin.books.library.show') }}" class="btn btn-outline-secondary px-4">
									<i class="bi bi-list-ul me-1"></i> Lihat Daftar Buku
								</a>
								<a href="{{ route('admin.dashboard') }}" class="btn btn-link text-secondary">
									<i class="bi bi-arrow-left me-1"></i> Dashboard
								</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection