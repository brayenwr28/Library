@extends('layout.app')

@section('title', 'Input Koleksi Perpustakaan')

@section('content')
<section class="bg-slate-50">
	<div class="mx-auto max-w-4xl px-6 pb-24 pt-32">
		<header class="mb-10">
			<span class="inline-flex items-center rounded-full bg-white px-4 py-1 text-xs font-semibold uppercase tracking-wide text-slate-500 shadow-sm">Tambah Koleksi</span>
			<h1 class="mt-4 text-3xl font-semibold text-slate-900">Input Buku Perpustakaan</h1>
			<p class="mt-3 max-w-2xl text-sm text-slate-600">Lengkapi data berikut agar buku muncul di halaman daftar koleksi dengan informasi penerbit, kategori, stok, serta sampul digital.</p>
		</header>

		@if (session('success'))
			<div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
				{{ session('success') }}
			</div>
		@endif

		@if ($errors->any())
			<div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
				<p class="font-semibold">Terjadi kesalahan:</p>
				<ul class="mt-2 space-y-1">
					@foreach ($errors->all() as $error)
						<li>• {{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
			<form action="{{ route('admin.books.library.store') }}" method="POST" class="grid gap-6" enctype="multipart/form-data" novalidate>
				@csrf

				<div class="grid gap-6 md:grid-cols-[220px_1fr] md:items-start">
					<div class="flex flex-col gap-3 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-5 text-center">
						<div class="relative mx-auto flex h-28 w-28 items-center justify-center overflow-hidden rounded-2xl bg-white text-4xl text-slate-400">
							<img src="" alt="Pratinjau sampul" class="hidden h-full w-full object-cover" id="cover-preview" />
							<span id="cover-placeholder">📘</span>
						</div>
						<div class="text-xs text-slate-500">
							<p class="font-semibold text-slate-600">Sampul Buku</p>
							<p class="mt-1 leading-relaxed">Unggah gambar JPG atau PNG maksimal 2MB untuk ditampilkan sebagai sampul koleksi.</p>
						</div>
						<input type="file" name="cover_image" accept="image/png,image/jpeg" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs text-slate-600 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
					</div>

					<div class="grid gap-6">
						<div class="grid gap-6 md:grid-cols-2">
							<div>
								<label for="title" class="text-sm font-medium text-slate-600">Judul Buku *</label>
								<input type="text" id="title" name="title" value="{{ old('title') }}" required class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
							</div>
							<div>
								<label for="author" class="text-sm font-medium text-slate-600">Pengarang *</label>
								<input type="text" id="author" name="author" value="{{ old('author') }}" required class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
							</div>
						</div>

						<div class="grid gap-6 md:grid-cols-3">
							<div>
								<label for="publisher" class="text-sm font-medium text-slate-600">Penerbit *</label>
								<input type="text" id="publisher" name="publisher" value="{{ old('publisher') }}" required class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
							</div>
							<div>
								<label for="publication_year" class="text-sm font-medium text-slate-600">Tahun Terbit</label>
								<input type="number" id="publication_year" name="publication_year" value="{{ old('publication_year', now()->year) }}" min="1900" max="2100" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
							</div>
							<div>
								<label for="category" class="text-sm font-medium text-slate-600">Kategori</label>
								<input type="text" id="category" name="category" value="{{ old('category') }}" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
							</div>
						</div>

						<div class="grid gap-6 md:grid-cols-2">
							<div>
								<label for="isbn" class="text-sm font-medium text-slate-600">Nomor ISBN</label>
								<input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
							</div>
							<div class="grid gap-3 md:grid-cols-2">
								<div>
									<label for="status" class="text-sm font-medium text-slate-600">Status *</label>
									<select id="status" name="status" required class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
										<option value="available" @selected(old('status') === 'available')>Tersedia</option>
										<option value="unavailable" @selected(old('status') === 'unavailable')>Tidak Tersedia</option>
									</select>
								</div>
								<div>
									<label for="stock" class="text-sm font-medium text-slate-600">Stok</label>
									<input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" />
								</div>
							</div>
						</div>


						<div>
							<label for="summary" class="text-sm font-medium text-slate-600">Ringkasan</label>
							<textarea id="summary" name="summary" rows="4" class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">{{ old('summary') }}</textarea>
						</div>
					</div>
				</div>

				<div class="flex flex-wrap items-center gap-3 pt-2">
					<button type="submit" class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">Simpan Buku</button>
					<a href="{{ route('admin.books.library.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-700">Lihat daftar buku</a>
				</div>
			</form>
		</div>
	</div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
	var input = document.querySelector('input[name="cover_image"]');
	var preview = document.getElementById('cover-preview');
	var placeholder = document.getElementById('cover-placeholder');

	if (!input || !preview || !placeholder) {
		return;
	}

	preview.addEventListener('load', function () {
		if (preview.src.startsWith('blob:')) {
			URL.revokeObjectURL(preview.src);
		}
	});

	input.addEventListener('change', function (event) {
		var file = event.target.files && event.target.files[0];

		if (!file) {
			preview.classList.add('hidden');
			preview.removeAttribute('src');
			placeholder.classList.remove('hidden');
			return;
		}

		var objectUrl = URL.createObjectURL(file);
		preview.src = objectUrl;
		preview.classList.remove('hidden');
		placeholder.classList.add('hidden');
	});
});
</script>
@endsection
