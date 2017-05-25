<div class="_you-might-also-like">

	<div class="list-container">

		
		{{-- <pre><% hotelList | json %></pre> --}}

		<div class="list-item no-border" ng-repeat="item in hotelList" ng-cloak>

			<div class="media">
			  	<a class="media-left bg-cover size-lg" href="{{ $baseUrlLang }}/hotel/<% hhModule.getRestDetail(item) %> " style="background-image: url(<% item.cover_media.thumbnail_url_link %>)"></a>
			  	<div class="media-body">

				    <a href="{{ $baseUrlLang }}/hotel/<% hhModule.getRestDetail(item) %> " class="media-heading link-secondary-col">
				    	<% item.name %>
				    </a>

				  	<div class="d-block address">
				    	<% item.address %>
				  	</div>

				  	<ul class="clearUL rate-star" ng-init="initStar(item)">

				  		<li class="d-inline-block" ng-repeat="star in item.rateStar">
				  			<span ng-class="{'icon-star': star.selected , 'icon-star icon-star_border': !star.selected }"></span>
				  		</li>

				  	</ul>

				  	<ul class="clearUL features">
				  		<li class="d-inline-block" ng-repeat="feature in item.features"><span class="tag tag-default _border tag-pill text-capitalize"><% feature %></span></li>
				  		<li class="d-inline-block" ng-show="item.features.length<=0"><span class="tag tag-default _border tag-pill text-capitalize">Wi-Fi</span></li>
				  	</ul> 

				  	<div class="action">
						<div class="btn-group" role="group" aria-label="Basic example">
						  	{{-- <button type="button" class="btn btn-secondary">Left</button> --}}
						  	<div class="btn btn-secondary price"> 
						  		<span class="price"><span>USD</span> <span><% item.price | currency:'$':2 %></span></span>
						  	</div>
						  	<a href="{{ $baseUrlLang }}/hotel/<% hhModule.getRestDetail(item) %> " class="btn btn-secondary bt-select text-uppercase">{{ trans('content.general.select_this_hotel') }}</a>
						</div>
				  	</div>

			  	</div>

			</div>

		</div>


		<div class="msg text-center" style="padding: 200px 0;" ng-show="firstInit && hotelList && hotelList.length<=0" ng-cloak>
			<h4 class="title">{{ trans('content.general.no_hotel_found') }}</h4>
		</div>


	</div>

	<br>

	<span ng-init="currentPage=1;totalItem=options.total;maxSize=5; _url='{{ URL::current() }}';itemPerPage=itemLimit"></span>
	{{-- <pre><% options | json %></pre> --}}
	<div class="text-xs-center" ng-show="options.total>itemLimit">
		<ul uib-pagination total-items="options.total" ng-model="currentPage" items-per-page="itemPerPage" max-size="maxSize" template-url="{{ asset('template/pagination.html') }}" class="pagination-md" boundary-link="true" force-ellipses="true" rotate="true" previous-text="{{ trans('content.general.prev') }}" next-text="{{ trans('content.general.next') }}" ng-change="pageChanged()"></ul>
	</div>

</div>