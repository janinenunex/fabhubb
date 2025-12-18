@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-primary-900">Dashboard</h1>
    <p class="text-lg text-gray-500 mt-2">Welcome back! Here's what's happening with your FabHub system.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <!-- Total Orders -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Total Orders</p>
                <p class="text-4xl font-bold mt-2">{{ $totalOrders ?? 10 }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-5">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Pending Orders</p>
                <p class="text-4xl font-bold mt-2">{{ $pendingOrders ?? 6 }}</p>
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
                <p class="text-4xl font-bold mt-2">{{ $completedOrders ?? 3 }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-5">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Services -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Total Services</p>
                <p class="text-4xl font-bold mt-2">{{ $totalServices ?? 8 }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-5">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Total Customers</p>
                <p class="text-4xl font-bold mt-2">{{ $totalUsers ?? 1 }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-5">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Monthly Revenue Chart -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 lg:col-span-2">
        <h2 class="text-xl font-bold text-white mb-4">Monthly Revenue</h2>
        <canvas id="revenueChart" height="150"></canvas>
    </div>

    <!-- Order Status Distribution (Donut Chart) -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6">
        <h2 class="text-xl font-bold text-white mb-4">Order Status Distribution</h2>
        <canvas id="statusChart" height="150"></canvas>
    </div>
</div>

<!-- Most Popular Services - White box with light cream header -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Most Popular Services -->
    <div class="bg-white rounded-xl shadow-xl overflow-hidden">
        <div class="bg-accent-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-primary-900">Most Popular Services</h2>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-primary-900">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-white">Rank</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-white">Service</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-white">Orders</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-white">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($popularServices as $service)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm font-bold text-accent-400">#{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-medium text-gray-900">{{ $service->name }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $service->count }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-900">${{ number_format($service->revenue, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-400">No orders yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Service Availability (moved here) -->
    <div class="bg-white rounded-xl shadow-xl overflow-hidden">
        <div class="bg-accent-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-primary-900">Service Availability</h2>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-primary-900">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-white">Service Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-white">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-white">Price</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($allServices as $service)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $service->name }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-4 py-2 text-sm font-bold rounded-full {{ $service->getStatusBadgeClass() }}">{{ $service->status }}</span>
                            </td>
                            <td class="px-4 py-2 font-semibold text-gray-900">${{ number_format($service->price ?? 0, 2) }}</td>
                        </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-center text-gray-400">No services available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Users & Recent Orders Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-xl overflow-hidden">
        <div class="bg-accent-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-primary-900">Recent Users</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-primary-900">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-white">Name</th>
                        <th class="px-4 py-3 text-left font-medium text-white">Email</th>
                        <th class="px-4 py-3 text-left font-medium text-white">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($recentUsers as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-700 whitespace-nowrap text-xs">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-700 whitespace-nowrap text-xs">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-400">
                                No recent users.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-xl overflow-hidden">
        <div class="bg-accent-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-primary-900">Recent Orders</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-primary-900">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-white">Order</th>
                        <th class="px-4 py-3 text-left font-medium text-white">Customer</th>
                        <th class="px-4 py-3 text-left font-medium text-white">Service</th>
                        <th class="px-4 py-3 text-left font-medium text-white">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">#{{ $order->id }}</td>
                            <td class="px-4 py-3 text-gray-700 whitespace-nowrap text-xs">{{ $order->user->name }}</td>
                            <td class="px-4 py-3 text-gray-700 whitespace-nowrap text-xs">{{ $order->service->name }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-1 text-xs font-bold rounded {{ $order->getStatusBadgeClass() }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                                No recent orders.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Charts Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Wait for Chart to be available
    const initCharts = () => {
        if (typeof window.Chart === 'undefined') {
            setTimeout(initCharts, 100);
            return;
        }

        // Monthly Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new window.Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($revenueLabels ?? []),
                    datasets: [{
                        label: 'Revenue ($)',
                        data: @json($revenueData ?? []),
                        borderColor: '#fbbf24',
                        backgroundColor: 'rgba(251, 191, 36, 0.2)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { labels: { color: '#e0e0e0' } }
                    },
                    scales: {
                        y: { ticks: { color: '#e0e0e0' }, grid: { color: '#374151' } },
                        x: { ticks: { color: '#e0e0e0' }, grid: { color: '#374151' } }
                    }
                }
            });
        }

        // Order Status Distribution (Donut Chart)
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            const statusData = @json($statusDistribution ?? []);
            new window.Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Processing', 'Completed', 'Cancelled'],
                    datasets: [{
                        data: [statusData.Pending ?? 0, statusData.Processing ?? 0, statusData.Completed ?? 0, statusData.Cancelled ?? 0],
                        backgroundColor: [
                            '#fbbf24', // Pending - Yellow
                            '#3b82f6', // Processing - Blue
                            '#10b981', // Completed - Green
                            '#ef4444'  // Cancelled - Red
                        ],
                        borderColor: '#1e293b',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: '#e0e0e0', padding: 20 }
                        }
                    }
                }
            });
        }
    };

    initCharts();
});
</script>
@endsection