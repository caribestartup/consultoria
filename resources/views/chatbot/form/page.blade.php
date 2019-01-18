<div class="bd panel-wrapper mT-10 mB-10">
    <div class="layers">
        <div class="layer w-100 p-15 bgc-grey-200">
            <strong>{{ __('micro_content.page') }} <span class="number">{{ $index + 1 }}</span></strong>
            <i class="fa fa-times pull-right cur-p close-panel" data-toggle="modal" data-target="#page-delete-modal"></i>
            <i class="fa fa-chevron-up pull-right cur-p mr-2 minimize"></i>
        </div>
        <div class="layer w-100 p-20 panel-body  bgc-white">
            <div class="form-group">
                <label>{{__('common.title') }}</label>
                <input class="form-control title-i" name="page[{{ $index }}][title]" required
                       @isset($page)
                       value="{{ $page->title }}"
                        @endisset
                />
            </div>
            <div>
            <textarea name="page[{{ $index }}][content]" class="text-editor content-i">@isset($page){{ $page->content }}@endisset</textarea>
            </div>
        </div>
    </div>
</div>