<?php $title = ['user' , 'patient'];?>
@extends('admin.layouts.app')
@section('title' )
	@lang('app.patients')
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
            
            <li class="breadcrumb-item active" aria-current="page">@lang('app.patients')</li>
          </ol>
        </nav>
  </div>
  
</div>
	<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>@lang('user.patient_list')</h2>
					<div class="operation">
						<a href="{{route('patient.create')}}" class="btn btn-outline-primary btn-sm text-uppercase">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('app.create_new')
						</a>
					</div>
					
				</div>

				<div class="card-body">
					<div class="responsive-data-table">
						<table id="responsive-data-table" class="table even-odd dt-responsive dataTable no-footer dtr-inline collapsed " style="width:100%">
							<thead>
								<tr >
									
									<th>@lang('app.entry_name')</th>
									<th>@lang('app.entry_id')</th>
									<th>@lang('app.entry_address')</th>
									<th>@lang('app.entry_job')</th>
									<th>@lang('app.entry_social_status')</th>
									{{-- <th>@lang('app.entry_sex')</th> --}}
									{{-- <th>@lang('app.entry_nationality')</th> --}}
									<th>@lang('app.age')</th>
									<th>@lang('app.entry_birthday')</th>
									<th>@lang('app.entry_created_at')</th>
									<th>@lang('app.entry_action')</th>
								</tr>
							</thead>

							<tbody>
								@if(isset($patients))
							@foreach($patients as $patient)									
							<tr class="{{$patient->user->status == 0 ? 'background-danger' : ''}}">
								<td><a href="{{route('patient.show' , $patient)}}">{{$patient->user->name}}</a></td>
								<td>{{$patient->id}}</td>
								<td>{{$patient->address}}</td>
								<td>{{$patient->job}}</td>
								<td>
									@if($patient->social_status == 0)
										<span class="badge badge-primary">@lang('app.single')</span>
									@else
									<span class="badge badge-success">@lang('app.married')</span>
									@endif
								</td>
								{{-- <td>
									@if($patient->sex == 0)
										<span class="badge badge-primary">@lang('app.female')</span>
									@else
									<span class="badge badge-success">@lang('app.male')</span>
									@endif
								</td> --}}
							{{-- <td>{{$patient->nationality}}</td>	 --}}
							<td>{{$patient->age}}</td>
							<td>{{$patient->birthday}}</td>
							<td data-sort="{{$patient->created_at}}">{{date('Y-m-d' , strtotime($patient->created_at))}}</td>
								<td>
									<div class="dropdown show d-inline-block widget-dropdown" id="{{$patient->id}}"><a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a><ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1"><li class="dropdown-item"><a href="{{route('patient.edit' , $patient->id)}}">@lang("app.edit")</a></li><li class="dropdown-item"><a href="javascript::void(0)" class="delete-item" data-toggle="modal" data-target="#exampleModal" data-id="{{$patient->id}}" >@lang("app.delete")</a></li></ul></div>
								</td>
							</tr>
							@endforeach
							{{-- test --}}
							@endif
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
	var patients = null;
	

	;
	jQuery(document).ready(function() {
		var urlDelete = '';
		var itemId = 0;
	   var patientTable = jQuery('#responsive-data-table').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		'order'	: [[7, 'desc']],
	    'language': datatableLanguage
	   });
	   //getpatient(patientTable);
	   $('.card-body').on('click' , 'a.delete-item',function(e){
	   		e.preventDefault();
	   		var button = $(this);
	   		// var url = $(this).attr('href');
	   		
	   		// urlDelete = url;
	   		itemId = button.data('id');
	   });
	   $('.sure-delete').on('click', function(){
	   		deleteItem("{{url('api')}}/patient", itemId);
	   });
  });
</script>
@endsection