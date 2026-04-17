<ul class="nav flex-column text-center mt-4" style="gap: 15px;">

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.home') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.home') }}">
            <i class="fas fa-home fa-lg"></i><br>
            <small>Beranda</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.rumah') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.rumah') }}">
            <i class="fas fa-building fa-lg"></i><br>
            <small>Rumah Saya</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.iuran') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.iuran') }}">
            <i class="fas fa-wallet fa-lg"></i><br>
            <small>Iuran</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.pengaduan') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.pengaduan') }}">
            <i class="fas fa-comments fa-lg"></i><br>
            <small>Pengaduan</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.pengumuman') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.pengumuman') }}">
            <i class="fas fa-bullhorn fa-lg"></i><br>
            <small>Pengumuman</small>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('user.profil') ? 'active fw-bold text-primary' : 'text-dark' }}"
           href="{{ route('user.profil') }}">
            <i class="fas fa-user-circle fa-lg"></i><br>
            <small>Profil</small>
        </a>
    </li>

</ul>
