@extends('layouts.default-map')

@section('content')	
<ng-view></ng-view>
	<div class="restaurant-map"  ng-controller="restMapCtrl">

		{{-- ------------- MAP ------------ --}}
		<div class="_map full-map">

			{{-- <span ng-init="restMaps='{{ base64_encode(json_encode($restuarntList)) }}'"></span> --}}

			<ui-gmap-google-map center='map.center' zoom='map.zoom' draggable="true" options="map.options" events="map.events" control="map.control">
				{{-- <ui-gmap-marker coords="marker.coords" options="marker.options" events="marker.events" idkey="marker.id"></ui-gmap-marker> --}}

				<ui-gmap-marker models1="directoriesMap" 

						coords="markerItem.coords" options="markerItem.options"
						fit="false"
						icon="markerItem.options.icon" 
						events="markerItem.events" idkey="markerItem.id" clusterOptions1="map.clusterOptions" 
						doCluster1="map.doClusterRandomMarkers" ng-repeat="(key, markerItem) in markers">

						<ui-gmap-window options="markerItem.windowOptions" closeClick="closeClick()" show="markerItem.show">

							<div class="info-box" ng-cloak>

								<div class="media" ng-init="_img = hhModule.getRestCover(markerItem);">
								  	<a class="media-left <% _img.bg_cls %>" href="{{ $baseUrlLang }}/restaurant/<% hhModule.getRestDetail(markerItem) %>" style="background-image: url(<% _img.src %>)">
								    	{{-- <img ng-show="_img.bg_cls != 'bg-normal'" class="media-object" ng-src="<% _img.src %>" alt="<% markerItem.directory_name %>"> --}}
								  	</a>
								  	<div class="media-body">
								    	<h6 class="media-heading text-overflow">
									    	<a href="{{ $baseUrlLang }}/restaurant/<% hhModule.getRestDetail(markerItem) %>" title="<% markerItem.directory_name %>">
									    		<% markerItem.directory_name %>
									    	</a>
								    	</h6>
								    	<h6 class="sub_title">
								    		{{-- <span class="_location">Phnom Penh</span> --}}
								    		<span class="_price text-primary-col"><b><% hhModule.getDollarSimbol(markerItem.price_rate) %><b></span>
								    		<span class="near_by_val float-xs-right"><b><% hhModule.formatDistance(markerItem.distance) %></b></span>
								    	</h6>
								   	<p class="_desc text-overflow"><% markerItem.address %></p>
								  	</div>
								</div>

							</div>
		            </ui-gmap-window>


				</ui-gmap-marker>

				{{-- 				<ui-gmap-window options="marker.windowOptions" closeClick1="closeClick()" coords1="'self'" 
									coords="markerItem.coords" show="markerItem.show"  templateUrl1="language == 'kh' ? '/kh/template-maps/windows' : '/template-maps/windows'"
									templateParameter1="itemMarker"
									ng-repeat="(key, markerItem) in markers" > --}}
								
				         	{{-- </ui-gmap-window> --}}

			</ui-gmap-google-map>

			<button class="btn btn-outline-primary1" ng-cloak ng-class="{'isShowing':showList}" ng-click="showList=!showList" ng-show="!showList">
				<span class="icon-arrow_back"></span> <span>{{ trans('content.general.show_list') }}</span>
			</button>

			<button class="btn btn-outline-primary1 hidden-sm-down" ng-cloak ng-class="{'isShowing':showList}" ng-click="showList=!showList" ng-show="showList">
				<span class="icon-arrow_forward"></span> <span>{{ trans('content.general.hide_list') }}</span>
			</button>

		</div>

		<div class="side-bar-fixed-full-height left-side opacity-bg" ng-class="{'_show':showList}" ng-init="requestFactory()">

			<div class="side-bar-fixed-container">

				<div class="title display-flex flex-items-xs-middle">
					<h1 class="main_title sm-size text-capitalize md-size flex-1 no-marg"> 
						{{-- <i>suggestion for</i> : <b>food</b> --}}
						{{-- <i> --}}
						{{ trans('content.context.find_your_favorite_place_on_map') }}
						{{-- </i> --}}
						{{-- <b>map</b> --}}
					</h1>
					{{-- <button class="bt-clear-style btn full-radius btn-primary-dark"><span class="icon-link"></span></button> --}}
					<button class="bt-clear-style btn btn-pin full-radius1 btn-primary-dark1 hidden-md-up" ng-click="showList=!showList">
						<span class="icon-pin"></span>
						<span>{{ trans('content.general.hide_list') }}</span>
					</button>
				</div>


				<?php

					$topFilter = array(
									array(
										'display_name'	=> trans('content.general.near_by'),
										'name'	=> 'nearby',
										'slug'	=> 'nearby'
									),
									array(
										'display_name'	=> trans('content.general.new'),
										'name'	=> 'new',
										'slug'	=> 'new'
									),
									array(
										'display_name'	=> trans('content.general.recommendation'),
										'name'	=> 'recommendation',
										'slug'	=> 'rec'
									),
									// array(
									// 	'name'	=> 'special',
									// 	'slug'	=> 'special'
									// ),
									// array(
									// 	'name'	=> "haven't been",
									// 	'slug'	=> "haven't been"
									// ),
									// array(
									// 	'name'	=> 'Following',
									// 	'slug'	=> 'Following'
									// ),
							
									
								);


						if (RequestGateway::isLogin()){
							$topFilter[]=array(
											'display_name'	=> trans_choice('content.detail.like',2),
											'name'	=> 'liked',
											'slug'	=> 'likes'
										);
							$topFilter[]=array(
											'display_name'	=> trans_choice('content.user.save',2),
											'name'	=> 'saved',
											'slug'	=> 'saves'
										);

						}

				?>	

				{{-- ------------- FILTER ------------ --}}
				<div class="simple-tag {{ AuthGateway::isLogin()?'':'bg-gray-less' }}  display-flex flex-items-xs-top">
					<h6 class="_title no-marg padd-top-5 marg-right-20">{{ trans('content.context.filter') }} :</h6>
					<ul class="clearUL flex-1 text-xs-left padd-left-10">

						@foreach($topFilter as $item)

							<li class="d-inline-block marg-bottom-10">
								<a href="javascript:void(0)" ng-click="filter('{{ $item['slug'] }}')">
									<span class="tag tag-default _border tag-pill text-capitalize">{{ $item['display_name'] }}</span>
								</a>
							</li>

						@endforeach
					</ul>
				</div>

				{{-- ------------- REGISTER & LOGIN ------------ --}}
				@if(!AuthGateway::isLogin())
					<div class="sign-in-register text-xs-center">
						<h5 class="main_title"><b>{{ trans('content.context.discover_places') }}</b></h5>
						<p class="desc">{{ trans('content.context.discover_places_desc') }}</p>

						{{ Form::open(array(
				               'action' => 'Auth\FrontAuthController@fbLogin',
				               'name' => 'fbLogin',
				               'accept-charsetme' => 'utf-8',
				               'method' => 'POST',
				               'class' => 'fb_login',
				               )) }}

						  	<input type="hidden" name="data" ng-value="_dataFbLogin.encrypted">
						  	<input type="hidden" name="data_pass" ng-value="_dataFbLogin.encrypted_pass">


		        	 	{{ Form::close() }} 

						<ul class="clearUL">
							<li class="d-inline-block"><button class="btn btn-primary full-radius fb-style md-size text-capitalize" ng-click="fbSignIn()">{{ trans('content.user.sign_in_with_facebook') }}</button></li>
							<li class="d-inline-block _or"><span class="or">{{ trans('content.navbar.or') }}</span></li>
							<li class="d-inline-block"><a href="{{ URL::to('/login') }}" class="text-capitalize">{{ trans('content.context.sign_in_with_email') }}</a></li>
						</ul>
					</div>
				@endif

				{{-- --------------- just show me -------------- --}}
				<div class="show-me-by-cate">
					<h6 class="_title">{{ trans('content.context.just_show_me') }} : <a href="#map_advance_filter" class="popupAdvanceFilter float-xs-right" title="Advance Filter"><span class="icon-tune"></span> {{ trans('content.general.advance_filter') }}</a></h6>
					<div class="category-box with-overlay" style="padding: 0;"> 
						{{-- <div class="carousel" data-flickity='{ "groupCells": true, "cellAlign": "left" }'> --}}
						<div class="carousel" data-flickity='{ "groupCells": true, "contain": true, "pageDots": false, "lazyLoad": true, "bgLazyLoad": true, "bgLazyLoad": 1 }'>
							{{-- @for($i=0;$i<=12;$i++) --}}
							@foreach($orgin_payment_parking['origin'] as $_cateItem)
								<?php 
									// $imgCate = array('cate-1.jpg','cate-2.jpg','food.jpg');
									// $img_cate_rand =$imgCate[rand(0, sizeof($imgCate)-1)];
									$imgCover = HungryModule::getRestCover($_cateItem);
								?>	
								@continue(!$_cateItem['display_name'])
							  	<div class="carousel-cell cate-item opacity-hover" data-flickity-bg-lazyload="{{ $imgCover }}">
									<div class="overlay-bg col_md"></div>
									<a  href="javascript:void(0)" title="" class="d-block _text sm-size text-overflow" ng-click="filterCategory('{{$_cateItem['display_name']}}')">{{ $_cateItem['display_name'] }}</a>
								</div>
							@endforeach
						</div>
					</div>
				</div>

				<div class="rest-verticel-list">
					<div ng-show="!restList">
						@include('includes.elements.mock-up.rest-vertical-mock-up')
					</div>
					
					@include('includes.elements.list.restaurant-vertical-list', array('no_title'=>true, 'on_map_page'=>true))

					<div  ng-show="restList.length==0" style="padding: 20px;">
						<br>
						<br>
						<br>
						<br>
						<div class="alert alert-info" role="alert">
						  <strong>{{ trans('content.general.empty') }} !!</strong> {{ trans('content.general.no_result_with_your_search') }}
						</div>
					</div>

					<div class="text-xs-center marg-top-20" ng-hide="!restList || isLoadMoreHide" ng-cloak>
						{{-- <a href="javascript:void(0)" class="btn btn-outline-primary btn-radius" ng-click = "loadMore()">{{ trans('content.general.load_more') }} ...</a> --}}
						{{-- <button class="btn btn-outline-primary full-radius text-uppercase" ng-class="{'btn-loading': isLoading}" ng-disabled="isLoading" ng-click = "loadMore()" type="button"> <img class="center-absolute _loading-icon size-sm" src="{{ asset('img/svg/loading/loading-spin.svg') }}" alt="login loading"> <span class="_text">{{ trans('content.general.load_more') }} ...</span></button> --}}

						<button class="btn btn-primary btn-primary--fx full-radius text-uppercase" ng-class="{'btn-loading': isLoading}" ng-disabled="isLoading" ng-click="loadMore()" type="button"> 
							<img class="center-absolute _loading-icon size-sm" src="{{ asset('img/svg/loading/loading-spin-white.svg') }}" alt="login loading"> 
							<span class="_text">{{ trans('content.general.load_more') }} ...</span>
						</button>
					</div>
					
					<br>
					<br>

				</div>	

			</div>

		</div>


		{{-- popup advance filter for restaurant --}}
		@include('includes.elements.comp.popup-advance-filter')


	</div>

@stop

@section('scripts')

@stop