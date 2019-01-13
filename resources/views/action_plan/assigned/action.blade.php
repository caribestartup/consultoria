<div class="bd panel-wrapper mT-10 mB-10 action-wrapper bgc-white">
    <div class="layers">
        <div class="layer w-100 p-15">
            <strong>
                {{ $actionConfig->action->title }}
            </strong>
            <i class="fa fa-chevron-up pull-right cur-p mr-2 minimize"></i>
            @if($actionConfig->ending_date != null)
                <div class="pull-right mr-3">
                    <i class="fa fa-clock-o mr-1 c-orange-800"></i>
                    <span>{{ $actionConfig->ending_date }}</span>
                </div>
            @endif
        </div>
        <div class="layer w-100 pR-20 pL-20 pB-20 panel-body ">
            <div class="mB-20">
                <div>
                    <div class="mB-10">
                        <strong>{{ __('action_plan.about_action_to_develop') }}</strong>
                    </div>
                    <div class="mB-15">
                        <div>{{ __('action_plan.done_before_question') }}</div>
                        <div class="pL-20 mT-10">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio"
                                       name="action[{{ $actionConfig->id }}][done_before]"
                                       value="1"
                                       id="db-y-{{ $actionConfig->id }}"
                                       @if($actionConfig->done_before == 1)
                                       checked
                                        @endif
                                />
                                <label class="custom-control-label" for="db-y-{{ $actionConfig->id }}">{{ __('common.yes') }}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio"
                                       name="action[{{ $actionConfig->id }}][done_before]"
                                       value="0"
                                       id="db-n-{{ $actionConfig->id }}"
                                       @if($actionConfig->done_before == 0)
                                       checked
                                        @endif
                                />
                                <label class="custom-control-label" for="db-n-{{ $actionConfig->id }}">{{ __('common.no') }}</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>{{ __('action_plan.know_what_to_do_question') }}</div>
                        <div class="pL-20 mT-10">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio"
                                       name="action[{{ $actionConfig->id }}][know_what_to_do]"
                                       value="1"
                                       id="kwtd-y-{{ $actionConfig->id }}"
                                       @if($actionConfig->know_what_to_do == 1)
                                       checked
                                        @endif
                                />
                                <label class="custom-control-label" for="kwtd-y-{{ $actionConfig->id }}">{{ __('common.yes') }}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio"
                                       name="action[{{ $actionConfig->id }}][know_what_to_do]"
                                       value="0"
                                       id="kwtd-n-{{ $actionConfig->id }}"
                                       @if($actionConfig->know_what_to_do == 0)
                                       checked
                                        @endif
                                />
                                <label class="custom-control-label" for="kwtd-n-{{ $actionConfig->id }}">{{ __('common.no') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mB-15 mT-15">

                <div>
                    <div class="mB-10">
                        <strong>{{ __('action_plan.value_your_knowledge') }}</strong>
                    </div>
                    <div class="mB-15">
                        <div class="d-inline mR-10">{{ __('action_plan.value_your_knowledge_about_this_action') }}</div>
                        <div class="star-rating d-inline">
                            <span class="fa fa-star-o" data-rating="1" style="cursor: pointer"></span>
                            <span class="fa fa-star-o" data-rating="2" style="cursor: pointer"></span>
                            <span class="fa fa-star-o" data-rating="3" style="cursor: pointer"></span>
                            <span class="fa fa-star-o" data-rating="4" style="cursor: pointer"></span>
                            <span class="fa fa-star-o" data-rating="5" style="cursor: pointer"></span>
                            <input name="action[{{ $actionConfig->id }}][knowledge_level]" type="hidden" class="rating-value"
                                   value="{{ $actionConfig->knowledge_level }}"/>
                        </div>
                    </div>

                    <div>
                        <div>{{ __('action_plan.know_how_to_improve') }}</div>
                        <div class="pL-20 mT-10 mB-10">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio"
                                       name="action[{{ $actionConfig->id }}][know_how_to_improve]"
                                       value="1"
                                       id="kwti-y-{{ $actionConfig->id }}"
                                       @if($actionConfig->know_how_to_improve == 1)
                                       checked
                                        @endif
                                />
                                <label class="custom-control-label" for="kwti-y-{{ $actionConfig->id }}">{{ __('common.yes') }}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio"
                                       name="action[{{ $actionConfig->id }}][know_how_to_improve]"
                                       value="0"
                                       id="kwti-n-{{ $actionConfig->id }}"
                                       @if($actionConfig->know_what_to_do == 0)
                                       checked
                                        @endif
                                />
                                <label class="custom-control-label" for="kwti-n-{{ $actionConfig->id }}">{{ __('common.no') }}</label>
                            </div>
                        </div>

                        <textarea class="form-control" placeholder="{{ __('action_plan.write_suggestions') }}"
                                  name="action[{{ $actionConfig->id }}][improve_knowledge]">@isset($actionConfig){{ $actionConfig->improve_knowledge }}@endisset</textarea>
                    </div>
                </div>

                @if($actionConfig->action->microContents->count() > 0)
                    <hr class="mB-15 mT-25">
                    <div>
                        <div class="mB-10">
                            <strong>{{ __('action_plan.you_can_check') }}</strong>
                        </div>
                        <div class="row">
                            @foreach($actionConfig->action->microContents as $microContent)
                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 mB-15">
                                    <a href="{{ action('MicroContentController@show', ['id' => $microContent->id]) }}" target="_blank">

                                        <img class="img-responsive h-100 of-cv bdrsT-4" src="
                                    @if($microContent->images->count() > 0)
                                        {{ asset($microContent->images[0]->url) }}
                                        @else
                                        {{ asset('images/noimage.png') }}
                                        @endif">
                                        <div class="text-center bgc-app-primary bdrsB-4">{{ $microContent->title }}</div>

                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($actionConfig->action->questions->count() > 0)
                    <hr class="mB-15 mT-25">
                    <strong>{{ __('common.training') }}</strong>
                    <div class="row">
                        @foreach($actionConfig->action->questions as $question)
                            @include('action_plan.assigned.question', ['index' => $loop->index])
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>