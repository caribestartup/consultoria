@extends('default')

@section('title')
    @if(isset($actionPConfig))
        {{ __('action_plan.edit_action_plan') }}
    @else
        {{ __('action_plan.create_action_plan') }}
    @endif
@endsection

@section('css')
    <link href="{{ asset('/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">

    <style>
        .nopad {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        /*image gallery*/
        .image-checkbox {
            cursor: pointer;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            border: 4px solid transparent;
            margin-bottom: 0;
            outline: 0;
        }
        .image-checkbox input[type="checkbox"] {
            display: none;
        }

        .image-checkbox-checked {
            border-color: #003C4F;
        }
        .image-checkbox .fa {
            position: absolute;
            color: #003C4F;
            background-color: #f2f3f5;
            padding: 10px;
            top: 0;
            right: 0;
        }
        .image-checkbox-checked .fa {
            display: block !important;
        }

        .micro-c-image {
            max-height: 150px;
        }
        
    </style>
@endsection

@section('content')

        <h1 class=" ml-3 text-white" style="font-family: Comfortaa">
             @include('components.index_create', [
            'title' => trans_choice('common.action_plan', 2),
            'url'   => route('action_plans.create'),
            'create'=> __('action_plan.create_action_plan')
            ])
        </h1>

  
 
  

    @include('action_plan.form.form')

    @include('components.modal', [
    'modal_id'  => 'question-delete-modal',
    'title'     => __('common.attention!'),
    'content'   => __('common.delete_question'),
    'accept'    => __('common.yes'),
    'cancel'    => __('common.no')
    ])

    @include('components.modal', [
    'modal_id'  => 'action-delete-modal',
    'title'     => __('common.attention!'),
    'content'   => __('action_plan.delete_action_question'),
    'accept'    => __('common.yes'),
    'cancel'    => __('common.no')
    ])

    @include('components.modal', [
     'modal_id'  => 'free-content-delete-modal',
     'title'     => __('common.attention!'),
     'content'   => __('action_plan.delete_free_content_question'),
     'accept'    => __('common.yes'),
     'cancel'    => __('common.no')
     ])

    @isset($actionPConfig)
        @include('components.modal', [
        'modal_id'  => 'delete-modal',
        'title'     => __('common.attention!'),
        'content'   => __('action_plan.delete_action_plan_question'),
        'accept'    => __('common.yes'),
        'cancel'    => __('common.no')
        ])
    @endisset

    <div data-toggle="modal" data-target="#micro-contents-modal" id="open-micro-contents-modal"></div>

    {{-- modal de los micro contenidos --}}
    <div class="modal fade" id="micro-contents-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('action_plan.select_micro_content') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-20">
                    <div class="row">



                        @foreach($microContents as $microContent)
                            <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2 nopad text-center image-checkbox">
                                @if(count($microContent->images) > 0)
                                    <img class="img-responsive h-100 w-100  of-cv  micro-c-image bdrsT-4" src="@if(strpos($microContent->images[0]->url, 'http') === 0)
                                    {{ $microContent->images[0]->url }}
                                    @else
                                    {{ asset($microContent->images[0]->url) }}
                                    @endif" />
                                @else
                                    <img class="img-responsive h-100 w-100  of-cv micro-c-image bdrsT-4" src="{{ asset('images/noimage.png') }}"/>
                                @endif
                                <input type="checkbox" value="{{ $microContent->id }}" class="micro-content-i" />
                                <i class="fa fa-check d-none"></i>
                                <label>{{ $microContent->title }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer mT-15">
                    <button type="button" class="btn btn-app-primary accept-button" data-dismiss="modal">{{ __('common.accept') }}</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Tipo libre --}}
    <div class="">
        <div id="free-content">
            @include('action_plan.form.free.content', ['index' => 0])
        </div>
        <div id="training-content">
            @include('action_plan.form.free.training_question', ['index' => 0])
        </div>
    </div>

@endsection

