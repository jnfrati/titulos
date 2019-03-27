@extends('layouts.app')
@section('content')
@php
if(Auth::user()->admin){
  $logs = App\Log::orderBy('created_at','desc')->get();    
}else {
  $logs = Auth::user()->log()->orderBy('created_at', 'desc')->get();
}




@endphp
@if($logs != null)
<div style="max-height:500px; overflow-y:auto;">
  <table class="table table-bordered table-black" >
    <thead>
      <tr>
        <th scope="col">Fecha</th>
        <th scope="col">User</th>
        <th scope="col">Operacion</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      
      @foreach ($logs as $log)
        @if(null == (App\User::onlyTrashed()->get()->find($log->user_id)))
        <tr>
            <th scope="row">{{$log->created_at}}</td>
            <td>{{App\User::get()->find($log->user_id)->email}}</td>
            <td>{{$log->operation}}</td>
            <td>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#log{{$log->id}}">
                  Abrir
                </button>
            </td>
        </tr>    
        <div class="modal" id="log{{$log->id}}" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Log- Fecha: {{$log->created_at}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Operacion: {{$log->operation}}</p>
                <p>Descripcion: {{$log->description}}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        @endif
      @endforeach
</tbody>
</table>
</div>
@endif
    
@endsection
