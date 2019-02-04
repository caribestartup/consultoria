@if(isset($actionPConfig))
    {!! Form::model($actionPConfig,
    ['route' => ['action_plans.update', $actionPConfig->id],
    'method' => 'PUT']) !!}
@else
    {!! Form::open(['route' => 'action_plans.store']) !!}
@endif
<div class="row " >
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
        <fieldset class="mT-10 bgc-white p-20 border-form " >
            <div class="row ">
                <div class="form-group col-xs-12 col-6 ">
                    <label for="type">{{ __('action_plan.type') }}</label>
                    <select class="custom-select " name="plan[type]" id="plan-type">
                        <option value="{{ \App\ActionPlan::GUIDED }}"
                                @if((isset($actionPConfig) && $actionPConfig->actionPlan->type == \App\ActionPlan::GUIDED) || empty($actionPConfig))
                                selected
                                @endif
                        >{{ __('action_plan.guided') }}</option>
                        <option value="{{ \App\ActionPlan::FREE }}"
                                @if(isset($actionPConfig) && $actionPConfig->actionPlan->type == \App\ActionPlan::FREE)
                                selected
                                @endif
                        >{{ __('action_plan.free') }}</option>
                    </select>
                </div>
                <div class="form-group col-xs-12 col-6">
                    <label for="type">{{ __('common.collaboration') }}</label>
                    <select class="custom-select" name="plan[collaboration]">
                        <option value="{{ \App\ActionPlan::INDIVIDUAL }}"
                                @if((isset($actionPConfig) && $actionPConfig->actionPlan->collaboration == \App\ActionPlan::INDIVIDUAL) || empty($actionPConfig))
                                selected
                                @endif
                        >{{ __('action_plan.individual') }}</option>
                        <option value="{{ \App\ActionPlan::COLLECTIVE }}"
                                @if((isset($actionPConfig) && $actionPConfig->actionPlan->collaboration == \App\ActionPlan::COLLECTIVE) || empty($actionPConfig))
                                selected
                                @endif
                        >{{ __('action_plan.collective') }}</option>
                    </select>
                </div>
            </div>

            <h2>{{ trans_choice('common.general', 1) }}</h2>
            <div class="pL-20 pR-20 ">
                <div class="form-group">
                    <label for="plan-title">{{ __('common.title') }}</label>
                    <input id="plan-title" class="form-control "  name="plan[title]" required
                           @isset($actionPConfig) value="{{ $actionPConfig->actionPlan->title }}" @endisset/>
                </div>
                <div class="form-group">
                    <label for="plan-objectives">{{ trans_choice('common.objective', 2) }}</label>
                    <textarea id="plan-objectives" class="form-control" required
                              name="plan[objectives]">@isset($actionPConfig){{ $actionPConfig->actionPlan->objectives }}@endisset</textarea>
                </div>

                <div class="row ">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <label for="start-date">{{ __('common.start_date') }}</label>
                        <input class="form-control datepicker"
                               name="configuration[start_date]"
                               @isset($actionPConfig)
                               value="{{ $actionPConfig->start_date }}"
                               @endisset
                               autocomplete="off"
                        >
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <label for="start-date">{{ __('common.ending_date') }}</label>
                        <input class="form-control datepicker"
                               name="configuration[ending_date]"
                               @isset($actionPConfig)
                               value="{{ $actionPConfig->ending_date }}"
                               @endisset
                               autocomplete="off"
                        >
                    </div>
                </div>

                
                    <div class="form-group">


                            <input type="checkbox" class="custom-control-input" style="none" name="configuration[has_coach]" id="has-coach"
                                    {{-- @if(isset($actionPConfig) and $actionPConfig->has_coach) --}}
                                    checked
    
                                    {{-- @endif --}}
                                    value="1">
                            {{-- <div class="custom-checkbox custom-control custom-control-inline">
                                
                                <label class="custom-control-label" for="has-coach">{{ __('action_plan.assign_coach') }}</label>
                            </div> --}}

                            <div id="coach" class="mT-5">
                                <div class="form-group">
                                    <label>{{ trans_choice('common.coach', 1) }}</label>
                                    <input id="coaches-i" class="form-control col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" placeholder="{{ __('common.search') }}"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off" required
                                        @if(isset($actionPConfig) and $actionPConfig->has_coach and $actionPConfig->coach_id != null)
                                        value="{{ $actionPConfig->coach->fullName() }}"
                                        
                                            @endif
                                    />
                                    <div class="dropdown-menu" id="coaches-drop-down">
                                        <div class="dropdown-item no-results">
                                            {{ __('common.no_result') }}
                                        </div>
                                    </div>
                                    <input type="hidden" name="configuration[coach_id]" id="coach-id"
                                        @if(isset($actionPConfig) and $actionPConfig->has_coach)
                                        value="{{ $actionPConfig->coach_id }}"
                                            @endif
                                    />
                                </div>
                                <div class="form-group">
                                    <label>{{ __('action_plan.coach_functions') }}</label>
                                    <textarea class="form-control" name="configuration[coach_functions]">@if(isset($actionPConfig) and $actionPConfig->has_coach){{ $actionPConfig->coach_functions }}@endif</textarea>
                                </div>
                            </div>
                        
                    </div>
                    <div class="form-group guided-type"
                        {{-- {{dd($actionPConfig)}} --}}
                        {{-- isset($actionPConfig) || --}}
                        @if( (isset($actionPConfig) && $actionPConfig->actionPlan->type == \App\ActionPlan::FREE))
                            style="display: none"
                        @endif >
                        <div class="custom-checkbox custom-control">
                            <input type="checkbox" class="custom-control-input" name="configuration[reminders]" id="reminders"
                                @if(isset($actionPConfig) and $actionPConfig->reminders)
                                checked
                                @endif
                                value="1">
                            <label class="custom-control-label" for="reminders">{{ __('common.enable_reminders') }}</label>
                        </div>
                        <div id="period" class="mT-5"
                            @if(!isset($actionPConfig) or (isset($actionPConfig) and !$actionPConfig->reminders))
                            style="display: none"
                                @endif            >
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 reminder-wrapper">
                                    <div class="custom-radio pr-3 custom-control custom-control-inline">
                                        <input name="configuration[reminders_period]" type="radio" class="custom-control-input reminders-i"
                                            @if(isset($actionPConfig) and $actionPConfig->reminders_period == \App\ActionPlan::R_DAILY)
                                            checked
                                            @endif
                                            value="{{ \App\ActionPlan::R_DAILY }}" id="daily">
                                        <label class="custom-control-label" for="daily">{{ __('common.daily') }}</label>
                                    </div>
                                    <div class="reminder-value mT-5 w-75">
                                        <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                            <input type="text" name="configuration[reminders_value]" class="form-control options"
                                                @if( (isset($actionPConfig) and $actionPConfig->reminders_period == \App\ActionPlan::R_DAILY))
                                                value="{{ $actionPConfig->remindersValue() }}"
                                                @else
                                                disabled="disabled"
                                                @endif
                                                required
                                            >
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 reminder-wrapper">
                                    <div class="custom-radio pr-3 custom-control custom-control-inline">
                                        <input name="configuration[reminders_period]" type="radio" class="custom-control-input reminders-i"
                                            @if(isset($actionPConfig) and $actionPConfig->reminders_period == \App\ActionPlan::R_WEEKLY)
                                            checked
                                            @endif
                                            value="{{ \App\ActionPlan::R_WEEKLY }}" id="weekly">
                                        <label class="custom-control-label" for="weekly">{{ __('common.weekly') }}</label>
                                    </div>
                                    <div class="reminder-value mT-5 w-75">
                                        <select name="configuration[reminders_value]" class="custom-select options"
                                                @if(!isset($actionPConfig) or (isset($actionPConfig) and $actionPConfig->reminders_period != \App\ActionPlan::R_WEEKLY)) disabled="disabled" @endif>
                                            <option value="0"
                                                    @if( (isset($actionPConfig)
                                                    and $actionPConfig->reminders_period == \App\ActionPlan::R_WEEKLY)
                                                    and $actionPConfig->reminders_value == 0)
                                                    selected
                                                    @endif
                                            >{{ __('common.monday') }}</option>
                                            <option value="1"
                                                    @if( (isset($actionPConfig)
                                                    and $actionPConfig->reminders_period == \App\ActionPlan::R_WEEKLY)
                                                    and $actionPConfig->reminders_value == 1)
                                                    selected
                                                    @endif
                                            >{{ __('common.tuesday') }}</option>
                                            <option value="2"
                                                    @if( (isset($actionPConfig)
                                                    and $actionPConfig->reminders_period == \App\ActionPlan::R_WEEKLY)
                                                    and $actionPConfig->reminders_value == 2)
                                                    selected
                                                    @endif
                                            >{{ __('common.wednesday') }}</option>
                                            <option value="3"
                                                    @if( (isset($actionPConfig)
                                                    and $actionPConfig->reminders_period == \App\ActionPlan::R_WEEKLY)
                                                    and $actionPConfig->reminders_value == 3)
                                                    selected
                                                    @endif
                                            >{{ __('common.thursday') }}</option>
                                            <option value="4"
                                                    @if( (isset($actionPConfig)
                                                    and $actionPConfig->reminders_period == \App\ActionPlan::R_WEEKLY)
                                                    and $actionPConfig->reminders_value == 4)
                                                    selected
                                                    @endif
                                            >{{ __('common.friday') }}</option>
                                            <option value="5"
                                                    @if( (isset($actionPConfig)
                                                    and $actionPConfig->reminders_period == \App\ActionPlan::R_WEEKLY)
                                                    and $actionPConfig->reminders_value == 5)
                                                    selected
                                                    @endif
                                            >{{ __('common.saturday') }}</option>
                                            <option value="6"
                                                    @if( (isset($actionPConfig)
                                                    and $actionPConfig->reminders_period == \App\ActionPlan::R_WEEKLY)
                                                    and $actionPConfig->reminders_value == 6)
                                                    selected
                                                    @endif
                                            >{{ __('common.sunday') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 reminder-wrapper">
                                    <div class="custom-radio custom-control custom-control-inline">
                                        <input name="configuration[reminders_period]" type="radio" class="custom-control-input reminders-i"
                                            @if(isset($actionPConfig) and $actionPConfig->reminders_period == \App\ActionPlan::R_MONTHLY)
                                            checked
                                            @endif
                                            value="2" id="monthly">
                                        <label class="custom-control-label" for="monthly">{{ __('common.monthly') }}</label>
                                    </div>
                                    <div class="reminder-value mT-5 w-75">
                                        <select name="configuration[reminders_value]" class="custom-select options"
                                                @if(!isset($actionPConfig) or (isset($actionPConfig) and $actionPConfig->reminders_period != \App\ActionPlan::R_MONTHLY)) disabled="disabled" @endif>
                                            @for($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}"
                                                        @if( (isset($actionPConfig)
                                                        and $actionPConfig->reminders_period == \App\ActionPlan::R_MONTHLY)
                                                        and $actionPConfig->reminders_value == $i)
                                                        selected
                                                        @endif
                                                >{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group guided-type"
                        @if((isset($actionPConfig)&& $actionPConfig->actionPlan->type == \App\ActionPlan::FREE))
                            style="display: none"
                        @endif >
                        <div class="custom-checkbox custom-control custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="configuration[tracing]"
                                id="tracing"
                                @if(isset($actionPConfig) and $actionPConfig->tracing)
                                checked
                                @endif
                                value="1">
                            <label class="custom-control-label" for="tracing">{{ __('action_plan.tracing_label') }}</label>
                        </div>
                    </div>

                    <div class="form-group guided-type"
                        @if( (isset($actionPConfig)&& $actionPConfig->actionPlan->type == \App\ActionPlan::FREE))
                            style="display: none"
                        @endif >
                        <div class="custom-checkbox custom-control custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="configuration[public]" id="public"
                                @if(isset($actionPConfig) and $actionPConfig->public)
                                checked
                                @endif
                                value="1">
                            <label class="custom-control-label" for="public">{{ __('action_plan.public_label') }}</label>
                        </div>
                    </div>

                <div class="form-group row free-type"
                    @if(!isset($actionPConfig) || (isset($actionPConfig)&& $actionPConfig->actionPlan->type == \App\ActionPlan::GUIDED))
                        style="display: none"
                    @endif>
                    <div class="col-8">
                        <div class="row align-items-end">
                            <div class="col-9"><label>{{ __('action_plan.content_type') }}</label>
                                <select class="custom-select" id="content-type">
                                    <option value="0">{{ __('action_plan.free_content') }}</option>
                                    <option value="1">{{ trans_choice('common.action', 1) }}</option>
                                    {{-- <option value="2">{{ trans_choice('common.question', 1) }}</option> --}}
                                </select>
                            </div>
                            <div class="col-3">
                                <i class="fa fa-plus-circle cur-p bgc-app-primary p-10 bdrs-4" id="add-content"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr class="mT-40 mB-20">

        {{-- Grupos de Usarios --}}
        <h2>{{ __('action_plan.link_group_users_to_ap') }}</h2>
        <fieldset class="mT-10 p-20 bgc-white border-form">
            <div class="form-group row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 r-0">
                    <label>{{ __('common.group_users') }}</label>
                    <input id="groups-i" class="form-control" placeholder="{{ __('common.search') }}"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off"
                    />
                    <div class="dropdown-menu" id="groups-drop-down">
                        <div class="dropdown-item no-results">
                            {{ __('common.no_result') }}
                        </div>
                    </div>
                </div>
            </div>
            <div id="groups-added" class="row">
                @isset($actionPConfig)
                    @isset($actionPConfig->groups)
                        @foreach($actionPConfig->groups as $group)
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 group-wrapper mT-10">
                                <div class="card p-10 h-100">
                                    <div class="row align-items-center">
                                        {{-- <div class="col-4 pR-0">
                                            <img src="{{ asset('/uploads/avatars/' .$user->avatar) }}" class="bdrs-50p" width="45px" height="45px"/>
                                        </div> --}}
                                        <div class="col-8 pL-5">
                                            {{ $group->value  }}
                                        </div>
                                    </div>
                                    <span class="fa fa-close pos-a r-2 t-2 cur-p "></span>
                                    <input type="hidden" name="groups[]" value="{{ $group->id }}"/>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                @endisset
            </div>
        </fieldset>

        <hr class="mT-40 mB-20">

        {{-- Usuarios --}}
        <h2>{{ __('action_plan.link_users_to_ap') }}</h2>
        <fieldset class="mT-10 p-20 bgc-white border-form">
            <div class="form-group row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 r-0">
                    <label>{{ trans_choice('common.user', 1) }}</label>
                    <input id="users-i" class="form-control" placeholder="{{ __('common.search') }}"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off"
                    />
                    <div class="dropdown-menu" id="users-drop-down">
                        <div class="dropdown-item no-results">
                            {{ __('common.no_result') }}
                        </div>
                    </div>
                </div>
            </div>
            <div id="users-added" class="row">
                @isset($actionPConfig)
                    {{-- {{ dd($actionPConfig->userFilter()) }} --}}
                    @foreach($actionPConfig->users as $user)
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 user-wrapper mT-10">
                            <div class="card p-10 h-100">
                                <div class="row align-items-center">
                                    <div class="col-4 pR-0">
                                        @if($user->avatar)
                                            <img src="{{ asset('/uploads/avatars/' .$user->avatar) }}" class="bdrs-50p" width="45px" height="45px"/>
                                        @else
                                            <img src="{{ asset('/uploads/avatars/unknown.png') }}" class="bdrs-50p" width="45px" height="45px"/>
                                        @endif
                                    </div>
                                    <div class="col-8 pL-5">
                                        {{ $user->fullName()  }}
                                    </div>
                                </div>
                                <span class="fa fa-close pos-a r-2 t-2 cur-p "></span>
                                <input type="hidden" name="users[]" value="{{ $user->id }}"/>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </fieldset>

        <div id="added-content" class="parent-container free-type mT-30">
            @php
                $indexQuestion = 0;
                $indexAction = 0;
                $indexFreeContent = 0;
            @endphp
            @isset($actionPConfig)
                @if($actionPConfig->actionPlan->type == \App\ActionPlan::FREE)
                    @foreach($actionPConfig->actionPlan->freePlanElements() as $element)
                        @if($element instanceof \App\Action)
                            @if(!$element->configurations->isEmpty())
                                <h2>{{ __('action_plan.add_action_to_ap') }}</h2>
                                <fieldset id="action-form" class="mT-10 p-20 bgc-white parent-container guided-type border-form">
                                @include('action_plan.form.action', ['action' => $element->configurations[0], 'index' => $indexAction])
                                {{-- <button type="button" class="btn btn-app-primary mT-15" id="new-action">{{__('action_plan.add_action') }}</button> --}}
                                {{-- <hr class="mT-40 mB-20"> --}}
                                </fieldset>
                                @php $indexAction++; @endphp
                            @endif
                        @elseif($element instanceof \App\FreeContent)
                            @include('action_plan.form.free.content', ['freeContent' => $element, 'index' => $indexFreeContent])
                            <hr class="mT-40 mB-20">
                            @php $indexFreeContent++; @endphp
                        @elseif($element instanceof \App\PlanQuestion)
                            @include('action_plan.form.free.training_question', ['question' => $element, 'index' => $indexQuestion])
                            <hr class="mT-40 mB-20">
                            @php $indexQuestion++; @endphp
                        @endif
                    @endforeach
                @endif
            @endisset
        </div>


        {{--
        <hr class="mT-30 mB-15">

        <h2>{{ __('action_plan.add_questions_to_ap') }}</h2>
        <fieldset id="question-form" class="mT-10 p-20 bgc-white border-form">
        @includeWhen(!isset($actionPConfig) || (isset($actionPConfig) and $actionPConfig->actionPlan->questions()->count() == 0),
        'action_plan.form.question', ['index' => 0, 'action_plan' => null, 'question' => null])

        @isset($actionPConfig)
        @foreach($actionPConfig->actionPlan->questions as $question)
        @include('action_plan.form.question', ['index' => $loop->index])
        @endforeach
        @endisset
        </fieldset>


        <button type="button" class="btn btn-app-primary mT-15" id="new-question">{{__('common.add_question') }}</button>
        --}}

        <div class="guided-type">
            <hr class="mT-30 mB-30">
                <h2>{{ __('action_plan.add_action_to_ap') }}</h2>
                <fieldset id="action-form" class="mT-10 p-20 bgc-white parent-container guided-type border-form">
                    @includeWhen(!isset($actionPConfig) or (isset($actionPConfig) and $actionPConfig->actionConfigurations->count() == 0), 'action_plan.form.action', ['index' => 0])
                    
                    @if(isset($actionPConfig) and $actionPConfig->actionPlan->type == \App\ActionPlan::GUIDED)
                        
                        
                            @foreach($actionPConfig->actionConfigurations as $action)
                                @include('action_plan.form.action', ['index' => $loop->index])
                            @endforeach
                        
                        {{-- <button type="button" class="btn btn-app-primary mT-15" id="new-action">{{__('action_plan.add_action') }}</button> --}}
                    @endif
                </fieldset>
                <button type="button" class="btn btn-app-primary mT-15" id="new-action">{{__('action_plan.add_action') }}</button>
                
            
            
        </div>

        <hr class="mT-30 mB-30">

        {!! Form::submit(__('common.save'),["class" => "btn btn-app-primary mr-3"])!!}

        @isset($actionPConfig)
            <input name="deleted[questions]" type="hidden"/>
            <input name="deleted[actions]" type="hidden"/>
            <input name="deleted[answers]" type="hidden"/>
        @endisset

        {!! Form::close() !!}

        @isset($actionPConfig)
            {!! Form::open([
            'class'     => 'deleteplanform',
            'route'     => ['action_plans.destroy', 'id' => $actionPConfig->id],
            'id'        => 'delete-form',
            'method'    => 'DELETE'
            ]) !!}
                {!! Form::button(__('common.delete'), [
                'class'         => 'btn btn-app-primary',
                'id'            => 'delete-action-plan'])!!}
            {!! Form::close() !!}
        @endisset
    </div>
</div>
