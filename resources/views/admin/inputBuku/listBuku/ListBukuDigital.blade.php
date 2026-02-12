@extends('layout.app')

@section('title', 'Daftar Koleksi Perpustakaan')

@section('content')
	<section class="bg-slate-50">
		<div class="mx-auto max-w-6xl px-6 pb-20">
			<div class="flex flex-col gap-4 pb-10 pt-10 md:flex-row md:items-center md:justify-between">
				<div>
					<p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Koleksi Perpustakaan</p>
					<h1 class="mt-3 text-3xl font-semibold text-slate-900">Daftar Buku Perpustakaan</h1>
					<p class="mt-2 text-sm text-slate-500">Pantau dan kelola buku fisik yang tersedia di perpustakaan.</p>
				</div>

				<div class="flex flex-col gap-3 sm:flex-row">
					<a href="{{ route('admin.books.library.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-700">
						Tambah Buku
					</a>
					<a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-5 py-3 text-sm font-medium text-slate-600 transition hover:bg-white">Kembali ke Dashboard</a>
				</div>
			</div>

			@if (session('success'))
				<div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
					{{ session('success') }}
				</div>
			@endif

			<form method="GET" action="{{ route('admin.books.library.index') }}" class="mb-8">
				<label for="search" class="sr-only">Cari buku</label>
				<div class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm sm:flex-row sm:items-center">
					<div class="flex flex-1 items-center gap-3">
						<svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0a7 7 0 1 0-9.9 0 7 7 0 0 0 9.9 0Z" />
						</svg>
						<input
							id="search"
							type="search"
							name="q"
							value="{{ $search ?? '' }}"
							placeholder="Cari judul, penulis, penerbit, atau ISBN"
							class="w-full border-none bg-transparent text-sm text-slate-600 placeholder:text-slate-400 focus:outline-none"
						>
					</div>
					@if(!empty($search))
						<a href="{{ route('admin.books.library.index') }}" class="text-xs font-medium text-slate-500 hover:text-slate-700">Reset</a>
					@endif
					<button type="submit" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700">
						Cari
					</button>
				</div>
			</form>

			<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
				<div class="hidden md:block">
					<table class="min-w-full table-fixed text-sm text-slate-600">
						<thead class="bg-slate-100 text-slate-500">
							<tr>
								<th class="w-16 px-5 py-3 text-left font-semibold">No.</th>
								<th class="px-5 py-3 text-left font-semibold">Detail Buku</th>
								<th class="w-32 px-5 py-3 text-left font-semibold">Kategori</th>
								<th class="w-24 px-5 py-3 text-left font-semibold">Stok</th>
								<th class="w-32 px-5 py-3 text-left font-semibold">Status</th>
								<th class="w-40 px-5 py-3 text-center font-semibold">Aksi</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-100">
							@forelse ($books as $index => $book)
								<tr class="hover:bg-slate-50">
									<td class="px-5 py-4 text-slate-400">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
									<td class="px-5 py-4">
										<p class="font-semibold text-slate-900">{{ $book->title }}</p>
										<p class="text-xs text-slate-500">{{ $book->author }}</p>
										<p class="text-xs text-slate-400">{{ $book->publisher }} · {{ $book->publication_year }}</p>
										@if($book->isbn)
											<p class="text-xs text-slate-400">ISBN: {{ $book->isbn }}</p>
										@endif
									</td>
									<td class="px-5 py-4 text-slate-500">{{ $book->category ?? '—' }}</td>
									<td class="px-5 py-4 text-slate-500">{{ $book->stock ?? 0 }}</td>
									<td class="px-5 py-4">
										@if($book->status === 'available')
											<span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Tersedia</span>
										@else
											<span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-600">Tidak Tersedia</span>
										@endif
									</td>
									<td class="px-5 py-4 text-center">
										<div class="flex items-center justify-center gap-2">
											@if($book->pdf_path)
												<a href="{{ asset('storage/' . $book->pdf_path) }}" target="_blank" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-50">Lihat PDF</a>
											@endif
											<form action="{{ route('admin.books.library.destroy', $book) }}" method="POST" onsubmit="return confirm('Hapus buku ini dari katalog?');">
												@csrf
												@method('DELETE')
												<button type="submit" class="rounded-lg bg-rose-500 px-3 py-2 text-xs font-medium text-white transition hover:bg-rose-600">Hapus</button>
											</form>
										</div>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="7" class="px-5 py-12 text-center text-sm text-slate-500">
										Tidak ada buku yang ditemukan. Tambahkan koleksi baru atau gunakan kata kunci lain.
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>

				<div class="md:hidden">
					@forelse ($books as $index => $book)
						<article class="space-y-3 border-b border-slate-100 px-5 py-5 last:border-b-0">
							<div class="flex items-start gap-3">
								@php
									$cover = $book->cover_path ? asset('storage/' . $book->cover_path) : null;
								@endphp
								<div class="flex h-20 w-16 items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-slate-100">
									@if($cover)
										<img src="{{ $cover }}" alt="Sampul {{ $book->title }}" class="h-full w-full object-cover">
									@else
										<span class="text-xs text-slate-400">Tidak ada</span>
									@endif
								</div>
								<div class="flex-1">
									<p class="text-xs uppercase tracking-wider text-slate-400">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</p>
									<h2 class="mt-1 text-base font-semibold text-slate-900">{{ $book->title }}</h2>
									<p class="text-xs text-slate-500">{{ $book->author }} · {{ $book->publisher }}</p>
									<p class="text-xs text-slate-400">{{ $book->category ?? 'Kategori tidak tersedia' }}</p>
								</div>
							</div>
							<dl class="grid grid-cols-2 gap-3 text-xs text-slate-500">
								<div>
									<dt class="text-slate-400">Tahun</dt>
									<dd class="font-medium text-slate-700">{{ $book->publication_year }}</dd>
								</div>
								<div>
									<dt class="text-slate-400">Stok</dt>
									<dd class="font-medium text-slate-700">{{ $book->stock ?? 0 }}</dd>
								</div>
								<div class="col-span-2">
									<dt class="text-slate-400">Status</dt>
									<dd class="mt-1">
										@if($book->status === 'available')
											<span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Tersedia</span>
										@else
											<span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-medium text-rose-600">Tidak Tersedia</span>
										@endif
									</dd>
								</div>
								@if($book->isbn)
									<div class="col-span-2">
										<dt class="text-slate-400">ISBN</dt>
										<dd class="font-medium text-slate-700">{{ $book->isbn }}</dd>
									</div>
								@endif
							</dl>
							<div class="flex items-center gap-3">
								@if($book->pdf_path)
									<a href="{{ asset('storage/' . $book->pdf_path) }}" target="_blank" class="flex-1 rounded-lg border border-slate-200 px-4 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-50">Lihat PDF</a>
								@endif
								<form action="{{ route('admin.books.library.destroy', $book) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus buku ini dari katalog?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="w-full rounded-lg bg-rose-500 px-4 py-2 text-xs font-medium text-white transition hover:bg-rose-600">Hapus</button>
								</form>
							</div>
						</article>
					@empty
						<div class="px-5 py-12 text-center text-sm text-slate-500">
							Tidak ada buku yang ditemukan.
						</div>
					@endforelse
				</div>
			</div>
		</div>
	</section>
@endsection
