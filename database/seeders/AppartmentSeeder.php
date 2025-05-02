<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppartmentSeeder extends Seeder
{
    public function run()
    {
        $appartments = [
            ['id' => 'APT001', 'name' => 'Études'],
            ['id' => 'APT002', 'name' => 'Affaires Juridiques et Foncières'],
            ['id' => 'APT003', 'name' => 'Gestion Urbaine'],
            ['id' => 'APT004', 'name' => 'Administratif et Financier'],
        ];

        foreach ($appartments as $appartment) {
            DB::table('appartments')->insertOrIgnore($appartment);
        }
    }
}