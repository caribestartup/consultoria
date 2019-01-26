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

                {!! Form::open([
                        'class'=>'deletetopicform',
                        'url'  => route('departament.destroy', $departament->id),
                        'method' => 'DELETE',
                        'id' => 'delete_form_'.$departament->id,
                        ])
                !!}

                    <tr>
                        <td>{{$departament->id}}</td>
                        <td>{{$departament->value}}</td>
                        <td>
                            <a href="{{ route('departament.show',$departament->id) }}"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('departament.edit',$departament->id) }}"><i class="fa fa-edit"></i></a>
                            <button id= {{$departament->id}} class="border-0 bg-transparent" style="cursor: pointer" type="button"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>

                    {!! Form::close() !!}

                @endforeach

            </tbody>
        </table>
    </div>

    @include('components.modal_delete', [
        'modal_id'  => 'delete-modal',
        'title'     => __('common.attention!'),
        'content'   => __('common.delete_entity'),
        'accept'    => __('common.yes'),
        'cancel'    => __('common.no')
        ])
@endsection

@section('js')

    <script type="text/javascript">
        var currentForm;
        $('.border-0').on('click', function() {
            currentForm = ($('#delete_form_'+this.id[0]));
            alertify.defaults.transition = "slide";
            alertify.defaults.theme.ok = "btn btn-primary";
            alertify.defaults.theme.cancel = "btn btn-danger";
            alertify.defaults.theme.input = "form-control";

            var header = document.createElement('modal-title');
            header.appendChild(document.getElementsByClassName('modal-title')[0]);

            var body = document.createElement('modal-content-alert');
            body.appendChild(document.getElementsByClassName('modal-content-alert')[0]);

            alertify.confirm(header, body, function(){
                    alertify.success('Eliminado');
                    currentForm.submit();
                },function(){
                    alertify.error('Cancelado');
                }).set({labels:{ok:'Elimanar', cancel: 'Cancelar'}, padding: false});
        });
    </script>
@endsection