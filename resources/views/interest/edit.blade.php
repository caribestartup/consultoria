@extends('default')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
    <style>
        
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .margin-carrousel{
            margin-right: 30px;
            margin-left: 30px;
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
@endsection

@section('content')

@include('components.index_top', ['indexes' => [
            trans_choice('common.interest', 2),	__('common.edit')
            ]])

<form method="post" action="{{action('InterestController@update',$id)}}">
    <div class="container">


            @csrf
            <input name="_method" type="hidden" value="PATCH">
            <div class="row">
                <!--LEFT CONTENT-->
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2 bg-white border-form">
                    <h4 class="ml-2 mt-2">
                        General
                    </h4>
                    <div class="mb-0 ml-5"> <!--id="collapseExample"-->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="nameTheme">{{ __('interest.interest_name') }}</label>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" name="title" class="form-control graywithout" id="nameTheme" value="{{$interests->title}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{ __('interest.objective') }}</label>
                                </div>
                                <div class="col-md-11" id='TextBoxesGroup1'>
                                    <!--<input type='text' name="objectives" class="form-control graywithout" id='textbox' value="{{$interests->objectives}}" >-->
                                    <textarea class="form-control graywithout" rows="5" name="objectives" id="comment">{{$interests->objectives}}</textarea>
                                </div>
                                <!--<div class="col-md-1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a  id="addButton"   value='Add Button' class="btn  add"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="col-md-6">
                                            <a  id="removeButton" class="btn  add"><i class="fa fa-minus"></i></a>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Valora tus conocimientos sobre el tema</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <!--<div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="incialRadio" value="option1" checked>
                                            Inicial
                                        </label>
                                    </div>-->
                                    <input name="knowledge_valuation" type="radio" class="custom-radio"
                                           @isset($interests)
                                           @if($interests->knowledge_valuation == 0)
                                           checked
                                           @endif
                                           @endisset

                                           @empty($interests)
                                           checked
                                           @endempty
                                           value="0">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">{{ __('common.initial') }}</span>

                                </div>
                                <div class="col-md-3">
                                    <input name="knowledge_valuation" type="radio" class=""
                                           @isset($interests)
                                           @if($interests->knowledge_valuation == 1)
                                           checked
                                           @endif
                                           @endisset
                                           value="1">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">{{ __('common.middle') }}</span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <input name="knowledge_valuation" type="radio" class=""
                                           @isset($interests)
                                           @if($interests->knowledge_valuation == 2)
                                           checked
                                           @endif
                                           @endisset
                                           value="2">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">{{ __('common.advanced') }}</span>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row form-inline">
                                <div class="col-md-3">
                                    <label class="float-left">
                                        Nivel de importancia
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <div class="star-rating float-left">
                                        <span class="fa fa-star-o" data-rating="1" style="cursor: pointer"></span>
                                        <span class="fa fa-star-o" data-rating="2" style="cursor: pointer"></span>
                                        <span class="fa fa-star-o" data-rating="3" style="cursor: pointer"></span>
                                        <span class="fa fa-star-o" data-rating="4" style="cursor: pointer"></span>
                                        <span class="fa fa-star-o" data-rating="5" style="cursor: pointer"></span></a>
                                        <input type="hidden" name="importance_level" id="importance-level" class="rating-value" value="{{$interests->importance_level}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex flex-row  form-inline">
                                <div class="col-md-3 ">
                                    <label class="float-left">
                                        Permitir Colaboración
                                    </label>
                                </div>
                                <div class="col-md-2 d-flex justify-content-center">
                                    <div class="col-md-1"><span>No</span></div>
                                    <div class="col-md-10">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <div class="col-md-1"><span>Yes</span></div>
                                </div>
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
                            <?php
                            $index=0;
                            $cantVer=5;
                            $cantTopic = $topics->count();
                            $cantSlide=$cantTopic/$cantVer;
                            ?>

                            <div class="row>">
                                <div class="col-md-12">
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner margin-carrousel">

                                            @for($i=0;$i<$cantSlide;$i++)
                                                <div class="carousel-item
                                                        @if($i==0)
                                                        active
                                                        @endif
                                                        ">
                                                    <div class="row">
                                                        @for($j=0;$j<$cantVer;$j++)
                                                            @if($index<$cantTopic)
                                                                <div class="col-md-2 col-sm-2 col-xs-2 mx-2" style="height: 100px; width:100px; background-image: url('{{asset('images/Temas-0-01.png')}}');background-repeat: no-repeat ;background-size: 100% 100%">
                                                                    <div class="row d-flex justify-content-end">
                                                                        <input type="checkbox" class="checkbox" value="{{$topics[$index]->id}}" name="topic[]"
                                                                            @if($interests->hasTopic($topics[$index]->id))
                                                                                checked
                                                                            @endif
                                                                        >
                                                                    </div>
                                                                    <div class="row d-flex justify-content-center mt-5" style="background-color: #336372">
                                                                        <label class="mt-1" style="color: white">{{$topics[$index]->concat()}}</label>
                                                                    </div>
                                                                </div>

                                                            @endif
                                                            <?php $index = $index + 1?>
                                                        @endfor
                                                    </div>
                                                </div>
                                            @endfor

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
                        <hr class="pr-2">

                    </div>
                </div>
            </div>
        </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2 bg-white border-form px-3">
                <h4 class="ml-2 mt-2">
                    Seguimiento
                </h4>

                <div class="px-5"><div class="form-group">
                        <div class="row">

                                <div class="col-md-3 ">
                                    <label>{{ __('interest.expiration_date') }}</label>
                                </div>

                        <!--    <div class="col-md-9">
                                <div class="input-group date" data-date-format='yy-mm-dd'  data-provide="datepicker">
                                    <input type="text"  name="expiration_date" class="form-control graywithout" placeholder="Fecha Fin" value="{{$interests->expiration_date}}">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div> -->

                            <div class="input-group date col-md-9">
                                    <input type="text" autocomplete="off"  name="expiration_date" class="form-control graywithout datepicker" placeholder="Fecha Fin" value="{{$interests->expiration_date}}">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"  name="reminders" id="reminders"
                                               @isset($interest)
                                               @if($interest->reminders)
                                               checked
                                               @endif
                                               @endisset
                                               value="1">
                                        Habilitar recordatorio
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="exampleRadios" id="" value="option1" checked>
                                        Conteo de horas empleadas
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">

                            <ul class="pl-0" style="list-style: none" >
                                <li><label>Periodo</label>
                                </li>
                                <li>
                                    <div class="form-check " >
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="reminders_period" id="diarioRadio"
                                                   @isset($interests)
                                                   @if($interests->reminders_period == 1)
                                                   checked
                                                   @endif
                                                   @endisset

                                                   @empty($interests)
                                                   checked
                                                   @endempty

                                                   value="1"
                                                    onclick="show1off();"  >


                                            Diario
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="reminders_period" id="semanalRadio"

                                                   @isset($interests)
                                                   @if($interests->reminders_period == 2)
                                                   checked
                                                   @endif
                                                   @endisset

                                                   @empty($interests)
                                                   checked
                                                   @endempty

                                                   value="2" onclick="show1off();" >
                                            Semanal
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="reminders_period" id="mensualRadio"
                                                   @isset($interests)
                                                   @if($interests->reminders_period == 3)
                                                   checked
                                                   @endif
                                                   @endisset

                                                   @empty($interests)
                                                   checked
                                                   @endempty

                                                   value="3"
                                                   onclick="show1off();" >
                                            Mensual
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="reminders_period" id="anualRadio"
                                                   @isset($interests)
                                                   @if($interests->reminders_period == 4)
                                                   checked
                                                   @endif
                                                   @endisset

                                                   @empty($interests)
                                                   checked
                                                   @endempty

                                                   value="4"
                                                   onclick="show1off();" >
                                            Anual
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-9 ">

                            <div class="input-group px-3 clockpicker col-md-3" id="clock" data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="text" autocomplete="off" name="reminders_value_hour" class="form-control graywithout" value="">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>

                            <div class="col-md-3">
                                <div class="input-group fg-float">
                                    <div class="fg-line">
                                        <input id='day' autocomplete="off" type='text' name="reminders_value_day" value="" class="form-control material fg-input">
                                    </div>
                                </div>
						    </div>

                            <div class="col-md-3">
                                <div class="input-group fg-float">
                                    <div class="fg-line">
                                        <input id='month' type='text' autocomplete="off" name="reminders_value_month" value="" class="form-control material fg-input">
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="col-md-3">
                                <div class="input-group fg-float">
                                    <div class="fg-line">
                                        <input id='year' type='text' autocomplete="off" name="reminders_value_year" value="" class="form-control material fg-input">
                                    </div>
                                </div>
						    </div> 
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
<div class="container">
    <div class="row ">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2  d-flex justify-content-end pr-0 mt-2">
            <button type="submit" class="btn btn-app-primary mr-3">Guardar</button>
            {{-- <button type="submit" class="btn btn-primary border-bot" style="background-color: #003C4F">Finalizar</button> --}}
        </div>

    </div>
</div>


</form>
@section('js')
    <script src="{{ asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    {{-- <script src="{{ asset('/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script> --}}
    <script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
        $('.clockpicker').clockpicker();
    </script>
    <script>

        $(document).ready(function(){

            var counter = 2;

            $("#addButton").click(function () {

                if(counter>10){
                    alert("Only 10 textboxes allow");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('div'))
                    .attr("id", 'TextBoxDiv' + counter);

                /*newTextBoxDiv.after().html('<label>Objetivo '+ counter + ' : </label>' +
                 '<input type="text" class="form-control" name="textbox' + counter +
                 '" id="textbox' + counter + '" value="" >');*/

                newTextBoxDiv.after().html('<select name="filter_type" id="filter_type" class="form-control"><option value="">Jessica Nacianceno</option><option value="date">Reinaldo Ponce</option> <option value="popularity">Camilo Del Real</option> <option value="like_count">Yaniel Gómez</option> <option value="comment_count">Paco Gonzalez</option></select>');


                newTextBoxDiv.appendTo("#TextBoxesGroup");


                counter++;
            });

            $("#removeButton").click(function () {
                if(counter==1){
                    alert("No more textbox to remove");
                    return false;
                }

                counter--;

                $("#TextBoxDiv" + counter).remove();

            });

            $("#getButtonValue").click(function () {

                var msg = '';
                for(i=1; i<counter; i++){
                    msg += "\n Textbox #" + i + " : " + $('#Objetivo' + i).val();
                }
                alert(msg);
            });

            $("#clock").hide();
            $("#day").hide();
            $("#month").hide();
            $("#year").hide();

            $('.clockpicker').clockpicker();

            $('.datepicker').datepicker({
                language: 'es',
                startDate: 'now',
                setDate: new Date(),
                format: 'yyyy-mm-dd'
            });

            $('#day').datetimepicker({
                format: 'DD'
            });

            $('#month').datetimepicker({
                format: 'MM'
            });

            $('#year').datetimepicker({
                format: 'YYYY'
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

        



    </script>

<script>
    function show1off(){
        if ($("#diarioRadio").is(":checked")) {
                $("#clock").show();
            } else {
                $("#clock").hide();
            }
            if ($("#semanalRadio").is(":checked")) {
                $("#day").show();
            } else {
                $("#day").hide();
            }
            if ($("#mensualRadio").is(":checked")) {
                $("#month").show();
            } else {
                $("#month").hide();
            }
            if ($("#anualRadio").is(":checked")) {
                $("#year").show();
            } else {
                $("#year").hide();
            }
    }

</script>
@stop
@endsection