<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.dashboard') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Iuran -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-money-bill"></i>
            <span>Lihat Iuran</span>
        </a>
    </li>

    <!-- Upload -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-upload"></i>
            <span>Upload Pembayaran</span>
        </a>
    </li>

    <!-- Pengaduan -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-comment"></i>
            <span>Ajukan Pengaduan</span>
        </a>
    </li>

    <!-- Status -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-check-circle"></i>
            <span>Status Pengaduan</span>
        </a>
    </li>

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

</ul>
