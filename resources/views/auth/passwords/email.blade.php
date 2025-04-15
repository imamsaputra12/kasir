<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background: url('{{ asset('assets/img/kasir1.jpg') }}') no-repeat center center/cover;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            position: relative;
        }

        .card.show {
            opacity: 1;
        }

        .card-header {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            font-size: 1.5rem;
        }

        .card-body {
            background: rgba(255, 255, 255, 0.6);
            padding: 40px;
            border-radius: 15px;
        }

        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            width: 100%;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            font-weight: bold;
            border-radius: 50px;
            padding: 12px;
            width: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }

        .back-to-login {
            display: block;
            text-align: center;
            color: #667eea;
            font-weight: bold;
            text-decoration: none;
            margin-top: 10px;
        }

        .back-to-login:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card" id="forgotPasswordCard">
                    <div class="card-header">{{ __('Forgot Password') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email" class="fw-bold">{{ __('Enter Your Email') }}</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Send Password Reset Link') }}</button>
                            </div>
                        </form>
                        <a href="{{ route('login') }}" class="back-to-login">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            document.getElementById('forgotPasswordCard').classList.add("show");
        };
    </script>

</body>
</html>