<?php $title = ['user' , 'patient'];?>
@extends('admin.layouts.app')

@section('title')
	@if($action == 'create')
						@lang('application.create_application')
					@else
						@lang('application.edit_application')
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
              <a href="{{route('patient.show' , $patient->id)}}">
                @lang('app.patient')
              </a>

            </li>
            

            
            <li class="breadcrumb-item" aria-current="page">@if($action == 'edit') @lang('application.edit_application') @else @lang('application.create_application')@endif</li>
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
						@lang('application.create_application')
					@else
						@lang('application.edit_application')
					@endif
					</h2>

				
				</div>

				<div class="card-body">
					<section class="form-submit application"  >
						<div class="row">
							@foreach($questions as $item)
								{{-- Text --}}
								@if($item->answer_type == 1)
									<div class="col-md-12 mb-3">
										<label for="{{$item->id}}" class="text-bold question-title">{{$item->question}}</label>
										<input type="text" class="form-control"  name="{{$action == 'create' ? 'questions['.$item->id.'][answer]' : 'chooses[]'}}"  id="{{$item->id}}" placeholder="@lang('app.answer')"
										aria-describedby="inputGroupPrepend3"  >
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
								{{-- Checkbox --}}
								@elseif($item->answer_type == 2)
									<div class="col-md-12 mb-3">
										<label for="{{$item->id}}" class="text-bold question-title">{{$item->question}}</label>
										<div class="checkboxs {{$item->is_many == 1 ? 'is-many' : 'not-many'}}">
											<div class="row">
												@foreach($item->chooses as $choose)
												<div class="col-md-3 col-sm-4">
													<label class="control control-checkbox checkbox-primary checkbox-big">
														<span>{{$choose->choose}}</span>
														<input type="checkbox" name="{{$action == 'create' ? 'questions['.$item->id.'][chooses][]' : 'chooses[]'}}" value="{{$choose->choose}}" class="primary form-control"  />
														<div class="control-indicator"></div>
													</label>
													
												</div>
												@endforeach
											</div>
										</div>
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
								{{-- SelectBox --}}
								@elseif($item->answer_type == 3)
									<div class="col-md-12 mb-3">
										<label for="{{$item->id}}" class="text-bold question-title">{{$item->question}}</label>
										<select class="select2 form-control " {{$item->is_many == 1 ? 'multiple' : ''}}    name="{{$action == 'create' ? 'questions['.$item->id.'][chooses][]' : 'chooses[]'}}" >
											@foreach($item->chooses as $key => $choose)
												<option value="{{$choose->choose}}">{{$choose->choose}}</option>
											@endforeach
										</select>
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
								{{-- Textarea --}}
								@elseif($item->answer_type == 4)
									<div class="col-md-12 mb-3">
										<label for="{{$item->id}}" class="text-bold question-title">{{$item->question}}</label>
										<textarea  class="form-control" name="{{$action == 'create' ? 'questions['.$item->id.'][answer]' : 'chooses[]'}}" id="{{$item->id}}" placeholder="@lang('app.answer')"
											aria-describedby="inputGroupPrepend3"  rows="3">
	
											</textarea>
										<div class="invalid-feedback">
											@lang('app.error_general_form')
										</div>
									</div>
								@endif
								@if($item->reason == 1)
								<div class="col-md-12 mt-2 mb-2">
									<input type="text" name="{{$action == 'create' ? 'questions['.$item->id.'][reason]' : 'reason'}}" placeholder="@lang('application.reason')" class="form-control">
								</div>
								@endif
								<hr>
							@endforeach
							
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
	
	function getFormData(inputclasses = '.form-submit .form-control'){
      var inputs = $(inputclasses);
      var data = {} ;
      $.each(inputs , function(index , value){
        var input = $(this);
        if(input.prop('type') == 'checkbox'){
          if(input.prop('checked') == true)
            data[input.prop('name')] = input.prop('value');
          
        }

        else if(input.prop('type') != 'checkbox' && input.prop('value').length > 0 && input.prop('name').length > 0){
          data[input.prop('name')] = input.val();
        }
        // input.prop('name');
      });

      return data;
    }
	function createAndEdit(xdata , type = 'create' , url = "" ){
		if(type == 'edit'){
			xdata['_method'] = 'PATCH';
		}
		$.ajax({

			url: url,
			method: 'post',
			headers : header,
			data: xdata,
			success: function(json){
				console.log(json);
				if(json.success){
					toastr.success( json.message, '@lang("application.create_application")');	
					window.location.replace("{{route('patient.show' , $patient->id) . '?tab=application'}}");
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
			var application = $(this);
			if(Object.keys(formData).length > 0){
				var url = (action == 'edit') ? "{{url('api')}}/patient/{{$patient->id}}/application/{{$applicationQuestion->id ?? ''}}" : "{{url('api')}}/patient/{{$patient->id}}/application";
				createAndEdit(formData , "{{$action}}" , url);
			}else{
				toastr.warning( '@lang("app.error_input_form")', '@lang("app.error")');
			}
		});

		// checkbox control
		$('.checkboxs.not-many input[type=checkbox]').on('change' , function(){
			var thisTag = $(this);
			thisTag.parent().parent().parent().parent().find('input[type=checkbox]').prop('checked' , false);
			thisTag.prop('checked' , true);
			// console.log(thisTag.val());
		});
	});
</script>
@endsection