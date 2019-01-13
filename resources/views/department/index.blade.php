@extends('default')

@section('title')
    {{ trans_choice('common.department', 2) }}
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            @include('components.index_create', [
            'title' => trans_choice('common.department', 2),
            'url'   => route('departments.create'),
            'create'=> __('department.create_department')
            ])
        </div>
    </div>
    <div class="row mt-5">
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
                    <form  action="{{route('departments.destroy',$department->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <tr>
                            <td>{{$department->id}}</td>
                            <td>{{$department->value}}</td>
                            <td>
                                <a href="{{ route('departments.show',$department->id) }}"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('departments.edit',$department->id) }}"><i class="fa fa-edit"></i></a>
                                <button class="border-0 bg-transparent" style="cursor: pointer" type="submit"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        @endforeach
                    </form>

                </tbody>
            </table>
        </div>
    </div>
@endsection