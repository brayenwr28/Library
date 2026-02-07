<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-slate-800 mb-2">📚 Login Perpustakaan</h1>
            <p class="text-slate-600">Masuk untuk melakukan peminjaman online</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-700 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Username Input -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">
                        Username
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="{{ old('username') }}"
                        placeholder="Masukkan username Anda"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-700 transition"
                        required
                    >
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Masukkan password Anda"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-700 transition"
                        required
                    >
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-slate-700 hover:bg-slate-800 text-white font-semibold py-3 rounded-lg transition duration-200"
                >
                    🔓 Login
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <div class="flex-1 border-t border-slate-300"></div>
                <span class="px-3 text-slate-500 text-sm">atau</span>
                <div class="flex-1 border-t border-slate-300"></div>
            </div>

            <!-- Register Link -->
            <p class="text-center text-slate-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-slate-700 font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="/" class="text-slate-600 hover:text-slate-800 font-semibold">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
