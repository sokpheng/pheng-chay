<div class="overview">
	
	{{-- about --}}
	@if($restuarntInfo['description'])
	 	<div class="info-section marg-bottom-20">
			<h5 class="_title text-capitalize"><span class="icon-textsms"></span> {{ trans('content.detail.about') }}</h5>
			<p class="no-marg">
				<span class="address">{{ $_description }}</span>
			</p>
		</div>
	@endif


	@if(isset($restuarntInfo['socials']))

{{--                             [facebook] => www.facebook.com/Khema51/
                            [google+] => 
                            [instagram] => 
                            [pinterest] =>  --}}

        <?php
        	
        	$chkSocial = false;
        	foreach ($restuarntInfo['socials'] as $key => $value) {
        		if($value != ''){
        			$chkSocial = true;
        			break;
        		}

        	}

        ?> 
        
        @if($chkSocial)
			<div class="info-section follow-us">
				<h5 class="_title text-capitalize">
				{{-- <span class="icon-textsms"></span>  --}}
				{{ trans('content.general.follow_us') }} : 
		        <ul class="d-inline-block clearUL">

			        @if(isset($restuarntInfo['socials']['facebook']) && $restuarntInfo['socials']['facebook'] !='')
			        	<li><a href="{{ HungryModule::getHttpUrl($restuarntInfo['socials']['facebook'], 'https') }}" target="_blank"><span class="icon-facebook"></span></a></li>
			        @endif

			        @if(isset($restuarntInfo['socials']['google+']) && $restuarntInfo['socials']['google+'] !='')
			        	<li><a href="{{ HungryModule::getHttpUrl($restuarntInfo['socials']['google+'], 'https') }}" target="_blank"><span class="icon-google"></span></a></li>
			        @endif

			        @if(isset($restuarntInfo['socials']['instagram']) && $restuarntInfo['socials']['instagram'] !='')
			        	<li><a href="{{ HungryModule::getHttpUrl($restuarntInfo['socials']['instagram'], 'https') }}" target="_blank"><span class="icon-instagram"></span></a></li>
			        @endif

			        @if(isset($restuarntInfo['socials']['pinterest']) && $restuarntInfo['socials']['pinterest'] !='')
			        	<li><a href="{{ HungryModule::getHttpUrl($restuarntInfo['socials']['pinterest'], 'https') }}" target="_blank"><span class="icon-pinterest"></span></a></li>
			        @endif

		        </ul>
		        </h5>

		    </div>
	    @endif

	@endif


	{{-- feature --}}
	@if($restuarntInfo['features'])
		<div class="info-section {{ !isset($restuarntInfo['socials']) ? '' : 'marg-top-20' }}">
			<h5 class="_title text-capitalize border-bottom">
			{{-- <span class="icon-textsms"></span>  --}}
			{{ trans('content.general.features') }}</h5>
			<div class="row space0-xs padd-top-15">
				@foreach($restuarntInfo['features'] as $item)
					<div class="col-sm-3">
						<a class="item-link" href="{{ $baseUrlLang.'/search?s='.urlencode($item['display_name']) }}" title=""><span class="icon-check_circle tick-icon"></span> {{ HungryModule::getLangCate($item,'display_name') }}</a>
					</div>
				@endforeach
			</div>
		</div>
	@endif

	{{-- payment method --}}
	@if($restuarntInfo['payment_methods'])
		<div class="info-section marg-top-20">
			<h5 class="_title text-capitalize border-bottom">
			{{-- <span class="icon-textsms"></span>  --}}
			{{ trans('content.general.payment_methods') }}</h5>
			<div class="row space0-xs padd-top-15">
				@foreach($restuarntInfo['payment_methods'] as $item)
					<div class="col-sm-3">
						<a class="item-link" href="{{ $baseUrlLang.'/search?s='.urlencode($item['display_name']) }}" title=""><span class="icon-check_circle tick-icon"></span> {{ HungryModule::getLangCate($item,'display_name') }}</a>
					</div>
				@endforeach
			</div>
		</div>
	@endif

	{{-- foods --}}
	@if($restuarntInfo['foods'])
		<div class="info-section marg-top-20">
			<h5 class="_title text-capitalize border-bottom">
			{{ trans('content.general.time') }}</h5>
			<ul class="clearUL favorite-tag">


				<?php

					$foodsTime = $restuarntInfo['foods'];

					if(sizeof($foodsTime)>0){
						$tmp = [];
						foreach($foodsTime as $item){
							 // echo strtolower($item['display_name']) ;
							
							if(strtolower($item['display_name']) === 'breakfast'){
								$item['order'] = 1;
							}
							else if(strtolower($item['display_name']) == 'lunch'){
								$item['order'] = 2;
							}
							else if(strtolower($item['display_name']) == 'dinner'){
								$item['order'] = 3;
							}
							else if(strtolower($item['display_name']) == 'late night'){
								$item['order'] = 4;
							}
							else{
								// similar_text($var_1, $var_2, $_similarPercent);
							}
							array_push($tmp, $item);
						}
					}

					$collection = collect($tmp);

					$foodsTime = $collection->sortBy('order')->toArray();

				?>

				@foreach($foodsTime as $item)
					<li>
						<a class="tag tag-default primary-tag item-link" href="{{ $baseUrlLang.'/search?s='.urlencode($item['display_name']) }}" title="">{{ HungryModule::getLangCate($item,'display_name') }}</a>
					</li>
				@endforeach
			</ul>
		</div>
	@endif

	{{-- price rang with time --}}
	@if(isset($restuarntInfo['dimension_price_ranges']) && sizeof($restuarntInfo['dimension_price_ranges'])>0)
		<div class="info-section marg-top-15">

			<table class="table table-striped">
				<thead class="thead-inverse">
					<tr>
						<th>{{ trans('content.general.time') }}</th>
						{{-- <th>{{ trans('content.general.open_hour') }}</th> --}}
						<th>{{ trans('content.general.price') }}</th>
					</tr>
				</thead>
				<tbody>
				
					@foreach($restuarntInfo['dimension_price_ranges'] as $item)

					  	<?php
							// setlocale(LC_MONETARY,"en_US");
							$_minPrice = '$'. number_format($item['min_price'], 2, '.', ',');
							$_maxPrice = '$'. number_format($item['max_price'], 2, '.', ',');
					  	?>

						<tr>
							<th>{{ HungryModule::getLangCate($item['dimension'],'display_name') }}</th>
							{{-- <td>10:00 AM - 10:00 PM</td> --}}
							<td class="_price">{{ $_minPrice .' - ' .$_maxPrice }}</td>
						</tr>

					@endforeach

				</tbody>
			</table>
		</div>
	@endif

	{{-- drinks --}}
	@if($restuarntInfo['drinks'])
		<div class="info-section marg-top-20">
			<h5 class="_title text-capitalize border-bottom">
			{{ trans_choice('content.general.categories',2) }}</h5>
			<ul class="clearUL favorite-tag">
				@foreach($restuarntInfo['drinks'] as $item)
					<li>
						<a class="tag tag-default primary-tag item-link" href="{{ $baseUrlLang.'/search?s='.urlencode($item['display_name']) }}" title="">{{ HungryModule::getLangCate($item,'display_name') }}</a>
					</li>
				@endforeach
			</ul>
		</div>
	@endif

	{{-- origins --}}
	@if($restuarntInfo['origins'])
		<div class="info-section marg-top-20">
			<h5 class="_title text-capitalize border-bottom">
			{{ trans('content.general.category') }}</h5>
			<ul class="clearUL favorite-tag">
				@foreach($restuarntInfo['origins'] as $item)
					<li>
						<a class="tag tag-default primary-tag item-link" href="{{ $baseUrlLang.'/search?s='.urlencode($item['display_name']) }}" title="">{{ HungryModule::getLangCate($item,'display_name') }}</a>
					</li>
				@endforeach
			</ul>
		</div>
	@endif

	{{-- categories --}}
	@if($restuarntInfo['categories'])
		<div class="info-section marg-top-20">
			<h5 class="_title text-capitalize border-bottom">
			{{ trans_choice('content.general.purpose',2) }}</h5>
			<ul class="clearUL favorite-tag">
				@foreach($restuarntInfo['categories'] as $item)
					<li>
						<a class="tag tag-default primary-tag item-link" href="{{ $baseUrlLang.'/search?s='.urlencode($item['display_name']) }}" title="">{{ HungryModule::getLangCate($item,'display_name') }}</a>
					</li>
				@endforeach
			</ul>
		</div>
	@endif

	{{-- parkings --}}
	@if($restuarntInfo['parkings'])
		<div class="info-section marg-top-20">
			<h5 class="_title text-capitalize border-bottom">
			{{ trans('content.general.parking') }}</h5>
			<ul class="clearUL favorite-tag">
				@foreach($restuarntInfo['parkings'] as $item)
					<li>
						<a class="tag tag-default primary-tag item-link" href="{{ $baseUrlLang.'/search?s='.urlencode($item['display_name']) }}" title="">{{ HungryModule::getLangCate($item,'display_name') }}</a>
					</li>
				@endforeach
			</ul>
		</div>
	@endif

	{{-- open times --}}
	{{-- <pre>{{ print_r($restuarntInfo['open_times'], true) }}</pre> --}}

	<?php

		$chkOpenTimeValue = false;
		if(isset($restuarntInfo['open_times'])){
			if(sizeof($restuarntInfo['open_times'])>0){
				foreach($restuarntInfo['open_times'] as $key => $item){
					if($item !='')
						$chkOpenTimeValue = true;
				}
			}
		}

	?>

	@if(isset($restuarntInfo['open_times']) && $chkOpenTimeValue)
		<div class="info-section white-bg">
			<h5 class="_title text-capitalize border-bottom">
				<span class="icon-schedule"></span> 
				{{ trans('content.general.open_hour') }}
			</h5>
			<ul class="clearUL open-time">
				<?php
					$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
				?>
				@foreach($days as $key => $item)
					@if(isset($restuarntInfo['open_times'][$item]))
						<li>
							<span class="day d-inline-block text-capitalize">{{ $item }} <span class="float-xs-right">:</span> </span>
							<span class="time text-uppercase">{{ $restuarntInfo['open_times'][$item] }} </span>
						</li>
					@endif
				@endforeach
			</ul>
		</div>
	@endif

	{{-- address & map --}}
	<div class="info-section rest-on-map marg-top-20" ng-init="directory_name = '{{ addslashes($_directory_name) }}';lat={{ isset($restuarntInfo['loc']) ? $restuarntInfo['loc']['coordinates'][1] : 0 }};lng={{ isset($restuarntInfo['loc']) ?  $restuarntInfo['loc']['coordinates'][0] : 0 }};">

		<div class="_address">
			<h5 class="_title text-capitalize"><span class="icon-room"></span>
			{{ $_directory_name }}</h5>
			<p class="no-marg">{{ $_address }}</p>
		</div>

		<div class="_map full-section-div marg-top-20" ng-init="initMap()">
			@if(isset($restuarntInfo['loc']))
				<ui-gmap-google-map center='map.center' zoom='map.zoom' draggable="true" options="options">
				<ui-gmap-marker coords="marker.coords" options="marker.options" events="marker.events" idkey="marker.id">
				</ui-gmap-marker>
				</ui-gmap-google-map>
			@endif
		</div>

	</div>

</div>