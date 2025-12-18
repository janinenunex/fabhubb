@extends('layouts.customer')

@section('title', 'Order Details')

@section('content')
<div class="mb-8">
    <a href="{{ route('customer.dashboard') }}" class="text-accent-600 hover:text-accent-700">&larr; Back to Dashboard</a>
    <h1 class="text-3xl font-bold text-primary-900 mt-4">Order #{{ $order->id }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-accent-50 rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-primary-900 mb-4">Order Information</h2>
            
            <div class="space-y-4">
                <div>
                    <p class="text-gray-600 text-sm">Service Name</p>
                    <p class="text-lg font-semibold text-primary-900">{{ $order->service->name }}</p>
                </div>

                <div>
                    <p class="text-gray-600 text-sm">Service Description</p>
                    <p class="text-gray-700">{{ $order->service->description }}</p>
                </div>

                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200">
                    <div>
                        <p class="text-gray-600 text-sm">Price per Unit</p>
                        <p class="text-lg font-semibold text-primary-900">${{ number_format($order->service->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Quantity</p>
                        <p class="text-lg font-semibold text-primary-900">{{ $order->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total Price</p>
                        <p class="text-2xl font-bold text-accent-600">${{ number_format($order->getTotalPrice(), 2) }}</p>
                    </div>
                </div>
                
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-primary-900 mb-2">Contact Information</h3>
                    <p class="text-gray-600 text-sm">Name: <span class="text-gray-800 font-medium">{{ $order->contact_name ?? $order->user->name }}</span></p>
                    <p class="text-gray-600 text-sm">Email: <span class="text-gray-800 font-medium">{{ $order->contact_email ?? $order->user->email }}</span></p>
                    <p class="text-gray-600 text-sm">Phone: <span class="text-gray-800 font-medium">{{ $order->contact_phone ?? '—' }}</span></p>
                </div>

                @if(!empty($order->notes))
                    <div class="pt-4">
                        <h3 class="text-sm font-semibold text-primary-900 mb-2">Notes</h3>
                        <p class="text-gray-700">{{ $order->notes }}</p>
                    </div>
                @endif

                @if(!empty($order->files) && is_array($order->files))
                    <div class="pt-4">
                        <h3 class="text-sm font-semibold text-primary-900 mb-2">Uploaded Files</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($order->files as $file)
                                <li><a target="_blank" rel="noopener" href="{{ asset('storage/' . $file) }}" class="text-accent-500 hover:underline">{{ basename($file) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Timeline section (keep your original code) -->
        <div class="bg-accent-50 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-primary-900 mb-4">Order Timeline</h2>
            <!-- Your existing timeline code here -->
        </div>
    </div>

    <div>
        <div class="bg-accent-50 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-primary-900 mb-4">Status</h2>
            
            <div class="mb-6">
                <span class="px-6 py-3 text-xl font-bold rounded-full {{ $order->getStatusBadgeClass() }}">
                    {{ $order->status }}
                </span>
            </div>

            <!-- Rest of sidebar (keep your original code) -->
        </div>
    </div>
</div>
@endsection