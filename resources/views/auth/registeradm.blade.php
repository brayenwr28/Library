<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeUp {
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-indigo-50/30 text-slate-800 flex items-center justify-center px-4 py-12 antialiased">
    <div class="w-full max-w-4xl rounded-[2rem] border border-slate-200 bg-white shadow-2xl shadow-indigo-100/40 overflow-hidden animate-fadeUp">
        <div class="grid grid-cols-1 md:grid-cols-[1.1fr_0.9fr]">
            
            <section class="relative overflow-hidden border-b border-slate-100 bg-gradient-to-b from-slate-50/90 to-slate-100/50 p-8 md:border-b-0 md:border-r md:p-12 flex flex-col justify-between">
                <div class="absolute -top-20 -left-20 w-40 h-40 bg-indigo-200/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -right-20 w-40 h-40 bg-blue-200/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.25em] text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.856.12-1.685.342-2.466"></path></svg>
                        Perpustakaan Digital
                    </div>
                    <h1 class="mt-6 text-3xl font-extrabold tracking-tight text-slate-900 md:text-4xl">Registrasi Admin</h1>
                    <p class="mt-4 text-sm leading-relaxed text-slate-500">
                        Buat akun admin untuk mengelola koleksi, peminjaman, dan data anggota. Gunakan kredensial resmi karena akses ini khusus petugas.
                    </p>
                </div>

                <div class="mt-12 relative z-10 space-y-4 rounded-2xl border border-slate-200/80 bg-white/80 backdrop-blur-sm p-6 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Panduan Singkat
                    </p>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <span class="text-indigo-500 font-bold mt-0.5">•</span>
                            <span>Gunakan <strong>email institusi</strong> untuk keperluan verifikasi valid.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-indigo-500 font-bold mt-0.5">•</span>
                            <span>Sandi minimal <strong>8 karakter</strong> kombinasi huruf dan angka.</span>
                        </li>
                    </ul>
                </div>
            </section>

            <main class="p-8 md:p-12 flex flex-col justify-between">
                <div>
                    <div class="mb-8 flex items-center gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-xs font-bold tracking-wider text-indigo-600 border border-indigo-100">
                            ADM
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Formulir Pendaftaran</p>
                            <h2 class="text-lg font-bold text-slate-900">Detail Akun Admin</h2>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50/60 p-4 text-sm text-emerald-800 backdrop-blur-sm">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0x"></path></svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50/60 p-4 text-sm text-rose-800 backdrop-blur-sm">
                            <div class="flex items-center gap-2 font-semibold text-rose-900">
                                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span>Periksa kembali isian Anda:</span>
                            </div>
                            <ul class="mt-2 list-disc space-y-1 pl-5 text-xs text-rose-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ $action ?? route('register.store') }}" class="space-y-5">
                        @csrf

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="name" class="text-xs font-bold uppercase tracking-wide text-slate-500">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 transition duration-200 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100"
                                    placeholder="Masukkan nama lengkap"
                                >
                                @error('name')
                                    <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1"><span class="inline-block w-1 h-1 rounded-full bg-rose-500"></span> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="text-xs font-bold uppercase tracking-wide text-slate-500">Email Admin <span class="text-rose-500">*</span></label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 transition duration-200 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100"
                                    placeholder="nama@perpustakaan.ac.id"
                                >
                                @error('email')
                                    <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1"><span class="inline-block w-1 h-1 rounded-full bg-rose-500"></span> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="username" class="text-xs font-bold uppercase tracking-wide text-slate-500">Username <span class="text-rose-500">*</span></label>
                            <input
                                id="username"
                                type="text"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 transition duration-200 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100"
                                placeholder="admin.nama"
                            >
                            @error('username')
                                <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1"><span class="inline-block w-1 h-1 rounded-full bg-rose-500"></span> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="password" class="text-xs font-bold uppercase tracking-wide text-slate-500">Kata Sandi <span class="text-rose-500">*</span></label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 transition duration-200 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100"
                                    placeholder="Minimal 8 karakter"
                                >
                                @error('password')
                                    <p class="mt-1.5 text-xs text-rose-500 flex items-center gap-1"><span class="inline-block w-1 h-1 rounded-full bg-rose-500"></span> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="text-xs font-bold uppercase tracking-wide text-slate-500">Konfirmasi Kata Sandi <span class="text-rose-500">*</span></label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 transition duration-200 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100"
                                    placeholder="Ulangi kata sandi"
                                >
                            </div>
                        </div>

                        <button type="submit" class="mt-2 w-full rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition duration-200 hover:bg-indigo-700 hover:shadow-indigo-300 focus:outline-none focus:ring-4 focus:ring-indigo-100 active:scale-[0.99]">
                            Buat Akun Admin
                        </button>
                    </form>
                </div>

                <div class="mt-8 space-y-3 text-center">
                    <div class="text-xs text-slate-500">
                        Sudah memiliki akun admin? 
                        <a href="{{ route('admin.login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 hover:underline">Masuk di sini</a>
                    </div>
                    <div class="text-[11px] text-slate-400">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-1 hover:text-slate-600 hover:underline transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke beranda
                        </a>
                    </div>
                </div>
            </main>

        </div>
    </div>
</body>
</html>