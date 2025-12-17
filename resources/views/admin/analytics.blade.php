@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-white">Analytics Dashboard</h1>
    <p class="text-gray-300 mt-2">Track revenue, popular services, and order trends</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
    <!-- Monthly Revenue Chart -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-white mb-6">Monthly Revenue (Last 12 Months)</h2>
        <canvas id="revenueChart" height="200"></canvas>
    </div>

    <!-- Daily Orders Chart -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-white mb-6">Daily Orders (Last 30 Days)</h2>
        <canvas id="ordersChart" height="200"></canvas>
    </div>
</div>

<!-- Popular Services + Export Button -->
<div class="bg-primary-800 rounded-xl shadow-xl p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Most Popular Services</h2>
        <a href="{{ route('admin.orders.export') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg">
            Export Orders to CSV
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-white">
            <thead class="bg-primary-700">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-medium text-primary-300">Rank</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-primary-300">Service</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-primary-300">Orders</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-primary-300">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-700">
                @forelse($popularServices as $index => $service)
                    <tr class="hover:bg-primary-700/50">
                        <td class="px-6 py-4 text-lg font-bold text-primary-400">#{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium">{{ $service->name }}</td>
                        <td class="px-6 py-4">{{ $service->count }}</td>
                        <td class="px-6 py-4 font-semibold">${{ number_format($service->revenue, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">No orders yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: @json($revenueLabels),
            datasets: [{
                label: 'Revenue ($)',
                data: @json($revenueData),
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#e0e0e0' } } },
            scales: {
                y: { ticks: { color: '#e0e0e0' }, grid: { color: '#374151' } },
                x: { ticks: { color: '#e0e0e0' }, grid: { color: '#374151' } }
            }
        }
    });

    new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels: @json($orderDates),
            datasets: [{
                label: 'Orders',
                data: @json($orderCounts),
                backgroundColor: '#0284c7'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#e0e0e0' } } },
            scales: {
                y: { ticks: { color: '#e0e0e0' }, grid: { color: '#374151' } },
                x: { ticks: { color: '#e0e0e0' }, grid: { color: '#374151' } }
            }
        }
    });
});
</script>
@endsection