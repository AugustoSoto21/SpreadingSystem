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
            $table->timestamp('fecha');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_tarifa');
            $table->string('link');
            $table->enum('envio_gratis',['Si','No'])->default('Si');
            $table->float('monto_envio');
            $table->unsignedBigInteger('id_fuente');
            $table->unsignedBigInteger('id_recepcionista');
            $table->unsignedBigInteger('id_estado');
            $table->text('observacion')->nullable();
            $table->unsignedBigInteger('id_agencia');
            $table->enum('status_deposito',['Depositado','Por Depositar'])->default('Depositado');

            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_tarifa')->references('id')->on('tarifas');
            $table->foreign('id_fuente')->references('id')->on('fuentes');
            $table->foreign('id_recepcionista')->references('id')->on('recepcionistas');
            $table->foreign('id_estado')->references('id')->on('estados');
            $table->foreign('id_agencia')->references('id')->on('agencias');



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
