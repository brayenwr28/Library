@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            }

            50% {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.8);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes rotate-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes shine {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes gradient-shift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: float-slow 4s ease-in-out infinite;
        }

        .animate-rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }

        .animate-shine {
            background-size: 1000px 100%;
            animation: shine 3s infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        .delay-100 {
            animation-delay: 100ms;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        .delay-300 {
            animation-delay: 300ms;
        }

        .delay-400 {
            animation-delay: 400ms;
        }

        .delay-500 {
            animation-delay: 500ms;
        }

        .delay-600 {
            animation-delay: 600ms;
        }

        .group-hover\:scale-105:hover {
            transform: scale(1.05);
        }

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Smooth border animation */
        .border-gradient {
            position: relative;
            background-clip: padding-box;
        }

        .border-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            background: linear-gradient(45deg, #3b82f6, #06b6d4, #8b5cf6, #3b82f6);
            background-size: 300% 300%;
            border-radius: inherit;
            animation: gradient-shift 4s ease infinite;
        }
    </style>

    <section class="relative overflow-hidden bg-slate-950 pb-16 sm:pb-20">
        <!-- Background Image with Overlay (Less Zoomed/Right Aligned on Desktop) -->
        <div class="absolute inset-y-0 right-0 w-full md:w-[40%] lg:w-[38%] z-0">
            <img src="{{ asset('logo/gedungMetamedia.webp') }}"
                 alt="Gedung Universitas Metamedia"
                 class="h-full w-full object-cover object-center md:object-contain md:object-right opacity-30 md:opacity-55">
            <!-- Mobile overlay -->
            <div class="absolute inset-0 bg-slate-950/80 md:hidden"></div>
            <!-- Desktop fade-out gradient overlay -->
            <div class="hidden md:block absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/30 to-transparent"></div>
        </div>

        <!-- Animated background decoration -->
        <div class="absolute inset-0 overflow-hidden z-10">
            <div
                class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-gradient-to-br from-blue-500/20 to-cyan-500/10 blur-3xl animate-float">
            </div>
            <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-gradient-to-tr from-indigo-500/20 to-blue-500/10 blur-3xl animate-float-slow"
                style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-96 w-96 rounded-full bg-gradient-to-br from-purple-500/10 to-pink-500/5 blur-3xl animate-float"
                style="animation-delay: 2s;"></div>

            <!-- Floating accent shapes -->
            <div class="absolute top-20 left-20 w-32 h-32 rounded-full border border-blue-400/20 animate-rotate-slow"></div>
            <div class="absolute bottom-32 right-32 w-40 h-40 rounded-full border border-cyan-400/20 animate-rotate-slow"
                style="animation-direction: reverse;"></div>
        </div>

        @php
            $adminUser = Auth::guard('admin')->user();
            $memberUser = Auth::user();
            $currentUser = $adminUser ?? $memberUser;
        @endphp

        <div class="relative z-20 mx-auto max-w-4xl px-4 py-16 sm:px-6 sm:py-20">
            <div class="space-y-7 sm:space-y-8">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-blue-500/50 bg-gradient-to-r from-blue-500/20 to-cyan-500/20 px-3 sm:px-4 py-2 backdrop-blur-sm animate-fade-in-up hover:border-blue-400/80 transition-all">
                    <span class="h-2 w-2 rounded-full bg-blue-400 animate-pulse-glow shrink-0"></span>
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-blue-100 block md:hidden">
                        ✨ Perpustakaan Digital
                    </span>
                    <span class="text-xs font-semibold uppercase tracking-widest text-blue-100 hidden md:block">
                        ✨ Perpustakaan Digital Universitas Metamedia
                    </span>
                </div>

                @if($currentUser)
                    <!-- USER PROFILE CARD IN HERO SECTION -->
                    <div class="flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-4 sm:p-5 backdrop-blur-md animate-fade-in-up max-w-xl shadow-xl">
                        @if($memberUser && $memberUser->photo && file_exists(public_path('storage/' . $memberUser->photo)))
                            <img src="{{ asset('storage/' . $memberUser->photo) }}" alt="{{ $currentUser->name }}" class="h-14 w-14 rounded-xl object-cover border-2 border-cyan-400/60 shadow-md shrink-0">
                        @else
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-tr from-blue-600 via-cyan-600 to-teal-500 text-white font-bold text-xl shadow-md shrink-0">
                                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex flex-col text-left overflow-hidden">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <span class="text-base sm:text-lg font-bold text-white truncate">Halo, {{ $currentUser->name }} 👋</span>
                                <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold tracking-wider uppercase {{ $adminUser ? 'bg-purple-500/30 text-purple-200 border border-purple-400/40' : 'bg-cyan-500/30 text-cyan-200 border border-cyan-400/40' }}">
                                    {{ $adminUser ? 'Administrator' : 'Anggota' }}
                                </span>
                            </div>
                            <p class="text-xs sm:text-sm text-slate-300 truncate mt-0.5">
                                @if($adminUser)
                                    Email: {{ $currentUser->email }} | Akses Penuh Sistem
                                @else
                                    NIM/ID: {{ $memberUser->nim ?? $memberUser->member_id ?? '-' }} • {{ $memberUser->prodi ?? 'Anggota Perpustakaan' }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                <div class="space-y-5 sm:space-y-6">
                    <h1
                        class="text-4xl font-bold text-white leading-[1.1] sm:text-5xl md:text-6xl lg:text-7xl animate-fade-in-up delay-100">
                        <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-300 bg-clip-text text-transparent">
                            Jelajahi Pengetahuan
                        </span>
                        <br />
                        <span class="text-white">Dalam Perpustakaan</span>
                        <br />
                        <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Digital Kami
                        </span>
                    </h1>

                    <p class="max-w-xl text-base leading-relaxed text-slate-300 sm:text-lg animate-fade-in-up delay-200">
                        Platform Perpustakaan Digital Yang Inovatif Untuk Mengakses Koleksi, Jurnal, Dan Sumber Akademik
                        Dengan Mudah Dan Efisien
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:gap-4 animate-fade-in-up delay-300">
                    <a href="{{ route('katalog') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 px-5 py-3 font-semibold text-white transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-500/50 sm:w-auto sm:px-6">
                        <span>Jelajahi Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    @if($adminUser)
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-purple-400/50 bg-purple-500/20 px-5 py-3 font-semibold text-purple-100 backdrop-blur transition-all hover:-translate-y-0.5 hover:border-purple-300 hover:bg-purple-500/30 sm:w-auto sm:px-6">
                            <span>⚙️ Dashboard Admin</span>
                        </a>
                    @else
                        <a href="{{ route('peminjaman.riwayat') }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-blue-400/50 bg-blue-500/10 px-5 py-3 font-semibold text-blue-100 backdrop-blur transition-all hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-500/20 sm:w-auto sm:px-6">
                            <span>📊 Lihat Riwayat</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50 py-16 sm:py-24">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 right-0 h-96 w-96 rounded-full bg-blue-100/40 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-96 w-96 rounded-full bg-indigo-100/30 blur-3xl"></div>
            <div class="absolute top-1/2 left-1/4 h-80 w-80 rounded-full bg-purple-100/20 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6">
            <div class="mb-12 space-y-4 text-center animate-fade-in-up sm:mb-20">
                <div
                    class="inline-flex items-center justify-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3 py-2 sm:px-4">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                    <span class="text-xs font-semibold text-blue-700 sm:text-sm">Fitur Utama</span>
                </div>
                <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl md:text-5xl">
                    Layanan Unggulan Kami
                </h2>
                <p class="mx-auto max-w-2xl text-sm text-slate-600 sm:text-lg">
                    Fitur-fitur inovatif yang dirancang khusus untuk memberikan Kemudahan Dalam Mengakses Perpustakaan
                    Digital
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
                <!-- Card 1 -->
                <a href="{{ route('katalog') }}"
                    class="group relative flex h-full min-h-[230px] flex-col overflow-hidden rounded-2xl border border-blue-200/60 bg-gradient-to-br from-blue-50 via-white to-cyan-50 p-4 shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl sm:min-h-[320px] sm:p-8 animate-fade-in-up delay-100">

                    <!-- Badge -->
                    <div
                        class="absolute top-0 right-0 rounded-bl-lg bg-gradient-to-r from-blue-500 to-cyan-500 px-3 py-1 text-[10px] font-bold text-white sm:px-4 sm:py-2 sm:text-xs">
                        Populer
                    </div>

                    <!-- Background effect -->
                    <div
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-blue-500/5 to-cyan-500/5">
                    </div>

                    <div class="relative space-y-3 sm:space-y-4">
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 text-2xl shadow-lg transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-110 sm:mb-6 sm:h-16 sm:w-16 sm:text-3xl">
                            📚
                        </div>
                        <h3 class="text-lg font-bold leading-tight text-slate-900 sm:text-2xl">Katalog Digital</h3>
                        <p class="text-sm leading-relaxed text-slate-600 sm:text-base">Koleksi Digital dengan metadata lengkap dan pencarian
                            cerdas.</p>
                    </div>

                    <div class="relative mt-auto pt-4 border-t border-blue-200/50 sm:mt-8 sm:pt-6">
                        <span
                            class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 transition group-hover:text-blue-700 sm:text-sm">
                            Jelajahi katalog
                            <svg class="w-3.5 h-3.5 transition group-hover:translate-x-2 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="{{ route('admin.books.library.index') }}"
                    class="group relative flex h-full min-h-[230px] flex-col overflow-hidden rounded-2xl border border-indigo-200/60 bg-gradient-to-br from-indigo-50 via-white to-blue-50 p-4 shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl sm:min-h-[320px] sm:p-8 animate-fade-in-up delay-200">

                    <!-- Badge -->
                    <div
                        class="absolute top-0 right-0 rounded-bl-lg bg-gradient-to-r from-indigo-500 to-blue-500 px-3 py-1 text-[10px] font-bold text-white sm:px-4 sm:py-2 sm:text-xs">
                        Pro
                    </div>

                    <div
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-indigo-500/5 to-blue-500/5">
                    </div>

                    <div class="relative space-y-3 sm:space-y-4">
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-blue-500 text-2xl shadow-lg transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-110 sm:mb-6 sm:h-16 sm:w-16 sm:text-3xl">
                            🗂️
                        </div>
                        <h3 class="text-lg font-bold leading-tight text-slate-900 sm:text-2xl">Koleksi Perpustakaan</h3>
                        <p class="text-sm leading-relaxed text-slate-600 sm:text-base">Daftar buku, koleksi baru, dan ketersediaan dengan
                            mudah.</p>
                    </div>

                    <div class="relative mt-auto pt-4 border-t border-indigo-200/50 sm:mt-8 sm:pt-6">
                        <span
                            class="inline-flex items-center gap-2 text-xs font-semibold text-indigo-600 transition group-hover:text-indigo-700 sm:text-sm">
                            Kelola koleksi
                            <svg class="w-3.5 h-3.5 transition group-hover:translate-x-2 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="{{ route('ktm.index') }}"
                    class="group relative flex h-full min-h-[230px] flex-col overflow-hidden rounded-2xl border border-purple-200/60 bg-gradient-to-br from-purple-50 via-white to-indigo-50 p-4 shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl sm:min-h-[320px] sm:p-8 animate-fade-in-up delay-300">

                    <!-- Badge -->
                    <div
                        class="absolute top-0 right-0 rounded-bl-lg bg-gradient-to-r from-purple-500 to-indigo-500 px-3 py-1 text-[10px] font-bold text-white sm:px-4 sm:py-2 sm:text-xs">
                        Baru
                    </div>

                    <div
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-purple-500/5 to-indigo-500/5">
                    </div>

                    <div class="relative space-y-3 sm:space-y-4">
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 text-2xl shadow-lg transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-110 sm:mb-6 sm:h-16 sm:w-16 sm:text-3xl">
                            👥
                        </div>
                        <h3 class="text-lg font-bold leading-tight text-slate-900 sm:text-2xl">Kartu Anggota</h3>
                        <p class="text-sm leading-relaxed text-slate-600 sm:text-base">Member Perpustakaan Metamedia, status keanggotaan digital
                        </p>
                    </div>

                    <div class="relative mt-auto pt-4 border-t border-purple-200/50 sm:mt-8 sm:pt-6">
                        <span
                            class="inline-flex items-center gap-2 text-xs font-semibold text-purple-600 transition group-hover:text-purple-700 sm:text-sm">
                            Kelola anggota
                            <svg class="w-3.5 h-3.5 transition group-hover:translate-x-2 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </a>

                <!-- Card 4 -->
                <a href="{{ route('peminjaman.riwayat') }}"
                    class="group relative flex h-full min-h-[230px] flex-col overflow-hidden rounded-2xl border border-orange-200/60 bg-gradient-to-br from-orange-50 via-white to-red-50 p-4 shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl sm:min-h-[320px] sm:p-8 animate-fade-in-up delay-400">

                    <!-- Badge -->
                    <div
                        class="absolute top-0 right-0 rounded-bl-lg px-3 py-1 text-[10px] font-bold sm:px-4 sm:py-2 sm:text-xs {{ $fineStatusClass ?? 'bg-emerald-100 text-emerald-700' }}">
                        {{ $fineStatusLabel ?? 'Aman' }}
                    </div>

                    <div
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-orange-500/5 to-red-500/5">
                    </div>

                    <div class="relative space-y-3 sm:space-y-4">
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-500 text-2xl shadow-lg transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-110 sm:mb-6 sm:h-16 sm:w-16 sm:text-3xl">
                            📈
                        </div>
                        <h3 class="text-lg font-bold leading-tight text-slate-900 sm:text-2xl">Ringkasan Peminjaman</h3>
                        <p class="text-sm leading-relaxed text-slate-600 sm:text-base">
                            @if($member)
                                {{ $activeLoans->count() }} pinjaman aktif, {{ $dueSoonLoans->count() }} buku mendekati jatuh
                                tempo, dan estimasi denda
                                {{ $estimatedFine > 0 ? 'Rp ' . number_format($estimatedFine, 0, ',', '.') : '0' }}.
                            @else
                                Lihat riwayat peminjaman dan status akun Anda dalam tampilan ringkas yang mudah dipahami.
                            @endif
                        </p>
                    </div>

                    <div class="relative mt-auto pt-4 border-t border-orange-200/50 sm:mt-8 sm:pt-6">
                        <span
                            class="inline-flex items-center gap-2 text-xs font-semibold text-orange-600 transition group-hover:text-orange-700 sm:text-sm">
                            Lihat riwayat
                            <svg class="w-3.5 h-3.5 transition group-hover:translate-x-2 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </a>

                <!-- Card 5 -->
                <a href="{{ route('pengunjung.form') }}"
                    class="group relative flex h-full min-h-[230px] flex-col overflow-hidden rounded-2xl border border-green-200/60 bg-gradient-to-br from-green-50 via-white to-emerald-50 p-4 shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl sm:min-h-[320px] sm:p-8 animate-fade-in-up delay-500">

                    <!-- Badge -->
                    <div
                        class="absolute top-0 right-0 rounded-bl-lg bg-gradient-to-r from-green-500 to-emerald-500 px-3 py-1 text-[10px] font-bold text-white sm:px-4 sm:py-2 sm:text-xs">
                        Pro
                    </div>

                    <div
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-green-500/5 to-emerald-500/5">
                    </div>

                    <div class="relative space-y-3 sm:space-y-4">
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 text-2xl shadow-lg transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-110 sm:mb-6 sm:h-16 sm:w-16 sm:text-3xl">
                            📋
                        </div>
                        <h3 class="text-lg font-bold leading-tight text-slate-900 sm:text-2xl">Isi Pengunjung</h3>
                        <p class="text-sm leading-relaxed text-slate-600 sm:text-base">Catat Kunjungan Anda ke Perpustakaan Universitas
                            Metamedia.</p>
                    </div>

                    <div class="relative mt-auto pt-4 border-t border-green-200/50 sm:mt-8 sm:pt-6">
                        <span
                            class="inline-flex items-center gap-2 text-xs font-semibold text-green-600 transition group-hover:text-green-700 sm:text-sm">
                            Isi data pengunjung
                            <svg class="w-3.5 h-3.5 transition group-hover:translate-x-2 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('[data-slider]');
            if (!slider) return;

            const slides = slider.querySelectorAll('[data-slide]');
            const dots = slider.querySelectorAll('[data-dot]');
            const prevButton = slider.querySelector('[data-prev]');
            const nextButton = slider.querySelector('[data-next]');
            let activeIndex = 0;
            let timer;
            let isHovering = false;

            const updateSlides = (index) => {
                slides.forEach((slide, idx) => {
                    const isActive = idx === index;
                    slide.style.opacity = isActive ? '1' : '0';
                    slide.style.pointerEvents = isActive ? 'auto' : 'none';
                });
                dots.forEach((dot, idx) => {
                    const isActive = idx === index;
                    dot.classList.toggle('bg-white', isActive);
                    dot.classList.toggle('w-8', isActive);
                    dot.classList.toggle('bg-white/50', !isActive);
                    dot.classList.toggle('w-2.5', !isActive);
                });
                activeIndex = index;
            };

            const goTo = (index) => {
                const nextIndex = (index + slides.length) % slides.length;
                updateSlides(nextIndex);
                restartTimer();
            };

            const restartTimer = () => {
                if (timer) clearInterval(timer);
                if (!isHovering) {
                    timer = setInterval(() => goTo(activeIndex + 1), 6000);
                }
            };

            // Hover pause functionality
            slider.addEventListener('mouseenter', () => {
                isHovering = true;
                if (timer) clearInterval(timer);
            });

            slider.addEventListener('mouseleave', () => {
                isHovering = false;
                restartTimer();
            });

            prevButton?.addEventListener('click', () => goTo(activeIndex - 1));
            nextButton?.addEventListener('click', () => goTo(activeIndex + 1));
            dots.forEach((dot, idx) => dot.addEventListener('click', () => goTo(idx)));

            updateSlides(0);
            restartTimer();
        });
    </script>
@endsection