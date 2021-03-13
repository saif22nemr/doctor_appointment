<?php $title = ['setting' , 'setting'];?>
@extends('admin.layouts.app')

@section('title')
	@lang('setting.edit_setting')
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.settings')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>

            </li>
        <li class="breadcrumb-item">
          <a href="{{route('setting.index')}}">
            @lang('app.settings')
          </a>
          </li>
            <li class="breadcrumb-item" aria-current="page">@if($action  == 'edit') @lang('app.edit') @else @lang('app.create') @endif</li>
          </ol>
        </nav>
  </div>
</div>
<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>
						@lang('setting.edit_setting')
					</h2>

					
				</div>

				<div class="card-body">
					<section class="form-submit"  >
						<form id="setting-form">
						
								{{-- <h2>@lang('setting.site_info')</h2> --}}
								<fieldset class="custom-fieldset">
									<legend>@lang('setting.site_info')</legend>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="site_title">@lang('app.entry_site_name')</label>
											<input type="text" class="form-control" name="site_title" id="site_title" placeholder="@lang('app.entry_name')"
											aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['site_title'] : old('site_title')}}">
											<div class="invalid-feedback">
												@lang('app.error_general_form')
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="meta_name">@lang('app.entry_site_meta_name')</label>
											<input type="text" class="form-control" name="meta_name" id="meta_name" placeholder="@lang('app.entry_site_meta_name')"
											aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['meta_name'] : old('meta_name')}}">
											<div class="invalid-feedback">
												@lang('app.error_general_form')
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="site_title">@lang('app.entry_site_meta_description')</label>
											<input type="text" class="form-control" name="meta_description" id="meta_description" placeholder="@lang('app.entry_site_meta_description')"
											aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['meta_description'] : old('meta_description')}}">
											<div class="invalid-feedback">
												@lang('app.error_general_form')
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="meta_keywords">@lang('app.entry_site_meta_keywords')</label>
											<input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="@lang('app.entry_site_meta_keywords')"
											aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['meta_keywords'] : old('meta_keywords')}}">
											<div class="invalid-feedback">
												@lang('app.error_general_form')
											</div>
										</div>
										
										<div class="col-md-6 mb-3">
											<label for="site_footer">@lang('app.entry_site_footer')</label>
											<input type="text" class="form-control" name="site_footer" id="site_footer" placeholder="@lang('app.entry_site_footer')"
											aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['site_footer'] : old('site_footer')}}">
											<div class="invalid-feedback">
												@lang('app.error_general_form')
											</div>
										</div>
										
									</div>
								</fieldset>
							
									
							

							<fieldset class="custom-fieldset">
								<legend>@lang('setting.email_info')</legend>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="email">@lang('app.entry_email')</label>
										<input type="email" class="form-control" name="email" id="email" placeholder="@lang('app.entry_name')"
										 aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['email'] : old('email')}}">
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="email_host">@lang('app.entry_email_host')</label>
										<input type="text" class="form-control" name="email_host" id="email_host" placeholder="@lang('app.entry_email_host')"
										 aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['email_host'] : old('email_host')}}">
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="email_port">@lang('app.entry_email_port')</label>
										<input type="number" class="form-control" name="email_port" id="email_port" placeholder="@lang('app.entry_email_port')"
										 aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['email_port'] : old('email_port')}}">
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="email_sender">@lang('app.entry_email_sender')</label>
										<input type="text" class="form-control" name="email_sender" id="email_sender" placeholder="@lang('app.entry_email_sender')"
										 aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $setting['email_sender'] : old('email_sender')}}">
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="email_password">@lang('app.entry_email_password')</label>
										<input type="text" class="form-control" name="email_password" id="email_password" placeholder="@lang('app.entry_password')"
										 aria-describedby="inputGroupPrepend3"  >
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
								</div>
							</fieldset>
						
						
						</form>	
						</div>
						<div class="save-button">
							<button type="button" class="btn btn-primary" id="save" data-action="{{$action}}" type="submit">@lang('app.button_save')</button>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('js')
<script type="text/javascript">
	var lang = "{{$lang}}";
	function getFormData(){
		var inputs = $('.form-submit .form-control');
		var data = {} ;
		$.each(inputs , function(index , value){
			var input = $(this);
			if(input.val().length > 0 && input.prop('name').length > 0){
				data[input.prop('name')] = input.val();
			}
		});
		return data;
	}
	
	function createAndEdit(xdata , type = 'create' , url = "{{url('api')}}/"+lang+"/setting" ){
		console.log(xdata);
		$.ajax({

			url: url,
			method: 'post',
			headers : header,
			data: xdata,
			cache: false,
        	contentType: false,
        	processData: false,
			success: function(json){
				console.log(json);
				if(json.success){
					// console.log(json);
					toastr.success( json.message, '@lang("app.settings")');	
					window.location.replace("{{route('setting.index')}}");
				}else{
					toastr.warning( json.message, '@lang("app.error")');
				}
				
			},
			error: function(xhr){
				console.log(xhr);
				handlingAjaxError(xhr);
			},
		});
	}
	$(function(){
		var action = "{{$action}}";
		$('#save').on('click' , function(){
			var formData = new FormData($('#setting-form')[0]);
			var setting = $(this);
			if(true){
				var url = "{{route('api.setting.update')}}";
				createAndEdit(formData , "{{$action}}" , url);
			}else{
				toastr.warning( '@lang("app.error_input_form")', '@lang("app.error")');
			}
		});
	});
</script>
@endsection