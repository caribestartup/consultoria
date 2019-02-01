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
        <a href="{{'chatbot/create' }}" class="btn btn-app-primary p-10 border-bot mt-3 ml-3">{{ __('Crear nuevo') }}</a>
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
                            <a href="{{ action('ChatbotController@design', ['id' => $chat->id ]) }}">
                                <span class="img-menu">
                                    <img src="{{ asset("images/folder.png") }}" height="30px" width="30px" />
                                </span>
                            </a>
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
                                    'id' => 'delete_form_'.$chat->id,
                                    ])
                            !!}
                                {{-- <button type="button" id="{{ $user->id }}" class="btn btn-light btn-sm fsz-md text-color-primary-header" title="{{ trans('common.delete') }}"><i class="ti-trash"></i></button> --}}
                           
                                {{-- <button type="submit" id="sendbtn" class="btn btn-light btn-sm fsz-md text-color-primary-header" title="{{ trans('common.delete') }}"><i class="ti-trash"></i></button> --}}
                                <a href="" id="{{ $chat->id }}" type="button" style="-webkit-appearance: none;">
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

    @include('components.modal_delete', [
        'modal_id'  => 'delete-modal',
        'title'     => __('common.attention!'),
        'content'   => __('common.delete_entity'),
        'accept'    => __('common.yes'),
        'cancel'    => __('common.no')
    ])
@endsection

@section('js')
    <script type="text/javascript">
        var currentForm;
        $(document).on('click', 'form.deletechatbotform a', function(e) {
            e.preventDefault();
            var id = this.getAttribute("id");
            alertify.defaults.transition = "slide";
            alertify.defaults.theme.ok = "btn btn-primary";
            alertify.defaults.theme.cancel = "btn btn-danger";
            alertify.defaults.theme.input = "form-control";

            var header = document.createElement('modal-title');
            header.appendChild(document.getElementsByClassName('modal-title')[0]);

            var body = document.createElement('modal-content-alert');
            body.appendChild(document.getElementsByClassName('modal-content-alert')[0]);

            alertify.confirm(header, body, function(){
                    alertify.success('Eliminado');
                    currentForm = $('#delete_form_'+id);
                    currentForm.submit();
                },function(){
                    alertify.error('Cancelado');
                }).set({labels:{ok:'Elimanar', cancel: 'Cancelar'}, padding: false});
        });
    </script>
@endsection