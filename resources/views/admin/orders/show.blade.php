@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Orders</a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-4">Order #{{ $order->id }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Information</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Customer Name</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Customer Email</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Service</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->service->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Quantity</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->quantity }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Price per Unit</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($order->service->price, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Price</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($order->getTotalPrice(), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Service Details</h2>
            <p class="text-gray-700 dark:text-gray-300">{{ $order->service->description }}</p>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Status</h2>
            
            <div class="mb-6">
                <span class="px-4 py-2 inline-flex text-lg leading-5 font-semibold rounded-full {{ $order->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ $order->status }}
                </span>
            </div>

            @if ($order->status === 'Pending')
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="Completed">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                        Mark as Completed
                    </button>
                </form>
            @else
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="Pending">
                    <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg">
                        Mark as Pending
                    </button>
                </form>
            @endif

            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <p class="text-gray-600 dark:text-gray-400 text-sm">Created On</p>
                <p class="text-gray-900 dark:text-white font-semibold">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
            </div>

            <div class="mt-4">
                <p class="text-gray-600 dark:text-gray-400 text-sm">Last Updated</p>
                <p class="text-gray-900 dark:text-white font-semibold">{{ $order->updated_at->format('M d, Y \a\t h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
