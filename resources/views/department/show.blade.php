@extends('default')

@section('content')


    <!--Breadcrum-->
    <div class="row ">
        <nav aria-label="breadcrumb"  role="navigation">
            <ol class="breadcrumb" style="background-color: #E6E6E6">
                <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Department</a></li>
                <li class="breadcrumb-item"><a href="#">Create</a></li>
            </ol>
        </nav>
    </div>
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
                        <input type="text" class="border-0 graywithout" name="value" value="{{$department->value}}" placeholder="Introduzca el nombre del departmento" style="width: 100%" disabled>
                    </div>

                </div>
            </div>

        </div>


    </form>





@endsection