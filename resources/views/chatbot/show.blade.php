@extends('default')

@section('content')


    <!--Breadcrum-->
    <div class="row ">
        <nav aria-label="breadcrumb"  role="navigation">
            <ol class="breadcrumb" style="background-color: #E6E6E6">
                <li class="breadcrumb-item"><a href="{{ route('chatbot.index') }}">Chatbot</a></li>
                <li class="breadcrumb-item"><a href="#">Create</a></li>
            </ol>
        </nav>
    </div>
    <form method="post" action="{{action('ChatbotController@update',$id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">

        <div class="row ">
            <div class="col-md-6 bg-white">
                <div class="row">

                    <div class="col-md-4 pr-0 pt-2">
                        <label>Título del Chatbot</label>
                    </div>
                    <div class="col-md-8 pl-0  bg-white pt-2">
                        <input type="text" class="border-0 graywithout" name="title" value="{{$chatbot->title}}" placeholder="Introduzca el título del chatbot" style="width: 100%" disabled>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-4 pr-0 pt-2">
                        <label>Descripción del Chatbot</label>
                    </div>
                    <div class="col-md-8 pl-0  bg-white pt-2">
                        <input type="text" class="border-0 graywithout" name="descrption" value="{{$chatbot->description}}" placeholder="Introduzca la descripción del chatbot" style="width: 100%" disabled>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-4 pr-0 pt-2">
                        <label>Evento asociado del Chatbot</label>
                    </div>
                    <div class="col-md-8 pl-0  bg-white pt-2">
                        <input type="text" class="border-0 graywithout" name="interaction" value="{{$chatbot->interaction}}" placeholder="Introduzca el evento asociado al chatbot" style="width: 100%" disabled>
                    </div>

                </div>
            </div>

        </div>


    </form>





@endsection