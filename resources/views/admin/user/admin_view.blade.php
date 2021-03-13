<?php $title = ['user' , 'admin'];?>
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
				  @lang('user.admin_list')
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
					
						{{-- <a href="javascript::void(0)" class="btn btn-outline-primary btn-sm text-uppercase" id="end-admin">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('admin.end_admin')
						</a> --}}
					</div>
					
				</div>

				<div class="card-body">
					<div class="row admin-data">
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_name')</h4>
						<p>{{$admin->name}}</p>
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
						<p>{{date('Y-m-d H:i A' , strtotime($admin->created_at))}}</p>
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

{{-- admin Result --}}
<div class="modal fade" id="adminResult" tabindex="-1" role="dialog" aria-labelledby="adminResult" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title " id="adminResult">@lang('admin.semester_result')</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{{-- content --}}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">@lang('app.cancel')</button>
				{{-- <button type="button" class="btn btn-primary btn-pill">Save Changes</button> --}}
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
	//    Student payment and sending emails
	   $('.student-payment').on('click' , function(){
		   var button = $(this);
		   $.ajax({
			   url : "{{url('api/'.$lang.'/admin/'.$admin->id.'/payment')}}/"+button.data('id')+'/send',
			   method: 'post',
			   headers : header,
			   success: function(json){
				   toastr.success(json.message , "@lang('app.payments')");
			   },error:function(xhr){
				   console.log(xhr);
				   handlingAjaxError(xhr);
			   }
		   });
	   });
	//    end admin
	   $('#end-admin').on('click' , function(){
		   var button = $(this);
		   $.ajax({
			   url : "{{url('api/'.$lang.'/admin/'.$admin->id.'/finish')}}",
			   method: 'get',
			   headers : header,
			   success: function(json){
				   toastr.success(json.message , "@lang('app.admin')");
			   },error:function(xhr){
				   console.log(xhr);
				   handlingAjaxError(xhr);
			   }
		   });
	   });
	   var lang = "{{$lang}}";
	//    show result
	   $('.responsive-data-table').on('click' , '.show-result' , function(){
		   var thisTag = $(this);
		   console.log('student|: '+ thisTag.data('id'));
		   $.ajax({
			   url: "{{url('api/'.$lang.'/admin/'.$admin->id.'/student')}}/"+thisTag.data('id')+'/result',
			   method: 'get',
			   headers : header,
			   success: function(json){
				   console.log(json);
				   var courses = json.courses;
				   var student = json.student;
				//    console.log(json);
				var totalDegree = 0;
				var totalMaxDegree = 0;
				var content = '';
				content += '<h3 class="mt-2 mb-4 text-center">'+student.info.name+'</h3>';
				   content += '<table class="table">';
					content += '<thead>'
						content += '<th>@lang("app.course")</th>';
						content += '<th>@lang("app.degree")</th>';
						content += '<th>@lang("app.entry_max_degree")</th>';
						content += '<th>@lang("app.entry_status")</th>';
					content += '</thead>';
					content += '<tbody>';
					
						$.each(courses , function(key , course){
							// console.log(course);
							totalDegree += course.final_degree;
							totalMaxDegree += course.max_degree;
							content += '<tr>';
								content += '<td>'
								if(lang == 'en') content += course.title_en;
								else content += course.title;
								content += '</td>';
								content += '<td>'+course.final_degree+'</td>';
								content += '<td>'+course.max_degree+'</td>';
								content += '<td>'
									if(course.success == 1) 
										content += '<span class="badge badge-success">@lang("app.status_success")</span>';
									else 
									content += '<span class="badge badge-danger">@lang("app.status_fail")</span>';
								content += '</td>';
							content += '</tr>';
						});
						// content += '<tr class="last-row">';
						// 	content += '<td >@lang("app.result")</td>';
						// 	content += '<td>'+totalDegree+'</td>';
						// 	content += '<td>'+totalMaxDegree+'</td>';
						// 	content +="<td></td>";
						// content += '</tr>';
					content += '</tbody>';
				   content += '</table>';
				   $('#adminResult .modal-body').html(content);
				   
			   },
			   error: function(xhr){
				   handlingAjaxError(xhr);
				   console.log(xhr);
			   }
		   });
	   });
  });
</script>
@endsection