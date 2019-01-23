<div class="answer row align-items-center">
    <div class="form-group col-xs-12 col-sm-8 col-md-8 col-lg-9 col-xl-9">
        <input class="form-control d-inline-block answer-i" name="question[{{$question_index}}][answers][][value]"
               @isset($answer)
               value="{{ $answer->value }}"
                @endisset
        />
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 col-xl-3 form-group">
        <div class="custom-control custom-radio mr-2 custom-control-inline">
            <input type="radio" id="correct-{{ $index + 1 }}0" question="1" name="question[{{$question_index }}][is_correct]" 
            		class="custom-control-input correct-i"
                    @isset($answer)
                        value="{{ $index }}"
                        @if($answer->is_correct)
                            checked
                        @endif
                    @endisset

                    @empty($answer)
                        value="{{ $index }}"
                        checked
                    @endempty
            >
            <label class="custom-control-label" for="correct-{{ $index  + 1 }}0">{{ __('common.correct') }}</label>
        </div>
        <i class="fa fa-minus-circle cur-p remove-answer"
           @isset($answer)
           id="answer-{{ $answer->id }}"
                @endisset
        ></i>
        <i class="fa fa-plus-circle cur-p new-answer"></i>
    </div>
</div>