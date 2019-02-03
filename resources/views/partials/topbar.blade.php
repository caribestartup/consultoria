<div class="header navbar header-nav-bar navbar-dark navbar-fixed-top navbar navbar-expand-lg " role="navigation">
    <div class="header-container ">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav-left " role="navigation">
            <li class=" top-menu-item">
                <a id='sidebar-toggle' class="sidebar-toggle  text-white" href="javascript:void(0);">
                    <i class="ti-menu mx"></i>
                </a>
            </li>
        </ul>

        @php
            $notifications = \App\Http\Controllers\NotificationController::unread();
            $chatbots = \App\Http\Controllers\ChatbotController::unread();
            // dd($chatbots);
            // dd($chatbots->firstQuestion())
        @endphp

        <ul class="nav-right md-lg-12 collapse navbar-collapse navbar-nav " id="navbarSupportedContent">

            <li class="top-menu-item" style="padding-top: 15px">
                <div class="form-group search-image">
                    <input class="search-text" style="width: 100%;" type="search" placeholder="" >
                    <i class="fa fa-search fa-lg fa-fw"></i>
                </div>
            </li>

            <!--usuario-->
            <li class="dropdown top-menu-item font" >
                <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown" >
                    <div class="peer ml-1" style="text-align: right ">
                        <span class="fsz-sm c-grey-50">{{ auth()->user()->name .' '. auth()->user()->last_name }}</span>
                        <br>
                        <span class="fsz-sm c-grey-500" >
                            @foreach(auth()->user()->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </span>
                    </div>
                    <div class="peer mR-10" style="padding-left: 10px">
                        <!-- <img class="w-2r bdrs-50p" src="{{ auth()->user()->avatarUrl }}" alt="">  -->
                        @if(auth()->user()->avatar)
                            <img class="w-2r bdrs-50p" src="{{ asset('/uploads/avatars/'.auth()->user()->avatar) }}" alt="{{ trans('users.user_avatar_alt') }}">
                            @else
                            <img class="w-2r bdrs-50p" src="{{ asset('/uploads/avatars/unknown.png') }}" alt="{{ trans('users.user_avatar_alt') }}">
                        @endif
                        <!-- <img class="w-2r bdrs-50p" src="{{ asset('/images/unknown.png') }}" alt=""> -->
                        <i class="fa fa-sort-down text-white"></i>
                    </div>
                </a>
                <ul class="dropdown-menu fsz-sm">
                    <!-- <li>
                        <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-settings mR-10"></i>
                            <span>{{ trans_choice('common.setting', 1) }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-user mR-10"></i>
                            <span>{{ trans_choice('common.profile', 1) }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-email mR-10"></i>
                            <span>{{ trans_choice('common.message', 2) }}</span>
                        </a>
                    </li>
                    <li role="separator" class="divider"></li> -->
                    <li>
                        <a href="{{ route('logout') }}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-power-off mR-10"></i>
                            <span>{{ __('login.logout') }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!--notificaciones-->

            <ul class="nav-right">
                <li class="notifications dropdown top-menu-item">
                    @if($notifications->count() > 0)
                        <span class="counter bgc-red">{{ $notifications->count() }}</span>
                    @endif
                    <a href="" class="dropdown-toggle no-after text-white" data-toggle="dropdown">
                        <img src="{{ asset('/images/assets/top_notif.png') }}" height="32px" width="32px"/>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="pX-20 pY-15 bdB">
                            <i class="ti-bell pR-10"></i>
                            <span class="fsz-sm fw-600 c-grey-900">{{ trans_choice('common.notification', 2) }}</span>
                        </li>
                        <li class="list-not">
                            <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                                @foreach($notifications as $notification)
                                    <a href="{{ $notification->url()['url'] }}" class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'>
                                        <div class="peer mR-15">
                                            <img class="" src="{{ asset($notification->image()) }}" alt="" width="35px" height="35px">
                                        </div>
                                        <div class="peer peer-greed">
                                            <span>
                                                <span class="fw-500">{{ $notification->message() }}</span>
                                                <span class="c-grey-600">Inicia <span class="text-dark">{{ $notification->url()['inicio'] }}</span></span>
                                            </span>
                                            @if(isset($notification->url()['dias']))
                                                <span class="{{$notification->url()['class']}}">
                                                    <p class="m-0">
                                                        <small class="fsz-xs">{{ $notification->url()['dias'] }} {{$notification->url()['mgs']}} </small>
                                                    </p>
                                                </span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                        {{--<li class="pX-20 pY-15 ta-c bdT">
                            <span>
                                <a href="" class="c-grey-600 cH-blue fsz-sm td-n">{{ __('notification.view_all') }}
                                    <i class="ti-angle-right fsz-xs mL-10"></i>
                                </a>
                            </span>
                        </li>--}}
                    </ul>
                </li>
            </ul>
            <!--chatbot-->
            <ul class="nav-right">
                @if($chatbots != null)
                    @if($chatbots->firstQuestion() != null)
                        <li class="notifications dropdown top-menu-item show">
                            {{-- <span class="counter bgc-blue">3</span> --}}
                            {{-- <a href="" class="dropdown-toggle no-after text-white"> --}}
                            <a href="" class="dropdown-toggle no-after text-white">
                                <img src="{{ asset('/images/assets/chatbotTop.png') }}" height="32px" width="32px"/>
                            </a>
                    @else
                        <li class="notifications dropdown top-menu-item">
                    @endif
                @endif
                    <ul class="dropdown-menu">
                        <li class="pX-20 pY-15 bdB">
                            <i class="ti-bell pR-10"></i>
                            <span class="fsz-sm fw-600 c-grey-900">Chatbot</span>
                        </li>
                        <li class="list-chat">
                            @if($chatbots != null)
                                @if($chatbots->firstQuestion() != null)
                                    @include('chatbot.form.question_chat', ['question' => $chatbots->firstQuestion()])
                                @endif
                            @endif
                        </li>
                        {{--<li class="pX-20 pY-15 ta-c bdT">
                            <span>
                                <a href="" class="c-grey-600 cH-blue fsz-sm td-n">{{ __('notification.view_all') }}
                                    <i class="ti-angle-right fsz-xs mL-10"></i>
                                </a>
                            </span>
                        </li>--}}
                    </ul>
                </li>
            </ul>
        </ul>
    </div>
</div>

