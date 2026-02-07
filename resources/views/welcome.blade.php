<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital | Universitas Metamedia</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.85); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-fadeUp {
            animation: fadeUp 0.9s ease-out forwards;
        }

        .animate-zoomIn {
            animation: zoomIn 0.7s ease-out forwards;
        }

        .delay-1 { animation-delay: .3s; }
        .delay-2 { animation-delay: .6s; }
        .delay-3 { animation-delay: .9s; }

        .feature-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            overflow: hidden;
            position: relative;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
            z-index: 1;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 3.5rem;
            line-height: 1;
            display: block;
            margin-bottom: 1rem;
            transition: transform 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.15) rotate(5deg);
        }

        .feature-gradient-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .feature-gradient-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .feature-gradient-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .feature-gradient-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
    </style>
</head>

<body class="bg-white min-h-screen text-slate-700">

<!-- ================= HERO ================= -->
<section class="relative pt-40 pb-32 text-center px-6">
    <div class="absolute inset-0 bg-gradient-to-b from-slate-100 to-white -z-10"></div>

    <h1 class="text-4xl md:text-5xl font-bold animate-fadeUp">
        Perpustakaan Digital<br>Universitas Metamedia
    </h1>   

    <p class="mt-5 text-slate-500 animate-fadeUp delay-1">
        Layanan perpustakaan digital berbasis web<br>
        untuk mendukung kegiatan akademik
    </p>

    <div class="mt-10 flex justify-center gap-4 animate-fadeUp delay-2">
        <button class="bg-slate-700 text-white px-7 py-3 rounded-lg hover:bg-slate-800 transition">
            Cari Buku
        </button>
    </div>
</section>

<!-- ================= FITUR ================= -->
<section class="px-6 md:px-10 py-16">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">

        <!-- Katalog Digital -->
        <div class="feature-card feature-gradient-1 p-8 text-center text-white animate-fadeUp delay-1">
            <span class="feature-icon">📖</span>
            <h3 class="font-bold text-xl mb-2">Katalog Digital</h3>
            <p class="text-white text-opacity-90 text-sm">Pencarian buku cepat dan terstruktur dengan filter lengkap</p>
        </div>

        <!-- Peminjaman Online -->
        <a href="{{ route('peminjaman.index') }}" class="feature-card feature-gradient-2 p-8 text-center text-white animate-fadeUp delay-2 block cursor-pointer">
            <span class="feature-icon">�</span>
            <h3 class="font-bold text-xl mb-2">Peminjaman Online</h3>
            <p class="text-white text-opacity-90 text-sm">Tanpa antre dan efisien langsung dari aplikasi</p>
        </a>

        <!-- Manajemen Anggota -->
        <div class="feature-card feature-gradient-3 p-8 text-center text-white animate-fadeUp delay-3">
            <span class="feature-icon">👥</span>
            <h3 class="font-bold text-xl mb-2">Manajemen Anggota</h3>
            <p class="text-white text-opacity-90 text-sm">Data anggota terintegrasi dengan sistem keamanan</p>
        </div>

        <!-- Riwayat Peminjaman -->
        <div class="feature-card feature-gradient-4 p-8 text-center text-white animate-fadeUp delay-3">
            <span class="feature-icon">📊</span>
            <h3 class="font-bold text-xl mb-2">Riwayat</h3>
            <p class="text-white text-opacity-90 text-sm">Monitoring peminjaman dan laporan terperinci</p>
        </div>

    </div>
</section>

</body>
</html>
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
@endsection
