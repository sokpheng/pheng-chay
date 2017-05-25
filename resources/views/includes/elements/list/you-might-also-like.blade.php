<div class="_you-might-also-like">
	@if(!isset($no_title))
		<h2 class="_title text-uppercase">{{ trans('content.general.you_might_also_like') }}</h2>
	@endif
	<div class="list-container">


		@if(isset($restList))

			@foreach($restList as $index => $restItem)
				<div class="list-item {{ isset($on_map_page) ? 'on-map-page' : '' }}">
					@if(isset($on_map_page))
						<span class="_item_number">{{ $index+1 }}</span>
					@endif

						<?php

						  	$_address = HungryModule::getLangCate($restItem,'address');
						  	$_directory_name = HungryModule::getLangCate($restItem,'directory_name');
						?>
					<div class="media">
					  	<a class="media-left bg-cover" href="{{ HungryModule::getRestDetailLink($restItem) }}" style="background-image: url({{ HungryModule::getRestCover($restItem) }})"></a>
					  	<div class="media-body">
						    <a href="{{ HungryModule::getRestDetailLink($restItem) }}" class="media-heading link-secondary-col">{{ $_directory_name }}
						    </a>
						  	<div class="feature">
						  		@if(isset($restItem['commune']))
						  			{{ $restItem['commune']['display_name'] }}
						  		@endif
						  		<b class="_price no-marg">
									{{ HungryModule::getDollarSimbol($restItem['price_rate']) }}
						  		</b>
						  	</div>

						  	@if($restItem['address'])
						  		<span class="address">{{ $_address }}</span>
						  	@endif

					  	</div>
					  	<div class="_rate display-flex flex-items-xs-middle">
					  		<span class="_val">{{ round(isset($restItem['rating'])?$restItem['rating']:0, 1, PHP_ROUND_HALF_UP)  }}</span>
					  	</div>
					</div>
				</div>
			@endforeach


		@else



			@for($i=0;$i<10;$i++)
				<div class="list-item {{ isset($on_map_page) ? 'on-map-page' : '' }}">
					@if(isset($on_map_page))
						<span class="_item_number">{{ $i+1 }}</span>
					@endif
					<div class="media">
					  	<a class="media-left bg-cover" href="{{ URL::to('/restaurant/1023-metro-hassakan') }}" style="background-image: url({{ asset('img/tmp/cate-1.jpg') }})"></a>
					  	<div class="media-body">
						    <a href="{{ URL::to('/restaurant/1023-metro-hassakan') }}" class="media-heading link-secondary-col">Metro hassakan (Metro Cafe)</a>
						  	<div class="feature">Asian<b class="_price">$$$</b></div>
						  	<span class="address">#127, St 148 Phnom Penh Cambodia</span>
					  	</div>
					  	<div class="_rate display-flex flex-items-xs-middle">
					  		<span class="_val">8.4</span>
					  	</div>
					</div>
				</div>
			@endfor

		@endif

	</div>
</div>