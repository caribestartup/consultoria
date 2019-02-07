@if(isset($chatbot))
    {!! Form::model($chatbot,
    ['route' => ['chatbot.update', $chatbot->id],
    'method' => 'PUT']) !!}
@else
    {!! Form::open(['route' => 'chatbot.store']) !!}
@endif
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
            <fieldset class="mT-10 bgc-white p-20 border-form">

                <input type="hidden" name="chatbot[is_design]"
                    @if(isset($chatbot))
                        value="{{ $chatbot->is_design }}"
                    @else
                        value="0"
                    @endif
                >
                
                <h2>{{ __('chatbot.general') }}</h2>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>{{ __('chatbot.name') }}</label>
                            <input class="form-control" name="chatbot[name]" id="name" required
                                @isset($chatbot)
                                    value="{{ $chatbot->name }}"
                                @endisset
                            />
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>{{ __('chatbot.description') }}</label>
                            <input class="form-control" name="chatbot[description]" id="name" required
                                @isset($chatbot)
                                    value="{{ $chatbot->description }}"
                                @endisset
                            />
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>{{ __('chatbot.approach') }}</label>
                            <select id="approach" name="chatbot[approach]" class="form-control">
                                @foreach($approachOptions as $opt)
                                    @if(isset($chatbot))
                                        @if($chatbot->approach == $opt)
                                            <option selected value="{{$opt}}">{{$opt}}</option>
                                        @else
                                            <option value="{{$opt}}">{{$opt}}</option>
                                        @endif
                                    @else
                                        <option  @if($loop->index == 0) selected @endif value="{{$opt}}">{{$opt}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row free-type">
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                        <label for="start-date">Lanzamiento</label>
                        <input class="form-control datepicker"
                               name="chatbot[launch]"
                               @isset($chatbot)
                               value="{{ $chatbot->launch }}"
                               @endisset
                               autocomplete="off"
                               {{-- required --}}
                        />
                    </div>
                </div>
            </fieldset>

            <hr class="mT-40 mB-20">

            <h2>{{ __('chatbot.add_evaluation_questions') }}</h2>
            <fieldset id="question-form" class="mT-10 p-20 bgc-white border-form">
                @includeWhen(!isset($chatbot) || (isset($chatbot) and $chatbot->questions()->count() == 0),
                    'chatbot.form.question', ['index' => 0, 'chatbot' => null, 'question' => null])

                @isset($chatbot)
                    @foreach($chatbot->questions as $question)
                        @include('chatbot.form.question', ['index' => $loop->index])
                    @endforeach
                @endisset
            </fieldset>

            <button type="button" class="btn btn-app-primary mT-15" id="new-question">{{__('common.add_question') }}</button>

            <hr class="mT-30 mB-30">

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
                    @isset($chatbot)
                        @isset($chatbot->groups)
                            @foreach($chatbot->groups as $group)
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

            <h2>{{ __('chatbot.add_user') }}</h2>
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
                    @isset($chatbot)
                        @foreach($chatbot->users as $user)
                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 user-wrapper mT-10">
                                <div class="card p-10 h-100">
                                    <div class="row align-items-center">
                                        @if($user->avatar)
                                            <img src="{{ asset('/uploads/avatars/' .$user->avatar) }}" class="bdrs-50p" width="45px" height="45px"/>
                                        @else
                                            <img src="{{ asset('/uploads/avatars/unknown.png') }}" class="bdrs-50p" width="45px" height="45px"/>
                                        @endif
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

            {{-- <hr class="mT-30 mB-15">

            <h2>{{ __('chatbot.link_actions') }}</h2>
            <fieldset id="action-form" class="mT-10 p-20 bgc-white border-form">
                @include('chatbot.form.action')
            </fieldset> --}}

            <hr class="mT-30 mB-30">

            {!! Form::submit(__('common.save'),["class" => "btn btn-app-primary mr-3"]) !!}

                @isset($chatbot)
                    <input name="deleted[questions]" type="hidden"/>
                    <input name="deleted[answers]" type="hidden"/>
                @endisset

            {!! Form::close() !!}

            @isset($chatbot)
                {!! Form::open([
                'class'     => 'deletechatform',
                'route'     => ['chatbot.destroy', 'id' => $chatbot->id],
                'id'        => 'delete-form',
                'method'    => 'DELETE'
                ]) !!}
                    {!! Form::button(__('common.delete'), [
                        'class'         => 'btn btn-app-primary',
                        'id'            => 'delete-micro-content',
                        'data-toggle'   => "modal",
                        'data-target'  => "#delete-modal"])
                    !!}
                {!! Form::close() !!}
            @endisset
        </div>
    </div>
{!! Form::close() !!}