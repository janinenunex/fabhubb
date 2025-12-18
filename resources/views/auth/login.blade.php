<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - CTU FabLab</title>

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
<body class="bg-primary-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-3xl"> <!-- Reduced from max-w-4xl -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
            <!-- Left: Login Form - reduced padding -->
            <div class="w-full md:w-1/2 p-8"> <!-- Reduced from p-12 -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-primary-900">Welcome Back</h1>
                    <p class="text-primary-600 mt-2 text-sm">Sign in to your CTU FabLab account</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-3 bg-danger-100 border border-danger-300 text-danger-700 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-primary-700 mb-1.5">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-primary-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Enter your email address"
                            required
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-primary-700 mb-1.5">
                            Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            class="w-full px-4 py-3 bg-gray-50 border border-primary-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Enter your password"
                            required
                        >
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <span class="ml-2 text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-primary-600 hover:text-primary-700">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3.5 px-6 rounded-lg transition shadow-md flex items-center justify-center">
                        Sign In
                    </button>

                    <p class="text-center text-sm text-gray-600 mt-5">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Create Account</a>
                    </p>
                </form>
            </div>

            <!-- Right: Logo & Branding -->
            <div class="hidden md:flex w-full md:w-1/2 bg-white items-center justify-center p-8">
                <div class="text-center">
                    <div class="mb-8">
                        <img src="{{ asset('images/fablab-logo.jpg') }}" alt="CTU Danao FabLab Logo" class="mx-auto mb-6" style="max-width: 280px; height: auto; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>