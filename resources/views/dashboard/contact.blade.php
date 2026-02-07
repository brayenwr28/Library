<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Contact Person | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeUp { animation: fadeUp .9s ease-out forwards; }
        .delay-1 { animation-delay: .2s; }
        .delay-2 { animation-delay: .4s; }
        .delay-3 { animation-delay: .6s; }
    </style>
</head>

<body class="bg-slate-100 text-slate-700">

<!-- ================= HEADER ================= -->
<section class="relative overflow-hidden pt-20">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-300 to-slate-100"></div>
    <div class="relative py-28 text-center animate-fadeUp">
        <span class="inline-block mb-3 px-4 py-1 rounded-full bg-slate-700 text-white text-xs tracking-wide">
            Informasi & Kontak
        </span>
        <h1 class="text-4xl md:text-5xl font-bold">
            Perpustakaan Digital
        </h1>
        <p class="mt-4 text-slate-600">
            Universitas Metamedia
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="px-10 py-20 grid grid-cols-1 md:grid-cols-3 gap-8">

    <!-- Informasi Umum -->
    <div class="group bg-white p-7 rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition animate-fadeUp delay-1">
        <div class="w-12 h-12 rounded-full bg-slate-700 text-white flex items-center justify-center mb-5">
            📚
        </div>
        <h2 class="font-semibold text-lg mb-4">Informasi Umum</h2>
        <ul class="space-y-2 text-sm text-slate-600 leading-relaxed">
            <li><strong>Nama:</strong> Perpustakaan Universitas Metamedia</li>
            <li><strong>Alamat:</strong> Jl. Khatib Sulaiman Dalam No.1, Padang</li>
            <li><strong>Email:</strong> rektorat@metamedia.ac.id</li>
            <li><strong>Telepon:</strong> +62 853-6309-7108</li>
        </ul>
    </div>

    <!-- Pustakawan -->
    <div class="group bg-white p-7 rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition animate-fadeUp delay-2">
        <div class="w-12 h-12 rounded-full bg-slate-700 text-white flex items-center justify-center mb-5">
            👤
        </div>
        <h2 class="font-semibold text-lg mb-4">Pustakawan</h2>
        <ul class="space-y-2 text-sm text-slate-600">
            <li><strong>Nama:</strong> Winda Sari, A.Md</li>
            <li><strong>Jabatan:</strong> Kepala Perpustakaan</li>
            <li><strong>Email:</strong> windatwinsbeuty@gmail.com</li>
        </ul>
    </div>

    <!-- Jam Operasional -->
    <div class="group bg-white p-7 rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition animate-fadeUp delay-3">
        <div class="w-12 h-12 rounded-full bg-slate-700 text-white flex items-center justify-center mb-5">
            🕒
        </div>
        <h2 class="font-semibold text-lg mb-4">Jam Operasional</h2>
        <ul class="space-y-2 text-sm text-slate-600">
            <li>Senin – Jumat: 08.00 – 15.00 WIB</li>
            <li>Sabtu: 09.00 – 13.00 WIB</li>
            <li>Minggu & Libur Nasional: Tutup</li>
        </ul>
    </div>

</section>

<!-- ================= MAP ================= -->
<section class="px-10 pb-20 animate-fadeUp delay-2">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200">
        <div class="px-6 py-4 border-b font-semibold flex items-center gap-2">
            📍 Lokasi Perpustakaan
        </div>
        <iframe
            src="https://www.google.com/maps?q=Universitas+Metamedia&output=embed"
            class="w-full h-[380px] border-0"
            loading="lazy">
        </iframe>
    </div>
</section>

<!-- ================= NOTE ================= -->
<section class="px-10 pb-24 animate-fadeUp delay-3">
    <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl shadow-sm">
        <h3 class="font-semibold mb-2 flex items-center gap-2">
            ℹ️ Catatan Layanan
        </h3>
        <p class="text-sm text-slate-600 leading-relaxed">
            Layanan peminjaman buku dilakukan pada jam operasional.
            Pengguna diharapkan membawa kartu identitas mahasiswa
            saat melakukan pengambilan buku di perpustakaan.
        </p>
    </div>
</section>

</body>
</html>

@extends('layouts.app')

@section('title', 'Contact Person')

@section('content')
@endsection
