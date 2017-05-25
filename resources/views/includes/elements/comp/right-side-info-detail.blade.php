<div class="right-side-info {{ $_cls }} hidden-xs-up">
	<div class="more-about-restaurant marg-bottom-20">
		<div class="rest-on-map" ng-init="lat={{ isset($restuarntInfo['loc']) ? $restuarntInfo['loc']['coordinates'][1] : 0 }};lng={{ isset($restuarntInfo['loc']) ?  $restuarntInfo['loc']['coordinates'][0] : 0 }}; initMap();">
			<div class="_map">
				@if(isset($restuarntInfo['loc']))
					<ui-gmap-google-map center='map.center' zoom='map.zoom' draggable="true" options="options">
					<ui-gmap-marker coords="marker.coords" options="marker.options" events="marker.events" idkey="marker.id">
					</ui-gmap-marker>
					</ui-gmap-google-map>
				@endif
			</div>
			<div class="_address">
				<h5 class="_title text-capitalize"><span class="icon-room"></span>
				{{ $_directory_name }}</h5>
				<?php
					// $_locale = HungryModule::getLangCate($restuarntInfo,'kh');
				?>
				<p class="no-marg">{{ $_address }}</p>
				@if($restuarntInfo['description'])
				<br>
				<h5 class="_title text-capitalize"><span class="icon-textsms"></span> {{ trans('content.detail.about') }}</h5>
				<p class="no-marg">
					<span class="address">{{ $_description }}</span>
					
				</p>
				@endif
				
			</div>
		</div>
		<div class="list-group list-features">
			{{-- features --}}
			@if($restuarntInfo['features'])
			
			<div class="list-group-item active marg-top-0">
				<h5 class="_title no-marg text-capitalize">{{ trans('content.general.features') }}</h5>
			</div>
			
			<div class="list-group-container">
				@foreach($restuarntInfo['features'] as $featureItem)
				<div class="list-group-item ">
					<div class="display-flex flex-items-xs-middle">
						<h6 class="_title flex-1 no-marg text-capitalize">{{  $featureItem['display_name'] }}</h6>
						<span class="icon-check_circle float-xs-right right-icon"></span>
					</div>
				</div>
				@endforeach
			</div>
			
			@endif
			{{-- <br> --}}
			{{-- food & drinks --}}
			@if($restuarntInfo['drinks'] || $restuarntInfo['foods'])
			<div class="list-group-item active">
				<h5 class="_title no-marg text-capitalize">{{ trans('content.general.food_drink') }}</h5>
			</div>
			<div class="list-group-container">
				@foreach($restuarntInfo['drinks'] as $featureItem)
				<div class="list-group-item">
					<div class="display-flex flex-items-xs-middle">
						<h6 class="_title flex-1 no-marg text-capitalize">{{ $featureItem['display_name'] }}</h6>
						<span class="icon-check_circle float-xs-right right-icon"></span>
						<span class="float-xs-right hidden-xs-up">
							Brunch, Lunch, Dinner
						</span>
					</div>
				</div>
				@endforeach
				@foreach($restuarntInfo['foods'] as $featureItem)
				<div class="list-group-item">
					<div class="display-flex flex-items-xs-middle">
						<h6 class="_title flex-1 no-marg text-capitalize">{{ $featureItem['display_name'] }}</h6>
						<span class="icon-check_circle float-xs-right right-icon"></span>
						<span class="float-xs-right hidden-xs-up">
							Brunch, Lunch, Dinner
						</span>
					</div>
				</div>
				@endforeach
			</div>
			@endif
			{{-- payment methods --}}
			@if($restuarntInfo['payment_methods'])
			<div class="list-group-item active">
				<h5 class="_title no-marg text-capitalize">{{ trans('content.general.payment_methods') }}</h5>
			</div>
			<div class="list-group-container">
				@foreach($restuarntInfo['payment_methods'] as $featureItem)
				<div class="list-group-item">
					<div class="display-flex flex-items-xs-middle">
						<h6 class="_title flex-1 no-marg text-capitalize">{{ $featureItem['display_name'] }}</h6>
						<span class="icon-check_circle float-xs-right right-icon"></span>
						<span class="float-xs-right hidden-xs-up">
							Brunch, Lunch, Dinner
						</span>
					</div>
				</div>
				@endforeach
			</div>
			@endif
			{{-- origin --}}
			@if($restuarntInfo['origins'])
			<div class="list-group-item active">
				<h5 class="_title no-marg text-capitalize">{{ trans('content.general.origins') }}</h5>
			</div>
			<div class="list-group-container">
				@foreach($restuarntInfo['origins'] as $featureItem)
				<div class="list-group-item">
					<div class="display-flex flex-items-xs-middle">
						<h6 class="_title flex-1 no-marg text-capitalize">{{ $featureItem['display_name'] }}</h6>
						<span class="icon-check_circle float-xs-right right-icon"></span>
						<span class="float-xs-right hidden-xs-up">
							Brunch, Lunch, Dinner
						</span>
					</div>
				</div>
				@endforeach
			</div>
			@endif
		</div>
	</div>
</div>

<div class="hidden-md-down">
	<div class="pro-right-side">
		<img src="{{ asset('img/tmp/smart-promo.png') }}" alt="smart" style="width: 100%;">
		<br>
		<br>
	</div>
	@include('includes.elements.list.you-might-also-like', array('restList'=>$restuarntInfo['you_may_like']))
</div>