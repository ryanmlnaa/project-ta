@if(auth()->user()->role == 'admin')
    <nav class="navbar-admin">

        <div class="nav-left">
            <div class="nav-page-indicator"></div>
            <span class="nav-title">
                @if(request()->routeIs('admin.dashboard'))
                    Dashboard Admin
                @elseif(request()->routeIs('penghuni.*'))
                    Data Penghuni
                @elseif(request()->routeIs('iuran.*'))
                    Data Iuran
                @elseif(request()->routeIs('layanan.*'))
                    Layanan Pengaduan
                @elseif(request()->routeIs('informasi.*'))
                    Informasi
                @elseif(request()->routeIs('laporan.*'))
                    Laporan
                @elseif(request()->routeIs('admin.user.*'))
                    Manajemen User
                @else
                    Admin Panel
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
@endif

<ul class="navbar-nav sidebar-admin-ul">

    {{-- BRAND --}}
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="fas fa-leaf"></i>
        </div>
        <div class="sidebar-brand-text-wrap">
            <span class="sidebar-brand-name">GREEN VIEW</span><center></center>
            <center><span class="sidebar-brand-sub">PANEL ADMIN</span></center>
        </div>
    </div>

    <div class="sa-divider"></div>

    <div class="sa-section">MANAJEMEN SISTEM</div>

    <li class="sa-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="sa-item {{ request()->routeIs('penghuni.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('penghuni.index') }}">
            <i class="fas fa-users"></i>
            <span>Data Penghuni</span>
        </a>
    </li>

    <li class="sa-item {{ request()->routeIs('iuran.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('iuran.index') }}">
            <i class="fas fa-wallet"></i>
            <span>Data Iuran</span>
        </a>
    </li>

    <li class="sa-item {{ request()->routeIs('layanan.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('layanan.index') }}">
            <i class="fas fa-headset"></i>
            <span>Layanan Pengaduan</span>
        </a>
    </li>

    <li class="sa-item {{ request()->routeIs('informasi.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('informasi.index') }}">
            <i class="fas fa-bullhorn"></i>
            <span>Informasi</span>
        </a>
    </li>

    <li class="sa-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-file-invoice"></i>
            <span>Laporan</span>
        </a>
    </li>

    <div class="sa-divider"></div>

    <div class="sa-section">LAINNYA</div>

    <li class="sa-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('admin.user.index') }}">
            <i class="fas fa-user-cog"></i>
            <span>Manajemen User</span>
        </a>
    </li>

    {{-- <div class="sa-divider"></div> --}}

    {{-- <li class="sa-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="sa-link sa-logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li> --}}

</ul>

<style>
/* =====================================================
   ROOT VARIABLES
===================================================== */
:root {
    --sa-bg:        #064e3b;  /* ganti dari #1a6e3a */
    --sa-hover:     rgba(255,255,255,0.10);
    --sa-active:    rgba(255,255,255,0.15);
    --sa-border:    rgba(255,255,255,0.08);
    --sa-text:      rgba(255,255,255,0.72);
    --sa-width:     230px;
    --na-height:    62px;
    --na-bg:        #ffffff;
}

body { margin: 0; padding: 0; overflow-x: hidden; }

/* =====================================================
   SIDEBAR
===================================================== */
.sidebar-admin-ul {
    position: fixed;
    top: 0; left: 0;
    width: var(--sa-width);
    height: 100vh;
    background: var(--sa-bg);
    box-shadow: 4px 0 24px rgba(0,0,0,0.18);
    z-index: 1000;
    overflow-y: auto;
    overflow-x: hidden;
    display: flex !important;
    flex-direction: column;
    padding: 0 0 24px 0;
    margin: 0 !important;
    list-style: none;
    scrollbar-width: none;
}
.sidebar-admin-ul::-webkit-scrollbar { display: none; }

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 22px 20px 18px;
}

.sidebar-brand-icon {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.13);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    color: #fff;
    flex-shrink: 0;
}

.sidebar-brand-text-wrap {
    display: flex;
    flex-direction: column;
    line-height: 1.15;
}

.sidebar-brand-name {
    font-size: 13.5px;
    font-weight: 800;
    color: #fff;
    letter-spacing: 0.6px;
}

.sidebar-brand-sub {
    font-size: 9.5px;
    color: rgba(255,255,255,0.45);
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
}

/* Brand */
.sa-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 22px 20px 18px;
    flex-shrink: 0;
}

.sa-brand-icon {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.13);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    color: #fff;
    flex-shrink: 0;
}

.sa-brand-texts {
    display: flex;
    flex-direction: column;
    line-height: 1.15;
}

.sa-brand-name {
    font-size: 13.5px;
    font-weight: 800;
    color: #fff;
    letter-spacing: 0.6px;
}

.sa-brand-sub {
    font-size: 9.5px;
    color: rgba(255,255,255,0.45);
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
}

/* Divider */
.sa-divider {
    height: 1px;
    background: var(--sa-border);
    margin: 10px 16px;
    flex-shrink: 0;
}

/* Section label */
.sa-section {
    font-size: 10px;
    font-weight: 700;
    color: rgba(255,255,255,0.38);
    letter-spacing: 1.1px;
    text-transform: uppercase;
    padding: 8px 20px 6px;
    flex-shrink: 0;
}

/* Nav item */
.sa-item {
    list-style: none;
    margin: 6px 10px;
    flex-shrink: 0;
    box-sizing: border-box;
}

