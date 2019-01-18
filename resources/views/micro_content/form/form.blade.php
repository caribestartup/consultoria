@if(isset($microContent))
    {!! Form::model($microContent,
    ['route' => ['micro_contents.update', $microContent->id],
    'method' => 'PUT']) !!}
@else
    {!! Form::open(['route' => 'micro_contents.store']) !!}
@endif
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
        <fieldset class="mT-10 bgc-white p-20 border-form">
            <div class="form-group">
                <label>{{ __('common.title') }}</label>
                <input class="form-control" name="micro_content[title]" required
                       @isset($microContent)
                       value="{{ $microContent->title }}"
                        @endisset
                />
            </div>

            <div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                <label>{{ trans_choice('common.point', 2) }}</label>
                <input class="form-control points-i" name="micro_content[approve]" required type="number" />
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    @include('components.topic_select', ['parent' => isset($microContent) ? $microContent: null])
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>{{ __('micro_content.type_label') }}</label>
                        <div>
                            <div class="custom-radio custom-control mR-20 custom-control-inline" >
                                <input name="micro_content[type]" type="radio" class="custom-control-input" id="bibliography"
                                       @isset($microContent)
                                       @if($microContent->type == 0)
                                       checked
                                       @endif
                                       @endisset

                                       @empty($microContent)
                                       checked
                                       @endempty
                                       value="0"/>
                                <label class="custom-control-label" for="bibliography">{{ __('micro_content.bibliography') }}</label>
                            </div>
                            <div class="custom-radio custom-control custom-control-inline">
                                <input name="micro_content[type]" type="radio" class="custom-control-input" id="guided"
                                       @isset($microContent)
                                       @if($microContent->type == 1)
                                       checked
                                       @endif
                                       @endisset
                                       value="1">
                                <label class="custom-control-label" for="guided">{{ __('common.guided') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>{{ __('common.visibility') }}</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="public" name="micro_content[public]"
                                   @if( isset($microContent) and $microContent->public)
                                   checked
                                   @endif
                                   value="1"
                            />
                            <label class="custom-control-label" for="public">{{ __('common.public') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr class="mT-40 mB-20">

        <h2>{{ __('micro_content.add_pages_to_mc') }}</h2>
        <fieldset id="page-form" class="mT-10 p-20 bgc-white border-form">
            @includeWhen(!isset($microContent), 'micro_content.form.page', ['index' => 0])

            @isset($microContent)
                @foreach($microContent->pages as $page)
                    @include('micro_content.form.page', ['index' => $loop->index])
                @endforeach
            @endisset
        </fieldset>

        <button type="button" class="btn btn-app-primary mT-15" id="new-page">{{__('micro_content.add_page') }}</button>

        <hr class="mT-30 mB-15">

        <h2>{{ __('micro_content.add_evaluation_questions') }}</h2>
        <fieldset id="question-form" class="mT-10 p-20 bgc-white border-form">
            @includeWhen(!isset($microContent) || (isset($microContent) and $microContent->questions()->count() == 0),
            'micro_content.form.question', ['index' => 0, 'microContent' => null, 'question' => null])

            @isset($microContent)
                @foreach($microContent->questions as $question)
                    @include('micro_content.form.question', ['index' => $loop->index])
                @endforeach
            @endisset
        </fieldset>

        <button type="button" class="btn btn-app-primary mT-15" id="new-question">{{__('common.add_question') }}</button>
        <hr class="mT-30 mB-15">

        <h2>{{ __('micro_content.link_actions') }}</h2>
        <fieldset id="action-form" class="mT-10 p-20 bgc-white border-form">
            @include('micro_content.form.action')
        </fieldset>

        <hr class="mT-30 mB-30">

        {!! Form::submit(__('common.save'),["class" => "btn btn-app-primary mr-3"])!!}

        @isset($microContent)
            <input name="deleted[questions]" type="hidden"/>
            <input name="deleted[answers]" type="hidden"/>

            {!! Form::button(__('common.delete'), [
            'class'         => 'btn btn-app-primary',
            'id'            => 'delete-micro-content',
            'data-toggle'   => "modal",
             'data-target'  => "#delete-modal"])!!}
        @endisset

        {!! Form::close() !!}

        @isset($microContent)
            {!! Form::open([
            'class'     => 'hide',
            'route'     => ['micro_contents.destroy', 'id' => $microContent->id],
            'id'        => 'delete-form',
            'method'    => 'DELETE'
            ]) !!}
            {!! Form::close() !!}
        @endisset
    </div>
</div>