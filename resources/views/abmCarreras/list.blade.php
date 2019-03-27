@extends('layouts.app')

@section('content')
<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10">
                    Lista de carreras
                </div>
                <div class="col-md-2">
                        <div class="text-center">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCarrera">
                                Agregar Carrera
                            </button>
                        </div>
                </div>
            </div>
        </div>
        <div class="card-body">

<table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Escuela</th>
        <th scope="col">Nombre</th>
        <th scope="col">Resolucion</th>
        <th scope="col">Plan</th>
        <th scope="col">
            Editar
        </th>
        <th scope="col">
            Borrar
        </th>
      </tr>
    </thead>
    <tbody>
        @foreach ($carreras as $carrera)
            <tr>
                <th scope="row">{{$carrera->escuela}}</th>
                <td>{{$carrera->nombre}}</td>
                <td>{{$carrera->resolucion}}</td>
                <td>{{$carrera->plan}}</td>
                <td>
                    <form id="print" method="POST" action="/carrera/show/{{$carrera->id}}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </form>                    
                </td>
                <td>
                <form id="delete" method="POST" action="/carrera/delete/{{$carrera->id}}">
                    @csrf
                    {{method_field('DELETE')}}
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
                </td>
            </tr>    
        @endforeach
    </tbody>
</table>
        </div>
        
@endsection



@section('outContent')
    @include('abmCarreras.create')
@endsection
