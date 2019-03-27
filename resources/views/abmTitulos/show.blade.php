@extends('layouts.app')
@section('content')
@php
$state = " ";
$finalize = " ";
$numTituloValue = "";
$ciclo = "";
$borrador = "";

if($titulo->ciclo){
    $ciclo = "checked";
}
switch ($titulo->estado) {
    case "paraImpresion":
        $estado = "Para impresion";
        if(!Auth::user()->admin)
            $state = "disabled";
        break;
    case "impreso":
        $estado = "Impreso";
        $state = "disabled";
        $finalize = "disabled";
        $numTituloValue = $titulo->numeroDeTitulo;
        break;
    default:
        $estado = "Carga de datos";
        $borrador ="borrador";
        break;
    }
    

@endphp

<!--
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
-->

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-2">Editar Titulo</div>
            <div class="col-4">
                <label><b> Estado: </b>{{$estado}}</label>
            </div>
            <div class="col text-center">
                <button type="button" onclick="document.getElementById('print').submit()" class="btn btn-success" {{$finalize}}>Imprimir {{$borrador}}</button>
            </div>
            @if($titulo->estado == "paraImpresion" || $titulo->estado == "impreso")
                <div class="col text-center">
                     <button type="button" onclick="finalize()" class="btn btn-warning" {{$finalize}}>Pasar a: Impreso</button>
                </div>
            @else
                <div class="col text-center">
                     <button type="button" onclick="document.getElementById('close').submit()" class="btn btn-warning" {{$state}}>Pasar a: Para Impresion</button>
                </div>
            @endif
        </div>       
    </div>
    <div class="card-body">
        <form method="POST" action="/titulo/edit/{{$titulo->id}}">
            @csrf
            @if($titulo->estado != "cargaDeDatos")
                <div class="form-group">
                    <label for="numeroDeTitulo">Numero de titulo</label>
                    <input type="text" class="form-control" id="numeroDeTitulo"
                value="{{$numTituloValue}}"
                        {{$finalize}}
                        required
                    >
                </div>
                    
            @endif
            <div class="form-group">
                <label for="nombre">Nombres y apellidos</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{$titulo->nombreYApellido}}" {{$state}}>
            </div>
            
            <div class="form-group">
                <label for="Dni">Dni</label>
                <input type="text" class="form-control" id="Dni" name="dni" value="{{$titulo->dni}}" {{$state}}>
            </div>
            <div class="form-group">
                <label for="carrera">Carrera</label>
                <select id="carrera" class="custom-select" name="carrera" {{$state}}>
                    @foreach($carreras as $carrera)
                        @if($titulo->carrera->id == $carrera->id)
                            <option value="{{$carrera->id}}" selected>{{$carrera->nombre}}</option>
                        @else
                            <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
                        @endif                
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-check">
                        <label class="form-check-input-label" for="ciclo">Es ciclo </label>
                        <input type="checkbox" class="form-check-label" id="ciclo" name="ciclo" onchange="change()" {{$ciclo}} {{$state}}>
                    </div>
                </div>
                <div class="col-9">
                    <div class="form-group" id="tituloPrevioDiv" style="visibility:hidden;">
                        <div class="row">
                        <div class="col-2">
                                <label for="tituloPrevio">Titulo Previo:</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="tituloPrevio" name="tituloPrevio" value="{{$titulo->tituloPrevio}}" {{$state}}>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="fechaUltimaMateria">Fecha de la ultima materia</label>
                <input type="text" class="form-control" id="fechaUltimaMateria" name="fechaUltimaMateria" value="{{$titulo->fechaUltimaMateria}}" {{$state}}>
            </div>
            <div class="form-group">
                <label for="fechaExpedicionDiploma">Fecha de expedicion de diploma</label>
                <input type="text" class="form-control" id="fechaExpedicionDiploma" name="fechaExpedicionDiploma" value="{{$titulo->fechaExpedicionDiploma}}" {{$state}}>
            </div>
            
            <div class="row ">
                <div class="col text-left">
                    <button type="submit" class="btn btn-success" {{$state}}>Guardar</button>
                </div>
                <div class="col text-right">
                    <a href="/home" 
                        class="btn btn-danger" 
                        role="button" 
                        aria-pressed="true"
                        >Cancelar</a>
                </div>
            </div>
        </form>
        <form id="print" method="POST" action="/titulo/print/{{$titulo->id}}" target="_blank">
            @csrf
        </form>
        <form id="close" method="POST" action="/titulo/close/{{$titulo->id}}">
            @csrf
        </form>
        <form id="finalize" method="POST" action="/titulo/finalize/{{$titulo->id}}">
            @csrf
            <input type="text" name="numeroDeTitulo" id="numTitulo" hidden>
        </form>
    </div>
</div>
<script type="text/javascript">

function finalize(){
    const numeroDeCarton = document.getElementById('numeroDeTitulo').value;
    if(typeof numeroDeCarton === 'undefined' || numeroDeCarton != ""){
        document.getElementById('numTitulo').value = numeroDeCarton;
        document.getElementById('finalize').submit()
    }else   
        alert("Numero de carton requerido");
}
function change(){
    const tituloPrevioDiv = document.getElementById("tituloPrevioDiv");
    if(document.getElementById("ciclo").checked )
        tituloPrevioDiv.style.visibility= "visible";
    else{
        tituloPrevioDiv.style.visibility= "hidden";
    }
}
</script>

@if($ciclo == "checked")
    <script>
        change();
    </script>
@endif

@endsection


@section('right-bar')
    @include('layouts.log')
@endsection