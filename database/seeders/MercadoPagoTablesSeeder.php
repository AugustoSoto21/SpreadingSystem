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

        \DB::table('medios')->insert([
            ['medio' => 'LINK',
            'porcentaje' => 5.99,
            'id_iva' => 1],
            ['medio' => 'POINT CREDITO',
            'porcentaje' => 5.79,
            'id_iva' => 1],
            ['medio' => 'POINT DEBITO',
            'porcentaje' => 3.29,
            'id_iva' => 1],
            ['medio' => 'QR DINERO EN CUENTA',
            'porcentaje' => 0.8,
            'id_iva' => 1],
            ['medio' => 'QR CREDITO',
            'porcentaje' => 5.79,
            'id_iva' => 1],
            ['medio' => 'QR DEBITO',
            'porcentaje' => 0.99,
            'id_iva' => 1]
        ]);

        \DB::table('cuotas')->insert([
            ['id_medio' => 1,
            'cant_cuota' => 1,
            'interes' => 0],
            ['id_medio' => 1,
            'cant_cuota' => 3,
            'interes' => 10],
            ['id_medio' => 1,
            'cant_cuota' => 6,
            'interes' => 18],
            ['id_medio' => 1,
            'cant_cuota' => 9,
            'interes' => 28],
            ['id_medio' => 1,
            'cant_cuota' => 12,
            'interes' => 33],
            //--------------------
            ['id_medio' => 2,
            'cant_cuota' => 1,
            'interes' => 0],
            //---------------------
            ['id_medio' => 3,
            'cant_cuota' => 1,
            'interes' => 0],
            //-------------------
            ['id_medio' => 4,
            'cant_cuota' => 1,
            'interes' => 0],
            //-------------------
            ['id_medio' => 5,
            'cant_cuota' => 1,
            'interes' => 0],
        ]);
    }
}
