<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vacation;
use Illuminate\Database\Seeder;

class VacationSeeder extends Seeder
{
    public function run()
    {
        Vacation::create([
            'matricul_employer' => 'EMP001',
            'reason' => 'Family event',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(10),
            'status' => 'pending',
        ]);
    }
}

