@extends('layouts.app')

@section('title', 'Katalog Buku')

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
                        📚 Katalog Referensi Universitas Metamedia
                    </span>
                    <h1 class="text-4xl font-extrabold text-slate-900 mt-1 tracking-tight">Koleksi Pilihan Perpustakaan</h1>
                </div>
            </div>
            <p class="text-slate-600 text-lg max-w-3xl relative z-10">Temukan bacaan rekomendasi yang dikurasi oleh tim pustakawan. Setiap kartu menampilkan ringkasan singkat agar Anda bisa menentukan buku yang tepat sebelum mengajukan peminjaman.</p>
        </div>

        @forelse ($books as $book)
            @php
                $isDigital = (bool) $book->pdf_path;
                $canRead = $isDigital || (auth()->check() && in_array($book->id, $borrowedBookIds ?? [], true));
            @endphp
            @if($loop->first)
                <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3 items-stretch">
            @endif

            <div class="group h-full flex flex-col overflow-hidden rounded-2xl border-2 border-blue-100/70 bg-white shadow-md transition duration-300 hover:shadow-[0_15px_30px_rgba(37,99,235,0.2)] hover:border-blue-500 hover:-translate-y-2">
                <div class="bg-gradient-to-r from-blue-50/80 to-indigo-50/80 border-b border-blue-100 px-6 py-5">
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-extrabold text-slate-900 line-clamp-2 group-hover:text-blue-600 transition duration-300" title="{{ $book->title }}">{{ $book->title }}</h3>
                            <p class="text-sm text-slate-500 mt-1.5 flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H5.75A2.75 2.75 0 0 0 3 4.25v11.5A2.75 2.75 0 0 0 5.75 18.5h8.5a2.75 2.75 0 0 0 2.75-2.75V8M10.5 1.5v5.25h5.25M10.5 1.5a2.75 2.75 0 0 1 2.75 2.75v2.5"/></svg>
                                {{ $book->author }}
                            </p>
                        </div>
                        <div class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-[0_4px_12px_rgba(37,99,235,0.3)] border border-blue-400 font-medium text-xl">📖</div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="rounded-lg bg-white/90 px-2.5 py-1.5 border border-blue-50 shadow-sm">
                            <span class="font-bold text-blue-700 block mb-0.5">📅 Tahun</span>
                            <span class="text-slate-600 font-semibold">{{ $book->publication_year }}</span>
                        </div>
                        <div class="rounded-lg bg-white/90 px-2.5 py-1.5 border border-blue-50 shadow-sm">
                            <span class="font-bold text-blue-700 block mb-0.5">🏢 Penerbit</span>
                            <span class="text-slate-600 font-semibold truncate block" title="{{ $book->publisher }}">{{ $book->publisher }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-1 flex-col gap-4 p-6">
                    @if($book->category || $book->isbn)
                        <div class="flex gap-2 flex-wrap">
                            @if($book->category)
                                <span class="inline-flex items-center gap-1 rounded-full bg-sky-50 border border-sky-200 px-3 py-1 text-xs font-bold text-sky-700 shadow-sm">
                                    🏷️ {{ $book->category }}
                                </span>
                            @endif
                            @if($book->isbn)
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 border border-slate-200 px-3 py-1 text-xs font-bold text-slate-600 font-mono shadow-sm">
                                    🔢 {{ $book->isbn }}
                                </span>
                            @endif
                        </div>
                    @endif

                    @if($book->summary)
                        <div class="bg-slate-50/80 rounded-xl p-4 border border-slate-100 min-h-[7rem]">
                            <p class="text-sm text-slate-600 line-clamp-4 leading-relaxed">{{ $book->summary }}</p>
                        </div>
                    @else
                        <div class="bg-slate-50/40 rounded-xl p-4 border border-dashed border-slate-200 min-h-[7rem] flex items-center justify-center">
                            <p class="text-sm text-slate-400 italic">Ringkasan belum tersedia</p>
                        </div>
                    @endif

                    <div class="flex gap-2">
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

                    <div class="mt-auto pt-4 border-t border-slate-100 space-y-3">
                        <div class="flex gap-2">
                            @if($isDigital)
                                <a href="{{ route('peminjaman.read', ['book' => $book->id]) }}" 
                                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-orange-500 px-4 py-3 text-sm font-bold text-white shadow-[0_5px_15px_rgba(220,38,38,0.35)] transition duration-300 hover:from-red-700 hover:to-orange-600 hover:shadow-[0_8px_20px_rgba(220,38,38,0.5)] active:scale-95">
                                    👁️ Baca Buku
                                </a>
                            @else
                                <a href="{{ route('peminjaman.katalog', ['book_id' => $book->id]) }}" 
                                   class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-3 text-sm font-bold text-white shadow-[0_5px_15px_rgba(37,99,235,0.35)] transition duration-300 hover:from-blue-700 hover:to-blue-600 hover:shadow-[0_8px_20px_rgba(37,99,235,0.5)] active:scale-95">
                                    📌 Pinjam Buku
                                </a>
                            @endif
                        </div>

                        @if($book->pdf_path)
                            @auth
                                @if($canRead)
                                    <div class="rounded-xl bg-blue-50 border border-blue-200 px-4 py-2.5 text-center shadow-inner">
                                        <p class="text-xs font-bold text-blue-700 flex items-center justify-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                            @if($isDigital)
                                                Klik baca untuk membuka PDF
                                            @else
                                                Buku ini sedang kamu pinjam
                                            @endif
                                        </p>
                                    </div>
                                @else
                                    <div class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-2.5 text-center">
                                        <p class="text-xs font-semibold text-slate-500">
                                            @if($isDigital)
                                                Buku digital siap dibaca
                                            @else
                                                Pinjam buku untuk membaca PDF
                                            @endif
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

            @if($loop->last)
                </div>
            @endif
        @empty
            <div class="rounded-3xl border-2 border-dashed border-blue-300 bg-white/80 backdrop-blur p-16 text-center shadow-xl">
                <div class="text-7xl mb-4 animate-bounce filter drop-shadow-[0_10px_10px_rgba(59,130,246,0.2)]">📚</div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Katalog Kosong</h2>
                <p class="text-slate-600 max-w-md mx-auto mb-6">Belum ada data buku dalam katalog. Tambahkan melalui halaman input buku untuk menampilkannya di sini.</p>
                @auth('admin')
                <a href="{{ route('admin.books.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-3.5 text-sm font-bold text-white shadow-[0_5px_15px_rgba(37,99,235,0.35)] transition duration-300 hover:from-blue-700 hover:to-blue-600 hover:shadow-[0_8px_20px_rgba(37,99,235,0.5)] active:scale-95">
                    ➕ Tambah Buku Baru
                </a>
                @endauth
            </div>
        @endforelse
    </div>
</section>
@endsection