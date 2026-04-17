!-- Sidebar User -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('user.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-home"></i>
        </div>
        <div class="sidebar-brand-text mx-3">GREEN VIEW</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Menu Penghuni
    </div>

    <!-- Lihat Iuran -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-money-bill"></i>
            <span>Lihat Iuran</span>
        </a>
    </li>

    <!-- Upload Pembayaran -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-upload"></i>
            <span>Upload Pembayaran</span>
        </a>
    </li>

    <!-- Ajukan Pengaduan -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-comment-dots"></i>
            <span>Ajukan Pengaduan</span>
        </a>
    </li>

    <!-- Status Pengaduan -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-check-circle"></i>
            <span>Status Pengaduan</span>
        </a>
    </li>

    <!-- Pengumuman -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-bullhorn"></i>
            <span>Lihat Pengumuman</span>
        </a>
    </li>

    <!-- Profil -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-user"></i>
            <span>Edit Profil</span>
        </a>
    </li>

    <hr class="sidebar-divider">

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
