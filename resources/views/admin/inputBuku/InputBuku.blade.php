@extends('layout.app')

@section('title', 'Input Buku Digital')

@section('content')
<section class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
	<div class="mx-auto max-w-4xl px-6 pb-20 pt-8">
		<!-- Header -->
		<div class="mb-8">
			<div class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-2 mb-4">
				<span class="h-2 w-2 rounded-full bg-blue-600"></span>
				<span class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Tambah Koleksi</span>
			</div>
			<h1 class="text-4xl font-bold text-slate-900 mb-2">📖 Tambah Buku Digital</h1>
			<p class="text-slate-600">Unggah buku PDF baru ke katalog perpustakaan digital Anda dengan informasi lengkap dan terperinci.</p>
		</div>

		<!-- Success Alert -->
		@if (session('success'))
			<div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm animate-pulse">
				<div class="flex items-start gap-3">
					<div class="mt-0.5">
						<svg class="h-5 w-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
						</svg>
					</div>
					<div>
						<p class="font-semibold text-emerald-900">✅ Berhasil!</p>
						<p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
					</div>
				</div>
			</div>
		@endif

		<!-- Error Alert -->
		@if ($errors->any())
			<div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-5 shadow-sm">
				<div class="flex items-start gap-3">
					<div class="mt-0.5">
						<svg class="h-5 w-5 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
						</svg>
					</div>
					<div class="flex-1">
						<p class="font-semibold text-rose-900">⚠️ Terjadi Kesalahan</p>
						<ul class="mt-3 space-y-2">
							@foreach ($errors->all() as $error)
								<li class="text-sm text-rose-700 flex items-start gap-2">
									<span class="inline-block w-1.5 h-1.5 bg-rose-600 rounded-full mt-1.5 flex-shrink-0"></span>
									{{ $error }}
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endif

		<!-- Form Card -->
		<div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-lg">
			<form action="{{ route('admin.books.store') }}" method="POST" class="grid gap-8" novalidate enctype="multipart/form-data">
				@csrf

				<!-- Section: Informasi Dasar -->
				<div class="border-b-2 border-slate-100 pb-6">
					<h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
						<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-semibold">1</span>
						Informasi Dasar Buku
					</h2>

					<div class="grid gap-6 md:grid-cols-2">
						<div>
							<label for="title" class="block text-sm font-semibold text-slate-700 mb-2">📖 Judul Buku <span class="text-rose-500">*</span></label>
							<input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Contoh: Clean Code - A Handbook of Agile Software" required
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 {{ $errors->has('title') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('title')
								<p class="mt-2 text-xs text-rose-600 flex items-center gap-1">
									<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
									{{ $message }}
								</p>
							@enderror
						</div>
						<div>
							<label for="author" class="block text-sm font-semibold text-slate-700 mb-2">✍️ Penulis <span class="text-rose-500">*</span></label>
							<input type="text" name="author" id="author" value="{{ old('author') }}" placeholder="Contoh: Robert C. Martin" required
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 {{ $errors->has('author') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('author')
								<p class="mt-2 text-xs text-rose-600 flex items-center gap-1">
									<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
									{{ $message }}
								</p>
							@enderror
						</div>
					</div>
				</div>

				<!-- Section: Detail Publikasi -->
				<div class="border-b-2 border-slate-100 pb-6">
					<h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
						<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 text-purple-600 font-semibold">2</span>
						Detail Publikasi
					</h2>

					<div class="grid gap-6 md:grid-cols-3">
						<div>
							<label for="publication_year" class="block text-sm font-semibold text-slate-700 mb-2">📅 Tahun Terbit <span class="text-rose-500">*</span></label>
							<input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year', now()->year) }}" min="1900" max="2100" required
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200 {{ $errors->has('publication_year') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('publication_year')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label for="publisher" class="block text-sm font-semibold text-slate-700 mb-2">🏢 Penerbit <span class="text-rose-500">*</span></label>
							<input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" placeholder="Contoh: Prentice Hall" required
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200 {{ $errors->has('publisher') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('publisher')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label for="category" class="block text-sm font-semibold text-slate-700 mb-2">🏷️ Kategori <span class="text-slate-400 font-normal">(opsional)</span></label>
							<input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="Contoh: Programming"
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200">
							@error('category')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>

				<!-- Section: Identifikasi & Status -->
				<div class="border-b-2 border-slate-100 pb-6">
					<h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
						<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 text-amber-600 font-semibold">3</span>
						Identifikasi & Status
					</h2>

					<div class="grid gap-6 md:grid-cols-2">
						<div>
							<label for="isbn" class="block text-sm font-semibold text-slate-700 mb-2">🔢 ISBN <span class="text-slate-400 font-normal">(opsional)</span></label>
							<input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" placeholder="Sesuaikan Dengan Nomor Buku"
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 {{ $errors->has('isbn') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('isbn')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
							<p class="mt-2 text-xs text-slate-500">Boleh ISBN standar atau nomor identitas buku apapun (opsional)</p>
						</div>
						<div>
							<label for="status" class="block text-sm font-semibold text-slate-700 mb-2">✅ Status Ketersediaan <span class="text-rose-500">*</span></label>
							<select name="status" id="status" required
									class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 {{ $errors->has('status') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
								<option value="" disabled selected>-- Pilih Status --</option>
								<option value="available" @selected(old('status') === 'available')>✓ Tersedia</option>
								<option value="unavailable" @selected(old('status') === 'unavailable')>✗ Tidak Tersedia</option>
							</select>
							@error('status')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>

				<!-- Section: Konten & Media -->
				<div class="border-b-2 border-slate-100 pb-6">
					<h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
						<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-cyan-100 text-cyan-600 font-semibold">4</span>
						Konten & Media
					</h2>

					<div class="grid gap-6 md:grid-cols-2">
						<div>
							<label for="cover_url" class="block text-sm font-semibold text-slate-700 mb-2">🖼️ URL Sampul Buku <span class="text-slate-400 font-normal">(opsional)</span></label>
							<input type="url" name="cover_url" id="cover_url" value="{{ old('cover_url') }}"
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200"
								   placeholder="https://images.example.com/cover.jpg">
							@error('cover_url')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
							<p class="mt-2 text-xs text-slate-500">URL lengkap dengan protokol https://</p>
						</div>
						<div>
							<label for="stock" class="block text-sm font-semibold text-slate-700 mb-2">📦 Jumlah Eksemplar <span class="text-slate-400 font-normal">(opsional)</span></label>
							<input type="number" name="stock" id="stock" value="{{ old('stock', 1) }}" min="0"
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200">
							@error('stock')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
							<p class="mt-2 text-xs text-slate-500">Jumlah copy fisik yang tersedia</p>
						</div>
					</div>

					<!-- PDF File Upload -->
					<div class="mt-6">
						<label for="pdf_file" class="block text-sm font-semibold text-slate-700 mb-3">📄 Upload File PDF <span class="text-rose-500">*</span></label>
						<div class="relative">
							<input type="file" name="pdf_file" id="pdf_file" accept="application/pdf" required
								   class="w-full rounded-lg border-2 border-dashed border-slate-300 px-6 py-8 text-sm transition cursor-pointer hover:border-cyan-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 file:mr-4 file:rounded-lg file:border-0 file:bg-cyan-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-cyan-600 {{ $errors->has('pdf_file') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
						</div>
						@error('pdf_file')
							<p class="mt-3 text-xs text-rose-600 flex items-center gap-1">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
								{{ $message }}
							</p>
						@enderror
						<div class="mt-4 grid grid-cols-3 gap-3 text-xs text-slate-600 bg-blue-50 rounded-lg p-4">
							<div class="flex items-start gap-2">
								<svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
								<span>Format: PDF</span>
							</div>
							<div class="flex items-start gap-2">
								<svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
								<span>Max: 20MB</span>
							</div>
							<div class="flex items-start gap-2">
								<svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
								<span>Wajib diisi</span>
							</div>
						</div>
					</div>

					<!-- Summary Textarea -->
					<div class="mt-6">
						<label for="summary" class="block text-sm font-semibold text-slate-700 mb-3">📝 Ringkasan / Sinopsis <span class="text-slate-400 font-normal">(opsional)</span></label>
						<textarea name="summary" id="summary" rows="5" placeholder="Deskripsikan konten buku, tujuan pembelajaran, atau ringkasan singkat..."
								  class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 {{ $errors->has('summary') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">{{ old('summary') }}</textarea>
						@error('summary')
							<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
						@enderror
						<p class="mt-2 text-xs text-slate-500">Berikan deskripsi singkat tentang buku untuk membantu pengguna mencari buku yang tepat</p>
					</div>
				</div>

				<!-- Action Buttons -->
				<div class="flex flex-wrap items-center gap-4 pt-4 border-t border-slate-100">
					<button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:shadow-xl hover:from-blue-700 hover:to-blue-800 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
						<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8m0 8l-6 2m6-2l6 2m0-11l-9-2-9 2" />
						</svg>
						💾 Simpan Buku
					</button>
					<a href="{{ route('admin.books.show') }}" class="inline-flex items-center gap-2 rounded-lg border-2 border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:border-slate-400">
						<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
						</svg>
						📚 Lihat Daftar Buku
					</a>
					<a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900">
						↩️ Kembali ke Dashboard
					</a>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
