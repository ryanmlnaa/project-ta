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

<style>
    /* ========================= */
/* 🔥 SIDEBAR PREMIUM ADMIN */
/* ========================= */
.sidebar-premium {
    background: linear-gradient(180deg, #1e3a8a, #4f46e5, #6366f1);
    box-shadow: 5px 0 20px rgba(0,0,0,0.2);
}

/* BRAND */
.sidebar-brand {
    font-weight: bold;
    font-size: 18px;
    color: white !important;
}

.sidebar-brand-icon i {
    font-size: 20px;
}

/* MENU */
.sidebar-premium .nav-link {
    color: #e0e7ff !important;
    font-weight: 500;
    padding: 10px 15px;
    border-radius: 10px;
    margin: 5px 10px;
    transition: 0.3s;
}

/* ICON */
.sidebar-premium .nav-link i {
    margin-right: 10px;
}

/* HOVER */
.sidebar-premium .nav-link:hover {
    background: rgba(255,255,255,0.1);
    transform: translateX(5px);
    color: #ffffff !important;
}

/* ACTIVE */
.sidebar-premium .nav-item.active .nav-link {
    background: linear-gradient(135deg, #22c55e, #4ade80);
    color: white !important;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* HEADING */
.sidebar-heading {
    color: #c7d2fe;
    font-size: 12px;
    margin-left: 15px;
}

/* LOGOUT */
.logout-admin {
    color: #fecaca !important;
}

.logout-admin:hover {
    color: #ffffff !important;
    background: rgba(255,0,0,0.2);
}
</style>
