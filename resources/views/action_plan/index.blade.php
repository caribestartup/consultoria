@extends('default')

@section('title')
    {{ trans_choice('common.action_plan', 2) }}
@endsection

@section('css')
    <style>
        .items a  {
            color: #003C4F !important;
        }

        .speaker-coach {
            top: 90px;
            right: 35%;
        }
    </style>

    <link href="{{ asset('/plugins/circle/circle.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="row title-page-buttom">
        <div class="col-xs-12 col-sm-6 pT-10">
            @include('components.index_create', [
            'title' => trans_choice('common.action_plan', 2),
            'url'   => route('action_plans.create'),
            'create'=> __('action_plan.create_action_plan')
            ])
        </div>
    </div>
    <div class="row items">
        @foreach($actionPConfigs as $actionPConfig)
            @php
                $isActive = $actionPConfig->startDate() >= now() and now() <= $actionPConfig->endingDate();
            @endphp

            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 mT-20">
                <a class="card-action-plan h-100" href="{{ action('ActionPlanController@show', ['id' => $actionPConfig->id ]) }}">
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                            <div class="pL-10 pR-10 pT-10">
                        <div class="pos-a">
                            @if($isActive)
                                <img src="{{ asset('images/assets/activo.png') }}" height="45px"/>
                            @else
                                <img src="{{ asset('images/assets/inactive.png') }}" height="45px"/>
                            @endif
                        </div>
                        <div class="text-left font-plan-up pL-60">
                            {{ $actionPConfig->actionPlan->title }}
                        </div>
                        <div class="row align-items-center mT-20">
                            <div class="col">

                                <div class="inner-content text-right">
                                    <div class="row">
                                        <div class="col-3 card-label-date1">
                                            Creado:<br>
                                            {{date('d-m-Y', strtotime($actionPConfig->start_date)) }}
                                        </div>
                                        <div class="col-6 ">
                                            <div class="c100 p{{ $actionPConfig->compliment() }} center green">
                                        <span>{{ $actionPConfig->compliment() }}%</span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                        </div>
                                        <div class="col-3 card-label-date2">
                                            Fecha tope:<br>
                                            {{date('d-m-Y', strtotime($actionPConfig->ending_date)) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mT-20">
                            <div style="width: 33%">
                                <figure class="text-center font-plan-down">
                                    {{ trans_choice('common.action', 2) }}<br>
                                    <img style="margin-top: 5px" src="{{ asset('images/assets/action.png') }}" height="32px"/><br>
                                    <figcaption>
                                        <div class="c-blue-800 mT-10">
                                            <strong>{{ $actionPConfig->actionConfigurations->count() }}</strong>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                            <div style="width: 33%">
                                <figure class="text-center font-plan-down">
                                {{ trans_choice('common.knowledge', 2) }}<br>
                                    <img style="margin-top: 5px" src="{{ asset('images/assets/knowledge.png') }}" height="32px"/><br>
                                    <figcaption>

                                        <div class="c-blue-800 mT-10">
                                            <strong>{{ $actionPConfig->trainingsAmount() }}</strong>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                            <div style="width: 33%">
                                <figure class="text-center font-plan-down">
                                {{ trans_choice('common.evaluation', 2) }}<br>
                                    <img style="margin-top: 5px" src="{{ asset('images/assets/evaluation.png') }}" height="32px"/><br>
                                    <figcaption>

                                        <div class="c-blue-800 mT-10">
                                            <strong>{{ $actionPConfig->notePorcent() }}</strong>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>

                        </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 card-div-right">
                            <div class="row text-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-15">
                                    <img class="user-thumbail" src="{{ auth()->user()->avatarUrl }}" alt="">
                                    <h4 class="user-label">{{$actionPConfig->user->fullName()}}</h4>
                                    <h4 class="rol-label">{{$actionPConfig->user->rol}}</h4>
                                </div>
                                @if(!$actionPConfig->coach()->get()->isEmpty())
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-20">
                                        <img style="margin-left: 30px;position: absolute;" src="{{ asset('images/assets/ASSET-19.png') }}" height="30px"/>
                                        <img class="user-thumbail" style="margin-top: 10px;width: 50px !important;" src="{{ $actionPConfig->coach()->get()[0]->getAvatarUrlAttribute() }}" height="42px"/>
                                        <br>
                                        <h4 class="user-label">{{ $actionPConfig->coach()->get()[0]->fullName() }}</h4>
                                    </div>
                                @else
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-20">
                                        {{-- <img style="margin-left: 30px;position: absolute;" src="{{ asset('images/assets/ASSET-20.png') }}" height="42px"/> --}}
                                        <img class="user-thumbail" style="margin-top: 10px;width: 42px !important;" src="{{ asset('images/assets/ASSET-20.png') }}" height="42px"/>
                                        <br>
                                        <h4 class="user-label">Sin coach</h4>
                                    </div>
                                @endif
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-20">
                                    {{-- TODO --}}
                                    @if(\Illuminate\Support\Facades\Auth::user()->id === $actionPConfig->user->id || \Illuminate\Support\Facades\Auth::user()->rol == 'Administrador')
                                        <button class="card-buttom-edit edit-plan" href="{{ action('ActionPlanController@edit', ['id' => $actionPConfig->id ]) }}">Editar Plan</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{ $actionPConfigs->links() }}
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.edit-plan').click(function (e) {
                e.preventDefault();
                window.location = $(this).attr('href');
            });
        });
    </script>
@endsection
