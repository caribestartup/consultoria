@extends('default')

@section('title')
    {{ __('common.home') }}
@endsection

@section('content')
    <br>


        @if(auth()->check() && auth()->user()->rol == 'Administrador')
            <div class="row gap-20 masonry pos-r border-form">
                <div class="masonry-sizer col-md-6"></div>
                <div class="masonry-item  w-100">
                    <div class="row gap-20">
                        <!-- #Toatl Visits ==================== -->
                        <div class='col-md-3'>
                            <div class="layers bd bgc-white p-20">
                                <div class="layer w-100 mB-10">
                                    <h6 class="lh-1">Total de Planes de acción</h6>
                                </div>
                                <div class="layer w-100">
                                    <div class="peers ai-sb fxw-nw">
                                        <div class="peer peer-greed">
                                            <span id="sparklinedash"></span>
                                        </div>
                                        <div class="peer">
                                            <a class='sidebar-link' href="{{ route('action_plans.index') }}">
                                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500">{{$nActionPlan}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- #Total Page Views ==================== -->
                        <div class='col-md-3'>
                            <div class="layers bd bgc-white p-20">
                                <div class="layer w-100 mB-10">
                                    <h6 class="lh-1">Total de Intereses</h6>
                                </div>
                                <div class="layer w-100">
                                    <div class="peers ai-sb fxw-nw">
                                        <div class="peer peer-greed">
                                            <span id="sparklinedash2"></span>
                                        </div>
                                        <div class="peer">
                                            <a class='sidebar-link' href="{{ route('interests.index') }}">
                                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500">{{$nInterest}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- #Unique Visitors ==================== -->
                        <div class='col-md-3'>
                            <div class="layers bd bgc-white p-20">
                                <div class="layer w-100 mB-10">
                                    <h6 class="lh-1">Total de Micro contenidos</h6>
                                </div>
                                <div class="layer w-100">
                                    <div class="peers ai-sb fxw-nw">
                                        <div class="peer peer-greed">
                                            <span id="sparklinedash3"></span>
                                        </div>
                                        <div class="peer">
                                            <a class='sidebar-link' href="{{ route('micro_contents.index') }}">
                                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500">{{$nMicroContent}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- #Bounce Rate ==================== -->
                        <div class='col-md-3'>
                            <div class="layers bd bgc-white p-20">
                                <div class="layer w-100 mB-10">
                                    <h6 class="lh-1">Total de Usuarios</h6>
                                </div>
                                <div class="layer w-100">
                                    <div class="peers ai-sb fxw-nw">
                                        <div class="peer peer-greed">
                                            <span id="sparklinedash4"></span>
                                        </div>
                                        <div class="peer">
                                            <a class='sidebar-link' href="{{ route('users.index') }}">
                                                <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-blue-50 c-blue-500">
                                                    {{$nUser}}
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- @if(auth()->check() && auth()->user()->is_coach == true) --}}
            <br>
            <br>
            <div class="row gap-20 masonry pos-r border-form">
                <div class="masonry-sizer col-md-6"></div>
                <div class="masonry-item col-12">
                    @include('components.charts_colunm_all', ['coachs' => $coachs, 'dataResult' => $dataResult])
                </div>
            </div>
            {{-- @endif --}}

        {{-- @elseif(auth()->check() && auth()->user()->is_coach == true)
            <div class="masonry-item col-12">
                @include('components.charts_colunm')
            </div> --}}
        @else
            <div class="masonry-item col-12">
                <!-- #Site Visits ==================== -->
                <!-- <div class="bd bgc-white"> -->
                        <div class="jumbotron">
                          <h2 class="display-3">Bienvenido, {{auth()->user()->fullName()}}!</h2>
                          <p class="lead">Sistema de consultoria automatizado para mejorar los conocimientos y organizar las acciones, los contenidos y todo lo relacionado en su area de trabajo.</p>
                          <hr class="my-4">
                          <p>Asistencia guiada por nuestra plataforma para un mejor desempeño.</p>
                          <p class="lead">
                            <a class="btn btn-primary btn-lg" href="#" role="button">Pedir Asistencia</a>
                          </p>
                        </div>
                <!-- </div> -->
            </div>

        @endif



@endsection
