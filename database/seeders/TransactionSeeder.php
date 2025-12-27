<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Transaksi IN (Pembelian dari supplier)
        $transactionIn1 = [
            'user_id' => 2, // Staff
            'supplier_id' => 1,
            'type' => 'IN',
            'transaction_date' => now()->subDays(10),
            'note' => 'Pembelian stok awal laptop dan mouse',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ];
        DB::table('transactions')->insert($transactionIn1);
        $transactionId1 = DB::getPdo()->lastInsertId();

        DB::table('transaction_items')->insert([
            ['transaction_id' => $transactionId1, 'product_id' => 1, 'quantity' => 10, 'price' => 8500000.00],
            ['transaction_id' => $transactionId1, 'product_id' => 2, 'quantity' => 50, 'price' => 125000.00],
        ]);

        // Transaksi IN 2
        $transactionIn2 = [
            'user_id' => 2,
            'supplier_id' => 2,
            'type' => 'IN',
            'transaction_date' => now()->subDays(8),
            'note' => 'Pembelian keyboard dan monitor',
            'created_at' => now()->subDays(8),
            'updated_at' => now()->subDays(8),
        ];
        DB::table('transactions')->insert($transactionIn2);
        $transactionId2 = DB::getPdo()->lastInsertId();

        DB::table('transaction_items')->insert([
            ['transaction_id' => $transactionId2, 'product_id' => 3, 'quantity' => 30, 'price' => 450000.00],
            ['transaction_id' => $transactionId2, 'product_id' => 4, 'quantity' => 20, 'price' => 1800000.00],
        ]);

        // Transaksi OUT (Penjualan/Pengeluaran)
        $transactionOut1 = [
            'user_id' => 2,
            'supplier_id' => null,
            'type' => 'OUT',
            'transaction_date' => now()->subDays(5),
            'note' => 'Penjualan ke customer corporate',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ];
        DB::table('transactions')->insert($transactionOut1);
        $transactionId3 = DB::getPdo()->lastInsertId();

        DB::table('transaction_items')->insert([
            ['transaction_id' => $transactionId3, 'product_id' => 1, 'quantity' => 5, 'price' => 8500000.00],
            ['transaction_id' => $transactionId3, 'product_id' => 2, 'quantity' => 10, 'price' => 125000.00],
            ['transaction_id' => $transactionId3, 'product_id' => 4, 'quantity' => 3, 'price' => 1800000.00],
        ]);

        // Transaksi OUT 2
        $transactionOut2 = [
            'user_id' => 2,
            'supplier_id' => null,
            'type' => 'OUT',
            'transaction_date' => now()->subDays(3),
            'note' => 'Penjualan retail',
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(3),
        ];
        DB::table('transactions')->insert($transactionOut2);
        $transactionId4 = DB::getPdo()->lastInsertId();

        DB::table('transaction_items')->insert([
            ['transaction_id' => $transactionId4, 'product_id' => 3, 'quantity' => 5, 'price' => 450000.00],
            ['transaction_id' => $transactionId4, 'product_id' => 7, 'quantity' => 2, 'price' => 1200000.00],
        ]);

        // Transaksi ADJUST (Penyesuaian stok)
        $transactionAdjust = [
            'user_id' => 1, // Admin
            'supplier_id' => null,
            'type' => 'ADJUST',
            'transaction_date' => now()->subDays(2),
            'note' => 'Stock opname - koreksi stok rusak',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ];
        DB::table('transactions')->insert($transactionAdjust);
        $transactionId5 = DB::getPdo()->lastInsertId();

        DB::table('transaction_items')->insert([
            ['transaction_id' => $transactionId5, 'product_id' => 2, 'quantity' => -5, 'price' => 125000.00],
            ['transaction_id' => $transactionId5, 'product_id' => 6, 'quantity' => 10, 'price' => 950000.00],
        ]);
    }
}
