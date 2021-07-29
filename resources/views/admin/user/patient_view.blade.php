<?php $title = ['patient' , 'patient'];?>
@extends('admin.layouts.app')
@section('title' )
	@lang('app.patient')
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.patient')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{route('patient.index')}}">
				  @lang('user.patient_list')
				</a>
  
			  </li>
            
            <li class="breadcrumb-item active" aria-current="page">@lang('app.show')</li>
          </ol>
        </nav>
  </div>
  
</div>
	<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>@lang('app.patient')</h2>
					<div class="operation">
					
						<a href="javascript::void(0)" class="btn btn-outline-primary btn-sm text-uppercase" data-toggle="modal" data-target="#updatePhones" id="update-phones">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('user.update_phones')
						</a>
					</div>
					
				</div>

				<div class="card-body">
					<div class="row patient-data">
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_name')</h4>
						<p>{{$patient->user->name}}</p>
						</div>
						@if($patient->user->email)
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_email')</h4>
						<p>{{$patient->user->email}}</p>
						</div>
						@endif
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_job')</h4>
						<p>{{$patient->job}}</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_address')</h4>
						<p>{{$patient->address}}</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_social_status')</h4>
						<p>
							{{$patient->social_status }}
						</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_sex')</h4>
						<p>
							@if($patient->sex == 0)
								<span class="badge badge-primary">@lang('app.female')</span>
							@else 
								<span class="badge badge-success">@lang('app.male')</span>
							@endif
						</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_status')</h4>
						<p>
							@if($patient->user->status == 0)
								<span class="badge badge-danger">@lang('app.no')</span>
							@else 
								<span class="badge badge-success">@lang('app.yes')</span>
							@endif
						</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_birthday')</h4>
						<p>
							{{$patient->birthday}}
						</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_phone')</h4>
							@foreach($patient->user->phones as $phone)
								<p class="{{$phone->primary == 1 ? 'text-bold' : ''}}">{{$phone->number}}</p>
							@endforeach
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_created_at')</h4>
						<p>{{date('Y-m-d h:i A' , strtotime($patient->created_at))}}</p>
						</div>
					</div>
					{{-- Tabs --}}
					<ul class="nav nav-tabs mt-6" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link {{(isset($tab) and $tab == 'application') ? 'active' : ''}}" id="application-tab" data-toggle="tab" href="#application" role="tab" aria-controls="application" aria-selected="true">@lang('app.application')</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{(isset($tab) and $tab == 'comment') ? 'active' : ''}}" id="comment-tab" data-toggle="tab" href="#comment" role="tab" aria-controls="comment" aria-selected="true">@lang('app.comments')</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{(isset($tab) and $tab == 'activities') ? 'active' : ''}}" id="activities-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="activities" aria-selected="true">@lang('app.activities')</a>
						</li>
					
					</ul>
					<div class="tab-content" id="myTabContent1">
						{{-- Application --}}
						<div class="tab-pane pt-3 fade  {{(isset($tab) and $tab == 'application') ? 'show active' : ''}}" id="application" role="tabpanel" aria-labelledby="application-tab">
							<div class="operation clearfix">
								@if($patient->application_id != null)
									<a href="javascript::void(0)" class="btn btn-outline-danger delete-item btn-sm text-uppercase" id="delete-application" data-toggle="modal" data-target="#deleteItem" data-id="{{$patient->id}}">
										<i class=" mdi mdi-delete"></i> @lang('application.delete_application')
									</a>
								@else 
									<a href="{{route('patient.application.create' , $patient->id)}}" class="btn btn-outline-primary btn-sm text-uppercase" id="end-patient">
										<i class=" mdi mdi-plus-circle-outline"></i> @lang('application.create_application')
									</a>
								@endif
							</div>

							@if($patient->application != null)
								<div class="question-list clearfix mt-6">
									@foreach ($patient->application->questions as $item)
										<div class=" question card">
											<div class="card-header">
												<a href="{{route('patient.application.edit' , [$patient->id , $item->id])}}" class="text-bold question" >{{$item->question}}</a>
												
											</div>
										
											<div class="card-body">
												@if(count($item->answers) == 1)
													<p class="">{{$item->answers[0]->answer}}</p>
												@else
													<div class="row">
														@foreach($item->answers as $choose)
															<div class="col-md-3 col-sm-4">
																<span >- {{$choose->answer}}</span>
															</div>
														@endforeach
													</div>
												@endif
												@if($item->reason != null)
													<p><strong class="mr-2">@lang('application.reason'):</strong> {{$item->reason}}</p>
												@endif
											</div>
										</div>
									@endforeach
								</div>
							@endif
							
						</div>
						{{-- Comments --}}
						<div class="tab-pane pt-3 fade  {{(isset($tab) and $tab == 'comment') ? 'show active' : ''}}" id="comment" role="tabpanel" aria-labelledby="comment-tab">
							<div class="operation clearfix">
									<a href="javascript::void(0)" class="btn btn-outline-primary btn-sm text-uppercase" id="add-comment" data-toggle="modal" data-target="#updateComment" data-patient="{{$patient->id}}" >
										<i class=" mdi mdi-plus-ciryle-outline"></i> @lang('user.create_comment')
									</a>
								
							</div>
							<div class="comments">
								@foreach($patient->comments as $item)
									<div class="comment">
										<div class="sender-name"><a href="{{route('admin.show' , $item->user_id)}}">{{$item->user->name}}</a></div>
										<div class="comment-content">
											<span class="delete-item" data-id="{{$item->id}}"><i class=" mdi mdi-delete"></i></span>
											<span class="datetime">{{date('Y-m-d h:i A' , strtotime($item->created_at))}}</span>
											<div class="comment-body">
												{{$item->message}}
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>

						{{-- Activities --}}
						<div class="tab-pane pt-3 fade  {{(isset($tab) and $tab == 'activities') ? 'show active' : ''}}" id="activities" role="tabpanel" aria-labelledby="activities-tab">
							<div class="responsive-data-table">
								<table id="responsive-data-table" class="table even-odd dt-responsive dataTable no-footer dtr-inline collapsed " style="width:100%">
									<thead>
										<tr>
											<th>@lang('app.entry_description')</th>
											<th>@lang('app.entry_created_at')</th>
										</tr>
									</thead>

									<tbody>
									@foreach($patient->activities as $activity)
									<td>{{$activity->description}}</td>
									<td data-sort="{{$activity->created_at}}">{{date('Y-m-d h:i A' , strtotime($activity->created_at))}}</td>
									
									</tr>
									@endforeach
									{{-- test --}}
									
									</tbody>
								</table>
							</div>
						</div>
				
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- Delete Item -->
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
					@lang('application.delete_message')<br>
					@lang('app.delete_sure')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">@lang('app.cancel')</button>
					<button type="button" data-dismiss="modal" data-url="" class="btn btn-primary btn-pill sure-delete" >@lang('app.delete')</button>
				</div>
			</div>
		</div>
	</div>
{{-- Comment Form --}}
	<div class="modal fade" id="updateComment" tabindex="-1" role="dialog" aria-labelledby="updateCommentLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateCommentLabel">@lang('user.edit_comment')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<label>@lang('app.comment')</label>

							<textarea class="form-control auto-focus" name="message" placeholder="@lang('user.comment_placeholder')" ></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">@lang('app.cancel')</button>
					<button type="button" data-dismiss="modal" data-url="" data-patient="0" data-action="create" class="btn btn-primary btn-pill save-data" >@lang('app.save')</button>
				</div>
			</div>
		</div>
	</div>
	{{-- Update Phones --}}
	<div class="modal fade" id="updatePhones" tabindex="-1" role="dialog" aria-labelledby="updatePhonesLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updatePhonesLabel"><span>@lang('app.phones')</span>
						
					</h5>
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="operation">
						<a href="javascript::void(0)" class="btn btn-outline-primary btn-sm text-uppercase" id="add-phone" >
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('app.add')
						</a>
					</div>
					@foreach($patient->user->phones as $key => $phone)
						<div class="row">
							<div class="col-md-12">
								<div class="phone">
									<label class="control control-checkbox checkbox-primary checkbox-big">
										<input type="checkbox" name="phones[{{$key}}][primary]" value="1" class="primary form-control" {{$phone->primary == 1 ? 'checked' : ''}} />
										<div class="control-indicator"></div>
									</label>
									<input type="number" name="phones[{{$key}}][number]" value="{{$phone->number}}" class="form-control">
								
									<span class="delete delete-item"><i class=" mdi mdi-close"></i> </span>
								</div>
							</div>
						</div>
					@endforeach
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">@lang('app.cancel')</button>
					<button type="button" data-dismiss="modal" data-url="" class="btn btn-primary btn-pill save-data" >@lang('app.save')</button>
				</div>
			</div>
		</div>
	</div>

