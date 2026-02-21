@extends('layout.app')

@section('title', 'Edit Buku Digital')

@section('content')
<section class="bg-slate-50">
	<div class="mx-auto max-w-4xl px-6 pb-20 pt-32">
		<div class="mb-10">
			<h1 class="text-3xl font-semibold text-slate-900">✏️ Edit Buku Digital</h1>
			<p class="mt-2 text-sm text-slate-600">Perbarui informasi buku: <strong>{{ $book->title }}</strong></p>
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
			<form action="{{ route('admin.books.update', $book) }}" method="POST" class="grid gap-6" novalidate enctype="multipart/form-data">
				@csrf
				@method('PUT')

				<div class="grid gap-6 md:grid-cols-2">
					<div>
						<label for="title" class="text-sm font-medium text-slate-600">Judul Buku *</label>
						<input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
						@error('title')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
					<div>
						<label for="author" class="text-sm font-medium text-slate-600">Penulis *</label>
						<input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
						@error('author')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				<div class="grid gap-6 md:grid-cols-3">
					<div>
						<label for="publication_year" class="text-sm font-medium text-slate-600">Tahun Terbit *</label>
						<input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year', $book->publication_year) }}" min="1900" max="2100" required
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
						@error('publication_year')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
					<div>
						<label for="publisher" class="text-sm font-medium text-slate-600">Penerbit *</label>
						<input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}" required
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
						@error('publisher')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
					<div>
						<label for="category" class="text-sm font-medium text-slate-600">Kategori</label>
						<input type="text" name="category" id="category" value="{{ old('category', $book->category) }}"
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
						@error('category')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				<div class="grid gap-6 md:grid-cols-2">
					<div>
						<label for="isbn" class="text-sm font-medium text-slate-600">ISBN</label>
						<input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
						@error('isbn')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
					<div>
						<label for="status" class="text-sm font-medium text-slate-600">Status *</label>
						<select name="status" id="status" required
								class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
							<option value="available" @selected(old('status', $book->status) === 'available')>Tersedia</option>
							<option value="unavailable" @selected(old('status', $book->status) === 'unavailable')>Tidak Tersedia</option>
						</select>
						@error('status')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				<div class="grid gap-6 md:grid-cols-2">
					<div>
						<label for="cover_url" class="text-sm font-medium text-slate-600">URL Sampul (opsional)</label>
						<input type="url" name="cover_url" id="cover_url" value="{{ old('cover_url', $book->cover_url) }}"
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
							   placeholder="https://...">
						@error('cover_url')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
					<div>
						<label for="stock" class="text-sm font-medium text-slate-600">Jumlah Eksemplar</label>
						<input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock ?? 0) }}" min="0"
							   class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
						@error('stock')
							<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				<div>
					<label for="pdf_file" class="text-sm font-medium text-slate-600">File PDF Buku <span class="text-slate-500">(opsional - untuk mengganti PDF)</span></label>
					<input type="file" name="pdf_file" id="pdf_file" accept="application/pdf"
						   class="mt-2 w-full rounded-lg border border-dashed border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
					<p class="mt-2 text-xs text-slate-500">Format PDF, maksimal 20MB.</p>
					@if ($book->pdf_path)
						<div class="mt-3 flex items-center gap-2 rounded-lg border border-blue-200 bg-blue-50 p-3">
							<svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
							</svg>
							<div>
								<p class="text-xs font-medium text-blue-700">PDF saat ini sudah diunggah</p>
								<p class="text-xs text-blue-600">Upload file baru untuk mengganti</p>
							</div>
						</div>
					@endif
					@error('pdf_file')
						<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="summary" class="text-sm font-medium text-slate-600">Ringkasan</label>
					<textarea name="summary" id="summary" rows="4"
							  class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">{{ old('summary', $book->summary) }}</textarea>
					@error('summary')
						<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div class="flex flex-wrap items-center gap-3 pt-2">
					<button type="submit" class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
						💾 Simpan Perubahan
					</button>
					<a href="{{ route('admin.books.show') }}" class="rounded-lg border border-slate-300 px-5 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
						↩️ Batal
					</a>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
