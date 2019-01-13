<div class="answer row align-items-center ">
    <div class="form-group col-xs-12 col-sm-8 col-md-9 col-lg-9 col-xl-9">
        <input class="form-control d-inline-block answer-i" name="action[{{ $action_index }}][question][{{$question_index}}][options][][value]"
               @isset($option)
               value="{{ $option->value }}"
                @endisset
        />
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-3 form-group">
        <i class="fa fa-minus-circle cur-p remove-answer"
           @isset($option)
           id="answer-{{ $option->id }}"
                @endisset
        ></i>
        <i class="fa fa-plus-circle cur-p new-answer"></i>
    </div>
</div>