<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MercadoPagoTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ivas')->insert([
        	'iva' => 21
        ]);
    }
}
