@if(auth()->user()->role == 'rt')
    <nav class="navbar-rt">

        <div class="nav-left">
            <div class="nav-page-indicator"></div>
            <span class="nav-title">
                @if(request()->routeIs('rt.dashboard'))
                    Dashboard RT
                @elseif(request()->routeIs('rt.penghuni'))
                    Data Penghuni
                @elseif(request()->routeIs('rt.rumah'))
                    Data Rumah
                @elseif(request()->routeIs('rt.iuran'))
                    Data Iuran
                @elseif(request()->routeIs('layanan.index'))
                    Layanan Pengaduan
                @else
                    Panel RT
                @endif
            </span>
        </div>

        <div class="nav-right">

            {{-- Notif bell (opsional kosmetik) --}}
            {{-- <div class="nav-icon-btn">
                <i class="fas fa-bell"></i>
                <span class="notif-dot"></span>
            </div> --}}

            <div class="nav-divider-v"></div>

            {{-- Profile Dropdown --}}
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
                        <a class="dropdown-item" href="{{ route('rt.profile') }}">
                            <i class="fas fa-user-circle me-2"></i> Edit Profile
                        </a>
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

<ul class="navbar-nav sidebar sidebar-rt">

    {{-- BRAND --}}
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="fas fa-leaf"></i>
        </div>
        <div class="sidebar-brand-text-wrap">
            <span class="sidebar-brand-name">GREEN VIEW</span>
            <span class="sidebar-brand-sub">PANEL RT</span>
        </div>
    </div>

    <div class="sidebar-divider"></div>

    {{-- MENU UTAMA --}}
    <div class="sidebar-section-title">MENU UTAMA</div>

    <li class="nav-item {{ request()->routeIs('rt.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rt.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('rt.penghuni') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rt.penghuni') }}">
            <i class="fas fa-users"></i>
            <span>Data Penghuni</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('rt.rumah') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rt.rumah') }}">
            <i class="fas fa-building"></i>
            <span>Data Rumah</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('rt.iuran') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rt.iuran') }}">
            <i class="fas fa-wallet"></i>
            <span>Data Iuran</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('layanan.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('layanan.index') }}">
            <i class="fas fa-comments"></i>
            <span>Layanan Pengaduan</span>
        </a>
    </li>

    <div class="sidebar-divider"></div>

    {{-- LAINNYA --}}
    <div class="sidebar-section-title">LAINNYA</div>

    <li class="nav-item {{ request()->routeIs('informasi.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('informasi.index') }}">
            <i class="fas fa-bullhorn"></i>
            <span>Informasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>
    </li>

</ul>

<style>
/* =====================================================
   VARIABLES
===================================================== */
:root {
    --sb-bg:        #064e3b;  /* ganti dari #1a5e2a */
    --sb-hover:     rgba(255,255,255,0.1);
    --sb-active:    rgba(255,255,255,0.15);
    --sb-border:    rgba(255,255,255,0.08);
    --sb-text:      rgba(255,255,255,0.72);
    --sb-text-on:   #ffffff;
    --nb-bg:        #ffffff;
    --sb-width:     230px;
    --nb-height:    62px;
}

body { margin: 0; padding: 0; }

/* =====================================================
   SIDEBAR
===================================================== */
.sidebar-rt {
    position: fixed;
    top: 0; left: 0;
    width: var(--sb-width);
    height: 100vh;
    background: var(--sb-bg);
    box-shadow: 4px 0 24px rgba(0,0,0,0.18);
    z-index: 1000;
    overflow-y: auto;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    padding-bottom: 24px;
    scrollbar-width: none;
}
.sidebar-rt::-webkit-scrollbar { display: none; }

/* Brand */
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

/* Divider */
.sidebar-divider {
    border: none;
    border-top: 1px solid var(--sb-border);
    margin: 8px 16px;
}

/* Section title */
.sidebar-section-title {
    font-size: 10px;
    font-weight: 700;
    color: rgba(255,255,255,0.38);
    letter-spacing: 1.1px;
    text-transform: uppercase;
    padding: 10px 20px 5px;
}

/* Nav items */
/* Nav items */
.sidebar-rt .nav-item {
    list-style: none;
    margin: 4px 0;
    padding: 0 10px;
    box-sizing: border-box;
    flex-shrink: 0;
}

.sidebar-rt .nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 13px 14px;
    border-radius: 10px;
    color: var(--sb-text) !important;
    font-size: 13.5px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    background: transparent;
    border: none;
    width: 100%;
    box-sizing: border-box;
    text-align: left;
}

