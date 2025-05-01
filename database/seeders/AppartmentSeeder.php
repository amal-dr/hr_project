<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppartmentSeeder extends Seeder
{
    public function run()
    {
        $appartments = [
            ['id' => 'APT001', 'name' => 'Études', 'matricul_manager' => 'MGR001'],
            ['id' => 'APT002', 'name' => 'Affaires Juridiques et Foncières', 'matricul_manager' => 'MGR002'],
            ['id' => 'APT003', 'name' => 'Gestion Urbaine', 'matricul_manager' => 'MGR003'],
            ['id' => 'APT004', 'name' => 'Administratif et Financier', 'matricul_manager' => 'MGR004'],
        ];

        foreach ($appartments as $appartment) {
            DB::table('appartments')->insertOrIgnore($appartment);
        }
    }
}