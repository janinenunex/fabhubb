<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - FabHub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-accent-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-primary-900 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold text-accent-400">
                            FabHub
                        </a>
                    </div>

                    <div class="flex items-center gap-8">
                        <a href="{{ route('customer.dashboard') }}" class="hover:text-accent-300 {{ request()->routeIs('customer.dashboard') ? 'text-accent-300 font-semibold' : '' }}">
                            My Dashboard
                        </a>
                        <a href="{{ route('customer.services') }}" class="hover:text-accent-300 {{ request()->routeIs('customer.services') ? 'text-accent-300 font-semibold' : '' }}">
                            Services
                        </a>
                        @if (auth()->user()?->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-accent-300">
                                Admin Panel
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-accent-300">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 bg-accent-50">
            @if ($message = Session::get('success'))
                <div class="mb-6 p-4 bg-success-100 border border-success-300 text-success-700 rounded-lg">
                    {{ $message }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-danger-100 border border-danger-300 text-danger-700 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="bg-primary-900 text-white py-6 mt-auto">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} FabHub - FabLab Online Service System. All rights reserved.</p>
            </div>
        </footer>
    </div>
        @stack('scripts')
</body>
</html>