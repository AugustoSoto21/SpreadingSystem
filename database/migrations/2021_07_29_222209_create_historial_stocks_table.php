<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_agencia');
            $table->enum('locker',['SIN PROBAR','STOCK','FALLA','CAMBIO']);
            $table->unsignedBigInteger('id_producto');
            $table->integer('cantidad');
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
        Schema::dropIfExists('historial_stocks');
    }
}
