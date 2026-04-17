<!-- 🔥 SIDEBAR PREMIUM ADMIN -->
<ul class="navbar-nav sidebar sidebar-dark accordion sidebar-premium" id="accordionSidebar">

    <!-- BRAND -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-leaf"></i>
        </div>
        <div class="sidebar-brand-text mx-2">GREEN VIEW</div>
    </a>

    <hr class="sidebar-divider my-2">

    <!-- DASHBOARD -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manajemen Sistem
    </div>

    <!-- MENU -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('penghuni.index') }}">
            <i class="fas fa-users"></i>
            <span>Data Penghuni</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('iuran.index') }}">
            <i class="fas fa-wallet"></i>
            <span>Data Iuran</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('layanan.index') }}">
            <i class="fas fa-headset"></i>
            <span>Layanan Pengaduan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('informasi.index') }}">
            <i class="fas fa-bullhorn"></i>
            <span>Informasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-file-invoice"></i>
            <span>Laporan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.user.index') }}">
            <i class="fas fa-user-cog"></i>
            <span>Manajemen User</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- LOGOUT -->
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="nav-link btn btn-link text-left logout-admin">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </form>
    </li>

</ul>
