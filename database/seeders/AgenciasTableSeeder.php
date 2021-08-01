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
            ['nombre' => 'SPREADING', 'almacen' => 'No'],
            ['nombre' => 'FULLTRANS', 'almacen' => 'No'],
        	['nombre' => 'OESTE', 'almacen' => 'No'],
        	['nombre' => 'EEED', 'almacen' => 'No'],
        	['nombre' => 'NEX LOGÍSTICA', 'almacen' => 'Si'],
        	['nombre' => 'ENVÍOS FLEX', 'almacen' => 'No'],
        	['nombre' => 'ECOFLEX', 'almacen' => 'Si'],
        ]);
    }
}
