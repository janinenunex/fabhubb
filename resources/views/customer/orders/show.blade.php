@extends('layouts.customer')

@section('title', 'Order Details')

@section('content')
<div class="mb-8">
    <a href="{{ route('customer.dashboard') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Dashboard</a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-4">Order #{{ $order->id }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Information</h2>
            
            <div class="space-y-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Service Name</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->service->name }}</p>
                </div>

                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Service Description</p>
                    <p class="text-gray-700 dark:text-gray-300">{{ $order->service->description }}</p>
                </div>

                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Price per Unit</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($order->service->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Quantity</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Total Price</p>
                        <p class="text-2xl font-bold text-blue-600">${{ number_format($order->getTotalPrice(), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Timeline</h2>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Order Placed</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-10 w-10 rounded-full {{ $order->status === 'Completed' ? 'bg-green-100 dark:bg-green-900' : 'bg-gray-200 dark:bg-gray-700' }}">
                            <svg class="h-6 w-6 {{ $order->status === 'Completed' ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $order->status === 'Completed' ? 'Order Completed' : 'Waiting for Processing' }}
                        </p>
                        @if ($order->status === 'Completed')
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->updated_at->format('M d, Y \a\t h:i A') }}</p>
                        @else
                            <p class="text-sm text-gray-600 dark:text-gray-400">In progress</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Status</h2>
            
            <div class="mb-6">
                <span class="px-4 py-2 inline-flex text-lg leading-5 font-semibold rounded-full {{ $order->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ $order->status }}
                </span>
            </div>

            @if ($order->status === 'Pending')
                <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                    <p class="text-sm text-yellow-800 dark:text-yellow-100">
                        <strong>Status:</strong> Your order is being processed. We'll notify you when it's ready!
                    </p>
                </div>
            @else
                <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4">
                    <p class="text-sm text-green-800 dark:text-green-100">
                        <strong>Status:</strong> Your order is complete. You can pick it up or arrange delivery.
                    </p>
                </div>
            @endif

            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Order ID</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">#{{ $order->id }}</p>
            </div>

            <div class="mt-4">
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Placed On</p>
                <p class="text-gray-900 dark:text-white font-semibold">{{ $order->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
