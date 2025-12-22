<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@inventory.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff User',
                'username' => 'staff',
                'email' => 'staff@inventory.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Owner User',
                'username' => 'owner',
                'email' => 'owner@inventory.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);

        // Assign roles to users
        DB::table('user_roles')->insert([
            ['user_id' => 1, 'role_id' => 1], // Admin -> Admin role
            ['user_id' => 2, 'role_id' => 2], // Staff -> Staff role
            ['user_id' => 3, 'role_id' => 3], // Owner -> Owner role
        ]);
    }
}
