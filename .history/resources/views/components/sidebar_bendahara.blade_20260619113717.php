@if(auth()->user()->role == 'bendahara')
<nav class="navbar-admin">

    <div class="nav-left">
        <button class="nav-hamburger" id="sidebarToggle" aria-label="Toggle sidebar">
            <span></span><span></span><span></span>
        </button>
        <div class="nav-page-indicator"></div>
        <span class="nav-title">
            @if(request()->routeIs('bendahara.dashboard'))
                Dashboard Bendahara
            @elseif(request()->routeIs('bendahara.iuran.*'))
                Data Iuran
            @elseif(request()->routeIs('bendahara.kas.*'))
                Kas Masuk & Keluar
            @elseif(request()->routeIs('bendahara.rekap.*'))
                Rekap Iuran
            @else
                Panel Bendahara
            @endif
        </span>
    </div>

    <div class="nav-right">
        <div class="nav-divider-v"></div>
        <div class="dropdown">
            <div class="nav-profile" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-avatar-wrap">
                    <img src="{{ Auth::user()->photo
                        ? asset('profile/' . Auth::user()->photo) . '?' . time()
                        : 'https://i.pravatar.cc/100?img=12' }}"
                        class="nav-avatar" alt="avatar">
                    <span class="avatar-status"></span>
                </div>
                <div class="nav-user-info">
                    <span class="nav-name">{{ Auth::user()->name }}</span>
                    <span class="nav-role">{{ Auth::user()->username }}</span>
                </div>
                <i class="fas fa-chevron-down nav-arrow"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-user-header">
                    <img src="{{ Auth::user()->photo
                        ? asset('profile/' . Auth::user()->photo) . '?' . time()
                        : 'https://i.pravatar.cc/100?img=12' }}"
                        class="duh-avatar" alt="avatar">
                    <div>
                        <div class="duh-name">{{ Auth::user()->name }}</div>
                        <div class="duh-role">{{ Auth::user()->username }}</div>
                    </div>
                </li>
                <li><div class="dropdown-divider"></div></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

</nav>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
@endif

<ul class="sidebar-admin-ul" id="sidebarMain">

    <button class="sidebar-close" id="sidebarClose" aria-label="Tutup sidebar">
        <i class="fas fa-times"></i>
    </button>

    <div class="sidebar-brand">
        <div class="sidebar-brand-icon"><i class="fas fa-wallet"></i></div>
        <div class="sidebar-brand-text-wrap">
            <span class="sidebar-brand-name">GREEN VIEW</span>
            <span class="sidebar-brand-sub">PANEL BENDAHARA</span>
        </div>
    </div>

    <div class="sa-divider"></div>
    <div class="sa-section">MENU UTAMA</div>

    <li class="sa-item {{ request()->routeIs('bendahara.iuran.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('bendahara.iuran.index') }}">
            <i class="fas fa-wallet"></i>
            <span>Data Iuran</span>
        </a>
    </li>

</ul>
