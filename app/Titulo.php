<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Titulo extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 
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
     */
    protected $fillable = [
        'nombreYApellido','dni','ciclo','fechaUltimaMateria','fechaExpedicionDiploma'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function carrera(){
        return $this->belongsTo('App\Carrera');
    }
}
