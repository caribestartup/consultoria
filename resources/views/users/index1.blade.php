@extends('default')

@section('title')
    {{ trans_choice('common.user', 2) }}
@endsection

@section('css')
    <style>
        #create-bar {
            width: 98%;
        }
    </style>
    @endsection

@section('content')
 <div class="row title-page-buttom">
        <div class="col-xs-12 col-sm-6">
             @include('components.index_create', [
                'title' => trans_choice('common.user', 2),
                'url'   => route('users.create'),
                'create'=> __('users.new_user_header')
            ])
        </div>
    </div>
    <div class="row  ">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8 col-xl-8 text-white mB-20" >
           
          <!-- filtro
           <div class="col-sm-12 col-md-12 col-lg-4 form-group  pT-70 pR-30 pL-40">
                {!! Form::open(['method'=>'GET','url'=>'users','role'=>'search'])  !!}
                    <div class="row">
                        <div class="input-group">
                        {{ Form::input("text", "search", request()->session()->get('search'), array_merge(["placeholder" => trans('common.search_by_name'), "class" => "form-control"])) }}
                            <div class="input-group-append">
                                <button class="btn btn-app-primary btn-default-sm" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3 d-flex justify-content-end">
                        <div class="col-12 float-right">
                            <p class="text-color-primary-header font-weight-bold font">{{ trans('users.filter_by_role') }}</p>
                        <div>
                        @foreach($roles as $role)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="role_search_check_{{ $role->id }}" name="role_search_check_{{ $role->id }}"
                                       @if(request()->session()->has('role_search_check_'.$role->id) && strcmp(request()->session()->get('role_search_check_'.$role->id), "on") == 0)
                                       checked
                                        @endif
                                >
                                <label class="custom-control-label" for="role_search_check_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>-->
        </div>
            <div class="bdrs-3 mB-20">
                @if(!empty($users))
                    <nav class="mb-1">
                        <ul class="pagination justify-content-center">
                            {{$users->links('vendor.pagination.bootstrap-4')}}
                        </ul>
                    </nav>

                    <div class="row">
                        @foreach ($users as $user)
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mB-5" id="items">
                                <div class="card text-center h-100 pT-15 pB-15 border-form">

                                    <img class="card-img-top w-5r bdrs-50p mx-auto" src="{{ $user->avatarUrl }}" alt="{{ config('app.user_avatar_alt') }}">
                                    <div class="card-body">
                                        <h5 class="card-title"> <a href="{{ route('users.show', $user->id) }}" title="{{ trans('common.data') }}" class="text-color-primary-header">{{ $user->name.' '.$user->last_name }}</a> </h5>
                                        @foreach($user->roles as $role)
                                            <p class="card-subtitle" style="color:{{ $role->color }};">
                                                {{ $role->name }}
                                            </p>
                                        @endforeach
                                    </div>

                                    <ul class="list-inline list-group-flush">
                                        <li class="list-inline-item">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-light btn-sm fsz-md text-color-primary-header" title="{{ trans('common.edit') }}"><i class="ti-pencil"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            {!! Form::open([
                                                    'class'=>'deleteuserform',
                                                    'url'  => route('users.destroy', $user->id),
                                                    'method' => 'DELETE',
                                                    'id' => 'delete_form',
                                                    ])
                                                !!}
                                            <button type="button" id="sendbtn" class="btn btn-light btn-sm fsz-md text-color-primary-header" title="{{ trans('common.delete') }}"><i class="ti-trash"></i></button>
                                            {!! Form::close() !!}
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <nav class="mt-1">
                        <ul class="pagination justify-content-center">
                            {{$users->links('vendor.pagination.bootstrap-4')}}
                        </ul>
                    </nav>
                @endif
            </div>

        </div>
        
    </div>



    @include('components.modal', [
        'modal_id'  => 'delete-modal',
        'title'     => __('common.attention!'),
        'content'   => __('users.delete_user_question'),
        'accept'    => __('common.yes'),
        'cancel'    => __('common.no')
        ])

@endsection

@section('js')
    <script src="{{ asset('/plugins/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap4/js/bootstrap.min.js') }}"></script>
    <script>
        var currentForm;
        $(document).on('click', 'form.deleteuserform button', function() {
            currentForm = $(this).closest("form")
            $('#delete-modal').modal('show')
        });
        // function predelete(val) {
        //     currentForm = $(this).closest("form")
        //     $('#delete-modal').modal('show')
        // }
        $('#delete-modal .accept-button').click(function () {
            currentForm.submit();
        });
    </script>
@stop