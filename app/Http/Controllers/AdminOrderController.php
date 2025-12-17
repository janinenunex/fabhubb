<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['user', 'service'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'service']);
        return view('admin.orders.show', compact('order'));
    }

public function updateStatus(Request $request, Order $order): RedirectResponse
{
    $validated = $request->validate([
        'status' => 'required|in:' . implode(',', Order::$statuses),
    ]);

    $order->update($validated);

    return back()->with('success', 'Order status updated to ' . $validated['status']);
}
}
