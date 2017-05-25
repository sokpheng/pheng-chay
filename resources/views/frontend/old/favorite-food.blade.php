@extends('layouts.default')

@section('content')	

	<div class="max-container padding-section big-padding marg-top-50" ng-controller="favoriteCtrl">

		<div class="feedback-frm-container text-xs-center marg-top-30">

			<h3 class="title">{{ trans('content.general.what_your_favorite_food') }}</h3>

			<span ng-init="favorite_item = {{ json_encode($dimensions) }}"></span>

			<div class="favorite-tag marg-top-30">
				<ul class="clearUL" ng-cloak>
					{{-- @foreach($dimensions as $key => $_cateItem) --}}
						<li ng-class="{ 'active' : item.selected }" ng-repeat="(key, item) in favorite_item"><button class="tag tag-default" ng-click="makeAsFavorite(item)"><% item.display_name %></button></li>
					{{-- @endforeach --}}
				</ul>
			</div>

			<div style="max-width: 600px; margin: auto;">
				<br>
				<div class="alert alert-success _opacityLoading" role="alert" style="position: relative; background-color: transparent;border: none;">
					<div class="msg _loadingText" ng-class="{'isSuccess': isSuccess}">
						{!! trans('content.general.msg_favorite_food_update') !!}
					</div>
					<div class="loading" ng-class="{'isLoading': isLoading}"><img class="center-absolute _loading-icon size-sm" src="{{ asset('img/svg/loading/loading-spin.svg') }}" alt="login loading"></div>
				</div>
			</div>

		  	<div class="text-xs-center  marg-top-50">
		  		<a href="{{ $baseUrlLang }}" class="btn btn-outline-primary btn-bigger text-uppercase"><b>{{ trans('content.general.back_to_home') }}</b></a>
		  	</div>

		</div>

	</div>


@stop