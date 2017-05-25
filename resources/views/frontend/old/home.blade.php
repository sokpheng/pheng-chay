@extends('layouts.default')

@section('content')	

	<div ng-controller1="cambodroom">
	
		@include("includes.elements.section.main-booking", array('is_home'=>true))

		@include("includes.elements.section.top-destination")

	</div>

@stop


@section('scripts')


@stop
