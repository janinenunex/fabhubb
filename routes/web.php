<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CustomerController;

// Redirect root to proper dashboard
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    }

    return redirect()->route('login');
});

// Admin Routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/orders/export', [AdminDashboardController::class, 'export'])
            ->name('orders.export');

        Route::resource('services', AdminServiceController::class);

        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
    });

// Customer Routes
Route::middleware('auth')
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/services', [CustomerController::class, 'services'])
            ->name('services');

        Route::post('/orders', [CustomerController::class, 'placeOrder'])
            ->name('placeOrder');

        Route::get('/orders/{order}', [CustomerController::class, 'showOrder'])
            ->name('orders.show');
    });

require __DIR__.'/auth.php';