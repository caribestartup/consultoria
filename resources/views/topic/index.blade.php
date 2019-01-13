@extends('default')

@section('title')
    {{ trans_choice('common.topic', 2) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            @include('components.index_create', [
            'title' => trans_choice('common.topic', 2),
            'url'   => route('topics.create'),
            'create'=> __('topic.create_topic')
            ])
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-xs-12 col-sm-8 col-md-8">
            <h2>Temas</h2>
            <table class="table">
                <thead class="mythead">
                <tr>
                    <th scope="col" class="myth">ID</th>
                    <th scope="col" class="myth">Tema</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>

                @foreach($topics as $topic)
                    <form  action="{{route('topics.destroy',$topic->id)}}" method="post" data-toggle = "modal"
                           data-target  ="#delete-modal">
                        @csrf
                        @method('DELETE')

                        <tr>
                            <td>{{$topic->id}}</td>
                            <td>{{$topic->value}}</td>
                            <td>
                                <a href="{{ route('topics.show',$topic->id) }}"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('topics.edit',$topic->id) }}"><i class="fa fa-edit"></i></a>
                                <button class="border-0 bg-transparent" style="cursor: pointer" type="submit"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        @endforeach
                    </form>

                </tbody>
            </table>
        </div>
    </div>

    @include('components.modal', [
        'modal_id'  => 'delete-modal',
        'title'     => __('common.attention!'),
        'content'   => __('users.delete_user_question'),
        'accept'    => __('common.yes'),
        'cancel'    => __('common.no')
        ])
@endsection




