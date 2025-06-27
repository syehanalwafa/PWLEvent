<div class="main-header shadow-sm bg-white sticky-top">
  <div class="main-header-logo">
    <!-- Logo Header -->
    <div class="logo-header d-flex align-items-center px-3" data-background-color="dark" style="background-color: #343a40;">
      <a href="index.html" class="logo">
        <img
          src="{{ asset('assets/img/kaiadmin/LogoSidebar.png') }}"
          alt="navbar brand"
          class="navbar-brand"
          height="24"
        />
      </a>
      <div class="nav-toggle ms-3">
        <button class="btn btn-outline-light btn-sm btn-toggle toggle-sidebar me-1">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-outline-light btn-sm btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more ms-auto text-white">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>

  <!-- Navbar Header -->
  <nav class="navbar navbar-header navbar-expand-lg border-bottom shadow-sm">
    <div class="container-fluid">

      <!-- Search placeholder (hidden on desktop) -->
      <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"></nav>

      <ul class="navbar-nav topbar-nav ms-auto align-items-center">
        <!-- Search Mobile -->
        <li class="nav-item dropdown d-lg-none">
          <a class="nav-link" data-bs-toggle="dropdown" href="#"><i class="fa fa-search"></i></a>
          <ul class="dropdown-menu p-2">
            <li>
              <form class="navbar-form nav-search">
                <input type="text" class="form-control" placeholder="Search ...">
              </form>
            </li>
          </ul>
        </li>

        <!-- Profile Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center" data-bs-toggle="dropdown" href="#">
            <img
              src="{{ asset('storage/profile_photos/default.png') }}"
              alt="profile"
              class="rounded-circle me-2"
              width="36"
              height="36"
              style="object-fit: cover;"
            />
            <span class="d-none d-md-block">
              <span class="text-muted">Hi,</span>
              <strong>{{ session('name') }}</strong>
            </span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end mt-2 shadow animated fadeIn">
            <li class="px-3 py-3 text-center">
              <img
                src="{{ asset('storage/profile_photos/default.png') }}"
                class="rounded-circle mb-2"
                width="80"
                height="80"
                style="object-fit: cover;"
              />
              <h6 class="mb-0">{{ session('name') }}</h6>
              <small class="text-muted">{{ session('email') }}</small>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li class="px-3 pb-2">
              <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
</div>
