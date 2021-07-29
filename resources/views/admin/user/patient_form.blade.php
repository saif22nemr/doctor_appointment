<?php $title = ['patient' , 'patient'];?>
@extends('admin.layouts.app')

@section('title')
	@if($action == 'create')
						@lang('user.create_patient')
					@else
						@lang('user.edit_patient')
					@endif
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.patients')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>

            </li>
        	<li class="breadcrumb-item">
              <a href="{{route('patient.index')}}">
                @lang('app.patients')
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
						@lang('user.create_patient')
					@else
						@lang('user.edit_patient')
					@endif
					</h2>

				
				</div>

				<div class="card-body">
					<section class="form-submit"  >
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="name">@lang('app.entry_name')</label>
								<input type="text" class="form-control" name="name" name="name" id="name" placeholder="@lang('app.entry_name')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $patient->user->name : old('name')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="job">@lang('app.entry_job')</label>
								<input type="text" class="form-control" title="job" name="job" id="job" placeholder="@lang('app.entry_job')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $patient->job : old('job')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="address">@lang('app.entry_address')</label>
								<input type="text" class="form-control" title="address" name="address" id="address" placeholder="@lang('app.entry_address')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $patient->address : old('address')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="birthday">@lang('app.entry_birthday')</label>
								<input type="date" class="form-control" title="birthday" name="birthday" id="birthday" placeholder="@lang('app.entry_birthday')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $patient->birthday : old('birthday')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="sex">@lang('app.entry_sex')</label>
								<select class="select2 form-control" id="sex" name="sex">
									<option value="male" {{($action == 'edit' and $patient->sex == 1) ? 'selected' : ''}}>@lang('app.male')</option>
									<option value="female" {{($action == 'edit' and $patient->sex == 0) ? 'selected' : ''}}>@lang('app.female')</option>
								</select>
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>

							<div class="col-md-6 mb-3">
								<label for="social_status">@lang('app.entry_social_status')</label>
								<input type="text" name="social_status" class="form-control" value="{{$action == 'edit' ?? $patient->social_status}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="nationality">@lang('app.entry_nationality')</label>
								<input type="text" class="form-control" title="nationality" name="nationality" id="nationality" placeholder="@lang('app.entry_nationality')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $patient->nationality : "مصري"}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							@if($action == 'create')
							<div class="col-md-6 mb-3">
								<label for="phone">@lang('app.entry_phone')</label>
								
								<input type="text" class="form-control" title="phone" name="phones[0][number]" id="phone" placeholder="@lang('app.entry_phone')"
								 aria-describedby="inputGroupPrepend3" required>
								 <input type="hidden" class="form-control" name="phones[0][primary]" value="1">
								<div class="invalid-feedback">
									
									@lang('app.error_general_form')
								</div>

							</div>
							@elseif($action == 'edit')
							<div class="col-md-6 mb-3">
								<label for="status">@lang('app.entry_status')</label>
								<select class="select2 form-control" id="status" name="status">
									<option value="1" {{($action == 'edit' and $patient->user->status == 1) ? 'selected' : ''}}>@lang('app.yes')</option>
									<option value="0" {{($action == 'edit' and $patient->user->status == 0) ? 'selected' : ''}}>@lang('app.no')</option>
								</select>
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							@endif
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
							<div class="col-md-6 mb-3">
								<label for="branch">@lang('app.branches')</label>
								<select class="select2 form-control" name="branch_id">
									@foreach($branchs as $branch)
										<option value="{{$branch->id}}" {{($action == 'edit' and $patient->branch_id = $branch->id) ? 'selected' :''}}>{{$branch->name}}</option>
									@endforeach
								</select>
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
					toastr.success( json.message, '@lang("app.patients")');	
					window.location.replace("{{route('patient.index')}}");
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
			var patient = $(this);
			if(Object.keys(formData).length > 0){
				var url = (action == 'edit') ? "{{url('api')}}/patient/{{$patient->id ?? ''}}" : "{{url('api')}}/patient"
				createAndEdit(formData , "{{$action}}" , url);
			}else{
				toastr.warning( '@lang("app.error_input_form")', '@lang("app.error")');
			}
		});
	});
</script>
@endsection