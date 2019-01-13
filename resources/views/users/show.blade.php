@extends('default')

@section('title')
    {{ trans_choice('common.user', 1). ' '  . $user->fullName() }}
@endsection

@section('content')
    @include('components.index_top', ['indexes' => [
        trans_choice('common.user', 2),	$user->fullName()
        ]])

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-7">
            <div class="row p-10 mT-20 mB-20">
                <div class="col-12">
                    <div class="text-color-primary-header font-weight-bold float-left">
                        {{ trans('users.data_header') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-5"></div>
    </div>

    <div class="row mB-20 bgc-white p-20">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
            <h5 class="text-color-primary-header">{{ trans('users.general_data') }}</h5>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-9">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label fw-600">{{ trans('users.label_username') }}</label>
                        <div class="col-sm-12 col-md-10 col-form-label">
                            <label>{{ $user->name }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label fw-600">{{ trans('users.label_lastname') }}</label>
                        <div class="col-sm-12 col-md-10 col-form-label">
                            <label>{{ $user->last_name }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label fw-600">{{ trans('users.label_email') }}</label>
                        <div class="col-sm-12 col-md-10 col-form-label">
                            <label>{{ $user->email }}</label>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 d-flex justify-content-center">
                    <img class="bdrs-50p w-100 mx-auto" src="{{ asset($user->avatar) }}" alt="{{ trans('users.user_avatar_alt') }}">
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 my-2">
            <h5 class="text-color-primary-header">Permisos</h5>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-9">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label fw-600">{{ trans('users.label_role') }}</label>
                        <div class="col-sm-12 col-md-10 col-form-label">
                            <label>
                                @foreach($user->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
