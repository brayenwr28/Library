@extends('layouts.app')
@section('title', 'Isi Data Pengunjung')

@section('content')
<section class="bg-gradient-to-br from-blue-50 via-emerald-50 to-green-50 min-h-screen py-12 px-4">

    <div class="mx-auto max-w-2xl">

        <!-- Header -->
        <div class="mb-10 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-500 text-white mb-4 shadow-lg">
                <i class="fas fa-clipboard-check text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-slate-900 mb-3">Daftar Pengunjung</h1>
            <p class="text-slate-600 text-base">
                Silakan isi data diri Anda untuk mengakses layanan perpustakaan
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-green-100">

            <!-- Title -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-6 rounded-t-3xl">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-pen"></i> Formulir Pengunjung
                </h2>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('pengunjung.store') }}" class="p-8 space-y-6">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-base font-semibold text-slate-800 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama"
                        value="{{ old('nama') }}"
                        class="w-full px-5 py-4 text-base rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-400 focus:border-green-500 outline-none"
                        required>
                </div>

                <!-- Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-slate-700">
                    <p class="font-semibold text-blue-800 mb-2">Panduan:</p>
                    <ul class="list-disc ml-5 space-y-1">
                        <li>Mahasiswa → isi NIM</li>
                        <li>Dosen → isi NIDN</li>
                        <li>Umum → boleh dikosongkan</li>
                    </ul>
                </div>

                <!-- NIM -->
                <div>
                    <label class="block text-base font-semibold text-slate-800 mb-2">
                        NIM / NIDN <span class="text-slate-400 text-sm">(Opsional)</span>
                    </label>
                    <input 
                        type="text" 
                        name="nim"
                        value="{{ old('nim') }}"
                        class="w-full px-5 py-4 text-base rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 outline-none">
                </div>

                <!-- Button -->
                <div class="flex gap-4 pt-4">
                    <button 
                        type="submit"
                        class="flex-1 py-4 text-base font-bold bg-green-500 text-white rounded-xl hover:bg-green-600 transition">
                        Daftar Sekarang
                    </button>

                    <a href="/" 
                       class="px-6 py-4 border border-slate-300 rounded-xl text-slate-700 hover:bg-slate-100 transition">
                        Batal
                    </a>
                </div>

                <p class="text-center text-sm text-slate-500 mt-4">
                    Data Anda aman dan terlindungi
                </p>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-slate-500 mt-6">
            Perpustakaan Universitas Metamedia © 2026
        </div>

    </div>
</section>
@endsection