<!-- Navbar -->
<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="fas fa-bars"></i></a>
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
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <img src="{{ $currentUser?->profile_photo_url ?? asset('logo/logo-univ.png') }}" class="user-image img-circle me-2"
            alt="User avatar">
          <span class="d-none d-md-inline fw-semibold">{{ $currentUser?->name ?? 'Guest' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <li class="user-header text-center">
            <img src="{{ $currentUser?->profile_photo_url ?? asset('logo/logo-univ.png') }}" class="img-circle mb-2"
              alt="User avatar large">
            <p class="mb-0">{{ $currentUser?->name ?? 'Guest' }}</p>
            <small>{{ $currentUser?->email ?? 'Silakan masuk untuk melihat detail' }}</small>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          @if($adminUser)
            <li>
              @if(Route::has('admin.profile.edit'))
                <a href="{{ route('admin.profile.edit') }}" class="dropdown-item d-flex align-items-center">
                  <i class="fas fa-user me-2"></i> Profil Admin
                </a>
              @else
                <a href="{{ route('admin.dashboard') }}" class="dropdown-item d-flex align-items-center">
                  <i class="fas fa-user me-2"></i> Profil Admin
                </a>
              @endif
            </li>
          @elseif($user && Route::has('profile.edit'))
            <li>
              <a href="{{ route('profile.edit') }}" class="dropdown-item d-flex align-items-center">
                <i class="fas fa-user me-2"></i> Profil
              </a>
            </li>
          @endif
          <li>
            @if($adminUser)
              <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center">
                  <i class="fas fa-sign-out-alt me-2"></i> Logout Admin
                </button>
              </form>
            @elseif($user)
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center">
                  <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
              </form>
            @else
              <a href="{{ route('login') }}" class="dropdown-item d-flex align-items-center">
                <i class="fas fa-sign-in-alt me-2"></i> Login
              </a>
            @endif
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<!-- /.navbar -->