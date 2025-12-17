<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - FabHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #0F2A71 0%, #001740 100%);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Solid professional card */
        .login-card {
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
            border: none;
            box-shadow: 0 18px 40px rgba(2,6,23,0.35);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .login-card:hover { transform: translateY(-4px); box-shadow: 0 26px 60px rgba(2,6,23,0.38); }

        /* Form area */
        .col-md-6.p-5 { color: #07213a; }
        h2 { color: #07213a; font-size: 34px; }
        .text-muted { color: rgba(7,33,58,0.6) !important; }

        /* Inputs */
        .form-control {
            border-radius: 8px;
            border: 1px solid #e6e9ef;
            background: #ffffff;
            color: #07213a;
            font-size: 15px;
            padding: 12px 14px;
        }
        .form-control:focus {
            border-color: rgba(30,90,168,0.9);
            box-shadow: 0 8px 30px rgba(30,90,168,0.08);
            outline: none;
        }

        /* Button */
        .btn-signin {
            background: linear-gradient(90deg,#1e5aa8 0%, #164282 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.6px;
            box-shadow: 0 10px 30px rgba(22,66,130,0.22);
        }
        .btn-signin:hover { transform: translateY(-2px); box-shadow: 0 14px 40px rgba(22,66,130,0.26); }

        /* Logo section */
        .logo-section {
            background: #f8fafc;
            display:flex; align-items:center; justify-content:center;
        }
        .logo-section img {
            max-width: 800px;
            width: 110%;
            height: 450px;
            border-radius: 10px;
            box-shadow: 0 18px 48px rgba(2,6,23,0.18);
            border: 6px solid white;
            background: white;
        }

        @media (max-width: 1200px) {
            .card.login-card { max-width: 900px; }
        }

        @media (max-width: 992px) {
            .logo-section img { max-width: 420px; width: 85%; border-width:6px; }
            .card.login-card { max-width: 720px; }
        }

        /* Small helpers */
        .form-label { font-size: 12px; letter-spacing: 0.5px; color: rgba(7,33,58,0.65); }
    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100 px-2 py-4">
        <div class="card login-card" style="width:100%;max-width:900px;">
            <div class="row g-0">
                <!-- Form Column -->
                <div class="col-md-6 p-5">
                    <h2 class="fw-bold mb-2">Welcome Back</h2>
                    <p class="text-muted mb-4">Sign in to your CTU FabLab account</p>

                @if ($errors->any())
                    <div class="mb-3 alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold text-uppercase">✉ Email Address</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold text-uppercase">🔒 Password</label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-signin btn-lg text-white">
                            ➜ SIGN IN
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-dark">Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Create Account</a></p>
                </div>
                </div>

                <!-- Logo Column -->
                <div class="col-md-6 logo-section d-flex flex-column align-items-center justify-content-center p-5">
                    <div class="text-center">
                        <!-- Image Logo -->
                        <img src="{{ asset('images/fablab-logo.jpg') }}" alt="CTU DANAO" class="img-fluid mb-4 rounded shadow-lg">
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
