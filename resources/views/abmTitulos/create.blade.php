{{-- Necesita los parametros $location:String $carreras:[Carrera] --}}
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
<div class="modal" id="createCarrera" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Creacion de titulo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="/titulo/create">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombres y apellidos</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="Dni">Dni</label>
                    <input type="text" class="form-control" id="Dni" name="dni">
                </div>
                <div class="form-group">
                    <label for="carrera">Carrera</label>
                    <select class="custom-select" name="carrera" id="carrera">
                        <option selected>Abrir para seleccionar una carrera</option>
                    @foreach($carreras as $carrera)
                        <option value="{{$carrera->id}}">{{$carrera->nombre}} / Plan: {{$carrera->plan}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-3">    
                        <div class="form-check">
                            <label class="form-check-input-label" for="ciclo">Es ciclo </label>
                            <input type="checkbox" class="form-check-label" id="ciclo" name="ciclo" onchange="change()">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group" id="tituloPrevioDiv" style="visibility:hidden;">
                            <input type="text" class="form-control" id="tituloPrevio" name="tituloPrevio" placeholder="Titulo previo">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="fechaUltimaMateria">Fecha de la ultima materia</label>
                    <input type="text" class="form-control" id="fechaUltimaMateria" name="fechaUltimaMateria">
                </div>
                <div class="form-group">
                    <label for="fechaExpedicionDiploma">Fecha de expedicion de diploma</label>
                    <input type="text" class="form-control" id="fechaExpedicionDiploma" name="fechaExpedicionDiploma">
                </div>
                        
                <button type="submit" class="btn btn-success right">Guardar</button>
            </form>
        </div>
    </div>
    </div>
</div>

<script type="text/javascript">
    function change(){
        const tituloPrevioDiv = document.getElementById("tituloPrevioDiv");
        if(document.getElementById("ciclo").checked )
            tituloPrevioDiv.style.visibility= "visible";
        else{
            tituloPrevioDiv.style.visibility= "hidden";
        }
    }
</script>
