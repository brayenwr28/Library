@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<section class="bg-gradient-to-br from-blue-50 via-indigo-50 to-slate-50 min-h-screen">
    <div class="mx-auto max-w-7xl px-6 pb-24 pt-10">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-4">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25c0 5.378 3.707 9.881 8.5 10.428M12 6.253c5.5 0 10 4.745 10 10.997 0 5.368-3.707 9.881-8.5 10.428" />
                    </svg>
                </div>
                <div>
                    <span class="block text-xs font-semibold uppercase tracking-wider text-blue-600">📚 Katalog Referensi</span>
                    <h1 class="text-4xl font-bold text-slate-900 mt-1">Koleksi Pilihan Perpustakaan</h1>
                </div>
            </div>
            <p class="text-slate-600 text-lg max-w-3xl">Temukan bacaan rekomendasi yang dikurasi oleh tim pustakawan. Setiap kartu menampilkan ringkasan singkat agar Anda bisa menentukan buku yang tepat sebelum mengajukan peminjaman.</p>
        </div>

        <!-- Books Grid or Empty State -->
        @forelse ($books as $book)
            @php
                $canRead = auth()->check() && in_array($book->id, $borrowedBookIds ?? [], true);
            @endphp
            @if($loop->first)
                <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
            @endif

            <!-- Book Card -->
            <div class="group h-full flex flex-col overflow-hidden rounded-2xl border-2 border-slate-200 bg-white shadow-md transition duration-300 hover:shadow-2xl hover:border-blue-300 hover:-translate-y-2">
                <!-- Header Section with Icon -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b-2 border-slate-100 px-6 py-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-900 line-clamp-2">{{ $book->title }}</h3>
                            <p class="text-sm text-slate-600 mt-1 flex items-center gap-2">
                                <svg class="h-4 w-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H5.75A2.75 2.75 0 0 0 3 4.25v11.5A2.75 2.75 0 0 0 5.75 18.5h8.5a2.75 2.75 0 0 0 2.75-2.75V8M10.5 1.5v5.25h5.25M10.5 1.5a2.75 2.75 0 0 1 2.75 2.75v2.5"/></svg>
                                {{ $book->author }}
                            </p>
                        </div>
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl">📖</div>
                    </div>
                    
                    <!-- Quick Info Row -->
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="rounded-lg bg-white/70 px-2.5 py-1.5 border border-slate-100">
                            <span class="font-semibold text-slate-600">📅 Tahun:</span>
                            <span class="text-slate-700 font-medium">{{ $book->publication_year }}</span>
                        </div>
                        <div class="rounded-lg bg-white/70 px-2.5 py-1.5 border border-slate-100">
                            <span class="font-semibold text-slate-600">🏢 Penerbit:</span>
                            <span class="text-slate-700 font-medium truncate">{{ $book->publisher }}</span>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="flex flex-1 flex-col gap-4 p-6">
                    <!-- Category & ISBN -->
                    @if($book->category || $book->isbn)
                        <div class="flex gap-2 flex-wrap">
                            @if($book->category)
                                <span class="inline-flex items-center gap-1 rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                                    🏷️ {{ $book->category }}
                                </span>
                            @endif
                            @if($book->isbn)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 font-mono">
                                    🔢 {{ $book->isbn }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <!-- Summary -->
                    @if($book->summary)
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
                            <p class="text-sm text-slate-600 line-clamp-4 leading-relaxed">{{ $book->summary }}</p>
                        </div>
                    @else
                        <div class="bg-slate-50 rounded-lg p-4 border border-dashed border-slate-200">
                            <p class="text-sm text-slate-500 italic">Ringkasan belum tersedia</p>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="flex gap-2">
                        <span class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-xs font-bold uppercase tracking-wide shadow-sm {{ $book->status === 'available' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                            <span class="inline-block h-2 w-2 rounded-full bg-white animate-pulse"></span>
                            {{ $book->status === 'available' ? '✓ Tersedia' : '✗ Tidak Tersedia' }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
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

            @if($loop->last)
                </div>
            @endif
        @empty
            <!-- Empty State -->
            <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white/80 backdrop-blur p-16 text-center">
                <div class="text-7xl mb-4 animate-bounce">📚</div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Katalog Kosong</h2>
                <p class="text-slate-600 max-w-md mx-auto">Belum ada data buku dalam katalog. Tambahkan melalui halaman input buku untuk menampilkannya di sini.</p>
                <a href="{{ route('admin.books.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    ➕ Tambah Buku
                </a>
            </div>
        @endforelse
    </div>
</section>
@endsection
