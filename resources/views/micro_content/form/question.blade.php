<div class="bd panel-wrapper mT-10 mB-10 "
     @isset($microContent)
         id="question-{{ $question->id }}"
    @endif
>
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
                <div class="form-group col-xs-12 col-sm-8 col-md-8 col-lg-9 col-xl-9">
                    <label>{{ trans_choice('common.question', 1) }}</label>
                    <input class="form-control question-i" name="question[{{ $index }}][value]" required
                           @isset($question)
                           value="{{ $question->value }}"
                            @endisset/>
                </div>
                <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                    <label>{{ trans_choice('common.point', 2) }}</label>
                    <input class="form-control points-i" name="question[{{ $index }}][points]" required type="number"
                           @isset($question)
                           value="{{ $question->points }}"
                            @endisset/>
                </div>
            </div>

            <label>{{ trans_choice('common.answer', 2) }}</label>
            <div class="answers">
                @includeWhen(!isset($question), 'micro_content.form.answer', ['index' => 0, 'question_index' => 0])

                @isset($question)
                    @foreach($question->answers as $answer)
                        @include('micro_content.form.answer', ['index' => $loop->index, 'question_index' => $loop->parent->index])
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</div>