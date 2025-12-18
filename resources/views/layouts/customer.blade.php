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
        <nav class="bg-primary-900 text-white shadow-xl border-b border-primary-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 text-2xl font-bold text-accent-400 hover:text-accent-300 transition-colors duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>FabHub</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group {{ request()->routeIs('customer.dashboard') ? 'bg-accent-400 text-primary-900 font-semibold shadow-lg' : 'text-gray-200 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('customer.dashboard') ? '' : 'group-hover:scale-110' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>My Dashboard</span>
                        </a>
                        <a href="{{ route('customer.services') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group {{ request()->routeIs('customer.services') ? 'bg-accent-400 text-primary-900 font-semibold shadow-lg' : 'text-gray-200 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('customer.services') ? '' : 'group-hover:scale-110' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span>Services</span>
                        </a>
                        @if (auth()->user()?->isAdmin())
                            <div class="h-6 w-px bg-primary-700 mx-2"></div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-200 hover:bg-primary-800 hover:text-white transition-all duration-200 group">
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Admin Panel</span>
                            </a>
                        @endif
                        <div class="h-6 w-px bg-primary-700 mx-2"></div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-200 hover:bg-red-600 hover:text-white transition-all duration-200 group">
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
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