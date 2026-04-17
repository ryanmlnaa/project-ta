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

    @php
    $isExpired = false;

    if(auth()->check()){
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

        @endif

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @if(auth()->check() && auth()->user()->role == 'user')
                            <nav class="navbar navbar-expand-lg navbar-modern fixed-top">

                                <div class="container">

                                    {{-- LOGO --}}
                                    <a class="navbar-brand fw-bold logo-text d-flex align-items-center"
                                        href="{{ route('user.home') }}">
                                        <i class="fas fa-leaf me-2"></i>
                                        GREEN VIEW
                                    </a>

                                    {{-- TOGGLE --}}
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarUser">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>

                                    {{-- MENU --}}
                                    <div class="collapse navbar-collapse" id="navbarUser">

                                        <ul class="navbar-nav mx-auto">

                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}"
                                                    href="{{ route('user.home') }}">
                                                    <i class="fas fa-home"></i>
                                                    <span>Beranda</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('user.rumah') ? 'active' : '' }}"
                                                    href="{{ route('user.rumah') }}">
                                                    <i class="fas fa-building"></i>
                                                    <span>Rumah</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('user.iuran.*') ? 'active' : '' }}"
                                                    href="{{ route('user.iuran.index') }}">
                                                    <i class="fas fa-wallet"></i>
                                                    <span>Iuran</span>
                                                </a>
                                            </li>

                                            {{-- DROPDOWN --}}
                                            <li class="nav-item dropdown">

                                                @if($isExpired)

                                                    {{-- ❌ KONTRAK HABIS --}}
                                                    <a class="nav-link text-muted" href="#"
                                                        onclick="alert('Kontrak Anda telah berakhir')" style="pointer-events:none;">
                                                        <i class="fas fa-comments"></i>
                                                        <span>Pengaduan</span>
                                                    </a>

                                                @else

                                                    {{-- ✅ MASIH AKTIF --}}
                                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('user.layanan.*') ? 'active' : '' }}"
                                                        href="#" data-toggle="dropdown">
                                                        <i class="fas fa-comments"></i>
                                                        <span>Pengaduan</span>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-modern">
                                                        <a class="dropdown-item" href="{{ route('user.layanan.create') }}">
                                                            ✍️ Buat Pengaduan
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('user.layanan.status') }}">
                                                            📊 Status Pengaduan
                                                        </a>
                                                    </div>

                                                @endif

                                            </li>

                                            {{-- <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('user.pengumuman') ? 'active' : '' }}"
                                                    href="{{ route('user.pengumuman') }}">
                                                    <i class="fas fa-bullhorn"></i>
                                                    <span>Pengumuman</span>
                                                </a>
                                            </li> --}}

                                        </ul>
                                        <button id="darkToggle" class="btn btn-sm ms-2">
                                            🌙
                                        </button>

                                        {{-- PROFILE --}}
                                        <ul class="navbar-nav align-items-center">

                                            <li class="nav-item">
                                                <a href="{{ route('user.profil') }}" class="nav-link d-flex align-items-center">
                                                    <img src="{{ auth()->user()->photo
                    ? asset('profile/' . auth()->user()->photo)
                    : 'https://i.pravatar.cc/50?img=3' }}" class="avatar-navbar-premium">

                                                    <span class="ms-2 username-nav">
                                                        {{ auth()->user()->name }}
                                                    </span>
                                                </a>
                                            </li>

                                            {{-- LOGOUT --}}
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

    @yield('scripts')

    <div class="mobile-nav d-lg-none">
        <a href="{{ route('user.home') }}"><i class="fas fa-home"></i></a>
        <a href="{{ route('user.iuran.index') }}"><i class="fas fa-wallet"></i></a>
        <a href="{{ route('user.layanan.create') }}"><i class="fas fa-plus"></i></a>
        <a href="{{ route('user.layanan.status') }}"><i class="fas fa-list"></i></a>
    </div>

</body>

</html>

