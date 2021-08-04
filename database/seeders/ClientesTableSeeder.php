<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clientes')->insert([
        	['nombres' => 'Bill',
        	 'apellidos' => 'Gate', 
        	 'celular' => '987654321', 
        	 'direccion' => 'Miami', 
        	 'localidad' => 'Beach'],

        	['nombres' => 'Will', 
        	'apellidos' => 'Smith', 
        	'celular' => '987654322', 
        	'direccion' => 'Los Angeles', 
        	'localidad' => 'Beverly Hills'],

        	['nombres' => 'Keanu', 
        	'apellidos' => 'Reeves', 
        	'celular' => '987654323', 
        	'direccion' => 'Orlando', 
        	'localidad' => 'Florida'],

        	['nombres' => 'Augusto', 
        	'apellidos' => 'Soto', 
        	'celular' => '987654324', 
        	'direccion' => 'Argentina', 
        	'localidad' => 'Morón']
        ]);
    }
}
