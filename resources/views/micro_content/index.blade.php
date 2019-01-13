@extends('default')
@section('title')
    {{ trans_choice('common.micro_content', 2) }}
@endsection
@section('css')
    <style>
        .item-list a {
            color: #003C4F;
        }

        .view {
            padding-left: 25px !important;
            padding-right: 25px !important;
        }
    </style>
@endsection

@section('content')
    <div class="row title-page-buttom">
        <div class="col-xs-12 col-sm-6">
            @include('components.index_create', [
            'title' => trans_choice('common.micro_content', 2),
            'url'   => route('micro_contents.create'),
            'create'=> __('micro_content.create_micro_content')
            ])
        </div>
    </div>


    <div class="row">
        @foreach($microContents as $microContent)
             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 mT-20">
                <div class="card-action-plan card h-100">
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                            <div class="pR-15 pL-15 pB-10 pT-10 flex-fill title-microcontent-font title-microcontent-div">
                        {{ $microContent->title }}
                    </div>
                    <div class="row flex-fill card-text m-10">
                        <h4 class="contenido-title-microcontent-font">Contenido:</h4>
                        <p class="contenido-body-microcontent-font">
                            Para conseguir nuestros objetivos para conseguir nuestros para conseguir nuestros para conseguir nuestros Para conseguir nuestros objetivos.
                        </p>

                    </div>
                    <div class="text-center">
                            <a href="{{ route('micro_contents.show', ['id' => $microContent->id]) }}"
                                               class="mB-10">
                                <img class="mB-10" src="{{ asset('images/assets/ASSET-01.png') }}" height="42px"/>
                            </a>
                    </div>


                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 card-div-right">
                             <div class="row text-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-10">
                                    <img class="user-thumbail" src="{{ auth()->user()->avatarUrl }}" alt="">
                                    <h4 class="user-label">asd</h4>
                                    <h4 class="rol-label">Admin</h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-15">
                                     <img style="margin-top: 5px" src="{{ asset('images/assets/ASSET-25.png') }}" height="42px"/><br>
                                    <h4 class="question-cont-label">{{ $microContent->questions->count() }}</h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-15 mB-10">
                                        <a href="{{ route('micro_contents.show', ['id' => $microContent->id]) }}"
                                               class="card-buttom-edit mB-10 pl-4 pr-4">Editar</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="
                        @if($microContent->type == 0)
                            bgc-orange-400
                        @else
                            bgc-green-500
                        @endif
                            pT-20"></div>-->



                </div>
            </div>
        @endforeach
    </div>

    {{ $microContents->links() }}
@endsection

@section('js')

@endsection
