<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    
<style>
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(25px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fadeUp {
        animation: fadeUp .7s ease-out forwards;
    }
</style>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-200 to-slate-100 px-4">

    <div class="w-full max-w-md bg-white/90 backdrop-blur
                rounded-2xl shadow-2xl p-8 animate-fadeUp">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
            <img src="/logo/logo-univ.png"
                 alt="Logo Universitas Metamedia"
                 class="w-24 h-24 object-contain mb-4">

            <h1 class="text-xl font-semibold text-slate-800">
                Perpustakaan Digital
            </h1>
            <p class="text-sm text-slate-500">
                Universitas Metamedia
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="text-sm font-medium text-slate-600">
                    Email
                </label>
                <input type="email" name="email" required
                       class="w-full mt-1 px-4 py-2.5 rounded-lg
                              border border-slate-300
                              focus:outline-none focus:ring-2 focus:ring-slate-400
                              transition">
            </div>

            <div>
                <label class="text-sm font-medium text-slate-600">
                    Password
                </label>
                <input type="password" name="password" required
                       placeholder="********"
                       class="w-full mt-1 px-4 py-2.5 rounded-lg
                              border border-slate-300
                              focus:outline-none focus:ring-2 focus:ring-slate-400
                              transition">
            </div>

            <button type="submit"
                    class="w-full py-2.5 rounded-lg
                           bg-slate-700 text-white font-medium
                           hover:bg-slate-800
                           transition duration-200">
                Login
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-slate-700 font-medium hover:underline">
                Daftar Anggota
            </a>
        </div>

        <div class="text-center mt-4">
            <a href="/" class="text-xs text-slate-500 hover:underline">
                ← Kembali ke Beranda
            </a>
        </div>

    </div>
</div>
 

</body>
</html>