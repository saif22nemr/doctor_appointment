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