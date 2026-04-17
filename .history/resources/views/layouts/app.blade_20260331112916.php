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

    <style>
        .navbar-nav .nav-link {
             transition: 0.3s;
                }

                .navbar-nav .nav-link:hover {
                    color: #198754 !important;
                    transform: translateY(-2px);
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
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
                    <div class="container">

                        <a class="navbar-brand fw-bold text-success" href="{{ route('user.home') }}">
                            GREEN VIEW
                        </a>

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarUser">
                            <span class="navbar-toggler-icon"></span>
                        </button>

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
</style>
