<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Green View</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/') }}sbadmin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="{{ asset('/') }}sbadmin2/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/') }}sbadmin2/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    @stack('styles')
    <style>
        .navbar-nav .nav-link {
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #198754 !important;
            transform: translateY(-2px);
        }

        .kavling-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 10px;
        }

        .kavling {
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .kosong {
            background: #28a745;
        }

        .kosong:hover {
            background: #218838;
        }

        .terisi {
            background: #dc3545;
            cursor: not-allowed;
        }

        .disabled {
            background: #ccc;
        }

        .kavling {
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            color: white;
            cursor: pointer;
        }

        .kosong {
            background: #28a745;
        }

        .kosong:hover {
            background: #218838;
        }

        .terisi {
            background: #dc3545;
            cursor: not-allowed;
        }
    </style>

</head>

<body id="page-top" class="user-mode">
    @stack('scripts')
    @php
        $isExpired = false;

        if (auth()->check()) {
            $penghuni = \App\Models\Penghuni::where('email', auth()->user()->email)->first();

            if ($penghuni && $penghuni->status_huni == 'Kontrak' && $penghuni->tanggal_keluar) {
                $isExpired = now()->gt(\Carbon\Carbon::parse($penghuni->tanggal_keluar));
            }
        }
    @endphp
    {{-- 🔔 NOTIFIKASI REALTIME --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed"
            style="top:20px; right:20px; z-index:9999; min-width:250px;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show position-fixed"
            style="top:20px; right:20px; z-index:9999; min-width:250px;">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif


    <!-- Page Wrapper -->
    <div id="wrapper">

        @if(auth()->check())

            {{-- 🔥 ADMIN --}}
            @if(auth()->user()->role == 'admin')
                @include('components.sidebar')
            @endif

            {{-- 🔥 RT --}}
            @if(auth()->user()->role == 'rt')
                @include('components.sidebar_rt')
            @endif

             {{-- 🔥 BENDAHARA --}}
            @if(auth()->user()->role == 'bendahara')
                @include('components.sidebar_bendahara')
            @endif

        @endif

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @if(auth()->check() && auth()->user()->role == 'user')
                            <nav class="navbar-pro fixed-top">
                                <div class="navbar-pro-inner">

                                    {{-- ===== KIRI: LOGO + MENU ===== --}}
                                    <div class="navbar-left">

                                        {{-- LOGO --}}
                                        <a class="navbar-pro-brand" href="{{ route('user.home') }}">
                                            <div class="brand-icon">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 3C8 3 4 7 4 11c0 2.5 1.5 4.5 3 6h10c1.5-1.5 3-3.5 3-6 0-4-4-8-8-8z"
                                                        fill="rgba(255,255,255,0.25)" />
                                                    <path d="M7 19c0-2.8 2.2-5 5-7 2.8 2 5 4.2 5 7H7z" fill="white" />
                                                    <line x1="12" y1="12" x2="12" y2="7" stroke="white" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                </svg>
                                            </div>
                                            <span class="brand-name">GREEN VIEW</span>
                                        </a>

                                        {{-- SEPARATOR --}}
                                        <div class="brand-sep"></div>

                                        {{-- MENU --}}
                                        <ul class="navbar-pro-menu">
                                            <li>
                                                <a href="{{ route('user.home') }}"
                                                    class="pro-nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}">
                                                    <i class="fas fa-home"></i>
                                                    <span>Beranda</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.rumah') }}"
                                                    class="pro-nav-link {{ request()->routeIs('user.rumah') ? 'active' : '' }}">
                                                    <i class="fas fa-building"></i>
                                                    <span>Rumah</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.iuran.index') }}"
                                                    class="pro-nav-link {{ request()->routeIs('user.iuran.*') ? 'active' : '' }}">
                                                    <i class="fas fa-wallet"></i>
                                                    <span>Iuran</span>
                                                </a>
                                            </li>
                                            <li class="has-dropdown">
                                                @if($isExpired)
                                                    <a class="pro-nav-link disabled-link" href="#"
                                                        onclick="alert('Kontrak Anda telah berakhir'); return false;">
                                                        <i class="fas fa-comments"></i>
                                                        <span>Pengaduan</span>
                                                    </a>
                                                @else
                                                    <a class="pro-nav-link {{ request()->routeIs('user.layanan.*') ? 'active' : '' }}"
                                                        href="#">
                                                        <i class="fas fa-comments"></i>
                                                        <span>Pengaduan</span>
                                                        <i class="fas fa-chevron-down chevron-icon"></i>
                                                    </a>
                                                    <div class="pro-dropdown">
                                                        <a href="{{ route('user.layanan.create') }}" class="pro-dropdown-item">
                                                            <span class="drop-emoji">✍️</span>
                                                            <div>
                                                                <div class="drop-label">Buat Pengaduan</div>
                                                                <div class="drop-sub">Kirim laporan baru</div>
                                                            </div>
                                                        </a>
                                                        <a href="{{ route('user.layanan.status') }}" class="pro-dropdown-item">
                                                            <span class="drop-emoji">📊</span>
                                                            <div>
                                                                <div class="drop-label">Status Pengaduan</div>
                                                                <div class="drop-sub">Pantau laporan Anda</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- ===== KANAN: PROFIL + LOGOUT ===== --}}
                                    <div class="navbar-right">

                                        {{-- PROFILE --}}
                                        <a href="{{ route('user.profil') }}" class="pro-profile">
                                            <div class="pro-avatar-wrap">
                                                <img src="{{ auth()->user()->photo
                    ? asset('profile/' . auth()->user()->photo)
                    : 'https://i.pravatar.cc/50?img=3' }}" class="pro-avatar" alt="Avatar">
                                                <span class="avatar-dot"></span>
                                            </div>
                                            <div class="pro-profile-info">
                                                <span class="pro-name">{{ auth()->user()->name }}</span>
                                                <span class="pro-role">Penghuni</span>
                                            </div>
                                        </a>

                                        {{-- DIVIDER --}}
                                        <div class="nav-divider"></div>

                                        {{-- LOGOUT --}}
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="pro-logout-btn" title="Logout">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </button>
                                        </form>

                                    </div>

                                    {{-- HAMBURGER MOBILE --}}
                                    <button class="hamburger" id="hamburgerBtn" onclick="toggleMobileNav()">
                                        <span></span><span></span><span></span>
                                    </button>

                                </div>

                                {{-- MOBILE DRAWER --}}
                                <div class="mobile-drawer" id="mobileDrawer">
                                    <a href="{{ route('user.home') }}"
                                        class="mobile-item {{ request()->routeIs('user.home') ? 'active' : '' }}">
                                        <i class="fas fa-home"></i> Beranda
                                    </a>
                                    <a href="{{ route('user.rumah') }}"
                                        class="mobile-item {{ request()->routeIs('user.rumah') ? 'active' : '' }}">
                                        <i class="fas fa-building"></i> Rumah
                                    </a>
                                    <a href="{{ route('user.iuran.index') }}"
                                        class="mobile-item {{ request()->routeIs('user.iuran.*') ? 'active' : '' }}">
                                        <i class="fas fa-wallet"></i> Iuran
                                    </a>
                                    @if(!$isExpired)
                                        <a href="{{ route('user.layanan.create') }}" class="mobile-item">
                                            <i class="fas fa-comments"></i> Buat Pengaduan
                                        </a>
                                        <a href="{{ route('user.layanan.status') }}" class="mobile-item">
                                            <i class="fas fa-list"></i> Status Pengaduan
                                        </a>
                                    @endif
                                    <div class="mobile-bottom-row">
                                        <a href="{{ route('user.profil') }}" class="mobile-profile-pill">
                                            <img src="{{ auth()->user()->photo
                    ? asset('profile/' . auth()->user()->photo)
                    : 'https://i.pravatar.cc/50?img=3' }}" class="mobile-avatar">
                                            <span>{{ auth()->user()->name }}</span>
                                        </a>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="mobile-logout-btn">
                                                <i class="fas fa-sign-out-alt"></i> Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </nav>
                @endif

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <x-footer />
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/') }}sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/') }}sbadmin2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/') }}sbadmin2/js/sb-admin-2.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- DataTables JS (pastikan jQuery sudah ada sebelumnya) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    @yield('scripts')