/* Nav link */
/* Nav link */
.sa-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 13px 14px;
    border-radius: 10px;
    color: var(--sa-text) !important;
    font-size: 13.5px;
    font-weight: 500;
    text-decoration: none !important;
    transition: all 0.2s ease;
    background: transparent;
    border: none;
    width: 100%;
    box-sizing: border-box;
    text-align: left;
    cursor: pointer;
    line-height: 1;
}

.sa-link i {
    font-size: 14px;
    width: 18px;
    text-align: center;
    flex-shrink: 0;
    opacity: 0.85;
}

.sa-link:hover {
    background: var(--sa-hover);
    color: #fff !important;
    transform: translateX(3px);
}

.sa-item.active .sa-link {
    background: rgba(255,255,255,0.18) !important;
    color: #fff !important;
    font-weight: 700;
    border-left: 3px solid rgba(255,255,255,0.75);
    padding-left: 11px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.18);
    border-radius: 10px;
}

.sa-item.active .sa-link i {
    opacity: 1;
}

/* Logout */
.sa-logout {
    color: rgba(255,180,180,0.85) !important;
}
.sa-logout:hover {
    background: rgba(255,80,80,0.15) !important;
    color: #fca5a5 !important;
    transform: translateX(3px);
}

/* =====================================================
   NAVBAR ADMIN
===================================================== */
.navbar-admin {
    position: fixed;
    top: 0;
    left: var(--sa-width);
    right: 0;
    height: var(--na-height);
    background: var(--na-bg);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    z-index: 999;
    border-bottom: 1px solid #eef1ee;
    box-shadow: 0 1px 12px rgba(0,0,0,0.06);
}

.navbar-admin .nav-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.navbar-admin .nav-page-indicator {
    width: 4px;
    height: 22px;
    background: linear-gradient(180deg, #064e3b, #10b981);  /* sesuaikan */
    border-radius: 3px;
}

.navbar-admin .nav-title {
    font-size: 15px;
    font-weight: 700;
    color: #1a2e22;
}

.navbar-admin .nav-right {
    display: flex;
    align-items: center;
    gap: 6px;
}

.navbar-admin .nav-divider-v {
    width: 1px;
    height: 28px;
    background: #e8ede9;
    margin: 0 6px;
}

.navbar-admin .nav-profile {
    display: flex;
    align-items: center;
    gap: 9px;
    cursor: pointer;
    padding: 5px 10px 5px 6px;
    border-radius: 12px;
    border: 1px solid #e8ede9;
    background: #f9faf9;
    transition: all 0.2s ease;
}

.navbar-admin .nav-profile:hover {
    background: #e8f4eb;
    border-color: #c8e0cc;
}

.navbar-admin .nav-avatar-wrap {
    position: relative;
    flex-shrink: 0;
}

.navbar-admin .nav-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #d0e8d5;
    display: block;
}

.navbar-admin .avatar-status {
    position: absolute;
    bottom: 1px; right: 1px;
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #22c55e;
    border: 1.5px solid #fff;
}

.navbar-admin .nav-user-info {
    display: flex;
    flex-direction: column;
    line-height: 1.25;
}

.navbar-admin .nav-name {
    font-size: 13px;
    font-weight: 700;
    color: #1a2e22;
    white-space: nowrap;
}

.navbar-admin .nav-role {
    font-size: 11px;
    color: #888;
    font-weight: 500;
    white-space: nowrap;
}

.navbar-admin .nav-arrow {
    font-size: 10px;
    color: #aaa;
    margin-left: 2px;
    transition: transform 0.2s ease;
}

.navbar-admin .nav-profile[aria-expanded="true"] .nav-arrow {
    transform: rotate(180deg);
}

/* Dropdown */
.navbar-admin .dropdown-menu {
    animation: dropIn 0.2s ease;
    border-radius: 14px !important;
    border: 1px solid #e8ede9 !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    padding: 6px;
    min-width: 200px;
    margin-top: 6px !important;
}

@keyframes dropIn {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}

.navbar-admin .dropdown-user-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px 12px;
}

.navbar-admin .duh-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #d0e8d5;
    flex-shrink: 0;
}

.navbar-admin .duh-name {
    font-size: 13.5px;
    font-weight: 700;
    color: #1a2e22;
    line-height: 1.2;
}

.navbar-admin .duh-role {
    font-size: 11.5px;
    color: #888;
    font-weight: 500;
}

.navbar-admin .dropdown-divider {
    margin: 4px 0;
    border-color: #f0f4f1;
}

.navbar-admin .dropdown-item {
    border-radius: 8px;
    font-size: 13px;
    padding: 8px 12px;
    font-weight: 500;
    color: #2c3e50;
    transition: all 0.15s ease;
}

.navbar-admin .dropdown-item:hover {
    background: #f0faf3 !important;
    color: #1a6e3a !important;
}

.navbar-admin .dropdown-item.text-danger:hover {
    background: #fef2f2 !important;
    color: #dc2626 !important;
}

/* =====================================================
   CONTENT OFFSET
===================================================== */
#wrapper {
    display: flex;
    width: 100%;
}

#content-wrapper {
    margin-left: var(--sa-width) !important;
    width: calc(100% - var(--sa-width)) !important;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
}

#content {
    margin-left: 0 !important;
    margin-top: var(--na-height) !important;
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
    flex: 1;
}
</style>
