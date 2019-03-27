@extends('layouts.app')

@php
function getEstado($estado){
switch($estado){
    case 'cargaDeDatos':
        $estado = "Carga de datos";
        break;
    case 'paraImpresion':
        $estado = "Para impresion";
        break;
    case 'impreso':
        $estado = "Impreso";
        break;
    default:
        $estado = "Error";
}
return $estado;
}
@endphp


@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                Lista de titulos
            </div>
            <div class="col-md-2 justify-content-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCarrera">
                    Nuevo titulo
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <input type="text" id="myInput" onkeyup="filtroDeTitulos()" placeholder="Busqueda por DNI">
        <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                <th scope="col">Nombre y Apellido</th>
                <th scope="col">Dni</th>
                <th scope="col">Carrera</th>
                <th scope="col">Estado</th>
                <th scope="col">Resolucion</th>
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($titulos as $titulo)                
                    <tr class='clickable-row' data-href='/titulo/edit/{{$titulo->id}}'>
                        <td>{{$titulo->nombreYApellido}}</td>
                        <td>{{$titulo->dni}}</td>
                        <td>{{$titulo->carrera()->withTrashed()->getResults()->nombre}}</td>
                        <td>{{getEstado($titulo->estado)}}</td>
                        <td>{{$titulo->carrera()->withTrashed()->getResults()->resolucion}}</td>
                        <td>
                            <a href="/titulo/edit/{{$titulo->id}}" 
                            class="btn btn-warning" 
                            role="button" 
                            aria-pressed="true"
                            >Abrir</a>
                        </td>
                        <td>
                            @if(!$titulo->trashed())
                            <form method="POST" action="/titulo/delete/{{$titulo->id}}" id="borrarTitulo">
                                @csrf
                                {{method_field("DELETE")}}
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                            @else
                            <form method="post" action="/titulo/restaurar/{{$titulo->id}}" id="restaurarTitulo">
                                @csrf
                                <button type="submit"  class="btn btn-danger">Restaurar</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
 <script>
 function filtroDeTitulos() {
    // Declare variables 
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      } 
    }
  }
  function confirmar(accion, nombreEstudiante,idForm){
    if(confirm("Seguro que quiere "+accion+" el titulo de "+nombreEstudiante))
        document.getElementById(idForm).submit();
  }
  </script>
@endsection


@section('outContent')
    @include('abmTitulos.create')
@endsection