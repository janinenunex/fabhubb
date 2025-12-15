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
        ]);

        Order::create([
            'user_id' => auth()->id(),
            'service_id' => $validated['service_id'],
            'quantity' => $validated['quantity'],
            'status' => 'Pending',
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Order placed successfully!');
    }

    public function showOrder(Order $order): View
    {
        $this->authorize('view', $order);
        $order->load(['user', 'service']);
        return view('customer.orders.show', compact('order'));
    }
}
