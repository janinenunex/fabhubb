<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class AdminDashboardController extends Controller
{
public function index(): View
{
    $totalOrders = Order::count();
    $pendingOrders = Order::where('status', Order::STATUS_PENDING)->count();
    $completedOrders = Order::where('status', Order::STATUS_COMPLETED)->count();
    $totalUsers = User::where('role', 'customer')->count();
    $allServices = Service::all(); // or however your friend fetches all services
    $recentUsers = User::latest()->limit(5)->get();

    $recentOrders = Order::with(['user', 'service'])
        ->latest()
        ->limit(5)
        ->get();

    // === ADD ANALYTICS DATA HERE ===
    // Monthly Revenue (last 12 months)
    $monthlyRevenue = Order::selectRaw('MONTH(orders.created_at) as month, YEAR(orders.created_at) as year, SUM(quantity * services.price) as total')
        ->join('services', 'orders.service_id', '=', 'services.id')
        ->where('orders.created_at', '>=', Carbon::now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    $revenueLabels = [];
    $revenueData = [];
    for ($i = 11; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $revenueLabels[] = $date->format('M Y');
        $match = $monthlyRevenue->where('month', $date->month)->where('year', $date->year)->first();
        $revenueData[] = $match ? $match->total : 0;
    }

    // Most Popular Services
    $popularServices = Order::selectRaw('services.name, COUNT(*) as count, SUM(quantity * services.price) as revenue')
        ->join('services', 'orders.service_id', '=', 'services.id')
        ->groupBy('services.id', 'services.name')
        ->orderByDesc('count')
        ->limit(10)
        ->get();

    // Daily Orders (last 30 days)
    $dailyOrders = Order::selectRaw('DATE(orders.created_at) as date, COUNT(*) as count')
        ->where('orders.created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $orderDates = [];
    $orderCounts = [];
    for ($i = 29; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i)->format('Y-m-d');
        $orderDates[] = Carbon::parse($date)->format('M d');
        $count = $dailyOrders->firstWhere('date', $date)?->count ?? 0;
        $orderCounts[] = $count;
    }

    // Order Status Distribution for Donut Chart
    $statusDistribution = [
        'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
        'processing' => Order::where('status', Order::STATUS_PROCESSING)->count(),
        'ready_for_pickup' => Order::where('status', Order::STATUS_READY)->count(),
        'completed' => Order::where('status', Order::STATUS_COMPLETED)->count(),
    ];

    return view('admin.dashboard', [
        'totalOrders' => $totalOrders,
        'pendingOrders' => $pendingOrders,
        'completedOrders' => $completedOrders,
        'totalUsers' => $totalUsers,
        'recentOrders' => $recentOrders,
        'revenueLabels' => $revenueLabels,
        'revenueData' => $revenueData,
        'popularServices' => $popularServices,
        'orderDates' => $orderDates,
        'orderCounts' => $orderCounts,
        'allServices' => $allServices,
        'recentUsers' => $recentUsers,
        'statusDistribution' => $statusDistribution,
    ]);
}

public function analytics(): View
{
    // Monthly Revenue - Fixed ambiguous column
    $monthlyRevenue = Order::selectRaw('MONTH(orders.created_at) as month, YEAR(orders.created_at) as year, SUM(quantity * services.price) as total')
        ->join('services', 'orders.service_id', '=', 'services.id')
        ->where('orders.created_at', '>=', Carbon::now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    $revenueLabels = [];
    $revenueData = [];
    for ($i = 11; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $revenueLabels[] = $date->format('M Y');
        $match = $monthlyRevenue->where('month', $date->month)->where('year', $date->year)->first();
        $revenueData[] = $match ? $match->total : 0;
    }

    // Most Popular Services
    $popularServices = Order::selectRaw('services.name, COUNT(*) as count, SUM(quantity * services.price) as revenue')
        ->join('services', 'orders.service_id', '=', 'services.id')
        ->groupBy('services.id', 'services.name')
        ->orderByDesc('count')
        ->limit(10)
        ->get();

    // Daily Orders - Fixed ambiguous column
    $dailyOrders = Order::selectRaw('DATE(orders.created_at) as date, COUNT(*) as count')
        ->where('orders.created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $orderDates = [];
    $orderCounts = [];
    for ($i = 29; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i)->format('Y-m-d');
        $orderDates[] = Carbon::parse($date)->format('M d');
        $count = $dailyOrders->firstWhere('date', $date)?->count ?? 0;
        $orderCounts[] = $count;
    }

    return view('admin.analytics', compact(
        'revenueLabels', 'revenueData', 'popularServices', 'orderDates', 'orderCounts'
    ));
}
    public function export()
    {
        return Excel::download(new OrdersExport, 'fabhub-orders-' . now()->format('Y-m-d') . '.csv');
    }
}