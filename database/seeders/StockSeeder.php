<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            // Gudang Jakarta
            ['product_id' => 1, 'warehouse_id' => 1, 'quantity' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'warehouse_id' => 1, 'quantity' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'warehouse_id' => 1, 'quantity' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 4, 'warehouse_id' => 1, 'quantity' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 5, 'warehouse_id' => 1, 'quantity' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 6, 'warehouse_id' => 1, 'quantity' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 7, 'warehouse_id' => 1, 'quantity' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 8, 'warehouse_id' => 1, 'quantity' => 22, 'created_at' => now(), 'updated_at' => now()],

            // Gudang Bandung
            ['product_id' => 1, 'warehouse_id' => 2, 'quantity' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'warehouse_id' => 2, 'quantity' => 35, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'warehouse_id' => 2, 'quantity' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 4, 'warehouse_id' => 2, 'quantity' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 5, 'warehouse_id' => 2, 'quantity' => 15, 'created_at' => now(), 'updated_at' => now()],

            // Gudang Surabaya
            ['product_id' => 1, 'warehouse_id' => 3, 'quantity' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'warehouse_id' => 3, 'quantity' => 28, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 6, 'warehouse_id' => 3, 'quantity' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 7, 'warehouse_id' => 3, 'quantity' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 8, 'warehouse_id' => 3, 'quantity' => 15, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('stocks')->insert($stocks);
    }
}
