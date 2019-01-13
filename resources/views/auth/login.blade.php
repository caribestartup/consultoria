@extends('layouts.app')

@section('content')
    <div class="bgc-white pos-a centerXY p-15 modal-home  fondo_transp " >

        {{--<h4 class="fw-300 c-grey-900 mB-40">{{ __('common.login') }}</h4>--}}
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

  <div class="form-group">
  <div class="row">
    <div class="col-lg-2">
        <div class="bgc-white bdrs-50p pos-r" style='width: 40px; height: 40px;'>
             <img class="pos-a centerXY" src="/images/assets/users_log.png" alt="">
        </div>
    </div>
    <div class="col-lg-8">
    <p class="parr">Bienvenido a<br>Rocket Learning</p>
       
    </div>
  </div>
  </div>
 

<div class="text-center">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}  " >
                <input id="identity" type="identity" class=" input-text" name="identity" placeholder="{{ trans_choice('common.user', 1) }}" value="{{ old('email') }}" required autofocus>
               

                @if ($errors->has('email'))
                    <span class="form-text text-danger ">
                    <small>{{ $errors->first('email') }}</small>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} ">
                <input id="password" type="password" class="input-text" name="password" placeholder="{{ __('common.password') }}" required>
             

                @if ($errors->has('password'))
                    <span class="form-text text-danger">
                    <small>{{ $errors->first('password') }}</small>
                </span>
                @endif
            </div>
</div>
            <!--<div class="form-group">
                <div class="custom-checkbox custom-control">
                    <input type="checkbox" id="remember" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="custom-control-label">{{ __('common.remember_me') }}</label>
                </div>
            </div>-->

            <div class="text-center">
                <button class="btn btn-app-primary">{{ __('login.login') }}</button>
  <div class="form-group">
  <div class="row" style="padding-top: 20px">
    <div class="col-lg-2">
        <div class="bgc-white bdrs-50p pos-r" style='width: 40px; height: 40px;'>
             <img class="pos-a centerXY" src="/images/assets/users_add.png" alt="">
        </div>
    </div>
    <div class="col-lg-8">
    <p class="parr">No tiene cuenta todavía?<br>
    <a href="{{ route('register') }}" class="c-orange-800">{{ __('login.register_here') }} </a></p>
       
    </div>
  </div>
  </div>
                
               
            </div>
            {{--<div class="peers ai-c jc-sb fxw-nw">--}}
            {{--<div class="peer">--}}
            {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
            {{--Forgot Your Password?--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--<div class="peer">--}}
            {{--<a href="/register" class="btn btn-link">Create new account</a>--}}
            {{--</div>--}}
            {{--</div>--}}
        </form>
    </div>
@endsection
