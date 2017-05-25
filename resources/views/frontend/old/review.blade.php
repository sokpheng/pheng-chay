@extends('layouts.default')

@section('content')	
	
	@include("includes.elements.section.main-booking")

	<section class="hotel-review padding-section display-flex flex-end" ng-controller="hotelReviewCtrl">

		<div class="max-container no-padd" style="position: relative; width: 100%" ng-init="hotelId='{{ isset($hotelId) ? $hotelId : '' }}'; bookingId='{{ isset($bookingId) ? $bookingId : '' }}'">

			<div class="hotel-review-container">

				<?php
					$chkSuccess = Input::get('s');
				?>

				@if(isset($bookingId) && $chkSuccess==1)

				<div class="breadcrums-multi-step text-center">
					<ol class="cd-multi-steps text-bottom count">
						<li class="visited"><em>{{ trans('content.general.check_in') }}</em></li>
						<li class="visited"><a href="{{ URL::to('/select-hotel') }}"><em>{{ trans('content.general.select_hotel') }}</em></a></li>
						@if(!isset($bookingId))
							<li class="current"><em>{{ trans('content.general.review') }}</em></li>
							<li class="visited1 finish"><em>{{ trans('content.general.done') }} <span class="icon-check"></span></em></li>
						@else
							<li class="visited"><em>{{ trans('content.general.review') }}</em></li>
							<li class="visited finish"><em>{{ trans('content.general.done') }} <span class="icon-check"></span></em></li>
						@endif
					</ol>
				</div>


				<hr class="line-col-fade-left-right marg-md md-width">

				@endif


				@if(isset($is_success) || (isset($bookingId)) && $chkSuccess==1)

					<div class="box-with-shadow bg-green hotel-basic-info" style="padding: 30px;">

						<h2 class="text-center text-uppercase" style1="color: green;"><span class="icon-check"></span> {{ trans('content.general.booking_successfully') }}</h2>

						<h5 class="text-center" style="max-width: 710px; margin: auto">
							{{ trans('content.general.msg_booking_successfully') }}
						</h5>

					</div>

				@endif

				<br>


				{{-- hotel information --}}
				<div class="box-with-shadow bg-gray hotel-basic-info">
					
					<div class="row ">

						<div class="col-sm-7">

							<h4 class="title blue-col"  ng-cloak><% hotelInfo.name %></h4>

							<h6 class="desc" ng-cloak><% hotelInfo.address %></h5>

						  	<ul class="clearUL contactInfo" ng-cloak>
						  		<li class="d-inline-block" ng-show="hotelInfo.phone"><span class="icon-ring_volume"></span> <span><% hotelInfo.phone %></span></li>
						  		<li class="d-inline-block" ng-show="hotelInfo.email"><span class="icon-markunread"></span> <a href="mailto:<% hotelInfo.email %>?subject=Hi <% hotelInfo.name %>"><span><% hotelInfo.email %></span></a></li>
						  		<li class="d-inline-block" ng-show="hotelInfo.website"><span class="icon-public"></span> <a href="<% hotelInfo.website %>" target="_blank"><span>
						  			<% hhModule.removeHttpHttps(hotelInfo.website) %>
						  			
						  		</span></a></li>
						  	</ul>

						  	<ul class="clearUL rate-star d-inline-block">

						  		{{-- <pre><% hotelInfo.rateStar | json %></pre> --}}

						  		<li class="d-inline-block" ng-repeat="star in hotelInfo.rateStar">
						  			<span ng-class="{'icon-star': star.selected , 'icon-star icon-star_border': !star.selected }"></span>
						  		</li>

						  	</ul>

						  	<div class="price d-inline-block">
						  		<span style="font-size: 1.3rem;">Total :</span> <span class="lb">USD</span> 
						  		@if(!isset($bookingId))
						  			<span class="val" ng-cloak><% hotelInfo.price | currency:'$':2 %></span>
						  		@else
						  			<span class="val" ng-cloak><% bookingInfo.room_type.price | currency:'$':2 %></span>
						  		@endif
						  	</div>

						</div>	

						<div class="col-sm-5">
							
							<div class="row space5 bookingInfoContainer" ng-cloak>
								<div class="col-md-7 col-sm-12">
									<ul class="clearUL check-in-info">
										<li>
											<span class="lb">{{ trans('content.general.check_in') }} :</span>
											<span class="val" ng-cloak><b><% hhModule.dateToTimesteam(booking.check_in_date) | date:'medium' %></b></span>
										</li>
										<li>
											<span class="lb">{{ trans('content.general.check_out') }} :</span>
											<span class="val" ng-cloak><b><% hhModule.dateToTimesteam(booking.check_out_date) | date:'medium' %></b></span>
										</li>
									</ul>
								</div>
								<div class="col-md-5 col-sm-12 text-right text-sm-left">
									<ul class="clearUL check-in-info">
										<li>
											<span class="lb">{{ trans('content.general.room') }} :</span>
											<span class="val" ng-cloak><b><% booking.room || 0 %></b></span>
										</li>
										<li>
											<span class="lb">{{ trans('content.general.adult') }} :</span>
											<span class="val" ng-cloak><b><% booking.adult || 0 %></b></span>
										</li>
										<li>
											<span class="lb">{{ trans('content.general.children') }} :</span>
											<span class="val" ng-cloak><b><% booking.children || 0 %></b></span>
										</li>
									</ul>
								</div>
							</div>

						</div>	

					</div>

				</div>


				{{-- hotel gallery --}} 
				<div class="hotel-gallery three-element marg-top-20">
					<div class="row space0">
						<div class="col-sm-8" style="position: relative;">
							<a href="<% hotelInfo.cover_media.zoom_url_link %>" class="d-block main-element bg-cover hover-opacity _photoEle" style="background-image: url(<% hotelInfo.cover_media.zoom_url_link %>)">
								<div class="desc" ng-show="hotelInfo.short_description" ng-cloak>
									<span>“<% hotelInfo.short_description %>”</span>
								</div>
							</a>

							<?php

								// $videoLink = '';
								// $videoLink = "http://www.youtube.com/watch?v=7HKoqNJtMTQ";
								// if (strpos($videoLink, 'facebook.com') !== false) {
								// 	$videoLink = "https://www.facebook.com/v2.5/plugins/video.php?href=" . $videoLink;
								// }

							?>
							<a ng-show="hotelInfo.youtube_url" href="<% checkYouOrFBLink(hotelInfo.youtube_url) %>" class="btn-video video_pro"><span class="icon-play_circle_filled"></span></a>
						</div>
						<div class="col-sm-4">
							<div class="other-element display-flex">	
								<a href="<% getSecondPhoto(hotelInfo) %>" class="d-block all-gallery bg-cover hover-opacity _photoEle" style="background-image: url('<% getSecondPhoto(hotelInfo,'preview_url_link') %>')">
									<div class="overlay-bg color_md"></div>
									<h4 class="see-all-image center-absolute" ng-cloak>{{ trans('content.general.view_gallery') }} (<% hotelInfo.gallery.length %>)</h4>
								</a>
								<div id="map" class="map">
								</div>
							</div>
						</div>
					</div>

					{{-- render for gallery popup --}}
					<a ng-repeat="item in hotelInfo.gallery" href="<% item.zoom_url_link %>" class="_photoEle"></a>
					{{-- <pre><% hotelInfo | json %></pre> --}}
				</div>


				{{-- feature --}}	
				<div class="marg-top-20" ng-show="hotelInfo.features.length>0" ng-cloak>
					<h5 class="title">{{ trans('content.general.features') }}</h5>
					<div class="box bg-gray features">
						<ul class="clearUL" ng-cloak>

							<li class="d-inline-block" ng-repeat="item in hotelInfo.features">
								{{-- <span class="icon-wifi"></span>  --}}
								<span><% item %></span></li>

							</ul>

						</ul>
					</div>
				</div>


				{{-- rooms table --}}
				<div class="table-multi-body rooms-table marg-top-20 table-responsive">

					<table class="table  table-bordered1">

						<thead class="thead-inverse">
							<tr>
								<th class="bg-primary">{{ trans('content.general.type') }}</th>
								<th class="bg-primary hidden-sm-down">{{ trans('content.general.what_included') }}</th>
								<th class="bg-primary hidden-sm-down">{{ trans('content.general.capacity') }}</th>
								<th class="bg-primary">{{ trans('content.general.price_per_night') }}</th>
								<th class="bg-primary">{{ trans('content.general.room') }}</th>
								
								@if(!isset($bookingId))
									<th class="bg-primary"></th>
								@endif
							</tr>
						</thead>

						<tbody>
							<tr colspan="6" class="space size-md"><td></td></tr>
						</tbody>


						{{-- | filter:{ _id: bookingInfo.room_type._id --}}
						<tbody class="bg-gray" ng-repeat="item in hotelInfo.room_type" ng-cloak>
							<tr>
								<th scope="row" colspan="6" class="hotel-title">
									<h5 class="d-inline-block no-marg"><% item.title %></h5> 
									<span style="font-size: 22px;display: inline-block;vertical-align: text-bottom;margin-left: 10px;" class="hidden-sm-up icon-people" ng-class="{'icon-group_add':item.capacity>2}"></span>
								</th>
							</tr>
							<tr class="info">
								<td class="type">
									<ul class="clearUL info-list">

										<li ng-repeat="type in item.input_type"><span><% type %></span></li>

										{{-- <li><span>1 Bathroom</span></li> --}}
										{{-- <li><span>2 Single Bed</span></li> --}}
									</ul>
								</td>
								<td class="include hidden-sm-down">
									<ul class="clearUL info-list">
										<li ng-repeat="include in item.input_include"><span class="icon-check"></span><span><% include %></span></li>
										{{-- <li><span class="icon-check"></span><span>Breakfast</span></li> --}}
									</ul>
								</td>
								<td class="capacity text-center hidden-sm-down">
									<span class="icon-people" ng-class="{'icon-group_add':item.capacity>2}"></span>
								</td>
								<td class="price_per_night text-right">
										
									<ul class="clearUL info-list" ng-show="item.discount>0">
										<li class="old-price"><span>USD</span> <span><% item.price - (item.price * item.discount/100) | currency:'$':2 %></span></li>
										<li class="price"><span class="lb">USD</span> <span class="val"><% item.price | currency:'$':2 %></span></li>
									</ul>

									<ul class="clearUL info-list" ng-show="item.discount<=0">
										<li class="price"><span class="lb">USD</span> <span class="val"><% item.price | currency:'$':2 %></span></li>
									</ul>

								</td>
								<td class="room text-center" {{ isset($bookingId) ? 'colspan="2"' : '' }}>
									
									@if(!isset($bookingId))

										<div class="btn-group">
										  <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="min-width: 125px;">
										    <span ng-show="!item.room_selected">{{ trans('content.general.select_room') }}</span>
										    <span ng-show="item.room_selected"><% item.room_selected %> {{ trans('content.general.room') }}</span>
										  </button>
										  <div class="dropdown-menu" ng-hide="bookingInfo">
										  	@for($i=1;$i<10;$i++)
										    	<a class="dropdown-item" href="javascript:void(0)" ng-click="item.room_selected = {{ $i }}; item.erro_select_room=false;">{{ $i }}</a>
										    @endfor
										  </div>
										</div>
									@else
										<span><% bookingInfo.room %> {{ trans('content.general.room') }}</span>
									@endif
								</td>
								@if(!isset($bookingId))
								<td class="action text-center">
									@if(!isset($bookingId))
										<button class="btn btn-primary full-radius no-border size-sm" ng-click="selectRoom(item)">{{ trans('content.general.book_now') }}</button>
										<p ng-show="item.erro_select_room" style="color: red; margin-bottom: 0;margin-top: 5px;">
											<span>Note**</span> <span>Please select room</span>
										</p>
									@endif
									{{-- <pre><% bookingInfo | json %></pre> --}}
								</td>
								@endif
							</tr>
							{{-- <tr colspan="6" class="space size-sm"><td></td></tr> --}}
						</tbody>

						<tbody>
							<tr colspan="6" class="space size-sm"><td></td></tr>
						</tbody>


					</table>
					<a href="#fill-info" class="fillInfoPopup">&nbsp;</a>
				</div>	



				{{-- description --}}	
				<div class="description marg-top-20" ng-cloak>
					<h5 class="title">{{ trans('content.general.more_about') }} <% hotelInfo.name %></h5>
					<p>
						<% hotelInfo.description %>
					</p>
				</div>




			</div>

		</div>


		@include('includes.elements.comp.popup-fill-info')


	</section>

@stop


@section('scripts')


@stop
