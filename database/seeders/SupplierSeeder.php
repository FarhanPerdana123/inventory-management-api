<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT. Teknologi Maju',
                'phone' => '021-12345678',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV. Komputer Sejahtera',
                'phone' => '021-87654321',
                'address' => 'Jl. Gatot Subroto No. 45, Jakarta Selatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT. Electronics Indonesia',
                'phone' => '022-9876543',
                'address' => 'Jl. Dago No. 78, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toko Komputer Jaya',
                'phone' => '031-5556677',
                'address' => 'Jl. Basuki Rahmat No. 99, Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}
