@if(count($groups) > 0)
    <div>
        @foreach($groups as $group)
            <div data-id="{{ $group->id }}" data-name="{{ $group->value }}"
                 class="dropdown-item cur-p item">
                <div class="row align-items-center">
                    {{-- <div class="col-4 pR-0">
                        <img src="@if($group->avatar){{ asset('/uploads/avatars/' .$group->avatar) }}@else {{ asset('/images/unknown.png') }} @endif" class="bdrs-50p" width="45px" height="45px"/>
                    </div> --}}
                    <div class="col-8 pL-10">
                        {{ $group->value  }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif