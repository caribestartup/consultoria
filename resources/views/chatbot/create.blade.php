@extends('default')

@section('title')

@endsection

@section('css')


@endsection

@section('content-chatbot')

    <div class="row orange-row d-flex align-items-start mb-5">
        <h1 class=" ml-3 text-white" >
          @if(isset($chatbot))
            {{ __('chatbot.edit_micro_content') . ': ' . $chatbot->name }}
        @else
            {{ __('chatbot.create_chatbot_content') }}
        @endif
        </h1>

    </div>

    @include('chatbot.form.form')

    @include('components.modal', [
    'modal_id'  => 'page-delete-modal',
    'title'     => __('common.attention!'),
    'content'   => __('micro_content.delete_page_question'),
    'accept'    => __('common.yes'),
    'cancel'    => __('common.no')
    ])

    @include('components.modal', [
    'modal_id'  => 'question-delete-modal',
    'title'     => __('common.attention!'),
    'content'   => __('common.delete_question'),
    'accept'    => __('common.yes'),
    'cancel'    => __('common.no')
    ])

    @isset($chatbot)
        @include('components.modal', [
        'modal_id'  => 'delete-modal',
        'title'     => __('common.attention!'),
        'content'   => __('chatbot.delete_chatbot_question'),
        'accept'    => __('common.yes'),
        'cancel'    => __('common.no')
        ])
    @endisset


@endsection

