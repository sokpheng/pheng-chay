<div class="_you-might-also-like">

	@if(!isset($no_title))
		<h2 class="_title text-uppercase">{{ $_title }}</h2>
	@endif

	<div class="list-container">

		<div class="list-item <% 'item_' + restItem._id %> {{ isset($on_map_page) ? 'on-map-page' : '' }}" 
			ng-repeat="(key, restItem) in restList.result"
			ng-class="{'active': restItem.centerMap == true}"
			ng-click="centerMap(restItem)" 
			ng-mouseenter="restItemHover(restItem, true, key)" 
			ng-mouseleave="restItemHover(restItem, false, key)"
			on-finish-render="finishedRenderList" ng-cloak>

			@if(isset($on_map_page))
				<span class="_item_number"><% key+1 %></span>
			@endif
			<div class="media"
			ng-init="_img = hhModule.getRestCover(restItem);"
			>
			  	<a class="media-left <% _img.bg_cls %>" href="{{ $baseUrlLang }}/restaurant/<% hhModule.getRestDetail(restItem) %>" style="background-image: url(<% _img.src %>)"></a>
			  	<div class="media-body">
				    <a href="{{ $baseUrlLang }}/restaurant/<% hhModule.getRestDetail(restItem) %> " class="media-heading link-secondary-col">
				    	<% hhModule.getLangCate(restItem, 'directory_name') %>
				    </a>
				  	<div class="feature">
				  		{{-- <% hhModule.getLangCate(restItem, 'location') %> --}}
				  		<% restItem.location %>
				  		<b class="_price no-marg">
							{{-- {{ HungryModule::getDollarSimbol($restItem['price_rate']) }} --}}
							<% hhModule.getDollarSimbol(restItem.price_rate) %>  <% hhModule.formatDistance(restItem.distance) %>
				  		</b>
				  	</div>
				  	<span class="address" ng-show="restItem.address"><% hhModule.getLangCate(restItem, 'address') %></span>
			  	</div>
			  	<div class="_rate display-flex flex-items-xs-middle">
			  		{{-- <span class="_val">{{ round(isset($restuarntInfo['rating'])?$restuarntInfo['rating']:0, 1, PHP_ROUND_HALF_UP)  }}</span> --}}
			  		<span class="_val"><% restItem.rating | number:1 %></span>
			  	</div>
			</div>
		</div>

	</div>

</div>