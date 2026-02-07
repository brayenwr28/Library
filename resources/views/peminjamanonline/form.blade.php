<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Online | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen p-6">

    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800 mb-2">📚 Form Peminjaman Online</h1>
            <p class="text-slate-600">Halo, <strong>{{ $member->name }}</strong>! Ajukan peminjaman buku Anda sekarang.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="font-semibold text-red-700 mb-2">❌ Terjadi Kesalahan:</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Judul Buku (Dropdown) -->
                <div>
                    <label for="judul_buku" class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Buku *
                    </label>
                    <select 
                        id="judul_buku" 
                        name="judul_buku" 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-700 transition"
                        required
                    >
                        <option value="">-- Pilih Judul Buku --</option>
                        <option value="Teknologi Komputer" @selected(old('judul_buku') == 'Teknologi Komputer')>Teknologi Komputer</option>
                        <option value="Sejarah Komputer" @selected(old('judul_buku') == 'Sejarah Komputer')>Sejarah Komputer</option>
                        <option value="Perangkat Lunak Terbaru" @selected(old('judul_buku') == 'Perangkat Lunak Terbaru')>Perangkat Lunak Terbaru</option>
                        <option value="Design Komunikasi Visual" @selected(old('judul_buku') == 'Design Komunikasi Visual')>Design Komunikasi Visual</option>
                    </select>
                </div>

                <!-- Tanggal Pinjam -->
                <div>
                    <label for="tgl_pinjam" class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Pinjam *
                    </label>
                    <input 
                        type="date" 
                        id="tgl_pinjam" 
                        name="tgl_pinjam" 
                        value="{{ old('tgl_pinjam') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-700 transition"
                        required
                    >
                </div>

                <!-- Tanggal Kembali -->
                <div>
                    <label for="tgl_kembali" class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Kembali *
                    </label>
                    <input 
                        type="date" 
                        id="tgl_kembali" 
                        name="tgl_kembali" 
                        value="{{ old('tgl_kembali') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-700 transition"
                        required
                    >
                </div>

                <!-- Upload Bukti Registrasi -->
                <div>
                    <label for="bukti_registrasi" class="block text-sm font-semibold text-slate-700 mb-2">
                        Upload Bukti Screenshot Registrasi (Opsional)
                    </label>
                    <input 
                        type="file" 
                        id="bukti_registrasi" 
                        name="bukti_registrasi" 
                        accept="image/*"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-700 transition"
                    >
                    <p class="text-xs text-slate-500 mt-2">Format: JPEG, PNG, JPG, GIF. Ukuran maksimal: 2MB</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 bg-slate-700 hover:bg-slate-800 text-white font-semibold py-3 rounded-lg transition duration-200"
                    >
                        📋 Ajukan Peminjaman
                    </button>
                    <a href="/peminjaman/riwayat" class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-3 rounded-lg transition duration-200 text-center">
                        📖 Lihat Riwayat
                    </a>
                </div>
            </form>

            <!-- Info Box -->
            <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-slate-700">
                    <strong>ℹ️ Info:</strong> Setelah mengajukan peminjaman, Anda akan mendapatkan nomor antrian. 
                    Silakan ambil buku di perpustakaan dengan menunjukkan nomor antrian tersebut.
                </p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-6">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-slate-600 hover:text-slate-800 font-semibold">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>

</body>
</html>
