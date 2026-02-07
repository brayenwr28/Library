<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-slate-700">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Konten Halaman -->
    <main class="pt-28">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

</body>
</html>
