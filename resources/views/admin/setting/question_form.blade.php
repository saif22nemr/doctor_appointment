<?php $title = ['setting' , 'question'];?>
@extends('admin.layouts.app')

@section('title')
	@if($action == 'create')
						@lang('app.create_question')
					@else
						@lang('app.edit_question')
					@endif
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.questions')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>

            </li>
        	<li class="breadcrumb-item">
              <a href="{{route('setting.application.index')}}">
                @lang('app.questions')
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
						@lang('app.create_question')
					@else
						@lang('app.edit_question')
					@endif
					</h2>

					<div class="operation">
						@if($action =='edit')
						<a href="javascript:void(0)" class="btn btn-outline-danger btn-sm text-uppercase delete-item" data-toggle="modal" data-target="#deleteItem"  data-id="{{$question->id}}">
							<i class=" mdi mdi-delete"></i> @lang('app.delete')
						</a>
						@endif	
					</div>
				</div>

				<div class="card-body">
					<section class="form-submit"  >
						<div class="row">
							<div class="col-md-12 mb-3">
								<label for="question">@lang('app.question')</label>
								<input type="text" class="form-control" name="question" id="question" placeholder="@lang('app.question')"
								 aria-describedby="inputGroupPrepend3" required value="{{$action == 'edit' ? $question->question : old('question')}}">
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="answer_type">@lang('setting.answer_type')</label>
								<select class="select2 form-control" name="answer_type">
									<option value="text" {{($action == 'edit' and $question->answer_type == 1) ? 'selected' : ''}}>@lang('setting.text')</option>
									<option value="checkbox" {{($action == 'edit' and $question->answer_type == 2) ? 'selected' : ''}}>@lang('setting.checkbox')</option>
									<option value="selectbox" {{($action == 'edit' and $question->answer_type == 3) ? 'selected' : ''}}>@lang('setting.selectbox')</option>
									<option value="textarea" {{($action == 'edit' and $question->answer_type == 4) ? 'selected' : ''}}>@lang('setting.textarea')</option>
								</select>
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="reason">@lang('setting.reason')</label>
								<select class="select2 form-control" name="reason">
									<option value="0" {{($action == 'edit' and $question->reason == 0) ? 'selected' : ''}}>@lang('app.no')</option>
									<option value="1" {{($action == 'edit' and $question->reason == 1) ? 'selected' : ''}}>@lang('app.yes')</option>
								</select>
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="is_many">@lang('setting.is_many')</label>
								<select class="select2 form-control" name="is_many">
									<option value="0" {{($action == 'edit' and $question->is_many == 0) ? 'selected' : ''}}>@lang('app.no')</option>
									<option value="1" {{($action == 'edit' and $question->is_many == 1) ? 'selected' : ''}}>@lang('app.yes')</option>
								</select>
								<div class="invalid-feedback">
									@lang('app.error_general_form')
								</div>
							</div>
						
							
	
							
							
						</div> <!-- end form -->
						<div class="choose-part mt-6 mb-6">
							<h3 class="text-center text-bold">@lang('setting.chooses')</h3>
							<div class="operation">
								<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm text-uppercase" id="add-choose">
									<i class=" mdi mdi-plus-circle-outline"></i> @lang('setting.add_choose')
								</a>
							</div>
							<div class="choose-list clearfix">
								@if($action == 'create')
								<div class="row mb-3">
									<input type="text" name="chooses[0]" placeholder="@lang('setting.write_choose')" class="form-control">
									<div class="delete-button">
										<span class="delete-item"><i class=" mdi mdi-close"></i></span>
									</div>
								</div>
								@else 
									@foreach($question->chooses as  $key => $choose)
										<div class="row mb-3">
											<input type="text" name="chooses[{{$key}}]" placeholder="@lang('setting.write_choose')" class="form-control" value="{{$choose->choose}}">
											<div class="delete-button">
												<span class="delete-item"><i class=" mdi mdi-close"></i></span>
											</div>
										</div>
									@endforeach 
								@endif
							</div>
						</div>
						<div class="save-button">
							<button type="button" class="btn btn-primary" id="save" data-action="{{$action}}" type="submit">@lang('app.button_save')</button>
							
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<!-- Delete Modal -->
	<div class="modal fade" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="deleteItemLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteItemLabel">@lang('app.deletion')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					@lang('app.delete_sure')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">@lang('app.cancel')</button>
					<button type="button" data-dismiss="modal" data-url="" class="btn btn-primary btn-pill sure-delete" >@lang('app.delete')</button>
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
					toastr.success( json.message, '@lang("app.questions")');	
					window.location.replace("{{route('setting.application.index')}}");
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
		var itemId = 0;
		var chooseCount = {{($action == 'edit' ) ? count($question->chooses) : 1}};
		$('#save').on('click' , function(){
			var formData = getFormData();
			var question = $(this);
			if(Object.keys(formData).length > 0){
				var url = (action == 'edit') ? "{{url('api')}}/application/question/{{$question->id ?? ''}}" : "{{url('api')}}/application/question"
				createAndEdit(formData , "{{$action}}" , url);
			}else{
				toastr.warning( '@lang("app.error_input_form")', '@lang("app.error")');
			}
		});
		// delete choose
		$('.choose-list').on('click' , '.delete-item' , function(){
			$(this).parent().parent().remove();
		});
		// add choose
		$('#add-choose').on('click' , function(){
			var content = '<div class="row mb-3"><input type="text" name="chooses['+chooseCount+']" placeholder="@lang("setting.write_choose")" class="form-control"><div class="delete-button"><span class="delete-item"><i class=" mdi mdi-close"></i></span></div></div>';

			chooseCount += 1;
			$('.choose-list').append(content);
		});
		
		// delete
		$('.operation').on('click' , 'a.delete-item',function(e){
	   		e.preventDefault();
	   		var button = $(this);
	   		// var url = $(this).attr('href');
	   		
	   		// urlDelete = url;
	   		itemId = button.data('id');
			// group = button.data('group');
	   });
	   $('.sure-delete').on('click', function(){
	   			deleteItem("{{url('api')}}/application/question", itemId , "{{route('setting.application.index')}}");
	   });
	});
</script>
@endsection