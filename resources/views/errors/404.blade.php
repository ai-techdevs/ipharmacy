<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found | iPharmacy</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.jpg') }}" type="image/x-icon">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 6s ease-in-out infinite;
        }

        body::before {
            width: 400px;
            height: 400px;
            background: #00b4d8;
            top: -100px;
            left: -100px;
        }

        body::after {
            width: 500px;
            height: 500px;
            background: #0077b6;
            bottom: -150px;
            right: -150px;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .error-wrapper {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 40px 20px;
        }

        .error-code {
            font-size: clamp(100px, 20vw, 180px);
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #00b4d8, #0077b6, #48cae4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.85; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 50px 60px;
            max-width: 580px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(0, 180, 216, 0.25), rgba(0, 119, 182, 0.25));
            border: 1px solid rgba(0, 180, 216, 0.35);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: spin-slow 8s linear infinite;
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .icon-box i {
            font-size: 34px;
            color: #48cae4;
            animation: spin-slow 8s linear infinite reverse;
        }

        .error-title {
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .error-message {
            color: rgba(255, 255, 255, 0.6);
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 36px;
        }

        .divider {
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, #00b4d8, #0077b6);
            border-radius: 4px;
            margin: 20px auto 30px;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 119, 182, 0.45);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 119, 182, 0.65);
            color: #ffffff;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            font-weight: 500;
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.12);
            margin-left: 12px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            color: rgba(255, 255, 255, 0.85);
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.06);
        }

        .dots {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .dot {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 180, 216, 0.15);
            animation: floatDot linear infinite;
        }

        @keyframes floatDot {
            0%   { transform: translateY(0) rotate(0deg); opacity: 0.6; }
            100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
        }
    </style>
</head>

<body>

    <div class="dots">
        <div class="dot" style="width:10px;height:10px;top:20%;left:15%;animation-duration:7s;"></div>
        <div class="dot" style="width:6px;height:6px;top:60%;left:80%;animation-duration:9s;animation-delay:2s;"></div>
        <div class="dot" style="width:14px;height:14px;top:80%;left:30%;animation-duration:11s;animation-delay:1s;"></div>
        <div class="dot" style="width:8px;height:8px;top:10%;left:70%;animation-duration:8s;animation-delay:3s;"></div>
        <div class="dot" style="width:5px;height:5px;top:40%;left:90%;animation-duration:6s;animation-delay:4s;"></div>
    </div>

    <div class="error-wrapper">
        <div class="error-code">404</div>

        <div class="glass-card">
            <div class="icon-box">
                <i class="fas fa-compass"></i>
            </div>

            <h1 class="error-title">Page Not Found</h1>
            <div class="divider"></div>
            <p class="error-message">
                Oops! The page you are looking for doesn't exist or has been moved.
                Please check the URL or return to the homepage.
            </p>

            <div>
                <a href="{{ url('/') }}" class="btn-home" id="btn-go-home">
                    <i class="fas fa-home"></i>
                    Go to Homepage
                </a>
                <a href="javascript:history.back()" class="btn-back" id="btn-go-back">
                    <i class="fas fa-arrow-left"></i>
                    Go Back
                </a>
            </div>
        </div>
    </div>

</body>
</html>
