<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo text-white text-decoration-none fw-bold fs-4 ms-3">
                Tiketin
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

    <div class="sidebar-menu">
        <ul>
            <li><a href="{{ url('/panitia-kegiatan') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ url('/panitia-kegiatan/events/create') }}"><i class="fa fa-user-plus"></i> Tambah Event</a></li>
        </ul>
    </div>
</div>