.sidebar-rt .nav-link i {
    font-size: 14px;
    width: 18px;
    text-align: center;
    flex-shrink: 0;
    opacity: 0.85;
}

.sidebar-rt .nav-link:hover {
    background: var(--sb-hover);
    color: #fff !important;
    transform: translateX(3px);
}

.sidebar-rt .nav-item.active .nav-link {
    background: rgba(255,255,255,0.18) !important;
    color: #fff !important;
    font-weight: 700;
    border-left: 3px solid rgba(255,255,255,0.75);
    padding-left: 11px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.18);
    border-radius: 10px;
}

.sidebar-rt .nav-item.active .nav-link i {
    opacity: 1;
}

/* =====================================================
   NAVBAR
===================================================== */
.navbar-rt {
    position: fixed;
    top: 0;
    left: var(--sb-width);
    right: 0;
    height: var(--nb-height);
    background: var(--nb-bg);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    z-index: 999;
    border-bottom: 1px solid #eef1ee;
    box-shadow: 0 1px 12px rgba(0,0,0,0.06);
}

/* Left side */
.nav-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.nav-page-indicator {
    width: 4px;
    height: 22px;
    background: linear-gradient(180deg, #064e3b, #10b981);  /* sesuaikan */
    border-radius: 3px;
}

.nav-title {
    font-size: 15px;
    font-weight: 700;
    color: #1a2e22;
    letter-spacing: 0.1px;
}

/* Right side */
.nav-right {
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Bell button */
.nav-icon-btn {
    position: relative;
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #f4f7f5;
    border: 1px solid #e8ede9;
    display: flex; align-items: center; justify-content: center;
    color: #555;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.nav-icon-btn:hover {
    background: #e8f4eb;
    color: #1a5e2a;
    border-color: #c8e0cc;
}

.notif-dot {
    position: absolute;
    top: 7px; right: 7px;
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #e11d48;
    border: 1.5px solid #fff;
}

/* Vertical divider */
.nav-divider-v {
    width: 1px;
    height: 28px;
    background: #e8ede9;
    margin: 0 6px;
}

/* Profile trigger */
.nav-profile {
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

.nav-profile:hover {
    background: #e8f4eb;
    border-color: #c8e0cc;
}

/* Avatar */
.nav-avatar-wrap {
    position: relative;
    flex-shrink: 0;
}

.nav-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #d0e8d5;
    display: block;
}

.avatar-status {
    position: absolute;
    bottom: 1px; right: 1px;
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #22c55e;
    border: 1.5px solid #fff;
}

.nav-user-info {
    display: flex;
    flex-direction: column;
    line-height: 1.25;
}

.nav-name {
    font-size: 13px;
    font-weight: 700;
    color: #1a2e22;
}

.nav-role {
    font-size: 11px;
    color: #888;
    font-weight: 500;
}

.nav-arrow {
    font-size: 10px;
    color: #aaa;
    margin-left: 2px;
    transition: transform 0.2s ease;
}

.nav-profile[aria-expanded="true"] .nav-arrow {
    transform: rotate(180deg);
}

/* =====================================================
   DROPDOWN MENU
===================================================== */
.dropdown-menu {
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

/* User header inside dropdown */
.dropdown-user-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px 12px;
}

.duh-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #d0e8d5;
    flex-shrink: 0;
}

.duh-name {
    font-size: 13.5px;
    font-weight: 700;
    color: #1a2e22;
    line-height: 1.2;
}

.duh-role {
    font-size: 11.5px;
    color: #888;
    font-weight: 500;
}

.dropdown-divider {
    margin: 4px 0;
    border-color: #f0f4f1;
}

.dropdown-item {
    border-radius: 8px;
    font-size: 13px;
    padding: 8px 12px;
    font-weight: 500;
    color: #2c3e50;
    transition: all 0.15s ease;
}

.dropdown-item:hover {
    background: #f0faf3 !important;
    color: #1a5e2a !important;
}

.dropdown-item.text-danger:hover {
    background: #fef2f2 !important;
    color: #dc2626 !important;
}

/* =====================================================
   CONTENT OFFSET
===================================================== */
#content {
    margin-left: var(--sb-width);
    margin-top: var(--nb-height);
    padding: 20px;
}
</style>
