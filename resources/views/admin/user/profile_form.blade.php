<?php $title = ['user' , 'profile'];?>
@extends('admin.layouts.app')

@section('title')
	@if($action == 'create')
						@lang('user.create_profile')
					@else
						@lang('user.edit_profile')
					@endif
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.profile')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>

            </li>
        	
            

            
            <li class="breadcrumb-item" aria-current="page">@if($action == 'edit') @lang('app.edit') @else @lang('app.create')@endif</li>
          </ol>
        </nav>
  </div>
</div>
<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>
					@if($action == 'create')
						@lang('user.create_profile')
					@else
						@lang('user.edit_profile')
					@endif
					</h2>

				
				</div>

				<div class="card-body">
					<section class="form-submit"  >
						<div class="row">
							
							<div class="col-md-6 mb-3">
								<label for="username">@lang('app.entry_username')</label>
								<input type="text" class="form-control" title="username" name="username" id="username" placeholder="@lang('app.entry_username')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $user->username : old('username')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="email">@lang('app.entry_email')</label>
								<input type="email" class="form-control" title="email" name="email" id="email" placeholder="@lang('app.entry_email')"
								 aria-describedby="inputGroupPrepend3"  value="{{$action == 'edit' ? $user->email : old('email')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
					
							<div class="col-md-6 mb-3">
								<label for="password">@lang('app.entry_password')</label>
								<input type="text" class="form-control" title="password" name="password" id="password" placeholder="@lang('app.entry_password')"
								 aria-describedby="inputGroupPrepend3" required >
								 
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="password"></label>
								<button type="button" class="btn btn-secondary mt-4" id="generate-password"  onclick="randomString(8)">@lang('app.generate_password')</button>
								 
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							

							</div> <!-- end form -->
	
							
							
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
	
	@if($action == 'create')
		randomString();
	@endif
	function createAndEdit(xdata , type = 'create' , url = "" ){
		if(type == 'edit'){
			xdata['_method'] = 'PATCH';
		}
		console.log(url);
		$.ajax({

			url: url,
			method: 'post',
			headers : header,
			data: xdata,
			success: function(json){
				console.log(json);
				if(json.success){
					toastr.success( json.message, '@lang("app.profile")');	
					window.location.replace("{{route('dashboard.profile.index')}}");
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
			var formData = getFormData();
			var profile = $(this);
			if(Object.keys(formData).length > 0){
				var url = (action == 'edit') ? "{{url('api')}}/profile" : "{{url('api')}}/profile"
				createAndEdit(formData , "{{$action}}" , url);
			}else{
				toastr.warning( '@lang("app.error_input_form")', '@lang("app.error")');
			}
		});
	});
</script>
@endsection