@section('js')
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/plugins/summernote/lang/summernote-es-Es.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script>
        $(document).ready(function () {

            {{-- Evento para preguntas --}}
            function createQuestionEvents(question){
                let closeButton = question.find('.close-panel');
                closeButton.click(function () {
                    currentQuestion = $(this).closest('.panel-wrapper');
                });

                let hideButton = question.find('.minimize');
                hideButton.click(function () {
                    hideButton = $(this);
                    hideButton.toggleClass('fa-chevron-up');
                    hideButton.toggleClass('fa-chevron-down');
                    hideButton.closest('.panel-wrapper').find('.panel-body').slideToggle();
                });

                question.find('.remove-answer').click(removeAnswerEvents);
                question.find('.new-answer').click(createAnswerEvents);
            }

            {{-- Evento para respuestas --}}
            function createAnswerEvents() {

                let newAnswer = $(this).closest('.answer').clone();
                newAnswer.find('input').val('');
                newAnswer.find('.new-answer').click(createAnswerEvents);

                let removeAnswer = newAnswer.find('.remove-answer');
                removeAnswer.removeAttr('id');
                removeAnswer.click(removeAnswerEvents);

                let index = $(this).closest('.answers').find('.answer').length;
                let correct = newAnswer.find('.correct-i');
                let id = correct.attr('question');
                correct.val(index);
                correct.prop('id', 'correct-' + id + index);
                correct.closest('.form-group').find('label').prop('for', 'correct-' + id + index);
                $(this).closest('.answers').append(newAnswer);
            }

            {{-- Evento borrar respuestas --}}
            function removeAnswerEvents() {
                let questionCount = $('#question-form .panel-wrapper').length;
                if($(this).closest('.panel-wrapper').find('.answer').length > 1) {

                    {{-- Guardo el id de la respuesta a eliminar --}}
                    @isset($microContent)
                        let id = $(this).prop('id').replace('answer-', '');
                        if(id != ""){
                            deletedAnswers.val(id + ',' + deletedAnswers.val());
                        }
                    @endif

                    let answers = $(this).closest('.answers');
                    let checked = $(this).closest('.answer').find('.correct-i:checked');
                    $(this).closest('.answer').remove();

                    let correctAnswers = $('.correct-i', answers);
                    correctAnswers.each(function (index) {
                        let item = $(this);
                        item.val(index);
                        item.prop('id', 'correct-' + questionCount + index);
                        item.closest('.form-group').find('label').prop('for', 'correct-' + + questionCount + index);
                    });

                    if(checked.length) {
                        correctAnswers.eq(0).click();
                    }
                }
            }

            const Question = $('#question-form .panel-wrapper').eq(0)[0].outerHTML;
            var currentQuestion;

            {{-- Evento añadir pregunta --}}
            $('#new-question').click(function() {
                let newQuestion = $(Question);
                let questionCount = $('#question-form .panel-wrapper').length;
                newQuestion.find('.number').html(questionCount + 1);

                let question = newQuestion.find('.question-i');
                question.val('');
                question.attr('name', 'question[' + questionCount +'][value]');

                let points = newQuestion.find('.points-i');
                points.val('');
                points.attr('name', 'question[' + questionCount +'][points]');

                let answerWrapper = newQuestion.find('.answer:first-child');
                let answer = answerWrapper.find('.answer-i');
                answer.val('');
                answer.attr('name', 'question[' + questionCount + '][answers][][value]');

                newQuestion.find('.answers').html(answerWrapper);

                newQuestion.find('.correct-i').attr('name', 'question[' + questionCount + '][is_correct]');
                newQuestion.find('.correct-i').eq(0).click();

                let id = questionCount + 1;
                newQuestion.find('.correct-i').attr('id', 'correct-' + id +'0');
                newQuestion.find('.correct-i').attr('question', id);
                newQuestion.find('.custom-control-label').attr('for', 'correct-' + id +'0');
                
                newQuestion.removeAttr('id');
                $('#question-form').append(newQuestion);
                createQuestionEvents(newQuestion);
                //new_question.find('.question-i').attr('name', 'question[' + question_count +']');
            });

            createQuestionEvents($('#question-form .panel-wrapper'));

            {{-- Evento borrar pregunta --}}
            $('#question-delete-modal .accept-button').click(function () {

                        {{-- Guardo el id de la respuesta a eliminar --}}
                        @isset($microContent)
                let id = currentQuestion.prop('id').replace('question-', '');
                if(id != ""){
                    deletedQuestions.val(id + ',' + deletedQuestions.val());
                }
                @endif
                currentQuestion.remove();
                $('#question-form .panel-wrapper').each(function (index) {
                    let question = $(this);
                    question.find('.number').html(index + 1);
                    question.find('.question-i').attr('name', 'question[' + index +'][value]');
                    question.find('.points-i').attr('name', 'question[' + index +'][points]');
                    question.find('.answer-i').attr('name', 'question[' + index + '][answers][][value]');
                    question.find('.correct-i').attr('name', 'question[' + index + '][is_correct]');
                })
            });

            {{-- Evento buscar usuarios --}}
            $('#users-i').on('click keyup', function (e) {
                let dropDown = $('#users-drop-down');
                if($(this).val().replace(/[" \n]/g, '').length > 0) {
                    if(e.type === 'keyup' || (e.type === 'click' && $('.item', dropDown).length === 0))
                        $.post(
                            "{{ action('UserController@search') }}",
                            {
                                _token: $('input[name="_token"]').val(),
                                search: $(this).val()
                            },
                            function (result) {
                                $('.item', dropDown).remove();
                                result = $(result);
                                let items = $('.dropdown-item', result);
                                if(items.length > 0) {
                                    items.click(userDropDownItemEvent);
                                    dropDown.append(items);
                                    $('.no-results', dropDown).addClass('d-n');
                                }
                                else{
                                    $('.no-results', dropDown).removeClass('d-n');
                                    $('#users-i').removeData('user');
                                }
                            });
                }
                else{
                    $('.item', dropDown).remove();
                    $('.no-results', dropDown).removeClass('d-n');
                    $('#users-i').removeData('user');
                }
            });

            {{-- Evento click sobre usuarios en listado --}}
            function userDropDownItemEvent(){
                let item = $(this);
                let id = item.data('id');
                let usersAdded = $('#users-added');
                if(usersAdded.find('input[name="users[]"][value="' + id +'"]').length == 0) {
                    let newItem = '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 user-wrapper mT-10"><div class="card p-10 h-100"></div></div>';
                    newItem = $(newItem);

                    let input = '<input type="hidden" name="users[]" value="' + id + '"/>';
                    let closeButton = '<span class="fa fa-close pos-a r-2 t-2 cur-p "></span>';
                    closeButton = $(closeButton);
                    closeButton.click(removeUserEvent);

                    newItem.find('.card').append(item.html());
                    newItem.find('.card').append(closeButton);
                    newItem.append(input);

                    usersAdded.append(
                        newItem
                    );
                }
            }

            $('#users-added .fa-close').click(removeUserEvent);

            {{-- Evento eliminar usuario --}}
            function removeUserEvent(){
                let wrapper = $(this).closest('.user-wrapper');
                wrapper.hide('fast', function () {
                    $(this).remove();
                });
            }

        });
    </script>
@endsection
