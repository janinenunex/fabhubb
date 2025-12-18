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
                    <p class="text-gray-600 text-sm">Customer Name</p>
                    <p class="text-xl font-semibold">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Customer Email</p>
                    <p class="text-xl font-semibold">{{ $order->user->email }}</p>
                </div>
                    <div>
                        <p class="text-gray-600 text-sm">Contact Phone</p>
                        <p class="text-xl font-semibold">{{ $order->contact_phone ?? '—' }}</p>
                    </div>
                <div>
                    <p class="text-gray-600 text-sm">Service</p>
                    <p class="text-xl font-semibold">{{ $order->service->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Quantity</p>
                    <p class="text-xl font-semibold">{{ $order->quantity }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Price per Unit</p>
                    <p class="text-xl font-semibold">${{ number_format($order->service->price, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Price</p>
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
                    <h3 class="text-sm font-semibold text-primary-900 mb-4">Uploaded Files</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($order->files as $file)
                            @php
                                $filePath = asset('storage/' . $file);
                                $fileName = basename($file);
                                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                $isImage = in_array($fileExtension, ['png', 'jpg', 'jpeg', 'svg']);
                                $isPdf = $fileExtension === 'pdf';
                            @endphp
                            
                            @if($isImage)
                                <div class="relative group">
                                    <a href="{{ $filePath }}" target="_blank" class="block cursor-pointer" data-image-modal="{{ $filePath }}">
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                                            <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                                                @if($fileExtension === 'svg')
                                                    <img src="{{ $filePath }}" alt="{{ $fileName }}" class="w-full h-full object-contain p-2">
                                                @else
                                                    <img src="{{ $filePath }}" alt="{{ $fileName }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div class="p-2 bg-gray-50 border-t border-gray-200">
                                                <p class="text-xs text-gray-700 truncate font-medium">{{ $fileName }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @elseif($isPdf)
                                <div class="relative group">
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow cursor-pointer" data-pdf-modal="{{ $filePath }}">
                                        <div class="aspect-square bg-gray-100 flex flex-col items-center justify-center p-4">
                                            <svg class="w-16 h-16 text-red-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-xs text-gray-700 font-medium">PDF</span>
                                        </div>
                                        <div class="p-2 bg-gray-50 border-t border-gray-200">
                                            <p class="text-xs text-gray-700 truncate mb-1 font-medium">{{ $fileName }}</p>
                                            <div class="flex gap-1">
                                                <button type="button" class="flex-1 text-center text-xs px-2 py-1 bg-accent-400 hover:bg-accent-500 text-primary-900 font-semibold rounded transition-colors" onclick="event.stopPropagation(); window.open('{{ $filePath }}', '_blank');">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Fallback for unknown file types --}}
                                <div class="relative group">
                                    <a href="{{ $filePath }}" target="_blank" rel="noopener" class="block cursor-pointer">
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                                            <div class="aspect-square bg-gray-100 flex flex-col items-center justify-center p-4">
                                                <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                                @if($fileExtension)
                                                    <span class="text-xs text-gray-700 font-medium uppercase">{{ $fileExtension }}</span>
                                                @else
                                                    <span class="text-xs text-gray-700 font-medium">File</span>
                                                @endif
                                            </div>
                                            <div class="p-2 bg-gray-50 border-t border-gray-200">
                                                <p class="text-xs text-gray-700 truncate font-medium">{{ $fileName }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
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
                <p class="text-gray-600 text-sm mb-2">Created On</p>
                <p class="text-primary-900 font-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                <p class="text-gray-600 text-sm mt-6 mb-2">Last Updated</p>
                <p class="text-primary-900 font-semibold">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 hidden items-center justify-center bg-white bg-opacity-90 backdrop-blur-md z-50" style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); background-color: rgba(0,0,0,0.85);">
    <div class="relative max-w-7xl max-h-[90vh] mx-4">
        <button id="closeImageModal" class="absolute -top-12 right-0 text-white hover:text-gray-300 text-4xl font-bold z-10" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">✕</button>
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <img id="modalImage" src="" alt="Preview" class="max-w-full max-h-[90vh] object-contain">
        </div>
    </div>
</div>

<!-- PDF Preview Modal -->
<div id="pdfModal" class="fixed inset-0 hidden items-center justify-center bg-white bg-opacity-90 backdrop-blur-md z-50" style="backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); background-color: rgba(0,0,0,0.85);">
    <div class="relative w-full max-w-6xl max-h-[90vh] mx-4">
        <button id="closePdfModal" class="absolute -top-12 right-0 text-white hover:text-gray-300 text-4xl font-bold z-10" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">✕</button>
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden h-full flex flex-col">
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-primary-900">PDF Preview</h3>
                <a id="pdfDownloadLink" href="" target="_blank" rel="noopener" class="text-sm px-4 py-2 bg-accent-400 hover:bg-accent-500 text-primary-900 font-semibold rounded transition-colors">
                    Open in New Tab
                </a>
            </div>
            <div class="flex-1 overflow-hidden">
                <iframe id="modalPdf" src="" class="w-full h-full border-0" style="min-height: 600px;"></iframe>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function(){
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const closeImageModal = document.getElementById('closeImageModal');
        
        const pdfModal = document.getElementById('pdfModal');
        const modalPdf = document.getElementById('modalPdf');
        const pdfDownloadLink = document.getElementById('pdfDownloadLink');
        const closePdfModal = document.getElementById('closePdfModal');
        
        // Handle image click to open modal
        document.querySelectorAll('[data-image-modal]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const imageSrc = this.getAttribute('data-image-modal');
                modalImage.src = imageSrc;
                imageModal.classList.remove('hidden');
                imageModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Handle PDF click to open modal
        document.querySelectorAll('[data-pdf-modal]').forEach(element => {
            element.addEventListener('click', function(e) {
                const pdfSrc = this.getAttribute('data-pdf-modal');
                modalPdf.src = pdfSrc + '#view=FitH';
                pdfDownloadLink.href = pdfSrc;
                pdfModal.classList.remove('hidden');
                pdfModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            });
        });
        
        function closeImageModal() {
            imageModal.classList.add('hidden');
            imageModal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        
        function closePdfModalFunc() {
            pdfModal.classList.add('hidden');
            pdfModal.classList.remove('flex');
            modalPdf.src = '';
            document.body.style.overflow = '';
        }
        
        closeImageModal.addEventListener('click', closeImageModal);
        closePdfModal.addEventListener('click', closePdfModalFunc);
        
        // Close on backdrop click
        imageModal.addEventListener('click', function(e) {
            if (e.target === imageModal) {
                closeImageModal();
            }
        });
        
        pdfModal.addEventListener('click', function(e) {
            if (e.target === pdfModal) {
                closePdfModalFunc();
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!imageModal.classList.contains('hidden')) {
                    closeImageModal();
                }
                if (!pdfModal.classList.contains('hidden')) {
                    closePdfModalFunc();
                }
            }
        });
    })();
</script>
@endpush
@endsection