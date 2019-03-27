<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Carrera extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
        $table->increments('id');
        $table->integer('resolucion');
        $table->string('plan');
        $table->string('nombre');
        $table->string('escuela');
        $table->string('tituloAcademico');
     */
    protected $fillable = [
        'resolucion','plan','nombre','tituloAcademico','escuela'
    ];

    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function titulo(){
        return $this->hasMany('App\Titulo');
    }
}
