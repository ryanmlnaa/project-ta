<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold text-success" href="{{ route('user.home') }}">
            GREEN VIEW
        </a>

        <!-- Toggle Mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarUser">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarUser">
            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active text-primary fw-bold' : '' }}"
                       href="{{ route('user.home') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.rumah') ? 'active text-primary fw-bold' : '' }}"
                       href="{{ route('user.rumah') }}">
                        <i class="fas fa-building"></i> Rumah
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.iuran') ? 'active text-primary fw-bold' : '' }}"
                       href="{{ route('user.iuran') }}">
                        <i class="fas fa-wallet"></i> Iuran
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.pengaduan') ? 'active text-primary fw-bold' : '' }}"
                       href="{{ route('user.pengaduan') }}">
                        <i class="fas fa-comments"></i> Pengaduan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.pengumuman') ? 'active text-primary fw-bold' : '' }}"
                       href="{{ route('user.pengumuman') }}">
                        <i class="fas fa-bullhorn"></i> Pengumuman
                    </a>
                </li>

            </ul>

            <!-- Right Menu -->
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profil') }}">
                        <i class="fas fa-user-circle"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-link nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </li>

            </ul>

        </div>
    </div>
</nav>

<style>
.navbar-nav .nav-link {
    transition: 0.3s;
}

.navbar-nav .nav-link:hover {
    color: #198754 !important;
    transform: translateY(-2px);
}

.navbar {
    border-radius: 10px;
}
</style>
