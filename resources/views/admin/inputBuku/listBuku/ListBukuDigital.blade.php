@extends('layout.app')

@section('title', 'Daftar Koleksi Perpustakaan')

@section('content')
    <section class="bg-slate-50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            
            <div class="flex flex-col gap-4 pb-8 border-b border-slate-200 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-indigo-600">Koleksi Digital</p>
                    </div>
                    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Daftar Buku Digital</h1>
                    <p class="mt-2 text-sm text-slate-500">Kelola dan pantau koleksi buku digital (PDF) di perpustakaan online.</p>
                </div>

                <div class="flex flex-wrap gap-2.5">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <svg class="mr-2 h-4 w-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.books.import.form') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <svg class="mr-2 h-4 w-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Import Buku
                    </a>
                    <a href="{{ route('admin.books.create') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none">
                        + Tambah Buku
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="mt-6 p-4 rounded-xl border border-emerald-200 bg-emerald-50 flex items-start gap-3 shadow-sm">
                    <svg class="h-5 w-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <form method="GET" action="{{ route('admin.books.show') }}" class="mt-6 mb-6">
                <label for="search" class="sr-only">Cari buku</label>
                <div class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-3 shadow-sm sm:flex-row sm:items-center">
                    <div class="flex flex-1 items-center gap-3 px-2">
                        <svg class="h-5 w-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0a7 7 0 1 0-9.9 0 7 7 0 0 0 9.9 0Z" />
                        </svg>
                        <input
                            id="search"
                            type="search"
                            name="q"
                            value="{{ $search ?? '' }}"
                            placeholder="Cari judul, penulis, penerbit, atau ISBN..."
                            class="w-full border-none bg-transparent text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-0 py-1.5"
                        >
                    </div>
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-3 sm:border-t-0 sm:pt-0">
                        @if(!empty($search))
                            <a href="{{ route('admin.books.show') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.212 8H18"/></svg> Reset
                            </a>
                        @endif
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow transition hover:bg-slate-800">
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-600 whitespace-nowrap">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] tracking-wider font-bold border-b border-slate-200">
                            <tr>
                                <th scope="col" class="w-16 px-6 py-4 text-left">No.</th>
                                <th scope="col" class="px-6 py-4 text-left">Detail Buku</th>
                                <th scope="col" class="w-36 px-6 py-4 text-left">Kategori</th>
                                <th scope="col" class="w-24 px-6 py-4 text-center">Stok</th>
                                <th scope="col" class="w-32 px-6 py-4 text-left">Status</th>
                                <th scope="col" class="w-48 px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($books as $index => $book)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4 text-slate-400 font-mono text-xs">
                                        #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal max-w-md">
                                        <div class="font-semibold text-slate-900 text-base line-clamp-1">{{ $book->title }}</div>
                                        <div class="text-xs font-medium text-slate-500 mt-0.5">{{ $book->author }}</div>
                                        <div class="text-xs text-slate-400 mt-1 flex items-center gap-1.5">
                                            <span>{{ $book->publisher }}</span>
                                            <span class="text-slate-300">•</span>
                                            <span>{{ $book->publication_year }}</span>
                                        </div>
                                        @if($book->isbn)
                                            <span class="inline-block mt-1 text-[11px] font-mono bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded">ISBN: {{ $book->isbn }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-800">
                                            {{ $book->category ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-semibold text-slate-800">
                                        {{ $book->stock ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($book->status === 'available')
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-emerald-500"></span>Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-rose-500"></span>Tidak Tersedia
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.books.edit', $book) }}" class="inline-flex items-center rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                                Edit
                                            </a>
                                            @if($book->pdf_path)
                                                <a href="{{ asset('storage/' . $book->pdf_path) }}" target="_blank" class="inline-flex items-center rounded-md border border-indigo-100 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 shadow-sm transition hover:bg-indigo-100/80">
                                                    PDF
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?\n\nTindakan ini tidak dapat dibatalkan!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-rose-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center text-sm text-slate-400">
                                        <div class="text-3xl mb-2">🔍</div>
                                        Tidak ada buku digital yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-slate-100 bg-white">
                    @forelse ($books as $index => $book)
                        <article class="p-5 space-y-4">
                            <div class="flex items-start gap-4">
                                @php
                                    $cover = $book->cover_path ? asset('storage/' . $book->cover_path) : null;
                                @endphp
                                <div class="flex h-20 w-14 flex-shrink-0 items-center justify-center overflow-hidden rounded-md border border-slate-200 bg-slate-50 shadow-inner">
                                    @if($cover)
                                        <img src="{{ $cover }}" alt="Sampul {{ $book->title }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-xl">📕</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] font-mono tracking-wider text-slate-400">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</p>
                                    <h2 class="mt-0.5 text-base font-bold text-slate-900 truncate">{{ $book->title }}</h2>
                                    <p class="text-xs font-medium text-slate-500 truncate">{{ $book->author }}</p>
                                    <span class="inline-block mt-1.5 px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px] font-medium">
                                        {{ $book->category ?? 'Umum' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-2 bg-slate-50 p-2.5 rounded-lg text-center text-xs">
                                <div>
                                    <div class="text-slate-400 text-[10px] uppercase font-semibold">Tahun</div>
                                    <div class="font-bold text-slate-700 mt-0.5">{{ $book->publication_year }}</div>
                                </div>
                                <div>
                                    <div class="text-slate-400 text-[10px] uppercase font-semibold">Stok</div>
                                    <div class="font-bold text-slate-700 mt-0.5">{{ $book->stock ?? 0 }}</div>
                                </div>
                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-slate-400 text-[10px] uppercase font-semibold mb-0.5">Status</div>
                                    @if($book->status === 'available')
                                        <span class="px-1.5 py-0.2 text-[10px] font-bold text-emerald-700 bg-emerald-100 rounded">Tersedia</span>
                                    @else
                                        <span class="px-1.5 py-0.2 text-[10px] font-bold text-rose-700 bg-rose-100 rounded">Habis</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-2 pt-1">
                                <a href="{{ route('admin.books.edit', $book) }}" class="flex-1 inline-flex items-center justify-center rounded-md border border-slate-200 bg-white py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                    Edit
                                </a>
                                @if($book->pdf_path)
                                    <a href="{{ asset('storage/' . $book->pdf_path) }}" target="_blank" class="flex-1 inline-flex items-center justify-center rounded-md border border-indigo-100 bg-indigo-50 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100">
                                        Lihat PDF
                                    </a>
                                @endif
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus buku ini?\n\nTindakan ini tidak dapat dibatalkan!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-md bg-rose-600 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-rose-700">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="p-8 text-center text-sm text-slate-400">
                            Tidak ada buku digital yang ditemukan.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </section>
@endsection