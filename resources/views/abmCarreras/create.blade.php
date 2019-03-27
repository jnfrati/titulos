
{{--
    /*
    $table->increments('id');
    $table->string('escuela');
    $table->string('nombre');
    $table->string('resolucion');
    $table->string('plan');
    $table->string('tituloAcademico');
    */
--}}    
<div class="modal" id="createCarrera" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar Carrera</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="create" method="POST" action="/carrera/create">
                @csrf
                <div class="form-group">
                  <label for="escuela">Escuela</label>
                  <input type="text" class="form-control" id="escuela" name="escuela">
                </div>
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="resolucion">Resolucion</label>
                    <input type="text" class="form-control" id="resolucion" name="resolucion">
                </div>
                <div class="form-group">
                    <label for="plan">Plan</label>
                    <input type="text" class="form-control" id="plan" name="plan">
                </div>
                <div class="form-group">
                    <label for="titulo">Titulo que da</label>
                    <input type="text" class="form-control" id="titulo" name="tituloAcademico">
                </div>
            </form>
        </div>
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <button type="button" class="btn btn-primary mb-3" style=""
                    onclick="document.getElementById('create').submit()">Enviar</button>
                </div>
                <div class="col text-center">
                <button type="button" class="btn btn-secondary mb-3" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>