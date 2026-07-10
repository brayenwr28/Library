@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
<section class="bg-gradient-to-br from-blue-50 via-indigo-50 to-sky-100 min-h-screen text-slate-800">
    <div class="mx-auto max-w-7xl px-6 pb-24 pt-10">
        <div class="mb-12 border-b border-blue-200 pb-8 relative">
            <div class="absolute -top-6 left-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-600 shadow-[0_0_20px_rgba(37,99,235,0.45)] border border-blue-400">
                    <svg class="h-7 w-7 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25c0 5.378 3.707 9.881 8.5 10.428M12 6.253c5.5 0 10 4.745 10 10.997 0 5.368-3.707 9.881-8.5 10.428" />
                    </svg>
                </div>
                <div>
                    <span class="block text-xs font-extrabold uppercase tracking-widest text-blue-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span> 
                        Koleksi Perpustakaan Universitas Metamedia
                    </span>
                    <h1 class="text-4xl font-extrabold text-slate-900 mt-1 tracking-tight">Daftar Buku Tersedia</h1>
                </div>
            </div>
            <p class="text-slate-600 text-lg max-w-2xl relative z-10">Jelajahi koleksi buku perpustakaan kami. Silakan lakukan peminjaman dan kembalikan tepat waktu untuk menjaga koleksi kami tetap berkembang.</p>
        </div>

        <div class="mb-8">
            <form action="{{ route('admin.books.library.index') }}" method="GET" class="flex gap-3">
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" />
                        </svg>
                    </div>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari judul, penulis, ISBN..." 
                           class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-blue-100 bg-white text-slate-800 placeholder:text-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/20 hover:border-blue-200 shadow-md shadow-blue-100/50" />
                </div>
                @if($search !== '')
                    <a href="{{ route('admin.books.library.index') }}" 
                       class="inline-flex items-center gap-2 px-5 py-3.5 rounded-xl bg-slate-200 text-slate-700 font-medium transition hover:bg-slate-300 hover:text-slate-800">
                        ✕ Reset
                    </a>
                @endif
            </form>
        </div>

        @if($books->isEmpty())
            <div class="flex flex-col items-center justify-center gap-6 rounded-3xl border-2 border-dashed border-blue-300 bg-white/80 backdrop-blur py-20 text-center shadow-lg">
                <div class="text-7xl animate-bounce filter drop-shadow-[0_10px_10px_rgba(59,130,246,0.2)]">📭</div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Buku Belum Tersedia</h2>
                    <p class="max-w-md text-slate-600 mt-2 mx-auto mb-4">Belum ada buku yang ditambahkan. Silakan masukkan data buku melalui halaman input admin untuk memunculkannya di sini.</p>
                    @auth('admin')
                    <a href="{{ route('admin.books.library.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-3.5 text-sm font-bold text-white shadow-[0_5px_15px_rgba(37,99,235,0.35)] transition duration-300 hover:from-blue-700 hover:to-blue-600 hover:shadow-[0_8px_20px_rgba(37,99,235,0.5)] active:scale-95">
                        ➕ Tambah Buku Baru
                    </a>
                    @endauth
                </div>
            </div>
        @else
            <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 items-stretch">
                @foreach($books as $book)
                    <article class="group h-full min-h-[35rem] flex flex-col overflow-hidden rounded-2xl border-2 border-blue-100/70 bg-white shadow-md transition duration-300 hover:shadow-[0_15px_30px_rgba(37,99,235,0.2)] hover:border-blue-500 hover:-translate-y-2">
                        <div class="relative h-56 w-full overflow-hidden bg-gradient-to-br from-blue-50 to-sky-100 border-b border-blue-50">
                            @if($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="Sampul {{ $book->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110" />
                                <div class="absolute inset-0 bg-gradient-to-t from-blue-950/20 via-transparent to-transparent opacity-60"></div>
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <div class="text-6xl group-hover:scale-110 transition duration-300 filter drop-shadow-md">📕</div>
                                </div>
                            @endif
                            
                            <div class="absolute top-3 right-3">
                                @if($book->status === 'available')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-600 px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-white shadow-[0_4px_10px_rgba(37,99,235,0.4)]">
                                        <span class="inline-block h-2 w-2 rounded-full bg-white animate-pulse"></span>
                                        ✓ Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-600 px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-white shadow-[0_4px_10px_rgba(220,38,38,0.4)]">
                                        <span class="inline-block h-2 w-2 rounded-full bg-white"></span>
                                        ✗ Penuh
                                    </span>
                                @endif
                            </div>

                            <div class="absolute bottom-3 left-3">
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/95 border border-blue-100 backdrop-blur px-2.5 py-1 text-xs font-bold text-blue-700 shadow-sm">
                                    📦 {{ $book->stock }} Stok
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col gap-4 p-5">
                            <div class="border-b border-blue-50 pb-3">
                                <h3 class="text-base font-extrabold text-slate-900 line-clamp-2 group-hover:text-blue-600 transition duration-300" title="{{ $book->title }}">{{ $book->title }}</h3>
                                <p class="text-sm text-slate-500 mt-1 flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H5.75A2.75 2.75 0 0 0 3 4.25v11.5A2.75 2.75 0 0 0 5.75 18.5h8.5a2.75 2.75 0 0 0 2.75-2.75V8M10.5 1.5v5.25h5.25M10.5 1.5a2.75 2.75 0 0 1 2.75 2.75v2.5"/></svg>
                                    {{ $book->author }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div class="rounded-lg bg-blue-50/60 p-2.5 border border-blue-100">
                                    <dt class="font-bold text-blue-700">🏢 Penerbit</dt>
                                    <dd class="text-slate-600 mt-1 truncate font-medium">{{ $book->publisher }}</dd>
                                </div>

                                <div class="rounded-lg bg-indigo-50/60 p-2.5 border border-indigo-100">
                                    <dt class="font-bold text-indigo-700">📅 Tahun</dt>
                                    <dd class="text-slate-600 mt-1 font-medium">{{ $book->publication_year }}</dd>
                                </div>

                                <div class="rounded-lg bg-sky-50/70 p-2.5 border border-sky-100 col-span-2">
                                    <dt class="font-bold text-sky-700">🏷️ Kategori</dt>
                                    <dd class="text-slate-600 mt-1 truncate font-medium">{{ $book->category ?? '(Belum diatur)' }}</dd>
                                </div>

                                @if($book->isbn)
                                    <div class="rounded-lg bg-slate-50 p-2.5 border border-slate-200 col-span-2">
                                        <dt class="font-bold text-slate-700">🔢 ISBN</dt>
                                        <dd class="text-slate-600 mt-1 font-mono truncate">{{ $book->isbn }}</dd>
                                    </div>
                                @endif
                            </div>

                            @if($book->summary)
                                <div class="bg-slate-50/80 rounded-lg p-3 border border-slate-100 min-h-[5.5rem]">
                                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">{{ $book->summary }}</p>
                                </div>
                            @else
                                <div class="bg-slate-50/40 rounded-lg p-3 border border-dashed border-slate-200 min-h-[5.5rem] flex items-center justify-center">
                                    <p class="text-xs text-slate-400 italic">Ringkasan belum tersedia</p>
                                </div>
                            @endif

                            <div class="mt-auto pt-4 border-t border-slate-100 space-y-3">
                                <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                                    <span>{{ $book->created_at?->diffForHumans() }}</span>
                                    @if($book->pdf_path)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-blue-100 border border-blue-200 text-blue-700 font-extrabold text-[10px]">
                                            E-BOOK
                                        </span>
                                    @endif
                                </div>

                                @php
                                    $canRead = auth()->check() && isset($borrowedBookIds) && in_array($book->id, $borrowedBookIds, true);
                                @endphp

                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-2">
                                        @if(!$canRead)
                                            <a href="{{ route('peminjaman.perpus', ['book_id' => $book->id]) }}" 
                                               class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-3 text-sm font-bold text-white shadow-[0_5px_15px_rgba(37,99,235,0.35)] transition duration-300 hover:from-blue-700 hover:to-blue-600 hover:shadow-[0_8px_20px_rgba(37,99,235,0.5)] active:scale-95">
                                                📌 Pinjam Buku
                                            </a>
                                        @else
                                            <a href="{{ route('peminjaman.read', ['book' => $book->id]) }}" 
                                               class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-orange-500 px-4 py-3 text-sm font-bold text-white shadow-[0_5px_15px_rgba(220,38,38,0.35)] transition duration-300 hover:from-red-700 hover:to-orange-600 hover:shadow-[0_8px_20px_rgba(220,38,38,0.5)] active:scale-95">
                                                👁️ Baca Buku
                                            </a>
                                        @endif
                                    </div>

                                    @if($book->pdf_path)
                                        @auth
                                            @if($canRead)
                                                <div class="rounded-xl bg-blue-50 border border-blue-200 px-4 py-2.5 text-center shadow-inner">
                                                    <p class="text-xs font-bold text-blue-700 flex items-center justify-center gap-1.5">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                                        Buku ini sedang kamu pinjam
                                                    </p>
                                                </div>
                                            @else
                                                <div class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-2.5 text-center">
                                                    <p class="text-xs font-semibold text-slate-500">
                                                        Pinjam buku untuk membaca PDF
                                                    </p>
                                                </div>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" 
                                               class="block rounded-xl bg-blue-50 border border-blue-200 px-4 py-2.5 text-xs font-bold text-blue-700 transition hover:bg-blue-100 text-center shadow-sm">
                                                🔐 Masuk untuk membaca digital
                                            </a>
                                        @endauth
                                    @else
                                        <div class="rounded-xl bg-slate-100/80 border border-slate-200/60 px-4 py-2.5 text-center">
                                            <p class="text-xs font-medium text-slate-400 italic">
                                                E-Book/PDF tidak tersedia
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12 rounded-2xl bg-white border-2 border-blue-100 p-8 shadow-xl relative overflow-hidden">
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl"></div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 relative z-10">
                    <div class="text-center md:border-r border-blue-100 last:border-0">
                        <div class="text-4xl font-black text-blue-600 drop-shadow-sm">{{ $books->count() }}</div>
                        <p class="text-xs uppercase tracking-wider font-bold text-slate-500 mt-2">Total Judul</p>
                    </div>
                    <div class="text-center md:border-r border-blue-100 last:border-0">
                        <div class="text-4xl font-black text-blue-600 drop-shadow-sm">{{ $books->where('status', 'available')->count() }}</div>
                        <p class="text-xs uppercase tracking-wider font-bold text-slate-500 mt-2">Tersedia</p>
                    </div>
                    <div class="text-center md:border-r border-blue-100 last:border-0">
                        <div class="text-4xl font-black text-red-500 drop-shadow-sm">{{ $books->where('status', 'unavailable')->count() }}</div>
                        <p class="text-xs uppercase tracking-wider font-bold text-slate-500 mt-2">Dipinjam</p>
                    </div>
                    <div class="text-center last:border-0">
                        <div class="text-4xl font-black text-slate-700">{{ $books->sum('stock') }}</div>
                        <p class="text-xs uppercase tracking-wider font-bold text-slate-500 mt-2">Total Stok Fisik</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection