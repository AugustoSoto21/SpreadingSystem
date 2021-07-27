<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('productos')->insert([
        	['codigo' => '20210727RELRT45',
        	'detalles' => 'RELOJ INTELIGENTE',
        	'marca' => 'LG',
        	'modelo' => 'XR2',
        	'color' => 'NEGRO',
        	'id_categoria' => 1,
        	'status' => 'Activo'],

        	['codigo' => '20210727TABRT45',
        	'detalles' => 'TABLET INTELIGENTE',
        	'marca' => 'SAMSUM',
        	'modelo' => 'TB3',
        	'color' => 'GRIS',
        	'id_categoria' => 5,
        	'status' => 'Activo']
        ]);
    }
}
