@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.orders.index') }}" class="text-accent-600 hover:text-accent-700">&larr; Back to Orders</a>
    <h1 class="text-4xl font-bold text-primary-900 mt-4">Order #{{ $order->id }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left: Order Info -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-accent-50 rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-primary-900 mb-6">Order Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">
                <div>
                    <p class="text-primary-300 text-sm">Customer Name</p>
                    <p class="text-xl font-semibold">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-primary-300 text-sm">Customer Email</p>
                    <p class="text-xl font-semibold">{{ $order->user->email }}</p>
                </div>
                    <div>
                        <p class="text-primary-300 text-sm">Contact Name</p>
                        <p class="text-xl font-semibold">{{ $order->contact_name ?? $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-primary-300 text-sm">Contact Email</p>
                        <p class="text-xl font-semibold">{{ $order->contact_email ?? $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-primary-300 text-sm">Contact Phone</p>
                        <p class="text-xl font-semibold">{{ $order->contact_phone ?? '—' }}</p>
                    </div>
                <div>
                    <p class="text-primary-300 text-sm">Service</p>
                    <p class="text-xl font-semibold">{{ $order->service->name }}</p>
                </div>
                <div>
                    <p class="text-primary-300 text-sm">Quantity</p>
                    <p class="text-xl font-semibold">{{ $order->quantity }}</p>
                </div>
                <div>
                    <p class="text-primary-300 text-sm">Price per Unit</p>
                    <p class="text-xl font-semibold">${{ number_format($order->service->price, 2) }}</p>
                </div>
                <div>
                    <p class="text-primary-300 text-sm">Total Price</p>
                    <p class="text-3xl font-bold text-accent-600">${{ number_format($order->getTotalPrice(), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-accent-50 rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-primary-900 mb-6">Service Details</h2>
            <p class="text-gray-700 text-lg leading-relaxed">{{ $order->service->description }}</p>

            @if(!empty($order->notes))
                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-primary-900 mb-2">Notes</h3>
                    <p class="text-gray-700">{{ $order->notes }}</p>
                </div>
            @endif

            @if(!empty($order->files) && is_array($order->files))
                <div class="mt-6">
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

    <!-- Right: Status Panel -->
    <div>
        <div class="bg-accent-50 rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-primary-900 mb-10 text-center">Current Status</h2>

            <div class="text-center mb-12">
                <span class="inline-block px-12 py-6 text-3xl font-bold rounded-full {{ $order->getStatusBadgeClass() }}">
                    {{ $order->status }}
                </span>
            </div>

            @if($order->getNextStatus())
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="{{ $order->getNextStatus() }}">
                    <button type="submit" class="w-full py-6 text-2xl font-bold text-primary-900 rounded-lg shadow-lg transition bg-accent-400 hover:bg-accent-500">
                        → Mark as {{ $order->getNextStatus() }}
                    </button>
                </form>
            @else
                <div class="text-center py-8">
                    <p class="text-3xl font-bold text-success-600">Order Completed! 🎉</p>
                </div>
            @endif

            <div class="mt-12 pt-8 border-t border-gray-300 text-center">
                <p class="text-primary-300 text-sm mb-2">Created On</p>
                <p class="text-primary-900 font-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                <p class="text-primary-300 text-sm mt-6 mb-2">Last Updated</p>
                <p class="text-primary-900 font-semibold">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection