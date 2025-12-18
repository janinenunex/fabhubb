@extends('layouts.admin')

@section('title', 'Service Management')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-4xl font-bold text-primary-900">Service Management</h1>
        <p class="text-gray-500 mt-2">Manage your fabrication lab services</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="bg-accent-400 hover:bg-accent-500 text-primary-900 font-bold py-3 px-6 rounded-lg transition shadow-lg inline-block">
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
<!-- Add New Service is a dedicated page (no modal) -->

@push('scripts')
<script>
    (function(){
        // Edit modal logic
        const editModal = document.createElement('div');
        editModal.id = 'editServiceModal';
        // white translucent overlay with blur so page behind modal appears white and blurred
        editModal.className = 'fixed inset-0 hidden items-center justify-center bg-white bg-opacity-60 backdrop-blur-md z-50';
        // ensure blur fallback even if Tailwind utilities are not generated
        editModal.style.cssText += 'backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); background-color: rgba(255,255,255,0.6);';
        editModal.innerHTML = `
            <div class="w-full max-w-3xl mx-4">
                <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="p-6 border-b bg-primary-900">
                        <h2 class="text-2xl font-bold text-white">Edit Service</h2>
                        <p class="text-primary-200 text-sm mt-1">Update service details</p>
                        <button id="closeEditModal" class="absolute right-6 top-6 text-white">✕</button>
                    </div>
                    <form id="editServiceForm">
                        <input type="hidden" name="_method" value="PUT">
                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Service Name</label>
                                <input name="name" id="edit_name" class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price</label>
                                <input name="price" id="edit_price" type="number" step="0.01" min="0" class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white" required />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="edit_description" rows="3" class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white resize-none" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Supported File Formats</label>
                                <input name="file_formats" id="edit_file_formats" class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Materials</label>
                                <input name="materials" id="edit_materials" class="mt-1 block w-full border rounded-lg px-3 py-2 bg-white" />
                            </div>
                                <div class="md:col-span-2 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="status" id="edit_status" value="Available" class="form-checkbox h-5 w-5 text-accent-400">
                                        <span class="ml-2 text-sm text-gray-700">Service Available</span>
                                    </label>
                                </div>
                        </div>
                        <div class="p-6 border-t flex items-center justify-end gap-4">
                            <button type="button" id="cancelEditService" class="px-4 py-2 border rounded-lg">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-yellow-400 text-primary-900 rounded-lg font-bold">Update Service</button>
                        </div>
                    </form>
                </div>
            </div>
        `;
        document.body.appendChild(editModal);

        const openButtons = document.querySelectorAll('.open-edit-modal');
        const closeBtn = () => document.getElementById('closeEditModal');

        function showEditModal(){
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        }
        function hideEditModal(){
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
        }

        openButtons.forEach(btn => {
            btn.addEventListener('click', function(){
                const tr = this.closest('tr');
                const id = tr.dataset.serviceId;
                // populate form
                document.getElementById('edit_name').value = tr.dataset.serviceName || '';
                document.getElementById('edit_description').value = tr.dataset.serviceDescription || '';
                document.getElementById('edit_price').value = tr.dataset.servicePrice || '';
                document.getElementById('edit_materials').value = tr.dataset.serviceMaterials || '';
                document.getElementById('edit_file_formats').value = tr.dataset.serviceFileFormats || '';
                // set checkbox state from row dataset
                const statusCheckbox = document.getElementById('edit_status');
                if (statusCheckbox) statusCheckbox.checked = (tr.dataset.serviceStatus === 'Available');
                // store id on form element
                const form = document.getElementById('editServiceForm');
                form.dataset.serviceId = id;
                showEditModal();
            });
        });

        document.addEventListener('click', function(e){
            if (e.target && e.target.id === 'closeEditModal') hideEditModal();
            if (e.target && e.target.id === 'cancelEditService') hideEditModal();
        });

        // Submit via fetch
        document.getElementById('editServiceForm').addEventListener('submit', function(e){
            e.preventDefault();
            const form = e.target;
            const id = form.dataset.serviceId;
            if (!id) return;

            const url = `/admin/services/${id}`;
            const data = new FormData(form);
            // include CSRF
            data.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            fetch(url, { method: 'POST', body: data, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json().catch(() => r.text()))
                .then(res => {
                    // on success, update the row in table
                    const tr = document.querySelector(`tr[data-service-id="${id}"]`);
                    if (tr) {
                        // update dataset
                        tr.dataset.serviceName = document.getElementById('edit_name').value;
                        tr.dataset.serviceDescription = document.getElementById('edit_description').value;
                        tr.dataset.servicePrice = document.getElementById('edit_price').value;
                        tr.dataset.serviceMaterials = document.getElementById('edit_materials').value;
                        tr.dataset.serviceFileFormats = document.getElementById('edit_file_formats').value;

                        // update visible cells
                        tr.querySelector('.service-name').textContent = document.getElementById('edit_name').value;
                        const desc = document.getElementById('edit_description').value;
                        tr.querySelector('.service-description').textContent = desc.length > 100 ? desc.substring(0,97) + '...' : desc;
                        tr.querySelector('.service-price').innerHTML = '$' + parseFloat(document.getElementById('edit_price').value).toFixed(2) + ' <span class="text-sm text-gray-500">per unit</span>';
                        tr.querySelector('.service-materials').innerHTML = document.getElementById('edit_materials').value ? `<span class="text-sm">${document.getElementById('edit_materials').value}</span>` : '<span class="text-gray-500 italic">No materials specified</span>';

                        // update status badge based on checkbox
                        const isAvailable = document.getElementById('edit_status').checked;
                        const statusCell = tr.querySelector('.service-status');
                        if (statusCell) {
                            statusCell.innerHTML = `<span class="px-4 py-2 text-sm font-bold rounded-full ${isAvailable ? 'bg-green-600 text-white' : 'bg-red-600 text-white'}">${isAvailable ? 'Available' : 'Unavailable'}</span>`;
                        }
                        // update dataset flag
                        tr.dataset.serviceStatus = isAvailable ? 'Available' : 'Unavailable';
                    }

                    hideEditModal();
                })
                .catch(err => {
                    console.error('Update failed', err);
                    alert('Update failed. Check console for details.');
                });
        });
    })();
</script>
@endpush

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
                <tr class="hover:bg-gray-50" data-service-id="{{ $service->id }}" data-service-name="{{ e($service->name) }}" data-service-description="{{ e($service->description) }}" data-service-price="{{ $service->price }}" data-service-materials="{{ e($service->materials) }}" data-service-file-formats="{{ e($service->file_formats ?? '') }}" data-service-status="{{ $service->status }}">
                    <td class="px-6 py-4 font-medium text-gray-900 service-name">{{ $service->name }}</td>
                    <td class="px-6 py-4 text-gray-700 max-w-md service-description">{{ Str::limit($service->description, 100) }}</td>
                    <td class="px-6 py-4 font-semibold text-accent-400 service-price">${{ number_format($service->price, 2) }} <span class="text-sm text-gray-500">per unit</span></td>
                    <td class="px-6 py-4 text-gray-700 service-materials">
                        @if($service->materials)
                            <span class="text-sm">{{ $service->materials }}</span>
                        @else
                            <span class="text-gray-500 italic">No materials specified</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 service-status">
                        <span class="px-4 py-2 text-sm font-bold rounded-full {{ $service->getStatusBadgeClass() }}">
                            {{ $service->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 space-x-3">
                        <button type="button" class="open-edit-modal text-accent-400 hover:text-accent-300" title="Edit" data-service-id="{{ $service->id }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
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