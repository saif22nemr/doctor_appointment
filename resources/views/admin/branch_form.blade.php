<?php $title = ['branch'];?>
@extends('admin.layouts.app')

@section('title')
	@if($action == 'create')
						@lang('app.create_branch')
					@else
						@lang('app.edit_branch')
					@endif
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.branches')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>

            </li>
        	<li class="breadcrumb-item">
              <a href="{{route('branch.index')}}">
                @lang('app.branches')
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
						@lang('app.create_branch')
					@else
						@lang('app.edit_branch')
					@endif
					</h2>

				
				</div>

				<div class="card-body">
					<section class="form-submit"  >
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="name">@lang('app.entry_name')</label>
								<input type="text" class="form-control" name="name" name="name" id="name" placeholder="@lang('app.entry_name')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $branch->name : old('name')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="address">@lang('app.entry_address')</label>
								<input type="text" class="form-control" title="address" name="address" id="address" placeholder="@lang('app.entry_address')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $branch->address : old('address')}}">
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
					toastr.success( json.message, '@lang("app.branches")');	
					window.location.replace("{{route('branch.index')}}");
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
			var branch = $(this);
			if(Object.keys(formData).length > 0){
				var url = (action == 'edit') ? "{{url('api')}}/branch/{{$branch->id ?? ''}}" : "{{url('api')}}/branch"
				createAndEdit(formData , "{{$action}}" , url);
			}else{
				toastr.warning( '@lang("app.error_input_form")', '@lang("app.error")');
			}
		});
	});
</script>
@endsection