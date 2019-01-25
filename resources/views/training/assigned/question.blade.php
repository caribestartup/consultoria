<div class="col-xs-12 col-sm12 col-md-6 col-lg-6 col-xl-6">
    <div class="bd panel-wrapper mT-10 mB-10">
        <div class="layers">
            <div class="layer w-100 bgc-grey-200 p-15">
                <strong>
                    {{ trans_choice('common.question', 1) }} <span class="number">{{ $index + 1 }}</span>
                    <span class="question"></span>
                </strong>
                <i class="fa fa-chevron-down pull-right cur-p mr-2 minimize"></i>
            </div>

            <div class="layer w-100 p-20 panel-body bgc-white" style="display: none">
                <div class="mB-10">{{ $question->title }}</div>
                <div>
                    @php
                        $multiple = '';
                        if($question->type == \App\PlanQuestion::SINGLE)
                            $inputType = 'radio';
                        else{
                            $inputType = 'checkbox';
                            $multiple= '[]';
                          }
                    @endphp

                    @if($question->type == \App\PlanQuestion::SINGLE || $question->type == \App\PlanQuestion::MULTIPLE)
                        @foreach($question->options as $option)
                            <div class="custom-control custom-{{$inputType}}">
                                <input class="custom-control-input" type="{{ $inputType }}"
                                       name="action[{{ $actionConfig->id }}][question][{{ $question->id }}][value]{{ $multiple }}"
                                       value="{{ $option->id }}"
                                       id="{{ $actionConfig->id }}-{{ $option->id }}"
                                       @if($question->userAnswered(
                                       \Illuminate\Support\Facades\Auth::user()->id,
                                       $question->id,
                                       $option->id
                                       )->count() > 0)
                                       checked
                                        @endif

                                />
                                <label class="custom-control-label" for="{{ $actionConfig->id }}-{{ $option->id }}">{{ $option->value }}</label>
                            </div>
                        @endforeach
                    @else
                        @php $answer = $question->userAnswered(
                                   \Illuminate\Support\Facades\Auth::user()->id,
                                   $question->id)
                        @endphp
                        <textarea class="form-control" name="action[{{ $actionConfig->id }}][question][{{ $question->id }}][value]">@if($answer->count() > 0){{ $answer[0]->value }}@endif</textarea>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>