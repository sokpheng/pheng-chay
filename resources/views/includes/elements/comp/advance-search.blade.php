<?php

	$advanceSearch = array(
								// array(
								// 	'title'	=> trans('content.general.top_search'),
								// 	'item_count'	=> 0,
								// 	'popup_name'	=> 'popup_top_search',
								// 	'angular_obj'	=> 'advanceOption.top_search',
								// 	'list'	=>	$restCate,
								// 	'name'	=>	'top_search'
								// ),
								array(
									'title'	=> trans('content.general.category'),
									'item_count'	=> sizeof($categories),
									'popup_name'	=> 'popup_categories',
									'angular_obj'	=> 'advanceOption.categories',
									'list'	=>	$categories,
									'name'	=>	'category'
								),
								array(
									'title'	=> trans('content.general.locations'),
									'item_count'	=> sizeof($restSection['locations']['cities']),
									'popup_name'	=> 'popup_locations',
									'angular_obj'	=> 'advanceOption.locations',
									'list'	=>	$restSection['locations']['cities'],
									'name'	=>	'location'
								),
								array(
									'title'	=> trans('content.general.purpose'),
									'item_count'	=> sizeof($topCategoryHome['purposes']),
									'popup_name'	=> 'popup_purposes',
									'angular_obj'	=> 'advanceOption.purposes',
									'list'	=>	$topCategoryHome['purposes'],
									'name'	=>	'purposes'
								),
								array(
									'title'	=> trans('content.general.categories'),
									'item_count'	=> sizeof($topCategoryHome['food_drink']),
									'popup_name'	=> 'popup_food_drink',
									'angular_obj'	=> 'advanceOption.food_drink',
									'list'	=>	$topCategoryHome['food_drink'],
									'name'	=>	'food_drink'
								),
								array(
									'title'	=> trans('content.general.time'),
									'item_count'	=> sizeof($topCategoryHome['time']),
									'popup_name'	=> 'popup_time',
									'angular_obj'	=> 'advanceOption.time',
									'list'	=>	$topCategoryHome['time'],
									'name'	=>	'time'
								),


								// array(
								// 	'title'	=> trans('content.general.origins'),
								// 	'item_count'	=> sizeof($orgin_payment_parking['origin']),
								// 	'popup_name'	=> 'popup_origin',
								// 	'angular_obj'	=> 'advanceOption.origin',
								// 	'list'	=>	$orgin_payment_parking['origin'],
								// 	'name'	=>	'origin'
								// ),
								array(
									'title'	=> trans('content.general.features'),
									'item_count'	=> sizeof($orgin_payment_parking['feature']),
									'popup_name'	=> 'popup_feature',
									'angular_obj'	=> 'advanceOption.feature',
									'list'	=>	$orgin_payment_parking['feature'],
									'name'	=>	'feature'
								),
								array(
									'title'	=> trans('content.general.payment_methods'),
									'item_count'	=> sizeof($orgin_payment_parking['payment_method']),
									'popup_name'	=> 'popup_payment_method',
									'angular_obj'	=> 'advanceOption.payment_method',
									'list'	=>	$orgin_payment_parking['payment_method'],
									'name'	=>	'parking'
								),
								array(
									'title'	=> trans('content.general.parking'),
									'item_count'	=> sizeof($orgin_payment_parking['parking']),
									'popup_name'	=> 'popup_parking',
									'angular_obj'	=> 'advanceOption.parking',
									'list'	=>	$orgin_payment_parking['parking'],
									'name'	=>	'parking'
								),


		);

