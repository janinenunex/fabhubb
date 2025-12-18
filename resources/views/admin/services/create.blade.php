@extends('layouts.admin')

@section('title', 'Create Service')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-primary-900">Create Service</h1>
    <p class="text-gray-500 mt-2">Add a new FabLab service.</p>
</div>

<div class="mt-12 bg-accent-50 rounded-lg">
    <div class="max-w-3xl mx-auto py-6">
        <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Service Name</label>
                        <input name="name" value="{{ old('name') }}" placeholder="e.g., 3D Printing" class="w-full px-4 py-3 bg-primary-50 border border-primary-300 rounded-md text-gray-900" required />
                        @error('name')<p class="text-danger-600 text-sm mt-2">{{ $message }}</p>@enderror

                        <label class="block text-sm font-medium text-gray-700 mt-6 mb-2">Description</label>
                        <textarea name="description" rows="6" placeholder="Describe the service in detail..." class="w-full px-4 py-3 bg-primary-50 border border-primary-300 rounded-md text-gray-900 resize-none" required>{{ old('description') }}</textarea>
                        @error('description')<p class="text-danger-600 text-sm mt-2">{{ $message }}</p>@enderror

                        <label class="block text-sm font-medium text-gray-700 mt-6 mb-2">Price</label>
                        <input name="price" type="number" step="0.01" min="0" value="{{ old('price', '0.00') }}" class="w-full px-4 py-3 bg-primary-50 border border-primary-300 rounded-md text-gray-900" placeholder="0.00" required />
                        @error('price')<p class="text-danger-600 text-sm mt-2">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supported File Formats</label>
                        <input name="file_formats" value="{{ old('file_formats') }}" placeholder="e.g., STL, OBJ, 3MF" class="w-full px-4 py-3 bg-primary-50 border border-primary-300 rounded-md text-gray-900" />
                        @error('file_formats')<p class="text-danger-600 text-sm mt-2">{{ $message }}</p>@enderror

                        <label class="block text-sm font-medium text-gray-700 mt-6 mb-2">Materials</label>
                        <input name="materials" value="{{ old('materials') }}" placeholder="e.g., PLA, ABS, PETG" class="w-full px-4 py-3 bg-primary-50 border border-primary-300 rounded-md text-gray-900" />
                        @error('materials')<p class="text-danger-600 text-sm mt-2">{{ $message }}</p>@enderror

                        <div class="mt-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="status" value="Available" class="form-checkbox h-5 w-5 text-accent-400" {{ old('status', 'Available') == 'Available' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Service Available</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-4">
                    <button type="submit" class="px-5 py-3 bg-yellow-400 text-primary-900 rounded-md font-bold shadow-md">Create Service</button>
                    <a href="{{ route('admin.services.index') }}" class="px-4 py-3 bg-white border rounded-md">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection