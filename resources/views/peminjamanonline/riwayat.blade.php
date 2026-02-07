<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen p-6">

    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 mb-2">📖 Riwayat Peminjaman</h1>
            <p class="text-slate-600">Anggota: <strong>{{ $member->name }}</strong> ({{ $member->username }})</p>
        </div>

        <!-- Alert Message -->
        @if(session('alert'))
            <div class="mb-6 p-4 bg-green-50 border-2 border-green-300 rounded-lg animate-bounce">
                <p class="text-green-700 font-semibold text-lg">
                    ✅ {{ session('alert') }}
                </p>
            </div>
        @endif

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            
            @if($peminjamans->count() > 0)
                <!-- Table for Desktop -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-700 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">No.</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Nama Buku</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Tgl Pinjam</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Tgl Kembali</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Nomor Antrian</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($peminjamans as $index => $pinjam)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-800">{{ $pinjam->judul_buku }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-mono font-bold text-slate-700">
                                        {{ $pinjam->nomor_antrian }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($pinjam->status === 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">⏳ Menunggu</span>
                                        @elseif($pinjam->status === 'diambil')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">📚 Diambil</span>
                                        @elseif($pinjam->status === 'dikembalian')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">✅ Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Card View for Mobile -->
                <div class="md:hidden space-y-4">
                    @foreach($peminjamans as $index => $pinjam)
                        <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="text-sm text-slate-500">Peminjaman #{{ $index + 1 }}</p>
                                    <h3 class="text-lg font-bold text-slate-800">{{ $pinjam->judul_buku }}</h3>
                                </div>
                                @if($pinjam->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">⏳ Menunggu</span>
                                @elseif($pinjam->status === 'diambil')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">📚 Diambil</span>
                                @elseif($pinjam->status === 'dikembalian')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">✅ Dikembalikan</span>
                                @endif
                            </div>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-semibold text-slate-700">Pinjam:</span> {{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d/m/Y') }}</p>
                                <p><span class="font-semibold text-slate-700">Kembali:</span> {{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d/m/Y') }}</p>
                                <p class="font-mono"><span class="font-semibold text-slate-700">No. Antrian:</span> <strong class="text-slate-800">{{ $pinjam->nomor_antrian }}</strong></p>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📚</div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Belum Ada Peminjaman</h2>
                    <p class="text-slate-600 mb-6">Anda belum melakukan peminjaman buku. Mulai dengan mengajukan peminjaman sekarang!</p>
                    <a href="/peminjaman" class="inline-block bg-slate-700 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-lg transition">
                        ➕ Ajukan Peminjaman Baru
                    </a>
                </div>
            @endif

        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 mt-8 flex-wrap">
            <a href="/peminjaman" class="flex-1 min-w-max bg-slate-700 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-lg transition text-center">
                ➕ Ajukan Peminjaman Baru
            </a>
            <form action="{{ route('logout') }}" method="POST" class="flex-1 min-w-max">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                    🚪 Logout
                </button>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-slate-700">
                <strong>ℹ️ Info:</strong> Nomor antrian kami gunakan untuk mengidentifikasi peminjaman Anda. 
                Silakan tunjukkan nomor antrian ketika mengambil buku di perpustakaan.
            </p>
        </div>
    </div>

</body>
</html>