</body>

</html>

<style>
 /* ======================================== */
/* 🌿 NAVBAR PRO — GREEN GRADIENT EDITION   */
/* ======================================== */

.navbar-pro * { box-sizing: border-box; }
.navbar-pro ul { list-style: none; margin: 0; padding: 0; }
.navbar-pro a { text-decoration: none; }

.navbar-pro {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 9999;
}

.navbar-pro::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg,
        #064e3b 0%, #065f46 20%, #047857 45%, #059669 70%, #10b981 100%
    );
    box-shadow:
        0 4px 24px rgba(5,150,105,0.35),
        0 1px 0 rgba(255,255,255,0.12) inset,
        0 -1px 0 rgba(0,0,0,0.1) inset;
}

.navbar-pro::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg,
        transparent 0%, rgba(255,255,255,0.4) 30%,
        rgba(167,243,208,0.6) 50%, rgba(255,255,255,0.4) 70%, transparent 100%
    );
}

.navbar-pro-inner {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 64px;
    padding: 0 24px;
    max-width: 1600px;
    margin: 0 auto;
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 6px;
}

.navbar-pro-brand {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #fff !important;
    font-family: 'Nunito', sans-serif;
    font-weight: 900;
    font-size: 15px;
    letter-spacing: 1.8px;
    text-transform: uppercase;
    flex-shrink: 0;
    transition: all 0.2s;
}
.navbar-pro-brand:hover { opacity: 0.9; transform: translateY(-1px); }

