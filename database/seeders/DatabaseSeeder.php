<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear tables in proper order (child tables first)
        DB::table('attendances')->truncate();
        DB::table('vacation_requests')->truncate();
        DB::table('tasks')->truncate();
        DB::table('employers')->truncate();
        DB::table('appartments')->truncate();
        DB::table('managers')->truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Seed in proper order
        $this->call([
            ManagerSeeder::class,
            AppartmentSeeder::class,
            EmployerSeeder::class,
            TaskSeeder::class,
            AttendanceSeeder::class,
            VacationSeeder::class,
        ]);
    }
}