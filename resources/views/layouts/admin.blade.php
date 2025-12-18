<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - FabHub Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-accent-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-primary-900 text-white shadow-xl border-b border-primary-700">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-2xl font-bold text-accent-400 hover:text-accent-300 transition-colors duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>FabHub Admin</span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-200 hover:bg-primary-800 hover:text-white transition-all duration-200 group">
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>View as Customer</span>
                        </a>
                        <div class="h-6 w-px bg-primary-700"></div>
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

        <!-- Sidebar & Content -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div class="w-64 bg-primary-900 text-white shadow-xl relative">
                <nav class="p-6 space-y-3">
                    <a href="{{ route('admin.dashboard') }}" class="relative flex items-center gap-3 px-4 py-3.5 rounded-lg transition-all duration-300 ease-in-out {{ request()->routeIs('admin.dashboard') ? 'bg-accent-400 text-primary-900 font-semibold shadow-lg' : 'text-gray-200 hover:bg-primary-800 hover:text-white hover:shadow-md' }} group overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-accent-400 transform {{ request()->routeIs('admin.dashboard') ? 'scale-y-100' : 'scale-y-0 group-hover:scale-y-100' }} transition-transform duration-300"></div>
                        <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 {{ request()->routeIs('admin.dashboard') ? '' : 'group-hover:scale-110' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="text-sm font-medium relative z-10">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="relative flex items-center gap-3 px-4 py-3.5 rounded-lg transition-all duration-300 ease-in-out {{ request()->routeIs('admin.services.*') ? 'bg-accent-400 text-primary-900 font-semibold shadow-lg' : 'text-gray-200 hover:bg-primary-800 hover:text-white hover:shadow-md' }} group overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-accent-400 transform {{ request()->routeIs('admin.services.*') ? 'scale-y-100' : 'scale-y-0 group-hover:scale-y-100' }} transition-transform duration-300"></div>
                        <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 {{ request()->routeIs('admin.services.*') ? '' : 'group-hover:scale-110' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span class="text-sm font-medium relative z-10">Service Management</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="relative flex items-center gap-3 px-4 py-3.5 rounded-lg transition-all duration-300 ease-in-out {{ request()->routeIs('admin.orders.*') ? 'bg-accent-400 text-primary-900 font-semibold shadow-lg' : 'text-gray-200 hover:bg-primary-800 hover:text-white hover:shadow-md' }} group overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-accent-400 transform {{ request()->routeIs('admin.orders.*') ? 'scale-y-100' : 'scale-y-0 group-hover:scale-y-100' }} transition-transform duration-300"></div>
                        <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 {{ request()->routeIs('admin.orders.*') ? '' : 'group-hover:scale-110' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span class="text-sm font-medium relative z-10">Order Management</span>
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 p-8 bg-accent-50">
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
        </div>
    </div>
    @stack('scripts')
</body>
</html>