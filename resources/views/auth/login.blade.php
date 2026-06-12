<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login | Perpustakaan Digital</title>
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeUp { animation: fadeUp 0.5s ease-out forwards; }
    </style>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800 flex items-center justify-center px-4 py-12 antialiased">

    <div class="w-full max-w-md bg-white rounded-2xl border-2 border-slate-300/80 shadow-2xl overflow-hidden animate-fadeUp">
        
        <div class="flex flex-col items-center p-6 bg-slate-50 border-b-2 border-slate-200 text-center">
            <div class="p-1.5 bg-white rounded-xl border border-slate-300 shadow-sm mb-3 shrink-0">
                <img src="/logo/logo-univ.png" alt="Logo Universitas Metamedia" class="w-16 h-16 object-contain">
            </div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900">Perpustakaan Digital</h1>
            <p class="text-xs font-bold uppercase tracking-wider text-indigo-600 mt-0.5">Universitas Metamedia</p>
        </div>

        <div class="p-6 md:p-8">
            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf

                <div class="p-5 bg-slate-50 rounded-xl border-2 border-slate-200 shadow-sm space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 pb-2 mb-1">Kredensial Masuk</p>
                    
                    <div>
                        <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                            class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    </div>

                    <div>
                        <label class="text-xs font-bold uppercase tracking-wide text-slate-600">Password</label>
                        <input type="password" name="password" required placeholder="••••••••" 
                            class="w-full mt-1.5 px-3.5 py-2.5 border-2 border-slate-300 bg-white rounded-lg text-sm transition focus:border-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-sm shadow-md transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 active:scale-[0.99] mt-2">
                    Masuk Sekarang →
                </button>
            </form>

            <div class="mt-6 border-t-2 border-slate-100 pt-4 text-center space-y-3 text-xs md:text-sm">
                <div class="text-slate-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Daftar Anggota</a>
                </div>
                <div>
                    <a href="/" class="inline-flex items-center gap-1 text-xs text-slate-400 font-medium hover:text-slate-600 transition hover:underline">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

    </div>

</body>
</html>