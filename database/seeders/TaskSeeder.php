<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        Task::create([
            'description' => 'Prepare weekly report',
            'status' => 'pending',
            'deadline' => now()->addDays(3),
            'matricul_employer' => 'EMP001',
            'matricul_manager' => 'MGR001',
        ]);
    }
}