@extends('default')

@section('title')
	{{ __('users.new_add_header') }}
@endsection

@section('css')
	<link href="{{ asset('/plugins/croppie/croppie-2.6.2.css') }}" rel="stylesheet">
	<link href="{{ asset('/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet">

	<style>
		.upload-avatar .upload-avatar-wrap,
		.upload-avatar .upload-result,
		.upload-avatar.ready .upload-msg {
			display: none;
		}
		.upload-avatar.ready .upload-avatar-wrap {
			display: block;
		}
		.upload-avatar.ready .upload-result {
			display: inline-block;
		}
		.upload-avatar-wrap {
			width: 100%;
			height: 100%;
			margin: 0 auto;
		}
		.upload-wrapper-container {
			min-height: 300px;
		}

		.multiselect-container .checkbox input[type="checkbox"] {
			opacity: 1 !important;
		}

		.multiselect-native-select .dropdown-menu {
			min-width: 12rem;
		}

		button.multiselect {
			background-color: #f2f3f5;
		}

		.multiselect-container li a, button.multiselect span.multiselect-selected-text {
			color: #003C4F;
		}

		/* The switch - the box around the slider */
		.switch {
			position: relative;
			display: inline-block;
			width: 50px;
			height: 24px;
		}

		/* Hide default HTML checkbox */
		.switch input {
			opacity: 0;
			width: 0;
			height: 0;
		}

		/* The slider */
		.slider {
			position: absolute;
			cursor: pointer;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #ccc;
			-webkit-transition: .4s;
			transition: .4s;
		}

		.slider:before {
			position: absolute;
			content: "";
			height: 16px;
			width: 16px;
			left: 4px;
			bottom: 4px;
			background-color: white;
			-webkit-transition: .4s;
			transition: .4s;
		}

		input:checked + .slider {
			background-color: #F15A21;
		}

		input:focus + .slider {
			box-shadow: 0 0 1px #F15A21;
		}

		input:checked + .slider:before {
			-webkit-transform: translateX(26px);
			-ms-transform: translateX(26px);
			transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
			border-radius: 34px;
		}

		.slider.round:before {
			border-radius: 50%;
		}
	</style>
@stop

