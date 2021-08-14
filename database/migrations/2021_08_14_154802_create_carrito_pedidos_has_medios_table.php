<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritoPedidosHasMediosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrito_pedidos_has_medios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_carrito');
            $table->unsignedBigInteger('id_cuota');

            $table->foreign('id_carrito')->references('id')->on('carrito_pedido');
            $table->foreign('id_cuota')->references('id')->on('cuotas');
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
        Schema::dropIfExists('carrito_pedidos_has_medios');
    }
}
