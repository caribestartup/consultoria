<div class="answer row align-items-center">
    <div class="form-group col-xs-12 col-sm-8 col-md-9 col-lg-9 col-xl-9">
        <input class="form-control d-inline-block answer-i" name="question[{{$question_index}}][options][][value]"
               @isset($option)
               value="{{ $option->value }}"
                @endisset/>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 col-xl-2 form-group">
        <i class="fa fa-minus-circle cur-p remove-answer"></i>
        <i class="fa fa-plus-circle cur-p new-answer"></i>
    </div>
</div>