@extends('default')

@section('title')

@endsection

@section('css')



@endsection

@section('content-chatbot')

    <div class="row orange-row d-flex align-items-start mb-5">
        <h1 class="text-white ml-3">
            Chatbots
        </h1>

        <a  href="{{'chatbot/create' }}" class="btn btn-app-primary p-10 border-bot mt-3 ml-3">{{ __('Crear nuevo') }}</a>

    </div>

    <div class="row ">
        @foreach($chatbots as $chat)
        <div class="col-md-4 mb-5" style="border: 0">
            <div class="card" style="border-radius: 35px">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                             <span class="img-menu">
                                <img src="{{ asset("images/accept.png") }}" height="30px" width="35px" />
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label>{{$chat->name}}</label>
                        </div>
                        <div class="col-md-2">
                            <span class="img-menu">
                                <img src="{{ asset("images/folder.png") }}" height="30px" width="30px" />
                            </span>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('chatbot.edit',$chat->id) }}">
                             <span class="img-menu">
                                <img src="{{ asset("images/option.png") }}" height="30px" width="30px" />
                            </span>
                            </a>
                        </div>
                        <div class="col-md-2">
                            {!! Form::open([
                                    'class'=>'deletechatbotform',
                                    'url'  => route('chatbot.destroy',$chat->id),
                                    'method' => 'DELETE',
                                    'id' => 'delete_form',
                                    ])
                                !!}
                                <button type="submit" id="sendbtn" class="btn btn-light btn-sm fsz-md text-color-primary-header" title="{{ trans('common.delete') }}"><i class="ti-trash"></i></button>
                                <a href="" type="button">
                                    <span class="img-menu">
                                        <img src="{{ asset("images/trash.png") }}" height="30px" width="30px" />
                                    </span>
                                </a>
                            {!! Form::close() !!}
                            
                        </div>
                        <div class="col-md-11 ml-3 ">
                            <label>{{$chat->description}}</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="d-flex justify-content-center">Creado el: {{$chat->created_at}}</label>
                        </div>
                        <div class="col-md-4 d-flex flex-column ">
                            <label class="d-flex justify-content-center">Interacciones</label>
                            <span class="img-menu">
                            <img src="{{ asset("images/assets/micro_contents.png") }}" height="35px" width="35px" />
                            </span>
                            <label class="d-flex justify-content-center" style="color:  #ed5919">25</label>
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-center">
                            <label class="d-flex justify-content-center">Enfoque</label>
                            <span class="img-menu">
                            <img src="{{ asset("images/assets/micro_contents.png") }}" height="35px" width="35px" />
                            </span>
                            <label class="d-flex justify-content-center">{{$chat->approach}}</label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @endforeach


    </div>


@endsection

@section('js')
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>


@endsection