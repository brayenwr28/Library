<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi Anggota | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeUp {
            animation: fadeUp .8s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center px-4">

    <div class="bg-white w-full max-w-xl rounded-2xl shadow-xl p-8 animate-fadeUp">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
            <img src="/logo/logo-univ.png" class="w-20 h-20 object-contain mb-3" alt="Logo Universitas Metamedia">

            <h1 class="text-xl font-semibold text-slate-800">
                Registrasi Terlebih Dahulu
            </h1>
            <p class="text-sm text-slate-500">
                Perpustakaan Digital
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            <!-- Username -->
            <div>
                <label class="text-sm font-medium text-slate-600">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full mt-1 px-4 py-2 border rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-slate-400 @error('username') border-red-500 @enderror">
                @error('username')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nama & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-slate-600">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full mt-1 px-4 py-2 border rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-slate-400 @error('name') border-red-500 @enderror">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full mt-1 px-4 py-2 border rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-slate-400 @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- NIM & Prodi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-slate-600">NIM</label>
                    <input type="text" name="nim" value="{{ old('nim') }}"
                        class="w-full mt-1 px-4 py-2 border rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-slate-400 @error('nim') border-red-500 @enderror">
                    @error('nim')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600">Program Studi</label>
                    <select name="prodi"
                        class="w-full mt-1 px-4 py-2 border rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-slate-400 @error('prodi') border-red-500 @enderror">
                        <option value="">-- Silakan Pilih --</option>
                        <option value="Sistem Informasi" {{ old('prodi') === 'Sistem Informasi' ? 'selected' : '' }}>
                            Sistem Informasi</option>
                        <option value="Informatika" {{ old('prodi') === 'Informatika' ? 'selected' : '' }}>Informatika
                        </option>
                        <option value="Bisnis Digital" {{ old('prodi') === 'Bisnis Digital' ? 'selected' : '' }}>Bisnis
                            Digital</option>
                        <option value="Manajemen Ritel" {{ old('prodi') === 'Manajemen Ritel' ? 'selected' : '' }}>
                            Manajemen Ritel</option>
                        <option value="DKV" {{ old('prodi') === 'DKV' ? 'selected' : '' }}>DKV</option>
                        <option value="Pendidikan Teknologi Informasi" {{ old('prodi') === 'Pendidikan Teknologi Informasi' ? 'selected' : '' }}>Pendidikan Teknologi Informasi</option>
                    </select>
                    @error('prodi')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="text-sm font-medium text-slate-600">Password</label>
                <input type="password" name="password"
                    class="w-full mt-1 px-4 py-2 border rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-slate-400 @error('password') border-red-500 @enderror">
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="text-sm font-medium text-slate-600">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full mt-1 px-4 py-2 border rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-slate-400">
            </div>

            <!-- Button -->
            <button type="submit" class="w-full bg-slate-700 text-white py-3 rounded-lg
                       hover:bg-slate-800 transition font-semibold">
                Daftar Anggota
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-slate-700 font-medium hover:underline">
                Login
            </a>
        </div>

        <div class="text-center mt-4">
            <a href="/" class="text-xs text-slate-500 hover:underline">
                ← Kembali ke Beranda
            </a>
        </div>

    </div>
</body>

</html>