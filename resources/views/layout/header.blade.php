<!-- Navbar -->
<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-md-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-md-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Help
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
          <a class="dropdown-item" href="#">FAQ</a>
          <a class="dropdown-item" href="#">Support</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Contact</a>
        </div>
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
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge text-bg-danger navbar-badge">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="{{ asset('logo/logo-univ.png') }}" alt="User Avatar" class="img-size-50 me-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Brad Diesel
                <span class="float-end text-sm text-danger"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">Call me whenever you can...</p>
              <p class="text-sm text-muted"><i class="far fa-clock me-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="{{ asset('logo/logo-univ.png') }}" alt="User Avatar" class="img-size-50 img-circle me-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                John Pierce
                <span class="float-end text-sm text-muted"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">I got your message bro</p>
              <p class="text-sm text-muted"><i class="far fa-clock me-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="{{ asset('logo/logo-univ.png') }}" alt="User Avatar" class="img-size-50 img-circle me-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Nora Silvester
                <span class="float-end text-sm text-warning"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">The subject goes here</p>
              <p class="text-sm text-muted"><i class="far fa-clock me-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
      </div>
    </li>
    <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-bs-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge text-bg-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope me-2"></i> 4 new messages
            <span class="float-end text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users me-2"></i> 8 friend requests
            <span class="float-end text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file me-2"></i> 3 new reports
            <span class="float-end text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="fullscreen" href="#" role="button">
          <i class="fas fa-expand"></i>
        </a>
      </li>
      @php($user = Auth::user())
      @php($adminUser = Auth::guard('admin')->user())
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{ $user?->profile_photo_url ?? asset('logo/logo-univ.png') }}" class="user-image img-circle me-2" alt="User avatar">
          <span class="d-none d-md-inline fw-semibold">{{ $user?->name ?? 'Guest' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <li class="user-header text-center">
            <img src="{{ $user?->profile_photo_url ?? asset('logo/logo-univ.png') }}" class="img-circle mb-2" alt="User avatar large">
            <p class="mb-0">{{ $user?->name ?? 'Guest' }}</p>
            <small>{{ $user?->email ?? 'Silakan masuk untuk melihat detail' }}</small>
          </li>
          <li><hr class="dropdown-divider"></li>
          @if($user && Route::has('profile.edit'))
            <li>
              <a href="{{ route('profile.edit') }}" class="dropdown-item d-flex align-items-center">
                <i class="fas fa-user me-2"></i> Profil
              </a>  
            </li>
          @endif
          <li>
            @if($user)
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center">
                  <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
              </form>
            @elseif($adminUser)
              <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center">
                  <i class="fas fa-sign-out-alt me-2"></i> Logout Admin
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