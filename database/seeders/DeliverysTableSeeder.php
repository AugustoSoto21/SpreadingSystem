<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeliverysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('deliverys')->insert([
        	['delivery' => 'Justin Beaber', 'id_agencia' => 1],
        	['delivery' => 'Shakira Mebarak', 'id_agencia' => 1],
        	['delivery' => 'Chester Benintong', 'id_agencia' => 2],
        	['delivery' => 'Jon Bon Jovi', 'id_agencia' => 2],
        	['delivery' => 'Michael Jackson', 'id_agencia' => 3],
        	['delivery' => 'Janneth Jackson', 'id_agencia' => 3],
        	['delivery' => 'Alejandro Fernandez', 'id_agencia' => 4],
        	['delivery' => 'Thalia Motola', 'id_agencia' => 4],
        	['delivery' => 'Bruno Mars', 'id_agencia' => 5],
        	['delivery' => 'Adele', 'id_agencia' => 5],
        	['delivery' => 'James Blunt', 'id_agencia' => 6],
        	['delivery' => 'Nelly Furtado', 'id_agencia' => 6],
        ]);
    }
}
