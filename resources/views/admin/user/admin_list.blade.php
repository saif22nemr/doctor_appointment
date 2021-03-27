<?php $title = ['user' , 'admin'];?>
@extends('admin.layouts.app')
@section('title' )
	@lang('app.admins')
@endsection
@section('content')

<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.employees')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>
            </li>
            
            <li class="breadcrumb-item active" aria-current="page">@lang('app.employees')</li>
          </ol>
        </nav>
  </div>
  
</div>
	<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>@lang('user.admin_list')</h2>
					<div class="operation">
						<a href="{{route('employee.create')}}" class="btn btn-outline-primary btn-sm text-uppercase">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('user.create_employee')
						</a>
						<a href="{{route('admin.create')}}" class="btn btn-outline-primary btn-sm text-uppercase">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('user.create_admin')
						</a>
						
					</div>
					
				</div>

				<div class="card-body">
					<div class="responsive-data-table">
						<table id="responsive-data-table" class="table even-odd dt-responsive dataTable no-footer dtr-inline collapsed " style="width:100%">
							<thead>
								<tr >
									
									<th>@lang('app.entry_name')</th>
									<th>@lang('app.entry_username')</th>
									<th>@lang('app.entry_phone')</th>
									<th>@lang('app.branch')</th>
									<th>@lang('app.entry_type')</th>
									<th>@lang('app.entry_status')</th>
									<th>@lang('app.entry_created_at')</th>
									<th>@lang('app.entry_action')</th>
								</tr>
							</thead>

							<tbody>
								@if(isset($admins))
							@foreach($admins as $admin)									
							<tr >
								<td><a href="{{$admin->group == 1 ? route('admin.show' , $admin) : route('employee.show' , $admin->id)}}">{{$admin->name}}</a></td>
								<td>{{$admin->username}}</td>
								<td>
									@foreach($admin->phones as $phone)
										{{-- @if($phone->primary == 1) --}}
											<p>{{$phone->number}}</p>
										{{-- @endif --}}
									@endforeach
								</td>
								<td>
									<a href="{{route('branch.show' , $admin->branch->id)}}" title="@lang('app.entry_address') : {{$admin->branch->address}}">{{$admin->branch->name}}</a>
								</td>
								<td>
									@if($admin->group == 1)
										<span class="badge badge-success">@lang('app.admin')</span>
									@else
									<span class="badge badge-primary">@lang('app.employee')</span>
									@endif
								</td>
								<td>
									@if($admin->status == 1)
										<span class="badge badge-success">@lang('app.open')</span>
									@else
										<span class="badge badge-danger">@lang('app.close')</span>
									@endif
								</td>
							<td data-sort="{{$admin->created_at}}">{{date('Y-m-d' , strtotime($admin->created_at))}}</td>
								<td>
									<div class="dropdown show d-inline-block widget-dropdown" id="{{$admin->id}}"><a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a><ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1"><li class="dropdown-item"><a href="{{ $admin->group == 1 ? route('admin.edit' , $admin->id) : route('employee.edit' , $admin->id)}}">@lang("app.edit")</a></li><li class="dropdown-item"><a href="javascript::void(0)" class="delete-item" data-toggle="modal" data-target="#exampleModal" data-id="{{$admin->id}}" data-group="{{$admin->group}}" >@lang("app.delete")</a></li></ul></div>
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
	var admins = null;
	

	;
	jQuery(document).ready(function() {
		var urlDelete = '';
		var itemId = 0;
		var group = 1;
	   var adminTable = jQuery('#responsive-data-table').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		// 'order'	: [[7, 'desc']],
	    'language': datatableLanguage
	   });
	   //getadmin(adminTable);
	   $('.card-body').on('click' , 'a.delete-item',function(e){
	   		e.preventDefault();
	   		var button = $(this);
	   		// var url = $(this).attr('href');
	   		
	   		// urlDelete = url;
	   		itemId = button.data('id');
			group = button.data('group');
	   });
	   $('.sure-delete').on('click', function(){
		   if(group == 1)
	   			deleteItem("{{url('api')}}/admin", itemId);
			else
				deleteItem("{{url('api')}}/employee", itemId);
	   });
  });
</script>
@endsection