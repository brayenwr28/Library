<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pustaka | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slideIn {
            animation: slideIn 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen p-6">

<!-- Container -->
<div class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="text-center mb-12 animate-slideIn">
        <h1 class="text-4xl font-bold text-slate-800 mb-2">🎉 Selamat Bergabung!</h1>
        <p class="text-slate-600">Anda telah terdaftar sebagai anggota Perpustakaan Digital</p>
    </div>

    <!-- Kartu Pustaka -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden animate-slideIn" style="animation-delay: 0.2s;">
        
        <!-- Card Background -->
        <div class="h-32 bg-gradient-to-r from-slate-700 to-slate-900"></div>

        <!-- Card Content -->
        <div class="px-8 py-8 relative -mt-16">
            
            <!-- Logo & Header -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-slate-800">KARTU ANGGOTA</h2>
                        <p class="text-sm text-slate-500 mt-1">Perpustakaan Digital Universitas Metamedia</p>
                    </div>
                    <div class="text-right">
                        <img src="/logo/logo-univ.png" alt="Logo" class="w-24 h-24 object-contain">
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="border-t border-slate-200 pt-6">
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Nomor Anggota</p>
                            <p class="text-lg font-bold text-slate-800 tracking-wider">{{ $member->member_id }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Tanggal Daftar</p>
                            <p class="text-lg font-bold text-slate-800">
                                @if($member->tgl_daftar)
                                    {{ \Carbon\Carbon::parse($member->tgl_daftar)->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Nama Lengkap</p>
                            <p class="text-xl font-bold text-slate-800">{{ $member->name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase mb-1">NIM</p>
                                <p class="text-lg font-semibold text-slate-700">{{ $member->nim }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Program Studi</p>
                                <p class="text-lg font-semibold text-slate-700">{{ $member->prodi }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer dengan Stempel & Tanda Tangan -->
                <div class="border-t border-slate-200 mt-8 pt-8">
                    <div class="grid grid-cols-3 gap-6 text-center">
                        <!-- Stempel -->
                        <div>
                            <div class="h-24 flex items-center justify-center mb-3 border-2 border-dashed border-red-300 rounded">
                                @if($member->stamp_path)
                                    <img src="{{ asset('storage/' . $member->stamp_path) }}" alt="Stempel" class="max-h-20 max-w-full">
                                @else
                                    <svg class="w-16 h-16 text-red-400 opacity-50" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="2"/>
                                        <text x="50" y="45" text-anchor="middle" font-size="10" font-weight="bold" fill="currentColor" transform="rotate(-15 50 50)">RESMI</text>
                                        <text x="50" y="60" text-anchor="middle" font-size="8" fill="currentColor">PERPUSTAKAAN</text>
                                    </svg>
                                @endif
                            </div>
                            <p class="text-xs font-semibold text-slate-500">Stempel Perpustakaan</p>
                        </div>

                        <!-- Tanggal -->
                        <div>
                            <p class="text-xs font-semibold text-slate-500 mb-2">TANGGAL</p>
                            <p class="text-sm font-semibold text-slate-700">{{ now()->format('d M Y') }}</p>
                        </div>

                        <!-- Tanda Tangan -->
                        <div>
                            <div class="h-24 mb-2 flex items-end justify-center text-slate-700 italic">
                                @if($member->signature_path)
                                    <img src="{{ asset('storage/' . $member->signature_path) }}" alt="Tanda Tangan" class="max-h-21 max-w-full">
                                @else
                                    _______________
                                @endif
                            </div>
                            <p class="text-xs font-semibold text-slate-500">Winda Sari, A.Md</p>
                            <p class="text-xs font-semibold text-slate-500">Tanda Tangan Pustakawan</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
                <p class="text-sm text-slate-700">
                    <strong>Catatan:</strong> Kartu ini berlaku sebagai identitas resmi anggota Perpustakaan Digital. Simpan dengan baik dan tunjukkan saat melakukan peminjaman buku.
                </p>
            </div>

        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex gap-4 justify-center">
        <a href="/" 
           class="border border-slate-700 text-slate-700 px-8 py-3 rounded-lg hover:bg-slate-100 transition font-semibold">
            ← Kembali ke Beranda
        </a>
        <a href="{{ route('member.download-pdf', $member->id) }}" 
           class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
            ⬇️ Download Kartu PDF
        </a>
    </div>

</div>

</body>
</html>
