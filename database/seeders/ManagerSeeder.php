<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        $managers = [
            [
                'matricul_manager' => 'MGR001',
                'first_name' => 'Études',
                'last_name' => 'Manager',
                'email' => 'etudes.manager@example.com',
                'passwordM' => Hash::make('password123'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'matricul_manager' => 'MGR002',
                'first_name' => 'Juridique',
                'last_name' => 'Manager',
                'email' => 'juridique.manager@example.com',
                'passwordM' => Hash::make('password123'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'matricul_manager' => 'MGR003',
                'first_name' => 'Gestion',
                'last_name' => 'Urbaine',
                'email' => 'gestion.urbaine@example.com',
                'passwordM' => Hash::make('password123'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'matricul_manager' => 'MGR004',
                'first_name' => 'Admin',
                'last_name' => 'Financier',
                'email' => 'admin.financier@example.com',
                'passwordM' => Hash::make('password123'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Use insertOrIgnore to avoid duplicates if they exist
        foreach ($managers as $manager) {
            DB::table('managers')->insertOrIgnore($manager);
        }
    }
}