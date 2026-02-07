<!-- Example: Layout dengan Role-based Navigation -->
<!-- resources/views/layouts/app-with-navbar.blade.php -->

@extends('layouts.app')

@section('layout')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="text-xl font-bold">📚 Perpustakaan Digital</a>

                @auth
                    <!-- Authenticated User -->
                    <div class="flex items-center space-x-6">
                        <!-- User Info -->
                        <div class="text-sm">
                            <p>{{ auth()->user()->name }}</p>
                            <p class="text-gray-400">
                                @if (auth()->user()->isAdmin())
                                    👤 Admin
                                @elseif (auth()->user()->isPustakawan())
                                    📚 Pustakawan
                                @else
                                    👥 Pengunjung
                                @endif
                            </p>
                        </div>

                        <!-- Role-based Menu -->
                        <div class="space-x-4">
                            <!-- UNTUK ADMIN -->
                            @can('isAdmin')
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-200">
                                    🏠 Admin
                                </a>
                            @endcan

                            <!-- UNTUK ADMIN + PUSTAKAWAN -->
                            @can('isAdminOrPustakawan')
                                <a href="{{ route('librarian.dashboard') }}" class="hover:text-gray-200">
                                    📚 Librarian
                                </a>
                            @endcan

                            <!-- UNTUK USER BIASA -->
                            @can('isUser')
                                <a href="{{ route('user.dashboard') }}" class="hover:text-gray-200">
                                    🏠 Home
                                </a>
                            @endcan

                            <!-- Logout untuk semua user -->
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="hover:text-gray-200">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Guest User -->
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="hover:text-gray-200">Login</a>
                        <a href="{{ route('register') }}" class="hover:text-gray-200">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="bg-gray-100 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2026 Perpustakaan Digital - All Rights Reserved</p>
    </footer>
</body>
</html>
@endsection
