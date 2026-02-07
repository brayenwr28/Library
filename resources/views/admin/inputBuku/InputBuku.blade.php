@extends('layouts.app')

@section('title', 'Input Buku')

@section('content')
<section class="bg-slate-50">
	<div class="mx-auto max-w-4xl px-6 pb-20 pt-32">
		<div class="mb-10">
			<h1 class="text-3xl font-semibold text-slate-900">Form Input Buku</h1>
			<p class="mt-2 text-sm text-slate-600">Tambahkan data buku agar muncul di katalog digital perpustakaan.</p>
		</div>  

		@if (session('success'))
			<div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
				{{ session('success') }}
			</div>
		@endif

		@if ($errors->any())
			<div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
				<p class="font-semibold">Terjadi kesalahan:</p>
				<ul class="mt-2 space-y-1">
					@foreach ($errors->all() as $error)
						<li>• {{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
			<form action="{{ route('admin.books.store') }}" method="POST" class="grid gap-6" novalidate enctype="multipart/form-data">
				@csrf

				<div class="grid gap-6 md:grid-cols-2">
					<div>
						<label for="title" class="text-sm font-medium text-slate-600">Judul Buku *</label>
						<input type="text" name="title" id="title" value="{{ old('title') }}" required
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					</div>
					<div>
						<label for="author" class="text-sm font-medium text-slate-600">Penulis *</label>
						<input type="text" name="author" id="author" value="{{ old('author') }}" required
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					</div>
				</div>

				<div class="grid gap-6 md:grid-cols-3">
					<div>
						<label for="publication_year" class="text-sm font-medium text-slate-600">Tahun Terbit *</label>
						<input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year') }}" min="1900" max="2100" required
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					</div>
					<div>
						<label for="publisher" class="text-sm font-medium text-slate-600">Penerbit *</label>
						<input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" required
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					</div>
					<div>
						<label for="category" class="text-sm font-medium text-slate-600">Kategori</label>
						<input type="text" name="category" id="category" value="{{ old('category') }}"
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					</div>
				</div>

				<div class="grid gap-6 md:grid-cols-2">
					<div>
						<label for="isbn" class="text-sm font-medium text-slate-600">ISBN</label>
						<input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					</div>
					<div>
						<label for="status" class="text-sm font-medium text-slate-600">Status *</label>
						<select name="status" id="status" required
								class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
							<option value="available" @selected(old('status') === 'available')>Tersedia</option>
							<option value="unavailable" @selected(old('status') === 'unavailable')>Tidak Tersedia</option>
						</select>
					</div>
				</div>

				<div class="grid gap-6 md:grid-cols-2">
					<div>
						<label for="cover_url" class="text-sm font-medium text-slate-600">URL Sampul (opsional)</label>
						<input type="url" name="cover_url" id="cover_url" value="{{ old('cover_url') }}"
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
							   placeholder="https://...">
					</div>
					<div>
						<label for="stock" class="text-sm font-medium text-slate-600">Jumlah Eksemplar</label>
						<input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0"
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					</div>
				</div>

				<div>
					<label for="pdf_file" class="text-sm font-medium text-slate-600">File PDF Buku *</label>
					<input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" required
						   class="mt-2 w-full rounded-lg border border-dashed border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					<p class="mt-2 text-xs text-slate-500">Format PDF, maksimal 20MB. File akan disimpan di penyimpanan lokal.</p>
				</div>

				<div class="md:col-span-2">
					<label for="summary" class="text-sm font-medium text-slate-600">Ringkasan</label>
					<textarea name="summary" id="summary" rows="4"
							  class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">{{ old('summary') }}</textarea>
				</div>

				<div class="flex flex-wrap items-center gap-3 pt-2">
					<button type="submit" class="rounded-lg bg-slate-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-700">
						Simpan Buku
					</button>
					<a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-700">
						Kembali ke Dashboard
					</a>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
