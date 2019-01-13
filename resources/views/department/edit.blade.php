@extends('default')

@section('content')


    @include('components.index_top', ['indexes' => [
            trans_choice('common.department', 2),	__('common.edit')
            ]])

    <form method="post" action="{{action('DepartmentController@update',$id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">

        <div class="row ">
            <div class="col-md-6 bg-white">
                <div class="row">

                    <div class="col-md-4 pr-0 pt-2">
                        <label>Nombre del Departmento</label>
                    </div>
                    <div class="col-md-8 pl-0  bg-white pt-2">
                        <input type="text" class="border-0 graywithout" name="value" value="{{$department->value}}" placeholder="Introduzca el nombre del departmento" style="width: 100%">
                    </div>

                </div>
            </div>

        </div>
        <div class="row ">
            <div class="col-md-6 pr-0  d-flex justify-content-end bg-white pb-2 pr-2 pt-2 ">
                <button type="submit" class="btn btn-primary" style="background-color: #003C4F">Finalizar</button>
            </div>
        </div>

    </form>





@endsection