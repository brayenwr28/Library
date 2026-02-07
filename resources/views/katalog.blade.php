<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog | Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen text-slate-700">

<section class="pt-36 px-6 pb-12">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">Katalog Buku</h1>
        <p class="text-slate-600 mb-6">Cari dan jelajahi koleksi buku digital kami. (Contoh tampilan statis)</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 border rounded-lg">
                <h3 class="font-semibold">Judul Buku A</h3>
                <p class="text-sm text-slate-500">Pengarang — Tahun</p>
            </div>
            <div class="p-4 border rounded-lg">
                <h3 class="font-semibold">Judul Buku B</h3>
                <p class="text-sm text-slate-500">Pengarang — Tahun</p>
            </div>
            <div class="p-4 border rounded-lg">
                <h3 class="font-semibold">Judul Buku C</h3>
                <p class="text-sm text-slate-500">Pengarang — Tahun</p>
            </div>
        </div>

    </div>
</section>
</body>
</html>
@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
@endsection