<style>
    /* ========================= */
    /* 🔥 NAVBAR PREMIUM FINAL */
    /* ========================= */
    .navbar-modern {
        background: linear-gradient(135deg, #4f46e5, #6366f1, #06b6d4);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        border-radius: 0 0 20px 20px;
        backdrop-filter: blur(10px);
        transition: 0.3s;
        z-index: 9999;
    }

    /* DARK MODE NAVBAR */
    body.dark .navbar-modern {
        background: linear-gradient(135deg, #020617, #1e293b, #334155);
    }

    /* NAV LINK */
    .navbar-modern .nav-link {
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 13px;
        color: #e0f2fe !important;
        font-weight: 500;
    }

    .navbar-modern .nav-link i {
        font-size: 16px;
        margin-bottom: 4px;
        color: #bae6fd;
    }

    .navbar-modern .nav-link:hover {
        transform: translateY(-3px) scale(1.05);
        color: #ffffff !important;
    }

    .navbar-modern .nav-link.active {
        color: #facc15 !important;
        font-weight: 600;
    }

    /* LOGO */
    .logo-text {
        color: #ffffff !important;
        font-weight: 700;
        letter-spacing: 1px;
        font-size: 18px;
        transition: 0.3s;
    }

    .logo-text:hover {
        color: #facc15 !important;
        transform: scale(1.05);
    }

    /* USER */
    .username-nav {
        color: #ffffff;
        font-size: 13px;
    }

    /* AVATAR */
    .avatar-navbar-premium {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ffffff;
        transition: 0.3s;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
    }

    .avatar-navbar-premium:hover {
        transform: scale(1.1);
    }

    /* LOGOUT */
    .btn-logout {
        color: #ffffff;
        transition: 0.3s;
    }

    .btn-logout:hover {
        color: #f87171;
        transform: scale(1.2);
    }

    /* ========================= */
    /* DROPDOWN */
    /* ========================= */
    .dropdown-menu {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border: none;
        padding: 8px;
    }

    .dropdown-item {
        border-radius: 8px;
        transition: 0.3s;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        color: white;
    }

    /* ========================= */
    /* CARD */
    /* ========================= */
    .card {
        border-radius: 14px;
        transition: 0.3s;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
    }

    /* ========================= */
    /* BUTTON */
    /* ========================= */
    .btn {
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    /* ========================= */
    /* TABLE */
    /* ========================= */
    .table {
        border-radius: 12px;
        overflow: hidden;
    }

    .table tbody tr:hover {
        background: #f9fafb;
    }

    /* ========================= */
    /* ALERT */
    /* ========================= */
    .alert {
        animation: slideFade 0.5s ease;
    }

    @keyframes slideFade {
        from {
            opacity: 0;
            transform: translateX(40px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* ========================= */
    /* MOBILE NAV */
    /* ========================= */
    .mobile-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        display: flex;
        justify-content: space-around;
        padding: 12px;
        box-shadow: 0 -5px 25px rgba(0, 0, 0, 0.08);
        z-index: 999;
    }

    .mobile-nav a {
        color: #6b7280;
        font-size: 20px;
        transition: 0.3s;
    }

    .mobile-nav a:hover {
        color: #4f46e5;
        transform: scale(1.2);
    }

    /* ========================= */
    /* 🌙 DARK MODE */
    /* ========================= */
    body.dark {
        background: #020617;
        color: #e2e8f0;
    }

    /* CARD */
    body.dark .card {
        background: #020617;
        color: #e2e8f0;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* TEXT */
    body.dark p {
        color: #e2e8f0 !important;
    }

    body.dark small {
        color: #cbd5f5;
    }

    body.dark .text-muted {
        color: #cbd5f5 !important;
    }

    /* 🔥 FIX JUDUL (PENTING) */
    body.dark h3,
    body.dark h4,
    body.dark h5 {
        color: #ffffff !important;
        font-weight: 600;
        text-shadow: 0 0 10px rgba(96, 165, 250, 0.2);
    }

    body.dark h4 i {
        color: #60a5fa;
    }

    /* DROPDOWN */
    body.dark .dropdown-menu {
        background: #1e293b;
        color: #e2e8f0;
    }

    body.dark .dropdown-item:hover {
        background: #3b82f6;
        color: white;
    }

    /* BADGE */
    body.dark .bg-success {
        background: #16a34a !important;
    }

    body.dark .bg-warning {
        background: #eab308 !important;
        color: black !important;
    }

    body.dark .bg-secondary {
        background: #475569 !important;
    }

    /* TABLE */
    body.dark .table tbody tr:hover {
        background: #334155;
    }

    /* INPUT */
    body.dark input,
    body.dark textarea,
    body.dark select {
        background: #1e293b;
        color: white;
        border: 1px solid #334155;
    }

    /* TIMELINE */
    body.dark .timeline-step {
        background: #334155;
    }

    body.dark .timeline-step.active {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: white;
    }

    body.dark .timeline-line {
        background: #475569;
    }

    /* ========================= */
    /* BODY */
    /* ========================= */
    body {
        scroll-behavior: smooth;
        background: #f9fafb;
    }

    /* ========================= */
    /* 🔥 FIX NAVBAR KETIMPA */
    /* ========================= */
    .user-mode #content {
        margin-top: 100px;
        /* sesuaikan tinggi navbar */
    }

    /* RESPONSIVE MOBILE */
    @media (max-width: 768px) {
        .user-mode #content {
            margin-top: 120px;
        }
    }
</style>

<script>
    setTimeout(() => {
        $('.alert').fadeOut('slow');
    }, 3000);

</script>

<script>
    const toggle = document.getElementById("darkToggle");

    toggle.addEventListener("click", () => {
        document.body.classList.toggle("dark");

        localStorage.setItem("darkMode",
            document.body.classList.contains("dark"));
    });

    if (localStorage.getItem("darkMode") === "true") {
        document.body.classList.add("dark");
    }
</script>
