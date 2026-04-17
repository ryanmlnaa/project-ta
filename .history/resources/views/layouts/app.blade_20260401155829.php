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

                <body id="page-top">


                    <!-- Page Wrapper -->
                    <div id="wrapper">

                            @if(auth()->check())
                            @if(auth()->user()->role == 'admin')
                                @include('components.sidebar')
                            @endif
                        @endif

                        <!-- Content Wrapper -->
                        <div id="content-wrapper" class="d-flex flex-column">

                            <!-- Main Content -->
                            <div id="content">

                                <!-- Topbar -->
                                @if(auth()->check() && auth()->user()->role == 'user')
                <nav class="navbar navbar-expand-lg navbar-light bg-success shadow-sm mb-4">
                    <div class="container">

                                <a class="navbar-brand fw-bold logo-text d-flex align-items-center"
                        href="{{ route('user.home') }}">

                            <i class="fas fa-leaf me-2"></i>

                            GREEN VIEW
                        </a>

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarUser">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarUser">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.home') }}">
                                        <i class="fas fa-home"></i> Beranda
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.rumah') }}">
                                        <i class="fas fa-building"></i> Rumah
                                    </a>
                                </li>

                                {{-- 🔥 DROPDOWN IURAN --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="iuranDropdown"
                                    role="button" data-toggle="dropdown">
                                        <i class="fas fa-wallet"></i> Iuran
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('user.iuran') }}">
                                            Lihat Data Iuran
                                        </a>
                                        <a class="dropdown-item" href="{{ route('user.upload.pembayaran') }}">
                                            Upload Pembayaran
                                        </a>
                                        <a class="dropdown-item" href="{{ route('user.status.pembayaran') }}">
                                            Status Pembayaran
                                        </a>
                                    </div>
                                </li>

                                {{-- 🔥 DROPDOWN PENGADUAN --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="pengaduanDropdown"
                                    role="button" data-toggle="dropdown">
                                        <i class="fas fa-comments"></i> Pengaduan
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('user.pengaduan') }}">
                                            Buat Pengaduan
                                        </a>
                                        <a class="dropdown-item" href="{{ route('user.status.pengaduan') }}">
                                            Status Pengaduan
                                        </a>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.pengumuman') }}">
                                        <i class="fas fa-bullhorn"></i> Pengumuman
                                    </a>
                                </li>

                            </ul>

                          <ul class="navbar-nav d-flex flex-row align-items-center gap-3">

                                {{-- PROFILE --}}
                                <li class="nav-item">
                                    <a href="{{ route('user.profil') }}" class="nav-link d-flex align-items-center gap-2">
                                        <img src="{{ auth()->user()->photo
                                        ? asset('profile/' . auth()->user()->photo)
                                        : 'https://i.pravatar.cc/150?img=3' }}"
                                        class="avatar">

                                        <span>{{ auth()->user()->name }}</span>
                                    </a>
                                </li>

                                {{-- LOGOUT --}}
                                <li class="nav-item d-flex align-items-center">
                                    <form action="{{ route('logout') }}" method="POST" class="m-0 d-flex align-items-center">
                                        @csrf
                                        <button type="submit" class="btn btn-link nav-link logout-btn p-0 d-flex align-items-center">
                                            <i class="fas fa-sign-out-alt fa-lg"></i>
                                        </button>
                                    </form>
                                </li>

                            </ul>

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

    @yield('scripts')

</body>

</html>

<style>
.nav-link {
    transition: all 0.3s ease;
}

.nav-link:hover {
    transform: scale(1.1);
    color: #0d6efd !important;
}

.nav-link i {
    display: block;
    margin-bottom: 5px;
}

.navbar-nav .nav-link {
    font-weight: 500;
    padding: 8px 14px;
}

.dropdown-menu {
    border-radius: 10px;
}

.dropdown-item:hover {
    background-color: #198754;
    color: white;
}

.logo-text {
    color: #000 !important; /* hitam biar kontras */
    letter-spacing: 1px;
    font-size: 18px;
}

.logo-text i {
    margin-right: 6px;
}

.logo-text:hover {
    color: #ffc107 !important;
}

.user-nav {
    color: #fff;
    font-weight: 500;
    transition: 0.3s;
}

.user-nav:hover {
    color: #e0f7f1;
    transform: scale(1.05);
}

.username {
    font-size: 14px;
}

.logout-btn {
    color: #fff;
    transition: 0.3s;
}

.logout-btn:hover {
    color: #ffdddd;
    transform: scale(1.1);
}

.user-nav i {
    background: rgba(255,255,255,0.2);
    padding: 6px;
    border-radius: 50%;
}

.logout-btn {
    line-height: 1;
}

.navbar img {
    border: 2px solid #fff;
}
</style>
