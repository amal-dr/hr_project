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
        DB::table('tasks')->truncate();
        DB::table('employers')->truncate();
        DB::table('managers')->truncate();
        DB::table('appartments')->truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Seed in proper order (parents first)
        $this->call([
            AppartmentSeeder::class,
            ManagerSeeder::class,
            EmployerSeeder::class,
            TaskSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}