@section('content')

	@include('components.index_top', ['indexes' => [
	trans_choice('common.user', 2),	__('common.new')
	]])

	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-7">
			<div class="row p-10 mT-20 mB-20">
				<div class="col-12">
					<h2 class="text-color-primary-header font-weight-bold float-left font">
						{{ trans('users.new_add_header') }}
					</h2>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-5"></div>
	</div>

	{!! Form::open([
			'id' => 'create_form',
			'action' => ['UserController@store'],
			'files' => true
		])
	!!}

	<div class="row mB-20 bgc-white p-20 border-form" >
		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2 ">
			<h5 class="text-color-primary-header">{{ trans('users.general_data') }}</h5>
		</div>

		<div class="container ">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-9 ">
					<div class="form-group row">
						{{ Form::label("name", trans('users.label_username'), ["class"=>"col-sm-12 col-md-2 col-form-label fw-600"]) }}
						<div class="col-sm-12 col-md-10">
							{{ Form::input("text", "name", null, array_merge(["placeholder" => trans('users.placeholder_username'), "class" => "form-control", "required" => "required|min:6"])) }}
						</div>
					</div>

					<div class="form-group row">
						{{ Form::label("last_name", trans('users.label_lastname'), ["class"=>"col-sm-12 col-md-2 col-form-label fw-600"]) }}
						<div class="col-sm-12 col-md-10">
							{{ Form::input("text", "last_name", null, array_merge(["placeholder" => trans('users.placeholder_lastname'), "class" => "form-control"])) }}
						</div>
					</div>

					<div class="form-group row">
						{{ Form::label("email", trans('users.label_email'), ["class"=>"col-sm-12 col-md-2 col-form-label fw-600"]) }}
						<div class="col-sm-12 col-md-10">
							{{ Form::input("email", "email", null, array_merge(["placeholder" => trans('users.placeholder_email'), "class" => "form-control"])) }}
						</div>
					</div>

					<div class="form-group row">
						{{ Form::label("password", trans('users.label_password'), ["class"=>"col-sm-12 col-md-2 col-form-label fw-600"]) }}
						<div class="col-sm-12 col-md-10">
							{{ Form::input("password", "password", null, array_merge(["placeholder" => trans('users.placeholder_password'), "class" => "form-control"])) }}
						</div>
					</div>

					<div class="form-group row">
						{{ Form::label("password_confirmation", trans('users.label_confirm'), ["class"=>"col-sm-12 col-md-2 col-form-label fw-600"]) }}
						<div class="col-sm-12 col-md-10">
							{{ Form::input("password", "password_confirmation", null, array_merge(["placeholder" => trans('users.placeholder_confirm'), "class" => "form-control"])) }}
						</div>
					</div>

					<div class="form-group row">
						{{ Form::label("avatar", trans('users.label_avatar'), ["class"=>"col-sm-12 col-md-2 col-form-label fw-600"]) }}
						<div class="col-sm-12 col-md-10">
							<div class="input-group">
								<div class="custom-file">
									{{ Form::file("avatar", array_merge(["class" => "form-control custom-file-input", "id" => "avatarFile"])) }}
									<label class="custom-file-label" for="avatarFile">{{ trans('users.search_avatar') }}</label>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row align-items-center">
						<div class="col-sm-12 col-md-2 fw-600">
							{{ Form::label('bosses-i', trans_choice('users.boss', 1)) }}
						</div>
						<div class="col-sm-12 col-md-10">
							<input id="bosses-i" class="form-control" placeholder="{{ __('common.search') }}"
								   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off"
							/>
							<div class="dropdown-menu" id="bosses-drop-down">
								<div class="dropdown-item no-results">
									{{ __('common.no_result') }}
								</div>
							</div>
							<input type="hidden" name="boss_id" id="boss-id">
						</div>
					</div>

					<div class="form-group row">
						{{ Form::label("department[]", trans_choice('common.department', 2), ["class"=>"col-sm-12 col-md-2 col-form-label fw-600"]) }}
						<div class="col-sm-12 col-md-10">
							<select multiple="multiple" name="department[]" class="department-i multiselect">
								@foreach($departments as $department)
									<option value="{{ $department->id }}"
									>{{ $department->value }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						{{ Form::label("group[]", trans_choice('common.group', 2), ["class"=>"col-sm-12 col-md-2 col-form-label fw-600"]) }}
						<div class="col-sm-12 col-md-10">
							<select multiple="multiple" name="group[]" class="group-i multiselect">
								@foreach($groups as $group)
									<option value="{{ $group->id }}"
									>{{ $group->value }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row align-items-center">
						<div class="col-sm-12 col-md-2 fw-600">
							{{ Form::label("coach", __('common.coach')) }}
						</div>
						<div class="col-md-6">
							<span>{{ __('common.no') }}</span>
							<label class="switch">
								<input type="checkbox" name="is_coach" id="coach">
								<span class="slider round"></span>
							</label>
							<span>{{ __('common.yes') }}</span>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-md-4 col-lg-3">
					<div class="upload-wrapper-container w-100 h-100">
						<div class="upload-avatar-wrap">
							<div id="upload-avatar"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 my-2">
			<h5 class="text-color-primary-header">{{ trans('users.permissions_data') }}</h5>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-9">
					<div class="form-group row">
                        <label for="rol">Rol</label>
						<div class="col-sm-12 col-md-10">

							<select name="rol" placeholder="{{ trans('users.placeholder_role') }}" class="form-control custom-select">
									<option value="">Sin selecionar</option>
									<option value="Administrador">Administrador</option>
									<option value="Jefe">Jefe</option>
									<option value="Empleado">Empleado</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="d-flex justify-content-end">
		<button type="submit" class="btn btn-app-primary float-right">{{ trans('common.confirm') }}</button>
	</div>

	{{ Form::input("hidden", "crop_x", null, array_merge(["id" => "crop_x"])) }}
	{{ Form::input("hidden", "crop_y", null, array_merge(["id" => "crop_y"])) }}
	{{ Form::input("hidden", "crop_width", null, array_merge(["id" => "crop_width"])) }}
	{{ Form::input("hidden", "crop_height", null, array_merge(["id" => "crop_height"])) }}
	{!! Form::close() !!}
@stop

@section('js')
	<script src="{{ asset('/plugins/croppie/croppie-2.6.2.min.js') }}"></script>
	<script src="{{ asset('/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js') }}"></script>
	<script>
        $(document).ready(function () {
			{{-- Creando multiselect --}}
            $('select.multiselect').multiselect({
                includeSelectAllOption: true,
                templates: { li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>' },
                allSelectedText: "{{ trans_choice('common.all', 2) }}",
                selectAllText: "{{ __('common.select_all') }}",
                nonSelectedText: "{{ __('common.non_selected') }}",
                nSelectedText: "{{ trans_choice('common.selected', 2) }}",
                filterPlaceholder: "{{ __('common.search') }}"
            });

            $('#avatarFile').on('change',function(){
                var fileName = $(this).val();
                $(this).next('.custom-file-label').html(fileName);
                readFile(this);
            });

            var uploadCroppie = document.getElementById('upload-avatar'),
                uploadAvatar = new Croppie(uploadCroppie, {
                    viewport: {
                        width: 150,
                        height: 150,
                        type: 'circle'
                    },
                    showZoomer: false,
                    enableExif: true
                });
            uploadCroppie.addEventListener('update', function (ev) {
                $('#crop_x').val(uploadAvatar.get().points[0])
                $('#crop_y').val(uploadAvatar.get().points[1])
                $('#crop_width').val(uploadAvatar.get().points[2] - uploadAvatar.get().points[0])
                $('#crop_height').val(uploadAvatar.get().points[3] - uploadAvatar.get().points[1])
            });

            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.upload-avatar').addClass('ready');
                        uploadAvatar.bind({
                            url: e.target.result
                        });
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    alert("Sorry - you're browser doesn't support the FileReader API");
                }
            }

			{{-- Evento buscar jefe --}}
            $('#bosses-i').on('click keyup', function (e) {
                let dropDown = $('#bosses-drop-down');
                if($(this).val().replace(/[" \n]/g, '').length > 0) {
                    if(e.type === 'keyup' || (e.type === 'click' && $('.item', dropDown).length === 0))
                        $.post(
                            "{{ action('UserController@search') }}",
                            {
                                _token: $('input[name="_token"]').val(),
                                search: $(this).val()
                            },
                            function (result) {
                                $('.item', dropDown).remove();
                                result = $(result);
                                let items = $('.dropdown-item', result);
                                if(items.length > 0) {
                                    items.click(bossDropDownItemEvent);
                                    dropDown.append(items);
                                    $('.no-results', dropDown).addClass('d-n');
                                }
                                else{
                                    $('.no-results', dropDown).removeClass('d-n');
                                    $('#bosses-i').removeData('user');
                                }
                            });
                }
                else{
                    $('.item', dropDown).remove();
                    $('.no-results', dropDown).removeClass('d-n');
                    $('#bosses-i').removeData('user');
                }
            });

			{{-- Evento click sobre jefe en listado--}}
            function bossDropDownItemEvent(){
                let item = $(this);
                let input = $('#bosses-i');
                input.val(item.data('name'));
                $('#boss-id').val(item.data('id'));
            }
        });

	</script>
@stop
