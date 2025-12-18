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
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow border border-gray-100">
                <!-- Header with Service Name -->
                <div class="bg-gray-50 p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-2xl font-bold text-primary-900">{{ $service->name }}</h3>
                        <span class="inline-block px-4 py-2 bg-green-600 text-white text-xs font-bold rounded-full">Available</span>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <!-- Description -->
                    <p class="text-gray-700 text-sm mb-6 line-clamp-2">
                        {{ $service->description }}
                    </p>

                    <!-- Price -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <p class="text-gray-600 text-xs mb-1">💰 Price</p>
                        <p class="text-2xl font-bold text-primary-900">
                            Starting at {{ $service->price ? '₱' . number_format($service->price, 2) . '/hour' : 'Contact us' }}
                        </p>
                    </div>

                    <!-- Service Details -->
                    <div class="space-y-3 mb-6">
                        <!-- File Format -->
                        @if ($service->file_formats)
                            <div class="flex items-start gap-3">
                                <span class="text-lg">📄</span>
                                <div>
                                    <p class="text-gray-600 text-xs font-medium">File Format</p>
                                    <p class="text-gray-800 text-sm">{{ $service->file_formats }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Materials -->
                        @if ($service->materials)
                            <div class="flex items-start gap-3">
                                <span class="text-lg">🔨</span>
                                <div>
                                    <p class="text-gray-600 text-xs font-medium">Materials</p>
                                    <p class="text-gray-800 text-sm">{{ $service->materials }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Time -->
                        @if ($service->turnaround_time)
                            <div class="flex items-start gap-3">
                                <span class="text-lg">⏱️</span>
                                <div>
                                    <p class="text-gray-600 text-xs font-medium">Time</p>
                                    <p class="text-gray-800 text-sm">{{ $service->turnaround_time }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Request Service Button (opens modal) -->
                    <button type="button" data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}" class="open-request-modal w-full bg-primary-900 hover:bg-primary-800 text-white font-bold py-3 px-6 rounded-lg transition">
                        Request Service
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-xl shadow-xl p-16 text-center border border-gray-200">
        <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="text-2xl font-bold text-primary-900 mb-3">No Services Available</h3>
        <p class="text-gray-600 text-lg">Check back soon for new services!</p>
    </div>
@endif

<!-- Request Service Modal -->
<div id="requestServiceModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg w-full max-w-4xl mx-4 overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 id="modalTitle" class="text-lg font-semibold">Request Service</h3>
            <button id="closeModal" class="text-gray-600 hover:text-gray-900">✕</button>
        </div>

        <form id="requestForm" method="POST" action="{{ route('customer.placeOrder') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="service_id" id="modal_service_id" value="">
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <label class="block text-sm font-medium">Name</label>
                    <input required name="name" value="{{ auth()->user()->name ?? '' }}" class="w-full border rounded px-3 py-2" />

                    <label class="block text-sm font-medium">Email</label>
                    <input required name="email" type="email" value="{{ auth()->user()->email ?? '' }}" class="w-full border rounded px-3 py-2" />

                    <label class="block text-sm font-medium">Phone</label>
                    <input required name="phone" class="w-full border rounded px-3 py-2" />

                    <label class="block text-sm font-medium">Quantity</label>
                    <input required name="quantity" type="number" min="1" value="1" class="w-24 border rounded px-3 py-2" />
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-medium">Upload Files</label>
                    <input name="files[]" type="file" accept=".svg,.pdf,.png,.jpeg,.jpg" multiple class="w-full" />

                    <label class="block text-sm font-medium">Notes (optional)</label>
                    <textarea name="notes" rows="5" class="w-full border rounded px-3 py-2"></textarea>

                    <div class="flex items-center justify-end gap-3 mt-2">
                        <button type="button" id="modalCancel" class="px-4 py-2 border rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-900 text-white rounded">Submit Request</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    (function(){
        const modal = document.getElementById('requestServiceModal');
        const close = document.getElementById('closeModal');
        const cancel = document.getElementById('modalCancel');
        const modalServiceId = document.getElementById('modal_service_id');
        const modalTitle = document.getElementById('modalTitle');

        function openModal(serviceId, serviceName){
            modalServiceId.value = serviceId;
            modalTitle.textContent = 'Request ' + serviceName;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(){
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.querySelectorAll('.open-request-modal').forEach(btn => {
            btn.addEventListener('click', function(){
                openModal(this.dataset.serviceId, this.dataset.serviceName);
            });
        });

        close.addEventListener('click', closeModal);
        cancel.addEventListener('click', closeModal);

        // Close on backdrop click
        modal.addEventListener('click', function(e){
            if (e.target === modal) closeModal();
        });
    })();
</script>
@endpush

@endsection