<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('estados')->insert([
        	['estado' => 'ENTREGADO', 'color' => '#00ffff', 'status_stock' => 'DECREMENTA' ],
        	['estado' => 'RECLAMO ENTREGADO', 'color' => ''],
        	['estado' => 'CONFIRMADO', 'color' => '#d9d9d9', 'status_stock' => 'DECREMENTA'],
        	['estado' => 'AFIRMADO', 'color' => '#b6d7a8', 'status_stock' => 'DECREMENTA'],
        	['estado' => 'POR CONFIRMAR', 'color' => '#ffe599', 'status_stock' => 'MANTIENE'],
        	['estado' => 'NO CONTESTA', 'color' => '#ea9999', 'status_stock' => 'MANTIENE'],
        	['estado' => 'CANCELADO', 'color' => '#666666', 'status_stock' => 'MANTIENE'],
        	['estado' => 'LLEGÓ Y NO ENTREGÓ', 'color' => '#666666', 'status_stock' => 'MANTIENE'],
        	['estado' => 'EN CAMINO', 'color' => '#d9d9d9', 'status_stock' => 'DECREMENTA'],
        	['estado' => 'ENVIADO', 'color' => '#3fdf96', 'status_stock' => 'DECREMENTA'],
        	['estado' => 'CANCELADO ALMACENADO', 'color' => '#d31212', 'status_stock' => 'MANTIENE'],
        	['estado' => 'LLEGADO ALMACENADO', 'color' => '#d31212', 'status_stock' => 'MANTIENE'],
        	['estado' => 'REPROGRAMADO CONFIRMADO', 'color' => ''],
        	['estado' => 'REPROGRAMADO AFIRMADO', 'color' => '#3fdf96','status_stock' => 'DECREMENTA'],
        	['estado' => 'REPROGRAMADO ENVIADO', 'color' => '#3fdf96','status_stock' => 'DECREMENTA'],
        	['estado' => 'RECLAMO', 'color' => '#ff9900', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/CONFIRMADO', 'color' => '#ff9900', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/AFIRMADO', 'color' => '#ff9900', 'status_stock' => 'MANTIENE'],
        	['estado' => 'RECLAMO SOLUCIONADO', 'color' => '#00ffff','status_stock' => 'DECREMENTA'],
        	['estado' => 'R/CANCELADO', 'color' => '#666666', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/LLEGÓ Y NO ENTREGÓ', 'color' => '#666666', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/EN CAMINO', 'color' => '#ff9900','status_stock' => 'DECREMENTA'],
        	['estado' => 'R/ENVIADO', 'color' => '#e69138','status_stock' => 'DECREMENTA'],],
        	['estado' => 'R/CANCELADO ALMACENADO', 'color' => '#d31212', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/LLEGADO ALMACENADO', 'color' => ''],
        	['estado' => 'R/REPROGRAMADO CONFIRMADO', 'color' => ''],
        	['estado' => 'R/REPROGRAMADO AFIRMADO', 'color' => ''],
        	['estado' => 'R/REPROGRAMADO ENVIADO', 'color' => ''],
        	['estado' => 'RECLAMO CANCELADO', 'color' => ''],
        	['estado' => 'LLAMAR', 'color' => ''],
        	['estado' => 'RECORDADO Y SIN RESPUESTA', 'color' => ''],
        	['estado' => 'PROVINCIA CONFIRMADO', 'color' => ''],
        	['estado' => 'PROVINCIA PAGADO', 'color' => ''],
        	['estado' => 'PAGADO', 'color' => ''],
        	['estado' => 'RECLAMO A RECOLECTAR', 'color' => ''],
        	['estado' => 'RECLAMO RECOLECTADO', 'color' => ''],
        	['estado' => 'RECLAMO A ENVIAR', 'color' => '']
        ]);
    }
}
