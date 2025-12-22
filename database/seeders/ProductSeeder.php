<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'sku' => 'PRD-001',
                'name' => 'Laptop Dell Inspiron 15',
                'description' => 'Intel Core i5, 8GB RAM, 512GB SSD',
                'price' => 8500000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD-002',
                'name' => 'Mouse Logitech M185',
                'description' => 'Wireless mouse with 2.4GHz connection',
                'price' => 125000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD-003',
                'name' => 'Keyboard Mechanical RGB',
                'description' => 'Gaming keyboard with RGB backlight',
                'price' => 450000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD-004',
                'name' => 'Monitor LG 24 Inch',
                'description' => 'Full HD IPS panel, 75Hz',
                'price' => 1800000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD-005',
                'name' => 'SSD Samsung 1TB',
                'description' => 'NVMe M.2 SSD, 3500MB/s read speed',
                'price' => 1500000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD-006',
                'name' => 'RAM DDR4 16GB',
                'description' => 'Corsair Vengeance 3200MHz',
                'price' => 950000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD-007',
                'name' => 'Webcam Logitech C920',
                'description' => 'Full HD 1080p webcam',
                'price' => 1200000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD-008',
                'name' => 'Headset HyperX Cloud II',
                'description' => '7.1 Surround sound gaming headset',
                'price' => 1100000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
