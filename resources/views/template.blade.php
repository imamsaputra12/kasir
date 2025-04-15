<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kasir</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .navbar {
            background-color: #007bff !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            color: #fff !important;
            font-weight: bold;
        }

        .navbar-nav .nav-item {
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease-in-out;
        }

        .navbar-nav .nav-item:hover {
            border-bottom: 2px solid #0a0a0a;
            background-color: rgba(0, 123, 255, 0.1);
        }

        .navbar-nav .nav-item .nav-link {
            color: #f8f9fa !important;
            font-weight: 600;
            padding: 15px 20px;
            transition: all 0.3s ease-in-out;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #ffffff !important;
            transform: translateX(3px);
        }

        .navbar-toggler-icon {
            background-color: #ffffff !important;
        }

        .user-avatar-md {
            width: 35px;
            height: 35px;
            object-fit: cover;
        }

        .container {
            margin-top: 80px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="index.html">Kasir</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                </li>
                @can('admin')
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('pelanggans.index') }}">
                        <i class="fas fa-users mr-2"></i> Pelanggan
                    </a>
                </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('produks.index') }}">
                        <i class="fas fa-box mr-2"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('penjualans.index') }}">
                        <i class="fas fa-shopping-cart mr-2"></i> Penjualan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('laporans.index') }}">
                        <i class="fas fa-chart-line mr-2"></i> Laporan
                    </a>
                </li>

            </ul>

            <!-- Form Pencarian -->
            <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                <input class="form-control mr-sm-2" type="search" name="query" placeholder="Search" required>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- User Dropdown -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/images/avatar-1.jpg') }}" alt="User" class="user-avatar-md rounded-circle" style="width: 35px; height: 35px; margin-right: 8px;">
                        <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('account.show') }}">Account</a>
                        <a class="dropdown-item" href="#">Setting</a>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); 
                            if(confirm('Apakah Anda yakin ingin logout?')) 
                            document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- Scripts -->
   <!-- Sertakan jQuery dan Bootstrap dari CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/libs/js/main-js.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/morris-bundle/morris.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    <script src="{{ asset('assets/libs/js/dashboard-ecommerce.js') }}"></script>
</body>

</html>