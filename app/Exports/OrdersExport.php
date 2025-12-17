<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::with(['user', 'service'])->get()->map(function ($order) {
            return [
                'ID' => $order->id,
                'Customer Name' => $order->user->name,
                'Customer Email' => $order->user->email,
                'Service' => $order->service->name,
                'Quantity' => $order->quantity,
                'Total Price' => '$' . number_format($order->quantity * $order->service->price, 2),
                'Status' => $order->status,
                'Date' => $order->created_at->format('M d, Y h:i A'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID', 'Customer Name', 'Customer Email', 'Service', 'Quantity', 'Total Price', 'Status', 'Date'
        ];
    }
}