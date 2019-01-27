<div class="row align-items-end">
    {{--<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 form-group">
        <label>{{ trans_choice('common.user', 1) }}</label>
        <input id="users-i" class="form-control" placeholder="{{ __('common.search') }}"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off"
        />
        <div class="dropdown-menu" id="users-drop-down">
            <div class="dropdown-item no-results">
                {{ __('common.no_result') }}
            </div>
        </div>

    </div>--}}

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 form-group">
        <label>{{ trans_choice('common.action_plan', 1) }}</label>
        <select class="custom-select" id="action-plans">
            <option value="-1">--{{ __('common.select') }}--</option>
            @foreach($actionPlans as $actionPlan)
                <option value="{{ $actionPlan->id }}">{{ $actionPlan->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 form-group">
        <label>{{ trans_choice('common.action', 1) }}</label>
        <select class="custom-select" name="action[]" id="actions">
            <option value="-1">--{{ __('common.select') }}--</option>
        </select>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 form-group">
        <button class="btn btn-app-primary" id="add-action" type="button">{{ __('common.add') }}</button>
    </div>
</div>

<table class="table mT-20
    @if(isset($microContent))
@if($microContent->actions()->count() == 0)
        d-none
@endif
@else
        d-none
@endif

        " id="actions-table">
    <thead>
    <tr>
        {{--<th>
            {{ trans_choice('common.user', 1) }}
        </th>--}}
        <th>
            {{ trans_choice('common.action_plan', 1) }}
        </th>
        <th>
            {{ trans_choice('common.action', 1) }}
        </th>
        <th>

        </th>
    </tr>
    </thead>
    <tbody>
    @isset($microContent)
        @foreach($microContent->actions as $action)
            <tr>
                {{--<td>{{ $action->actionPlan->configurations[0]->user->fullName() }}</td> --}}
                <td>{{ $action->actionPlan->title }}</td>
                <td>{{ $action->title }}</td>
                <td>
                    <i class="fa fa-times cur-p fsz-md" data-id="{{ $action->id }}"></i>
                </td>
            </tr>
        @endforeach
    @endisset
    </tbody>
</table>

<div id="action-inputs">
    @isset($microContent)
        @foreach($microContent->actions as $action)
            <input type="hidden" name="action[]" value="{{ $action->id }}"/>
        @endforeach
    @endisset
</div>