<li class="nav-item mT-25 {{ request()->is('/') ? 'bgc-blue-50' : '' }} border " style="font-family:Comfortaa">
    <a class='sidebar-link' href="{{ route('dash') }}" default >
        <span class="img-menu">
            {{--<i class="c-blue-500 ti-home"></i>--}}
            <img  src="{{ asset('/images/assets/home.png') }}" height="35px" width="35px" />
        </span>
        <span class="title pL-20">{{ __('common.dashboard') }}</span>
    </a>
</li>

<li class="nav-item {{ request()->is('micro_contents*') ? 'bgc-blue-50' : '' }} border " style="font-family:Comfortaa">
    <a class='sidebar-link' href="{{ route('micro_contents.index') }}">
        <span class="img-menu">
            <img src="{{ asset('/images/assets/micro_contents.png') }}" height="35px" width="35px" />
        </span>
        <span class="title  pL-20">{{ trans_choice('common.micro_content', 2) }}</span>
    </a>
</li>

@if(auth()->check() && auth()->user()->is_coach == true)
<li class="nav-item {{ request()->is('action_plans*') ? 'bgc-blue-50' : '' }} border " style="font-family:Comfortaa">
    <a class='sidebar-link' href="#">
        <span class="img-menu">
            <img src="{{ asset('/images/assets/action_plan.png') }}" height="32px" width="35px" />
        </span>
        <span class="title  pL-20">{{ trans_choice('common.action_plan', 2) }}</span>
        <i class="fa fa-sort-down text-blue title pL-20" ></i>
    </a>

    <span class="dropdown-menu dropdown-menu-right  ">
        <a class="dropdown-item" href="{{ action('ActionPlanController@index') }}">Todos</a>
        <a class="dropdown-item" href="{{ action('ActionPlanController@index_coach') }}">Coachs</a>
    </span>
</li>

@else
    <li class="nav-item {{ request()->is('action_plans*') ? 'bgc-blue-50' : '' }} border " style="font-family:Comfortaa">
        <a class='sidebar-link' href="{{ action('ActionPlanController@index') }}">
            <span class="img-menu">
                <img src="{{ asset('/images/assets/action_plan.png') }}" height="32px" width="35px" />
            </span>
            <span class="title  pL-20">{{ trans_choice('common.action_plan', 2) }}</span>
        </a>
    </li>

@endif

    <li class="nav-item {{ request()->is('interests*') ? 'bgc-blue-50' : '' }} border " style="font-family:Comfortaa">
        <a class='sidebar-link' href="{{ route('interests.index') }}">
            <span class="img-menu">
                <img src="{{ asset('/images/assets/2da-29.png') }}" height="35px" width="35px" />
            </span>
            <span class="title  pL-20">{{ trans_choice('interest.interest', 2) }}</span>
        </a>
    </li>

@if(auth()->check() && auth()->user()->rol == 'Administrador')


    <li class="nav-item {{ request()->is('users*') ? 'bgc-blue-50' : '' }} border " style="font-family:Comfortaa">
        <a class='sidebar-link ' href="{{ route('users.index') }}">
            <span class="img-menu">
                <img src="{{ asset('/images/assets/users.png') }}" height="35px" width="35px" />
            </span>
            <span class="title  pL-20">{{ trans_choice('common.user', 2) }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('chatbot*') ? 'bgc-blue-50' : '' }} border " style="font-family:Comfortaa">
        <a class='sidebar-link' href="{{ route('chatbot.index') }}">
            <span class="img-menu">
                <img src="{{ asset('/images/Untitled-1.png') }}" height="32px" width="35px" />
            </span>
            <span class="title  pL-20">Chatbot</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('setting*') ? 'bgc-blue-50' : '' }} border" style="font-family:Comfortaa">
        <a class='sidebar-link ' href="#">
            <span class="img-menu">
                {{--<i class="c-brown-500 ti-user"></i>--}}
                <img src="{{ asset('/images/assets/config.png') }}" height="35px" width="35px" />
            </span>
            <span class="title  pL-20">{{ trans_choice('common.setting', 2) }}</span>
            <i class="fa fa-sort-down text-blue title pL-20" ></i>
        </a>

        <span class="dropdown-menu dropdown-menu-right  ">
            <a class="dropdown-item" href="{{ action('DepartmentController@index') }}">{{ trans_choice('common.department', 2) }}</a>
            <a class="dropdown-item" href="{{ action('GroupController@index') }}">{{ trans_choice('common.group', 2) }}</a>
            <a class="dropdown-item" href="{{ action('TopicController@index') }}">{{ trans_choice('common.topic', 2) }}</a>
        </span>

    </li>
@endif
