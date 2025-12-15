<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            ['name' => '3D Printing', 'description' => 'High-quality 3D printing service.', 'price' => 150.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laser Cutting', 'description' => 'Precision laser cutting service.', 'price' => 200.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tarp Printing', 'description' => 'Custom tarp printing service.', 'price' => 250.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wood Cutting', 'description' => 'Wood cutting and engraving service.', 'price' => 180.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}