.brand-icon {
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.2);
    border: 1.5px solid rgba(255,255,255,0.35);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    backdrop-filter: blur(4px);
    box-shadow: 0 2px 10px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.2);
    flex-shrink: 0;
    transition: 0.2s;
}
.navbar-pro-brand:hover .brand-icon { background: rgba(255,255,255,0.28); transform: rotate(-5deg) scale(1.05); }
.brand-name { color: #fff; text-shadow: 0 1px 3px rgba(0,0,0,0.2); }

.brand-sep {
    width: 1px; height: 28px;
    background: rgba(255,255,255,0.25);
    margin: 0 10px;
    flex-shrink: 0;
}

.navbar-pro-menu {
    display: flex;
    align-items: center;
    gap: 2px;
}

.pro-nav-link {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 8px 15px;
    border-radius: 10px;
    color: rgba(255,255,255,0.82) !important;
    font-size: 13.5px;
    font-weight: 600;
    font-family: 'Nunito', sans-serif;
    transition: all 0.2s ease;
    white-space: nowrap;
    position: relative;
    border: 1px solid transparent;
}
.pro-nav-link i:not(.chevron-icon) { font-size: 13px; opacity: 0.85; }
.pro-nav-link:hover {
    background: rgba(255,255,255,0.15);
    color: #ffffff !important;
    border-color: rgba(255,255,255,0.2);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.pro-nav-link.active {
    background: rgba(255,255,255,0.22);
    color: #ffffff !important;
    border-color: rgba(255,255,255,0.3);
    box-shadow: 0 4px 14px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.25);
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.chevron-icon {
    font-size: 9px !important;
    margin-left: 1px;
    opacity: 0.7;
    transition: transform 0.2s;
}
.has-dropdown:hover .chevron-icon { transform: rotate(180deg); opacity: 1; }

/* ── DROPDOWN FIX ── */
.has-dropdown {
    position: relative;
}

.has-dropdown::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    height: 16px;
    background: transparent;
    z-index: 99;
}

.pro-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    border: 1px solid rgba(5,150,105,0.15);
    border-radius: 14px;
    padding: 18px 8px 8px;
    min-width: 230px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15), 0 4px 15px rgba(5,150,105,0.1);
    opacity: 0;
    pointer-events: none;
    visibility: hidden;
    transition: opacity 0.2s ease, visibility 0.2s ease;
    z-index: 100;
    margin-top: 0;
}

.has-dropdown:hover .pro-dropdown {
    opacity: 1;
    pointer-events: auto;
    visibility: visible;
}

.pro-dropdown::before {
    content: '';
    position: absolute;
    top: 10px; left: 20px;
    width: 12px; height: 12px;
    background: #fff;
    border: 1px solid rgba(5,150,105,0.15);
    border-bottom: none; border-right: none;
    transform: rotate(45deg);
}

