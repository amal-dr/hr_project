<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployerSeeder extends Seeder
{
    public function run()
    {
        $employers = [
            [
                'matricul_employer' => 'EMP001',
                'nom' => 'El Amrani',
                'prenom' => 'Omar',
                'email' => 'omar.elamrani@example.com',
                'telephone' => '0623456789',
                'passwordE' => Hash::make('password123'),
                'role' => 'Employee',
                'date_embauche' => '2023-06-15',
                'post' => 'Developer',
                'appartment_id' => 'APT001', // Changed from 'apartment'
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more employers as needed
        ];

        foreach ($employers as $employer) {
            DB::table('employers')->updateOrInsert(
                ['matricul_employer' => $employer['matricul_employer']],
                $employer
            );
        }
    }
}