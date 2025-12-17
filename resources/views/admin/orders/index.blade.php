@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-primary-900">Orders</h1>
    <p class="text-gray-500 mt-2">Manage all customer orders.</p>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-xl shadow-xl overflow-hidden"> <!-- White outer box -->
    <div class="p-6 border-b border-gray-200 bg-accent-50"> <!-- Light cream header -->
        <h2 class="text-2xl font-bold text-primary-900">All Orders</h2>
    </div>

    <table class="w-full">
        <thead class="bg-primary-900"> <!-- Dark navy thead -->
            <tr>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Order ID</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Customer</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Service</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Quantity</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Total Price</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Date</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white"> <!-- White/light rows -->
            @forelse ($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->user->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->service->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->quantity }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-accent-400">${{ number_format($order->getTotalPrice(), 2) }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block px-6 py-3 text-sm font-bold rounded-full min-w-[140px] {{ $order->getStatusBadgeClass() }}">
                            @if($order->status === 'Ready for Pickup')
                                Ready for<br>Pickup
                            @else
                                {{ $order->status }}
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-accent-400 hover:text-accent-300">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                        No orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-6 border-t border-gray-200 bg-gray-50">
        {{ $orders->links() }}
    </div>
</div>
@endsection