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
                        <label>Correos</label>
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
        // $('.btn').on('click', function () {
        //     var currentForm = $('#send_form')[0];
        //     currentForm.submit();
        // });
        function submitFrom (e) {
            $.post(
                "{{ action('TrainingController@create') }}",
                {
                    _token: $('input[name="_token"]').val(),
                    emails: document.getElementById('emails').value,
                    id: document.getElementById('id').value
                },
                function (result) {
                    console.log(result);
                }
            );

            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': token
            //     },
            //     url: urls,
            //     type: 'POST',
            //     data: {
            //         emails: email,
            //         id: ids
            //     }
            // });

            // // var data = [];
            // // data.array_push('emails', emails);
            // // data.array_push('id', id);
            // $.post(url,
            //     headers: {
            //         'X-CSRF-TOKEN': token
            //     },
            //     data: {
            //         emails: email,
            //         id: ids
            //     },
            //     function(data, status){
            //         alert("Data: " + data + "\nStatus: " + status);
            // });
            //     // fetch(url, {
            //     //     method: 'post',
            //     //     body: data
            //     // })
        };
    </script>
@endsection