<div class="main-header"> 
  <div class="main-header-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="index.html" class="logo">
        <img
          src="{{ asset('assets/img/kaiadmin/LogoSidebar.png') }}"
          alt="navbar brand"
          class="navbar-brand"
          height="20"
        />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>

  <!-- Navbar Header -->
  <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
      <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
        <div class="input-group">
          <div class="input-group-prepend"></div>
        </div>
      </nav>

      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <!-- Search Dropdown (Mobile) -->
        <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
            <i class="fa fa-search"></i>
          </a>
          <ul class="dropdown-menu dropdown-search animated fadeIn">
            <li>
              <form class="navbar-left navbar-form nav-search">
                <div class="input-group">
                  <input type="text" placeholder="Search ..." class="form-control" />
                </div>
              </form>
            </li>
          </ul>
        </li>

        <!-- Profile Dropdown -->
        <li class="nav-item topbar-user dropdown hidden-caret">
          <a class="dropdown-toggle profile-pic" href="#" id="dropdownProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar-sm">
              <img
                class="main-header-profile-photo"
                src="{{ asset('storage/profile_photos/default.png') }}"
                width="50"
                height="30"
                style="padding-right: 15px;"
              />
            </div>
            <span class="profile-username">
              <span class="op-7">Hi,</span>
              <span class="fw-bold">{{ session('name') }}</span>
            </span>
          </a>

          <ul class="dropdown-menu dropdown-user animated fadeIn" aria-labelledby="dropdownProfile">
            <li class="px-3 py-2 text-center">
              <div class="avatar-lg mb-2">
                <img
                  src="{{ asset('storage/profile_photos/default.png') }}"
                  alt="image profile"
                  class="avatar-img rounded-circle"
                  width="80"
                />
              </div>
              <div class="u-text">
                <h4 class="mb-0">{{ session('name') }}</h4>
                <p class="text-muted mb-0">{{ session('email') }}</p>
              </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button class="dropdown-item text-danger" type="submit">
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
