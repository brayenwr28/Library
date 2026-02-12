@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
<section class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 pb-24 pt-32">
        <div class="flex flex-col gap-4 pb-10 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="inline-flex items-center rounded-full bg-white px-4 py-1 text-xs font-semibold uppercase tracking-wide text-slate-500 shadow-sm">
                    Koleksi Perpustakaan
                </span>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Daftar Buku Tersedia</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-600">Semua buku yang sudah diinput admin ditampilkan dalam kartu berikut lengkap dengan informasi penerbit, kategori, dan stok.</p>
            </div>
            <form action="{{ route('admin.books.library.index') }}" method="GET" class="flex w-full max-w-md items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm">
                <label for="book-search" class="sr-only">Cari buku</label>
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" />
                </svg>
                <input id="book-search" type="search" name="q" value="{{ $search }}" placeholder="Cari judul, penulis, ISBN" class="w-full border-0 bg-transparent text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-0" />
                @if($search !== '')
                    <a href="{{ route('admin.books.library.index') }}" class="text-xs font-semibold text-slate-400 transition hover:text-slate-600">Reset</a>
                @endif
            </form>
        </div>

        @if($books->isEmpty())
            <div class="flex flex-col items-center justify-center gap-4 rounded-3xl border border-dashed border-slate-300 bg-white py-16 text-center">
                <div class="text-5xl">📭</div>
                <h2 class="text-xl font-semibold text-slate-800">Buku belum tersedia</h2>
                <p class="max-w-md text-sm text-slate-500">Belum ada buku yang ditambahkan. Silakan masukkan data buku melalui halaman input admin untuk memunculkannya di sini.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($books as $book)
                    <article class="group flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-slate-300 hover:shadow-md">
                        <div class="relative h-48 w-full overflow-hidden bg-slate-100">
                            @if($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="Sampul {{ $book->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-4xl text-slate-400">📘</div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col gap-4 p-6">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $book->title }}</h3>
                                    <p class="text-sm text-slate-500">{{ $book->author }}</p>
                                </div>
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-wide {{ $book->status === 'available' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $book->status === 'available' ? 'Tersedia' : 'Tidak tersedia' }}
                                </span>
                            </div>

                            <dl class="space-y-2 text-sm text-slate-600">
                                <div class="flex justify-between gap-3">
                                    <dt class="text-slate-500">Penerbit</dt>
                                    <dd class="text-right font-medium text-slate-700">{{ $book->publisher }}</dd>
                                </div>
                                <div class="flex justify-between gap-3">
                                    <dt class="text-slate-500">Kategori</dt>
                                    <dd class="text-right font-medium text-slate-700">{{ $book->category ?? 'Belum diatur' }}</dd>
                                </div>
                                <div class="flex justify-between gap-3">
                                    <dt class="text-slate-500">ISBN</dt>
                                    <dd class="font-mono text-xs text-slate-700">{{ $book->isbn ?? '-' }}</dd>
                                </div>
                                <div class="flex justify-between gap-3">
                                    <dt class="text-slate-500">Tahun terbit</dt>
                                    <dd class="font-medium text-slate-700">{{ $book->publication_year }}</dd>
                                </div>
                                <div class="flex justify-between gap-3">
                                    <dt class="text-slate-500">Stok</dt>
                                    <dd class="font-semibold text-slate-900">{{ $book->stock }}</dd>
                                </div>
                            </dl>

                            @if($book->summary)
                                <p class="text-sm text-slate-500">{{ Str::limit($book->summary, 140) }}</p>
                            @endif

                            <div class="mt-auto flex items-center justify-between pt-2 text-xs text-slate-400">
                                <span>Ditambahkan {{ $book->created_at?->diffForHumans() }}</span>
                                @if($book->pdf_path)
                                    <span class="inline-flex items-center gap-1 text-emerald-600">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                        PDF tersedia
                                    </span>
                                @else
                                    <span>Belum ada PDF</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
