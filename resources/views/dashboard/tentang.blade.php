@extends('layouts.app')

@section('title', 'Tentang Perpustakaan')

@section('content')
<style>
    /* ========== KEYFRAME ANIMATIONS ========== */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes zoomIn {
        from { opacity: 0; transform: scale(0.85); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }

    @keyframes pulse-scale {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes countUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ========== ANIMATION CLASSES ========== */
    .animate-fadeUp {
        animation: fadeUp 0.9s ease-out forwards;
        opacity: 0;
    }

    .animate-zoomIn {
        animation: zoomIn 0.7s ease-out forwards;
        opacity: 0;
    }

    .animate-slideInLeft {
        animation: slideInLeft 0.8s ease-out forwards;
        opacity: 0;
    }

    .animate-slideInRight {
        animation: slideInRight 0.8s ease-out forwards;
        opacity: 0;
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .animate-pulse-scale {
        animation: pulse-scale 2s ease-in-out infinite;
    }

    .delay-1 { animation-delay: 0.3s; }
    .delay-2 { animation-delay: 0.6s; }
    .delay-3 { animation-delay: 0.9s; }
    .delay-4 { animation-delay: 1.2s; }

    /* ========== SCROLL REVEAL ========== */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .scroll-reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* ========== CARD HOVER EFFECT ========== */
    .card-hover {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card-hover::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .card-hover:hover::before {
        left: 100%;
    }

    /* ========== COUNTER ANIMATION ========== */
    .counter {
        font-size: 2.5rem;
        font-weight: bold;
        animation: countUp 0.8s ease-out forwards;
        opacity: 0;
    }

    /* Icon styles */
    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 30px;
    }
</style>

<div class="bg-white min-h-screen text-slate-700">

    <section class="relative pt-40 pb-24 text-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-50 via-blue-50 to-blue-100 -z-10"></div>
        
        <div class="absolute top-20 left-10 w-72 h-72 bg-sky-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        
        <div class="max-w-4xl mx-auto px-6 animate-fadeUp">
            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4 animate-zoomIn">
                ℹ️ Tentang Kami
            </span>
            <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-blue-900 via-blue-700 to-sky-600 bg-clip-text text-transparent mb-6 animate-slideInLeft">
                Perpustakaan Digital Kami
            </h1>
            <p class="text-xl text-slate-600 leading-relaxed animate-slideInRight delay-1">
                Pusat Pembelajaran dan Penelitian Terdepan untuk Civitas Akademika Universitas Metamedia
            </p>
        </div>
    </section>

    <section class="px-6 py-16 bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="scroll-reveal">
                    <h2 class="text-4xl font-bold mb-6 text-slate-900">
                        Misi Kami
                    </h2>
                    <p class="text-lg text-slate-600 mb-4 leading-relaxed">
                        Perpustakaan Digital Universitas Metamedia berkomitmen untuk menyediakan akses informasi yang komprehensif, inovatif, dan mudah diakses untuk mendukung kegiatan akademik, penelitian, dan pengembangan sumber daya manusia.
                    </p>
                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        Kami menyediakan koleksi lengkap buku, jurnal elektronik, database penelitian, dan berbagai sumber daya digital lainnya yang dikurasi khusus untuk memenuhi kebutuhan akademik di era digital.
                    </p>
                    <div class="flex gap-4">
                        <div class="flex items-start gap-3">
                            <div class="text-2xl">📚</div>
                            <div>
                                <h4 class="font-bold text-slate-900">Koleksi Lengkap</h4>
                                <p class="text-sm text-slate-600">Ribuan judul buku & jurnal</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="text-2xl">⚡</div>
                            <div>
                                <h4 class="font-bold text-slate-900">Akses Digital</h4>
                                <p class="text-sm text-slate-600">24/7 dari mana saja</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="scroll-reveal" style="animation-delay: 0.2s;">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-sky-400 rounded-3xl transform rotate-6"></div>
                        <div class="relative bg-white rounded-3xl p-8 shadow-2xl transform hover:-rotate-2 transition-transform">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-blue-50 rounded-2xl p-4 text-center hover:bg-blue-100 transition-colors">
                                    <div class="text-3xl mb-2">📖</div>
                                    <p class="text-xs font-semibold text-slate-700">Buku Cetak</p>
                                </div>
                                <div class="bg-sky-50 rounded-2xl p-4 text-center hover:bg-sky-100 transition-colors">
                                    <div class="text-3xl mb-2">💻</div>
                                    <p class="text-xs font-semibold text-slate-700">E-Book</p>
                                </div>
                                <div class="bg-blue-50 rounded-2xl p-4 text-center hover:bg-blue-100 transition-colors">
                                    <div class="text-3xl mb-2">📰</div>
                                    <p class="text-xs font-semibold text-slate-700">E-Journal</p>
                                </div>
                                <div class="bg-sky-50 rounded-2xl p-4 text-center hover:bg-sky-100 transition-colors">
                                    <div class="text-3xl mb-2">🎓</div>
                                    <p class="text-xs font-semibold text-slate-700">Tesis</p>
                                </div>
                                <div class="bg-blue-50 rounded-2xl p-4 text-center hover:bg-blue-100 transition-colors">
                                    <div class="text-3xl mb-2">📊</div>
                                    <p class="text-xs font-semibold text-slate-700">Database</p>
                                </div>
                                <div class="bg-sky-50 rounded-2xl p-4 text-center hover:bg-sky-100 transition-colors">
                                    <div class="text-3xl mb-2">🎬</div>
                                    <p class="text-xs font-semibold text-slate-700">Multimedia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-gradient-to-r from-blue-700 to-blue-600">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-white mb-16 animate-fadeUp">
                Statistik Perpustakaan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="scroll-reveal bg-white/10 backdrop-blur-md rounded-2xl p-8 text-center border border-white/20 hover:bg-white/20 transition-all">
                    <div class="counter text-white mb-2">15K+</div>
                    <h4 class="text-white font-semibold text-lg">Koleksi Buku</h4>
                    <p class="text-blue-100 text-sm mt-2">Buku fisik di perpustakaan</p>
                </div>

                <div class="scroll-reveal bg-white/10 backdrop-blur-md rounded-2xl p-8 text-center border border-white/20 hover:bg-white/20 transition-all" style="animation-delay: 0.2s;">
                    <div class="counter text-white mb-2">5K+</div>
                    <h4 class="text-white font-semibold text-lg">E-Book & E-Journal</h4>
                    <p class="text-blue-100 text-sm mt-2">Koleksi digital tersedia</p>
                </div>

                <div class="scroll-reveal bg-white/10 backdrop-blur-md rounded-2xl p-8 text-center border border-white/20 hover:bg-white/20 transition-all" style="animation-delay: 0.4s;">
                    <div class="counter text-white mb-2">8K+</div>
                    <h4 class="text-white font-semibold text-lg">Anggota Aktif</h4>
                    <p class="text-blue-100 text-sm mt-2">Civitas akademika kami</p>
                </div>

                <div class="scroll-reveal bg-white/10 backdrop-blur-md rounded-2xl p-8 text-center border border-white/20 hover:bg-white/20 transition-all" style="animation-delay: 0.6s;">
                    <div class="counter text-white mb-2">50K+</div>
                    <h4 class="text-white font-semibold text-lg">Peminjaman/Tahun</h4>
                    <p class="text-blue-100 text-sm mt-2">Transaksi berhasil</p>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-slate-50">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16 animate-fadeUp">
                <span class="bg-gradient-to-r from-blue-700 to-sky-600 bg-clip-text text-transparent">Layanan Kami</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="scroll-reveal group">
                    <div class="card-hover bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="icon-box bg-blue-50 text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                            📚
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Koleksi Buku</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Koleksi buku cetak terlengkap dari berbagai bidang ilmu pengetahuan dengan pembaruan berkala.</p>
                    </div>
                </div>

                <div class="scroll-reveal group" style="animation-delay: 0.2s;">
                    <div class="card-hover bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="icon-box bg-sky-50 text-sky-600 mb-4 group-hover:scale-110 transition-transform">
                            💻
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">E-Book & E-Journal</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Akses ribuan buku dan jurnal elektronik dari database internasional terkemuka.</p>
                    </div>
                </div>

                <div class="scroll-reveal group" style="animation-delay: 0.4s;">
                    <div class="card-hover bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="icon-box bg-blue-50 text-blue-500 mb-4 group-hover:scale-110 transition-transform">
                            🔍
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Referensi Penelitian</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Panduan dan dukungan dalam menemukan sumber referensi untuk penelitian akademik.</p>
                    </div>
                </div>

                <div class="scroll-reveal group" style="animation-delay: 0.6s;">
                    <div class="card-hover bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="icon-box bg-sky-50 text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                            🎓
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Ruang Baca & Belajar</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Ruang nyaman dilengkapi fasilitas modern untuk membaca, belajar, dan penelitian.</p>
                    </div>
                </div>

                <div class="scroll-reveal group" style="animation-delay: 0.8s;">
                    <div class="card-hover bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="icon-box bg-blue-50 text-sky-600 mb-4 group-hover:scale-110 transition-transform">
                            🔖
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Layanan Peminjaman</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Sistem peminjaman yang mudah dan fleksibel dengan durasi yang dapat disesuaikan.</p>
                    </div>
                </div>

                <div class="scroll-reveal group" style="animation-delay: 1s;">
                    <div class="card-hover bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="icon-box bg-sky-50 text-blue-500 mb-4 group-hover:scale-110 transition-transform">
                            💬
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Konsultasi Librarian</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Tim profesional siap membantu Anda menemukan informasi yang dibutuhkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-20 bg-slate-50">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16 animate-fadeUp">
                <span class="bg-gradient-to-r from-blue-700 to-sky-600 bg-clip-text text-transparent">Fasilitas & Keunggulan</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="scroll-reveal space-y-4">
                    <div class="flex gap-4 p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                        <div class="text-3xl flex-shrink-0 text-blue-600">🌐</div>
                        <div>
                            <h4 class="font-bold text-slate-900">Akses Digital 24/7</h4>
                            <p class="text-sm text-slate-600">Akses e-resources dari mana saja kapan saja</p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                        <div class="text-3xl flex-shrink-0 text-blue-600">⚙️</div>
                        <div>
                            <h4 class="font-bold text-slate-900">Sistem Manajemen Modern</h4>
                            <p class="text-sm text-slate-600">Aplikasi perpustakaan terintegrasi dan user-friendly</p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                        <div class="text-3xl flex-shrink-0 text-blue-600">🎯</div>
                        <div>
                            <h4 class="font-bold text-slate-900">Pengelompokan Terstruktur</h4>
                            <p class="text-sm text-slate-600">Koleksi tersusun sistematis sesuai Dewey Decimal</p>
                        </div>
                    </div>
                </div>

                <div class="scroll-reveal space-y-4" style="animation-delay: 0.2s;">
                    <div class="flex gap-4 p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                        <div class="text-3xl flex-shrink-0 text-blue-600">📖</div>
                        <div>
                            <h4 class="font-bold text-slate-900">Literasi Digital</h4>
                            <p class="text-sm text-slate-600">Program pelatihan penggunaan database akademik</p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                        <div class="text-3xl flex-shrink-0 text-blue-600">👥</div>
                        <div>
                            <h4 class="font-bold text-slate-900">Tim Profesional</h4>
                            <p class="text-sm text-slate-600">Librarian berpengalaman siap membantu Anda</p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                        <div class="text-3xl flex-shrink-0 text-blue-600">🏆</div>
                        <div>
                            <h4 class="font-bold text-slate-900">Standar Internasional</h4>
                            <p class="text-sm text-slate-600">Layanan bersertifikat dan terakreditasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative px-6 py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-sky-600 -z-10"></div>
        
        <div class="absolute top-10 right-10 w-40 h-40 bg-white rounded-full opacity-10 animate-float"></div>
        <div class="absolute bottom-10 left-10 w-32 h-32 bg-white rounded-full opacity-10 animate-float" style="animation-delay: 2s;"></div>
        
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-4xl font-bold text-white mb-4 animate-slideInLeft">
                Siap Bergabung?
            </h2>
            <p class="text-blue-50 mb-8 text-xl animate-slideInRight delay-1">
                Daftarkan diri Anda dan nikmati semua layanan perpustakaan kami
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-blue-700 font-bold rounded-2xl hover:bg-sky-50 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 animate-bounce delay-2">
                    <span class="flex items-center justify-center gap-2">
                        ✍️ Daftar Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </a>
                <a href="/" class="inline-block px-8 py-4 border-2 border-white text-white font-bold rounded-2xl hover:bg-white/10 transition-all">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>

</div>

<script>
    // Intersection Observer untuk scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all scroll-reveal elements
    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });

    // Counter animation for statistics
    document.querySelectorAll('.counter').forEach(counter => {
        const target = counter.textContent;
        const number = parseInt(target.replace(/\D/g, ''));
        const suffix = target.replace(/[0-9]/g, '');
        const duration = 2000;
        const increment = number / (duration / 16);
        let current = 0;

        const animateCounter = setInterval(() => {
            current += increment;
            if (current >= number) {
                counter.textContent = number + suffix;
                clearInterval(animateCounter);
            } else {
                counter.textContent = Math.floor(current) + '+';
            }
        }, 16);
    });
</script>

@endsection