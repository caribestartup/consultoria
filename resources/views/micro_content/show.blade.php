@extends('default')

@section('title')
    {{ $microContent->title }}
@endsection

@section('css')
    <link href="{{ asset('/plugins/smart-wizard/css/smart_wizard.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/smart-wizard/css/smart_wizard_theme_arrows.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/smart-wizard/css/smart_wizard_theme_dots.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/smart-wizard/css/smart_wizard_theme_circles.css') }}" rel="stylesheet">
    <style>
        #micro-content-wizard .step-anchor .nav-item .nav-link::after {
            border-left: 30px solid #003C4F;
        }

        #micro-content-wizard .step-anchor,
        #micro-content-wizard .step-anchor .nav-item .nav-link
        {
            background: #003C4F;
            color: #fff;

        }

        #micro-content-wizard .step-anchor .nav-item.done .nav-link {
            background: #003C4F !important;
            color: #fff !important;
        }

        #micro-content-wizard .step-anchor .nav-item.active a::after
        {
            border-left: 30px solid #fff !important;
        }

        #micro-content-wizard .step-anchor .nav-item.active .nav-link {
            background: #fff !important;
            color: #003C4F !important;
            font-weight: 600;
        }

        #micro-content-wizard .step-anchor {
            border-bottom: none;
        }

        #micro-content-wizard .sw-btn-group .sw-btn-prev {
            background-color: #fff;
            color: #003C4F;
            border-color: #003C4F;
        }

        #micro-content-wizard .sw-btn-group .sw-btn-next {
            background-color: #003C4F;
            color: #fff;
            border-color: #003C4F;
        }
        #micro-content-wizard a.nav-link {
            transition: none;
        }
    </style>
@endsection

@section('content')
    @include('components.index_top', ['indexes' => [
        trans_choice('common.micro_content', 2), $microContent->title
        ]])

    <h1>{{ $microContent->title }}</h1>
    @if(\Illuminate\Support\Facades\Auth::user()->id === $microContent->user->id)
        <a class="btn btn-app-primary" href="{{ action('MicroContentController@edit', ['id' => $microContent->id]) }}">
            {{ __('common.edit') }}</a>
    @endif

    <div id="micro-content-wizard" class="bgc-white mT-10">
        <ul>
            @foreach($microContent->pages as $page)
                <li>
                    <a href="#{{ $page->titleSlug() }}">{{ $page->littleTitle() }}</a>
                </li>
            @endforeach
            {{-- @if(count($micro_content->pages)) --}}
            @php
                $showQuestions = count($microContent->questions) > 0 &&
                $microContent->userCanAnswer(\Illuminate\Support\Facades\Auth::user());
            @endphp
            @if($showQuestions)
                <li>
                    <a href="#{{ strtolower(trans_choice('common.question', 2)) }}">{{trans_choice('common.question', 2)}}</a>
                </li>
                <li>
                    <a href="#{{ strtolower(trans_choice('common.evaluation', 1)) }}">{{ trans_choice('common.evaluation', 1) }}</a>
                </li>
            @endif
            {{-- @endif --}}
        </ul>
        <div>
            @foreach($microContent->pages as $page)
                <div id="{{ strtolower(str_replace(' ', '-', $page->title)) }}" class="p-20">
                    <section>
                        <h2>{{ $page->title }}</h2>
                        <div>{!! $page->content !!}</div>
                    </section>
                </div>
            @endforeach

            @if($showQuestions)
                <div id="{{ strtolower(trans_choice('common.question', 2)) }}" class="p-20">
                    <form method="post" action="{{ action('MicroContentController@evaluate') }}" id="question-form">
                        <div class="row">
                            @foreach($microContent->questions as $question)
                                <div class="col-sm-6 col-md-3 col-lg-4 col-xl-4">
                                    <h3>{{ $question->value }}</h3>
                                    <div class="mT-15 mB-15">
                                        @foreach($question->answers as $answer)
                                            <div class="custom-control custom-radio mB-1">
                                                <input type="radio" id="anwers-{{$answer->id}}"
                                                       name="question[{{ $question->id }}]answer" class="custom-control-input"
                                                       value = {{ $answer->id }}
                                                       @if($loop->first)
                                                               checked
                                                        @endif/>
                                                <label class="custom-control-label" for="anwers-{{$answer->id}}">
                                                    {{ $answer->value }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @csrf
                    </form>
                </div>
            @endif
            <div id="{{ strtolower(trans_choice('common.evaluation', 1)) }}">
                <div class="text-center mT-60">
                    <h2>{{ __('micro_content.evaluation_message') }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/plugins/smart-wizard/js/jquery.smartWizard.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var wizard = $('#micro-content-wizard');
            wizard.smartWizard({
                theme: 'arrows',
                transitionEffect: 'fade',
                toolbarSettings: {
                    toolbarPosition: 'bottom',
                },
                anchorSettings: {
                    //enableAllAnchors: true,
                    markDoneStep: true, // add done css
                    markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                    enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                },
                lang: {
                    next: "{{ __('common.next') }}",
                    previous: "{{ __('common.previous') }}"
                }
            });

            var totalSteps = $('#micro-content-wizard ul.step-anchor a.nav-link').length - 1;
            var nextButton = $('#micro-content-wizard .sw-btn-next');

            {{-- Solo evaluo si el usuario puede hacerlo --}}
            @if($showQuestions)
            wizard.on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                if(stepNumber == (totalSteps - 1) && stepDirection == 'forward') {
                    var form = $('#question-form');
                    $.post(
                        form.prop('action'),
                        form.serialize(),
                        function (result) {

                        });
                }

                if(stepDirection == 'forward')
                    stepNumber++;
                else
                    stepNumber--;

                evaluateButtonText(stepNumber);
                return true;
            });

            evaluateButtonText($('ul.step-anchor .nav-item').index($('ul.step-anchor .nav-item.active')));

            function evaluateButtonText(stepNumber){
                if(stepNumber == (totalSteps - 1)){
                    nextButton.html("{{ __('common.evaluate') }}");
                }
                else {
                    nextButton.html("{{ __('common.next') }}");
                }
            }
            @endif
        });
    </script>
@endsection