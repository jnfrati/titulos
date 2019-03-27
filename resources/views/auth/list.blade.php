@extends('layouts.app')
@section('content')
<table class="table table-striped" id="myTable">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre y Apellido</th>
        <th scope="col">Username</th>
        <th scope="col">Editar</th>
        <th scope="col">Eliminar/Restaurar</th>
      </tr>
    </thead>
    <tbody>
      
        @foreach ($users as $user)
        
        <tr >
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->name}}, {{$user->lastname}}</td>
            <td>{{$user->email}}</td>
            <td>
                <button type="button" onclick='location.href="/users/list/{{$user->id}}"' class="btn btn-primary">Editar</button>
                
            </td>
            @if(!$user->trashed())
            <td>
                <button type="button" onclick="document.getElementById('delete{{$user->id}}').submit()" class="btn btn-danger">Eliminar</button>
                <form id="delete{{$user->id}}" method="POST" action="/users/delete/{{$user->id}}">
                    @csrf
                    {{method_field("DELETE")}}
                </form>
            </td>
            @else
            <td>
                <button type="button" onclick="document.getElementById('restore{{$user->id}}').submit()" class="btn btn-warning">Restaurar</button>
                <form id="restore{{$user->id}}" method="POST" action="/users/restore">
                    @csrf
                    {{method_field("PATCH")}}
                    <input type="text" id="id" name="id" value="{{$user->id}}" hidden>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@endsection


@section('right-bar')
@include('auth.edit')
@endsection
