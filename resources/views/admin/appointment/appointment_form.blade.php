<?php $title = ['appointment' , 'create'];?>
@extends('admin.layouts.app')

@section('title')
	@if($action == 'create')
						@lang('appointment.create_appointment')
					@else
						@lang('appointment.edit_appointment')
					@endif
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.appointments')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>

            </li>
        	<li class="breadcrumb-item">
              <a href="{{route('appointment.index')}}">
                @lang('app.appointments')
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
						@lang('appointment.create_appointment')
					@else
						@lang('appointment.edit_appointment')
					@endif
					</h2>

				
				</div>

				<div class="card-body">
					<section class="form-submit"  >
						<div class="row">
							@if($action == 'create')
							<div class="col-md-6 mb-3">
								<label for="patient">@lang('app.patients')</label>
								<select class="select2 form-control" name="patient_id">
									<option value="0">...</option>
									@foreach ($patients as $patient)
										<option value="{{$patient->id}}" >{{$patient->name}}</option>
									@endforeach
								</select>
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							@endif
							<div class="col-md-6 mb-3">
								<label for="title">@lang('app.entry_title')</label>
								<input type="text" class="form-control" name="title"  id="title" placeholder="@lang('app.entry_title')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $appointment->title : old('title')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="date">@lang('app.entry_date')</label>
								<input type="date" class="form-control" name="date" id="date" placeholder="@lang('app.entry_date')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $appointment->date : date('Y-m-d')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="time">@lang('app.entry_time')</label>
								<input type="time" class="form-control" name="time"  id="time" placeholder="@lang('app.entry_time')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $appointment->time : date('h:i:s')}}">
							</div>
							{{-- Branch --}}
							<div class="col-md-6 mb-3">
								<label for="branch">@lang('app.branches')</label>
								<select class="select2 form-control" name="branch_id">
									@foreach ($branches  as $item)
										<option value="{{$item->id}}" {{($action == 'edit' and $appointment->branch_id == $item->id)}}>{{$item->name}}</option>
									@endforeach
								</select>
								
							</div>
							<div class="col-md-6 mb-3">
								<label for="status">@lang('app.entry_status')</label>
								<select class="select2 form-control" name="status">
									@php
										$active = $action == 'edit' ? $appointment->status : 1;
									@endphp

									<option value="1" {{$action == 1 ?? 'selected'}}>@lang('appointment.pending')</option>
									<option value="2" {{$action == 2 ?? 'selected'}}>@lang('appointment.finished')</option>
									<option value="0" {{$action == 0 ?? 'selected'}}>@lang('appointment.canceled')</option>
								</select>
								
							</div>
							
							<div class="col-md-6 mb-3">
								<label for="patient_status">@lang('app.entry_patient_status')</label>
								<select class="select2 form-control" name="patient_status" id="patient_status">
									@php
										$active = $action == 'edit' ? $appointment->patient_status : 0;
									@endphp
									<option value="0" {{$active == 0 ?? 'selected'}}>@lang('appointment.new')</option>
									<option value="1" {{$active == 1 ?? 'selected'}}>@lang('appointment.followed')</option>
								</select>
								
							</div>
							<div class="col-md-6 mb-3 appointment-id {{($action == 'create' or $appointment->patient_status == 0) ? 'hide' : ''}}">
								<label for="appointment_id">@lang('app.entry_appointment_id')</label>
								<input type="number" name="appointment_id" id="appointment_id" class="form-control" value="{{($action =='edit' and $appointment->patient_status == 1) ? $appointment->appointment_id : ''}}">
							</div>
							@if($action == 'create' or $auth_user->group == 1)
							<div class="col-md-6 mb-3">
								<label for="note">@lang('app.entry_note')</label>
								<textarea class="form-control" name="note" rows="3">{{$action == 'edit' ? $appointment->note : ''}}</textarea>
							</div>
							@endif

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
					toastr.success( json.message, '@lang("app.appointments")');	
					window.location.replace("{{route('appointment.index')}}");
				}else{
					toastr.warning( json.message, '@lang("app.error")');
				}
				
			},
			error: function(xhr){
				handlingAjaxError(xhr);
			},
		});
	}
	$(function(){
		$('#patient_status').on('change' , function(){
			if($(this).prop('value') == 1){
				$('.appointment-id.hide').removeClass('hide');
			} 
			else{
				$('.appointment-id').addClass('hide');	
			}
		});
		var action = "{{$action}}";
		$('#save').on('click' , function(){
			var formData = getFormData();
			var appointment = $(this);
			if(Object.keys(formData).length > 0){
				var url = (action == 'edit') ? "{{url('api')}}/appointment/{{$appointment->id ?? ''}}" : "{{url('api')}}/appointment"
				createAndEdit(formData , "{{$action}}" , url);
			}else{
				toastr.warning( '@lang("app.error_input_form")', '@lang("app.error")');
			}
		});
	});
</script>
@endsection