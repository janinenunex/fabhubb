@extends('layouts.customer')

@section('title', 'Services')

@section('content')
<div class="mb-12">
    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">FabLab Services</h1>
    <p class="text-gray-600 dark:text-gray-400 mt-2">Browse and order our professional fabrication services</p>
</div>

@if ($services->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($services as $service)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-32"></div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $service->name }}</h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                        {{ $service->description }}
                    </p>

                    <div class="mb-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">Price per Unit</p>
                        <p class="text-3xl font-bold text-blue-600">${{ number_format($service->price, 2) }}</p>
                    </div>

                    <form action="{{ route('customer.placeOrder') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        
                        <div>
                            <label for="quantity_{{ $service->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Quantity
                            </label>
                            <input 
                                type="number" 
                                id="quantity_{{ $service->id }}" 
                                name="quantity" 
                                value="1" 
                                min="1" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                required
                            >
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            Order Now
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Services Available</h3>
        <p class="text-gray-600 dark:text-gray-400">Check back soon for new services!</p>
    </div>
@endif
@endsection
