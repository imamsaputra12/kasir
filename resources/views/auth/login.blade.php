<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.5s ease;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
        }

        .card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .card-header {
            background: linear-gradient(to right, #5a67d8, #6b46c1);
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 25px;
            font-size: 1.8rem;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .card-header:before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            pointer-events: none;
        }

        .card-body {
            padding: 40px 30px;
            background: white;
            border-radius: 0 0 20px 20px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control {
            border-radius: 50px;
            padding: 15px 25px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus {
            border-color: #6b46c1;
            box-shadow: 0 5px 15px rgba(107, 70, 193, 0.2);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            font-weight: 600;
            border-radius: 50px;
            padding: 15px;
            width: 100%;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #5a67d8, #6b46c1);
            box-shadow: 0 7px 20px rgba(102, 126, 234, 0.6);
            transform: translateY(-2px);
        }

        .forgot-password {
            display: block;
            text-align: center;
            color: #764ba2;
            font-weight: 500;
            text-decoration: none;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        .input-group {
            display: flex;
            align-items: center;
            width: 100%;
            position: relative;
        }

        .input-group-text {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .input-group .form-control {
            padding-right: 45px;
        }

        .input-group-text i {
            color: #6b46c1;
            font-size: 1.2rem;
        }

        .text-center {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .text-primary {
            color: #6b46c1;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .text-primary:hover {
            color: #5a67d8;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }

        /* Add responsive design */
        @media (max-width: 768px) {
            .card {
                max-width: 100%;
            }

            .card-body {
                padding: 30px 20px;
            }

            .form-control {
                padding: 12px 20px;
            }

            .btn-primary {
                padding: 12px;
            }
        }

        /* Animation effects */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(102, 126, 234, 0); }
            100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
        }

        .btn-primary:focus {
            animation: pulse 1.5s infinite;
        }

        #submit-loader {
        display: none;
        margin-top: 15px;
        text-align: center;
    }

    .mini-spinner {
        width: 30px;
        height: 30px;
        border: 4px solid #ddd;
        border-top: 4px solid #6b46c1;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: auto;
    }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card" id="loginCard">
                    <div class="card-header">{{ __('Login') }}</div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="form-group mb-3">
                                <label for="email" class="fw-bold">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="fw-bold">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>
                                    <span class="input-group-text" onclick="togglePassword()">
                                        <i id="toggleIcon" class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                                @endif
                            </div>
                            <!-- Tambahkan ini di dalam form (setelah tombol Login) -->
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary" onclick="showLoading()">{{ __('Login') }}</button>
                                <div id="submit-loader">
                                    <div class="mini-spinner"></div>
                                </div>
                            </div>

                        </form>
                        <a href="{{ route('password.request') }}" class="forgot-password">{{ __('Forgot Your Password?') }}</a>
                        <div class="text-center mt-3">
                            <center><span>Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold">Daftar</a></span></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var loginCard = document.getElementById('loginCard');
            setTimeout(function() {
                loginCard.classList.add("show");
            }, 100);
        };

        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggleIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>

    <!-- Update script showLoading() di bagian bawah -->
<script>
    window.onload = function() {
        var loginCard = document.getElementById('loginCard');
        var loader = document.getElementById('loader-wrapper');
        setTimeout(function() {
            loginCard.classList.add("show");
            loader.style.opacity = 0;
            setTimeout(() => loader.style.display = 'none', 300);
        }, 100);
    };

    function togglePassword() {
        var passwordField = document.getElementById("password");
        var toggleIcon = document.getElementById("toggleIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }

    function showLoading() {
        var miniLoader = document.getElementById('submit-loader');
        miniLoader.style.display = 'block';
    }
</script>

</body>
</html>