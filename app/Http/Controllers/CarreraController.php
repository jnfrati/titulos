<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Carrera;
class CarreraController extends Controller
{
    /*
    $table->increments('id');
    $table->string('escuela');
    $table->string('nombre');
    $table->string('resolucion');
    $table->string('plan');
    $table->string('tituloAcademico');
    */


    public function create(){
        Carrera::create(request()->except('_token'));
        return back();
    }
    public function edit(){
        $c = Carrera::get()->find(request()->id);
        $c->update(
                request()->except('_token')
            );
        return redirect()->back()
                    ->withInput(request()->input());
    }
    public function delete($id){
        $c = Carrera::find($id);
        $c->delete();
        return back();
    }
}
