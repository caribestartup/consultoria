@extends('default')
@section('css')
    <link href="{{ asset('/css/rSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ trans_choice('common.interest', 2) }}
@endsection


@section('content')
 <div class="row title-page-buttom">
        <div class="col-xs-12 col-sm-6">
          @include('components.index_create', [
            'title' => trans_choice('common.interest', 2),
            'url'   => route('interests.create'),
            'create'=> __('interest.create_interest')
            ])   
        </div>
    </div>

    <div class="row  ">
        <!--Cards-->
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8 col-xl-8 text-white" >

                 
            <!--<div class="col-sm-12 col-md-12 col-lg-4 form-group  pT-70 pR-30 pL-40">
                
                {!! Form::open(['method'=>'GET','url'=>'users','role'=>'search'])  !!}
                <!--Search_by--
                <div class="row d-flex justify-content-end pR-20">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 mb-1  ">
                        <div class="input-group justify-content-end  " >
                            {{ Form::input("text", "search", request()->session()->get('search'), array_merge(["placeholder" => trans('interest.search_interest'), "class" => "form-control"])) }}

                            <div class="input-group-append">
                                <button class="btn btn-app-primary btn-default-sm" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--Filter_by--S
                    <p class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-end pr-0 ">

                        <button class=" dropdown-toggle dropdown mb-2 border-0 bg-white" type="button"  data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="width: 150px">
                            <label class="pull-left">Filtro</label>
                            <i class="fa fa-angle-down d-flex pull-right pt-2 "></i>
                        </button>
                    </p>

                    <div class="collapsing col-md-12 float-right"  id="collapseExample" >
                        <label class="mt-3 d-flex justify-content-center">Importancia</label>
                        <input name="importancia" type="text" id="slider" >
                        <label class="d-flex justify-content-center mB-5">Conocimiento</label>
                        <input name="conocimiento" type="text" id="conocimiento" >
                    </div>
                </div>
                {!! Form::close() !!} 
            </div> -->
        </div>
        <div class="col-md-12">
                <!-- Titulo Cards -->
                
                {{-- <div class="row">
                    <div class="col-md-2 ">
                        <label class="mb-1" style="color: #003C4F">4 de marzo</label>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-2">
                        <hr style="border-top: 3px solid;border-color:#003C4F;width: 100px " >
                    </div>

                </div>--}}
                <!--cards-->
                <div class="row">
                    @foreach ($interests as $interest)
                        <div class="col-md-4 col-sm-4 col-xs-12 "   >
                            <div class="image-flip"  ontouchstart="this.classList.toggle('hover'); ">
                                <div class="mainflip" >
                                    <div class="frontside" style="border-radius: 30px" >
                                        <div class="card" style="border-radius: 30px" >
                                            <div class="card-body card-action-plan text-center py-0">
                                                <div class="row justify-content-end al p-10">
                                                    <a style="margin-right: 2px">9:21</a>
                                                    <span class="fa fa-clock-o"></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="star-rating">

                                                            @for( $i=1;$i<=$interest->importance_level;$i++)
                                                                <span class="fa fa-star-o" data-rating="{{$i}}"></span>
                                                                <input type="hidden" name="whatever1" class="rating-value" value="5">
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="card-text">{{$interest->title}}</p>
                                                <!-- <p><img class=" img-fluid" src="images/20171015_171252.jpg" alt="card image"></p>-->
                                                <p class="fa fa-users" style="font-size: 50px"></p>
                                                <?php
                                                $cantInterests= DB::table('user_interest')->where('interest_id' ,'=' ,$interest->id)->count();
                                                ?>
                                                <h4 class="card-title">{{$cantInterests}}</h4>
                                                <a>{{$interest->expiration_date}}</a>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="backside"  style="border-radius: 30px; width: 100% ;height: 100%">
                                        <div class="card" style="border-radius: 30px" >
                                            <div class="card-body  text-center mt-4">
                                                <h4 class="card-title">Objetivos  </h4>
                                                <p>{{$interest->objectives}}</p>
                                                <p class="card-text">{{$interest->expiration_date}}</p>
                                                <a href="{{ route('interests.show',$interest->id) }}"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('interests.edit',$interest->id) }}"><i class="fa fa-edit"></i></a>

                                            </div>
                                            <div class="row text-center">
                                                <div class="col-md-12 col-xs-12 col-sm-12 ">
                                                    <form action="{{route('interests.destroy',$interest->id)}}" method="post">
                                                        <button class="btn btn-light btn-sm fsz-md text-danger" type="submit"> <a type="submit" href="{{ route('interests.edit',$interest->id) }}"><i class="fa fa-trash"></i></a></button>
                                                        @csrf
                                                        @method('DELETE')

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>

        <!--Right_side-->
        {{--<div class="col-md-4 mT-70 pr-0">


            <div class="row">
                <div class="col-md-12">
                    <h3 style="color: #003C4F;font-weight: bold">{{ __('interest.weekly_summary') }}</h3>
                </div>
            </div>
            <!--Summary-->
            <div class="row px-3">
                <div class="col-md-6 bg-white border-0 pr-0 pl-4">
                    <div class="row mt-4">
                        <div class="col-md-6"><label>{{ __('interest.weekly_summary_finished') }}</label></div>
                        <div class="col-md-6"><span class="badge" style="background-color:#b8b8b8 ;width: 2.5em;font-size: 100%;border-radius: 1em">5</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><label>{{ __('interest.weekly_summary_delay') }}</label></div>
                        <div class="col-md-6"><span class="badge" style="background-color:#fec551 ;width: 2.5em;font-size: 100%;border-radius: 1em">3</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><label>{{ __('interest.weekly_summary_active') }}</label></div>
                        <div class="col-md-6"><span class="badge " style="background-color:#c9646c ;width: 2.5em;font-size: 100%;border-radius: 1em">8</span></div>
                    </div>
                </div>
                <div class="col-md-6 bg-white border-0 pl-0"><canvas id="myChart" width="940" height="670" class="chartjs-render-monitor mb-2" style="display: block; width: 540px; height: 270px;">12</canvas></div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3 style="color: #003C4F;font-weight: bold">{{ __('interest.other_suggestion') }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group border-0 ">
                        <li class="list-group-item">Incremento de las ganancias</li>
                        <li class="list-group-item">Distribución de las tarjetas identitarias</li>
                        <li class="list-group-item">Incremento de las ganancias</li>
                        <li class="list-group-item">Distribución de las tarjetas identitarias</li>
                        <li class="list-group-item">Incremento de las ganancias</li>
                    </ul>
                </div>
            </div>
        </div>--}}
    </div>
    <div class="row d-flex justify-content-between mb-3 ">
        <div class="col-md-12 pr-3 ">

        </div>
    </div>

    <!--<canvas id="myChart"></canvas>-->
@endsection

@section('js')
    <script src="{{ asset('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('/js/rSlider.js') }}"></script>
    <script>

        $(document).ready(function () {
            $('.datepicker').datepicker({
                dateFormat: 'dd-mm-yy',
                startDate: '-3d'
            });

            var mySlider = new rSlider({
                target: '#slider',
                values: [1, 2, 3, 4, 5],
                set:    null, // an array of preselected values
                range: true, // range slider                
                width:    null,
                scale:    false,
                labels:   true,
                tooltip:  false,
                step:     true, // step size
                disabled: false, // is disabled?
                onChange: null // callback
            });

            var mySlider2 = new rSlider({

                target: '#conocimiento',

                values: ['Bajo','Medio', 'Alto'],
                range: true, // range slider
                set:    null, // an array of preselected values
                width:    null,
                scale:    false,
                labels:   false,
                tooltip:  true,
                step:     true, // step size
                disabled: false, // is disabled?
                onChange: null // callback
            });

            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',

                data: {


                    datasets: [{
                        backgroundColor: [
                            "#b8b8b8",
                            "#fec551",
                            "#c9646c",

                        ],
                        data: [5, 3, 8]
                    }]
                },
                options: {
                    cutoutPercentage: 100,


                }
            });


        });
    </script>
@endsection
