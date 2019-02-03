@extends('default')

@section('title')
    {{ trans_choice('common.action_plan', 1) . ': '. $actionPConfig->actionPlan->title }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-star-rating/css/star-rating.min.css') }}">

@endsection

@section('content')
    @include('components.index_top', ['indexes' => [
        trans_choice('common.action_plan', 2),	$actionPConfig->actionPlan->title
        ]])

    <h1>{{ $actionPConfig->actionPlan->title }}</h1>
    {{-- TODO --}}
    @if(\Illuminate\Support\Facades\Auth::user()->id === $actionPConfig->user->id || \Illuminate\Support\Facades\Auth::user()->rol == 'Administrador')
        <a class="btn btn-app-primary mb-3" href="{{ action('ActionPlanController@edit', ['id' => $actionPConfig->id]) }}">
            {{ __('common.edit') }}
        </a>
        <a class="btn btn-app-primary mb-3" href="{{ action('TrainingController@show', ['id' => $actionPConfig->id]) }}">
            Agregar Evaluadores
        </a>
    @endif

    <div class="bgc-white p-20">
        {{-- <h1>{{ $actionPConfig->actionPlan->title }}</h1> --}}


        <strong>{{ trans_choice('common.objective', 2) }}</strong>
        <p class="pL-10"> {{ $actionPConfig->actionPlan->objectives }}</p>


        @if($actionPConfig->has_coach and $actionPConfig->coach_id != null)
            {{-- {{ dd($actionPConfig->has_coach) }} --}}
            <strong>{{ __('action_plan.assigned_coach') }}</strong>
            <div class="align-items-center mT-10">
                <img src="{{ asset($actionPConfig->coach->getAvatarUrlAttribute()) }}" class="bdrs-50p mR-10 " width="45px" height="45px"/>
                <span>{{ $actionPConfig->coach->fullName()  }}</span>
            </div>

            @if($actionPConfig->coach_functions != '')
                <div class="mT-15">
                    <strong>{{ __('action_plan.coach_functions') }}</strong>
                    <p>{{  $actionPConfig->coach_functions }}</p>
                </div>
            @endif
        @endif

    </div>

    {!! Form::open([
    'url'     => action('ActionPlanController@updateAssigned', ['id' => $actionPConfig->id]),
    'method'    => 'POST']) !!}

    @if($actionPConfig->actionPlan->type == \App\ActionPlan::GUIDED)
        @if($actionPConfig->actionConfigurations->count() > 0)
            <fieldset>
                <h2>{{ trans_choice('common.action', 2) }}</h2>
                @foreach($actionPConfig->actionConfigurations as $actionConfig)
                    @include('action_plan.assigned.action')
                @endforeach
            </fieldset>
        @endif

    @else
        <fieldset>
            @php
                $indexQuestion = 0;
                $indexFreeContent = 0;
            @endphp
                @if($actionPConfig->actionPlan)
                    {{-- {{dd($actionPConfig->actionPlan)}} --}}
                    @foreach($actionPConfig->actionPlan->freePlanElements() as $element)
                        @if($element instanceof \App\Action)
                            {{-- {{dd($actionPConfig->actionPlan->freePlanElements())}} --}}
                            @if(!$element->configurations->isEmpty())
                                {{-- {{dd($element->configurations)}} --}}
                                @include('action_plan.assigned.action', ['actionConfig' => $element->configurations[0]])
                            @endif
                        @elseif($element instanceof \App\FreeContent)
                            @include('action_plan.assigned.free_content', ['freeContent' => $element, 'index' => $indexFreeContent])
                        @php
                            $indexFreeContent++;
                        @endphp
                        @elseif($element instanceof \App\PlanQuestion)
                            @include('action_plan.assigned.question_plan', ['question' => $element, 'index' => $indexQuestion])
                            @php
                                $indexQuestion++;
                            @endphp
                        @endif
                    @endforeach
                @endif
        </fieldset>
    @endif

    <div class="text-right mT-10">
        {{ Form::submit(__('common.finalize'),["class" => "btn btn-app-primary"]) }}
    </div>

    {!! Form::close() !!}

@endsection

@section('js')
    <script src="{{ asset('plugins/bootstrap-star-rating/js/star-rating.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let hideButton = $('.minimize');
            hideButton.click(function () {
                hideButton = $(this);
                hideButton.toggleClass('fa-chevron-up');
                hideButton.toggleClass('fa-chevron-down');
                hideButton.closest('.panel-wrapper').find('.panel-body').slideToggle();
            });
        });
    </script>
@endsection