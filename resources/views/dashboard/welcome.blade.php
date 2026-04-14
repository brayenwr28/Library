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
        0%, 100% {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
        50% {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.8);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes float-slow {
        0%, 100% {
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
        0%, 100% {
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

    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-400 { animation-delay: 400ms; }
    .delay-500 { animation-delay: 500ms; }
    .delay-600 { animation-delay: 600ms; }

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

<section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 pb-20">
    <!-- Animated background decoration -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-gradient-to-br from-blue-500/20 to-cyan-500/10 blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-gradient-to-tr from-indigo-500/20 to-blue-500/10 blur-3xl animate-float-slow" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-96 w-96 rounded-full bg-gradient-to-br from-purple-500/10 to-pink-500/5 blur-3xl animate-float" style="animation-delay: 2s;"></div>
        
        <!-- Floating accent shapes -->
        <div class="absolute top-20 left-20 w-32 h-32 rounded-full border border-blue-400/20 animate-rotate-slow"></div>
        <div class="absolute bottom-32 right-32 w-40 h-40 rounded-full border border-cyan-400/20 animate-rotate-slow" style="animation-direction: reverse;"></div>
    </div>

    <div class="relative mx-auto flex max-w-6xl flex-col gap-12 px-6 py-20 md:flex-row md:items-center">
        <div class="flex-1 space-y-8">
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-500/50 bg-gradient-to-r from-blue-500/20 to-cyan-500/20 px-4 py-2.5 backdrop-blur-sm animate-fade-in-up hover:border-blue-400/80 transition-all">
                <span class="h-2.5 w-2.5 rounded-full bg-blue-400 animate-pulse-glow"></span>
                <span class="text-xs font-semibold uppercase tracking-widest text-blue-100">
                    ✨ Perpustakaan Digital Universitas Metamedia
                </span>
            </div>
            
            <div class="space-y-6">
                <h1 class="text-5xl font-bold text-white md:text-6xl lg:text-7xl leading-tight animate-fade-in-up delay-100">
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
                
                <p class="max-w-xl text-lg text-slate-300 leading-relaxed animate-fade-in-up delay-200">
                    Platform Perpustakaan Digital Yang Inovatif Untuk Mengakses Koleksi, Jurnal, Dan Sumber Akademik Dengan Mudah Dan Efisien
                </p>
            </div>

            <div class="flex gap-4 animate-fade-in-up delay-300">
                <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold hover:shadow-lg hover:shadow-blue-500/50 transition-all hover:-translate-y-0.5">
                    <span>Jelajahi Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="{{ url('/laporan') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg border border-blue-400/50 bg-blue-500/10 backdrop-blur text-blue-100 font-semibold hover:bg-blue-500/20 hover:border-blue-300 transition-all hover:-translate-y-0.5">
                    <span>📊 Lihat Statistik</span>
                </a>
            </div>
        </div>
        <div class="flex-1">
            <div class="relative overflow-hidden rounded-2xl shadow-2xl animate-slide-in-right group" data-slider>
                <!-- Premium gradient backdrop -->
                <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-900"></div>
                
                <!-- Slider content -->
                <div class="relative h-96 md:h-full">
                    <article
                        class="absolute inset-0 flex h-full flex-col justify-between bg-gradient-to-br from-blue-600/95 via-blue-700/90 to-cyan-600/95 p-10 transition-all duration-700 ease-in-out"
                        data-slide>
                        <div class="space-y-4">
                            <div class="inline-block rounded-lg bg-white/20 px-3 py-1 text-sm font-semibold text-white backdrop-blur">
                                📊 Dashboard
                            </div>
                            <h2 class="text-3xl font-bold text-white leading-snug">Dashboard Koleksi</h2>
                            <p class="text-base leading-relaxed text-blue-50">Visualisasi statistik koleksi, buku terbaru, dan ringkasan kegiatan perpustakaan dalam satu layar yang informatif dan elegan.</p>
                        </div>
                        <div class="rounded-lg bg-white/15 backdrop-blur-md border border-white/30 p-5 text-sm text-blue-50 hover:bg-white/25 transition-all">
                            <p class="font-semibold text-white">✨ Fitur Utama</p>
                            <p class="mt-2">Statistik real-time, buku favorit, dan agenda layanan untuk pengambilan keputusan cepat.</p>
                        </div>
                    </article>
                    
                    <article
                        class="absolute inset-0 flex h-full flex-col justify-between bg-gradient-to-br from-indigo-600/95 via-indigo-700/90 to-blue-600/95 p-10 opacity-0 transition-all duration-700 ease-in-out"
                        data-slide>
                        <div class="space-y-4">
                            <div class="inline-block rounded-lg bg-white/20 px-3 py-1 text-sm font-semibold text-white backdrop-blur">
                                📚 Peminjaman
                            </div>
                            <h2 class="text-3xl font-bold text-white leading-snug">Sirkulasi Peminjaman</h2>
                            <p class="text-base leading-relaxed text-indigo-50">Kelola perpanjangan, pengingat pengembalian, dan antrian peminjaman dengan antarmuka yang intuitif dan responsif.</p>
                        </div>
                        <div class="rounded-lg bg-white/15 backdrop-blur-md border border-white/30 p-5 text-sm text-indigo-50 hover:bg-white/25 transition-all">
                            <p class="font-semibold text-white">⚡ Otomasi</p>
                            <p class="mt-2">Pengingat otomatis dan notifikasi real-time untuk kemudahan pengelolaan.</p>
                        </div>
                    </article>
                    
                    <article
                        class="absolute inset-0 flex h-full flex-col justify-between bg-gradient-to-br from-purple-600/95 via-purple-700/90 to-indigo-600/95 p-10 opacity-0 transition-all duration-700 ease-in-out"
                        data-slide>
                        <div class="space-y-4">
                            <div class="inline-block rounded-lg bg-white/20 px-3 py-1 text-sm font-semibold text-white backdrop-blur">
                                👤 Profil
                            </div>
                            <h2 class="text-3xl font-bold text-white leading-snug">Profil Anggota</h2>
                            <p class="text-base leading-relaxed text-purple-50">Riwayat peminjaman lengkap, kartu anggota digital, dan rekomendasi literatur khusus untuk setiap pengguna.</p>
                        </div>
                        <div class="rounded-lg bg-white/15 backdrop-blur-md border border-white/30 p-5 text-sm text-purple-50 hover:bg-white/25 transition-all">
                            <p class="font-semibold text-white">🔒 Keamanan</p>
                            <p class="mt-2">Autentikasi modern dan manajemen akses berbasis peran pengguna.</p>
                        </div>
                    </article>
                </div>

                <!-- Navigation buttons -->
                <div class="absolute inset-0 z-10 flex items-center justify-between px-4 pointer-events-none">
                    <button type="button" aria-label="Slide sebelumnya" data-prev
                        class="pointer-events-auto rounded-full border border-white/40 bg-white/15 backdrop-blur-md p-3 text-white transition-all hover:bg-white/30 hover:border-white/70 hover:scale-125 duration-200 shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button type="button" aria-label="Slide berikutnya" data-next
                        class="pointer-events-auto rounded-full border border-white/40 bg-white/15 backdrop-blur-md p-3 text-white transition-all hover:bg-white/30 hover:border-white/70 hover:scale-125 duration-200 shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Dots navigation -->
                <div class="absolute bottom-6 left-0 right-0 z-10 flex justify-center gap-3">
                    <button type="button" aria-label="Pilih slide 1" data-dot
                        class="h-2.5 w-2.5 rounded-full bg-white shadow-lg transition-all duration-300 hover:bg-white/90 focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-offset-2 focus:ring-offset-transparent"></button>
                    <button type="button" aria-label="Pilih slide 2" data-dot
                        class="h-2.5 w-2.5 rounded-full bg-white/50 shadow-md transition-all duration-300 hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-offset-2 focus:ring-offset-transparent"></button>
                    <button type="button" aria-label="Pilih slide 3" data-dot
                        class="h-2.5 w-2.5 rounded-full bg-white/50 shadow-md transition-all duration-300 hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-offset-2 focus:ring-offset-transparent"></button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="relative bg-gradient-to-b from-slate-50 via-white to-slate-50 py-24 overflow-hidden">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 right-0 h-96 w-96 rounded-full bg-blue-100/40 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 h-96 w-96 rounded-full bg-indigo-100/30 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/4 h-80 w-80 rounded-full bg-purple-100/20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-6xl px-6">
        <div class="mb-20 text-center space-y-4 animate-fade-in-up">
            <div class="inline-flex items-center justify-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                <span class="text-sm font-semibold text-blue-700">Fitur Utama</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900">
                Layanan Unggulan Kami
            </h2>
            <p class="max-w-2xl mx-auto text-lg text-slate-600">
                Fitur-fitur inovatif yang dirancang khusus untuk memberikan pengalaman perpustakaan digital terbaik
            </p>
        </div>
        
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card 1 -->
            <a href="{{ route('katalog') }}"
                class="group relative h-full overflow-hidden rounded-2xl border border-blue-200/60 bg-gradient-to-br from-blue-50 via-white to-cyan-50 p-8 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-in-up delay-100">
                
                <!-- Badge -->
                <div class="absolute top-0 right-0 px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs font-bold rounded-bl-lg">
                    Populer
                </div>
                
                <!-- Background effect -->
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-blue-500/5 to-cyan-500/5"></div>
                
                <div class="relative space-y-4">
                    <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 text-3xl shadow-lg group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                        📚
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 leading-tight">Katalog Digital</h3>
                    <p class="leading-relaxed text-slate-600">Koleksi Digital dengan metadata lengkap dan pencarian cerdas.</p>
                </div>
                
                <div class="relative mt-8 pt-6 border-t border-blue-200/50">
                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 group-hover:text-blue-700 transition">
                        Jelajahi katalog
                        <svg class="w-4 h-4 group-hover:translate-x-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('admin.books.library.index') }}"
                class="group relative h-full overflow-hidden rounded-2xl border border-indigo-200/60 bg-gradient-to-br from-indigo-50 via-white to-blue-50 p-8 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-in-up delay-200">
                
                <!-- Badge -->
                <div class="absolute top-0 right-0 px-4 py-2 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-xs font-bold rounded-bl-lg">
                    Pro
                </div>
                
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-indigo-500/5 to-blue-500/5"></div>
                
                <div class="relative space-y-4">
                    <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-blue-500 text-3xl shadow-lg group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                        🗂️
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 leading-tight">Koleksi Perpustakaan</h3>
                    <p class="leading-relaxed text-slate-600">daftar buku, koleksi baru, dan pe ketersediaan dengan mudah.</p>
                </div>
                
                <div class="relative mt-8 pt-6 border-t border-indigo-200/50">
                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 group-hover:text-indigo-700 transition">
                        Kelola koleksi
                        <svg class="w-4 h-4 group-hover:translate-x-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('ktm.index') }}"
                class="group relative h-full overflow-hidden rounded-2xl border border-purple-200/60 bg-gradient-to-br from-purple-50 via-white to-indigo-50 p-8 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-in-up delay-300">
                
                <!-- Badge -->
                <div class="absolute top-0 right-0 px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-500 text-white text-xs font-bold rounded-bl-lg">
                    Baru
                </div>
                
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-purple-500/5 to-indigo-500/5"></div>
                
                <div class="relative space-y-4">
                    <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 text-3xl shadow-lg group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                        👥
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 leading-tight">Kartu Anggota</h3>
                    <p class="leading-relaxed text-slate-600">Member Perpustakaan Metamedia, status keanggotaan digital</p>
                </div>
                
                <div class="relative mt-8 pt-6 border-t border-purple-200/50">
                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-purple-600 group-hover:text-purple-700 transition">
                        Kelola anggota
                        <svg class="w-4 h-4 group-hover:translate-x-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="{{ url('/laporan') }}"
                class="group relative h-full overflow-hidden rounded-2xl border border-orange-200/60 bg-gradient-to-br from-orange-50 via-white to-red-50 p-8 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-in-up delay-400">
                
                <!-- Badge -->
                <div class="absolute top-0 right-0 px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-bl-lg">
                    Insight
                </div>
                
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-orange-500/5 to-red-500/5"></div>
                
                <div class="relative space-y-4">
                    <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-red-500 text-3xl shadow-lg group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                        📈
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 leading-tight">Analitik Ringkas</h3>
                    <p class="leading-relaxed text-slate-600">Laporan perpustakaan, tren peminjaman, dan insight performa dalam visualisasi yang mudah dipahami.</p>
                </div>
                
                <div class="relative mt-8 pt-6 border-t border-orange-200/50">
                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-orange-600 group-hover:text-orange-700 transition">
                        Lihat analitik
                        <svg class="w-4 h-4 group-hover:translate-x-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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