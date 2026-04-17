<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-smile"></i>
        </div>
        <div class="sidebar-brand-text mx-3">GREEN VIEW</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Menu Utama -->
    <div class="sidebar-heading">
        Manajemen Sistem
    </div>

    <!-- Kelola Data Penghuni -->
    <li class="nav-item">
    <a class="nav-link" href="{{ route('penghuni.index') }}">
        <i class="fas fa-users"></i>
        <span>Kelola Data Penghuni</span>
    </a>
</li>

    <!-- Kelola Iuran -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('iuran.index') }}">
            <i class="fas fa-money-bill-wave"></i>
            <span>Kelola Iuran</span></a>
    </li>

    <!-- Kelola Layanan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('') }}">
            <i class="fas fa-concierge-bell"></i>
            <span>Kelola Layanan</span></a>
    </li>

    <!-- Kelola Informasi -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/informasi') }}">
            <i class="fas fa-info-circle"></i>
            <span>Kelola Informasi</span></a>
    </li>

    <!-- Cetak Laporan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/laporan') }}">
            <i class="fas fa-file-alt"></i>
            <span>Cetak Laporan</span></a>
    </li>

    <!-- Kelola Data User -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/user') }}">
            <i class="fas fa-user-cog"></i>
            <span>Kelola Data User</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
