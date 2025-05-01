<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        Attendance::create([
            'matricul_employer' => 'EMP001',
            'date' => now()->toDateString(),
            'arrival_time' => '09:00:00',
            'leave_time' => '17:00:00',  // Changed from departure
            'status' => 'present',
        ]);
    }
}