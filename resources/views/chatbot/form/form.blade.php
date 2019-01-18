@if(isset($chatbot))
    {!! Form::model($chatbot,
    ['route' => ['chatbots.update', $chatbot->id],
    'method' => 'PUT']) !!}
@else
    {!! Form::open(['route' => 'chatbot.store']) !!}
@endif
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
        <fieldset class="mT-10 bgc-white p-20 border-form">
            
            <h2>{{ __('chatbot.general') }}</h2>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>{{ __('chatbot.name') }}</label>
                        <input class="form-control" name="name" id="name" required
                            @isset($chatbot)
                            value="{{ $chatbot->name }}"
                                @endisset
                        />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>{{ __('chatbot.description') }}</label>
                        <textarea name="description" id="description" class="form-control" rows="1" required />
                            @isset($chatbot)
                            value="{{ $chatbot->description }}"
                                @endisset
                        </textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>{{ __('chatbot.approach') }}</label>
                        <select id="approach" name="approach" class="form-control">
                            @foreach($approachOptions as $opt)
                                <option  @if($loop->index == 0 )selected @endif value="{{$opt}}">{{$opt}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr class="mT-40 mB-20">

        <h2>{{ __('chatbot.add_evaluation_questions') }}</h2>
        <fieldset id="question-form" class="mT-10 p-20 bgc-white border-form">
            @includeWhen(!isset($chatbot) || (isset($chatbot) and $chatbot->questions()->count() == 0),
            'chatbot.form.question', ['index' => 0, 'chatbot' => null, 'question' => null])

            @isset($chatbot)
                @foreach($chatbot->questions as $question)
                    @include('chatbot.form.question', ['index' => $loop->index])
                @endforeach
            @endisset
        </fieldset>

        <button type="button" class="btn btn-app-primary mT-15" id="new-question">{{__('common.add_question') }}</button>

        <hr class="mT-30 mB-30">

        <h2>{{ __('chatbot.add_user') }}</h2>
        <fieldset class="mT-10 p-20 bgc-white border-form">
            <div class="form-group row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 r-0">
                    <label>{{ trans_choice('common.user', 1) }}</label>
                    <input id="users-i" class="form-control" placeholder="{{ __('common.search') }}"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off"
                    />
                    <div class="dropdown-menu" id="users-drop-down">
                        <div class="dropdown-item no-results">
                            {{ __('common.no_result') }}
                        </div>
                    </div>
                </div>
            </div>
            <div id="users-added" class="row">
                @isset($chatbot)
                    @foreach($chatbot->users as $user)
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 user-wrapper mT-10">
                            <div class="card p-10 h-100">
                                <div class="row align-items-center">
                                    <div class="col-4 pR-0">
                                        <img src="{{ asset('/uploads/avatars/' .$user->avatar) }}" class="bdrs-50p" width="45px" height="45px"/>
                                    </div>
                                    <div class="col-8 pL-5">
                                        {{ $user->fullName()  }}
                                    </div>
                                </div>
                                <span class="fa fa-close pos-a r-2 t-2 cur-p "></span>
                                <input type="hidden" name="user[]" value="{{ $user->id }}"/>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </fieldset>

        <hr class="mT-30 mB-30">

        {!! Form::submit(__('common.save'),["class" => "btn btn-app-primary mr-3"]) !!}

        @isset($chatbot)
            <input name="deleted[questions]" type="hidden"/>
            <input name="deleted[answers]" type="hidden"/>

            {!! Form::button(__('common.delete'), [
            'class'         => 'btn btn-app-primary',
            'id'            => 'delete-micro-content',
            'data-toggle'   => "modal",
            'data-target'  => "#delete-modal"])!!}
        @endisset

        {!! Form::close() !!}

        @isset($chatbot)
            {!! Form::open([
            'class'     => 'hide',
            'route'     => ['chatbots.destroy', 'id' => $chatbot->id],
            'id'        => 'delete-form',
            'method'    => 'DELETE'
            ]) !!}
            {!! Form::close() !!}
        @endisset
    </div>
</div>