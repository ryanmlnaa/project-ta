<ul class="navbar-nav sidebar sidebar-dark accordion sidebar-rt">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text mx-3">RT PANEL</div>
    </a>

    <hr class="sidebar-divider">

    {{-- DATA PENGHUNI
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-users"></i>
            <span>Data Penghuni</span>
        </a>
    </li> --}}

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rt.dashboard') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- IURAN --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rt.iuran') }}">
            <i class="fas fa-wallet"></i>
            <span>Data Iuran</span>
        </a>
    </li>

    {{-- LAYANAN --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('layanan.index') }}">
            <i class="fas fa-comments"></i>
            <span>Layanan Pengaduan</span>
        </a>
    </li>

    {{-- INFORMASI --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('informasi.index') }}">
            <i class="fas fa-bullhorn"></i>
            <span>Informasi</span>
        </a>
    </li>

    {{-- LAPORAN --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- LOGOUT --}}
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="nav-link btn btn-link text-white">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </form>
    </li>

</ul>

<style>
    /* 🔥 SIDEBAR RT */
    .sidebar-rt {
        background: linear-gradient(135deg, #f59e0b, #f97316) !important;
    }

    .sidebar-rt .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
    }
</style>