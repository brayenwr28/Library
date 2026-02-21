@extends('layout.app')

@section('title', 'Input Buku Perpustakaan')

@section('content')
<section class="bg-gradient-to-br from-slate-50 to-emerald-50 min-h-screen">
	<div class="mx-auto max-w-5xl px-6 pb-20 pt-8">
		<!-- Header -->
		<div class="mb-8">
			<div class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 mb-4">
				<span class="h-2 w-2 rounded-full bg-emerald-600"></span>
				<span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">Koleksi Fisik</span>
			</div>
			<h1 class="text-4xl font-bold text-slate-900 mb-2">🏢 Input Buku Perpustakaan</h1>
			<p class="text-slate-600">Kelola koleksi buku fisik dengan data lengkap termasuk sampul, stok, dan kategori untuk perpustakaan Anda.</p>
		</div>

		<!-- Success Alert -->
		@if (session('success'))
			<div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm animate-pulse">
				<div class="flex items-start gap-3">
					<svg class="h-5 w-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
					</svg>
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
					<svg class="h-5 w-5 text-rose-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
					</svg>
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
			<form action="{{ route('admin.books.library.store') }}" method="POST" class="grid gap-8" enctype="multipart/form-data" novalidate>
				@csrf

				<!-- Section: Upload Sampul Buku -->
				<div class="border-b-2 border-slate-100 pb-6">
					<h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
						<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 font-semibold">1</span>
						Sampul Buku
					</h2>

					<div>
						<!-- Cover Image Upload -->
						<div>
							<label for="cover_image" class="block text-sm font-semibold text-slate-700 mb-3">🖼️ Upload Sampul Buku <span class="text-slate-400 font-normal">(opsional)</span></label>
							<div class="relative">
								<input type="file" name="cover_image" id="cover_image" accept="image/png,image/jpeg,image/jpg"
									   class="w-full rounded-lg border-2 border-dashed border-slate-300 px-6 py-8 text-sm transition cursor-pointer hover:border-emerald-500 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-600 {{ $errors->has('cover_image') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							</div>
							@error('cover_image')
								<p class="mt-3 text-xs text-rose-600">{{ $message }}</p>
							@enderror
							<div class="mt-3 grid grid-cols-3 gap-2 text-xs text-slate-600 bg-emerald-50 rounded-lg p-3">
								<div class="flex items-start gap-2">
									<svg class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
									<span>JPG, PNG</span>
								</div>
								<div class="flex items-start gap-2">
									<svg class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
									<span>Max 2MB</span>
								</div>
								<div class="flex items-start gap-2">
									<svg class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
									<span>Opsional</span>
								</div>
							</div>
						</div>
					</div>
				</div>
<!-- Section: Informasi Dasar -->
				<div class="border-b-2 border-slate-100 pb-6">
					<h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
						<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-semibold">2</span>
						Informasi Dasar Buku
					</h2>

					<div class="grid gap-6 md:grid-cols-2">
						<div>
							<label for="title" class="block text-sm font-semibold text-slate-700 mb-2">📖 Judul Buku <span class="text-rose-500">*</span></label>
							<input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Exp: Harry Potter and the Philosopher's Stone" required
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 {{ $errors->has('title') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('title')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label for="author" class="block text-sm font-semibold text-slate-700 mb-2">📚 Pengarang <span class="text-rose-500">*</span></label>
							<input type="text" id="author" name="author" value="{{ old('author') }}" placeholder="Exp: J.K. Rowling" required
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 {{ $errors->has('author') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('author')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>

				<!-- Section: Detail Publikasi -->
				<div class="border-b-2 border-slate-100 pb-6">
					<h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
						<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 text-purple-600 font-semibold">3</span>
						Detail Publikasi
					</h2>

					<div class="grid gap-6 md:grid-cols-3">
						<div>
							<label for="publisher" class="block text-sm font-semibold text-slate-700 mb-2">🏢 Penerbit <span class="text-rose-500">*</span></label>
							<input type="text" id="publisher" name="publisher" value="{{ old('publisher') }}" placeholder="Exp: Bloomsbury Publishing" required
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200 {{ $errors->has('publisher') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('publisher')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label for="publication_year" class="block text-sm font-semibold text-slate-700 mb-2">📅 Tahun Terbit <span class="text-slate-400 font-normal">(opsional)</span></label>
							<input type="number" id="publication_year" name="publication_year" value="{{ old('publication_year', now()->year) }}" min="1900" max="2100"
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200 {{ $errors->has('publication_year') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('publication_year')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label for="category" class="block text-sm font-semibold text-slate-700 mb-2">🏷️ Kategori <span class="text-slate-400 font-normal">(opsional)</span></label>
							<input type="text" id="category" name="category" value="{{ old('category') }}" placeholder="Exp: Fantasy, Fiction"
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200">
							@error('category')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
					</div>
				</div>

				<!-- Section: Identifikasi & Stok -->
				<div class="border-b-2 border-slate-100 pb-6">
					<h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
						<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 text-amber-600 font-semibold">4</span>
						Identifikasi & Inventaris
					</h2>

					<div class="grid gap-6 md:grid-cols-2">
						<div>
							<label for="isbn" class="block text-sm font-semibold text-slate-700 mb-2">🔢 ISBN <span class="text-slate-400 font-normal">(opsional)</span></label>
							<input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" placeholder="Sesuaikan Dengan Nomor Buku"
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 {{ $errors->has('isbn') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('isbn')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label for="stock" class="block text-sm font-semibold text-slate-700 mb-2">📦 Jumlah Stok <span class="text-slate-400 font-normal">(opsional)</span></label>
							<input type="number" id="stock" name="stock" value="{{ old('stock', 1) }}" min="0" max="9999"
								   class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200 {{ $errors->has('stock') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">
							@error('stock')
								<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
							@enderror
							<p class="mt-2 text-xs text-slate-500">Jumlah copy fisik yang tersedia di perpustakaan</p>
						</div>
					</div>

					<div>
						<label for="status" class="block text-sm font-semibold text-slate-700 mb-2">✅ Status Ketersediaan <span class="text-rose-500">*</span></label>
						<select id="status" name="status" required
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

				<!-- Section: Deskripsi -->
				<div>
					<label for="summary" class="block text-sm font-semibold text-slate-700 mb-3">📝 Ringkasan / Sinopsis <span class="text-slate-400 font-normal">(opsional)</span></label>
					<textarea id="summary" name="summary" rows="5" placeholder="Deskripsikan singkat tentang isi buku, tujuan, dan topik utama untuk membantu pembaca mencari buku yang tepat..."
							  class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200 {{ $errors->has('summary') ? 'border-rose-500 ring-2 ring-rose-200' : '' }}">{{ old('summary') }}</textarea>
					@error('summary')
						<p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
					@enderror
				</div>

				<!-- Action Buttons -->
				<div class="flex flex-wrap items-center gap-4 pt-4 border-t border-slate-100">
					<button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:shadow-xl hover:from-emerald-700 hover:to-emerald-800 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
						<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8m0 8l-6 2m6-2l6 2m0-11l-9-2-9 2" />
						</svg>
						💾 Simpan Buku
					</button>
					<a href="{{ route('admin.books.library.index') }}" class="inline-flex items-center gap-2 rounded-lg border-2 border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:border-slate-400">
						<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
						</svg>
						Lihat Daftar Buku
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
