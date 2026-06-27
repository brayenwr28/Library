<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Login Admin - Perpustakaan Digital</title>
</head>

<body class="bg-gradient-to-tr from-blue-900 via-blue-800 to-sky-700 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] rounded-full bg-sky-500/20 blur-3xl pointer-events-none"></div>

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
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>

    <div class="w-full max-w-md bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-8 md:p-10 animate-fadeUp border border-white/20 z-10">

        <div class="flex flex-col items-center mb-8">
            <div class="p-3 bg-blue-50 rounded-2xl shadow-inner mb-4 border border-blue-100/50">
                <img src="/logo/logo-univ.png" alt="Logo Universitas Metamedia" class="w-20 h-20 object-contain">
            </div>

            <h1 class="text-2xl font-bold text-blue-950 tracking-tight text-center">
                Perpustakaan Digital
            </h1>
            <div class="mt-1.5 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold tracking-wide uppercase">
                Portal Admin
            </div>
        </div>

        @if (session('status'))
            <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm animate-pulse">
                <i data-lucide="check-circle" class="w-5 h-5 shrink-0 text-emerald-600"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 shadow-sm">
                <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 text-rose-600"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-blue-900/70 mb-1.5">
                    Alamat Email
                </label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@metamedia.ac.id"
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 bg-slate-50/50 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white transition-all duration-200">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-blue-900/70 mb-1.5">
                    Password
                </label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 bg-slate-50/50 placeholder:text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white transition-all duration-200">
                </div>
            </div>

            <button type="submit" 
                class="w-full mt-2 py-3 px-4 rounded-xl bg-gradient-to-r from-blue-700 to-blue-600 text-white font-semibold shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 hover:from-blue-800 hover:to-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-200 flex items-center justify-center gap-2 group">
                <span>Masuk ke Dashboard</span>
                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </button>
        </form>

        <div class="border-t border-slate-100 mt-8 pt-6 space-y-3 text-center text-sm">
            <p class="text-slate-500">
                Belum memiliki akun? 
                <a href="{{ route('admin.register') }}" class="text-blue-600 font-semibold hover:text-blue-800 hover:underline transition-colors ml-0.5">
                    Daftar di sini
                </a>
            </p>
            
            <div>
                <a href="/" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-blue-600 font-medium transition-colors hover:underline">
                    <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>