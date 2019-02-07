@extends('default')

@section('content')

    @include('components.index_top', ['indexes' => [
                  trans_choice('common.topic', 2),	$topic->value
                  ]])


    <div class="row ">
        <div class="col-md-6 bg-white">
            <div class="row">

                <div class="col-md-4 pr-0 pt-2">
                    <label>Nombre del Tema</label>
                </div>
                <div class="col-md-8 pl-0  bg-white pt-2">
                    <input type="text" class="border-0 graywithout " disabled name="value" value="{{$topic->value}}" placeholder="Introduzca el nombre del tema" style="width: 100%">
                </div>

            </div>
        </div>

    </div>
@endsection

