<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_user');
            
            $table->unsignedBigInteger('id_producto');
            $table->integer('cantidad');
            $table->float('monto_und');
            $table->float('total_pp');//total por producto
            $table->float('monto_descuento')->default(0);//de la factura
            $table->float('porcentaje_descuento')->default(0);//de la factura
            $table->float('descuento_total')->default(0);
            //en cuanto a pago por mercado pago
            $table->float('iva_total')->default(0);
            $table->float('monto_ct')->default(0);
            $table->float('recargo_ct')->default(0);//de la factura
            $table->float('total_ct')->default(0);
            $table->integer('id_cuota')->default(0);
            $table->float('cuotas_ct')->default(0);
            $table->float('interes_ct')->default(0);
            
            $table->float('total_fact')->default(0);

            //en cuanto  pago de delivery
            $table->integer('id_zona')->default(0);
            $table->enum('envio_gratis',['Si','No'])->default('Si');
            $table->integer('id_tarifa')->default(0);
            $table->float('monto_tarifa')->default(0);
            $table->string('link')->nullable();
            
            $table->unsignedBigInteger('id_fuente');
            $table->unsignedBigInteger('id_estado');
            $table->text('observacion')->nullable();
            
            /*$table->enum('status_deposito',['Depositado','Por Depositar'])->default('Depositado');*/

            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_fuente')->references('id')->on('fuentes');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_estado')->references('id')->on('estados');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
