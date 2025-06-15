<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/LogoSidebar.png') }}" alt="navbar brand" class="navbar-brand" height="40" />
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
    </div>

    <div class="sidebar-menu">
        <ul>
            <li><a href="{{ url('/admin') }}"><i class="fa fa-tachometer-alt"></i> Dashboard Admin</a></li>
            <li><a href="{{ url('/admin/users/create') }}"><i class="fa fa-user-plus"></i> Tambah Pengguna</a></li>
        </ul>
    </div>
</div>
