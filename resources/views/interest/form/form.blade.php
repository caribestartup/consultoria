@if(isset($interest))
    {!! Form::model($interest,
    ['route' => ['interests.update', $interest->id],
    'method' => 'PUT']) !!}
@else
    {!! Form::open(['route' => 'interests.store']) !!}
@endif

<fieldset class="mT-10 bgc-white p-20 border-form ">
    <h2>{{ trans_choice('common.general', 1) }}</h2>
    <div class="pL-20 pR-20">
        <div class="form-group">
            <label for="title">{{ __('common.title') }}</label>
            <input class="form-control" name="title" required id="title"
                   @isset($interest)
                   value="{{ $interest->title }}"
                    @endisset
            />
        </div>

        <div class="form-group">
            <label for="objectives">{{ trans_choice('common.objective', 2) }}</label>
            <textarea id="objectives" class="form-control" name="objectives">@isset($interest){{ $interest->objectives }}@endisset</textarea>
        </div>

        <div class="form-group">
            <label for="knowledge-level">{{ __('interest.knowledge_level_label') }}</label>
            <div>
                <label class="custom-radio pr-4">
                    <input name="knowledge_valuation" type="radio" class="custom-radio"
                           @isset($interest)
                           @if($interest->knowledge_valuation == 0)
                           checked
                           @endif
                           @endisset

                           @empty($interest)
                           checked
                           @endempty
                           value="0">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">{{ __('common.initial') }}</span>
                </label>
                <label class="custom-radio pr-3">
                    <input name="knowledge_valuation" type="radio" class=""
                           @isset($interest)
                           @if($interest->knowledge_valuation == 1)
                           checked
                           @endif
                           @endisset
                           value="1">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">{{ __('common.middle') }}</span>
                </label>
                <label class="custom-radio pr-3">
                    <input name="knowledge_valuation" type="radio" class=""
                           @isset($interest)
                           @if($interest->knowledge_valuation == 2)
                           checked
                           @endif
                           @endisset
                           value="1">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">{{ __('common.advanced') }}</span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="importance-level">{{ __('interest.importance_level') }}</label>
            <input class="form-control" name="importance_level" id="importance-level" type="number"
                   @isset($interest)
                   value="{{ $interest->importance_level }}"
                    @endisset
            />
        </div>

        @include('components.topic_select', ['parent' => isset($interest) ? $interest: null])

        <div class="form-group">
            <label class="custom-checkbox">
                <input type="checkbox" class="" name="public"
                       @if(isset($interest) and $interest->public)
                       checked
                       @endif
                       value="1">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">{{ __('common.public') }}</span>
            </label>
        </div>
    </div>
</fieldset>

<fieldset class="mT-10 bgc-white p-20 border-form">
    <h2>{{ trans_choice('interest.tracing', 1) }}</h2>
    <div class="pL-20 pR-20">
        <div class="form-group">
            <label for="expiration-date">{{ __('common.ending_date') }}</label>
            <input class="form-control datepicker"
                   name="expiration_date"
                   id="expiration-date"
                   @isset($interest)
                   value="{{ $interest->expiration_date }}"
                    @endisset
            >
        </div>

        <div class="form-group">
            <label class="custom-checkbox">
                <input type="checkbox" class="" name="reminders" id="reminders"
                       @isset($interest)
                       @if($interest->reminders)
                       checked
                       @endif
                       @endisset
                       value="1">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">{{ __('common.enable_reminders') }}</span>
            </label>
            <div id="period"
                 @if(!isset($interest) or (isset($interest) and !$interest->reminders))
                 style="display: none"
                    @endif            >
                <label>{{ __('common.period') }}</label>
                <div>
                    <label class="custom-radio pr-4">
                        <input name="reminders_period" type="radio" class="custom-radio"
                               @if( (isset($interest) and $interest->reminders_period == 0)
                               or !isset($interest))
                               checked
                               @endif
                               value="0">
                        <span class="custom-control-indicator d-none"></span>
                        <span class="custom-control-description">{{ __('common.daily') }}</span>
                    </label>
                    <label class="custom-radio pr-3">
                        <input name="reminders_period" type="radio" class=""
                               @if(isset($interest) and $interest->reminders_period == 1)
                               checked
                               @endif
                               value="1">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">{{ __('common.weekly') }}</span>
                    </label>
                    <label class="custom-radio pr-3">
                        <input name="reminders_period" type="radio" class=""
                               @if(isset($interest) and $interest->reminders_period == 2)
                               checked
                               @endif
                               value="2">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">{{ __('common.monthly') }}</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</fieldset>

<hr class="mT-30 mB-30">

{!! Form::submit(__('common.save'),["class" => "btn btn-app-primary mr-3"])!!}

@isset($interest)
    {!! Form::button(__('common.delete'), [
    'class'         => 'btn btn-app-primary',
    'id'            => 'delete-interest',
    'data-toggle'   => "modal",
    'data-target'  => "#delete-modal"])!!}
@endisset

{!! Form::close() !!}

@isset($interest)
    {!! Form::open([
    'class'     => 'hide',
    'route'     => ['interests.destroy', 'id' => $interest->id],
    'id'        => 'delete-form',
    'method'    => 'DELETE'
    ]) !!}
    {!! Form::close() !!}
@endisset

