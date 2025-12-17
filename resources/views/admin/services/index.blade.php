@extends('layouts.admin')

@section('title', 'Service Management')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-4xl font-bold text-primary-900">Service Management</h1>
        <p class="text-gray-500 mt-2">Manage your fabrication lab services</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="bg-accent-400 hover:bg-accent-500 text-primary-900 font-bold py-3 px-6 rounded-lg transition shadow-lg">
        + Add New Service
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Stats Cards -->
    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Total Services</p>
                <p class="text-4xl font-bold mt-2">{{ $services->count() }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-4">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Available</p>
                <p class="text-4xl font-bold mt-2 text-success-400">{{ $services->where('status', 'Available')->count() }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-4">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-primary-800 rounded-xl shadow-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-300 text-sm">Unavailable</p>
                <p class="text-4xl font-bold mt-2 text-danger-400">{{ $services->where('status', 'Unavailable')->count() }}</p>
            </div>
            <div class="bg-accent-400 rounded-full p-4">
                <svg class="w-10 h-10 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Services Table -->
<div class="mt-12 bg-white rounded-xl shadow-xl overflow-hidden"> <!-- White outer box -->
    <div class="p-6 border-b border-gray-200 bg-accent-50"> <!-- Light cream header -->
        <h2 class="text-2xl font-bold text-primary-900">All Services</h2>
    </div>

    <table class="w-full">
        <thead class="bg-primary-900"> <!-- Dark navy thead -->
            <tr>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Name</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Description</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Price</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Materials</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white"> <!-- White/light rows -->
            @forelse ($services as $service)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $service->name }}</td>
                    <td class="px-6 py-4 text-gray-700 max-w-md">{{ Str::limit($service->description, 100) }}</td>
                    <td class="px-6 py-4 font-semibold text-accent-400">${{ number_format($service->price, 2) }} <span class="text-sm text-gray-500">per unit</span></td>
                    <td class="px-6 py-4 text-gray-700">
                        @if($service->materials)
                            <span class="text-sm">{{ $service->materials }}</span>
                        @else
                            <span class="text-gray-500 italic">No materials specified</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-4 py-2 text-sm font-bold rounded-full {{ $service->getStatusBadgeClass() }}">
                            {{ $service->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 space-x-3">
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-accent-400 hover:text-accent-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-danger-400 hover:text-danger-300" onclick="return confirm('Delete this service?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.322 2.322 0 0116.138 21H7.862a2.322 2.322 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        No services yet. <a href="{{ route('admin.services.create') }}" class="text-accent-400 hover:underline">Add the first one</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection