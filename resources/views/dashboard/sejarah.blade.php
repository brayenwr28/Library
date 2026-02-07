<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sejarah | Perpustakaan Digital</title>
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

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .animate-fadeUp {
            animation: fadeUp 0.9s ease-out forwards;
        }

        .animate-zoomIn {
            animation: zoomIn 0.7s ease-out forwards;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .delay-1 { animation-delay: .3s; }
        .delay-2 { animation-delay: .6s; }
        .delay-3 { animation-delay: .9s; }
    </style>
</head>

<body class="bg-white min-h-screen text-slate-700">

<!-- ================= HERO HEADER ================= -->
<section class="relative pt-40 pb-24 text-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 -z-10"></div>
    
    <div class="max-w-4xl mx-auto px-6 animate-fadeUp">
        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
            📚 Sejarah Perpustakaan
        </span>
        <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-slate-900 via-slate-700 to-slate-900 bg-clip-text text-transparent mb-6">
            Perjalanan Transformasi Digital
        </h1>
        <p class="text-xl text-slate-500 leading-relaxed">
             Menjadi Pusat Informasi Digital yang Melayani Seluruh Civitas Akademika
        </p>
    </div>
</section>

<!-- ================= HISTORY IMAGE ================= -->
<section class="w-full overflow-hidden">
    <img src="/images/sejarah-top.jpg" alt="Sejarah Universitas Metamedia" class="w-full h-auto object-contain">
</section>

<!-- ================= HISTORY DETAIL (TEKS) ================= -->
<section class="px-6 py-12 bg-slate-50">
    <div class="max-w-5xl mx-auto text-slate-700 leading-relaxed text-justify">
            <p class="mb-4">
                Perguruan Tinggi ini berdiri berdasarkan Keputusan Yayasan Dharma Bhakti Selecta tanggal 4 Juni 1986 No:001/Ist/YDBS/SK/VI/1986, maka didirikan Akademi Informatika Komputer (AIK) di Padang. Pada tanggal 18 Juni 1990 terjadi perubahan kepemilikan yayasan dan perubahan azas menjadi berazazkan Islam. Oleh karena azas pendiriannya berbeda, maka tanggal 15 Maret 1995 dilakukan perubahan nama yayasan dari Yayasan Dharma Bhakti Selecta menjadi Yayasan Amal Bakti Mukmin Indonesia (ALBANI) dengan Akta No. 77 Notaris Zamri, SH tanggal 15 Maret 1995 dan telah mendapat persetujuan dari Dirjen DIKTI No. 502/DIKTI/Kep/1996 tanggal 22 Oktober 1996. Pada tanggal 29 April 2011, nama Yayasan Amal Bakti Mukmin Indonesia (ALBANI) diganti menjadi Yayasan Amal Bakti Mukmin Padang dengan akta notaris Ujang Iskandar, SE, SH, M.Kn, No. 80 tanggal 29 April 2011. Hal ini diperkuat dengan Keputusan Menteri Hukum dan Hak Azazi Manusia Republik Indonesia No. AHU-288.AH0104 tahun 2012, tanggal 26 Januari 2012.
            </p>

            <p class="mb-4">
                Berdasarkan Surat Keputusan Menteri Pendidikan Republik Indonesia Nomor: 0682/O/1990 tanggal 13 November 1990 tentang Status Terdaftar Program Diploma III, Akademi Informatika Komputer (AIK) berubah nama menjadi Akademi Manajemen Informatika dan Komputer (AMIK) Indonesia. Sesuai dengan tuntutan lembaga dan perkembangan dunia pendidikan, pada tahun Akademik 2001/2002 AMIK Indonesia dikembangkan menjadi STMIK Indonesia Padang yang mengelola Program Diploma dan Strata 1 dengan Keputusan Menteri Pendidikan Nasional Republik Indonesia Nomor: 04/D/O/2002 tanggal 2 Januari 2002 tentang Pemberian Izin Penyelenggaraan Program-program Studi dan Pendirian Sekolah Tinggi Manajemen Informatika dan Komputer (STMIK) Indonesia di Padang (perubahan bentuk dari AMIK Indonesia).
            </p>

            <p class="mb-4">
                Saat ini Institusi dan Program Studi STMIK Indonesia telah terakreditasi B. Visi dari STMIK Indonesia Padang adalah menjadi salah satu perguruan tinggi di bidang komputer yang terkemuka di ASEAN pada tahun 2033. Sedangkan misinya antara lain mendidik dan membina mahasiswa menjadi tenaga ahli yang profesional di bidangnya, berjiwa kewirausahaan, dan berperilaku Islami serta menghasilkan lulusan yang berkualitas, kreatif, inovatif dan berdaya saing Internasional. Untuk visi Prodi S1 Sistem Informasi adalah terkemuka ditingkat Nasional tahun 2023 bidang system analyst dan database administrator yang profesional.
            </p>
        </div>
    </div>
</section>


<!-- ================= VISI & MISI ================= -->
<section class="px-6 py-20">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-16 animate-fadeUp">Visi & Misi</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- VISI -->
            <div class="group">
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2 animate-slideInLeft">
                    <div class="text-4xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Visi</h3>
                    <p class="text-slate-700 leading-relaxed text-lg">
                        Universitas Metamedia menjadi salah satu perguruan tinggi bidang teknologi informasi terkemuka di ASEAN pada tahun 2033.
                    </p>
                </div>
            </div>

            <!-- MISI -->
            <div class="group">
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-2 animate-slideInRight">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Misi</h3>
                    <p class="text-slate-700 mb-4 leading-relaxed">
                        Mendidik dan membina mahasiswa menjadi tenaga teknologi informasi yang profesional, berjiwa kewirausahaan, dan berperilaku Islami serta mampu menghadapi tantangan dunia kerja. Kegiatan utama meliputi:
                    </p>
                    <ul class="space-y-3 text-slate-700 list-inside list-disc">
                        <li>Menyelengarakan pendidikan yang berorientasi pada kebutuhan dan perkembangan ilmu pengetahuan dan teknologi informasi untuk menghasilkan lulusan yang berkualitas, kreatif, inovatif, dan berdaya saing internasional.</li>
                        <li>Mengupayakan kegiatan penelitian dan pengembangannya sehingga memberikan kontribusi pada kemajuan ilmu pengetahuan.</li>
                        <li>Melaksanakan pengabdian kepada masyarakat yang bersifat membantu pemecahan masalah dalam bidang teknologi informasi di dunia industri, instansi pemerintah dan swasta.</li>
                        <li>Membangun citra positif dan membina hubungan yang berkesinambungan dengan para ahli, lembaga-lembaga penelitian dan pendidikan, perusahaan-perusahaan dalam berbagai bidang, praktisi, serta masyarakat.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA SECTION ================= -->
<section
    <h2 class="text-3xl font-bold text-white mb-4 animate-fadeUp">Kunjungi Perpustakaan Kami</h2>
    <p class="text-blue-100 mb-8 text-lg animate-fadeUp delay-1">Jelajahi koleksi lengkap dan layanan terbaik</p>
    <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition-all transform hover:scale-105 animate-fadeUp delay-2">
        Kembali ke Beranda →
    </a>
</section>
</body>
</html>
@extends('layouts.app')

@section('title', 'Sejarah Perpustakaan')

@section('content')
</section>
@endsection
