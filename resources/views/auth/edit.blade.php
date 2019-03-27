@php
    $var = false;
    if(!isset($u)){
        $var = true;
    }else{
        $checked = "";
        if($u->admin)
            $checked = "checked";
    }
@endphp
<div class="card">
    <div class="card-header">Editar Usuario</div>
    <div class="card-body">
        @if($var)
            Seleccione el boton editar para modificar la informacion o cambiar la contraseña de un usuario
        @else
        <form method="POST" action="/users/edit">
            @csrf
            <input type="text" id="id" value="{{$u->id}}" hidden>
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$u->name}}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>

                <div class="col-md-6">
                    <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{$u->lastname}}" required autofocus>
                </div>
            </div>
                                    
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                <div class="col-md-6">
                    <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $u->email }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 text-md-right">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="adminCheckbox" name="admin" value="1" {{$checked}}>
                    <label class="form-check-label" for="adminCheckbox">Admin</label>
                </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Finalizar') }}
                    </button>
                </div>
            </div>
        </form>
        @endif

    </div>
</div>
