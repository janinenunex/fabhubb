<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 2, // John Customer
                'service_id' => 1, // 3D Printing
                'quantity' => 2,
                'status' => 'pending',
                'order_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}