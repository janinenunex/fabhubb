@extends('layouts.customer')

@section('title', 'Services')

@section('content')
<div class="mb-12">
    <h1 class="text-4xl font-bold text-primary-900">FabLab Services</h1>
    <p class="text-gray-600 mt-2">Browse and order our professional fabrication services</p>
</div>

@if ($services->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($services as $service)
            <div class="bg-primary-800 rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow">
                <!-- Gradient Header -->
                <div class="bg-gradient-to-r from-accent-600 to-accent-800 h-40"></div>
                
                <div class="p-8 text-white">
                    <h3 class="text-2xl font-bold mb-3">{{ $service->name }}</h3>
                    
                    <p class="text-gray-400 text-base mb-6 line-clamp-3">
                        {{ $service->description }}
                    </p>

                    <div class="mb-8 pt-6 border-t border-primary-700">
                        <p class="text-white text-sm mb-2">Price per Unit</p>
                        <p class="text-4xl font-bold text-white">${{ number_format($service->price, 2) }}</p>
                    </div>

                    <form action="{{ route('customer.placeOrder') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        
                        <div>
                            <label for="quantity_{{ $service->id }}" class="block text-sm font-medium text-primary-300 mb-2">
                                Quantity
                            </label>
                            <input 
                                type="number" 
                                id="quantity_{{ $service->id }}" 
                                name="quantity" 
                                value="1" 
                                min="1" 
                                class="w-full px-5 py-3 bg-primary-700/50 border border-primary-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent-500"
                                required
                            >
                        </div>

                        <button type="submit" class="w-full bg-accent-400 hover:bg-accent-500 text-primary-900 font-bold py-4 px-6 rounded-lg transition shadow-lg">
                            Order Now
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-primary-800 rounded-xl shadow-xl p-16 text-center">
        <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="text-2xl font-bold text-primary-900 mb-3">No Services Available</h3>
        <p class="text-gray-500 text-lg">Check back soon for new services!</p>
    </div>
@endif
@endsection