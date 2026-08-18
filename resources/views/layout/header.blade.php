<!-- Navbar -->
<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="bi bi-list fs-3 text-dark"></i></a>
      </li>
      <li class="nav-item d-none d-md-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
      </li>
      <li class="nav-item d-none d-md-inline-block">
        <a href="{{ route('admin.peminjaman.menunggu') }}" class="nav-link">Peminjaman</a>
      </li>
      <li class="nav-item d-none d-md-inline-block">
        <a href="{{ route('admin.pengembalian.index') }}" class="nav-link">Pengembalian</a>
      </li>
      <li class="nav-item d-none d-md-inline-block">
        <a href="{{ route('admin.report.index') }}" class="nav-link">Laporan</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="d-none d-md-inline ms-md-3" role="search">
      <div class="input-group input-group-sm">
        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-secondary" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto align-items-center">
      <li class="nav-item dropdown">
        <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell"></i>
          <span class="badge text-bg-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <span class="dropdown-header">Notifikasi</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope me-2"></i> 4 notifikasi baru
            <span class="float-end text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users me-2"></i> 8 permintaan baru
            <span class="float-end text-muted text-sm">12 hours</span>
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="fullscreen" href="#" role="button">
          <i class="fas fa-expand"></i>
        </a>
      </li>
      @php($adminUser = Auth::guard('admin')->user())
      @php($user = Auth::user())
      @php($currentUser = $adminUser ?? $user)
      <li class="nav-item dropdown user-menu ms-2">
        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-2.5 py-1 rounded-pill user-profile-btn" data-bs-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <div class="position-relative">
            <img src="{{ $currentUser?->profile_photo_url ?? asset('logo/logo.png') }}" 
              class="rounded-circle border border-2 border-white shadow-sm object-fit-cover bg-white"
              width="36" height="36" alt="User avatar">
            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-1" style="width: 10px; height: 10px;" title="Online"></span>
          </div>
          <div class="d-none d-md-flex flex-column text-start me-1">
            <span class="fw-semibold text-dark fs-7 lh-1">{{ $currentUser?->name ?? 'Guest' }}</span>
            <small class="text-muted fs-8 lh-1 mt-1">{{ $adminUser ? 'Administrator' : ($user ? 'Anggota' : 'Guest') }}</small>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 mt-2 user-dropdown-card" style="min-width: 280px;">
          <!-- User Profile Card Header -->
          <li class="p-3 mb-2 rounded-3 text-center position-relative overflow-hidden user-dropdown-header">
            <div class="position-relative z-1">
              <div class="avatar-wrapper mb-2 position-relative d-inline-block">
                <img src="{{ $currentUser?->profile_photo_url ?? asset('logo/logo.png') }}" 
                  class="rounded-circle shadow border border-3 border-white object-fit-contain p-1 bg-white"
                  width="72" height="72" alt="User avatar large">
              </div>
              <h6 class="fw-bold mb-0 text-white fs-6">{{ $currentUser?->name ?? 'Guest' }}</h6>
              <small class="text-white-50 d-block text-truncate px-2 mb-1 fs-8">{{ $currentUser?->email ?? 'Silakan masuk' }}</small>
              <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 fw-medium fs-8 backdrop-blur">
                <i class="fas fa-shield-alt me-1 fs-9"></i> {{ $adminUser ? 'Administrator' : ($user ? 'Anggota' : 'Guest') }}
              </span>
            </div>
          </li>

          <!-- Menu Items -->
          @if($adminUser)
            <li>
              <a href="{{ Route::has('admin.profile.edit') ? route('admin.profile.edit') : route('admin.dashboard') }}" 
                class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 rounded-3 text-dark fw-medium user-dropdown-link">
                <div class="icon-shape rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; min-width: 36px;">
                  <i class="fas fa-user-gear fs-6"></i>
                </div>
                <div>
                  <div class="lh-1 fw-semibold fs-7">Profil Admin</div>
                  <small class="text-muted fs-8">Kelola akun & pengaturan</small>
                </div>
              </a>
            </li>
          @elseif($user && Route::has('profile.edit'))
            <li>
              <a href="{{ route('profile.edit') }}" 
                class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 rounded-3 text-dark fw-medium user-dropdown-link">
                <div class="icon-shape rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; min-width: 36px;">
                  <i class="fas fa-user-circle fs-6"></i>
                </div>
                <div>
                  <div class="lh-1 fw-semibold fs-7">Profil Saya</div>
                  <small class="text-muted fs-8">Informasi akun Anda</small>
                </div>
              </a>
            </li>
          @endif

          <li><hr class="dropdown-divider my-2 opacity-25"></li>

          <!-- Logout Button -->
          <li>
            @if($adminUser)
              <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 rounded-3 text-danger fw-medium user-dropdown-link logout-link w-100 border-0 bg-transparent text-start">
                  <div class="icon-shape rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; min-width: 36px;">
                    <i class="fas fa-right-from-bracket fs-6"></i>
                  </div>
                  <div>
                    <div class="lh-1 fw-semibold fs-7 text-danger">Logout Admin</div>
                    <small class="text-danger opacity-75 fs-8">Keluar dari akun admin</small>
                  </div>
                </button>
              </form>
            @elseif($user)
              <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 rounded-3 text-danger fw-medium user-dropdown-link logout-link w-100 border-0 bg-transparent text-start">
                  <div class="icon-shape rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; min-width: 36px;">
                    <i class="fas fa-right-from-bracket fs-6"></i>
                  </div>
                  <div>
                    <div class="lh-1 fw-semibold fs-7 text-danger">Logout</div>
                    <small class="text-danger opacity-75 fs-8">Keluar dari akun Anda</small>
                  </div>
                </button>
              </form>
            @else
              <a href="{{ route('login') }}" class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 rounded-3 text-primary fw-medium user-dropdown-link">
                <div class="icon-shape rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; min-width: 36px;">
                  <i class="fas fa-right-to-bracket fs-6"></i>
                </div>
                <div>
                  <div class="lh-1 fw-semibold fs-7">Login</div>
                  <small class="text-muted fs-8">Masuk ke sistem</small>
                </div>
              </a>
            @endif
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<!-- /.navbar -->

<style>
  .user-profile-btn {
    transition: all 0.2s ease-in-out;
    border: 1px solid transparent;
  }
  .user-profile-btn:hover, .user-profile-btn[aria-expanded="true"] {
    background-color: rgba(13, 110, 253, 0.08);
    border-color: rgba(13, 110, 253, 0.15);
  }
  .user-dropdown-card {
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    box-shadow: 0 14px 38px rgba(0, 0, 0, 0.14), 0 4px 12px rgba(0, 0, 0, 0.06) !important;
    animation: userDropdownFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    transform-origin: top right;
  }
  @keyframes userDropdownFadeIn {
    from {
      opacity: 0;
      transform: scale(0.95) translateY(-8px);
    }
    to {
      opacity: 1;
      transform: scale(1) translateY(0);
    }
  }
  .user-dropdown-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    box-shadow: inset 0 -2px 10px rgba(0,0,0,0.1);
  }
  .user-dropdown-link {
    transition: all 0.18s ease;
  }
  .user-dropdown-link:hover {
    background-color: #f1f5f9;
    transform: translateX(3px);
  }
  .logout-link:hover {
    background-color: #fef2f2 !important;
  }
  .fs-7 { font-size: 0.875rem; }
  .fs-8 { font-size: 0.775rem; }
  .fs-9 { font-size: 0.685rem; }
  .backdrop-blur {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
  }
</style>