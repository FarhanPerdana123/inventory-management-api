<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Gudang Utama Jakarta',
                'location' => 'Jl. Raya Bekasi KM 20, Jakarta Timur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gudang Cabang Bandung',
                'location' => 'Jl. Soekarno Hatta No. 456, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gudang Cabang Surabaya',
                'location' => 'Jl. Ahmad Yani No. 789, Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('warehouses')->insert($warehouses);
    }
}
