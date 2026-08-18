<nav class="fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
    <!-- Navbar Container -->
    <div class="flex items-center justify-between px-4 md:px-12 py-3">

        <!-- LOGO + NAMA -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group select-none">
            <div class="flex items-center gap-2">
                <img src="{{ asset('logo/logo.png') }}"
                     alt="Logo Universitas Metamedia"
                     class="h-9 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <img src="{{ asset('logo/enbi1.webp') }}"
                     alt="Logo ENBI"
                     class="h-9 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            </div>
            <div class="flex flex-col">
                <span class="font-bold text-slate-800 text-xs sm:text-base md:text-lg leading-tight tracking-tight">
                    Perpustakaan Digital
                </span>
                <span class="text-[8px] sm:text-[10px] md:text-xs text-slate-500 font-semibold tracking-wider uppercase">
                    Universitas Metamedia
                </span>
            </div>
        </a>

        <!-- MOBILE HAMBURGER TOGGLE -->
        <button id="mobile-menu-toggle" type="button" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none md:hidden transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- DESKTOP MENU -->
        <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
            <li class="relative group">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition">
                    Beranda
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>
            <li class="relative group">
                <a href="{{ route('katalog') }}" class="hover:text-slate-900 transition">
                    Katalog
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>
            <li class="relative group">
                <a href="{{ route('admin.books.library.index') }}" class="hover:text-slate-900 transition">
                    Perpustakaan
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>
            <li class="relative group">
                <a href="{{ route('sejarah') }}" class="hover:text-slate-900 transition">
                    Sejarah
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>
            <li class="relative group">
                <a href="{{ route('tentang') }}" class="hover:text-slate-900 transition">
                    Tentang
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>
            <li class="relative group">
                <a href="{{ route('contact') }}" class="hover:text-slate-900 transition">
                    Contact
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>

            <!-- AUTH BUTTONS / USER PROFILE -->
            @php
                $adminUser = Auth::guard('admin')->user();
                $memberUser = Auth::user();
                $currentUser = $adminUser ?? $memberUser;
            @endphp

            @if(!$currentUser)
                <li>
                    <a href="{{ route('login') }}"
                       class="ml-4 px-5 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold
                              hover:shadow-lg hover:shadow-blue-500/30 transition shadow-sm">
                        Login
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}"
                       class="ml-2 px-5 py-2 rounded-lg border border-slate-200 text-slate-700 font-medium
                              hover:bg-slate-50 hover:text-slate-900 transition shadow-sm">
                        Register
                    </a>
                </li>
            @else
                <li class="relative">
                    <button type="button" id="profile-menu-button"
                            class="ml-4 flex items-center gap-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 px-4 py-1.5 text-sm font-semibold text-white shadow-sm transition hover:shadow-lg hover:shadow-blue-500/30">
                        @if($memberUser && $memberUser->photo && file_exists(public_path('storage/' . $memberUser->photo)))
                            <img src="{{ asset('storage/' . $memberUser->photo) }}" alt="{{ $currentUser->name }}" class="h-8 w-8 rounded-full object-cover border border-white/40 shadow-sm">
                        @else
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-xs font-bold uppercase shadow-sm">
                                {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                            </span>
                        @endif
                        <div class="flex flex-col text-left leading-tight">
                            <span class="font-semibold text-white text-xs sm:text-sm">{{ $currentUser->name }}</span>
                            <span class="text-[10px] text-blue-100 font-normal opacity-90">
                                {{ $adminUser ? 'Administrator' : 'Anggota' }}
                            </span>
                        </div>
                        <svg class="h-4 w-4 ml-0.5 opacity-80" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                        </svg>
                    </button>
 
                    <div id="profile-menu" class="absolute right-0 mt-2 w-56 rounded-xl border border-slate-200 bg-white p-2 shadow-lg hidden z-50">
                        <div class="px-3 py-2 border-b border-slate-100 mb-1">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $currentUser->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $currentUser->email }}</p>
                            <span class="mt-1.5 inline-block px-2.5 py-0.5 text-[10px] font-semibold rounded-full {{ $adminUser ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $adminUser ? 'Administrator' : 'Anggota' }}
                            </span>
                        </div>
                        @if($adminUser)
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                <span>Dashboard Admin</span>
                            </a>
                            <form action="{{ route('admin.logout') }}" method="POST" class="mt-1 border-t border-slate-100 pt-1">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    <span>Logout Admin</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('peminjaman.riwayat') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Riwayat Peminjaman</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>Edit Profil</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="mt-1 border-t border-slate-100 pt-1">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </li>
            @endif
        </ul>
    </div>
 
    <!-- MOBILE MENU DROPDOWN -->
    <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 right-0 bg-white/95 backdrop-blur-md border-t border-slate-200 px-6 py-6 space-y-4 shadow-xl z-40">
        <a href="{{ route('dashboard') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Beranda</a>
        <a href="{{ route('katalog') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Katalog</a>
        <a href="{{ route('admin.books.library.index') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Perpustakaan</a>
        <a href="{{ route('sejarah') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Sejarah</a>
        <a href="{{ route('tentang') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Tentang</a>
        <a href="{{ route('contact') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Contact</a>
        
        <hr class="border-slate-200 my-2">
        
        @if(!$currentUser)
            <div class="flex flex-col gap-2 pt-1">
                <a href="{{ route('login') }}" class="w-full text-center px-5 py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold hover:shadow-lg transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="w-full text-center px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                    Register
                </a>
            </div>
        @else
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-100 rounded-xl">
                    @if($memberUser && $memberUser->photo && file_exists(public_path('storage/' . $memberUser->photo)))
                        <img src="{{ asset('storage/' . $memberUser->photo) }}" alt="{{ $currentUser->name }}" class="h-10 w-10 rounded-full object-cover border border-slate-200">
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold uppercase shadow-sm">
                            {{ strtoupper(substr($currentUser->name, 0, 1)) }}
                        </span>
                    @endif
                    <div class="flex flex-col truncate">
                        <span class="text-sm font-semibold text-slate-800 truncate">{{ $currentUser->name }}</span>
                        <span class="text-xs text-slate-500 truncate">{{ $currentUser->email }}</span>
                        <span class="mt-0.5 inline-block text-[10px] font-semibold text-blue-600">
                            {{ $adminUser ? 'Administrator' : 'Anggota' }}
                        </span>
                    </div>
                </div>

                @if($adminUser)
                    <a href="{{ route('admin.dashboard') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Dashboard Admin</a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="pt-1 border-t border-slate-100">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-600 hover:text-red-700 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-red-600 transition-all duration-200">
                            Logout Admin
                        </button>
                    </form>
                @else
                    <a href="{{ route('peminjaman.riwayat') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Riwayat Peminjaman</a>
                    <a href="{{ route('profile.edit') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Edit Profil</a>
                    <form action="{{ route('logout') }}" method="POST" class="pt-1 border-t border-slate-100">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-600 hover:text-red-700 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-red-600 transition-all duration-200">
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('profile-menu-button');
        const menu = document.getElementById('profile-menu');

        if (toggle && menu) {
            const hideMenu = () => {
                menu.classList.add('hidden');
            };

            toggle.addEventListener('click', function (event) {
                event.stopPropagation();
                menu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                    hideMenu();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    hideMenu();
                }
            });
        }

        // MOBILE MENU TOGGLE
        const mobileToggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        if (mobileToggleBtn && mobileMenu) {
            mobileToggleBtn.addEventListener('click', function () {
                const isHidden = mobileMenu.classList.toggle('hidden');
                if (isHidden) {
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                } else {
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                }
            });
        }
    });
</script>
