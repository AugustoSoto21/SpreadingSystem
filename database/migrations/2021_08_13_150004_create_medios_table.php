<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medios', function (Blueprint $table) {
            $table->id();
            $table->string('medio');
            $table->float('porcentaje');
            $table->unsignedBigInteger('id_iva');
            $table->enum('status',['Activo','Inactivo'])->default('Activo');
            $table->enum('comision',['Si','No'])->default('Si');

            $table->foreign('id_iva')->references('id')->on('ivas')->onDelete('cascade');
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
        Schema::dropIfExists('medios');
    }
}
