@if(auth()->user()->role == 'bendahara')
<nav class="navbar-admin">

    <div class="nav-left">
        <button class="nav-hamburger" id="sidebarToggle" aria-label="Toggle sidebar">
            <span></span><span></span><span></span>
        </button>
        <div class="nav-page-indicator"></div>
        <span class="nav-title">
            @if(request()->routeIs('bendahara.iuran.*'))
                Data Iuran
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
            <i class="fas fa-wallet"></i><span>Data Iuran</span>
        </a>
    </li>

    <li class="sa-item {{ request()->routeIs('bendahara.rekap.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('bendahara.rekap.index') }}">
            <i class="fas fa-file-invoice-dollar"></i><span>Rekap Iuran</span>
        </a>
    </li>

    <li class="sa-item {{ request()->routeIs('bendahara.kas.*') ? 'active' : '' }}">
        <a class="sa-link" href="{{ route('bendahara.kas.index') }}">
            <i class="fas fa-coins"></i><span>Kas Bendahara</span>
        </a>
    </li>

</ul>

<style>
:root {
    --sa-bg:      #064e3b;
    --sa-hover:   rgba(255,255,255,0.10);
    --sa-active:  rgba(255,255,255,0.15);
    --sa-border:  rgba(255,255,255,0.08);
    --sa-text:    rgba(255,255,255,0.72);
    --sa-width:   230px;
    --na-height:  62px;
    --na-bg:      #ffffff;
}

body { margin: 0; padding: 0; overflow-x: hidden; }

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
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
}
.sidebar-admin-ul::-webkit-scrollbar { display: none; }

.sidebar-brand { display: flex; align-items: center; gap: 12px; padding: 22px 20px 18px; }
.sidebar-brand-icon {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.13);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #fff; flex-shrink: 0;
}
.sidebar-brand-text-wrap { display: flex; flex-direction: column; line-height: 1.15; flex: 1; }
.sidebar-brand-name { font-size: 13.5px; font-weight: 800; color: #fff; letter-spacing: 0.6px; }
.sidebar-brand-sub  { font-size: 9.5px; color: rgba(255,255,255,0.45); font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; }

.sidebar-close {
    display: none;
    background: rgba(255,255,255,0.12);
    border: none; color: #fff;
    width: 30px; height: 30px;
    border-radius: 8px; cursor: pointer;
    font-size: 14px; align-items: center; justify-content: center;
    flex-shrink: 0; transition: background 0.2s;
    position: absolute; top: 16px; right: 16px;
}
.sidebar-close:hover { background: rgba(255,255,255,0.22); }

.sa-divider { height: 1px; background: var(--sa-border); margin: 10px 16px; flex-shrink: 0; }

.sa-section {
    font-size: 10px; font-weight: 700;
    color: rgba(255,255,255,0.38);
    letter-spacing: 1.1px; text-transform: uppercase;
    padding: 8px 20px 6px; flex-shrink: 0;
}

.sa-item { list-style: none; margin: 6px 10px; flex-shrink: 0; box-sizing: border-box; }

.sa-link {
    display: flex; align-items: center; gap: 10px;
    padding: 13px 14px; border-radius: 10px;
    color: var(--sa-text) !important;
    font-size: 13.5px; font-weight: 500;
    text-decoration: none !important;
    transition: all 0.2s ease;
    background: transparent; border: none;
    width: 100%; box-sizing: border-box;
    text-align: left; cursor: pointer; line-height: 1;
}
.sa-link i { font-size: 14px; width: 18px; text-align: center; flex-shrink: 0; opacity: 0.85; }
.sa-link:hover { background: var(--sa-hover); color: #fff !important; transform: translateX(3px); }

.sa-item.active .sa-link {
    background: rgba(255,255,255,0.18) !important;
    color: #fff !important;
    font-weight: 700;
    border-left: 3px solid rgba(255,255,255,0.75);
    padding-left: 11px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.18);
    border-radius: 10px;
}
.sa-item.active .sa-link i { opacity: 1; }

.sidebar-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 999; opacity: 0;
    transition: opacity 0.3s ease;
    backdrop-filter: blur(2px);
}
.sidebar-overlay.active { display: block; opacity: 1; }

.navbar-admin {
    position: fixed;
    top: 0; left: var(--sa-width); right: 0;
    height: var(--na-height);
    background: var(--na-bg);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 24px; z-index: 999;
    border-bottom: 1px solid #eef1ee;
    box-shadow: 0 1px 12px rgba(0,0,0,0.06);
    transition: left 0.3s cubic-bezier(0.4,0,0.2,1);
}

