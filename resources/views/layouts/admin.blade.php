<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- SB ADMIN STYLE -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- FONT -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CUSTOM -->
    <link rel="stylesheet" href="{{ asset('css/template.css') }}">
</head>

<body id="page-top">

<<div id="wrapper">

    @include('components.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            @include('components.topbar')

            <div class="container-fluid">
                @yield('content')
            </div>

        </div>

    </div>

</div>

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>

@stack('scripts')

</body>
</html>
