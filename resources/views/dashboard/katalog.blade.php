@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<section class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-6 pb-20 pt-32">
        <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="space-y-3">
                <span class="inline-flex items-center rounded-full bg-white px-4 py-1 text-xs font-semibold uppercase tracking-wide text-slate-500 shadow-sm">
                    Katalog Referensi
                </span>
                <h1 class="text-3xl font-semibold text-slate-900 md:text-4xl">Koleksi Pilihan Perpustakaan</h1>
                <p class="max-w-2xl text-sm text-slate-600">Temukan bacaan rekomendasi yang dikurasi oleh tim pustakawan. Setiap kartu menampilkan ringkasan singkat agar Anda bisa menentukan buku yang tepat sebelum mengajukan peminjaman.</p>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($books as $book)
                @php
                    $canRead = auth()->check() && in_array($book->id, $borrowedBookIds ?? [], true);
                @endphp
                <div class="group flex h-full flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-slate-300 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $book->title }}</h3>
                            <p class="text-sm text-slate-500">{{ $book->author }} · {{ $book->publication_year }}</p>
                            <p class="text-xs text-slate-500">Penerbit: {{ $book->publisher }}</p>
                            @if($book->category)
                                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">{{ $book->category }}</p>
                            @endif
                        </div>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600">📘</span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-600">{{ $book->summary ? Str::limit($book->summary, 140) : 'Ringkasan belum tersedia.' }}</p>
                    <div class="mt-auto flex flex-col gap-3 pt-2">
                        <div class="flex items-center justify-between gap-3">
                            @if(! $canRead)
                                <a href="{{ route('peminjaman.show', ['book_id' => $book->id]) }}" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700">
                                    Pinjam Buku
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            @else
                                <a href="{{ route('peminjaman.read', ['book' => $book->id]) }}" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                    Baca Buku Ini
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            @endif
                            <div class="text-right text-xs text-slate-500">
                                <p>ISBN: {{ $book->isbn ?? '-' }}</p>
                                <span class="mt-1 inline-flex items-center justify-end gap-1 rounded-full px-2 py-1 text-[11px] font-semibold
                                    {{ $book->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $book->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3 text-xs">
                            @if($book->pdf_path)
                                @auth
                                    @if($canRead)
                                        <span class="inline-flex items-center gap-2 rounded-lg bg-emerald-50 px-4 py-2 text-xs font-semibold text-emerald-700">
                                            Buku ini sedang kamu pinjam
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-lg bg-slate-200 px-4 py-2 text-xs font-semibold text-slate-600">
                                            Pinjam buku untuk membaca
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg bg-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-300">
                                        Masuk untuk membaca
                                    </a>
                                @endauth
                            @else
                                <span class="inline-flex items-center gap-2 rounded-lg bg-slate-200 px-4 py-2 text-xs font-semibold text-slate-600">
                                    PDF belum tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                    Belum ada data buku dalam katalog. Tambahkan melalui halaman input buku.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
