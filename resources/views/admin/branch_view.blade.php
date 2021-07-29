<?php $title = ['branch' , 'branch'];?>
@extends('admin.layouts.app')
@section('title' )
	@lang('app.branch')
@endsection
@section('content')
<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.branch')</h1>
    
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
            
            <li class="breadcrumb-item active" aria-current="page">@lang('app.show')</li>
          </ol>
        </nav>
  </div>
  
</div>
	<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>@lang('app.branch')</h2>
					{{-- <div class="operation">
					
						<a href="javascript::void(0)" class="btn btn-outline-primary btn-sm text-uppercase" data-toggle="modal" data-target="#updatePhones" id="update-phones">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('user.update_phones')
						</a>
					</div> --}}
					
				</div>

				<div class="card-body">
					<div class="row branch-data">
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_name')</h4>
						<p>{{$branch->name}}</p>
						</div>
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_address')</h4>
						<p>{{$branch->address}}</p>
						</div>
						
						<div class="col-sm-4 mb-3">
							<h4>@lang('app.entry_created_at')</h4>
						<p>{{date('Y-m-d h:i A' , strtotime($branch->created_at))}}</p>
						</div>
					</div>
					{{-- Tabs --}}
					<ul class="nav nav-tabs mt-6" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="activities-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="activities" aria-selected="true">@lang('app.activities')</a>
						</li>
					
					
					</ul>
					<div class="tab-content" id="myTabContent1">
						{{-- Activities --}}
						<div class="tab-pane pt-3 fade show  active" id="activities" role="tabpanel" aria-labelledby="activities-tab">
						
							<div class="responsive-data-table">
								<table id="responsive-data-table" class="table even-odd dt-responsive dataTable no-footer dtr-inline collapsed " style="width:100%">
									<thead>
										<tr>
											<th>@lang('app.entry_description')</th>
											<th>@lang('app.entry_created_at')</th>
										</tr>
									</thead>

									<tbody>
									@foreach($branch->activities as $activity)
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




@endsection


@section('js')
<script src="{{asset('assets/plugins/data-tables/jquery.datatables.min.js')}}"></script>
<script src="{{asset('assets/plugins/data-tables/datatables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/data-tables/datatables.responsive.min.js')}}"></script>

<script type="text/javascript">
	var branches = null;

	jQuery(document).ready(function() {
		var urlDelete = '';
		var itemId = 0;
	   var branchTable = jQuery('#responsive-data-table').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		// 'order' : [[1, 'desc']],
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
	   //getbranch(branchTable);
	   $('.card-body').on('click' , 'a.delete-item',function(e){
	   		e.preventDefault();
	   		var button = $(this);
	   		// var url = $(this).attr('href');
	   		type = button.data('type');
	   		// urlDelete = url;
	   		itemId = button.data('id');
	   });
	   $('.sure-delete').on('click', function(){
		   if(type == 'payment') var url = "{{url('api/'.$lang.'/branch/'.$branch->id.'/payment')}}";
		   else var url = "{{url('api/'.$lang.'/branch/'.$branch->id.'/semester')}}";
		 
	   		deleteItem(url, itemId);
	   });
	

  });
</script>
@endsection