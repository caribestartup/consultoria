<div class="modal fade" id="{{ $modal_id }}">
    <div class="modal-title">
        <h5 style="font-size: xx-large;">{{$title}}</h5>
    </div>
    <div class="modal-content-alert" style="text-align: center; font-size: x-large;">
        <p>{{ $content }}</p>
    </div>
    <div class="modal-footer">
        @isset($accept)
            <button type="button" class="btn btn-danger accept-button" data-dismiss="modal">{{ $accept }}</button>
        @endisset

        @isset($cancel)
            <button type="button" class="btn btn-secondary cancel-button" data-dismiss="modal">{{ $cancel }}</button>
        @endisset
    </div>
</div>
