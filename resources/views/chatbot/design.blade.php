@extends('default')

@section('title')
    
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
    <style>
        .mt-12{
            margin-top: 6rem !important;
        }
        .dd-question-custom {
            color:#fff !important;
            background:#3d9fd0;
        }
        .dd-question-custom:hover {
            color:#fff !important; 
            background:#3d9fd0c7 !important;
        }
        .dd-answer-custom:hover {
            color:black !important; 
            background:#e2e2e2 !important;
        }
        .dd-height {
            height: auto;
        }
        b{
            color: #3d9fd0;
        }
        .dd-width{
            width: 100% !important;
        }
        .dd-collapse {
            color:#fff !important;
        }
        .dd-expand {
            color:#fff !important;
        }
        .dd-answer-custom{
            background: #e2e2e2;
            /* margin: 5px 0px 5px 5px;
            padding: 5px 10px;
            height: 30px;
            font-weight: 700;
            border-width: 1px;
            text-decoration: none;
            border-style: solid;
            border-color: rgb(204, 204, 204);
            border-image: initial;
            
            border-radius: 3px;
            box-sizing: border-box;
            display: block;
            color: rgb(51, 51, 51); */
        }
    </style>
@endsection

@section('content-chatbot')

    <div class="row title-page-buttom">
        <div class="col-xs-12 col-sm-6">
            @include('components.index_create', [
            'title' => 'Diseñar Chatbot',
            'url'   => route('chatbot.create'),
            'create'=> __('chatbot.create_chatbot_content')
            ])
        </div>
    </div>
    {{-- @include('components.index_top', ['indexes' => [
            trans_choice('common.chatbot', 1)
        ]]) --}}

        <div class="pr-0 pt-2 mt-12">
            <h3>Chatbot</h3>
            <p><b>Importante: </b>Arrastre las pregutas dentro de las respuestas correspondientes</p>
        </div>
    <div class="row masonry pos-r border-form " style="width: 100%; background-color: #fff">
        
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item col-12" style="width: 100%">
            <div class="dd" style="max-width: 100%">
                <ol class="dd-list">
                    @foreach ($questions as $question)
                        <li class="dd-item" data-type="question" data-id="{{$question->id}}">
                            <div class="dd-question-custom dd-handle dd-height" >{{$question->value}}</div>
                            <ol class="dd-list">
                                @foreach ($question->answers as $answer)
                                    <li class="dd-item" data-type="answer" data-db="{{$answer->id}}" data-id="{{$question->id.'_'.$answer->id}}">
                                        <div class="dd-answer-custom dd-handle dd-height ">{{ $answer->value }}</div>
                                    </li>
                                @endforeach
                            </ol>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
    <div class="mt-4 text-md-right">
        @csrf
    <input type="hidden" id="chatbot_id" value="{{ $questions[0]->chatbot_id }}">
        {{ Form::button(__('common.finalize'),["class" => "btn btn-app-primary", "id" => "submit", 'onClick' => "submitFrom()"]) }}
    </div>
    
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
    <script>

    function submitFrom (e) {
            $.post(
                "{{ action('ChatbotController@design_store') }}",
                {
                    _token: $('input[name="_token"]').val(),
                    data: $('.dd').nestable('serialize'),
                    id: document.getElementById('chatbot_id').value
                },
                function (result) {
                   location.href="{{ action('ChatbotController@index') }}"
                }
            );
        };
    
    var place;
        
    $('.dd').nestable({
        maxDepth: 16,
        onDragStart: function (l, e) {
            var type = $(e).data('type');
            if (type == "answer") {
                e.preventDefault();
            }
        },
        beforeDragStop: function(l,e, p){
            place = p;
        },
        callback: function(l,e){
            var type = $(e).data('type');
            var type_in = place.parent().data('type');

            if(type == type_in){
                alert('Las preguntas solo se pueden agregar dentro de las respuestas');
            }
        }
    });
    
</script>
@endsection