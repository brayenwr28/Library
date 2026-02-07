<nav class="fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
    <div class="flex items-center justify-between px-12 py-3">

        <!-- LOGO + NAMA -->
        <div class="flex items-center gap-4">
            <img src="/logo/univmetamedia.png"
                 alt="Logo Universitas Metamedia"
                 class="w-21 h-16 object-contain">
        </div>

        <!-- MENU -->
        <ul class="flex items-center gap-8 text-sm font-medium text-slate-600">

            <li class="relative group">
                <a href="/" class="hover:text-slate-900 transition">
                    Beranda
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>

            <li class="relative group">
                <a href="/katalog" class="hover:text-slate-900 transition">
                    Katalog
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>

            <li class="relative group">
                <a href="/sejarah" class="hover:text-slate-900 transition">
                    Sejarah
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>

            <li class="relative group">
                <a href="/tentang" class="hover:text-slate-900 transition">
                    Tentang
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>

            <li class="relative group">
                <a href="/contact" class="hover:text-slate-900 transition">
                    Contact
                </a>
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-slate-700 transition-all group-hover:w-full"></span>
            </li>

            <!-- BUTTON LOGIN -->
            <li>
                <a href="/login"
                   class="ml-4 px-5 py-2 rounded-lg bg-slate-700 text-white
                          hover:bg-slate-800 transition shadow-sm">
                    Login
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}"
                   class="ml-4 px-5 py-2 rounded-lg bg-slate-700 text-white
                          hover:bg-slate-800 transition shadow-sm">
                    Register
                </a>
            </li>
        </ul>

    </div>
</nav>
