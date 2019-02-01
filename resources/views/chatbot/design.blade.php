@extends('default')

@section('title')
    
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
    <style>
        .dd-answer-custom:hover {
            color:black !important; 
            background:rgb(200, 250, 250) !important;
        }
        .dd-answer-custom{
            background: rgb(200, 250, 250);
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

    <div class="row gap-20 masonry pos-r border-form">
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item col-12">
            <div class="dd">
                <ol class="dd-list">
                    @foreach ($questions as $question)
                        <li class="dd-item" data-type="question" data-id="{{$question->id}}">
                            <div class="dd-handle" >{{$question->value}}</div>
                            <ol class="dd-list">
                                @foreach ($question->answers as $answer)
                                    <li class="dd-item" data-type="answer" data-db="{{$answer->id}}" data-id="{{$question->id.'_'.$answer->id}}">
                                    <div  class="dd-answer-custom dd-handle">{{ $answer->value }}</div>
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

    $('.dd').nestable({
        maxDepth: 16,
        onDragStart: function (l, e) {
            // get type of dragged element
            var type = $(e).data('type');

            if (type == "answer") {
                e.preventDefault();
            }
            
            // based on type of dragged element add or remove no children class
            // switch (type) {
            //     case 'question':
            //         // element of type1 can be child of type2 and type3
            //         l.find("[data-type=answer]").removeClass('dd-nochildren');
            //         // l.find("[data-type=type3]").removeClass('dd-nochildren');
            //         console.log($('.dd').nestable('toArray'));
            //         break;
            //     // case 'type2':
            //     //     // element of type2 cannot be child of type2 or type3
            //     //     l.find("[data-type=type2]").addClass('dd-nochildren');
            //     //     l.find("[data-type=type3]").addClass('dd-nochildren');
            //     //     console.log($('.dd').nestable('toArray'));
            //     //     break;
            //     // case 'type3':
            //     //     // element of type3 cannot be child of type2 but can be child of type3
            //     //     l.find("[data-type=type2]").addClass('dd-nochildren');
            //     //     l.find("[data-type=type3]").removeClass('dd-nochildren');
            //     //     console.log($('.dd').nestable('toArray'));
            //     //     break;
            //     default:
            //         // console.error("Invalid type");
            //         console.log($('.dd').nestable('serialize'));
            // }
            
        }
    });
    
</script>
@endsection