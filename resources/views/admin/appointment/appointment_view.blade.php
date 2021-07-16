<?php $title = ['appointment' , ''];?>
@extends('admin.layouts.app')
@section('title' )
	@lang('app.appointment')
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.appointment')</h1>
    
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
            
            <li class="breadcrumb-item active" aria-current="page">@lang('app.show')</li>
          </ol>
        </nav>
  </div>
  
</div>
	<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>@lang('app.appointment')</h2>
					<div class="operation">
						<a href="{{route('appointment.edit' , $appointment->id)}}" class="btn btn-outline-primary btn-sm text-uppercase" >
							<i class=" mdi mdi-circle-edit-outline"></i> @lang('app.edit')
						</a>
						<a href="javascript::void(0)" class="btn btn-outline-success btn-sm text-uppercase" data-toggle="modal" data-target="#updateStatus" id="update-status" data-status="{{$appointment->status}}">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('appointment.update_status')
						</a>
						
					</div>
					
				</div>

				<div class="card-body">
					<div class="row appointment-data">
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_id')</h4>
							<p>{{$appointment->id}}</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.patient')</h4>
							<p><a href="{{route('patient.show' , $appointment->patient_id)}}">{{$appointment->patient->user->name}}</a></p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.branch')</h4>
							<p><a href="{{route('branch.show' , $appointment->branch_id)}}" >{{$appointment->branch->name}}</a></p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_title')</h4>
							<p>{{$appointment->title}}</p>
						</div>
						
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_date')</h4>
							<p>{{$appointment->date}}</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_time')</h4>
							<p>{{date('h:i A' , strtotime($appointment->time))}}</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_status')</h4>
							<p>
								@if($appointment->status == 0)
									<span class="badge badge-danger">@lang('appointment.canceled')</span>
								@elseif($appointment->status == 1)
									<span class="badge badge-primary">@lang('appointment.pending')</span>
								@elseif($appointment->status == 2)
									<span class="badge badge-success">@lang('appointment.finished')</span>
								@elseif($appointment->status == 3)
									<span class="badge badge-wait">@lang('appointment.appointment_request')</span>
								@endif
							</p>
						</div>
						@if($appointment->patient_status == 1 and isset($appointment->followAppointment->id))
						<div class="col-sm-4 mb-3">
							<h4>@lang('appointment.continue')</h4>
							<p>
								<a href="{{route('appointment.show' , $appointment->appointment_id ? $appointment->appointment_id : 0)}}">{{$appointment->followAppointment->title}}</a>
							</p>
						</div>
						@endif
						
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_created_at')</h4>
							<p>{{date('Y-m-d h:i A' , strtotime($appointment->created_at))}}</p>
						</div>
						@if(!empty($appointment->note))
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_note')</h4>
							<p>
								{{$appointment->note}}
							</p>
						</div>
						@endif
					</div>
					{{-- Tabs --}}
					<ul class="nav nav-tabs mt-6" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link {{(isset($tab) and $tab == 'comments') ? 'active' : ''}}" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="true">@lang('app.comments')</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{(isset($tab) and $tab == 'activities') ? 'active' : ''}}" id="activities-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="activities" aria-selected="true">@lang('app.activities')</a>
						</li>
						
					</ul>
					<div class="tab-content" id="myTabContent1">
						{{-- Comments --}}
						<div class="tab-pane pt-3 fade  {{(isset($tab) and $tab == 'comments') ? 'show active' : ''}}" id="comments" role="tabpanel" aria-labelledby="comments-tab">
							<div class="operation clearfix">
								<a href="javascript::void(0)" class="btn btn-outline-primary btn-sm text-uppercase" id="add-comment" data-toggle="modal" data-target="#updateComment" data-appointment="{{$appointment->id}}" >
									<i class=" mdi mdi-plus-ciryle-outline"></i> @lang('user.create_comment')
								</a>
								
							</div>
							<div class="comments">
								@foreach($appointment->comments as $item)
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
									@foreach($appointment->activities as $activity)
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
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">@lang('app.deletion')</h5>
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

	{{-- Update Status --}}
	<div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="updateStatusLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateStatusLabel">@lang('appointment.update_status')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="row">
							<div class="col-sm-12">
								<label>@lang('app.entry_status')</label>
								<select class="select2 form-control status" name="status" >
									<option value="1">@lang('appointment.pending')</option>
									<option value="2">@lang('appointment.finished')</option>
									<option value="0">@lang('appointment.canceled')</option>
									{{-- <option value="1">@lang('appointment.pending')</option> --}}
								</select>
							</div>
							<div class="col-sm-12">
								<label >@lang('app.entry_note')</label>
								<textarea class="form-control note" name="note" rows="4">{{$appointment->note != null ? $appointment->note : ''}}</textarea>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">@lang('app.cancel')</button>
					<button type="button" data-dismiss="modal" data-url="" class="btn btn-primary btn-pill sure-save" >@lang('app.save')</button>
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
				<button type="button" data-dismiss="modal" data-url="" data-id="0" data-action="create" class="btn btn-primary btn-pill save-data" >@lang('app.save')</button>
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
	var appointments = null;

	jQuery(document).ready(function() {
		var urlDelete = '';
		var itemId = 0;
	   var appointmentTable = jQuery('#responsive-data-table').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		'order' : [[1, 'desc']],
	    'language': datatableLanguage
	   });
	   var permissions = jQuery('#responsive-data-table1').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		// 'order' : [[1, 'desc']],
	    'language': datatableLanguage
	   });
	
	   var type = 'else';
	   //getappointment(appointmentTable);
	   $('.card-body').on('click' , 'a.delete-item',function(e){
	   		e.preventDefault();
	   		var button = $(this);
	   		// var url = $(this).attr('href');
	   		type = button.data('type');
	   		// urlDelete = url;
	   		itemId = button.data('id');
	   });
	
	//    update status and note
	   $('#update-status').on('click' , function(){
		   var tag = $(this);
		   var id = {{$appointment->id}};
			var modelUpdate = $('#updateStatus');
			modelUpdate.find('select.status').val(tag.data('status'));
			modelUpdate.find('select.status').trigger('change');
	   });

	   $('#updateStatus').on('click' , '.sure-save' , function(){
		   var data = getFormData('#updateStatus .form-control');
		   data['_method'] = 'PUT';
		   $.ajax({
			   url : "{{route('api.appointment.update' , $appointment->id)}}",
			   method: 'post',
			   headers : header,
			   data: data,
			   success: function(json){
				   toastr.success(json.message , "@lang('appointment.edit_appointment')");
				   window.location.replace('{{route("appointment.show" , $appointment->id)}}');
			   },
			   error: function(xhr){
					handlingAjaxError(xhr);
			   }
		   });
	   });
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
			var url = "{{route('api.appointment.comment.store' , $appointment->id)}}/"+thisTag.data('id');
		}else{
			var url = "{{route('api.appointment.comment.store' , $appointment->id)}}";
		}
		$.ajax({
			url  : url,
			method : 'post',
			headers : header,
			data: dataForm,
			success: function(json){
				console.log(json);
				toastr.success(json.message , "@lang('app.comment')")
				window.location.replace('{{route("appointment.show" , $appointment->id)}}');
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
			url : "{{route('api.appointment.show' , $appointment->id)}}/comment/"+ tag.data('id'),
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