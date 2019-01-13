<div class="bd panel-wrapper mT-10 mB-10 free-content-wrapper">
    <div class="layers">
        <div class="layer w-100 p-15 bgc-grey-200">
            <strong>{{ __('action_plan.free_content') }} <span class="number">{{ $index + 1 }}</span></strong>
            <i class="fa fa-times pull-right cur-p close-panel" data-toggle="modal" data-target="#free-content-delete-modal"></i>
            <i class="fa fa-chevron-up pull-right cur-p mr-2 minimize"></i>
        </div>
        <div class="layer w-100 p-20 panel-body  bgc-white">
            <div class="form-group">
                <label>{{ trans_choice('common.title', 1) }}</label>
                <input class="form-control title-i" name="freeContent[{{ $index }}][title]" required
                       @isset($freeContent)
                       value="{{ $freeContent->title }}"
                        @endisset/>
            </div>
            <textarea name="freeContent[{{ $index }}][content]" class="text-editor content-i">@isset($freeContent){!! $freeContent->content !!}@endisset</textarea>
        </div>

        @isset($freeContent)
            <input type="hidden" class="order-i" name="freeContent[{{ $index }}][order]" value="{{ $freeContent->action_plan_order }}"/>
        @endisset
    </div>
</div>