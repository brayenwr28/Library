@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <section class="bg-slate-50">
        <div class="mx-auto flex max-w-6xl flex-col gap-12 px-6 py-16 md:flex-row md:items-center">
            <div class="flex-1 space-y-6">
                <span
                    class="inline-flex items-center rounded-full bg-white px-4 py-1 text-xs font-semibold uppercase tracking-wide text-slate-500 shadow-sm">
                    Perpustakaan Digital Universitas Metamedia
                </span>
                <h1 class="text-4xl font-semibold text-slate-900 md:text-5xl">
                    Temukan literatur dan kelola layanan akademik dalam satu ruang yang tenang.
                </h1>
                <p class="max-w-xl text-base text-slate-600">
                    Platform kami menyederhanakan pencarian koleksi, peminjaman, dan pemantauan aktivitas anggota agar tim
                    perpustakaan dapat fokus pada pendampingan akademik.
                </p>
            </div>
            <div class="flex-1">
                <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl" data-slider>
                    <div class="absolute inset-0 z-10 flex items-center justify-between px-4">
                        <button type="button" aria-label="Slide sebelumnya" data-prev
                            class="rounded-full border border-slate-200 bg-white/80 p-2 text-slate-500 transition hover:text-slate-900">&larr;</button>
                        <button type="button" aria-label="Slide berikutnya" data-next
                            class="rounded-full border border-slate-200 bg-white/80 p-2 text-slate-500 transition hover:text-slate-900">&rarr;</button>
                    </div>
                    <div class="relative h-80">
                        <article
                            class="absolute inset-0 flex h-full flex-col justify-between p-10 transition-opacity duration-500 ease-in-out"
                            data-slide>
                            <div class="space-y-4">
                                <h2 class="text-2xl font-semibold text-slate-900">Dashboard Koleksi</h2>
                                <p class="text-sm leading-relaxed text-slate-600">Statistik ringkas, buku baru, dan agenda
                                    layanan didesain untuk pengambilan keputusan cepat.</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-600">
                                <p class="font-medium text-slate-800">Sorotan</p>
                                <p class="mt-2">Visualisasi sederhana mendukung tindak lanjut petugas tanpa memenuhi layar
                                    dengan warna mencolok.</p>
                            </div>
                        </article>
                        <article
                            class="absolute inset-0 flex h-full flex-col justify-between p-10 opacity-0 transition-opacity duration-500 ease-in-out"
                            data-slide>
                            <div class="space-y-4">
                                <h2 class="text-2xl font-semibold text-slate-900">Sirkulasi Peminjaman</h2>
                                <p class="text-sm leading-relaxed text-slate-600">Kelola antrian, perpanjangan, dan
                                    pengingat pengembalian melalui antarmuka yang konsisten.</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-600">
                                <p class="font-medium text-slate-800">Automasi</p>
                                <p class="mt-2">Pengingat jadwal dan status real-time menjaga anggota selalu terinformasi.
                                </p>
                            </div>
                        </article>
                        <article
                            class="absolute inset-0 flex h-full flex-col justify-between p-10 opacity-0 transition-opacity duration-500 ease-in-out"
                            data-slide>
                            <div class="space-y-4">
                                <h2 class="text-2xl font-semibold text-slate-900">Profil Anggota</h2>
                                <p class="text-sm leading-relaxed text-slate-600">Riwayat pinjam, kartu anggota digital, dan
                                    rekomendasi literatur tersaji dalam panel rapi.</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-600">
                                <p class="font-medium text-slate-800">Keamanan</p>
                                <p class="mt-2">Autentikasi modern serta pengelolaan hak akses berbasis peran.</p>
                            </div>
                        </article>
                    </div>
                    <div class="relative z-10 flex justify-center gap-2 pb-6">
                        <button type="button" aria-label="Pilih slide 1" data-dot
                            class="h-2 w-8 rounded-full bg-slate-900 transition"></button>
                        <button type="button" aria-label="Pilih slide 2" data-dot
                            class="h-2 w-8 rounded-full bg-slate-200 transition"></button>
                        <button type="button" aria-label="Pilih slide 3" data-dot
                            class="h-2 w-8 rounded-full bg-slate-200 transition"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto max-w-6xl px-6 pb-20">
            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Layanan Unggulan</h2>
                    <p class="text-sm text-slate-500">Fondasi operasional perpustakaan dengan visual yang bersih dan fokus.
                    </p>
                </div>
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-slate-600 underline-offset-4 hover:text-slate-900 hover:underline">
                    Masuk untuk melihat detail
                </a>
            </div>
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                 <a href="{{ route('katalog') }}"
                    class="group flex flex-col gap-4 rounded-2xl border border-slate-200 bg-slate-50/70 p-6 shadow-sm transition hover:border-slate-300 hover:bg-white">
                    <div
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white text-lg text-slate-700 shadow-inner">
                        📚</div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Katalog Terpadu</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">Koleksi terindeks dengan metadata rapi dan
                            filter cerdas untuk pencarian cepat.</p>
                    </div>
                    <span class="text-sm font-medium text-slate-500 transition group-hover:text-slate-700">Selengkapnya
                        &rarr;</span>
                </a>
                <a href="{{ route('Bukuperpus.index') }}"
                    class="group flex flex-col gap-4 rounded-2xl border border-slate-200 bg-slate-50/70 p-6 shadow-sm transition hover:border-slate-300 hover:bg-white">
                    <div
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white text-lg text-slate-700 shadow-inner">
                        🗂️</div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Koleksi Perpustakaan</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">Lihat daftar buku yang tersedia dan tambahkan koleksi baru dengan mengisi detail pentingnya.</p>
                    </div>
                    <span class="text-sm font-medium text-slate-500 transition group-hover:text-slate-700">Kelola koleksi
                        &rarr;</span>
                </a>
                <a href=""
                    class="group flex flex-col gap-4 rounded-2xl border border-slate-200 bg-slate-50/70 p-6 shadow-sm transition hover:border-slate-300 hover:bg-white">
                    <div
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white text-lg text-slate-700 shadow-inner">
                        👥</div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Manajemen Anggota</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">Member ID otomatis, status keanggotaan, dan
                            insight keterlibatan belajar.</p>
                    </div>
                    <span class="text-sm font-medium text-slate-500 transition group-hover:text-slate-700">Kelola anggota
                        &rarr;</span>
                </a>
                <a href="{{ url('/laporan') }}"
                    class="group flex flex-col gap-4 rounded-2xl border border-slate-200 bg-slate-50/70 p-6 shadow-sm transition hover:border-slate-300 hover:bg-white">
                    <div
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white text-lg text-slate-700 shadow-inner">
                        📈</div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Analitik Ringkas</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">Indikator performa utama disajikan sederhana
                            untuk mendukung keputusan cepat.</p>
                    </div>
                    <span class="text-sm font-medium text-slate-500 transition group-hover:text-slate-700">Lihat ringkasan
                        &rarr;</span>
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
                    slide.style.opacity = idx === index ? '1' : '0';
                    slide.style.pointerEvents = idx === index ? 'auto' : 'none';
                });
                dots.forEach((dot, idx) => {
                    dot.classList.toggle('bg-slate-900', idx === index);
                    dot.classList.toggle('bg-slate-200', idx !== index);
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