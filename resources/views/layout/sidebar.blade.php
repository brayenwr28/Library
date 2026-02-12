<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-decoration-none">
      <img src="{{ asset('logo/univmetamedia.png') }}" alt="Logo" class="brand-image opacity-75 shadow">
      <span class="brand-text fw-semibold">{{ config('app.name', 'Admin Dashboard') }}</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>
        
        <li class="nav-header ps-3 pt-2 pb-1 text-uppercase small text-secondary">Management Buku</li>
        <li class="nav-item {{ request()->is('admin/books*') || request()->routeIs('Bukuperpus.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/books*') || request()->routeIs('Bukuperpus.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-journal-text"></i>
            <p>
              Manajemen Buku
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-header ps-3 pt-2 pb-1 text-uppercase small text-secondary">Input Koleksi</li>
            <li class="nav-item">
              <a href="{{ route('admin.books.create') }}" class="nav-link {{ request()->is('admin/books/create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-plus-circle"></i>
                <p>Input Buku Digital</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.books.library.create') }}" class="nav-link {{ request()->routeIs('admin.books.library.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-plus-circle-dotted"></i>
                <p>Input Buku Perpustakaan</p>
              </a>
            </li>
            <li class="nav-header ps-3 pt-3 pb-1 text-uppercase small text-secondary">List Buku</li>
            <li class="nav-item">
              <a href="{{ route('admin.books.show') }}" class="nav-link {{ request()->is('admin/books/digital*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Buku Digital</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.books.library.show') }}" class="nav-link {{ request()->is('admin/books/library*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Buku Perpustakaan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header ps-3 pt-2 pb-1 text-uppercase small text-secondary">Management Anggota</li>
        <li class="nav-item {{ request()->is('admin/members*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/members*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-people"></i>
            <p>
              Pengguna & Anggota
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/members') }}" class="nav-link {{ request()->is('admin/members') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Data Anggota</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/users') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Data Pengguna</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('admin/loans*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/loans*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-book-half"></i>
            <p>
              Transaksi Peminjaman
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/loans') }}" class="nav-link {{ request()->is('admin/loans') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Peminjaman Aktif</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/loans/history') }}" class="nav-link {{ request()->is('admin/loans/history*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Riwayat Peminjaman</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('admin/reports*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-graph-up"></i>
            <p>
              Laporan & Statistik
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('admin/reports/borrowers') }}" class="nav-link {{ request()->is('admin/reports/borrowers*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Grafik Peminjaman</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('admin/reports/books') }}" class="nav-link {{ request()->is('admin/reports/books*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Statistik Buku</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="{{ url('admin/settings') }}" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-gear"></i>
            <p>Pengaturan Sistem</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>