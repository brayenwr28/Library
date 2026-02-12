<nav class="fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
    <div class="flex items-center justify-between px-12 py-3">

        <!-- LOGO + NAMA -->
        <div class="flex items-center gap-4">
            <img src="{{ asset('logo/univmetamedia.png') }}"
                 alt="Logo Universitas Metamedia"
                 class="w-21 h-16 object-contain">
        </div>

        <!-- MENU -->
        <ul class="flex items-center gap-8 text-sm font-medium text-slate-600">

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
                       class="ml-4 px-5 py-2 rounded-lg bg-slate-500 text-white
                              hover:bg-slate-600 transition shadow-sm">
                        Login
                    </a>
                </li>
                <li>
                    <a href="{{ route('register') }}"
                       class="ml-4 px-5 py-2 rounded-lg bg-slate-500 text-white
                              hover:bg-slate-600 transition shadow-sm">
                        Register
                    </a>
                </li>
            @else
                <li class="relative">
                    <button type="button" id="profile-menu-button"
                            class="ml-4 flex items-center gap-2 rounded-lg bg-slate-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-600">
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
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('profile-menu-button');
        const menu = document.getElementById('profile-menu');

        if (!toggle || !menu) {
            return;
        }

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
    });
</script>
