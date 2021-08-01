<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_agencia');
            $table->unsignedBigInteger('id_producto');
            $table->integer('stock')->nullable()->default(0);
            $table->integer('stock_disponible')->nullable()->default(0);//son los que se descuentan cuando los pedidos aún no finalizan
            $table->integer('stock_min')->nullable()->default(0);
            $table->integer('stock_fallas')->nullable()->default(0);//son los que fueron reportados con fallas
            $table->integer('stock_reclamos')->nullable()->default(0);//son los reclamos de pedidos
            $table->integer('stock_devueltos')->nullable()->default(0);//son los devueltos de pedidos


            $table->foreign('id_agencia')->references('id')->on('agencias')->onDelete('cascade');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');
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
        Schema::dropIfExists('almacens');
    }
}
