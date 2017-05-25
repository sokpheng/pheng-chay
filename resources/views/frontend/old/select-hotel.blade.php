@extends('layouts.default')

@section('content')	

	@include("includes.elements.section.main-booking")

	<section class="select-hotel padding-section display-flex flex-end" ng-controller="selectHotelCtrl">

		<div class="max-container no-padd" style="position: relative; width: 100%">

			<div class="select-hotel-container">

				<div class="breadcrums-multi-step text-center">
					<ol class="cd-multi-steps text-bottom count">
						<li class="visited"><a href="#0">{{ trans('content.general.check_in') }}</a></li>
						<li class="current"><em>{{ trans('content.general.select_hotel') }}</em></li>
						<li><em>{{ trans('content.general.review') }}</em></li>
						<li class="finish"><em>{{ trans('content.general.done') }} <span class="icon-check"></span></em></li>
					</ol>
				</div>

				<hr class="line-col-fade-left-right marg-md md-width">

				<div class="row">
					
					@if(isset($neverTrue))
						<div class="col-sm-3">

							{{-- <pre>{{ print_r($bookingSearchInfo, true) }}</pre> --}}
							{{-- <pre><% booking | json %></pre> --}}
							<div class="list-group filter-link">
							
								<form name="frmSearch" class="search-form marg-bottom-20">
									<h5 class="_sub_title no-marg">Search result for:</h5>
									<div class="form-group">
										<input type="text" name="search_text" class="form-control bg-gray" placeholder="type something to search ..." ng-model="filter.searchTxt" ng-model-options="{ debounce: 1500 }" ng-change="searchNow()" style="height: 45px;">
										<button type="button" class="btn-submit bt-clear-style"><span class="icon-search"></span></button>
									</div>
								</form>


								<div class="sub-list-group">

									<div class="list-group-item sub-active marg-top-0 display-flex flex-items-xs-middle">
										<h5 class="_sub_title no-marg flex-1">Popular Search</h5>
									</div>

									<div class="list-group-container">

										<?php

											// $popular = array('Phnom Penh', 'Siem Reap', 'Wi-Fi', 'Breakfast', 'Swimming Pool');
											$popular = array(
												array(
													'title' => 'Phnom Penh',
													'slug' => 'phnom-penh',
													'locale' => array(
														'kh' => array(
															'title' => 'Phnom Penh In Khmer'
														)
													)
												),
												array(
													'title' => 'Siem Reap',
													'slug' => 'siem-reap',
													'locale' => array(
														'kh' => array(
															'title' => 'Siem Reap In Khmer'
														)
													)
												),
												array(
													'title' => 'Sihanouk Vill',
													'slug' => 'sihanouk-vill',
													'locale' => array(
														'kh' => array(
															'title' => 'Sihanouk Vill Khmer'
														)
													)
												),
												array(
													'title' => 'Kom Pot',
													'slug' => 'kom-pot',
													'locale' => array(
														'kh' => array(
															'title' => 'Kom Pot In Khmer'
														)
													)
												),
												array(
													'title' => 'Wi-Fi',
													'slug' => 'wi-fi',
													'locale' => array(
														'kh' => array(
															'title' => 'Wi-Fi In Khmer'
														)
													)
												),
												array(
													'title' => 'Breakfast',
													'slug' => 'breakfast',
													'locale' => array(
														'kh' => array(
															'title' => 'Breakfast In Khmer'
														)
													)
												),
												array(
													'title' => 'Swimming Pool',
													'slug' => 'swimming-pool',
													'locale' => array(
														'kh' => array(
															'title' => 'Swimming Pool In Khmer'
														)
													)
												),
											);

										?>

										<span id="popularData" class="dataTmp" ng-init="popular={{ json_encode($popular) }}"></span>

										<div class="list-group-item" ng-repeat="item in popular" ng-cloak>

											<label class="custom-control custom-checkbox" ng-init="item.checked = checkSelectOnFirstLoad(item)">
											  	<input type="checkbox" class="custom-control-input" ng-model="item.checked" ng-change="locationSearch(item)" ng-model-options="{ debounce: 500 }">
											  	<span class="custom-control-indicator"></span>
											  	<span class="custom-control-description"><% item.title %></span>
											</label>

										</div>

									</div>

								</div>



								<div class="sub-list-group">

									<div class="list-group-item sub-active marg-top-0 display-flex flex-items-xs-middle marg-bottom-20">
										<h5 class="_sub_title no-marg flex-1">Price Per Night</h5>
									</div>

									<div class="list-group-container">
										<br>
										<div id="price-range-slider" class="flat-slider"></div>
										<br>
										<span ng-cloak>USD <b class="val" style="color: orange"><% min_price | currency:'$':2 %></b></span> - <span ng-cloak>USD <b class="val" style="color: orange"><% max_price | currency:'$':2 %></b></span>
									</div>

								</div>

								<div class="sub-list-group">

									<div class="list-group-item sub-active marg-top-0 display-flex flex-items-xs-middle marg-bottom-10">
										<h5 class="_sub_title no-marg flex-1">Star Rate</h5>
									</div>

									<div class="list-group-container">

									  	<ul class="clearUL rate-star default-col hidden-xs-up">
									  		<li class="d-inline-block"><span class="icon-star"></span></li>
									  		<li class="d-inline-block"><span class="icon-star"></span></li>
									  		<li class="d-inline-block"><span class="icon-star"></span></li>
									  		<li class="d-inline-block"><span class="icon-star"></span></li>
									  		<li class="d-inline-block"><span class="icon-star"></span></li>
									  	</ul>
									  	<div class="rate-star">
									  		<span uib-rating template-url="{{ asset('template/rating.html') }}" ng-model="rate" max="5" read-only="isReadonly" on-hover="hoveringOver(value)" on-leave="overStar = null;" ng-change="leaveStar()" titles="['one','two','three']" aria-labelledby="default-rating" state-on="'icon-star'" state-off="'icon-star icon-star_border'"></span>
									  	</div>

									</div>

								</div>


								@if(isset($neverTrue))
									<div class="sub-list-group">

											<div class="list-group-item sub-active marg-top-0 display-flex flex-items-xs-middle">
												<h5 class="_sub_title no-marg flex-1">Accommodation type</h5>
											</div>

											<div class="list-group-container">
												<?php

													// $type = array('Hotel', 'Guest House', 'Breakfast', 'Swimming Pool');

													$accommodation = array(
														array(
															'title' => 'Hotel',
															'slug' => 'hotel',
															'locale' => array(
																'kh' => array(
																	'title' => 'Hotel In Khmer'
																)
															)
														),
														array(
															'title' => 'Guest House',
															'slug' => 'guest-house',
															'locale' => array(
																'kh' => array(
																	'title' => 'Guest House In Khmer'
																)
															)
														),
														array(
															'title' => 'Breakfast',
															'slug' => 'breakfast',
															'locale' => array(
																'kh' => array(
																	'title' => 'Breakfast In Khmer'
																)
															)
														),
														array(
															'title' => 'Swimming Pool',
															'slug' => 'swimming-pool',
															'locale' => array(
																'kh' => array(
																	'title' => 'Swimming Pool In Khmer'
																)
															)
														),
													);

												?>
												<span id="accommodationData" class="dataTmp" ng-init="accommodation={{ json_encode($accommodation) }}"></span>

												<div class="list-group-item" ng-repeat="item in accommodation" ng-cloak>

													<label class="custom-control custom-checkbox" ng-init="item.checked = checkSelectOnFirstLoad(item)">
													  	<input type="checkbox" class="custom-control-input" ng-model="item.checked" ng-change="advanceSearchFilter(item, true)">
													  	<span class="custom-control-indicator"></span>
													  	<span class="custom-control-description"><% item.title %></span>
													</label>

												</div>

											</div>

									</div>
								@endif


							</div>

						</div>
					@endif

					<div class="col-sm-12">
						

						<div class="filter-box">
							<h5 class="title d-inline-block no-marg">{{ trans('content.general.select_your_hotel') }}</h5>

							@if(isset($neverTrue))
								<ul class="float-xs-right">

									<li class="d-inline-block dropdown">

									  	<a class="btn btn-secondary dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Price</a>

									  	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
										    <a class="dropdown-item" href="#">Lower</a>
										    <a class="dropdown-item" href="#">Higher</a>
									  	</div>

									</li>
								</ul>
							@endif

						</div>

						@include('includes.elements.list.hotel-list')

					</div>

				</div>



			</div>

		</div>

	</section>

@stop


@section('scripts')


@stop
