@extends('layouts.dashboard')

@section('content')	
    <div layout="column" flex id="content">
    	<md-content class="main-content" ng-view layout="column" flex class="md-padding" style="overflow-y: auto;">
    	</md-content>
    </div>
	
@stop