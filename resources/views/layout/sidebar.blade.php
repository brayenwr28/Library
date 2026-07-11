<aside class="app-sidebar shadow" data-bs-theme="dark" style="background-color: #191b20 !important;">
  <div class="sidebar-brand"
    style="display: flex; justify-content: center; align-items: center; padding: 18px 0; border-bottom: 1px solid rgba(195, 213, 226, 0.15);">
    <a href="{{ route('admin.dashboard') }}"
      class="brand-link text-decoration-none d-flex align-items-center justify-content-center w-100">
      <img src="{{ asset('logo/univmetamedia.png') }}" alt="Logo" class="brand-image"
        style="max-height: 55px; width: auto; filter: drop-shadow(0px 4px 8px rgba(40, 144, 255, 0.25)); transition: transform 0.3s ease;"
        onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <style>
        /* Gaya dasar untuk Link Menu */
        .sidebar-menu .nav-link {
          color: rgba(255, 255, 255, 0.75) !important;
          transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
          position: relative;
          border-left: 3px solid transparent;
        }

        /* Efek Animasi Hover Menarik */
        .sidebar-menu .nav-link:hover {
          background-color: rgba(255, 255, 255, 0.06) !important;
          color: #ffffff !important;
          padding-left: 20px !important;
          /* Efek bergeser smooth ke kanan */
        }

        /* Gaya Menu Ketika Aktif dengan Garis Indikator */
        .sidebar-menu .nav-link.active {
          background: linear-gradient(90deg, rgba(40, 144, 255, 0.2) 0%, rgba(40, 144, 255, 0.02) 100%) !important;
          color: #2890ff !important;
          /* Warna teks teks/ikon mengikuti warna highlight */
          font-weight: 600;
          border-left: 3px solid #2890ff !important;
          /* Garis vertikal menyala di kiri */
        }

        /* Memastikan icon pendukung di menu aktif ikut berwarna cerah */
        .sidebar-menu .nav-link.active .nav-icon {
          color: #2890ff !important;
        }

        /* Gaya Judul Kelompok Menu (Header) */
        .sidebar-menu .nav-header {
          color: rgba(255, 255, 255, 0.35) !important;
          font-weight: 700;
          letter-spacing: 0.8px;
          font-size: 0.75rem;
          text-transform: uppercase;
          margin-top: 10px;
        }

        /* Desain sub-menu di dalam dropdown */
        .sidebar-menu .nav-treeview .nav-link {
          border-left: 3px solid transparent !important;
        }

        .sidebar-menu .nav-treeview .nav-link:hover {
          padding-left: 28px !important;
        }

        .sidebar-menu .nav-treeview .nav-link.active {
          border-left: 3px solid #2890ff !important;
          background: transparent !important;
        }
      </style>

      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-grid-1x2-fill"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header ps-3 pt-3 pb-1">Management Buku</li>
        <li
          class="nav-item {{ request()->is('admin/books*') || request()->routeIs('Bukuperpus.*') ? 'menu-open' : '' }}">
          <a href="#"
            class="nav-link {{ request()->is('admin/books*') || request()->routeIs('Bukuperpus.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-journals"></i>
            <p>
              Manajemen Buku
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="background-color: rgba(0, 0, 0, 0.2);">
            <li class="nav-header ps-4 pt-2 pb-1 text-uppercase tiny text-muted" style="font-size: 10px; opacity: 0.6;">
              Input Koleksi</li>
            <li class="nav-item">
              <a href="{{ route('admin.books.create') }}"
                class="nav-link ps-4 {{ request()->is('admin/books/create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-file-earmark-arrow-up-fill"></i>
                <p>Input Buku Digital</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.books.library.create') }}"
                class="nav-link ps-4 {{ request()->routeIs('admin.books.library.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-plus-square-fill"></i>
                <p>Input Buku Perpustakaan</p>
              </a>
            </li>
            <li class="nav-header ps-4 pt-2 pb-1 text-uppercase tiny text-muted" style="font-size: 10px; opacity: 0.6;">
              List Buku</li>
            <li class="nav-item">
              <a href="{{ route('admin.books.show') }}"
                class="nav-link ps-4 {{ request()->is('admin/books/digital*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-laptop-fill"></i>
                <p>Buku Digital</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.books.library.show') }}"
                class="nav-link ps-4 {{ request()->is('admin/books/library*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-book-fill"></i>
                <p>Buku Perpustakaan</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-header ps-3 pt-3 pb-1">Management Anggota</li>
        <li class="nav-item">
          <a href="{{ route('admin.members.import.form') }}" class="nav-link">
            <i class="nav-icon bi bi-file-earmark-spreadsheet-fill"></i>
            <p>Import Anggota</p>
          </a>
        </li>
        <li class="nav-header ps-3 pt-3 pb-1">Transaksi & Sirkulasi</li>
        <li class="nav-item">
          <a href="{{ route('admin.pengembalian.index') }}"
            class="nav-link {{ request()->routeIs('admin.pengembalian.index') ? 'active' : '' }}">
            <i class="nav-icon bi bi-clipboard2-check-fill"></i>
            <p>Konfirmasi Peminjaman</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.pengembalian.menunggu') }}"
            class="nav-link {{ request()->routeIs('admin.pengembalian.menunggu') ? 'active' : '' }}">
            <i class="nav-icon bi bi-box-arrow-in-left"></i>
            <p>Konfirmasi Pengembalian</p>
          </a>
        </li>

        <li class="nav-item {{ request()->is('admin/reports*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-clipboard-data-fill"></i>
            <p>
              Laporan & Statistik
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="background-color: rgba(0, 0, 0, 0.2);">
            <li class="nav-item">
              <a href="{{ route('admin.report.peminjaman') }}"
                class="nav-link ps-4 {{ request()->routeIs('admin.report.peminjaman') ? 'active' : '' }}">
                <i class="nav-icon bi bi-file-earmark-arrow-down-fill"></i>
                <p>Laporan Peminjaman</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.report.pengembalian') }}"
                class="nav-link ps-4 {{ request()->routeIs('admin.report.pengembalian') ? 'active' : '' }}">
                <i class="nav-icon bi bi-file-earmark-arrow-up-fill"></i>
                <p>Laporan Pengembalian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.report.pengunjung') }}"
                class="nav-link ps-4 {{ request()->routeIs('admin.report.pengunjung') ? 'active' : '' }}">
                <i class="nav-icon bi bi-people-fill"></i>
                <p>Laporan Pengunjung</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.report.anggota') }}"
                class="nav-link ps-4 {{ request()->routeIs('admin.report.anggota') ? 'active' : '' }}">
                <i class="nav-icon bi bi-person-badge-fill"></i>
                <p>Laporan Anggota</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.report.denda') }}"
                class="nav-link ps-4 {{ request()->routeIs('admin.report.denda') ? 'active' : '' }}">
                <i class="nav-icon bi bi-cash-stack"></i>
                <p>Laporan Denda</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>