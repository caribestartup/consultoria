@extends('layouts.app')

@section('content')
    <div class="bgc-white pos-a centerXY p-15 modal-home fondo_transp">
        
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <div class="row">
                <div class="col-lg-2">
                    <div class="bgc-white bdrs-50p pos-r" style='width: 40px; height: 40px;'>
                         <img class="pos-a centerXY" src="/images/assets/users_add.png" alt="">
                    </div>
                </div>
                <div class="col-lg-8">
                <h4 class="parr">Registro<br>
                </h4>
                   
    </div>
  </div>
  </div>
  <div class="text-center">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                
                <input id="name" type="text" class="input-text" name="name" value="{{ old('name') }}" required autofocus placeholder="Nombre">

                @if ($errors->has('name'))
                    <span class="form-text text-danger">
                    <small>{{ $errors->first('name') }}</small>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                
                <input id="email" type="email" class="input-text" name="email" value="{{ old('email') }}" required placeholder="EMail">

                @if ($errors->has('email'))
                    <span class="form-text text-danger">
                    <small>{{ $errors->first('email') }}</small>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              
                <input id="password" type="password" class="input-text" name="password" required placeholder="Contraseña">

                @if ($errors->has('password'))
                    <span class="form-text text-danger">
                    <small>{{ $errors->first('password') }}</small>
                </span>
                @endif
            </div>

            <div class="form-group">
                
                <input id="password_confirmation" type="password" class="input-text" name="password_confirmation" required placeholder="Confirmar Contraseña">

            </div>

            <div class="text-center">
               <button class="btn btn-app-primary">Registrar</button>
  <div class="form-group">
  <div class="row" style="padding-top: 20px">
    
    <div class="col-lg-8">
    <a href="/login" parr>Tengo una cuenta</a><br>
    
       
    </div>
  </div>
  </div>
                
        </div>


               
            </div>

        </form>
    </div>
@endsection