.nav-hamburger {
    display: none; flex-direction: column; gap: 5px;
    background: none; border: none; cursor: pointer;
    padding: 6px; border-radius: 8px; margin-right: 8px;
    flex-shrink: 0; -webkit-tap-highlight-color: transparent;
}
.nav-hamburger span { display: block; width: 22px; height: 2px; background: #1a2e22; border-radius: 2px; transition: all 0.25s ease; }
.nav-hamburger:hover { background: #f0f4f1; }
.nav-hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.nav-hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.nav-hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

.navbar-admin .nav-left  { display: flex; align-items: center; gap: 12px; }
.navbar-admin .nav-page-indicator { width: 4px; height: 22px; background: linear-gradient(180deg,#064e3b,#10b981); border-radius: 3px; }
.navbar-admin .nav-title { font-size: 15px; font-weight: 700; color: #1a2e22; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px; }
.navbar-admin .nav-right { display: flex; align-items: center; gap: 6px; }
.navbar-admin .nav-divider-v { width: 1px; height: 28px; background: #e8ede9; margin: 0 6px; }

.navbar-admin .nav-profile {
    display: flex; align-items: center; gap: 9px; cursor: pointer;
    padding: 5px 10px 5px 6px; border-radius: 12px;
    border: 1px solid #e8ede9; background: #f9faf9;
    transition: all 0.2s ease;
}
.navbar-admin .nav-profile:hover { background: #e8f4eb; border-color: #c8e0cc; }
.navbar-admin .nav-avatar-wrap { position: relative; flex-shrink: 0; }
.navbar-admin .nav-avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #d0e8d5; display: block; }
.navbar-admin .avatar-status { position: absolute; bottom: 1px; right: 1px; width: 8px; height: 8px; border-radius: 50%; background: #22c55e; border: 1.5px solid #fff; }
.navbar-admin .nav-user-info { display: flex; flex-direction: column; line-height: 1.25; }
.navbar-admin .nav-name { font-size: 13px; font-weight: 700; color: #1a2e22; white-space: nowrap; }
.navbar-admin .nav-role { font-size: 11px; color: #888; font-weight: 500; white-space: nowrap; }
.navbar-admin .nav-arrow { font-size: 10px; color: #aaa; margin-left: 2px; transition: transform 0.2s ease; }
.navbar-admin .nav-profile[aria-expanded="true"] .nav-arrow { transform: rotate(180deg); }

.navbar-admin .dropdown-menu {
    animation: dropIn 0.2s ease;
    border-radius: 14px !important;
    border: 1px solid #e8ede9 !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    padding: 6px; min-width: 200px; margin-top: 6px !important;
}
@keyframes dropIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }
.navbar-admin .dropdown-user-header { display: flex; align-items: center; gap: 10px; padding: 10px 12px 12px; }
.navbar-admin .duh-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #d0e8d5; flex-shrink: 0; }
.navbar-admin .duh-name { font-size: 13.5px; font-weight: 700; color: #1a2e22; line-height: 1.2; }
.navbar-admin .duh-role { font-size: 11.5px; color: #888; font-weight: 500; }
.navbar-admin .dropdown-divider { margin: 4px 0; border-color: #f0f4f1; }
.navbar-admin .dropdown-item { border-radius: 8px; font-size: 13px; padding: 8px 12px; font-weight: 500; color: #2c3e50; transition: all 0.15s ease; }
.navbar-admin .dropdown-item:hover { background: #f0faf3 !important; color: #1a6e3a !important; }
.navbar-admin .dropdown-item.text-danger:hover { background: #fef2f2 !important; color: #dc2626 !important; }

#content-wrapper {
    margin-left: var(--sa-width) !important;
    width: calc(100% - var(--sa-width)) !important;
    min-height: 100vh;
    display: flex; flex-direction: column; overflow-x: hidden;
    transition: margin-left 0.3s cubic-bezier(0.4,0,0.2,1), width 0.3s cubic-bezier(0.4,0,0.2,1);
}

#content {
    margin-left: 0 !important;
    margin-top: var(--na-height) !important;
    padding: 20px; width: 100%; box-sizing: border-box; flex: 1;
}

@media (max-width: 768px) {
    .sidebar-admin-ul { transform: translateX(-100%); z-index: 1050; width: 260px; box-shadow: 6px 0 32px rgba(0,0,0,0.28); }
    .sidebar-admin-ul.sidebar-open { transform: translateX(0); }
    .sidebar-close { display: flex; }
    .navbar-admin { left: 0; }
    .nav-hamburger { display: flex; }
    .navbar-admin .nav-user-info { display: none; }
    .navbar-admin .nav-divider-v { display: none; }
    .navbar-admin .nav-profile { padding: 5px 8px; gap: 6px; }
    .navbar-admin .nav-title { font-size: 14px; max-width: 150px; }
    #content-wrapper { margin-left: 0 !important; width: 100% !important; }
    #content { padding: 14px; }
    .sa-link { padding: 15px 14px; font-size: 14px; }
}

@media (max-width: 400px) {
    .sidebar-admin-ul { width: 240px; }
    .navbar-admin .nav-title { font-size: 13px; max-width: 120px; }
}

@media (min-width: 769px) {
    .sidebar-admin-ul { transform: translateX(0) !important; }
    .sidebar-overlay  { display: none !important; }
    .sidebar-close    { display: none !important; }
    .nav-hamburger    { display: none !important; }
}
</style>

<script>
(function () {
    var sidebar   = document.getElementById('sidebarMain');
    var overlay   = document.getElementById('sidebarOverlay');
    var toggleBtn = document.getElementById('sidebarToggle');
    var closeBtn  = document.getElementById('sidebarClose');

    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('sidebar-open');
        if (overlay) { overlay.style.display = 'block'; setTimeout(function(){ overlay.classList.add('active'); }, 10); }
        if (toggleBtn) toggleBtn.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('sidebar-open');
        if (overlay) { overlay.classList.remove('active'); setTimeout(function(){ overlay.style.display = 'none'; }, 300); }
        if (toggleBtn) toggleBtn.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (closeBtn)  closeBtn.addEventListener('click', closeSidebar);
    if (overlay)   overlay.addEventListener('click', closeSidebar);

    if (sidebar) {
        sidebar.querySelectorAll('.sa-link').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) closeSidebar();
            });
        });
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) closeSidebar();
    });
})();
</script>
