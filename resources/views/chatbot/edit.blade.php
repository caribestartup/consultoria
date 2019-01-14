@extends('default')

@section('title')

@endsection

@section('css')



@endsection

@section('content-chatbot')

    <div class="row orange-row">
        <h1>
            Chatbot create
        </h1>
        <button class="createChatbotButtons">Crea nuevo</button>
    </div>
    <form method="post" action="{{action('ChatbotController@update',$id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-11">
            <div class="row">
                <div class="col-md-4 d-flex flex-column">
                    <h1 class="mb-5">Generales</h1>
                    <label class="mb-3">Nombre del Chatbot</label>
                    <input class="mb-3 light-brown" type="text" name="name" id="name" style="border-radius: 35px" value="{{$chatbot->name}}">
                    <label class="mb-3">Descripcion</label>
                    <textarea class="mb-3 light-brown" name="description" id="description"  style="border-radius: 35px">{{$chatbot->description}}</textarea>
                    <h1 class="mb-5">Enfoque</h1>
                    <label class="mb-3">Seleccione el enfoque del Chatbot</label>
                    <select id="approach" name="approach">
                        @foreach($approachOptions as $opt)
                            <option  @if($loop->index == 0 )selected @endif value="{{$opt}}">{{$opt}}</option>
                        @endforeach
                    </select>
                    <div class="dropdown mb-3">
                        <button class="btn btn-secondary dropdown-toggle light-brown" style="border-radius: 35px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span class="img-menu">
                            <img src="{{ asset("images/assets/micro_contents.png") }}" height="35px" width="35px" />
                                 <label>Microcontenido</label>
                            </span>
                        </button>
                        <div class="dropdown-menu light-brown" aria-labelledby="dropdownMenuButton">
                            @foreach($approachOptions as $option)
                                <a class="dropdown-item" href="#">
                                <span class="img-menu">
                                <img src="{{ asset("images/assets/micro_contents.png") }}" height="35px" width="35px" />
                                     <label>{{$option}}</label>
                                </span>
                                </a>
                            @endforeach


                        </div>
                    </div>

                </div>
                <div class="col-md-4 d-flex flex-column">
                    <label class=  mb-3" style="margin-top: 98px">Respuesta de error predeterminada</label>
                    <textarea class="mb-5 light-brown" style="border-radius: 35px" name="default_response" id="default_response">{{$chatbot->default_response}}</textarea>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dropdownCheck">
                        <label class="form-check-label" for="dropdownCheck">
                            Quiere que el chatbot inicie automáticamente
                        </label>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4 d-flex flex-row">
            <span class="img-menu">
                <button type="submit" class="bg-transparent" style="border:0">
                     <img src="{{ asset("images/assets/micro_contents.png") }}" height="35px" width="35px" />
                     <label>Salvar Chatbot</label>
                </button>
             </span>
        </div>
        <div class="col-md-4 d-flex flex-row">
            <span class="img-menu">
                <button type="submit" class="bg-transparent" style="border:0">
                    <img src="{{ asset("images/assets/micro_contents.png") }}" height="35px" width="35px" />
                         <label>Salvar y diseñar</label>
                </button>
             </span>
        </div>
    </div>
    </div>

    </form>


@endsection

@section('js')
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>


@endsection