@extends('default')

@section('title')
    {{ trans_choice('common.user', 2) }}
@endsection

@section('css')
    <style>
        #create-bar {            width: 98%;
        }
        .Administrador {
            color: #EE6255;
        }
        .Jefe {
            color: #79C944;
        }
        .Empleado {
            color: #FFAD00;
        }
    </style>
    @endsection

@section('content')
    <div class="row title-page-buttom">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8 col-xl-8 " >
            @include('components.index_create', [
                'title' => trans_choice('common.user', 2),
                'url'   => route('users.create'),
                'create'=> __('users.new_user_header')
            ])

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
                                <div class="card text-center card-action-plan border-form h-100 pT-15 pB-15">

                                    @if($user->avatar)
                                        <img class="card-img-top w-5r bdrs-50p mx-auto" src="{{ asset('/uploads/avatars/'.$user->avatar) }}" alt="{{ trans('users.user_avatar_alt') }}">
                                        @else
                                        <img class="card-img-top w-5r bdrs-50p mx-auto" src="{{ asset('/uploads/avatars/unknown.png') }}" alt="{{ trans('users.user_avatar_alt') }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title"> <a href="{{ route('users.show', $user->id) }}" title="{{ trans('common.data') }}" class="text-color-primary-header">{{ $user->name.' '.$user->last_name }}</a> </h5>

                                        <p class="card-subtitle {{ $user->rol }}">
                                            {{ $user->rol }}
                                        </p>
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

    <!-- </div> -->



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
