<?php $title = ['setting' , 'application'];?>
@extends('admin.layouts.app')
@section('title' )
	@lang('app.application')
@endsection
@section('content')

<div class="breadcrumb-wrapper breadcrumb-contacts">
  <div>
    <h1>@lang('app.application')</h1>
    
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard.index')}}">
                <span class="mdi mdi-home"></span> @lang('app.dashboard')
              </a>
            </li>
            
            <li class="breadcrumb-item active" aria-current="page">@lang('app.application')</li>
          </ol>
        </nav>
  </div>
  
</div>
	<div class="row">
		<div class="col-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom d-flex justify-content-between">
					<h2>@lang('app.question_list')</h2>
					<div class="operation">
						<a href="{{route('setting.application.create')}}" class="btn btn-outline-primary btn-sm text-uppercase">
							<i class=" mdi mdi-plus-circle-outline"></i> @lang('app.create_new')
						</a>
					</div>
					
				</div>

				<div class="card-body">
					<div class="question-list">
					@foreach($questions as $question)
						@if($question->answer_type == 2 or $question->answer_type == 3)
							<div class=" question card">
								<div class="card-header">
									<a href="{{route('setting.application.edit' , $question->id)}}" class="text-bold question">{{$question->question}}</a>
									@if($question->answer_type == 2)
										<span class="question-type badge badge-primary">@lang('setting.checkbox')</span>
									@elseif($question->answer_type == 3)
										<span class="question-type badge badge-success">@lang('setting.selectbox')</span>
									@endif
								</div>
								<div class="card-body">
									{{-- <h4 class="text-bold mb-4">@lang('setting.chooses')</h4> --}}
									<div class="row">
										@foreach($question->chooses as $choose)
											<div class="col-md-3 col-sm-4">
												<span >- {{$choose->choose}}</span>
											</div>
										@endforeach
									</div>
								</div>
							</div>
						@else 
							<div class="question card">
								<div class="card-header">
									<a href="{{route('setting.application.edit' , $question->id)}}" class="text-bold question">{{$question->question}}</a>
									@if($question->answer_type == 1)
										<span class="question-type badge badge-secondary">@lang('setting.text')</span>
									@elseif($question->answer_type == 4)
										<span class="question-type badge badge-danger">@lang('setting.textarea')</span>
									@endif
								</div>
								{{-- <div class="card-body"></div> --}}
							</div>
						@endif
					@endforeach

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
	var questions = null;
	

	;
	jQuery(document).ready(function() {
		var urlDelete = '';
		var itemId = 0;
		var group = 1;
	   var questionTable = jQuery('#responsive-data-table').DataTable({
	    "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
	    "pageLength": 20,
		"dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
		// 'order'	: [[7, 'desc']],
	    'language': datatableLanguage
	   });
	   //getquestion(questionTable);
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
	   			deleteItem("{{url('api')}}/question", itemId);
			else
				deleteItem("{{url('api')}}/employee", itemId);
	   });
  });
</script>
@endsection