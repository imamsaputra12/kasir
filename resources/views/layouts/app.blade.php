<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #4A00E0, #8E2DE2);
            padding: 10px 20px;
        }
        .navbar-custom .navbar-brand {
            font-weight: bold;
            color: #fff;
            font-size: 1.5rem;
        }
        .navbar-custom .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: 0.3s;
        }
        .navbar-custom .nav-link:hover {
            color: #ffdd57 !important;
        }
        .btn-auth {
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-login {
            background: #ffdd57;
            color: #000;
        }
        .btn-register {
            background: #ff5733;
            color: #fff;
        }
        .btn-auth:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <!-- Branding -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-code"></i> {{ config('app.name', 'Laravel') }}
                </a>

                <!-- Toggle button for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @if (Auth::guest())
                            <li class="nav-item">
                                <a class="nav-link btn-auth btn-login me-2" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-auth btn-register" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>