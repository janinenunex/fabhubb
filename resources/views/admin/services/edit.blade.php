@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<div id="editServiceModalBackdrop" class="fixed inset-0 flex items-center justify-center bg-primary-900 bg-opacity-40 backdrop-blur-sm z-50" style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); background-color: rgba(255,255,255,0.6);">
    <div class="w-full max-w-3xl mx-4">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="p-6 border-b bg-primary-900">
                <h2 class="text-2xl font-bold text-white">Edit Service</h2>
                <p class="text-primary-200 text-sm mt-1">Update service details</p>
                <a href="{{ route('admin.services.index') }}" class="absolute right-6 top-6 text-white">✕</a>
            </div>

            <form action="{{ route('admin.services.update', $service) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $service->name) }}" 
                            class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white" 
                            placeholder="e.g. 3D Printing"
                            required
                        >
                        @error('name')
                            <p class="text-danger-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input 
                            type="number" 
                            id="price" 
                            name="price" 
                            value="{{ old('price', $service->price) }}" 
                            step="0.01" 
                            min="0" 
                            class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white" 
                            placeholder="0.00"
                            required
                        >
                        @error('price')
                            <p class="text-danger-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4" 
                            class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white resize-none" 
                            placeholder="Describe the service and what it offers..."
                            required
                        >{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="text-danger-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="file_formats" class="block text-sm font-medium text-gray-700">Supported File Formats</label>
                        <input name="file_formats" id="file_formats" placeholder="e.g., STL, OBJ, 3MF" value="{{ old('file_formats', $service->file_formats) }}" class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white" />
                    </div>

                    <div>
                        <label for="materials" class="block text-sm font-medium text-gray-700">Materials</label>
                        <input name="materials" id="materials" placeholder="e.g., PLA, ABS, PETG" value="{{ old('materials', $service->materials) }}" class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white" />
                    </div>
                </div>

                <div class="p-6 border-t flex items-center justify-end gap-4">
                    <a href="{{ route('admin.services.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-yellow-400 text-primary-900 rounded-lg font-bold">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection