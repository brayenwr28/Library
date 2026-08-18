<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Login | Perpustakaan Digital Universitas Metamedia</title>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 flex items-center justify-center px-4 py-12 antialiased relative overflow-hidden">

    <div class="absolute -top-40 -right-40 w-96 h-96 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl pointer-events-none"></div>

    <style>
        @keyframes smoothFadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-smoothFadeUp {
            animation: smoothFadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/80 border border-slate-100 overflow-hidden animate-smoothFadeUp z-10">
        
        <div class="flex flex-col items-center pt-8 pb-4 px-6 text-center">
            <div class="p-2 bg-gradient-to-b from-slate-50 to-white rounded-full shadow-sm mb-3 shrink-0 border border-slate-100">
                <img src="{{ asset('logo/logo.png') }}" alt="Logo Universitas Metamedia" class="w-16 h-16 object-contain">
            </div>
            <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Perpustakaan Digital</h1>
            <p class="text-xs font-semibold uppercase tracking-widest text-sky-600 mt-1">Universitas Metamedia</p>
        </div>

        <div class="p-6 md:p-8 pt-2">
            @if (session('status'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-lg flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold rounded-lg flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf

                <div class="p-5 bg-slate-50/60 rounded-xl border border-slate-100 space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200/60 pb-2 mb-2 flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-sky-500"></i>
                        Masuk Sistem (Admin / Anggota)
                    </p>
                    
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wide text-slate-600 block mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@metamedia.ac.id"
                                class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-lg text-sm transition placeholder:text-slate-400/80 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-wide text-slate-600 block mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i data-lucide="key-round" class="w-4 h-4"></i>
                            </span>
                            <input type="password" name="password" required placeholder="••••••••" 
                                class="w-full pl-9 pr-3.5 py-2.5 bg-white border border-slate-200 rounded-lg text-sm transition placeholder:text-slate-400/80 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-sky-600 text-white py-3 rounded-xl font-bold text-sm shadow-md shadow-sky-600/10 transition duration-200 hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-100 active:scale-[0.98] mt-2 flex items-center justify-center gap-2 group">
                    <span>Masuk Sekarang</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                </button>
            </form>

            <div class="mt-6 border-t border-slate-100 pt-4 text-center space-y-3.5 text-xs md:text-sm">
                <div class="text-slate-500 font-medium">
                    Belum punya akun?
                    <div class="mt-1 flex items-center justify-center gap-2">
                        <a href="{{ route('register') }}" class="text-sky-600 font-bold hover:text-sky-700 hover:underline transition-colors">Daftar Anggota</a>
                        <span class="text-slate-300">•</span>
                        <a href="{{ route('admin.register') }}" class="text-indigo-600 font-bold hover:text-indigo-700 hover:underline transition-colors">Daftar Admin</a>
                    </div>
                </div>
                
                <div class="pt-1">
                    <a href="/" class="inline-flex items-center gap-1.5 text-xs text-slate-400 font-semibold hover:text-slate-600 transition hover:underline">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>