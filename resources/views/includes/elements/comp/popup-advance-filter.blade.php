
{{-- ========= Map Advance Filter ======== --}}
<div id="map_advance_filter" class="magnific-popup __default mfp-hide size-lg no-padd advance-filter-box">
	
	<div class="header-popup full-width hidden-xs-up">
		<div class="input-group clear-style">
		  	<span class="input-group-addon" id="basic-addon1"><span class="icon-search"></span></span>
		  	<input type="text" ng-model="search.$" class="form-control" placeholder="{{ trans('content.navbar.i_looking_for') }} ..." aria-describedby="basic-addon1">
		</div>
	</div>


	{{-- ============ tab obj ============ --}}

	<?php

			$advanceSearch = array(
				// array(
				// 	'title'	=> trans('content.general.categories'),
				// 	'item_count'	=> sizeof($categories),
				// 	'popup_name'	=> 'popup_categories',
				// 	'angular_obj'	=> 'advanceOption.categories',
				// 	'list'	=>	$categories,
				// 	'name'	=>	'category'
				// ),
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
					'title'	=> trans('content.general.food_drink'),
					'item_count'	=> sizeof($orgin_payment_parking['drink']),
					'popup_name'	=> 'popup_drink',
					'angular_obj'	=> 'advanceOption.drink',
					'list'	=>	$orgin_payment_parking['drink'],
					'name'	=>	'drink'
				),
				array(
					'title'	=> trans('content.general.time'),
					'item_count'	=> sizeof($topCategoryHome['time']),
					'popup_name'	=> 'popup_time',
					'angular_obj'	=> 'advanceOption.time',
					'list'	=>	$topCategoryHome['time'],
					'name'	=>	'time'
				),

				array(
					'title'	=> trans('content.general.category'),
					'item_count'	=> sizeof($orgin_payment_parking['origin']),
					'popup_name'	=> 'popup_origin',
					'angular_obj'	=> 'advanceOption.origin',
					'list'	=>	$orgin_payment_parking['origin'],
					'name'	=>	'origin'
				),
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
					'name'	=>	'payment_method'
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

	<div class="data-tmp">

		<?php

			$cityPro = trans('content.city_province');

		?>

		{{-- <span id="tmp_categories" ng-init='advanceOption.categories={{ json_encode($categories) }}'></span> --}}
		<span id="tmp_locations" ng-init='advanceOption.locations={{ json_encode($restSection['locations']['cities']) }}'></span>
		<span id="tmp_purposes" ng-init='advanceOption.purposes={{ json_encode($topCategoryHome['purposes']) }}'></span>
		<span id="tmp_drink" ng-init='advanceOption.drink={{ json_encode($orgin_payment_parking['drink']) }}'></span>
		<span id="tmp_time" ng-init='advanceOption.time={{ json_encode($topCategoryHome['time']) }}'></span>

		<span id="tmp_origin" ng-init='advanceOption.origin={{ json_encode($orgin_payment_parking['origin']) }}'></span>
		<span id="tmp_feature" ng-init='advanceOption.feature={{ json_encode($orgin_payment_parking['feature']) }}'></span>
		<span id="tmp_payment_method" ng-init='advanceOption.payment_method={{ json_encode($orgin_payment_parking['payment_method']) }}'></span>
		<span id="tmp_parking" ng-init='advanceOption.parking={{ json_encode($orgin_payment_parking['parking']) }}'></span>

		<span id="cityProLang" ng-init="cityProLang = {{ json_encode($cityPro) }}"></span>

	</div>

	{{-- ================================= --}}

	<div class="content">

		<ul class="nav nav-pills border-bottom full-border-bottom marg-bottom-30 item-center-sm" role="tablist">
			@foreach($advanceSearch as $key => $item)
				<?php
					$active = $key == 0 ? 'active' : '';
					$itemCount = $item['item_count'];
					if($item['name'] === 'location'){
						// $itemCount = 0;
						foreach ($item['list'] as $key_sub => $itemLocation) {
							$itemCount += sizeof($itemLocation['districts']);
						}
					}
				?>
			  	<li class="nav-item size-sm">
			    	<a class="nav-link {{ $active }} size-sm text-capitalize" data-toggle="tab" href="#{{ $item['name'] }}" role="tab"><span class="_title">{{ $item['title'] }}</span> <span class="tag tag-primary tag-pill">{{ $itemCount }}</span></a>
			  	</li>
		  	@endforeach
		</ul>

		<div class="tab-content tab-default no-bg">
			
			{{-- @if(isset($neverTrue)) --}}
				@foreach($advanceSearch as $key => $item)
					<?php
						// $locationName = str_slug($item['display_name'],'-');
						$active = $key == 0 ? 'in active' : '';
					?>
				  	<div class="tab-pane fade {{ $active }}" id="{{ $item['name'] }}" role="tabpanel">

				  		@if($item['name'] === 'location')

				  			<div class="multi-filter" ng-repeat="(key, item) in {{ $item['angular_obj'] }} | filter:search:strict" ng-if="item.display_name">

								<label class="custom-control custom-checkbox text-primary-col" ng-init="item.checked = checkSelectOnFirstLoad(item)">
								  	<input type="checkbox" class="custom-control-input" ng-model="item.checked" ng-change="advanceSearchFilter(item)">
								  	<span class="custom-control-indicator"></span>
								  	{{-- <span class="custom-control-description"><% hhModule.getLangCate(item, 'display_name') %></span> --}}
								  	<span class="custom-control-description"><% getTitleCityPro(cityProLang,item) %></span>
								</label>

								<div class="row">
									<div class="col-sm-3" ng-repeat="(keyDistricts, itemDistricts) in  item.districts | filter:search:strict" ng-cloak ng-if="item.display_name">

										<label class="custom-control custom-checkbox" ng-init="itemDistricts.checked = checkSelectOnFirstLoad(itemDistricts)">
										  	<input type="checkbox" class="custom-control-input" ng-model="itemDistricts.checked" ng-change="advanceSearchFilter(itemDistricts)">
										  	<span class="custom-control-indicator"></span>
										  	<span class="custom-control-description text-capitalize"><% getTitleCityPro(cityProLang,itemDistricts) %></span>
										</label>

									</div>
								</div>

								<div ng-show="key != {{ $item['angular_obj'] }}.length-1">
									<br>
									<hr class="line-col-fade-left-right md-width">
									<br>
								</div>

							</div>

						@else

							<div class="row">
								<div class="col-sm-3" ng-if="item.display_name" ng-repeat="(key, item) in {{ $item['angular_obj'] }} | filter:search:strict" ng-cloak>

									<label class="custom-control custom-checkbox" ng-init="item.checked = checkSelectOnFirstLoad(item)">
									  	<input type="checkbox" class="custom-control-input" ng-model="item.checked" ng-change="advanceSearchFilter(item)">
									  	<span class="custom-control-indicator"></span>
									  	<span class="custom-control-description text-capitalize"><% hhModule.getLangCate(item, 'display_name') %></span>
									</label>

								</div>
							</div>

						@endif

				  	</div>
			  	@endforeach
		  	{{-- @endif --}}

		</div>

	</div>

	<div class="footer-popup no-padd-top1 bt-gray">
		<div class="text-xs-right">
			<a href="javascript:void(0)" class="clear-filter" ng-click="clearFilter()">{{ trans('content.general.clear_filter') }}</a>
			<button class="btn btn-primary btn-apply" ng-click="applyFilter()">{{ trans('content.general.apply') }}</button>
		</div>
	</div>

</div>