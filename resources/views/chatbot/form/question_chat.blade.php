<style>
    .jumbotron-chat{
        padding: 1rem 1rem;
        margin-bottom: 2rem;
        background-color: #e9ecef;
        border-radius: .3rem;
    }
</style>
<div class="jumbotron-chat">
    <div class="panel-wrapper mT-10 mB-10">
        <input type="hidden" name="chatbot_id" value={{$question->chatbot_id}}>
        <div class="layers">
            {{-- <div class="layer w-100 p-15">
                <strong>
                    Chatbot
                    <span class="number"></span>
                    <span class="question"></span>
                </strong>
                <i class="fa fa-chevron-down pull-right cur-p mr-2 minimize"></i>
            </div> --}}

                <div class="layer w-100 p-20 panel-body">
                    <h4 class="">{{ $question->value }}</h4>
                    <hr class="my-4">
                    {{-- <div class="mB-10"></div> --}}
                        
                        @foreach ($question->answers as $answer)
                            <div class="answer row align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answer" id="{{$answer->id}}" 
                                        @isset($answer)
                                            value="{{ $answer->id }}"
                                        @endisset 
                                    />
                                    @csrf
                                    <label class="form-check-label" for="{{ $answer->id }}">
                                        {{ $answer->value }}      
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    
                </div>
        </div>
    </div>
     <p class="lead text-center">
        <a class="btn btn-primary btn-lg" href="" id="next" role="button">Siguiente</a>
    </p>
</div>

<script src="{{ asset('/plugins/jquery/jquery-3.3.1.min.js') }}"></script>
<script>
    $('#next').on("click", function (e) { 
        e.preventDefault();
        $.post(
            "{{ action('ChatbotController@next') }}",
            {
                _token: $('input[name="_token"]').val(),
                answer_id: $("input[type='radio'][name='answer']:checked").val(),
                chatbot_id: $('input[name="chatbot_id"]').val()
            },
            function (result) {

                if (result != 0){
                    var question = result['question'];
                    var answers = result['answers'];
                    var layers = $('div[class="layer w-100 p-20 panel-body"]').parent();
                    $('div[class="layer w-100 p-20 panel-body"]').remove();
                    var question = '<div class="layer w-100 p-20 panel-body"><h4 class="">'+question.value+'</h4><hr class="my-4">';
                    var answer = '';
                    answers.forEach(element => {
                        answer += '<div class="answer row align-items-center"><div class="form-check"><input class="form-check-input" type="radio" name="answer" id="'+element.id+'" value="'+element.id+'"/>@csrf <label class="form-check-label" for="'+element.id+'">'+element.value+'</label></div></div>';
                    });
                    var close = '</div>';
                    var block = question+answer+close;
                    layers.append(block);
                    // location.href="{{ action('ActionPlanController@index') }}"
                }
                else{
                    //cerrar el pinga esa
                    $('div[class="jumbotron-chat"]').remove();
                }
            }
        );
    });
</script>