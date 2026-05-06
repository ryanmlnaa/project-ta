<nav class="navbar navbar-expand-lg navbar-modern fixed-top">
    <div class="container-fluid px-4">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold text-white d-flex align-items-center"
           href="{{ route('user.home') }}">
            <i class="fas fa-leaf me-2"></i> GREEN VIEW
        </a>

        <!-- TOGGLE -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarUser">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navbarUser">

            <!-- MENU TENGAH -->
            <ul class="navbar-nav mx-auto gap-2">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}"
                       href="{{ route('user.home') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.rumah') ? 'active' : '' }}"
                       href="{{ route('user.rumah') }}">
                        <i class="fas fa-building"></i> Rumah
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.iuran') ? 'active' : '' }}"
                       href="{{ route('user.iuran') }}">
                        <i class="fas fa-wallet"></i> Iuran
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.upload.pembayaran') ? 'active' : '' }}"
                       href="{{ route('user.upload.pembayaran') }}">
                        <i class="fas fa-upload"></i> Upload
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.status.pembayaran') ? 'active' : '' }}"
                       href="{{ route('user.status.pembayaran') }}">
                        <i class="fas fa-check-circle"></i> Status
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.pengaduan') ? 'active' : '' }}"
                       href="{{ route('user.pengaduan') }}">
                        <i class="fas fa-comments"></i> Pengaduan
                    </a>
                </li>

            </ul>

            <!-- RIGHT -->
            <ul class="navbar-nav align-items-center gap-2">

                <!-- PROFILE -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('user.profil') }}">
                        <i class="fas fa-user-circle"></i>
                    </a>
                </li>

                <!-- LOGOUT -->
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </li>

            </ul>

        </div>
    </div>
</nav>
