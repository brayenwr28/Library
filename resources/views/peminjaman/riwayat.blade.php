<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative min-h-screen bg-slate-950 text-slate-100">
    <div class="absolute inset-0 -z-20 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-950"></div>
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,rgba(94,234,212,0.25),transparent_45%),radial-gradient(circle_at_bottom,rgba(148,163,184,0.18),transparent_50%)]"></div>

    <div class="relative mx-auto max-w-6xl px-6 py-12">
        <header class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-[0_20px_60px_-25px_rgba(15,23,42,0.65)] backdrop-blur-xl">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1 text-xs font-semibold tracking-[0.3em] uppercase text-emerald-100">
                        Riwayat Peminjaman
                    </span>
                    <h1 class="mt-4 text-3xl font-semibold text-white md:text-4xl">Buku yang Pernah Kamu Jelajahi</h1>
                    <p class="mt-3 text-sm leading-relaxed text-slate-200">
                        Anggota: <span class="font-semibold text-white">{{ $member->name }}</span>
                        <span class="text-slate-300">({{ $member->username }})</span>
                    </p>
                </div>
                <div class="flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 px-5 py-4">
                    <div class="rounded-full bg-emerald-400/20 p-3 text-emerald-200">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-8 4h6m3 5H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-slate-300">Terakhir diperbarui</p>
                        <p class="text-sm font-semibold text-white">{{ now()->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </header>

        @php
            $totalPeminjaman = $peminjamans->count();
            $totalAktif = $peminjamans->where('status', 'diambil')->count();
            $totalSelesai = $peminjamans->where('status', 'dikembalikan')->count();
            $nextReturn = $peminjamans->where('status', 'diambil')->sortBy('tgl_kembali')->first();
        @endphp

        <section class="mt-10 grid gap-5 md:grid-cols-3">
            <article class="rounded-3xl border border-white/10 bg-white/10 p-6 shadow-[0_15px_45px_-20px_rgba(16,185,129,0.55)]">
                <p class="text-xs font-medium uppercase tracking-widest text-emerald-200">Total Peminjaman</p>
                <div class="mt-3 flex items-end gap-2">
                    <span class="text-4xl font-semibold text-white">{{ $totalPeminjaman }}</span>
                    <span class="text-xs text-slate-300">sepanjang waktu</span>
                </div>
            </article>
            <article class="rounded-3xl border border-white/10 bg-white/10 p-6 shadow-[0_15px_45px_-20px_rgba(59,130,246,0.45)]">
                <p class="text-xs font-medium uppercase tracking-widest text-blue-200">Sedang Dipinjam</p>
                <div class="mt-3 flex items-end gap-2">
                    <span class="text-4xl font-semibold text-white">{{ $totalAktif }}</span>
                    <span class="text-xs text-slate-300">buku aktif</span>
                </div>
                @if($nextReturn)
                    <p class="mt-2 text-xs text-slate-300">Kembali sebelum <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($nextReturn->tgl_kembali)->translatedFormat('d F Y') }}</span></p>
                @endif
            </article>
            <article class="rounded-3xl border border-white/10 bg-white/10 p-6 shadow-[0_15px_45px_-20px_rgba(96,165,250,0.35)]">
                <p class="text-xs font-medium uppercase tracking-widest text-slate-200">Selesai Dibaca</p>
                <div class="mt-3 flex items-end gap-2">
                    <span class="text-4xl font-semibold text-white">{{ $totalSelesai }}</span>
                    <span class="text-xs text-slate-300">telah dikembalikan</span>
                </div>
            </article>
        </section>

        @if(session('alert'))
            <div class="mt-8 flex items-center gap-3 rounded-2xl border border-emerald-300/30 bg-emerald-400/15 px-6 py-4 text-emerald-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p class="text-sm font-medium">{{ session('alert') }}</p>
            </div>
        @endif

        <section class="mt-8 rounded-3xl border border-white/10 bg-white text-slate-800 shadow-[0_30px_80px_-40px_rgba(15,23,42,0.6)]">
            @if($peminjamans->count() > 0)
                <div class="hidden md:block overflow-hidden rounded-3xl">
                    <table class="min-w-full border-separate border-spacing-y-2">
                        <thead>
                            <tr class="bg-slate-900 text-slate-100">
                                <th class="rounded-l-2xl px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest">No.</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest">Judul Buku</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest">Tgl Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest">Tgl Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-widest">Nomor Antrian</th>
                                <th class="rounded-r-2xl px-6 py-4 text-center text-xs font-semibold uppercase tracking-widest">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $index => $pinjam)
                                <tr class="bg-white/90 text-slate-700 shadow-sm transition hover:-translate-y-1 hover:bg-white">
                                    <td class="rounded-l-2xl px-6 py-5 align-top text-sm font-semibold text-slate-500">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-5 align-top">
                                        <p class="font-semibold text-slate-900">{{ $pinjam->judul_buku }}</p>
                                        <p class="mt-1 text-xs text-slate-500">Nomor antrian <span class="font-mono text-slate-700">{{ $pinjam->nomor_antrian }}</span></p>
                                    </td>
                                    <td class="px-6 py-5 align-top text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-5 align-top text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            {{ $pinjam->nomor_antrian }}
                                        </span>
                                    </td>
                                    <td class="rounded-r-2xl px-6 py-5 text-center align-top">
                                        @if($pinjam->status === 'diambil')
                                            <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                                Terpinjam
                                            </span>
                                        @elseif($pinjam->status === 'dikembalikan')
                                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                                Dikembalikan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">
                                                <span class="h-2 w-2 rounded-full bg-slate-500"></span>
                                                Status tidak dikenal
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="space-y-4 border-t border-slate-200/80 px-6 py-6 md:hidden">
                    @foreach($peminjamans as $index => $pinjam)
                        <article class="rounded-2xl border border-slate-200/80 bg-white/95 p-5 text-slate-700 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Peminjaman #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</p>
                                    <h3 class="mt-1 text-lg font-semibold text-slate-900">{{ $pinjam->judul_buku }}</h3>
                                </div>
                                @if($pinjam->status === 'diambil')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        ● Terpinjam
                                    </span>
                                @elseif($pinjam->status === 'dikembalikan')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        ● Dikembalikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">
                                        ● Status tidak dikenal
                                    </span>
                                @endif
                            </div>
                            <dl class="mt-4 grid gap-3 text-sm">
                                <div class="flex justify-between border-b border-slate-200/70 pb-2">
                                    <dt class="text-slate-500">Tanggal pinjam</dt>
                                    <dd class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-slate-200/70 pb-2">
                                    <dt class="text-slate-500">Tanggal kembali</dt>
                                    <dd class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-slate-500">Nomor antrian</dt>
                                    <dd class="font-mono font-semibold text-slate-800">{{ $pinjam->nomor_antrian }}</dd>
                                </div>
                            </dl>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center gap-6 px-8 py-16 text-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-4xl">📚</div>
                    <h2 class="text-2xl font-semibold text-slate-900">Belum ada peminjaman tercatat</h2>
                    <p class="max-w-md text-sm text-slate-600">Kamu belum meminjam buku apa pun. Jelajahi katalog dan ajukan peminjaman pertama kamu untuk mulai membaca.</p>
                    <a href="{{ route('peminjaman.show') }}" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                        ➕ Ajukan Peminjaman Baru
                    </a>
                </div>
            @endif
        </section>

        <div class="mt-10 flex flex-col gap-4 sm:flex-row">
            <a href="{{ route('peminjaman.show') }}" class="flex-1 rounded-2xl border border-white/10 bg-white/10 px-6 py-4 text-center text-sm font-semibold text-white shadow-[0_15px_45px_-30px_rgba(15,23,42,0.8)] transition hover:bg-white/15">
                ➕ Ajukan Peminjaman Baru
            </a>
            <form action="{{ route('logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full rounded-2xl border border-rose-200/40 bg-rose-500/80 px-6 py-4 text-sm font-semibold text-white shadow-[0_18px_45px_-25px_rgba(244,63,94,0.65)] transition hover:bg-rose-500">
                    🚪 Keluar dari Akun
                </button>
            </form>
        </div>

        <aside class="mt-8 rounded-3xl border border-white/10 bg-white/10 p-6 text-sm text-slate-200 shadow-[0_25px_65px_-35px_rgba(15,23,42,0.7)]">
            <p>
                <span class="font-semibold text-white">Catatan:</span> Simpan nomor antrian sebagai bukti ketika mengambil buku fisik di perpustakaan. Status akan otomatis berganti menjadi "Dikembalikan" setelah petugas memverifikasi pengembalian Anda.
            </p>
        </aside>
    </div>

</body>
</html>
