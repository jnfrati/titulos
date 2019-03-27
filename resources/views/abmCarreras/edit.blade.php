@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Editar</div>
    <div class="card-body">
            @if(!isset($carreras))
                <h2>No hay Carreras. </h2>
                <p><h4>Presione el boton Agregar Carrera para crear una nueva</h4></p>
            @elseif($c==null)
                <h1>Seleccionar carrera para editar</h1>
            @else   
                <form method="POST" action="/carrera/edit">
                    @csrf
                    <input hidden type="text" name="id" value="{{$c->id}}"/>
                    <div class="form-group">
                        <label for="escuela">Escuela</label>
                        <input value="{{$c->escuela}}" type="text" class="form-control" id="escuela" name="escuela">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input value="{{$c->nombre}}" type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="resolucion">Resolucion</label>
                        <input value="{{$c->resolucion}}" type="text" class="form-control" id="resolucion" name="resolucion">
                    </div>
                    <div class="form-group">
                        <label for="plan">Plan</label>
                        <input value="{{$c->plan}}" type="text" class="form-control" id="plan" name="plan">
                    </div>
                    <div class="form-group">
                        <label for="tituloAcademico">Titulo que da</label>
                        <input value="{{$c->tituloAcademico}}" type="text" class="form-control" id="tituloAcademico" name="tituloAcademico">
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-success" type="submit">Guardar</button>
                        </div>
                        <div class="col">
                                <div class="col text-right">
                                        <a href="/home" 
                                            class="btn btn-danger" 
                                            role="button" 
                                            aria-pressed="true"
                                            >Cancelar</a>
                                    </div>
                        </div>
                    </div>
                </form>
            @endif 
    </div>
</div>
@endsection