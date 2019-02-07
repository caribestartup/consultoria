<div class="bd panel-wrapper mT-10 mB-10 action-wrapper"
     @isset($action)
     id="action-{{ $action->id }}"
        @endif
>
    <div class="layers">
        <div class="layer w-100 bgc-grey-200 p-15">
            <strong>
                {{ trans_choice('common.action', 1) }} <span class="action-number">{{ $index + 1 }}</span>
            </strong>
            <i class="fa fa-times pull-right cur-p close-panel" data-toggle="modal" data-target="#action-delete-modal"></i>
            <i class="fa fa-chevron-up pull-right cur-p mr-2 minimize"></i>
        </div>
        <div class="layer w-100 p-20 panel-body bgc-white">
            <div class="mB-20">
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-8 col-md-9 col-lg-9 col-xl-9">
                        <label>{{ trans_choice('common.title', 1) }}</label>
                        <input class="form-control title-i" name="action[{{ $index }}][title]" required
                               @isset($action)
                               value="{{ $action->action->title }}"
                                @endisset/>
                    </div>
                    <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                        <label>{{ trans_choice('action_plan.action_plan_percent', 2) }}</label>
                        <input class="form-control percent-i" name="action[{{ $index }}][objectives_percent]" required type="number"
                               @isset($action)
                               value="{{ $action->action->objectives_percent }}"
                                @endisset/>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ trans_choice('common.objective', 2) }}</label>
                    <textarea name="action[{{ $index }}][objectives]" class="form-control objectives-i">@isset($action){{$action->action->objectives}}@endisset</textarea>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <label for="start-date">{{ __('common.start_date') }}</label>
                        <input class="form-control datepicker start-date-i"
                               name="action[{{ $index }}][configuration][start_date]"
                               @isset($action)
                               value="{{ $action->start_date }}"
                               @endisset
                               autocomplete="off"
                        >
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <label for="start-date">{{ __('common.ending_date') }}</label>
                        <input class="form-control datepicker ending-date-i"
                               name="action[{{ $index }}][configuration][ending_date]"
                               @isset($action)
                               value="{{ $action->ending_date }}"
                               @endisset
                               autocomplete="off"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-checkbox custom-control">
                        <input type="checkbox" class="collaboration-i custom-control-input"
                               id="collaboration-{{$index}}"
                               name="action[{{ $index }}][configuration][collaboration]"
                               @if(isset($action) and $action->collaboration)
                               checked
                               @endif
                               value="1">
                        <label class="custom-control-label" for="collaboration-{{$index}}">{{ __('action_plan.collaborator_for_action') }}</label>
                    </div>
                </div>

                <div class="mB-10 mT-30">
                    <strong>{{ __('action_plan.link_micro_contents') }}</strong>
                </div>
                {{--<button class="btn btn-default link-micro-content"
                        type="button" data-action-index="{{ $index }}">
                    {{ trans_choice('common.micro_content', 2) }}
                </button>
                --}}

                <div class="micro-contents-added row pL-15 pR-15">
                    <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2 image-checkbox text-center">
                        <img class="img-responsive h-100 w-100 of-cv bdrs-4 link-micro-content micro-c-image cur-p" src="{{ asset('images/add.svg') }}" />
                    </div>
                    @isset($action)
                        @foreach($action->action->microContents as $microContent)
                            <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 col-xl-2 nopad text-center image-checkbox">
                                @if(count($microContent->images) > 0)
                                    <img class="img-responsive h-100 w-100  of-cv bdrs-4 micro-c-image" src="@if(strpos($microContent->images[0]->url, 'http') === 0)
                                    {{ $microContent->images[0]->url }}
                                    @else
                                    {{ asset($microContent->images[0]->url) }}
                                    @endif" />
                                @else
                                    <img class="img-responsive h-100 w-100 of-cv bdrsT-4 micro-c-image" src="{{ asset('images/noimage.png') }}"/>
                                @endif
                                <input type="hidden" value="{{ $microContent->id }}" class="micro-content-i" name="action[{{ $index }}][micro_content][]" />
                                <i class="fa fa-close"></i>
                                <label>{{ $microContent->title }}</label>
                            </div>
                        @endforeach
                    @endisset
                </div>

                <div class="mB-10 mT-30">
                    <strong>{{ __('action_plan.training_questions') }}</strong>
                </div>

                <div class="training question-form">
                    @includeWhen(!isset($action) or (isset($action) and $action->action->questions->count() == 0) , 'action_plan.form.question', ['index' => 0, 'action_index' => 0])

                    @isset($action)
                        @foreach($action->action->questions as $question)
                            @include('action_plan.form.question', ['index' => $loop->index, 'action_index' => $index])
                        @endforeach
                    @endisset
                </div>

                <button type="button" class="btn btn-app-primary mT-15 new-question">{{__('common.add_question') }}</button>

            </div>
        </div>

        @if(isset($action) and $actionPConfig->actionPlan->type == \App\ActionPlan::FREE)
            <input type="hidden" name="action[{{ $index }}][order]" class="order-i" value="{{ $action->action->action_plan_order }}"/>
        @endisset
    </div>
</div>