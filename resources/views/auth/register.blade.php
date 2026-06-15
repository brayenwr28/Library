<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Anggota | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeUp { animation: fadeUp 0.5s ease-out forwards; }
    </style>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800 flex items-center justify-center px-4 py-12 antialiased">

    <div class="bg-white w-full max-w-2xl rounded-2xl border-2 border-slate-300/80 shadow-2xl overflow-hidden animate-fadeUp">
        
        <div class="flex items-center gap-5 p-6 md:p-8 bg-slate-50/50 border-b-2 border-slate-200">
            <div class="p-1.5 bg-white rounded-xl border border-slate-300 shadow-sm shrink-0">
                <img src="/logo/logo-univ.png" class="w-16 h-16 object-contain" alt="Logo Universitas Metamedia">
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Formulir Registrasi Anggota</h1>
                <p class="text-xs font-bold uppercase tracking-wider text-indigo-600 mt-0.5">Perpustakaan Digital • Univ Metamedia</p>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-white">
            <form method="POST" action="{{ route('register.store') }}" class="space-y-5" enctype="multipart/form-data">
                @csrf

                <div class="p-5 md:p-6 bg-slate-50 rounded-xl border-2 border-slate-200 space-y-4 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 pb-2 mb-2">Informasi Akun Utama</p>
                    
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Username <span class="text-rose-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username"
                            class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100 @error('username') border-rose-400 bg-rose-50 @enderror">
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda"
                                class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100 @error('name') border-rose-400 bg-rose-50 @enderror">
                            @error('name')
                                <p class="text-rose-500 text-xs mt-1</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Email <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                                class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100 @error('email') border-rose-400 bg-rose-50 @enderror">
                            @error('email')
                                <p class="text-rose-500 text-xs mt-1"></p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="p-5 md:p-6 bg-slate-50 rounded-xl border-2 border-slate-200 space-y-4 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 pb-2 mb-2">Detail Institusi & Status</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-600">NIM / Nomor Induk <span class="text-rose-500">*</span></label>
                            <input type="text" name="nim" value="{{ old('nim') }}" placeholder="Masukkan NIM"
                                class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100 @error('nim') border-rose-400 bg-rose-50 @enderror">
                            @error('nim')
                                <p class="text-rose-500 text-xs mt-1"></p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Program Studi <span class="text-rose-500">*</span></label>
                            <select name="prodi"
                                class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100 @error('prodi') border-rose-400 bg-rose-50 @enderror">
                                <option value="">-- Silakan Pilih --</option>
                                <option value="Sistem Informasi" {{ old('prodi') === 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                <option value="Informatika" {{ old('prodi') === 'Informatika' ? 'selected' : '' }}>Informatika</option>
                                <option value="Bisnis Digital" {{ old('prodi') === 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
                                <option value="Manajemen Ritel" {{ old('prodi') === 'Manajemen Ritel' ? 'selected' : '' }}>Manajemen Ritel</option>
                                <option value="DKV" {{ old('prodi') === 'DKV' ? 'selected' : '' }}>DKV</option>
                                <option value="Pendidikan Teknologi Informasi" {{ old('prodi') === 'Pendidikan Teknologi Informasi' ? 'selected' : '' }}>Pendidikan Teknologi Informasi</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Jenis Anggota <span class="text-rose-500">*</span></label>
                        <select name="jenis_anggota"
                            class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                            <option value="mahasiswa" {{ old('jenis_anggota', 'mahasiswa') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen" {{ old('jenis_anggota') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                        </select>
                    </div>
                </div>

                <div class="p-5 md:p-6 bg-slate-50 rounded-xl border-2 border-slate-200 space-y-4 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 pb-2 mb-2">Kata Sandi</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Password <span class="text-rose-500">*</span></label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100 @error('password') border-rose-400 bg-rose-50 @enderror">
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Konfirmasi Password <span class="text-rose-500">*</span></label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password"
                                class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 border border-indigo-700 text-white py-3.5 rounded-xl font-bold text-sm shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 active:scale-[0.99]">
                    Kirim & Daftarkan Anggota →
                </button>
            </form>

            <div class="mt-6 border-t-2 border-slate-100 pt-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm">
                <span class="text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Login</a></span>
                <a href="/" class="inline-flex items-center gap-1 text-xs text-slate-400 font-medium hover:text-slate-600 transition hover:underline">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>
</body>
</html>