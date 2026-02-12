<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <div class="mx-auto max-w-5xl px-6 py-12">
        <header class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Riwayat Peminjaman</p>
                    <h1 class="mt-3 text-3xl font-semibold text-slate-900 md:text-4xl">Catatan Bacaan Anda</h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Anggota: <span class="font-semibold text-slate-900">{{ $member->name }}</span>
                        <span class="text-slate-400">({{ $member->username }})</span>
                    </p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm">
                    <p class="text-xs uppercase tracking-widest text-slate-400">Terakhir diperbarui</p>
                    <p class="mt-1 font-semibold text-slate-700">{{ now()->translatedFormat('d F Y, H:i') }}</p>
                </div>
            </div>
        </header>

        @php
            $totalPeminjaman = $peminjamans->count();
            $totalAktif = $peminjamans->where('status', 'diambil')->count();
            $totalSelesai = $peminjamans->where('status', 'dikembalikan')->count();
            $nextReturn = $peminjamans->where('status', 'diambil')->sortBy('tgl_kembali')->first();
        @endphp

        <section class="mt-8 grid gap-4 md:grid-cols-3">
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-medium text-slate-500">Total Peminjaman</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalPeminjaman }}</p>
                <p class="text-xs text-slate-400">Sejak akun dibuat</p>
            </article>
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-medium text-slate-500">Sedang Dipinjam</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalAktif }}</p>
                @if($nextReturn)
                    <p class="text-xs text-slate-400">Kembali sebelum {{ \Carbon\Carbon::parse($nextReturn->tgl_kembali)->translatedFormat('d F Y') }}</p>
                @else
                    <p class="text-xs text-slate-400">Tidak ada tenggat dekat</p>
                @endif
            </article>
            <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs font-medium text-slate-500">Selesai Dibaca</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalSelesai }}</p>
                <p class="text-xs text-slate-400">Telah dikembalikan</p>
            </article>
        </section>

        @if(session('alert'))
            <div class="mt-8 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p>{{ session('alert') }}</p>
            </div>
        @endif

        <section class="mt-8 rounded-2xl border border-slate-200 bg-white shadow-sm">
            @if($peminjamans->count() > 0)
                <div class="hidden md:block overflow-hidden rounded-2xl">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">No.</th>
                                <th class="px-6 py-3 text-left font-semibold">Judul Buku</th>
                                <th class="px-6 py-3 text-left font-semibold">Tgl Pinjam</th>
                                <th class="px-6 py-3 text-left font-semibold">Tgl Kembali</th>
                                <th class="px-6 py-3 text-left font-semibold">Nomor Antrian</th>
                                <th class="px-6 py-3 text-center font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($peminjamans as $index => $pinjam)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-slate-500">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-900">{{ $pinjam->judul_buku }}</p>
                                        <p class="text-xs text-slate-400">Nomor antrian {{ $pinjam->nomor_antrian }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full border border-slate-300 px-3 py-1 text-xs text-slate-600">{{ $pinjam->nomor_antrian }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($pinjam->status === 'diambil')
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">Terpinjam</span>
                                        @elseif($pinjam->status === 'dikembalikan')
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Dikembalikan</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-600">Status tidak dikenal</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-slate-200">
                    @foreach($peminjamans as $index => $pinjam)
                        <article class="p-5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-slate-400">Peminjaman #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</p>
                                    <h3 class="mt-1 text-base font-semibold text-slate-900">{{ $pinjam->judul_buku }}</h3>
                                </div>
                                @if($pinjam->status === 'diambil')
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">Terpinjam</span>
                                @elseif($pinjam->status === 'dikembalikan')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">Dikembalikan</span>
                                @else
                                    <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-600">Status tidak dikenal</span>
                                @endif
                            </div>
                            <dl class="mt-4 space-y-2 text-sm text-slate-600">
                                <div class="flex justify-between border-b border-slate-100 pb-2">
                                    <dt>Tanggal pinjam</dt>
                                    <dd class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-slate-100 pb-2">
                                    <dt>Tanggal kembali</dt>
                                    <dd class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Nomor antrian</dt>
                                    <dd class="font-medium text-slate-800">{{ $pinjam->nomor_antrian }}</dd>
                                </div>
                            </dl>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center gap-4 px-8 py-16 text-center text-sm text-slate-500">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full border border-slate-200">📚</div>
                    <h2 class="text-lg font-semibold text-slate-800">Belum ada peminjaman tercatat</h2>
                    <p class="max-w-md">Mulai jelajahi katalog dan ajukan peminjaman untuk mengisi riwayat bacaan Anda.</p>
                    <a href="{{ route('peminjaman.show') }}" class="inline-flex items-center rounded-full border border-slate-300 px-5 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">
                        Ajukan Peminjaman Baru
                    </a>
                </div>
            @endif
        </section>

        <div class="mt-8 flex flex-col gap-3 text-sm text-slate-600 sm:flex-row">
            <a href="{{ route('peminjaman.show') }}" class="flex-1 rounded-xl border border-slate-200 bg-white px-5 py-3 text-center font-medium transition hover:bg-slate-50">
                Ajukan Peminjaman Baru
            </a>
            <form action="{{ route('logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full rounded-xl border border-slate-200 bg-slate-800 px-5 py-3 font-medium text-white transition hover:bg-slate-700">
                    Keluar dari Akun
                </button>
            </form>
        </div>

        <aside class="mt-6 rounded-xl border border-slate-200 bg-white px-5 py-4 text-sm text-slate-600">
            <p>
                <span class="font-semibold text-slate-800">Catatan:</span> Simpan nomor antrian ketika mengambil buku fisik. Status peminjaman akan diperbarui setelah petugas memverifikasi pengembalian Anda.
            </p>
        </aside>
    </div>
</body>
</html>
