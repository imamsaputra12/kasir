<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Utama</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', 'Raleway', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            text-align: center;
            color: #333;
        }
        .header {
            background: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
            color: white;
            padding: 20px;
            font-size: 24px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            display: flex;
            align-items: center;
            font-weight: 700;
        }
        .logo i {
            margin-right: 10px;
            font-size: 28px;
        }
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: url('') no-repeat center center/cover;
            z-index: -1;
            filter: brightness(0.7) contrast(1.1);
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.7) 0%, rgba(58, 12, 163, 0.7) 100%);
            z-index: -1;
        }
        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            z-index: 2;
            color: white;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
            padding: 20px;
        }
        .title {
            font-size: 72px;
            font-weight: bold;
            margin-bottom: 20px;
            background: linear-gradient(to right, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: none;
            animation: fadeIn 1.5s ease-in-out;
        }
        .subtitle {
            font-size: 24px;
            margin-bottom: 40px;
            max-width: 600px;
            line-height: 1.5;
            animation: slideUp 1s ease-in-out 0.5s both;
        }
        .button-container {
            border: none;
            padding: 30px 50px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            display: inline-block;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out 1s both;
            backdrop-filter: blur(10px);
        }
        .links {
            margin-top: 10px;
            display: flex;
            gap: 20px;
        }
        .links a {
            color: #3a0ca3;
            padding: 15px 35px;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            border: 2px solid #3a0ca3;
            border-radius: 50px;
            transition: all 0.3s ease;
            margin: 5px;
            display: inline-block;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .links a:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(135deg, #3a0ca3 0%, #4361ee 100%);
            transition: all 0.3s ease;
            z-index: -1;
        }
        .links a:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .links a:hover:before {
            width: 100%;
        }
        .links a i {
            margin-right: 8px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            font-size: 14px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* Responsive styles */
        @media (max-width: 768px) {
            .title {
                font-size: 50px;
            }
            .subtitle {
                font-size: 18px;
                padding: 0 20px;
            }
            .button-container {
                padding: 20px 30px;
            }
            .links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    <div class="overlay"></div>
    <div class="header">
        <div class="logo">
            <i class="fas fa-cash-register"></i>
            <span>Kasir App</span>
        </div>
        <div class="nav-links">
            <span id="current-time"></span>
        </div>
    </div>
    <div class="content">
        <div class="title">Kasir App</div>
        <div class="subtitle">Solusi kasir modern untuk bisnis Anda. Mudah digunakan, cepat, dan efisien.</div>
        <div class="button-container">
            <div class="links">
                <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a>
            </div>
        </div>
    </div>
    <div class="footer">
        &copy; 2025 Kasir App - All Rights Reserved
    </div>

    <script>
        // Display current time
        function updateTime() {
            const now = new Date();
            const timeElement = document.getElementById('current-time');
            timeElement.textContent = now.toLocaleTimeString();
        }
        
        setInterval(updateTime, 1000);
        updateTime();
        
        // Add simple animation for page load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.content').style.opacity = '1';
        });
    </script>
</body>
</html>