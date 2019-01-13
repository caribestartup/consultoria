<div class="bd panel-wrapper mT-10 mB-10 training-wrapper"
     @isset($question)
     id="question-{{ $question->id }}"
        @endif>
    <div class="layers">
        <div class="layer w-100 bgc-grey-200 p-15">
            <strong>
                {{ trans_choice('common.question', 1) }} <span class="number">{{ $index + 1 }}</span>
                <span class="question"></span>
            </strong>
            <i class="fa fa-times pull-right cur-p close-panel" data-toggle="modal" data-target="#question-delete-modal"></i>
            <i class="fa fa-chevron-up pull-right cur-p mr-2 minimize"></i>
        </div>
        <div class="layer w-100 p-20 panel-body bgc-white">
            <div class="row mB-20">
                <div class="form-group col-xs-12 col-sm-8 col-md-9 col-lg-9 col-xl-9">
                    <label>{{ trans_choice('common.question', 1) }}</label>
                    <input class="form-control question-i" name="question[{{ $index }}][title]" required
                    @isset($question) value="{{ $question->title }}" @endisset/>
                </div>
                <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                    <label>{{ __('action_plan.answer_type') }}</label>
                    <select class="custom-select type-i" name="[question][{{ $index }}][type]">
                        <option value="{{ \App\PlanQuestion::SINGLE }}"
                                @if(isset($question) and $question->type == \App\PlanQuestion::SINGLE)
                                selected
                                @endif
                        >{{ __('common.unique') }}</option>
                        <option value="{{ \App\PlanQuestion::MULTIPLE }}"
                                @if(isset($question) and $question->type == \App\PlanQuestion::MULTIPLE)
                                selected
                                @endif
                        >{{ __('common.multiple') }}</option>
                        <option value="{{ \App\PlanQuestion::FREE_TEXT }}"
                                @if(isset($question) and $question->type == \App\PlanQuestion::FREE_TEXT)
                                selected
                                @endif
                        >{{ __('action_plan.free_text') }}</option>
                    </select>
                </div>
            </div>

            <div class="answer-div">
                <label>{{ trans_choice('common.answer', 2) }}</label>
                <div class="answers">
                    @includeWhen(!isset($question), 'action_plan.form.free.training_answer', ['index' => 0, 'question_index' => 0])

                    @isset($question)
                        @foreach($question->options as $option)
                            @include('action_plan.form.free.training_answer', ['question_index' => $index])
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>

        @isset($question)
            <input type="hidden" class="order-i" name="question[{{ $index }}][order]" value="{{ $question->action_plan_order }}"/>
        @endisset
    </div>
</div>