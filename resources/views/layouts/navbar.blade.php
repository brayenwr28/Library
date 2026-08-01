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

            <!-- AUTH BUTTONS -->
            @guest
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
                            class="ml-4 flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:shadow-lg hover:shadow-blue-500/30">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-sm uppercase">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                        </svg>
                    </button>
 
                    <div id="profile-menu" class="absolute right-0 mt-2 w-52 rounded-xl border border-slate-200 bg-white p-2 shadow-lg hidden">
                        <a href="{{ route('peminjaman.riwayat') }}" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                            <span>Riwayat Peminjaman</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                            <span>Edit Profil</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-1">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </li>
            @endguest
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
        
        @guest
            <div class="flex flex-col gap-2 pt-1">
                <a href="{{ route('login') }}" class="w-full text-center px-5 py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold hover:shadow-lg transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="w-full text-center px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                    Register
                </a>
            </div>
        @else
            <div class="space-y-2">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Akun: {{ auth()->user()->name }}</div>
                <a href="{{ route('peminjaman.riwayat') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Riwayat Peminjaman</a>
                <a href="{{ route('profile.edit') }}" class="block text-slate-600 hover:text-slate-900 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-blue-600 transition-all duration-200">Edit Profil</a>
                <form action="{{ route('logout') }}" method="POST" class="pt-1">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-600 hover:text-red-700 hover:pl-2 font-medium py-1 border-l-2 border-transparent hover:border-red-600 transition-all duration-200">
                        Logout
                    </button>
                </form>
            </div>
        @endguest
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
