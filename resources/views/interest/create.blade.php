
@extends('default')

@section('title')
    @if(isset($actionPConfig))
        {{ __('interest.edit_interest') }}
    @else
        {{ __('interest.create_interest') }}
    @endif
@endsection

@section('css')
    <style>
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #F15A21;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #F15A21;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <link href="{{ asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')


 @if(isset($actionPConfig))
        @include('components.index_top', ['indexes' => [
        trans_choice('common.interest', 2),  __('common.edit')
        ]])
    @else
        @include('components.index_top', ['indexes' => [
        trans_choice('common.interest', 2),  __('common.new')
        ]])
    @endif

    <h2>
        @if(isset($actionPConfig))
            {{ __('interest.edit_interest') . ': ' . $actionPConfig->interest->title }}
        @else
            {{ __('interest.create_interest') }}
        @endif
    </h2>

    {!! Form::open([
                'action' => ['InterestController@store'],
                'method' => 'post'
                ])
        !!}

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2 ">
            <div class="bgc-white p-20 border-form">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nameTheme">{{ __('interest.interest_name') }}</label>
                        </div>
                        <div class="col-md-11">
                            <input type="text" name="title" class="form-control graywithout" id="nameTheme">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>{{ __('interest.objective') }}</label>
                        </div>
                        <div class="col-md-11" id='TextBoxesGroup1'>
                            <input type='text' name="objectives" class="form-control graywithout" id='textbox' >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ __('interest.rate_knowledge_about_topic') }}</label>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="custom-control custom-radio">
                                <input name="knowledge_valuation" type="radio" class="custom-control-input"
                                       id="ke_1"
                                       @isset($interest)
                                       @if($interest->knowledge_valuation == 0)
                                       checked
                                       @endif
                                       @endisset

                                       @empty($interest)
                                       checked
                                       @endempty
                                       value="0"/>
                                <label class="custom-control-label" for="ke_1">{{ __('common.initial') }}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="custom-control custom-radio">
                                <input name="knowledge_valuation" type="radio" class="custom-control-input"
                                       id="ke_2"
                                       @isset($interest)
                                       @if($interest->knowledge_valuation == 1)
                                       checked
                                       @endif
                                       @endisset
                                       value="1"/>
                                <label class="custom-control-label" for="ke_2">{{ __('common.middle') }}</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="custom-control custom-radio">
                                <input name="knowledge_valuation" type="radio" class="custom-control-input"
                                       id="ke_3"
                                       @isset($interest)
                                       @if($interest->knowledge_valuation == 2)
                                       checked
                                       @endif
                                       @endisset
                                       value="2">
                                <label class="custom-control-label" for="ke_3">{{ __('common.advanced') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <label>{{ __('interest.importance_level') }}</label>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <div class="star-rating">
                            <span class="fa fa-star-o" data-rating="1" style="cursor: pointer"></span>
                            <span class="fa fa-star-o" data-rating="2" style="cursor: pointer"></span>
                            <span class="fa fa-star-o" data-rating="3" style="cursor: pointer"></span>
                            <span class="fa fa-star-o" data-rating="4" style="cursor: pointer"></span>
                            <span class="fa fa-star-o" data-rating="5" style="cursor: pointer"></span>
                            <input type="hidden" name="importance_level" id="importance-level" class="rating-value"
                                   @isset($interest)
                                   value="{{ $interest->importance_level }}"
                                    @endif
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <label>{{ __('interest.allow_collaboration') }}</label>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9 align-items-center">
                        <span>No</span>
                        <div class="d-inline">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <span>Yes</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="float-left">
                                Dirias que este tema es util para
                            </label>
                        </div>
                    </div>
                    @php
                        $index=0;
                        $cantVer=5;
                        $cantTopic= $topics->count();
                        $cantSlide=$cantTopic/$cantVer;
                    @endphp

                    <div class="row>">
                        <div class="col-md-12">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        @for($i=0;$i<$cantSlide;$i++)

                                            <div class="carousel-item
                                                        @if($i==0)
                                                    active
                                                         @endif">



                                                <div class="row">

                                                    @for($j=0;$j<$cantVer;$j++)

                                                        @if($index<$cantTopic)
                                                            <div class="col-md-2 col-sm-6 col-xs-12 mx-2  "  style="height: 100px; width:100px; background-image: url('{{asset('images/Temas-0-01.png')}}');background-repeat: no-repeat ;background-size: 100% 100%">


                                                                <div class="row d-flex justify-content-end">
                                                                    <input type="checkbox" class="checkbox" value="{{$topics[$index]->id}}" name="topic[]">
                                                                </div>
                                                                <div class="row d-flex justify-content-center mt-5" style="background-color: #336372">
                                                                    <label class="mt-1" style="color: white">{{$topics[$index]->value}}</label>
                                                                </div>


                                                            </div>

                                                        @endif
                                                        <?php $index = $index + 1?>

                                                    @endfor

                                                </div>
                                            </div>

                                        @endfor
                                    </div>

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2>{{ __('common.tracing') }}</h2>
            <div class="bgc-white p-20 border-form">
                <div class="px-5">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{ __('interest.expiration_date') }}</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group date" data-date-format='yy-mm-dd'  data-provide="datepicker">
                                    <input type="text"  name="expiration_date" class="form-control graywithout" placeholder="Fecha Fin" value="">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox"  name="reminders" id="reminders"
                                           @isset($interest)
                                           @if($interest->reminders)
                                           checked
                                           @endif
                                           @endisset
                                           value="1">
                                    <label class="custom-control-label" for="reminders">Habilitar recordatorio</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="exampleRadios" id="counting"
                                           value="option1" checked/>
                                    <label class="custom-control-label" for="counting">Conteo de horas empleadas</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <ul class="pl-0" style="list-style: none" >
                                <li>
                                    <label>{{ __('common.period') }}</label>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio" >
                                        <input class="custom-control-input" type="radio" name="reminders_period" id="diarioRadio" @if( (isset($interest) and $interest->reminders_period == 1)
                                                           or !isset($interest))
                                        checked
                                               @endif
                                               value="1" onclick="show1off();" >
                                        <label class="custom-control-label" for="diarioRadio">{{ __('common.daily') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio" >
                                        <input class="custom-control-input" type="radio" name="reminders_period" id="semanalRadio" @if( (isset($interest) and $interest->reminders_period == 2)
                                                           or !isset($interest))
                                        checked
                                               @endif
                                               value="2" onclick="show1off();" >
                                        <label class="custom-control-label" for="semanalRadio">{{ __('common.weekly') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="reminders_period" id="mensualRadio" @if( (isset($interest) and $interest->reminders_period == 3)
                                                           or !isset($interest))
                                        checked
                                               @endif
                                               value="3" onclick="show1off();" >
                                        <label class="custom-control-label" for="mensualRadio">{{ __('common.monthly') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="reminders_period" id="anualRadio" @if( (isset($interest) and $interest->reminders_period == 4)
                                                           or !isset($interest))
                                        checked
                                               @endif
                                               value="4" onclick="show1off();" >
                                        <label class="custom-control-label" for="anualRadio">Anual
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-9 ">
                            <div class="input-group clockpicker  px-3 " id="clock" data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="text" class="form-control graywithout" value="13:14">
                                <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                            </div>

                            <select name="filter_type" id="filter_type1"  class="custom-select  mx-3" style="display: none">
                                <option value="">Lunes</option>
                                <option value="date">Martes</option>
                                <option value="popularity">Miercoles</option>
                                <option value="like_count">Jueves</option>
                                <option value="comment_count">Viernes</option>
                                <option value="like_count">Sabado</option>
                                <option value="comment_count">Domingo</option>
                            </select>

                            <select name="filter_type" id="filter_type2" class="custom-select  mx-3" style="display: none">
                                <option value="">1</option>
                                <option value="date">2</option>
                                <option value="popularity">3</option>
                                <option value="like_count">4</option>
                            </select>

                            <select name="filter_type" id="filter_type3" class="custom-select  mx-3" style="display: none">
                                <option value="">Enero</option>
                                <option value="date">Febrero</option>
                                <option value="popularity">Marzo</option>
                                <option value="like_count">Abril</option>
                                <option value="">Mayo</option>
                                <option value="date">Junio</option>
                                <option value="popularity">Julio</option>
                                <option value="like_count">Agosto</option>
                                <option value="">Septiembre</option>
                                <option value="date">Octubre</option>
                                <option value="popularity">Noviembre</option>
                                <option value="like_count">Diciembre</option>
                            </select>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-8 d-flex justify-content-end pr-0 mt-2">
            <button type="submit" class="btn btn-primary" style="background-color: #003C4F">Finalizar</button>
        </div>

    </div>
    {!! Form::close() !!}


@endsection
@section('js')
    <script src="{{ asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.clockpicker').clockpicker();

            $('.datepicker').datepicker({
                format: 'mm/dd/yyyy',
                startDate: '-3d'
            });

            var $star_rating = $('.star-rating .fa');

            var SetRatingStar = function() {
                return $star_rating.each(function() {
                    if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                        return $(this).removeClass('fa-star-o').addClass('fa-star');
                    } else {
                        return $(this).removeClass('fa-star').addClass('fa-star-o');
                    }
                });
            };

            $star_rating.on('click', function() {
                $star_rating.siblings('input.rating-value').val($(this).data('rating'));
                return SetRatingStar();
            });

            SetRatingStar();
        });

        function show1off(){
            $("input[name='reminders_period']").click(function () {
                if ($("#diarioRadio").is(":checked")) {
                    $("#clock").show();
                } else {
                    $("#clock").hide();
                }
                if ($("#semanalRadio").is(":checked")) {
                    $("#filter_type1").show();
                } else {
                    $("#filter_type1").hide();
                }
                if ($("#mensualRadio").is(":checked")) {
                    $("#filter_type2").show();
                } else {
                    $("#filter_type2").hide();
                }
                if ($("#anualRadio").is(":checked")) {
                    $("#filter_type3").show();
                } else {
                    $("#filter_type3").hide();
                }

            });
        }

    </script>
@endsection
