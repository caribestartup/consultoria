@extends('default')

@section('title')
    {{ trans_choice('common.department', 2) }}
@endsection

@section('content')

    <div class="row title-page-buttom">
        <div class="col-xs-12 col-sm-6">
            @include('components.index_create', [
            'title' => trans_choice('common.department', 2),
            'url'   => route('departments.create'),
            'create'=> __('department.create_department')
            ])
        </div>
    </div>
    <div class="row mt-10">
        <div class="col-xs-12 col-sm-8 col-md-8">
            <h2>Departmentos</h2>
            <table class="table">
                <thead class="mythead">
                <tr>
                    <th scope="col" class="myth">ID</th>
                    <th scope="col" class="myth">Department</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>

                    @foreach($departments as $department)
                        {!! Form::open([
                            'class'=>'deletetopicform',
                            'url'  => route('departments.destroy', $department->id),
                            'method' => 'DELETE',
                            'id' => 'delete_form_'.$department->id,
                            ])
                        !!}
                            <tr>
                                <td>{{$department->id}}</td>
                                <td>{{$department->value}}</td>
                                <td>
                                    <a href="{{ route('departments.show',$department->id) }}"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('departments.edit',$department->id) }}"><i class="fa fa-edit"></i></a>
                                    <button id= {{$department->id}} class="border-0 bg-transparent" style="cursor: pointer" type="button"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>

                        {!! Form::close() !!}

                    @endforeach

                </tbody>
            </table>
        </div>
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