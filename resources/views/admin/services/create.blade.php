@extends('layouts.admin')

@section('title', 'Create Service')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-primary-900">Create Service</h1>
    <p class="text-gray-500 mt-2">Add a new FabLab service.</p>
</div>

<div class="max-w-2xl">
    <div class="bg-accent-50 rounded-lg shadow-lg p-8">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <div class="mb-8">
                <label for="name" class="block text-sm font-medium text-accent-400 mb-2">Service Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    class="w-full px-5 py-4 bg-accent-100 border border-accent-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent" 
                    placeholder="e.g. 3D Printing"
                    required
                >
                @error('name')
                    <p class="text-danger-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="description" class="block text-sm font-medium text-accent-400 mb-2">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="6" 
                    class="w-full px-5 py-4 bg-accent-100 border border-accent-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent resize-none" 
                    placeholder="Describe the service in detail..."
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-danger-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-10">
                <label for="price" class="block text-sm font-medium text-accent-400 mb-2">Price per Unit</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    value="{{ old('price') }}" 
                    step="0.01" 
                    min="0" 
                    class="w-full px-5 py-4 bg-accent-100 border border-accent-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent" 
                    placeholder="0.00"
                    required
                >
                @error('price')
                    <p class="text-danger-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="bg-accent-400 hover:bg-accent-500 text-primary-900 font-bold py-3 px-8 rounded-lg transition shadow-lg"
                >
                    Create Service
                </button>
                <a 
                    href="{{ route('admin.services.index') }}" 
                    class="bg-primary-300 hover:bg-primary-400 text-primary-900 font-bold py-3 px-8 rounded-lg transition shadow-lg"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection