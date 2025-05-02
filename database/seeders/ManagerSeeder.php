<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        // First ensure appartments exist
        $this->call(AppartmentSeeder::class);

        $managers = [
            [
                'matricul_manager' => 'MGR001',
                'appartment_id' => 'APT001',
                'first_name' => 'Études',
                'last_name' => 'Manager',
                'email' => 'etudes.manager@example.com',
                'passwordM' => Hash::make('password123'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ... other managers
        ];

        foreach ($managers as $manager) {
            DB::table('managers')->insertOrIgnore($manager);
        }
    }
}