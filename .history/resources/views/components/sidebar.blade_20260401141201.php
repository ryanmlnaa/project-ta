<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-smile"></i>
        </div>
        <div class="sidebar-brand-text mx-3">GREEN VIEW</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manajemen Sistem
    </div>

    <!-- Penghuni -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('penghuni.index') }}">
            <i class="fas fa-users"></i>
            <span>Kelola Data Penghuni</span>
        </a>
    </li>

    <!-- Iuran -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('iuran.index') }}">
            <i class="fas fa-money-bill-wave"></i>
            <span>Kelola Iuran</span>
        </a>
    </li>

    <!-- Layanan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('layanan.index') }}">
            <i class="fas fa-concierge-bell"></i>
            <span>Kelola Layanan</span>
        </a>
    </li>

    <!-- Informasi -->
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-info-circle"></i>
            <span>Kelola Informasi</span>
        </a>
    </li>

    <!-- Laporan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-file-alt"></i>
            <span>Cetak Laporan</span>
        </a>
    </li>

    <!-- User -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.user.index') }}">
            <i class="fas fa-user-cog"></i>
            <span>Kelola Data User</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

   <!-- Logout -->
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="nav-link btn btn-link text-left">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </form>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

</ul>
