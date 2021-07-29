<?php $title = ['employee' , 'admin'];?>
@extends('admin.layouts.app')
@section('title' )
	@lang('app.admin')
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.admin')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{route('admin.index')}}">
				  @lang('app.admins')
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
					<h2>@lang('app.admin')</h2>
					<div class="operation">
					
						<a href="javascript::void(0)" class="btn btn-outline-primary btn-sm text-uppercase" data-toggle="modal" data-target="#updatePhones" id="update-phones">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('user.update_phones')
						</a>
					</div>
					
				</div>

				<div class="card-body">
					<div class="row admin-data">
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_name')</h4>
						<p>{{$admin->name}}</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_username')</h4>
						<p>{{$admin->username}}</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_phone')</h4>
							@foreach($admin->phones as $phone)
								<p class="{{$phone->primary == 1 ? 'text-bold' : ''}}">{{$phone->number}}</p>
							@endforeach
						</div>
						@if($admin->email)
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_email')</h4>
						<p>{{$admin->email}}</p>
						</div>
						@endif
						
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_status')</h4>
						<p>
							@if($admin->status == 0)
								<span class="badge badge-danger">@lang('app.no')</span>
							@else 
								<span class="badge badge-success">@lang('app.yes')</span>
							@endif
						</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_created_at')</h4>
						<p>{{date('Y-m-d h:i A' , strtotime($admin->created_at))}}</p>
						</div>
					</div>
					{{-- Tabs --}}
					<ul class="nav nav-tabs mt-6" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link {{(isset($tab) and $tab == 'activities') ? 'active' : ''}}" id="activities-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="activities" aria-selected="true">@lang('app.activities')</a>
						</li>
					
					</ul>
					<div class="tab-content" id="myTabContent1">
						{{-- Application --}}
						<div class="tab-pane pt-3 fade  {{(isset($tab) and $tab == 'activities') ? 'show active' : ''}}" id="activities" role="tabpanel" aria-labelledby="activities-tab">
						
							{{-- Semester List --}}
							<div class="responsive-data-table">
								<table id="responsive-data-table" class="table even-odd dt-responsive dataTable no-footer dtr-inline collapsed " style="width:100%">
									<thead>
										<tr>
											<th>@lang('app.entry_description')</th>
											<th>@lang('app.entry_created_at')</th>
										</tr>
									</thead>

									<tbody>
									@foreach($admin->activities as $activity)
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
					@foreach($admin->phones as $key => $phone)
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
	var admins = null;

	jQuery(document).ready(function() {
		var urlDelete = '';
		var itemId = 0;
		var phoneCount = {{count($admin->phones)}};
	   var adminTable = jQuery('#responsive-data-table').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		'order' : [[1, 'desc']],
	    'language': datatableLanguage
	   });
	
	   var type = 'else';
	   //getadmin(adminTable);
	   $('.card-body').on('click' , 'a.delete-item',function(e){
	   		e.preventDefault();
	   		var button = $(this);
	   		// var url = $(this).attr('href');
	   		type = button.data('type');
	   		// urlDelete = url;
	   		itemId = button.data('id');
	   });
	   $('.sure-delete').on('click', function(){
		   if(type == 'payment') var url = "{{url('api/'.$lang.'/admin/'.$admin->id.'/payment')}}";
		   else var url = "{{url('api/'.$lang.'/admin/'.$admin->id.'/semester')}}";
		 
	   		deleteItem(url, itemId);
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
			   url : "{{route('api.admin.phone.update' , $admin->id)}}",
			   method: 'post',
			   headers : header,
			   data: formData,
			   success: function(json){
				   toastr.success(json.message , "@lang('app.admin')");
			   },error:function(xhr){
				   console.log(xhr);
				   handlingAjaxError(xhr);
			   }
		   });
	   });
	   
  });
</script>
@endsection