.pro-dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 13px;
    border-radius: 10px;
    color: #374151;
    font-size: 13.5px;
    font-family: 'Nunito', sans-serif;
    transition: all 0.2s;
}
.pro-dropdown-item:hover {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    color: #065f46;
    transform: translateX(3px);
}
.drop-emoji { font-size: 20px; flex-shrink: 0; }
.drop-label { font-weight: 700; font-size: 13.5px; color: #1f2937; }
.drop-sub { font-size: 11.5px; color: #6b7280; margin-top: 1px; }
.pro-dropdown-item:hover .drop-label { color: #065f46; }

/* ── KANAN ── */
.navbar-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.nav-divider {
    width: 1px; height: 30px;
    background: rgba(255,255,255,0.25);
}

.pro-profile {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px 14px 5px 5px;
    border-radius: 50px;
    background: rgba(255,255,255,0.15);
    border: 1.5px solid rgba(255,255,255,0.25);
    transition: all 0.2s;
    color: #fff !important;
    backdrop-filter: blur(4px);
}
.pro-profile:hover {
    background: rgba(255,255,255,0.25);
    border-color: rgba(255,255,255,0.4);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    color: #fff !important;
}

.pro-avatar-wrap { position: relative; flex-shrink: 0; }
.pro-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    border: 2px solid rgba(255,255,255,0.5);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.avatar-dot {
    position: absolute;
    bottom: 1px; right: 1px;
    width: 10px; height: 10px;
    background: #fde047;
    border-radius: 50%;
    border: 2px solid rgba(6,95,70,0.8);
    box-shadow: 0 0 6px rgba(253,224,71,0.6);
}

.pro-profile-info { display: flex; flex-direction: column; line-height: 1.2; }
.pro-name {
    font-size: 13px; font-weight: 700; color: #fff;
    font-family: 'Nunito', sans-serif;
    max-width: 110px; overflow: hidden;
    text-overflow: ellipsis; white-space: nowrap;
    text-shadow: 0 1px 2px rgba(0,0,0,0.15);
}
.pro-role {
    font-size: 10px; color: #a7f3d0;
    font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
}

.pro-logout-btn {
    width: 38px; height: 38px;
    border-radius: 10px;
    border: 1.5px solid rgba(255,255,255,0.25);
    background: rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.85);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    transition: all 0.2s;
    backdrop-filter: blur(4px);
}
.pro-logout-btn:hover {
    background: rgba(239,68,68,0.25);
    border-color: rgba(252,165,165,0.5);
    color: #fca5a5;
    transform: scale(1.08);
    box-shadow: 0 4px 14px rgba(239,68,68,0.3);
}

/* ── HAMBURGER ── */
.hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    cursor: pointer;
    padding: 8px;
}
.hamburger span {
    display: block;
    width: 20px; height: 2px;
    background: rgba(255,255,255,0.9);
    border-radius: 2px;
    transition: 0.3s;
}

/* ── MOBILE DRAWER ── */
.mobile-drawer {
    display: none;
    flex-direction: column;
    gap: 3px;
    padding: 10px 16px 16px;
    position: relative;
    background: linear-gradient(180deg, #047857, #065f46);
    border-top: 1px solid rgba(255,255,255,0.1);
}
.mobile-drawer.open { display: flex; }

.mobile-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 10px;
    color: rgba(255,255,255,0.82);
    font-size: 14px;
    font-family: 'Nunito', sans-serif;
    font-weight: 600;
    transition: all 0.2s;
    border: 1px solid transparent;
}
.mobile-item i { width: 18px; text-align: center; color: #6ee7b7; }
.mobile-item:hover,
.mobile-item.active {
    background: rgba(255,255,255,0.15);
    color: #fff;
    border-color: rgba(255,255,255,0.15);
}

.mobile-bottom-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 4px 4px;
    margin-top: 8px;
    border-top: 1px solid rgba(255,255,255,0.15);
    gap: 10px;
}

.mobile-profile-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.9);
    font-size: 13px;
    font-family: 'Nunito', sans-serif;
    font-weight: 700;
}
.mobile-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,0.4);
}

.mobile-logout-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    border: 1px solid rgba(252,165,165,0.4);
    background: rgba(239,68,68,0.15);
    color: #fca5a5;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Nunito', sans-serif;
    cursor: pointer;
    transition: 0.2s;
}
.mobile-logout-btn:hover { background: rgba(239,68,68,0.3); color: #fff; }

/* ── CONTENT OFFSET ── */
.user-mode #content { margin-top: 64px; }

@media (max-width: 768px) {
    .user-mode #content { margin-top: 64px; }
}

@media (max-width: 992px) {
    .navbar-pro-menu,
    .navbar-right { display: none; }
    .hamburger { display: flex; }
}
</style>

<script>
    setTimeout(() => {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>

<script>
    // Dark Toggle
    const toggle = document.getElementById("darkToggle");
    if (toggle) {
        toggle.addEventListener("click", () => {
            document.body.classList.toggle("dark");
            const isDark = document.body.classList.contains("dark");
            localStorage.setItem("darkMode", isDark);
            toggle.querySelector('.dark-icon').textContent = isDark ? '☀️' : '🌙';
        });
        if (localStorage.getItem("darkMode") === "true") {
            document.body.classList.add("dark");
            toggle.querySelector('.dark-icon').textContent = '☀️';
        }
    }

    // Hamburger Mobile
    function toggleMobileNav() {
        const drawer = document.getElementById('mobileDrawer');
        drawer.classList.toggle('open');
    }
</script>
