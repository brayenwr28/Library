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
            <p class="text-slate-600">Halo, <strong>{{ $member->name }} ID: {{ $member->member_id }}</strong>! Ajukan peminjaman buku Anda sekarang.</p>
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

            <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                @php
                    $defaultBookId = old('book_id', $selectedBookId ?? null);
                @endphp

                <!-- Informasi Buku -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Buku *
                    </label>

                    @if(isset($selectedBook) && $selectedBook)
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700">
                            <p class="font-semibold text-slate-900">{{ $selectedBook->title }}</p>
                            <p>{{ $selectedBook->author }} · {{ $selectedBook->publication_year }}</p>
                            @if($selectedBook->publisher)
                                <p class="text-xs text-slate-500">Penerbit: {{ $selectedBook->publisher }}</p>
                            @endif
                            @if($selectedBook->category)
                                <p class="text-xs text-slate-500">Kategori: {{ $selectedBook->category }}</p>
                            @endif
                            <p class="mt-2 text-xs text-emerald-600">Buku dipilih otomatis dari katalog.</p>
                        </div>

                        <input type="hidden" name="book_id" value="{{ $selectedBook->id }}">
                    @else
                        <select
                            id="book_id"
                            name="book_id"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-700 transition"
                            required
                            @disabled($books->isEmpty())
                        >
                            <option value="">-- Pilih Judul Buku --</option>
                            @forelse($books as $book)
                                <option value="{{ $book->id }}" @selected($defaultBookId == $book->id)>
                                    {{ $book->title }} — {{ $book->author }} ({{ $book->publication_year }})
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada buku tersedia</option>
                            @endforelse
                        </select>
                        <p class="text-xs text-slate-500 mt-2">Buku yang dapat dipinjam adalah yang sudah memiliki file PDF dan berstatus tersedia.</p>
                    @endif
                </div>

                @if($books->isEmpty())
                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-700">
                        Belum ada buku yang tersedia untuk dipinjam. Silakan hubungi petugas perpustakaan untuk menambahkan koleksi.
                    </div>
                @endif

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
                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 bg-slate-700 hover:bg-slate-800 text-white font-semibold py-3 rounded-lg transition duration-200"
                    >
                        📋 Ajukan Peminjaman
                    </button>
                    <a href="{{ route('peminjaman.riwayat') }}" class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-3 rounded-lg transition duration-200 text-center">
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