@section('js')

    <script src="{{ asset('/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/plugins/summernote/lang/summernote-es-Es.js') }}"></script>
    <script>
        $(document).ready(function () {
            function convertDatePicker(element) {
                element.datepicker({
                    language: 'es',
                    startDate: 'now',
                    setDate: new Date(),
                    format: 'yyyy-mm-dd'
                });
            }

            $('.clockpicker').clockpicker();

            function imageToCheck() {
                // sync the state to the input
                $('#micro-contents-modal .image-checkbox').on("click", function (e) {
                    let checkbox = $(this).find('input[type="checkbox"]');
                    let checked = $(this).find('input[type="checkbox"]:checked');
                    if(checked.length === 0) {
                        $(this).addClass('image-checkbox-checked');
                        checkbox.attr('checked', 'checked');
                    }
                    else{
                        $(this).removeClass('image-checkbox-checked');
                        checkbox.removeAttr('checked');
                    }

                    e.preventDefault();
                });
            }


            imageToCheck();
            convertDatePicker($('.datepicker'));

            $('#reminders').click(function () {
                let checked = $('#reminders:checked').length > 0;
                if(checked)
                    $('#period').show('fast');
                else
                    $('#period').hide('fast');
            });

            $('#has-coach').click(function () {
                let checked = $('#has-coach:checked').length > 0;
                if(checked)
                    $('#coach').show('fast');
                else
                    $('#coach').hide('fast');
            });

            var Question = $('.question-form .question-wrapper');

            if(Question.length > 0)
                Question = Question.eq(0)[0].outerHTML;

            var currentQuestion;

            function newQuestionEvent(button){
                button.click(function() {
                    let questionForm = $(this).closest('.action-wrapper').find('.question-form');
                    let newQuestion = $(Question);
                    let questionCount = questionForm.find('.question-wrapper').length;
                    newQuestion.find('.question-number').html(questionCount + 1);

                    let actionsWrapper;
                    let isFromAction = $(this).closest('#action-form').length > 0;
                    if(isFromAction) {
                        actionsWrapper = $('#action-form');
                    }
                    else{
                        actionsWrapper = $('#added-content');
                    }

                    let actionIndex = $('.action-wrapper', actionsWrapper).index($(this).closest('.action-wrapper'));

                    let question = newQuestion.find('.question-i');
                    question.val('');
                    question.attr('name', 'action[' + actionIndex +'][question][' + questionCount +'][value]');

                    let type = newQuestion.find('.type-i');
                    type.val(0);
                    type.attr('name', 'action[' + actionIndex + '][question][' + questionCount +'][type]');

                    let answerWrapper = newQuestion.find('.answer:first-child');
                    let answer = answerWrapper.find('.answer-i');
                    answer.val('');
                    answer.attr('name', 'action[' + actionIndex + '][question][' + questionCount + '][options][][value]');
                    answer.find('.remove-answer').removeAttr('id');

                    newQuestion.find('.answers').html(answerWrapper);

                    newQuestion.removeAttr('id');
                    questionForm.append(newQuestion);
                    createQuestionEvents(newQuestion);
                });
            }

            newQuestionEvent($('.new-question'));

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
                question.find('.type-i').click(questionTypeEvent)
            }

            createQuestionEvents($('.question-form .panel-wrapper'));

            createQuestionEvents($('#added-content .training-wrapper'));

            {{-- Evento para el tipo de pregunta --}}
            function  questionTypeEvent() {
                let type = $(this);
                type.change(function () {
                    let anwersDiv = type.closest('.panel-wrapper').find('.answer-div');
                    if(type.val() == 2) {
                        anwersDiv.hide('fast');
                    }
                    else {
                        anwersDiv.show('fast');
                    }
                });
            }

            {{-- Evento para respuestas --}}
            function createAnswerEvents() {
                let newAnswer = $(this).closest('.answer').clone();
                newAnswer.find('input').val('');
                newAnswer.find('.new-answer').click(createAnswerEvents);
                newAnswer.find('.remove-answer').removeAttr('id');
                newAnswer.find('.remove-answer').click(removeAnswerEvents);

                $(this).closest('.answers').append(newAnswer);
            }

            {{-- Evento borrar respuestas --}}
            function removeAnswerEvents() {
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
                        $(this).val(index);
                    });

                    if(checked.length) {
                        correctAnswers.eq(0).click();
                    }
                }
            }

            {{-- Evento borrar pregunta --}}
            $('#question-delete-modal .accept-button').click(function () {
                        {{-- Guardo el id de la respuesta a eliminar --}}
                        @isset($actionPConfig)
                let id = currentQuestion.prop('id').replace('question-', '');
                if(id != ""){
                    deletedQuestions.val(id + ',' + deletedQuestions.val());
                }
                        @endif

                let questionsWrapper, actionIndex;
                let isFromAction = currentQuestion.closest('.action-wrapper').length > 0;
                if(isFromAction) {
                    questionsWrapper = $('.question-form');
                    actionIndex = $('.panel-wrapper', questionsWrapper).index(currentQuestion.closest('.action-wrapper'));
                }
                else{
                    questionsWrapper = $('#added-content');
                }

                currentQuestion.remove();
                $('.training-wrapper', questionsWrapper).each(function (index) {
                    let question = $(this);
                    question.find('.question-number').html(index + 1);
                    let prefixName;
                    if(isFromAction) {
                        prefixName = 'action[' + actionIndex + '][question]';
                    }
                    else{
                        prefixName = 'question';
                    }

                    question.find('.question-i').attr('name', prefixName + '[' + index +'][title]');
                    question.find('.type-i').attr('name', prefixName + '[' + index +'][type]');
                    question.find('.answer-i').attr('name', prefixName + '[' + index + '][options][][value]');
                });

                if(!isFromAction)
                    correctOrder();
            });

            var Action = $('#action-form .action-wrapper');
            if(Action.length > 0)
                Action = Action.eq(0)[0].outerHTML;
            var CurrentAction;
            $('#new-action').click(function() {
                newActionEvent($('#action-form'));
            });

            {{-- Evento para nueva accion --}}
            function newActionEvent(container){
                let newAction = $(Action);
                let actionCount = $('.action-wrapper', container).length;
                newAction.find('.action-number').html(actionCount + 1);

                let title = newAction.find('.title-i');
                title.val('');
                title.attr('name', 'action[' + actionCount +'][title]');

                let percent = newAction.find('.percent-i');
                percent.val('');
                percent.attr('name', 'action[' + actionCount +'][objectives_percent]');

                let objectives = newAction.find('.objectives-i');
                objectives.html('');
                objectives.attr('name', 'action[' + actionCount +'][objectives]');

                let startDate = newAction.find('.start-date-i');
                startDate.val('');
                startDate.attr('name', 'action[' + actionCount +'][configuration][start_date]');

                let endingDate = newAction.find('.ending-date-i');
                endingDate.val('');
                endingDate.attr('name', 'action[' + actionCount +'][configuration][ending_date]');

                let collaboration = newAction.find('.collaboration-i');
                collaboration.prop('id', 'collaboration-' + actionCount);
                collaboration.attr('name', 'action[' + actionCount +'][configuration][collaboration]');
                collaboration.closest('.form-group').find('label').prop('for', 'collaboration-' + actionCount);

                let linkMicroContent = newAction.find('.link-micro-content');
                linkMicroContent.data('action-index', actionCount);
                microContentModalEvents(linkMicroContent);
                newAction.find('.micro-contents-added .image-checkbox.nopad').remove();
                newAction.find('.question-wrapper:not(:first-child)').remove();

                let question = newAction.find('.question-wrapper:first-child');
                question.find('.answers .answer:not(:first-child)').remove();

                question.find('.question-i').attr('name', 'action[' + actionCount + '][question][0][title]').val('');
                question.find('.type-i').attr('name', 'action[' + actionCount + '][question][0][type]').val(0);
                question.find('.answer-i').attr('name', 'action[' + actionCount + '][question][0][options][][value]').val('');
                question.find('.remove-answer').removeAttr('id');

                createQuestionEvents(question);
                convertDatePicker(newAction.find('.datepicker'));
                newQuestionEvent(newAction.find('.new-question'));

                newAction.removeAttr('id');
                container.append(newAction);

                createActionEvents(newAction);

                return newAction;
            }

            {{-- Evento para modal de micro contenido --}}
            function microContentModalEvents(button) {
                button.click(function () {
                    $('#open-micro-contents-modal').click();
                    CurrentAction = $(this).closest('.panel-wrapper');
                })
            }

            microContentModalEvents($('.link-micro-content'));

            {{-- Evento para cerrar modal de micro contenidos --}}
            function acceptMicroContentModalEvent() {
                $('#micro-contents-modal button.accept-button').click(function () {
                    let microContents = $('#micro-contents-modal input[type="checkbox"]:checked');
                    let microContentsWrapper = CurrentAction.find('.micro-contents-added');
                    let index = CurrentAction.closest('.parent-container').find('.action-wrapper').index(CurrentAction);
                    microContents.each(function () {
                        let value = $(this).val();
                        let existing = microContentsWrapper.find('input[value="' + value + '"]');
                        if(existing.length === 0) {
                            let item = $(this).closest('.image-checkbox');
                            item.removeClass('image-checkbox-checked');

                            item = item.clone();
                            item.find('.micro-content-i').prop('name', 'action[' + index + '][micro_content][]');
                            item.removeClass('col-xs-12');
                            item.addClass('col-xs-6');

                            let button = item.find('.fa-check');
                            button.removeClass('fa-check');
                            button.removeClass('d-none');
                            button.addClass('fa-close');

                            removeMicroContentEvent(button);

                            microContentsWrapper.append(item);
                        }

                        {{-- Elimino el checked del modal --}}
                        $(this).removeAttr('checked');
                        $(this).closest('.image-checkbox').find('.fa-check').addClass('d-none');
                    });
                });
            }

            function removeMicroContentEvent(button){
                button.click(function () {
                    let actualItem = $(this).closest('.image-checkbox');
                    actualItem.hide('fast', function () {
                        $(this).remove()
                    });
                });
            }

            removeMicroContentEvent($('.micro-contents-added .fa-close'));
            acceptMicroContentModalEvent();

            {{-- Evento para acciones --}}
            function createActionEvents(action){
                let closeButton = action.find('.close-panel');
                closeButton.click(function () {
                    CurrentAction = $(this).closest('.panel-wrapper');
                });

                let hideButton = action.find('.minimize');
                hideButton.click(function () {
                    hideButton = $(this);
                    hideButton.toggleClass('fa-chevron-up');
                    hideButton.toggleClass('fa-chevron-down');
                    hideButton.closest('.panel-wrapper').find('.panel-body').slideToggle();
                });
            }

            createActionEvents($('#action-form .action-wrapper'));
            createActionEvents($('#added-content .action-wrapper'));

            {{-- Evento borrar accion --}}
            $('#action-delete-modal .accept-button').click(function () {
                        {{-- Guardo el id de la accion a eliminar --}}
                        @isset($actionPConfig)
                let id = CurrentAction.prop('id').replace('action-', '');
                if(id != ""){
                    deletedActions.val(id + ',' + deletedActions.val());
                }
                        @endif

                let actionsWrapper;
                let isFromGuided = $(this).closest('#action-form').length > 0;
                if(isFromGuided) {
                    actionsWrapper = $('#action-form');
                }
                else{
                    actionsWrapper = $('#added-content');
                }

                CurrentAction.remove();
                $('.action-wrapper', actionsWrapper).each(function (index) {
                    let action = $(this);
                    action.find('.action-number').html(index + 1);
                    action.find('.title-i').attr('name', 'action[' + index +'][title]');
                    action.find('.percent-i').attr('name', 'action[' + index +'][percent]');
                    action.find('.objectives-i').attr('name', 'action[' + index + '][objectives]');
                    action.find('.micro-content-i').attr('name', 'action[' + index + '][micro_content][]');


                    let collaboration = action.find('.collaboration-i');
                    collaboration.attr('name', 'action[' + index + '][configuration][collaboration]');
                    collaboration.prop('id', 'configuration-' + index);
                    collaboration.closest('.form-group').find('label').prop('for', 'collaboration-' + index);

                    action.find('.link-micro-content').data('action-index', index);

                    action.find('.start-date-i').attr('name', 'action[' + index + '][configuration][start_date]');
                    action.find('.ending-date-i').attr('name', 'action[' + index + '][configuration][ending_date]');

                            {{-- En caso q sea accion de free content --}}
                    let order = action.find('.order-i');
                    if(order.length > 0) {
                        order.attr('name', 'action[' + index + '][order]');
                    }

                    action.find('.question-wrapper').each(function (i) {
                        let question = $(this);
                        question.find('.question-number').html(index + 1);
                        question.find('.question-i').attr('name', 'action[' + index + '][question][' + i +'][title]');
                        question.find('.type-i').attr('name', 'action[' + index + '][question][' + i +'][type]');
                        question.find('.answer-i').attr('name', 'action[' + index + '][question][' + i + '][options][][value]');
                    });
                });

                if(!isFromGuided)
                    correctOrder();
            });

            {{-- Evento buscar coach --}}
            $('#coaches-i').on('click keyup', function (e) {
                let dropDown = $('#coaches-drop-down');
                if($(this).val().replace(/[" \n]/g, '').length > 0) {
                    if(e.type === 'keyup' || (e.type === 'click' && $('.item', dropDown).length === 0))
                        $.post(
                            "{{ action('UserController@search') }}",
                            {
                                _token: $('input[name="_token"]').val(),
                                search: $(this).val(),
                                coach: 1
                            },
                            function (result) {
                                $('.item', dropDown).remove();
                                result = $(result);
                                let items = $('.dropdown-item', result);
                                if(items.length > 0) {
                                    items.click(coachDropDownItemEvent);
                                    dropDown.append(items);
                                    $('.no-results', dropDown).addClass('d-n');
                                }
                                else{
                                    $('.no-results', dropDown).removeClass('d-n');
                                    $('#coaches-i').removeData('user');
                                }
                            });
                }
                else{
                    $('.item', dropDown).remove();
                    $('.no-results', dropDown).removeClass('d-n');
                    $('#coaches-i').removeData('user');
                }
            });

            {{-- Evento click sobre coach en listado--}}
            function coachDropDownItemEvent(){
                let item = $(this);
                let input = $('#coaches-i');
                input.val(item.data('name'));
                $('#coach-id').val(item.data('id'));
            }

            {{-- Convertir input to timepicker--}}
            $('.datetimepicker').datetimepicker({
                format: 'LT'
            });

            {{-- Eventos de los recordatorios --}}
            $('.reminders-i').click(function () {
                let currentItem = $(this);
                let wrapper = currentItem.closest('.reminder-wrapper');
                wrapper.find('.options').removeAttr('disabled');
                let siblings = wrapper.siblings('.reminder-wrapper');
                siblings.find('.options').attr('disabled', 'disabled');
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



                    {{-- Tipo Libre --}}
                    {{-- Cojo contenido por defecto--}}
            var FreeContent = $('#free-content').html();
            $('#free-content').remove();
            var TrainingContent = $('#training-content').html();
            $('#training-content').remove();

            $('#plan-type').change(function () {
                let value = parseInt($(this).val());
                let toShow, toHide;
                if(value === 0) {
                    toShow = $('.guided-type');
                    toHide = $('.free-type');
                }else{
                    toHide = $('.guided-type');
                    toShow = $('.free-type');
                }

                toShow.show('fast');
                {{-- Kito disabled menos a los input de recordatorios dia, semana, mes --}}
                toShow.find('input:not([name="configuration[reminders_value]"]),select:not([name="configuration[reminders_value]"]),button,textarea').removeAttr('disabled');

                toHide.hide('fast');
                toHide.find('input:not([name="configuration[reminders_value]"]),select:not([name="configuration[reminders_value]"]),button,textarea').attr('disabled', 'disabled');
            });

            var CurrentFreeContent;
            function freeContentEvents(textEditor) {
                textEditor.summernote({
                    height: 300,
                    lang: 'es-Es'
                });

                let closeButton = textEditor.closest('.panel-wrapper').find('.close-panel');
                closeButton.click(function () {
                    CurrentFreeContent = $(this).closest('.panel-wrapper');
                });

                let hideButton = textEditor.closest('.panel-wrapper').find('.minimize');
                hideButton.click(function () {
                    hideButton = $(this);
                    hideButton.toggleClass('fa-chevron-up');
                    hideButton.toggleClass('fa-chevron-down');
                    hideButton.closest('.panel-wrapper').find('.panel-body').slideToggle();
                });
            }

            freeContentEvents($('.text-editor'));

            $('#add-content').click(function () {
                let option = parseInt($('#content-type').val());
                let addedContent  = $('#added-content');
                let newContent, count, orderInput;
                let order = $('.action-wrapper,.training-wrapper,.free-content-wrapper', $('#added-content')).length + 1;
                switch (option) {
                    case 0:
                        newContent = $(FreeContent);
                        count = addedContent.find('.free-content-wrapper').length;
                        newContent.find('.number').html(count + 1);
                        let textarea = newContent.find('.text-editor');
                        textarea.attr('name', 'freeContent[' + count + '][content]');
                        newContent.find('.title-i').attr('name','freeContent[' + count + '][title]');
                        freeContentEvents(textarea);
                        orderInput = '<input type="hidden" class="order-i" name="freeContent[' + count + '][order]" value="' + order + '"/>';
                        newContent.append(orderInput);
                        addedContent.append(newContent);

                        scrollTo(newContent);
                        break;
                    case 1:
                        let action = newActionEvent($('#added-content'));
                        let actionCount = $('.action-wrapper', $('#added-content')).length - 1;
                        orderInput = '<input type="hidden" class="order-i" name="action[' + actionCount + '][order]" value="' + order + '"/>';
                        action.append(orderInput);

                        scrollTo(action);
                        break;
                    case 2:
                        newContent = $(TrainingContent);
                        count = addedContent.find('.training-wrapper').length;
                        newContent.find('.number').html(count + 1);
                        newContent.find('.question-i').attr('name', 'question[' + count + '][title]');
                        newContent.find('.type-i').attr('name', 'question[' + count + '][type]');
                        newContent.find('.answer-i').attr('name', 'question[' + count+ '][options][][value]');
                        orderInput = '<input type="hidden" class="order-i" name="question[' + count + '][order]" value="' + order + '"/>';
                        newContent.append(orderInput);
                        createQuestionEvents(newContent);
                        addedContent.append(newContent);

                        scrollTo(newContent);
                        break;
                }
            });

            {{-- Evento borrar contenido libre --}}
            $('#free-content-delete-modal .accept-button').click(function () {
                CurrentFreeContent.remove();
                $('.free-content-wrapper', $('#added-content')).each(function (index) {
                    let freeContent = $(this);
                    freeContent.find('.number').html(index + 1);
                    freeContent.find('.text-editor').attr('name', 'freeContent[' + index + '][content]');
                    freeContent.find('.title-i').attr('name','freeContent[' + index + '][title]');
                });

                correctOrder();
            });

            function correctOrder(){
                $('#added-content .order-i').each(function (index) {
                    $(this).val(index + 1);
                });
            }

            function scrollTo(element){
                {{-- 65px es el ancho del menu de arriba y le sumo 10 mas para que no quede tan pegado arribita --}}
                $('html,body').animate({
                    scrollTop: element.offset().top - 75
                }, 'slow');
            }

            {{-- hasta aki tipo libre --}}

            @isset($actionPConfig)
            {{-- Boton eliminar plan de accion --}}
            $('#delete-modal .accept-button').click(function () {
                $('form#delete-form').submit();
            });

            {{-- ejecute el metodo de mostrar lo q corresponda a ese plan ed accion --}}
            $('#plan-type').change();

            var deletedActions = $('input[name="deleted[actions]"]');
            var deletedAnswers = $('input[name="deleted[answers]"]');
            var deletedQuestions = $('input[name="deleted[questions]"]');
            @endisset
        });
    </script>
@endsection