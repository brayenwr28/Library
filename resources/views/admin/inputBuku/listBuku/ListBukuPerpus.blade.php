@extends('layout.app')

@section('title', 'Daftar Koleksi Perpustakaan')

@section('content')
<div class="py-4">

	<!-- Header -->
	<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 border-bottom mb-4">
		<div>
			<p class="text-primary fw-bold small text-uppercase tracking-wide mb-1">
				<i class="bi bi-building me-1"></i> Koleksi Perpustakaan
			</p>
			<h1 class="h3 fw-extrabold text-dark mb-1">Daftar Buku Perpustakaan</h1>
			<p class="text-muted small mb-0">
				Total: <span class="fw-semibold text-dark">{{ $perpusses->total() }}</span> buku terdaftar
			</p>
		</div>
		<div class="d-flex flex-wrap gap-2">
			<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm px-3">
				<i class="bi bi-arrow-left me-1"></i> Dashboard
			</a>
			<a href="{{ route('admin.books.library.export.template') }}" class="btn btn-outline-success btn-sm px-3">
				<i class="bi bi-download me-1"></i> Template Excel
			</a>
			<a href="{{ route('admin.books.library.export') }}" class="btn btn-success btn-sm px-3">
				<i class="bi bi-file-earmark-excel me-1"></i> Export Excel
			</a>
			<a href="{{ route('admin.books.library.import.form') }}" class="btn btn-warning btn-sm px-3 text-dark">
				<i class="bi bi-upload me-1"></i> Import Excel
			</a>
			<a href="{{ route('admin.books.library.create') }}" class="btn btn-primary btn-sm px-3">
				<i class="bi bi-plus-lg me-1"></i> Tambah Buku
			</a>
		</div>
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

	<!-- Search Bar -->
	<form method="GET" action="{{ route('admin.books.library.show') }}" class="mb-4">
		<div class="input-group shadow-sm">
			<span class="input-group-text bg-white border-end-0">
				<i class="bi bi-search text-muted"></i>
			</span>
			<input type="search" name="q" id="search"
				value="{{ $search ?? '' }}"
				placeholder="Cari judul, penulis, penerbit, ISBN, klasifikasi..."
				class="form-control border-start-0 ps-0">
			@if(!empty($search))
				<a href="{{ route('admin.books.library.show') }}" class="btn btn-outline-secondary">
					<i class="bi bi-x-lg"></i>
				</a>
			@endif
			<button type="submit" class="btn btn-dark px-4">
				<i class="bi bi-search me-1"></i> Cari
			</button>
		</div>
	</form>

	<!-- Table Card -->
	<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
		<div class="table-responsive">
			<table class="table table-hover align-middle mb-0">
				<thead class="table-light border-bottom">
					<tr>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase" style="width:50px">No.</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase">No. Reg</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase">Judul Buku</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase">Penulis</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase">ISBN</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase">Penerbit</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase text-center">Tahun</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase">Klasifikasi</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase text-center">Jumlah</th>
						<th class="px-3 py-3 text-muted small fw-bold text-uppercase text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($perpusses as $index => $book)
						<tr>
							<td class="px-3 text-muted small font-monospace">
								{{ $perpusses->firstItem() + $index }}
							</td>
							<td class="px-3">
								@if($book->registration_number)
									<span class="badge bg-secondary-subtle text-secondary fw-normal font-monospace small">
										{{ $book->registration_number }}
									</span>
								@else
									<span class="text-muted">—</span>
								@endif
							</td>
							<td class="px-3" style="max-width: 220px;">
								<div class="fw-semibold text-dark small" style="white-space:normal;line-height:1.4">{{ $book->title }}</div>
								@if($book->category)
									<span class="badge bg-primary-subtle text-primary fw-normal mt-1 small">{{ $book->category }}</span>
								@endif
							</td>
							<td class="px-3 small text-muted">{{ $book->author }}</td>
							<td class="px-3 font-monospace small text-muted">{{ $book->isbn ?? '—' }}</td>
							<td class="px-3 small text-muted">{{ $book->publisher ?? '—' }}</td>
							<td class="px-3 small text-center text-muted">{{ $book->publication_year ?? '—' }}</td>
							<td class="px-3 small text-muted">{{ $book->klasifikasi ?? '—' }}</td>
							<td class="px-3 text-center">
								<span class="badge rounded-pill {{ ($book->stock ?? 0) > 0 ? 'bg-primary' : 'bg-secondary' }} px-3 py-2">
									{{ $book->stock ?? 0 }}
								</span>
							</td>
							<td class="px-3 text-center">
								<div class="d-flex justify-content-center gap-1">
									<a href="{{ route('admin.books.library.edit', $book) }}"
										class="btn btn-outline-primary btn-sm px-2 py-1">
										<i class="bi bi-pencil me-1"></i>Edit
									</a>
									<form action="{{ route('admin.books.library.destroy', $book) }}" method="POST"
										onsubmit="return confirm('Hapus buku \'{{ addslashes($book->title) }}\' dari katalog?');" class="d-inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger btn-sm px-2 py-1">
											<i class="bi bi-trash me-1"></i>Hapus
										</button>
									</form>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="10" class="text-center py-5">
								<div class="text-muted">
									<i class="bi bi-journal-x display-5 d-block mb-3 text-secondary opacity-50"></i>
									<p class="fw-semibold mb-1">Belum ada buku yang terdaftar</p>
									<p class="small mb-3">Tambahkan buku baru atau import dari Excel</p>
									<div class="d-flex justify-content-center gap-2">
										<a href="{{ route('admin.books.library.create') }}" class="btn btn-primary btn-sm">
											<i class="bi bi-plus-lg me-1"></i>Tambah Manual
										</a>
										<a href="{{ route('admin.books.library.import.form') }}" class="btn btn-success btn-sm">
											<i class="bi bi-file-earmark-excel me-1"></i>Import Excel
										</a>
									</div>
								</div>
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		<!-- Pagination -->
		@if($perpusses->hasPages())
			<div class="card-footer bg-light border-top d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 py-3 px-4">
				<p class="text-muted small mb-0">
					Menampilkan <strong>{{ $perpusses->firstItem() }}–{{ $perpusses->lastItem() }}</strong>
					dari <strong>{{ $perpusses->total() }}</strong> buku
				</p>
				<nav aria-label="Pagination">
					<ul class="pagination pagination-sm mb-0">
						{{-- Previous --}}
						<li class="page-item {{ $perpusses->onFirstPage() ? 'disabled' : '' }}">
							<a class="page-link" href="{{ $perpusses->onFirstPage() ? '#' : $perpusses->appends(['q' => $search])->previousPageUrl() }}">
								<i class="bi bi-chevron-left"></i>
							</a>
						</li>

						{{-- Page numbers --}}
						@foreach($perpusses->appends(['q' => $search])->getUrlRange(max(1, $perpusses->currentPage()-2), min($perpusses->lastPage(), $perpusses->currentPage()+2)) as $page => $url)
							<li class="page-item {{ $page == $perpusses->currentPage() ? 'active' : '' }}">
								<a class="page-link" href="{{ $url }}">{{ $page }}</a>
							</li>
						@endforeach

						{{-- Next --}}
						<li class="page-item {{ !$perpusses->hasMorePages() ? 'disabled' : '' }}">
							<a class="page-link" href="{{ $perpusses->hasMorePages() ? $perpusses->appends(['q' => $search])->nextPageUrl() : '#' }}">
								<i class="bi bi-chevron-right"></i>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		@endif
	</div>

</div>
@endsection