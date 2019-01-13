@extends('default')

@section('title')
    {{ trans_choice('common.group', 2) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            @include('components.index_create', [
            'title' => trans_choice('common.group', 2),
            'url'   => route('groups.create'),
            'create'=> __('group.create_group')
            ])
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-xs-12 col-sm-8 col-md-8">
            <h2>{{ __('group.groups') }}</h2>
            <table class="table">
                <thead class="mythead">
                <tr>
                    <th scope="col" class="myth">ID</th>
                    <th scope="col" class="myth">{{ __('group.group') }}</th>
                    <th scope="col" class="myth"></th>
                </tr>
                </thead>
                <tbody>

                @foreach($groups as $group)
                    <form  action="{{route('groups.destroy',$group->id)}}" method="post" data-toggle = "modal"
                           data-target  ="#delete-modal">
                        @csrf
                        @method('DELETE')

                        <tr>
                            <td>{{$group->id}}</td>
                            <td>{{$group->value}}</td>
                            <td>
                                <a href="{{ route('groups.show',$group->id) }}"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('groups.edit',$group->id) }}"><i class="fa fa-edit"></i></a>
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
