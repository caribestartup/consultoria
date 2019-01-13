@extends('default')

@section('page-header')
    {{ trans('app.user') }} <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')

    <div class="row mB-20 bgc-white p-20">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
            <h5 class="text-primary">Datos Generales</h5>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-1 col-md-9">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ trans('app.label_username') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <label>{{ $user->name }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ trans('app.label_lastname') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <label>{{ $user->last_name }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-12 col-md-2 col-form-label">{{ trans('app.label_email') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <label>{{ $user->email }}</label>
                        </div>
                    </div>

                </div>
                <div class="bg-warning col-sm-1 col-md-3 p-10">
                    <img class="bdrs-50p mx-auto" src="{{ $user->avatar }}" alt="{{ trans('app.user_avatar_alt') }}">
                    {{--<div class="profile-image-container w-100 c-green-300">--}}
                    {{--<div id="cropContainerEyecandy"></div>--}}
                    {{--</div>--}}
                    {{--<div class="uploadButton">--}}
                    {{--<a class="btn btn-primary w-100" id="upload-button">Upload new photo</a>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>

@stop
