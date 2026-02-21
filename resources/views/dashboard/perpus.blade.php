@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
<section class="bg-gradient-to-br from-slate-50 via-emerald-50 to-blue-50 min-h-screen">
    <div class="mx-auto max-w-7xl px-6 pb-24 pt-10">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-4">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25c0 5.378 3.707 9.881 8.5 10.428M12 6.253c5.5 0 10 4.745 10 10.997 0 5.368-3.707 9.881-8.5 10.428" />
                    </svg>
                </div>
                <div>
                    <span class="block text-xs font-semibold uppercase tracking-wider text-emerald-600">📚 Koleksi Perpustakaan</span>
                    <h1 class="text-4xl font-bold text-slate-900 mt-1">Daftar Buku Tersedia</h1>
                </div>
            </div>
            <p class="text-slate-600 text-lg max-w-2xl">Jelajahi koleksi buku perpustakaan kami. Silakan lakukan peminjaman dan kembalikan tepat waktu untuk menjaga koleksi kami tetap berkembang.</p>
        </div>

        <!-- Search Bar -->
        <div class="mb-8">
            <form action="{{ route('admin.books.library.index') }}" method="GET" class="flex gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" />
                        </svg>
                    </div>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari judul, penulis, ISBN..." 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-slate-200 bg-white text-slate-700 placeholder:text-slate-400 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200 hover:border-slate-300" />
                </div>
                @if($search !== '')
                    <a href="{{ route('admin.books.library.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-slate-200 text-slate-700 font-medium transition hover:bg-slate-300 hover:text-slate-800">
                        ✕ Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Books Grid or Empty State -->
        @if($books->isEmpty())
            <div class="flex flex-col items-center justify-center gap-6 rounded-3xl border-2 border-dashed border-slate-300 bg-white/80 backdrop-blur py-20 text-center">
                <div class="text-7xl animate-bounce">📭</div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Buku Belum Tersedia</h2>
                    <p class="max-w-md text-slate-600 mt-2">Belum ada buku yang ditambahkan. Silakan masukkan data buku melalui halaman input admin untuk memunculkannya di sini.</p>
                </div>
            </div>
        @else
            <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($books as $book)
                    <article class="group h-full flex flex-col overflow-hidden rounded-2xl border-2 border-slate-200 bg-white shadow-md transition duration-300 hover:shadow-2xl hover:border-emerald-300 hover:-translate-y-2">
                        <!-- Cover Image Section -->
                        <div class="relative h-56 w-full overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
                            @if($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="Sampul {{ $book->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110" />
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <div class="text-6xl animate-pulse">📕</div>
                                </div>
                            @endif
                            
                            <!-- Status Badge (Overlay) -->
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold uppercase tracking-wide shadow-lg {{ $book->status === 'available' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                                    <span class="inline-block h-2 w-2 rounded-full {{ $book->status === 'available' ? 'bg-white' : 'bg-white' }} animate-pulse"></span>
                                    {{ $book->status === 'available' ? '✓ Tersedia' : '✗ Tidak Tersedia' }}
                                </span>
                            </div>

                            <!-- Stock Badge -->
                            <div class="absolute bottom-3 left-3">
                                <span class="inline-flex items-center gap-1 rounded-lg bg-white/95 backdrop-blur px-2.5 py-1 text-xs font-semibold text-slate-700 shadow-md">
                                    📦 {{ $book->stock }} stok
                                </span>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="flex flex-1 flex-col gap-4 p-5">
                            <!-- Title & Author -->
                            <div class="border-b border-slate-100 pb-3">
                                <h3 class="text-base font-bold text-slate-900 line-clamp-2">{{ $book->title }}</h3>
                                <p class="text-sm text-slate-500 mt-1">
                                    <svg class="inline h-3.5 w-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H5.75A2.75 2.75 0 0 0 3 4.25v11.5A2.75 2.75 0 0 0 5.75 18.5h8.5a2.75 2.75 0 0 0 2.75-2.75V8M10.5 1.5v5.25h5.25M10.5 1.5a2.75 2.75 0 0 1 2.75 2.75v2.5"/></svg>
                                    {{ $book->author }}
                                </p>
                            </div>

                            <!-- Book Details Grid -->
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <!-- Publisher -->
                                <div class="rounded-lg bg-blue-50 p-2.5 border border-blue-100">
                                    <dt class="font-semibold text-blue-700">🏢 Penerbit</dt>
                                    <dd class="text-slate-600 text-xs mt-1 truncate">{{ $book->publisher }}</dd>
                                </div>

                                <!-- Year -->
                                <div class="rounded-lg bg-purple-50 p-2.5 border border-purple-100">
                                    <dt class="font-semibold text-purple-700">📅 Tahun</dt>
                                    <dd class="text-slate-600 text-xs mt-1">{{ $book->publication_year }}</dd>
                                </div>

                                <!-- Category -->
                                <div class="rounded-lg bg-amber-50 p-2.5 border border-amber-100 col-span-2">
                                    <dt class="font-semibold text-amber-700">🏷️ Kategori</dt>
                                    <dd class="text-slate-600 text-xs mt-1 truncate">{{ $book->category ?? '(Belum diatur)' }}</dd>
                                </div>

                                <!-- ISBN -->
                                @if($book->isbn)
                                    <div class="rounded-lg bg-emerald-50 p-2.5 border border-emerald-100 col-span-2">
                                        <dt class="font-semibold text-emerald-700">🔢 ISBN</dt>
                                        <dd class="text-slate-600 text-xs mt-1 font-mono truncate">{{ $book->isbn }}</dd>
                                    </div>
                                @endif
                            </div>

                            <!-- Summary -->
                            @if($book->summary)
                                <div class="bg-slate-50 rounded-lg p-3 border border-slate-100">
                                    <p class="text-xs text-slate-600 line-clamp-3">{{ $book->summary }}</p>
                                </div>
                            @endif

                            <!-- Footer with Metadata & Action Button -->
                            <div class="mt-auto pt-3 border-t border-slate-100 flex flex-col gap-2">
                                <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                                    <span>{{ $book->created_at?->diffForHumans() }}</span>
                                    @if($book->pdf_path)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-100 text-emerald-700 font-semibold">
                                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8 16.5a1 1 0 01-1-1v-5h-.5a1 1 0 0 1 0-2H7V9a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4h.5a1 1 0 0 1 0 2H13v5a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-5H8v5a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-5H3a1 1 0 0 1 0-2h.5V9a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1.5h.5a1 1 0 0 1 0 2H8v5z" clip-rule="evenodd"/>
                                            </svg>
                                            PDF
                                        </span>
                                    @endif
                                </div>
                                <!-- Action Button -->
                                @php
                                    $canRead = auth()->check() && isset($borrowedBookIds) && in_array($book->id, $borrowedBookIds, true);
                                @endphp
                             <div class="mt-auto pt-4 border-t border-slate-100 space-y-3">
                        <!-- Primary Action -->
                        <div class="flex gap-2">
                            @if(!$canRead)
                                <a href="{{ route('peminjaman.show', ['book_id' => $book->id]) }}" 
                                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-2.5 text-sm font-bold text-white shadow-md transition hover:shadow-lg hover:from-blue-700 hover:to-blue-800 active:scale-95">
                                    📌 Pinjam Buku
                                </a>
                            @else
                                <a href="{{ route('peminjaman.read', ['book' => $book->id]) }}" 
                                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-emerald-600 to-emerald-700 px-4 py-2.5 text-sm font-bold text-white shadow-md transition hover:shadow-lg hover:from-emerald-700 hover:to-emerald-800 active:scale-95">
                                    👁️ Baca Buku
                                </a>
                            @endif
                        </div>

                        <!-- Secondary Info -->
                        @if($book->pdf_path)
                            @auth
                                @if($canRead)
                                    <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-2.5">
                                        <p class="text-xs font-semibold text-emerald-700 flex items-center gap-2">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Buku ini sedang kamu pinjam
                                        </p>
                                    </div>
                                @else
                                    <div class="rounded-lg bg-blue-50 border border-blue-200 px-4 py-2.5">
                                        <p class="text-xs font-semibold text-blue-700 flex items-center gap-2">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>
                                            Pinjam buku untuk membaca PDF
                                        </p>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="block rounded-lg bg-indigo-50 border border-indigo-200 px-4 py-2.5 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100 text-center">
                                    🔐 Masuk untuk membaca
                                </a>
                            @endauth
                        @else
                            <div class="rounded-lg bg-slate-100 border border-slate-200 px-4 py-2.5">
                                <p class="text-xs font-semibold text-slate-600 flex items-center gap-2">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" clip-rule="evenodd"/></svg>
                                    PDF belum tersedia
                                </p>
                            </div>
                        @endif
                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Stats Footer -->
            <div class="mt-12 rounded-2xl bg-white border-2 border-slate-200 p-8 shadow-md">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-600">{{ $books->count() }}</div>
                        <p class="text-sm text-slate-600 mt-1">Total Buku</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $books->where('status', 'available')->count() }}</div>
                        <p class="text-sm text-slate-600 mt-1">Tersedia</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-rose-600">{{ $books->where('status', 'unavailable')->count() }}</div>
                        <p class="text-sm text-slate-600 mt-1">Tidak Tersedia</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-amber-600">{{ $books->sum('stock') }}</div>
                        <p class="text-sm text-slate-600 mt-1">Total Stok</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