@endsection


@section('js')
<script src="{{asset('assets/plugins/data-tables/jquery.datatables.min.js')}}"></script>
<script src="{{asset('assets/plugins/data-tables/datatables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/data-tables/datatables.responsive.min.js')}}"></script>

<script type="text/javascript">
	var patients = null;
	var itemId = 0;
	
	jQuery(document).ready(function() {
		var urlDelete = '';
		var itemId = 0;
		var commentId = 0;
		var patientId = {{$patient->id}};

		var phoneCount = {{count($patient->user->phones)}};
	   var patientTable = jQuery('#responsive-data-table').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		'order' : [[1, 'desc']],
	    'language': datatableLanguage
	   });
	   
	   var type = 'else';
	   //getpatient(patientTable);
	   $('.operation').on('click' , 'a.delete-item',function(e){
	   		e.preventDefault();
	   		var button = $(this);
	   		// var url = $(this).attr('href');
	   		type = button.data('type');
	   		// urlDelete = url;
	   		itemId = button.data('id');
	   });
	   $('.sure-delete').on('click', function(){
		   var url = "{{url('api/patient/'.$patient->id.'/application')}}";
		   
	   		deleteItem(url, itemId , "{{route('patient.application.create' , $patient->id)}}" ,false);
	   });
	//    when phone checked 
	$('#updatePhones ').on('change' , '.primary' , function(){
		$('#updatePhones .primary').prop('checked' , false);
		$(this).prop('checked' , true);
	});
	//    delete phone
	$('#updatePhones .delete-item').on('click' , function(){
		var thisTag = $(this);
		thisTag.parent().remove();
	});
	//    add phone input
	$('#add-phone').on('click' , function(){
		
		var content = '<div class="row"><div class="col-md-12"><div class="phone">';
		content += '<label class="control control-checkbox checkbox-primary checkbox-big"><input type="checkbox" class="primary form-control" name="phones['+phoneCount+'][primary]" /><div class="control-indicator"></div></label>';
		content += '<span><input type="number" name="phones['+phoneCount+'][number]"  class="form-control"></span>';
		content += '<span class="delete delete-item"><i class=" mdi mdi-close"></i> </span>';
		content += '</div></div></div>';
		$('#updatePhones .modal-body').append(content);
	    phoneCount += 1;
	});
	//    update phones
	   $('#updatePhones').on('click' , '.save-data' , function(){
		   var button = $(this);
		   var formData = getFormData('#updatePhones .form-control');
		   console.log(formData);
		   $.ajax({
			   url : "{{route('api.patient.phone.update' , $patient->id)}}",
			   method: 'post',
			   headers : header,
			   data: formData,
			   success: function(json){
				   toastr.success(json.message , "@lang('app.patient')");
			   },error:function(xhr){
				   console.log(xhr);
				   handlingAjaxError(xhr);
			   }
		   });
	   });
	//    Create Comment
	
	$('#add-comment').on('click' , function(){
		var thisTag = $(this);
		var button = $('#updateComment .save-data');
		// button.data('id' , thisTag.data('id'));
		button.data('action' , 'create');
		$('#updateComment textarea').prop('value' , '');
	});
	$('#updateComment .save-data').on('click' , function(){
		var thisTag = $(this);
		var dataForm = getFormData('#updateComment .form-control');
		if(thisTag.data('action') == 'edit'){
			var url = "{{route('api.patient.comment.store' , $patient->id)}}/"+thisTag.data('id');
		}else{
			var url = "{{route('api.patient.comment.store' , $patient->id)}}";
		}
		$.ajax({
			url  : url,
			method : 'post',
			headers : header,
			data: dataForm,
			success: function(json){
				console.log(json);
				toastr.success(json.message , "@lang('app.comment')")
				window.location.replace('{{route("patient.show" , $patient->id)}}');
			},
			error: function(xhr){
				console.log(xhr);
				handlingAjaxError(xhr);
			}
		});
	});

	$('.comments').on('click' , '.comment .delete-item' , function(){
		var tag = $(this);
		$.ajax({
			url : "{{route('api.patient.show' , $patient->id)}}/comment/"+ tag.data('id'),
			method: 'post',
			headers: header,
			data : {'_method' : 'DELETE'},
			success : function(json){
				console.log(json);
				tag.parent().parent().slideUp();
				toastr.success(json.message  , "{{ trans('app.comment')}}");
			},
			error: function(xhr){
				console.log(xhr);
				handlingAjaxError(xhr);
			}
		});
	});
	
  });
</script>
@endsection