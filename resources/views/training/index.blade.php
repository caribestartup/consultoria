@extends('default')
@section('title')
    {{ trans_choice('common.action_plan', 1) . ': '. $actionPConfig->actionPlan->title }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-star-rating/css/star-rating.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}">

@endsection

@section('content')
    @include('components.index_top', ['indexes' => [
        "Entrenamiento",	$actionPConfig->actionPlan->title
        ]])

    {!! Form::open([
    'url'        => action('TrainingController@create'),
    'id'         => 'send_form',
    'method'     => 'POST']) !!}

        <div class="row ">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
                <fieldset class="mT-10 bgc-white p-20 border-form">
                    <div class="form-group">
                        <label>Correos de los Evaluadores</label>
                        <input id="emails" class="form-control" type="text" value="" data-role="tagsinput" />
                        <input id="id" value="{{ $actionPConfig->id }}" type="hidden"/>
                        @csrf
                    </div>
                </fieldset>
                <div class="text-right mT-10">
                    {{ Form::button(__('common.finalize'),["class" => "btn btn-app-primary", "id" => "submit", 'onClick' => "submitFrom()"]) }}
                </div>
            </div>

        </div>



    {!! Form::close() !!}


@endsection

@section('js')
    <script src="{{ asset('plugins/bootstrap-star-rating/js/star-rating.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
    <script>
        function submitFrom (e) {
            var emails = document.getElementById('emails').value;
            emails = emails.split(',');
            var regular = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var incorrect = false;
            emails.forEach(email => {
                if (!regular.test(email)) {
                    incorrect = true;
                    alert('Formato de correo incorrecto, por favor revice los correos');
                }
            });
            if(incorrect === false) {
                $.post(
                    "{{ action('TrainingController@create') }}",
                    {
                        _token: $('input[name="_token"]').val(),
                        emails: document.getElementById('emails').value,
                        id: document.getElementById('id').value
                    },
                    function (result) {
                        // console.log(result);
                        location.href="{{ action('ActionPlanController@index') }}"
                    }
                );
            }

        };
    </script>
@endsection
