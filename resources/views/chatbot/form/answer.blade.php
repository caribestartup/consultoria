<div class="answer row align-items-center">
    <div class="form-group col-xs-12 col-sm-8 col-md-8 col-lg-9 col-xl-9">
        <input class="form-control d-inline-block answer-i" name="question[{{$question_index}}][answers][][value]"
            @isset($answer)
               value="{{ $answer->value }}"
            @endisset
        />
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 col-xl-3 form-group">
        <i class="fa fa-minus-circle cur-p remove-answer"
           @isset($answer)
           id="answer-{{ $answer->id }}"
                @endisset
        ></i>
        <i class="fa fa-plus-circle cur-p new-answer"></i>
    </div>
</div>