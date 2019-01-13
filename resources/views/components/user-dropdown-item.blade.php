@if(count($users) > 0)
    <div>
        @foreach($users as $user)
            <div data-id="{{ $user->id }}" data-name="{{ $user->fullName() }}"
                 class="dropdown-item cur-p item">
                <div class="row align-items-center">
                    <div class="col-4 pR-0">
                        <img src="@if($user->avatar){{ asset('/uploads/avatars/' .$user->avatar) }}@else {{ asset('/images/unknown.png') }} @endif" class="bdrs-50p" width="45px" height="45px"/>
                    </div>
                    <div class="col-8 pL-10">
                        {{ $user->fullName()  }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif