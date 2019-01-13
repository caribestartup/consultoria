@extends('default')

@section('content')


    <!--Breadcrum-->
    <div class="row ">
        <nav aria-label="breadcrumb"  role="navigation">
            <ol class="breadcrumb" style="background-color: #E6E6E6">
                <li class="breadcrumb-item"><a href="#">Opciones</a></li>
                <li class="breadcrumb-item"><a href="#">Departamento</a></li>
            </ol>
        </nav>
    </div>
    <div class="row  border-0">
        <div class="col-md-6 bg-white">
            <div class="row mx-0 ">
                <div class="col-md-10 col-sm-10 col-xs-6">
                    <h4 style="color: #003C4F;font-weight: bold">{{ __('departament.create_departament') }}</h4>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 py-2">
                    <a style="height: 20px; width: 80px" href="{{ route('departament.create') }}"><button type="button" class="btn px-3 py-0 btn-app-primary">Crear</button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <h2>Departamentos</h2>
        <table class="table">
            <thead class="mythead">
            <tr>
                <th scope="col" class="myth">ID</th>
                <th scope="col" class="myth">Departament</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>

            @foreach($departaments as $departament)
                <form  action="{{route('departament.destroy',$departament->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <tr>
                        <td>{{$departament->id}}</td>
                        <td>{{$departament->value}}</td>
                        <td>
                            <a href="{{ route('departament.show',$departament->id) }}"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('departament.edit',$departament->id) }}"><i class="fa fa-edit"></i></a>
                            <button class="border-0 bg-transparent" style="cursor: pointer" type="submit"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>

                    @endforeach
                </form>

            </tbody>
        </table>
    </div>
@endsection