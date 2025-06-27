<!-- Sidebar -->
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
            <!-- Menu untuk Dashboard Admin, hanya muncul jika user adalah admin -->
            @if(Auth::user() && Auth::user()->role == 'Administrator')
            <li>
                <a href="{{ url('/admin') }}">
                    <i class="fa fa-tachometer-alt"></i> Dashboard Admin
                </a>
            </li>
            <!-- Menu untuk Menambah Pengguna, hanya muncul jika user adalah admin -->
            <li>
                <a href="{{ url('/admin/users/create') }}">
                    <i class="fa fa-user-plus"></i> Tambah Pengguna
                </a>
            </li>
            @endif

            <!-- Menu lainnya untuk pengguna selain admin (misalnya jika ada) -->
            <!-- Menu untuk pengguna biasa, bisa ditambahkan sesuai dengan kebutuhan -->
        </ul>
    </div>
</div>
<!-- End Sidebar -->