?>
<div class="sub-list-group" style="min-height: 400px;">

	<div class="data-tmp">
		{{-- <span id="cate" ng-init="advanceOption.top_search={{ json_encode($restCate) }}"></span> --}}
		<span id="tmp_categories" ng-init='advanceOption.categories={{ json_encode($categories) }}'></span>
		<span id="tmp_locations" ng-init='advanceOption.locations={{ json_encode($restSection['locations']['cities']) }}'></span>
		<span id="tmp_purposes" ng-init='advanceOption.purposes={{ json_encode($topCategoryHome['purposes']) }}'></span>
		<span id="tmp_food_drink" ng-init='advanceOption.food_drink={{ json_encode($topCategoryHome['food_drink']) }}'></span>
		<span id="tmp_time" ng-init='advanceOption.time={{ json_encode($topCategoryHome['time']) }}'></span>

		<span id="tmp_origin" ng-init='advanceOption.origin={{ json_encode($orgin_payment_parking['origin']) }}'></span>
		<span id="tmp_feature" ng-init='advanceOption.feature={{ json_encode($orgin_payment_parking['feature']) }}'></span>
		<span id="tmp_payment_method" ng-init='advanceOption.payment_method={{ json_encode($orgin_payment_parking['payment_method']) }}'></span>
		<span id="tmp_parking" ng-init='advanceOption.parking={{ json_encode($orgin_payment_parking['parking']) }}'></span>
	</div>

	<div ng-cloak >
	@foreach($advanceSearch as $advanceItem)
		<div class="list-group-item sub-active marg-top-0 display-flex flex-items-xs-middle">
			<h5 class="_sub_title no-marg text-uppercase flex-1">{{ $advanceItem['title'] }}</h5>
			@if($advanceItem['item_count']>0)
				<span class="tag tag-default tag-pill float-xs-right">{{ $advanceItem['item_count'] }}</span>
			@endif
		</div>
		<div class="list-group-container">
			{{-- @foreach($advanceItem['list'] as $item) --}}
				<div class="list-group-item" ng-repeat="(key, item) in {{ $advanceItem['angular_obj'] }} | limitTo: 3" ng-cloak>
					<div class="display-flex flex-items-xs-middle">
						{{-- <a href="{{ URL::to('/search?s='.str_slug($item['display_name'], '-')) }}" class="link-black _title flex-1 no-marg text-capitalize">{{ $item['display_name'] }}</a> --}}
						<label class="custom-control custom-checkbox" ng-init="item.checked = checkSelectOnFirstLoad(item)">
						  	<input type="checkbox" class="custom-control-input" ng-model="item.checked" ng-change="advanceSearchFilter(item, true)">
						  	<span class="custom-control-indicator"></span>
						  	<span class="custom-control-description"><% item['display_name'] %></span>
						</label>
					</div>
				</div>
				@if($advanceItem['item_count']>0)
					<div class="list-group-item">
						<a href="#{{ $advanceItem['popup_name'] }}" class="popupFilterMore" style="color: #2196F3;">{{ trans('content.general.see_more_normal') }}</a>
					</div>
				@endif
				{{-- @break($advanceItem['item_count']>0 && $loop->index == 4) --}}
			{{-- @endforeach --}}
		</div>

		@if($advanceItem['item_count']>0)

			<div id="{{ $advanceItem['popup_name'] }}" class="magnific-popup __default mfp-hide size-md no-padd advance-filter-box">
				
				<div class="header-popup full-width">
					<div class="input-group clear-style">
					  	<span class="input-group-addon" id="basic-addon1"><span class="icon-search"></span></span>
					  	<input type="text" ng-model="search_{{$advanceItem['popup_name']}}.$" class="form-control" placeholder="{{ trans('content.navbar.i_looking_for') }} : {{ $advanceItem['title'] }}" aria-describedby="basic-addon1">
					</div>
				</div>

				<div class="content {{ $advanceItem['name'] === 'location' ? 'size-sm' : '' }}">

					@if($advanceItem['name'] === 'location')

						<ul class="nav nav-pills border-bottom full-border-bottom marg-bottom-20" role="tablist">
							@foreach($restSection['locations']['cities'] as $key => $item)
								<?php
									$locationName = str_slug($item['display_name'],'-');
									$active = $key == 0 ? 'active' : '';
								?>
							  	<li class="nav-item">
							    	<a class="nav-link {{ $active }} size-sm" data-toggle="tab" href="#{{ $locationName }}" role="tab"><span class="_title">{{ $item['display_name'] }}</span> <span class="tag tag-primary tag-pill">{{ sizeof($item['districts']) }}</span></a>
							  	</li>
						  	@endforeach
						</ul>

						<div class="tab-content tab-default no-bg">
							
							@foreach($restSection['locations']['cities'] as $key => $item)
								<?php
									$locationName = str_slug($item['display_name'],'-');
									$active = $key == 0 ? 'in active' : '';
								?>
							  	<div class="tab-pane fade {{ $active }}" id="{{ $locationName }}" role="tabpanel">
									<div class="row">
										<div class="col-sm-3" ng-repeat="(key, item) in {{ $advanceItem['angular_obj'].'['.$key.'].districts' }} | filter:search_{{$advanceItem['popup_name']}}:strict" ng-cloak>

											<label class="custom-control custom-checkbox" ng-init="item.checked = checkSelectOnFirstLoad(item)">
											  	<input type="checkbox" class="custom-control-input" ng-model="item.checked" ng-change="advanceSearchFilter(item)">
											  	<span class="custom-control-indicator"></span>
											  	<span class="custom-control-description"><% item['display_name'] %></span>
											</label>

										</div>
									</div>
							  	</div>
						  	@endforeach

						</div>

					@else

						<div class="row">
							<div class="col-sm-3" ng-repeat="(key, item) in {{ $advanceItem['angular_obj'] }} | filter:search_{{$advanceItem['popup_name']}}:strict" ng-cloak>

								<label class="custom-control custom-checkbox" ng-init="item.checked = checkSelectOnFirstLoad(item)">
								  	<input type="checkbox" class="custom-control-input" ng-model="item.checked" ng-change="advanceSearchFilter(item)">
								  	<span class="custom-control-indicator"></span>
								  	<span class="custom-control-description"><% item['display_name'] %></span>
								</label>

							</div>
						</div>

					@endif

				</div>


				<div class="footer-popup no-padd-top">
					<div class="text-xs-right">
						<a href="javascript:void(0)" class="clear-filter" ng-click="clearFilter()">{{ trans('content.general.clear_filter') }}</a>
						<button class="btn btn-primary btn-apply" ng-click="applyFilter()">{{ trans('content.general.apply') }}</button>
					</div>
				</div>

			</div>

		@endif

	@endforeach
	</div>

	<div class="footer-popup" style="padding: 0 15px;">
		<button class="btn btn-primary btn-apply" style="width: 100%;" ng-click="applyFilter()">{{ trans('content.general.apply') }}</button>
	</div>

</div>