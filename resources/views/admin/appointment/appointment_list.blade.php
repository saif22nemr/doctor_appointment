<?php $title = ['appointment' , $status];?>
@extends('admin.layouts.app')
@section('title' )
	@lang('app.appointments')
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
            
            <li class="breadcrumb-item active" aria-current="page">@lang('app.appointments')</li>
          </ol>
        </nav>
  </div>
  
</div>
	<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>@lang('appointment.appointment_list_'.$status)</h2>
					<div class="operation">
						<a href="{{route('appointment.create')}}" class="btn btn-outline-primary btn-sm text-uppercase">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('app.create_new')
						</a>
					</div>
					
				</div>

				<div class="card-body">
					<div class="responsive-data-table">
						<table id="responsive-data-table" class="table even-odd dt-responsive dataTable no-footer dtr-inline collapsed " style="width:100%">
							<thead>
								<tr >
									
									<th>@lang('app.entry_id')</th>
									<th>@lang('app.entry_title')</th>
									<th>@lang('app.patient')</th>
									<th>@lang('app.entry_date')</th>
									<th>@lang('app.entry_time')</th>
									@if($status == 'all')
									<th>@lang('app.entry_status')</th>
									@endif
									<th>@lang('app.entry_created_at')</th>
									<th>@lang('app.entry_action')</th>
								</tr>
							</thead>

							<tbody>
								{{-- @foreach($appointments as $appointment)
									<tr>
										<td>{{$appointment->id}}</td>
										<td>
											<a href="{{route('appointment.show' , $appointment->id)}}">{{$appointment->title}}</a>
										</td>
										<td>
											<a href="{{route('patient.show' , $appointment->patient_id)}}">{{$appointment->patient->user->name}}</a>
										</td>

										<td>
											{{$appointment->date}}
										</td>
										<td>{{date('h:i A' , strtotime($appointment->time))}}</td>
										@if($status == 'all')
										<td>
											@if($appointment->status == 1)
												<span class="badge badge-primary">@lang('appointment.pending')</span>
											@elseif($appointment->status == 2)
												<span class="badge badge-success">@lang('appointment.finished')</span>
											@elseif($appointment->status == 3)
												<span class="badge badge-success">@lang('appointment.finished')</span>

											@elseif($appointment->status == 4)
												<span class="badge badge-warning">@lang('appointment.request_appointment')</span>
											@else 
												<span class="badge badge-danger">@lang('appointment.canceled')</span>
											@endif
										</td>
										@endif
										<td>{{date('Y-m-d h:i A' , strtotime($appointment->created_at))}}</td>
										<td>
											<div class="dropdown show d-inline-block widget-dropdown" id="{{$appointment->id}}"><a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a><ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1"><li class="dropdown-item"><a href="{{  route('appointment.edit' , $appointment->id)}}">@lang("app.edit")</a></li><li class="dropdown-item"><a href="javascript::void(0)" class="delete-item" data-toggle="modal" data-target="#exampleModal" data-id="{{$appointment->id}}"  >@lang("app.delete")</a></li></ul></div>
										</td>
									</tr>
								@endforeach  --}}
							</tbody>
						</table>
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
@endsection


@section('js')
<script src="{{asset('assets/plugins/data-tables/jquery.datatables.min.js')}}"></script>
<script src="{{asset('assets/plugins/data-tables/datatables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/data-tables/datatables.responsive.min.js')}}"></script>

<script type="text/javascript">
	var appointments = null;
	

	;
	jQuery(document).ready(function() {
		var urlDelete = '';
		var itemId = 0;
		var appointmentTable = jQuery('#responsive-data-table').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		'order'	: [[{{$status == 'all' ? 6 : 5}}, 'desc']],
		'ajax' :{
			'url' :  "{{route('api.appointment.index')}}?status={{$status}}&datatable=1",
			'headers' : header,
		},
		"deferRender": true,
		'columns' : [
			{'data' : 'id'},
			{'data' : 'title_tag'},
			{'data' : 'patient_tag'},
			{'data' : 'date'},
			{'data' : 'time_tag'},
			@if($status == 'all')
			{'data' : 'status_tag'},
			@endif
			// {'data' : 'created_data.string' , 'sort' : 'created_date'},
			{'data' : {
				'_':  "created_date.string",
				'sort' : 'created_date.timestamp'
			} },
			{'data' : 'action'},
	   ],
	    'language': datatableLanguage
	   });

	@if($today)
	   appointmentTable.column(3).search("{{date('Y-m-d')}}").draw();

	   @endif
	   //getappointment(appointmentTable);
	   $('.card-body').on('click' , 'a.delete-item',function(e){
	   		e.preventDefault();
	   		var button = $(this);
	   		// var url = $(this).attr('href');
	   		
	   		// urlDelete = url;
	   		itemId = button.data('id');
	   });
	   $('.sure-delete').on('click', function(){
	   		deleteItem("{{url('api')}}/appointment", itemId);
	   });
  });
</script>
@endsection