<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('agencias')->insert([
        	['nombre' => 'FULLTRANS'],
        	['nombre' => 'OESTE'],
        	['nombre' => 'EEED'],
        	['nombre' => 'NEX LOGÍSTICA'],
        	['nombre' => 'ENVÍOS FLEX'],
        	['nombre' => 'ECOFLEX'],
        ]);
    }
}
