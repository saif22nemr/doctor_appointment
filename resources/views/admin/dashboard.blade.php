<?php $title = ['dashboard']?>
@extends('admin.layouts.app')

@section('title' , trans('app.dashboard'))

@section('content')
<div class="row my-widget">
	<div class="col-md-6 col-lg-6 col-xl-3">
		<a class="card widget-block p-4 rounded bg-primary border" href="{{$count['appointment']['wait_today']['link']}}">
			<div class="card-block">
				<i class="mdi mdi-doctor mr-4 text-white"></i>
				<h4 class="text-white my-2">{{$count['appointment']['wait_today']['count']}}</h4>
				<p>@lang('dashboard.count.appointment_wait_today')</p>
			</div>
		</a>
	</div>
	<div class="col-md-6 col-lg-6 col-xl-3">
		<a href="{{$count['appointment']['wait']['link']}}" class="card widget-block p-4 rounded bg-warning border">
			<div class="card-block">
				<i class="mdi mdi-doctor mr-4 text-white"></i>
				<h4 class="text-white my-2">{{$count['appointment']['wait']['count']}}</h4>
				<p>@lang('dashboard.count.appointment_wait')</p>
			</div>
		</a>
	</div>
	<div class="col-md-6 col-lg-6 col-xl-3">
		<a href="{{$count['appointment']['complete']['link']}}" class="card widget-block p-4 rounded bg-danger border">
			<div class="card-block">
				<i class="mdi mdi-doctor  mr-4 text-white"></i>
				<h4 class="text-white my-2">{{$count['appointment']['complete']['count']}}</h4>
				<p>@lang('dashboard.count.appointment_complete')</p>
			</div>
		</a>
	</div>
	<div class="col-md-6 col-lg-6 col-xl-3">
		<a href="{{$count['appointment']['all']['link']}}" class="card widget-block p-4 rounded bg-success border">
			<div class="card-block">
				<i class="mdi mdi-doctor t mr-4 text-white"></i>
				<h4 class="text-white my-2">{{$count['appointment']['all']['count']}}</h4>
				<p>@lang('dashboard.count.appointment_all')</p>
			</div>
		</a>
	</div>
</div>
<div class="row my-widget">
	<div class="col-md-6 col-lg-6 col-xl-3">
		<div class="media widget-media p-4 bg-white border">
			<i class="mdi mdi-account-outline text-blue mr-4"></i>
			<div class="media-body align-self-center">
				<h4 class="text-primary mb-2">{{$count['patient']['count']}}</h4>
				<p>@lang('dashboard.count.patient')</p>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg-6 col-xl-3">
		<div class="media widget-media p-4 rounded bg-white border">
			<i class="mdi mdi-cart-outline text-warning mr-4"></i>
			<div class="media-body align-self-center">
				<h4 class="text-primary mb-2">{{$count['admin']['count']}}</h4>
				<p>@lang('dashboard.count.admin')</p>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg-6 col-xl-3">
		<div class="media widget-media p-4 rounded bg-white border">
			<i class="mdi mdi-cart-outline text-danger mr-4"></i>
			<div class="media-body align-self-center">
				<h4 class="text-primary mb-2">{{$count['employee']['count']}}</h4>
				<p>{{trans('dashboard.count.employee')}}</p>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg-6 col-xl-3">
		<div class="media widget-media p-4 rounded bg-white border">
			<i class="mdi mdi-diamond text-success mr-4"></i>
			<div class="media-body align-self-center">
				<h4 class="text-primary mb-2">{{$count['branch']['count']}}</h4>
				<p>@lang('dashboard.count.branch')</p>
			</div>
		</div>
	</div>
</div>

@endsection