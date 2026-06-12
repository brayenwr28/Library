@extends('layout.app')

@section('title', 'Daftar Koleksi Perpustakaan')

@section('content')
    <section class="bg-slate-50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            
            <div class="flex flex-col gap-4 pb-8 border-b border-slate-200 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-indigo-600">Koleksi Perpustakaan</p>
                    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Daftar Buku Perpustakaan</h1>
                    <p class="mt-2 text-sm text-slate-500">Pantau dan kelola buku fisik yang tersedia di perpustakaan metamedia.</p>
                </div>

                <div class="flex flex-wrap gap-2.5">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                        ← Dashboard
                    </a>
                    <a href="{{ route('admin.books.library.import.form') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <svg class="mr-2 h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Import Buku
                    </a>
                    <a href="{{ route('admin.books.library.create') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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

            <form method="GET" action="{{ route('admin.books.library.index') }}" class="mt-6 mb-6">
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
                            <a href="{{ route('admin.books.library.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">Reset</a>
                        @endif
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2 text-sm font-semibold text-white shadow transition hover:bg-slate-800">
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-600 whitespace-nowrap">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] tracking-wider font-bold border-b border-slate-200">
                            <tr>
                                <th scope="col" class="w-16 px-6 py-4 text-left">No.</th>
                                <th scope="col" class="w-24 px-6 py-4 text-center">Sampul</th>
                                <th scope="col" class="px-6 py-4 text-left">Detail Buku</th>
                                <th scope="col" class="w-36 px-6 py-4 text-left">Kategori</th>
                                <th scope="col" class="w-24 px-6 py-4 text-center">Stok</th>
                                <th scope="col" class="w-32 px-6 py-4 text-left">Status</th>
                                <th scope="col" class="w-48 px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($perpusses as $index => $book)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4 text-slate-400 font-mono text-xs">
                                        #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($book->cover_path)
                                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="mx-auto h-20 w-14 rounded-md object-cover shadow-sm border border-slate-100">
                                        @else
                                            <div class="mx-auto flex h-20 w-14 items-center justify-center rounded-md bg-slate-100 text-xl shadow-inner">📕</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal max-w-sm">
                                        <div class="font-semibold text-slate-900 text-base line-clamp-1 hover:line-clamp-none transition duration-150">{{ $book->title }}</div>
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
                                            <a href="{{ route('admin.books.library.edit', $book) }}" class="inline-flex items-center rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                                Edit
                                            </a>
                                            @if($book->pdf_path)
                                                <a href="{{ asset('storage/' . $book->pdf_path) }}" target="_blank" class="inline-flex items-center rounded-md border border-indigo-100 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 shadow-sm transition hover:bg-indigo-100/80">
                                                    PDF
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.books.library.destroy', $book) }}" method="POST" onsubmit="return confirm('Hapus buku ini dari katalog?');" class="inline">
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
                                    <td colspan="7" class="px-6 py-16 text-center text-sm text-slate-400">
                                        <div class="text-3xl mb-2">🔍</div>
                                        Tidak ada buku yang ditemukan. Tambahkan koleksi baru atau gunakan kata kunci lain.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </section>
@endsection