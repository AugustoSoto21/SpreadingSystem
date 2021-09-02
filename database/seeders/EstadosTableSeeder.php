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
        	
        	['estado' => 'CONFIRMADO', 'color' => '#d9d9d9', 'status_stock' => 'MANTIENE'],
        	['estado' => 'AFIRMADO', 'color' => '#b6d7a8', 'status_stock' => 'DECREMENTA'],
        	['estado' => 'POR CONFIRMAR', 'color' => '#ffe599', 'status_stock' => 'MANTIENE'],
        	['estado' => 'NO CONTESTA', 'color' => '#ea9999', 'status_stock' => 'MANTIENE'],
        	['estado' => 'CANCELADO', 'color' => '#666666', 'status_stock' => 'INCREMENTA'],
        	['estado' => 'LLEGÓ Y NO ENTREGÓ', 'color' => '#666666', 'status_stock' => 'MANTIENE'],
        	['estado' => 'EN CAMINO', 'color' => '#d9d9d9', 'status_stock' => 'MANTIENE'],
        	['estado' => 'ENVIADO', 'color' => '#3fdf96', 'status_stock' => 'MANTIENE'],
        	['estado' => 'CANCELADO ALMACENADO', 'color' => '#d31212', 'status_stock' => 'MANTIENE'],//P
        	['estado' => 'LLAMAR', 'color' => '#00ff00', 'status_stock' => 'MANTIENE'],
        	['estado' => 'LLEGADO ALMACENADO', 'color' => '#d31212', 'status_stock' => 'MANTIENE'],//LO TIENE UNA AGENCIA EN SU DEPÓSITO----P
            //NADA EN PERU
        	['estado' => 'REPROGRAMADO CONFIRMADO', 'color' => '', 'status_stock' => 'MANTIENE'],
        	['estado' => 'REPROGRAMADO AFIRMADO', 'color' => '#3fdf96','status_stock' => 'MANTIENE'],
        	['estado' => 'REPROGRAMADO ENVIADO', 'color' => '#3fdf96','status_stock' => 'MANTIENE'],
        	//----
        	//['estado' => 'RECLAMO', 'color' => '#ff9900', 'status_stock' => 'MANTIENE'],
        	['estado' => 'RECLAMO A RECOLECTAR', 'color' => '#ff9900', 'status_stock' => 'MANTIENE'],
        	['estado' => 'RECLAMO RECOLECTADO', 'color' => '#00ffff','status_stock' => 'MANTIENE'],
            
            ['estado' => 'R/FALLA NO REPARABLE', 'color' => '#00ffff','status_stock' => 'DECREMENTA'],
            ['estado' => 'R/FALLA NO REPARABLE CAMBIO', 'color' => '#00ffff','status_stock' => 'DECREMENTA'],
            ['estado' => 'R/FALLA REPARABLE', 'color' => '#00ffff','status_stock' => 'MANTIENE'],
            ['estado' => 'R/FALLA REPARABLE CAMBIO', 'color' => '#00ffff','status_stock' => 'DECREMENTA'],
            ['estado' => 'R-CAMBIO PRODUCTO', 'color' => '#00ffff','status_stock' => 'DECREMENTA'],

        	['estado' => 'R/CONFIRMADO', 'color' => '#ff9900', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/AFIRMADO', 'color' => '#ff9900', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/CANCELADO', 'color' => '#666666', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/LLEGÓ Y NO ENTREGÓ', 'color' => '#666666', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/EN CAMINO', 'color' => '#ff9900','status_stock' => 'DECREMENTA'],
        	['estado' => 'R/ENVIADO', 'color' => '#e69138','status_stock' => 'DECREMENTA'],
        	['estado' => 'R/CANCELADO ALMACENADO', 'color' => '#d31212', 'status_stock' => 'MANTIENE'],

        	['estado' => 'R/LLEGADO ALMACENADO', 'color' => '', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/REPROGRAMADO CONFIRMADO', 'color' => '', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/REPROGRAMADO AFIRMADO', 'color' => '', 'status_stock' => 'MANTIENE'],
        	['estado' => 'R/REPROGRAMADO ENVIADO', 'color' => '', 'status_stock' => 'MANTIENE'],
        	
        	['estado' => 'PROVINCIA CONFIRMADO', 'color' => '#9900ff','status_stock' => 'DECREMENTA'],
        	['estado' => 'PROVINCIA PAGADO', 'color' => '#d9d9d9','status_stock' => 'DECREMENTA'],
        	['estado' => 'PAGADO', 'color' => '', 'status_stock' => 'MANTIENE'],
        	['estado' => 'RECLAMO A ENVIAR', 'color' => '#ff9900', 'status_stock' => 'DECREMENTA'],
            ['estado' => 'RECLAMO ENTREGADO ', 'color' => '#00ffff','status_stock' => 'MANTIENE'],
            ['estado' => 'ENTREGADO', 'color' => '#00ffff', 'status_stock' => 'DECREMENTA' ],
        	['estado' => 'RECLAMO SOLUCIONADO', 'color' => '#00ffff','status_stock' => 'MANTIENE'],
        	['estado' => 'RECLAMO CANCELADO', 'color' => '#666666', 'status_stock' => 'MANTIENE']

        ]);
    }
}
