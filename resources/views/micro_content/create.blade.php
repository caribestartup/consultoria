@extends('default')

@section('title')
    @if(isset($microContent))
        {{ __('micro_content.edit_micro_content') }}
    @else
        {{ __('micro_content.create_micro_content') }}
    @endif
@endsection

@section('css')
    <link href="{{ asset('/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet">
    <style>
        .multiselect-container .checkbox input[type="checkbox"] {
            opacity: 1 !important;
        }

        .multiselect-native-select .dropdown-menu {
            min-width: 12rem;
        }

        button.multiselect {
            background-color: #f2f3f5;
        }

        .multiselect-container li a, button.multiselect span.multiselect-selected-text {
            color: #003C4F;
        }

    </style>
@endsection

@section('content')
    <div class="row orange-row d-flex align-items-start mb-5">
        <h1 class=" ml-3 text-white" >
          @if(isset($microContent))
            {{ __('micro_content.edit_micro_content') . ': ' . $microContent->title }}
        @else
            {{ __('micro_content.create_micro_content') }}
        @endif
        </h1>

    </div>

    @include('micro_content.form.form')

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

    @isset($microContent)
        @include('components.modal', [
        'modal_id'  => 'delete-modal',
        'title'     => __('common.attention!'),
        'content'   => __('micro_content.delete_micro_content_question'),
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
            
            {{-- Evento para paginas --}}
            function createPageEvents() {
                let textEditor = $('.text-editor:visible');
                textEditor.summernote({
                    height: 300,
                    lang: 'es-Es'
                });

                let closeButton = textEditor.closest('.panel-wrapper').find('.close-panel');
                closeButton.click(function () {
                    currentPage = $(this).closest('.panel-wrapper');
                });

                let hideButton = textEditor.closest('.panel-wrapper').find('.minimize');
                hideButton.click(function () {
                    hideButton = $(this);
                    hideButton.toggleClass('fa-chevron-up');
                    hideButton.toggleClass('fa-chevron-down');
                    hideButton.closest('.panel-wrapper').find('.panel-body').slideToggle();
                });
            }

            const Page = $('#page-form .panel-wrapper').eq(0)[0].outerHTML;
            var currentPage;
            {{-- Evento boton añadir pagina --}}
            $('#new-page').click(function(){
                let newPage = $(Page);
                let index = $('#page-form .panel-wrapper').length;
                newPage.find('.number').html(index + 1);

                let title = newPage.find('.title-i');
                title.attr('name', 'page[' + index + '][title]');
                title.val('');

                let content = newPage.find('.content-i');
                content.attr('name', 'page[' + index + '][content]');
                content.html('');

                $('#page-form').append(newPage);
                createPageEvents();
            });

            {{-- Evento borrar pagina --}}
            $('#page-delete-modal .accept-button').click(function () {
                currentPage.remove();
                $('#page-form .panel-wrapper').each(function (index) {
                    let page = $(this);
                    page.find('.number').html(index + 1);
                    page.find('.title-i').attr('name', 'page[' + index + '][title][]');
                    page.find('.content-i').attr('name', 'page[' + index + '][content][]');
                })
            });

            createPageEvents();

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
                        item.closest('.form-group').find('label').prop('for', 'correct-' + questionCount + index);
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

            {{-- Creando multiselect --}}
            $('select.multiselect').multiselect({
                includeSelectAllOption: true,
                templates: { li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>' },
                allSelectedText: "{{ trans_choice('common.all', 2) }}",
                selectAllText: "{{ __('common.select_all') }}",
                nonSelectedText: "{{ __('common.non_selected') }}",
                nSelectedText: "{{ trans_choice('common.selected', 2) }}",
                filterPlaceholder: "{{ __('common.search') }}"
            });

            {{-- Boton agregar accion --}}
            $('#add-action').click(function () {
                let actionSelect = $('#actions');
                let action = $('option:selected', actionSelect).html();
                let actionId = actionSelect.val();

                if($('#action-inputs input[value="' + actionId +'"]').length === 0) {
                    {{--let user = $('#users-i').val();--}}

                    let planSelect = $('#action-plans');
                    let plan = $('option:selected', planSelect).html();

                    $('#action-inputs').append('<input type="hidden" name="action[]" value="' + actionId + '"/>');

                    let newRow = '<tr></tr>';
                    newRow = $(newRow);
                    {{--newRow.append('<td>' + user + '</td>');--}}
                    newRow.append('<td>' + plan + '</td>');
                    newRow.append('<td>' + action + '</td>');
                    newRow.append('<td><i class="fa fa-times cur-p fsz-md" data-id="' + actionId + '"></i></td>');
                    newRow.find('.fa-times').click(removeActionEvents);

                    $('#actions-table tbody').append(newRow);
                    $('#actions-table').removeClass('d-none');
                }
            });

            $('#actions-table .fa-times').click(removeActionEvents);

            {{-- Evento borrar accion --}}
            function removeActionEvents(){
                let actionId = $(this).data('id');
                $('#action-inputs input[value="' + actionId +'"]').remove();
                $(this).closest('tr').remove();
                if($('#actions-table tbody tr').length === 0) {
                    $('#actions-table').addClass('d-none');
                }
            }

            {{-- Evento buscar usuario --}}
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

            {{-- Evento del input buscar usuario --}}
            function userDropDownItemEvent(){
                let item = $(this);
                let userInput = $('#users-i');
                userInput.val(item.data('name'));
                userInput.data('user', item.data('id'));
                $.post(
                    "{{ action('MicroContentController@ajaxActionPlans') }}",
                    {
                        _token: $('input[name="_token"]').val(),
                        user: item.data('id')
                    },
                    function (result) {
                        let actionPlans = $('#action-plans');
                        $('option:not(:first-child)', actionPlans).remove();
                        for(let i = 0; i < result.length; i++) {
                            let newOption = '<option value="' + result[i].id +'">' + result[i].title +'</option>';
                            actionPlans.append(newOption)
                        }
                    });
            }

            {{-- Evento del select de planes de accion --}}
            $('#action-plans').change(function () {
                let actions = $('#actions');
                $('option:not(:first-child)', actions).remove();
                if($(this).val() != -1) {
                    $.post(
                        "{{ action('MicroContentController@ajaxActions') }}",
                        {
                            _token: $('input[name="_token"]').val(),
                            action_plan: $(this).val()
                        },
                        function (result) {
                            for (let i = 0; i < result.length; i++) {
                                let newOption = '<option value="' + result[i].id + '">' + result[i].title + '</option>';
                                actions.append(newOption)
                            }
                        });
                }
            });

            @isset($microContent)
            {{-- Boton eliminar micro contenid--}}
            $('#delete-modal .accept-button').click(function () {
                $('form#delete-form').submit();
            });

            let deletedAnswers = $('input[name="deleted[answers]"]');
            let deletedQuestions = $('input[name="deleted[questions]"]');
            @endisset


        });
    </script>
@endsection