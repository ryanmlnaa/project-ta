<ul class="nav justify-content-center mb-4" style="gap: 30px;">

    <li class="nav-item">
        <a class="nav-link text-center {{ request()->routeIs('user.home') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.home') }}">
            <i class="fas fa-home fa-lg mb-1"></i><br>
            <small>Beranda</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-center {{ request()->routeIs('user.rumah') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.rumah') }}">
            <i class="fas fa-building fa-lg mb-1"></i><br>
            <small>Rumah Saya</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-center {{ request()->routeIs('user.iuran') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.iuran') }}">
            <i class="fas fa-wallet fa-lg mb-1"></i><br>
            <small>Iuran</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-center {{ request()->routeIs('user.pengaduan') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.pengaduan') }}">
            <i class="fas fa-comments fa-lg mb-1"></i><br>
            <small>Pengaduan</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-center {{ request()->routeIs('user.pengumuman') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.pengumuman') }}">
            <i class="fas fa-bullhorn fa-lg mb-1"></i><br>
            <small>Pengumuman</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-center {{ request()->routeIs('user.profil') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.profil') }}">
            <i class="fas fa-user-circle fa-lg mb-1"></i><br>
            <small>Profil</small>
        </a>
    </li>

</ul>
