<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FuentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('fuentes')->insert([
        	['fuente' => 'Market Ching'],
        	['fuente' => 'Market Florencia'],
        	['fuente' => 'Whatsapp Central'],
        	['fuente' => 'Whatsapp Stephany'],
        	['fuente' => 'Market Nohemi'],
        	['fuente' => 'Market Nadia'],
        	['fuente' => 'Market Estefanía'],
        	['fuente' => 'Spreading Buenos Aires'],
        	['fuente' => 'Spreading Argentina'],
        	['fuente' => 'Whatsapp/Market Stephany'],
        	['fuente' => 'Whatsapp/Market Katherine'],
        	['fuente' => 'Whatsapp/Market Gonzalez'],
        	['fuente' => 'Instagram Buenos Aires'],
        	['fuente' => 'Whatsapp/Market Rossana'],
        	['fuente' => 'Whatsapp Rossana'],
        	['fuente' => 'Whatsapp Dayana']
        ]);
    }
}
