<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'materials' => 'nullable|string|max:1000',
            'file_formats' => 'nullable|string|max:1000',
            'status' => 'nullable|in:Available,Unavailable',
        ]);

        // Ensure default status is set if not provided
        if (empty($validated['status'])) {
            $validated['status'] = 'Available';
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'materials' => 'nullable|string|max:1000',
            'file_formats' => 'nullable|string|max:1000',
            'status' => 'nullable|in:Available,Unavailable',
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = $service->status ?? 'Available';
        }

        $service->update($validated);

        // If this is an AJAX / XHR request, return JSON so frontend can update the row without a redirect
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'service' => $service->fresh(),
            ]);
        }

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
