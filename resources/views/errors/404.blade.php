@extends('layouts.default')

@section('content')	

	<div class="max-container padd1">

		<div class="not-found-conten" style="padding: 200px 20px;">
			
			<h2 class="title" style="margin:0; text-align: center;">
				@if(isset($err_code) && $err_code == 500) 
					< {{ trans('content.general.page_not_found') }} >
				@else
					{{ trans('content.general.page_not_found') }}
				@endif
			</h2>

		  	<div class="text-xs-center  marg-top-50">
		  		@if(isset($err_code) && $err_code == 500)
		  			<a href="{{ $baseUrlLang }}" class="btn btn-outline-primary btn-bigger text-uppercase"><b>< {{ trans('content.general.back_to_home') }} ></b></a>
		  		@else
		  			<a href="{{ $baseUrlLang }}" class="btn btn-outline-primary btn-bigger text-uppercase"><b>{{ trans('content.general.back_to_home') }}</b></a>
		  		@endif
		  	</div>

		</div>

	</div>


@stop