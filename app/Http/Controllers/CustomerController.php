<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();
        $orders = $user->orders()->with('service')->latest()->paginate(10);
        $orderStats = [
            'total' => $user->orders()->count(),
            'pending' => $user->orders()->where('status', 'Pending')->count(),
            'completed' => $user->orders()->where('status', 'Completed')->count(),
        ];

        return view('customer.dashboard', compact('user', 'orders', 'orderStats'));
    }

    public function services(): View
    {
        $services = Service::all();
        return view('customer.services', compact('services'));
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:svg,pdf,png,jpeg,jpg|max:10240',
        ]);

        // Create the order first
        $order = Order::create([
            'user_id' => auth()->id(),
            'service_id' => $validated['service_id'],
            'quantity' => $validated['quantity'],
            'status' => Order::STATUS_PENDING,
            'contact_name' => $validated['name'],
            'contact_email' => $validated['email'],
            'contact_phone' => $validated['phone'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Handle uploaded files (optional)
        if ($request->hasFile('files')) {
            $stored = [];
            foreach ($request->file('files') as $file) {
                if ($file && $file->isValid()) {
                    $stored[] = $file->store("orders/{$order->id}", 'public');
                }
            }

            if (!empty($stored)) {
                $order->files = $stored;
                $order->save();
            }
        }

        return redirect()->route('customer.dashboard')->with('success', 'Order placed successfully!');
    }

public function show(Order $order)
{
    // Only allow the owner of the order to view it
    if ($order->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    return view('customer.orders.show', compact('order'));
}
}
