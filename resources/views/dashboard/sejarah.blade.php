@extends('layouts.app')

@section('title', 'Sejarah Perpustakaan')

@section('content')
@php
    // Ubah file musik di sini: public/audio/Soft Background Music for Presentation, Speech and Events.mp3
    $historyMusicFile = 'Soft Background Music for Presentation, Speech and Events.mp3';
    $historyMusic = asset('audio/' . rawurlencode($historyMusicFile));
@endphp

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
        50% { transform: translateY(-20px); }
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
        50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); }
    }

    @keyframes slide-up-fade {
        from { opacity: 0; transform: translateY(60px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
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

    .animate-pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }

    .animate-slide-up-fade {
        animation: slide-up-fade 0.8s ease-out forwards;
        opacity: 0;
    }

    .delay-1 { animation-delay: 0.3s; }
    .delay-2 { animation-delay: 0.6s; }
    .delay-3 { animation-delay: 0.9s; }
    .delay-4 { animation-delay: 1.2s; }

    /* ========== PARALLAX EFFECT ========== */
    .parallax-img {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    /* ========== GRADIENT ANIMATIONS ========== */
    .gradient-animation {
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

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

    /* ========== BORDER ANIMATION ========== */
    .border-gradient {
        position: relative;
        background: white;
        border-radius: 1rem;
    }

    .border-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, #3b82f6, #06b6d4, #3b82f6);
        border-radius: 1rem;
        padding: 2px;
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        opacity: 0;
        animation: borderGlow 3s ease-in-out infinite;
    }

    @keyframes borderGlow {
        0%, 100% { opacity: 0; }
        50% { opacity: 1; }
    }
</style>

<div class="bg-white min-h-screen text-slate-700">

<!-- ================= HISTORY MUSIC PLAYER ================= -->
<button type="button" id="history-music-fallback" class="hidden fixed bottom-4 right-4 z-50 rounded-full bg-slate-900/90 px-4 py-3 text-xs font-semibold text-white shadow-xl backdrop-blur hover:bg-slate-800 transition">
    Klik untuk aktifkan musik sejarah
</button>

<audio id="history-music" preload="auto" loop autoplay>
    <source src="{{ $historyMusic }}" type="audio/mpeg">
</audio>

<!-- ================= HERO HEADER ================= -->
<section class="relative pt-40 pb-24 text-center overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 -z-10"></div>
    
    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
    <div class="absolute top-40 right-10 w-72 h-72 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 4s;"></div>
    
    <div class="max-w-4xl mx-auto px-6 animate-fadeUp">
        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4 animate-zoomIn">
            📚 Sejarah Perpustakaan
        </span>
        <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-slate-900 via-blue-700 to-slate-900 bg-clip-text text-transparent mb-6 animate-slideInLeft">
            Perjalanan Transformasi Digital
        </h1>
        <p class="text-xl text-slate-500 leading-relaxed animate-slideInRight delay-1">
            Menjadi Pusat Informasi Digital yang Melayani Seluruh Civitas Akademika
        </p>
    </div>
</section>

<script>
    (function () {
        const audio = document.getElementById('history-music');
        const fallback = document.getElementById('history-music-fallback');

        if (!audio || !fallback) return;

        audio.volume = 0.25;

        const attemptPlay = async () => {
            try {
                await audio.play();
                fallback.classList.add('hidden');
            } catch (error) {
                fallback.classList.remove('hidden');
            }
        };

        fallback.addEventListener('click', async () => {
            await attemptPlay();
        });

        document.addEventListener('DOMContentLoaded', attemptPlay);
        window.addEventListener('load', attemptPlay);
    })();
</script>

<!-- ================= HISTORY IMAGE WITH PARALLAX ================= -->
<section class="relative w-full overflow-hidden h-96 md:h-[500px]">
    <div class="parallax-img absolute inset-0" style="background-image: url('/images/sejarah-top.jpg'); background-position: center; background-size: cover;">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-white"></div>
    </div>
    <!-- Animated overlay bars -->
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-white to-transparent"></div>
    </div>
</section>

<!-- ================= HISTORY DETAIL (TEKS) ================= -->
<section class="px-6 py-16 bg-white relative">
    <!-- Background decoration -->
    <div class="absolute left-0 top-1/4 w-96 h-96 bg-blue-50 rounded-full filter blur-3xl opacity-30 -z-10"></div>
    
    <div class="max-w-5xl mx-auto">
        <div class="text-slate-700 leading-relaxed text-justify space-y-6">
            <p class="scroll-reveal text-lg">
                Perguruan Tinggi ini berdiri berdasarkan Keputusan Yayasan Dharma Bhakti Selecta tanggal 4 Juni 1986 No:001/Ist/YDBS/SK/VI/1986, maka didirikan Akademi Informatika Komputer (AIK) di Padang. Pada tanggal 18 Juni 1990 terjadi perubahan kepemilikan yayasan dan perubahan azas menjadi berazazkan Islam. Oleh karena azas pendiriannya berbeda, maka tanggal 15 Maret 1995 dilakukan perubahan nama yayasan dari Yayasan Dharma Bhakti Selecta menjadi Yayasan Amal Bakti Mukmin Indonesia (ALBANI) dengan Akta No. 77 Notaris Zamri, SH tanggal 15 Maret 1995 dan telah mendapat persetujuan dari Dirjen DIKTI No. 502/DIKTI/Kep/1996 tanggal 22 Oktober 1996. Pada tanggal 29 April 2011, nama Yayasan Amal Bakti Mukmin Indonesia (ALBANI) diganti menjadi Yayasan Amal Bakti Mukmin Padang dengan akta notaris Ujang Iskandar, SE, SH, M.Kn, No. 80 tanggal 29 April 2011. Hal ini diperkuat dengan Keputusan Menteri Hukum dan Hak Azazi Manusia Republik Indonesia No. AHU-288.AH0104 tahun 2012, tanggal 26 Januari 2012.
            </p>

            <p class="scroll-reveal text-lg" style="animation-delay: 0.2s;">
                Berdasarkan Surat Keputusan Menteri Pendidikan Republik Indonesia Nomor: 0682/O/1990 tanggal 13 November 1990 tentang Status Terdaftar Program Diploma III, Akademi Informatika Komputer (AIK) berubah nama menjadi Akademi Manajemen Informatika dan Komputer (AMIK) Indonesia. Sesuai dengan tuntutan lembaga dan perkembangan dunia pendidikan, pada tahun Akademik 2001/2002 AMIK Indonesia dikembangkan menjadi STMIK Indonesia Padang yang mengelola Program Diploma dan Strata 1 dengan Keputusan Menteri Pendidikan Nasional Republik Indonesia Nomor: 04/D/O/2002 tanggal 2 Januari 2002 tentang Pemberian Izin Penyelenggaraan Program-program Studi dan Pendirian Sekolah Tinggi Manajemen Informatika dan Komputer (STMIK) Indonesia di Padang (perubahan bentuk dari AMIK Indonesia).
            </p>

            <p class="scroll-reveal text-lg" style="animation-delay: 0.4s;">
                Saat ini Institusi dan Program Studi STMIK Indonesia telah terakreditasi B. Visi dari STMIK Indonesia Padang adalah menjadi salah satu perguruan tinggi di bidang komputer yang terkemuka di ASEAN pada tahun 2033. Sedangkan misinya antara lain mendidik dan membina mahasiswa menjadi tenaga ahli yang profesional di bidangnya, berjiwa kewirausahaan, dan berperilaku Islami serta menghasilkan lulusan yang berkualitas, kreatif, inovatif dan berdaya saing Internasional. Untuk visi Prodi S1 Sistem Informasi adalah terkemuka ditingkat Nasional tahun 2023 bidang system analyst dan database administrator yang profesional.
            </p>
        </div>
    </div>
</section>

<!-- ================= TIMELINE / MILESTONE ================= -->
<section class="px-6 py-20 bg-gradient-to-b from-white to-blue-50">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-16 animate-fadeUp">
            <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Perjalanan Sejarah</span>
        </h2>

        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-blue-400 to-cyan-400 hidden md:block"></div>

            <!-- Timeline Items -->
            <div class="space-y-12">
                <!-- Item 1 -->
                <div class="flex items-center gap-8 md:gap-0">
                    <div class="hidden md:flex flex-1 justify-end pr-12">
                        <div class="scroll-reveal bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500 w-full max-w-sm hover:shadow-xl transition-shadow">
                            <p class="font-bold text-blue-600 text-lg mb-2">4 Juni 1986</p>
                            <p class="text-slate-700">Berdirinya Akademi Informatika Komputer (AIK) di Padang</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 md:w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center relative z-10 shadow-lg">
                        <div class="w-4 h-4 bg-white rounded-full"></div>
                    </div>
                    <div class="md:hidden">
                        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500 w-full">
                            <p class="font-bold text-blue-600 text-lg mb-2">4 Juni 1986</p>
                            <p class="text-slate-700">Berdirinya Akademi Informatika Komputer (AIK) di Padang</p>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-center gap-8 md:gap-0">
                    <div class="md:flex flex-1 pl-12 hidden">
                        <div class="scroll-reveal bg-white p-6 rounded-2xl shadow-lg border-r-4 border-cyan-500 w-full max-w-sm hover:shadow-xl transition-shadow" style="animation-delay: 0.2s;">
                            <p class="font-bold text-cyan-600 text-lg mb-2">18 Juni 1990</p>
                            <p class="text-slate-700">Perubahan kepemilikan yayasan & azas Islami</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 md:w-12 h-12 bg-cyan-500 rounded-full flex items-center justify-center relative z-10 shadow-lg">
                        <div class="w-4 h-4 bg-white rounded-full"></div>
                    </div>
                    <div class="md:hidden">
                        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-cyan-500 w-full">
                            <p class="font-bold text-cyan-600 text-lg mb-2">18 Juni 1990</p>
                            <p class="text-slate-700">Perubahan kepemilikan yayasan & azas Islami</p>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-center gap-8 md:gap-0">
                    <div class="hidden md:flex flex-1 justify-end pr-12">
                        <div class="scroll-reveal bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500 w-full max-w-sm hover:shadow-xl transition-shadow" style="animation-delay: 0.4s;">
                            <p class="font-bold text-blue-600 text-lg mb-2">15 Maret 1995</p>
                            <p class="text-slate-700">Perubahan nama menjadi ALBANI</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 md:w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center relative z-10 shadow-lg">
                        <div class="w-4 h-4 bg-white rounded-full"></div>
                    </div>
                    <div class="md:hidden">
                        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500 w-full">
                            <p class="font-bold text-blue-600 text-lg mb-2">15 Maret 1995</p>
                            <p class="text-slate-700">Perubahan nama menjadi ALBANI</p>
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex items-center gap-8 md:gap-0">
                    <div class="md:flex flex-1 pl-12 hidden">
                        <div class="scroll-reveal bg-white p-6 rounded-2xl shadow-lg border-r-4 border-cyan-500 w-full max-w-sm hover:shadow-xl transition-shadow" style="animation-delay: 0.6s;">
                            <p class="font-bold text-cyan-600 text-lg mb-2">2001/2002</p>
                            <p class="text-slate-700">Pengembangan menjadi STMIK Indonesia Padang</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 md:w-12 h-12 bg-cyan-500 rounded-full flex items-center justify-center relative z-10 shadow-lg">
                        <div class="w-4 h-4 bg-white rounded-full"></div>
                    </div>
                    <div class="md:hidden">
                        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-cyan-500 w-full">
                            <p class="font-bold text-cyan-600 text-lg mb-2">2001/2002</p>
                            <p class="text-slate-700">Pengembangan menjadi STMIK Indonesia Padang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ================= VISI & MISI ================= -->
<section class="px-6 py-20 bg-white">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-16 animate-fadeUp">
            <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Visi & Misi</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- VISI -->
            <div class="group">
                <div class="scroll-reveal card-hover border-gradient bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-blue-100 rounded-full -mr-20 -mt-20 opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="text-5xl mb-4 animate-bounce">🎯</div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm">V</span>
                            Visi
                        </h3>
                        <p class="text-slate-700 leading-relaxed text-lg">
                            Universitas Metamedia menjadi salah satu perguruan tinggi bidang teknologi informasi terkemuka di ASEAN pada tahun 2033.
                        </p>
                    </div>
                </div>
            </div>

            <!-- MISI -->
            <div class="group">
                <div class="scroll-reveal card-hover border-gradient bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2 relative overflow-hidden" style="animation-delay: 0.2s;">
                    <div class="absolute top-0 left-0 w-40 h-40 bg-cyan-100 rounded-full -ml-20 -mt-20 opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="text-5xl mb-4">📋</div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center text-white text-sm">M</span>
                            Misi
                        </h3>
                        <ul class="space-y-3 text-slate-700 list-inside list-disc text-sm leading-relaxed">
                            <li>Menyelengarakan pendidikan berkualitas, kreatif, dan berdaya saing internasional</li>
                            <li>Mendorong kegiatan penelitian yang memberikan kontribusi ilmu pengetahuan</li>
                            <li>Melaksanakan pengabdian masyarakat di bidang teknologi informasi</li>
                            <li>Membangun hubungan berkelanjutan dengan lembaga pendidikan dan industri</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Core Values -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
            <div class="scroll-reveal bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200 hover:shadow-lg transition-all">
                <div class="text-3xl mb-3">🎓</div>
                <h4 class="font-bold text-slate-900 mb-2">Profesional</h4>
                <p class="text-slate-700 text-sm">Menghasilkan lulusan yang profesional di bidangnya dengan standar internasional</p>
            </div>

            <div class="scroll-reveal bg-gradient-to-br from-cyan-50 to-cyan-100 p-6 rounded-xl border border-cyan-200 hover:shadow-lg transition-all" style="animation-delay: 0.2s;">
                <div class="text-3xl mb-3">💼</div>
                <h4 class="font-bold text-slate-900 mb-2">Kewirausahaan</h4>
                <p class="text-slate-700 text-sm">Membina jiwa kewirausahaan dan inovasi dalam setiap mahasiswa kami</p>
            </div>

            <div class="scroll-reveal bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl border border-indigo-200 hover:shadow-lg transition-all" style="animation-delay: 0.4s;">
                <div class="text-3xl mb-3">✨</div>
                <h4 class="font-bold text-slate-900 mb-2">Islami</h4>
                <p class="text-slate-700 text-sm">Mengedepankan nilai-nilai Islami dalam setiap aspek pendidikan dan kehidupan</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA SECTION ================= -->
<section class="relative px-6 py-20 overflow-hidden">
    <!-- Animated background -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-600 -z-10"></div>
    
    <!-- Floating elements -->
    <div class="absolute top-10 right-10 w-40 h-40 bg-white rounded-full opacity-10 animate-float"></div>
    <div class="absolute bottom-10 left-10 w-32 h-32 bg-white rounded-full opacity-10 animate-float" style="animation-delay: 2s;"></div>
    
    <div class="max-w-4xl mx-auto text-center relative z-10">
        <h2 class="text-4xl font-bold text-white mb-4 animate-slideInLeft">
            Kunjungi Perpustakaan Kami
        </h2>
        <p class="text-blue-100 mb-8 text-xl animate-slideInRight delay-1">
            Jelajahi koleksi lengkap dan layanan terbaik untuk mendukung akademis Anda
        </p>
        <a href="/" class="inline-block px-8 py-4 bg-white text-blue-600 font-bold rounded-2xl hover:bg-blue-50 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 animate-bounce delay-2">
            <span class="flex items-center gap-2">
                📚 Mulai Jelajahi
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </span>
        </a>
    </div>
</section>

<!-- ================= SCROLL ANIMATION SCRIPT ================= -->
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

    // Parallax effect for hero image
    const parallaxImg = document.querySelector('.parallax-img');
    if (parallaxImg) {
        window.addEventListener('scroll', function() {
            const scrollY = window.scrollY;
            parallaxImg.style.backgroundPosition = `center ${scrollY * 0.5}px`;
        });
    }
</script>
</div>

@endsection
