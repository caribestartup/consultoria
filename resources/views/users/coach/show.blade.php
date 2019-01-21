@extends('default')
@section('title')
    {{ trans_choice('common.micro_content', 2) }}
@endsection
@section('css')
    <style>
        #graphics {
            margin: 20px;
            width: 200px;
            height: 200px;
            position: relative;
        }

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
            'title' => 'Aprovado micro contenido',
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
                                <h4 class="contenido-title-microcontent-font">Informacion:</h4><br/>
                                <!-- <p class="contenido-body-microcontent-font">
                                    Puntos todales: {{$total}}
                                </p> -->
                                <ul>
                                    <li>Puntos totales: {{$total}}</li>
                                    <li>Aprovado: {{$microContent->approve}}</li>
                                    <li>Resultado: {{$result}}</li>
                                </ul>
                            </div>

                            <div id="graphics"></div>
                            {{-- <div class="container">
                                <div class="row">
                                    <div class="row text-center">
                                        <div class="col-md-3 col-sm-6">
                                            <div class="progress blue">
                                                <span class="progress-left">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar"></span>
                                                </span>
                                                <div class="progress-value">{{ ($result/$total)*100 }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                            <div class="row text-center">

                                {!! Form::open([
                                        'class'=>'deletenotificacionform',
                                        'url'  => route('notifications.update', $notificarion_id),
                                        'method' => 'PUT',
                                        'id' => 'delete_form',
                                        ])
                                    !!}
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mT-15 mB-10">

                                    <button type="submit" id="sendbtn" class="card-buttom-approve mB-10 pl-4 pr-4" title="Aprovar al estudiante">Aprovar</button>
                                </div>

                                {!! Form::close() !!}

                                {!! Form::open([
                                        'class'=>'deletenotificacionform',
                                        'url'  => route('notifications.destroy', $notificarion_id),
                                        'method' => 'DELETE',
                                        'id' => 'delete_form',
                                        ])
                                    !!}
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mT-15 mB-10">
                                    <button type="submit" id="sendbtn" class="card-buttom-delete mB-10 pl-4 pr-4" title="{{ trans('common.delete') }}"><i class="ti-trash"></i></button>
                                </div>

                                {!! Form::close() !!}
                            </div>

                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 card-div-right">
                            <div class="row text-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-10">
                                    <img class="user-thumbail" src="{{ $user->avatarUrl }}" alt="">
                                    <h4 class="user-label">{{$user->fullName()}}</h4>
                                    <h4 class="rol-label">{{$user->email}}</h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-15">
                                        <img style="margin-top: 5px" src="{{ asset('images/assets/ASSET-25.png') }}" height="42px"/><br>
                                    <h4 class="question-cont-label">{{ $microContent->questions->count() }}</h4>
                                    <p class="contenido-title-microcontent-font">
                                        Cantidad
                                    </p>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mT-15 mB-10">
                                        <a href="{{ route('micro_contents.show', ['id' => $microContent->id]) }}"
                                                class="card-buttom-edit mB-10 pl-4 pr-4">Editar</a>

                                </div> --}}
                            </div>
                        </div>
                        {{-- <div class="
                            @if($microContent->type == 0)
                                bgc-orange-400
                            @else
                                bgc-green-500
                            @endif
                                pT-20">

                        </div> --}}



                </div>
            </div>
        @endforeach
    </div>

    {{ $microContents->links() }}
@endsection

@section('js')
<script>

    var bar = new ProgressBar.Circle(graphics, {
        color: '#aaa',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 4,
        trailWidth: 1,
        easing: 'easeInOut',
        duration: 1400,
        text: {
            autoStyleContainer: false
        },
        from: { color: '#F15A21', width: 4 },
        to: { color: '#007B5E', width: 4 },
        // Set default step function for all animate calls
        step: function(state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);

            var value = Math.round({{ $result/$total}} * 100);
            if (value === 0) {
            circle.setText('');
            } else {
            circle.setText(value+"%");
            }

        }
    });

    @if($result >= $microContent->approve)
        bar._opts.from.color = '#007B5E';
        bar._opts.to.color = '#007B5E';
    @else
        bar._opts.from.color = '#F15A21';
        bar._opts.to.color = '#F15A21';
    @endif

    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '2rem';

    bar.animate({{$result/$total}});  // Number from 0.0 to 1.0
</script>

@endsection
