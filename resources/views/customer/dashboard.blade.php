@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-primary-900">Welcome, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-500 mt-2">Manage your orders and services</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <!-- Total Orders -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Total Orders</p>
                <p class="text-3xl font-bold mt-2">{{ $orderStats['total'] }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-5">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Pending Orders</p>
                <p class="text-3xl font-bold mt-2">{{ $orderStats['pending'] }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-5">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Completed Orders -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Completed Orders</p>
                <p class="text-3xl font-bold mt-2">{{ $orderStats['completed'] }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-5">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- My Orders Table -->
<div class="bg-white rounded-xl shadow-xl overflow-hidden">
    <div class="p-6 border-b border-gray-200 bg-accent-50 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-primary-900">My Orders</h2>
        <a href="{{ route('customer.services') }}" class="bg-accent-400 hover:bg-accent-500 text-primary-900 font-bold py-3 px-6 rounded-lg transition">
            + Place New Order
        </a>
    </div>

    @if($orders->count() > 0)
        <table class="w-full">
            <thead class="bg-primary-900">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Order ID</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Service</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->service->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->quantity }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">${{ number_format($order->getTotalPrice(), 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-4 py-2 text-sm font-bold rounded-full {{ $order->getStatusBadgeClass() }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('customer.orders.show', $order) }}" class="text-accent-500 hover:text-accent-400">
                                View Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-6 border-t border-gray-200 bg-gray-50">
            {{ $orders->links() }}
        </div>
    @else
        <div class="p-16 text-center">
            <p class="text-gray-500 text-xl mb-6">No orders yet.</p>
            <a href="{{ route('customer.services') }}" class="text-accent-500 hover:text-accent-400 text-lg underline">
                Browse Services
            </a>
        </div>
    @endif
</div>
@endsection