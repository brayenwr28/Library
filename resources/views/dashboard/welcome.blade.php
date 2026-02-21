@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 pb-20">
    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden">
        <div
            class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-gradient-to-br from-blue-500/20 to-cyan-500/10 blur-3xl">
        </div>
        <div
            class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-gradient-to-tr from-indigo-500/20 to-blue-500/10 blur-3xl">
        </div>
    </div>

    <div class="relative mx-auto flex max-w-6xl flex-col gap-12 px-6 py-20 md:flex-row md:items-center">
        <div class="flex-1 space-y-8">
            <div
                class="inline-flex items-center gap-2 rounded-full border border-blue-500/30 bg-blue-500/10 px-4 py-2 backdrop-blur-sm">
                <span class="h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span class="text-xs font-semibold uppercase tracking-wide text-blue-200">
                    Perpustakaan Digital Universitas Metamedia
                </span>
            </div>
            <h1 class="text-5xl font-bold text-white md:text-6xl lg:text-7xl leading-tight">
                Jelajahi Pengetahuan Dalam Perpustakaan Digital Kami
            </h1>
            <p class="max-w-xl text-lg text-slate-300 leading-relaxed">
                Platform Perpustakaan Digital Yang Inovatif Untuk Mengakses Koleksi,Jurnal Dan Sumber Akademik
            </p>
        <div class="flex-1">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 shadow-2xl"
                data-slider>
                <!-- Slider content -->
                <div class="relative h-96 md:h-full">
                    <article
                        class="absolute inset-0 flex h-full flex-col justify-between bg-gradient-to-br from-blue-600/90 to-cyan-600/90 p-10 transition-all duration-500 ease-in-out"
                        data-slide>
                        <div class="space-y-4">
                            <div
                                class="inline-block rounded-lg bg-white/20 px-3 py-1 text-sm font-semibold text-white backdrop-blur">
                                📊 Dashboard</div>
                            <h2 class="text-3xl font-bold text-white">Dashboard Koleksi</h2>
                            <p class="text-base leading-relaxed text-blue-100">Visualisasi statistik koleksi, buku
                                terbaru, dan ringkasan kegiatan perpustakaan dalam satu layar yang informatif dan
                                elegan.</p>
                        </div>
                        <div
                            class="rounded-lg bg-white/10 backdrop-blur-md border border-white/20 p-5 text-sm text-blue-100">
                            <p class="font-semibold text-white">✨ Fitur Utama</p>
                            <p class="mt-2">Statistik real-time, buku favorit, dan agenda layanan untuk pengambilan
                                keputusan cepat.</p>
                        </div>
                    </article>
                    <article
                        class="absolute inset-0 flex h-full flex-col justify-between bg-gradient-to-br from-indigo-600/90 to-blue-600/90 p-10 opacity-0 transition-all duration-500 ease-in-out"
                        data-slide>
                        <div class="space-y-4">
                            <div
                                class="inline-block rounded-lg bg-white/20 px-3 py-1 text-sm font-semibold text-white backdrop-blur">
                                📚 Peminjaman</div>
                            <h2 class="text-3xl font-bold text-white">Sirkulasi Peminjaman</h2>
                            <p class="text-base leading-relaxed text-indigo-100">Kelola perpanjangan, pengingat
                                pengembalian, dan antrian peminjaman dengan antarmuka yang intuitif dan responsif.</p>
                        </div>
                        <div
                            class="rounded-lg bg-white/10 backdrop-blur-md border border-white/20 p-5 text-sm text-indigo-100">
                            <p class="font-semibold text-white">⚡ Otomasi</p>
                            <p class="mt-2">Pengingat otomatis dan notifikasi real-time untuk kemudahan pengelolaan.</p>
                        </div>
                    </article>
                    <article
                        class="absolute inset-0 flex h-full flex-col justify-between bg-gradient-to-br from-purple-600/90 to-indigo-600/90 p-10 opacity-0 transition-all duration-500 ease-in-out"
                        data-slide>
                        <div class="space-y-4">
                            <div
                                class="inline-block rounded-lg bg-white/20 px-3 py-1 text-sm font-semibold text-white backdrop-blur">
                                👤 Profil</div>
                            <h2 class="text-3xl font-bold text-white">Profil Anggota</h2>
                            <p class="text-base leading-relaxed text-purple-100">Riwayat peminjaman lengkap, kartu
                                anggota digital, dan rekomendasi literatur khusus untuk setiap pengguna.</p>
                        </div>
                        <div
                            class="rounded-lg bg-white/10 backdrop-blur-md border border-white/20 p-5 text-sm text-purple-100">
                            <p class="font-semibold text-white">🔒 Keamanan</p>
                            <p class="mt-2">Autentikasi modern dan manajemen akses berbasis peran pengguna.</p>
                        </div>
                    </article>
                </div>

                <!-- Navigation buttons -->
                <div class="absolute inset-0 z-10 flex items-center justify-between px-4 pointer-events-none">
                    <button type="button" aria-label="Slide sebelumnya" data-prev
                        class="pointer-events-auto rounded-full border border-white/30 bg-white/10 backdrop-blur-md p-2 text-white transition hover:bg-white/20 hover:border-white/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>
                    <button type="button" aria-label="Slide berikutnya" data-next
                        class="pointer-events-auto rounded-full border border-white/30 bg-white/10 backdrop-blur-md p-2 text-white transition hover:bg-white/20 hover:border-white/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Dots navigation -->
                <div class="absolute bottom-6 left-0 right-0 z-10 flex justify-center gap-2">
                    <button type="button" aria-label="Pilih slide 1" data-dot
                        class="h-2 w-2 rounded-full bg-white transition-all duration-300"></button>
                    <button type="button" aria-label="Pilih slide 2" data-dot
                        class="h-2 w-2 rounded-full bg-white/40 transition-all duration-300"></button>
                    <button type="button" aria-label="Pilih slide 3" data-dot
                        class="h-2 w-2 rounded-full bg-white/40 transition-all duration-300"></button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="relative bg-gradient-to-b from-slate-50 to-white py-20">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 right-0 h-96 w-96 rounded-full bg-blue-100/20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-6xl px-6">
        <div class="mb-16 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-4xl font-bold text-slate-900">Layanan Unggulan</h2>
                <p class="mt-3 text-lg text-slate-600">Fitur-fitur andalanyang dirancang untuk efisiensi maksimal</p>
            </div>
        </div>
        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card 1 -->
            <a href="{{ route('katalog') }}"
                class="group relative overflow-hidden rounded-2xl border border-blue-200/50 bg-gradient-to-br from-blue-50 to-cyan-50 p-8 shadow-lg transition hover:shadow-2xl hover:border-blue-400">
                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-blue-500/10 to-cyan-500/10">
                </div>
                <div class="relative">
                    <div
                        class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 text-2xl shadow-md">
                        📚
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Katalog Terpadu</h3>
                    <p class="mt-3 leading-relaxed text-slate-600">Koleksi terindeks dengan metadata lengkap dan
                        pencarian cerdas untuk menemukan literatur dengan mudah.</p>
                </div>
                <span
                    class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 group-hover:text-blue-700 transition">
                    Jelajahi katalog
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('admin.books.library.index') }}"
                class="group relative overflow-hidden rounded-2xl border border-indigo-200/50 bg-gradient-to-br from-indigo-50 to-blue-50 p-8 shadow-lg transition hover:shadow-2xl hover:border-indigo-400">
                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-indigo-500/10 to-blue-500/10">
                </div>
                <div class="relative">
                    <div
                        class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-blue-500 text-2xl shadow-md">
                        🗂️
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Koleksi & Peminjaman Perpustakaan</h3>
                    <p class="mt-3 leading-relaxed text-slate-600">Kelola daftar buku, tambahkan koleksi baru, dan
                        perbarui status ketersediaan dengan antarmuka yang ramah pengguna.</p>
                </div>
                <span
                    class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 group-hover:text-indigo-700 transition">
                    Kelola koleksi
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('ktm.index') }}"
                class="group relative overflow-hidden rounded-2xl border border-purple-200/50 bg-gradient-to-br from-purple-50 to-indigo-50 p-8 shadow-lg transition hover:shadow-2xl hover:border-purple-400">
                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-purple-500/10 to-indigo-500/10">
                </div>
                <div class="relative">
                    <div
                        class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 text-2xl shadow-md">
                        👥
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Kartu Anggota</h3>
                    <p class="mt-3 leading-relaxed text-slate-600">Member ID otomatis, status keanggotaan digital, dan
                        tracking keterlibatan untuk setiap pengguna.</p>
                </div>
                <span
                    class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-purple-600 group-hover:text-purple-700 transition">
                    Kelola anggota
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>

            <!-- Card 4 -->
            <a href="{{ url('/laporan') }}"
                class="group relative overflow-hidden rounded-2xl border border-orange-200/50 bg-gradient-to-br from-orange-50 to-red-50 p-8 shadow-lg transition hover:shadow-2xl hover:border-orange-400">
                <div
                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-orange-500/10 to-red-500/10">
                </div>
                <div class="relative">
                    <div
                        class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-500 text-2xl shadow-md">
                        📈
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Analitik Ringkas</h3>
                    <p class="mt-3 leading-relaxed text-slate-600">KPI perpustakaan, tren peminjaman, dan insight
                        performa dalam visualisasi yang dapat dicerna dengan mudah.</p>
                </div>
                <span
                    class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-orange-600 group-hover:text-orange-700 transition">
                    Lihat analitik
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
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
                dot.classList.toggle('bg-white/40', !isActive);
                dot.classList.toggle('w-2', !isActive);
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
            timer = setInterval(() => goTo(activeIndex + 1), 6000);
        };

        prevButton?.addEventListener('click', () => goTo(activeIndex - 1));
        nextButton?.addEventListener('click', () => goTo(activeIndex + 1));
        dots.forEach((dot, idx) => dot.addEventListener('click', () => goTo(idx)));

        updateSlides(0);
        restartTimer();
    });
</script>
@endsection