<div class="modal fade" id="{{ $modal_id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
    </div>
</div>
