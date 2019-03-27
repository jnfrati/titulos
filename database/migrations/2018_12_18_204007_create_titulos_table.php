<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titulos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreYApellido');
            $table->string('dni');
            
            $table->boolean('ciclo');
            $table->string('tituloPrevio')->nullable();

            $table->string('fechaUltimaMateria');
            $table->string('fechaExpedicionDiploma');

            $table->integer('numeroDeTitulo')->default("-1");


            $table->enum('estado', ['cargaDeDatos', 'paraImpresion', 'impreso'])->default('cargaDeDatos');
            
            $table->integer('carrera_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titulos');
    }
}
