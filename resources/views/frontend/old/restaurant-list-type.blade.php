@extends('layouts.default')

@section('content')	

	<div class="search-filter-section padding-section big-padding1 marg-top-50" ng-controller="searchCtrl">

		<div class="max-container">

			<div class="result-list">
				
				<h4 class="result-title marg-bottom-20 marg-top-30">
					@if(isset($search_text))
						<span class="text-primary-col">{{ $rest_option['total'] or 0 }} </span>
						<span class="normal-col">{{ trans('content.general.result_found_of') }}</span>
						<span class="text-primary-col">{{ $search_text }}</span>
					@elseif(isset($rest_type))
						<span class="text-primary-col">{{ $rest_option['total'] or 0 }} </span>
						<span class="normal-col">{{ trans('content.general.result_found_of') }}</span>
						<span class="text-primary-col">{{ $rest_type }}</span>
					@else
						<span class="text-primary-col">{{ trans('content.general.recent_restaurant') }}</span>
					@endif
					<a href="{{ $baseUrlLang.'/search' }}" class="_filter float-xs-right"><span class="icon-tune"></span> <span class="_text hidden-sm-down">{{ trans('content.general.show_filter') }}</span></a>
				</h4>

				<div class="simple-product-box">

					@if(!isset($isLocation) && !isset($isCateogry))

						<div class="row flex-items-xs-top space10 space0-xs">
							{{-- @for($i=1;$i<=20;$i++) --}}

							@foreach($restuarntList as $key => $restItem)

								<?php
									$img_by_cate = array('food','food_1','food_2','food_3','ads','recommend-rest-1','recommend-rest-2','recommend-rest-3','recommend-rest-4');
									$img_by_cate_rand =$img_by_cate[rand(0, sizeof($img_by_cate)-1)];

									$eventClick = '';
									$clsPopup = '';
									if($isCoupon){
										$restUrl = '#coupon_promotion';
										$_directory_name = $restItem['directory_name'];
										$eventClick = 'ng-click=selectCouponPromo('.$key.')';
										$clsPopup = 'popupCouponPromotion';
									}
									else{
										$restUrl = HungryModule::getRestDetailLink($restItem);
										$_directory_name = HungryModule::getLangCate($restItem,'directory_name');
									}
									// echo '<pre>'. print_r($restItem,true).'</pre>';

									// $_directory_name = HungryModule::getLangCate($restItem,'directory_name');
								?>

								<div class="col-lg-3 col-md-6 col-sm-6">
									{{-- URL::to('/restaurant/1023-metro-hassakan') --}}
									<a href="{{ $restUrl }}" class="box-item d-block marg-bottom-20 opacity-hover {{ $clsPopup }}" {{ $eventClick }}>
										<div class="img-container" style="position: relative;background-image: url({{ HungryModule::getRestCover($restItem)  }})">
											@if($isCoupon)
												<div class="coupon">
													<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="70" viewBox="0 0 23 32">
														<path fill="#fff" d="M20.786 2.286q0.411 0 0.786 0.161 0.589 0.232 0.938 0.732t0.348 1.107v23.018q0 0.607-0.348 1.107t-0.938 0.732q-0.339 0.143-0.786 0.143-0.857 0-1.482-0.571l-7.875-7.571-7.875 7.571q-0.643 0.589-1.482 0.589-0.411 0-0.786-0.161-0.589-0.232-0.938-0.732t-0.348-1.107v-23.018q0-0.607 0.348-1.107t0.938-0.732q0.375-0.161 0.786-0.161h18.714z"></path>
													</svg>
													<span class="_dis_value">{{ $restItem['discount'] }}%</span>
												</div>
											@endif
										</div>
										{{-- <div class="overlay-bg color_md"></div> --}}
										{{-- @if(!$isCoupon) --}}
											<div class="info">
												<div class="main_title link-black-hover">{{ $_directory_name }}</div>

												@if(isset($neverTrue))
													<ul class="clearUL">
														<li>
															<div class="_cate d-inline-block text-overflow">
																{{ HungryModule::getHighlightCate($restItem['categories']) }}
															</div>
														</li>
														<li>
															<div class="_rate d-inline-block">
																<?php
																	$rateCount = HungryModule::getStarRate($restItem);
																?>
																@for($i=1; $i<= 5;$i++)
																	@if($i<=$rateCount)
																		<span class="icon-star"></span>
																	@else
																		<span class="icon-star_border"></span>
																	@endif
																@endfor
															</div>
															<div class="price_level d-inline-block float-xs-right"><span class="_lb">Price: </span><b class="_val"> 
																{{ HungryModule::getDollarSimbol($restItem['price_rate']) }}
															</b></div>
															<div class="_features d-inline-block float-xs-right hidden-xs-up">
																{{-- <span class="icon-cake"></span> --}}
																{{-- <span class="icon-wifi"></span> --}}
																{{-- <span class="icon-smoking_rooms"></span> --}}

																<?php
																	$features = HungryModule::getFeatureIcon($restItem);
																?>

																@foreach($features as $item)

																	<span class="{{ $item['icon_name'] }}"></span>

																@endforeach

															</div>
														</li>
													</ul>
												@endif


												@if(!$isCoupon)

													<ul class="clearUL">
														<li>
															<div class="_cate d-inline-block text-overflow">

																{{ HungryModule::getHighlightCate($restItem['categories']) }}

															</div>
														</li>
														<li>

															<div class="_rate d-inline-block">

																<?php
																	$rateCount = HungryModule::getStarRate($restItem);
																?>

																@for($i=1; $i<= 5;$i++)
																	@if($i<=$rateCount)
																		<span class="icon-star"></span>
																	@else
																		<span class="icon-star_border"></span>
																	@endif
																@endfor

															</div>

															<div class="price_level d-inline-block float-xs-right"><span class="_lb">{{ trans('content.general.price') }} : </span><b class="_val">

																{{ HungryModule::getDollarSimbol($restItem['price_rate']) }}

															</b></div>

															<div class="_features d-inline-block float-xs-right hidden-xs-up">
	 
																{{-- <span class="icon-cake"></span> --}}
																{{-- <span class="icon-wifi"></span> --}}
																{{-- <span class="icon-smoking_rooms"></span> --}}

																<?php
																	$features = HungryModule::getFeatureIcon($restItem);
																?>

																@foreach($features as $item)

																	<span class="{{ $item['icon_name'] }}"></span>

																@endforeach

															</div>

														</li>
													</ul>

												@else

													<ul class="clearUL terms">
														<li><span>{{ trans('content.general.coupon_term_1') }}</span></li>
														<li><span>{{ trans('content.general.coupon_term_2') }}</span></li>
													</ul>

													<h5 class="expire-date">
														<span class="1icon-schedule1">{{ trans('content.general.expired_on') }} </span>
														<?php
															$_date = date_create($restItem['end_date_at']);
														?>
														<span class="_date float-xs-right">{{ date_format($_date,"d M Y") }}</span>
													</h5>

												@endif

											</div>
										{{-- @endif --}}
									</a>
								</div>

							@endforeach
						</div>

						@if($isCoupon)
							<span ng-init="couponPromo = {{ json_encode($restuarntList) }}"></span>
							@include('includes.elements.comp.coupon-promotion-popup')
							{{-- <pre><% couponPromo | json %></pre> --}}
						@endif

					@endif
				</div>
				@if(isset($emptyData) && $emptyData )
					<br>
					<div class="alert alert-info" role="alert">
					  <strong>{{ trans('content.general.empty') }} !!</strong> {{ trans('content.general.no_result_with_your_search') }}
					</div>
				@endif

			</div>

			<br>
			
			@if(isset($emptyData) && !$emptyData && $rest_option['total']>=20)

				<?php
					// var offset = ($scope.proPage * $scope.itemPerPage) - $scope.itemPerPage;
					// $currentPage = 0;
					// $itemPerPage = 0;

					// if($rest_option['total'])
				?>

				<span ng-init="currentPage={{ $rest_page }};totalItem={{ $rest_option['total'] }};maxSize=8; _url='{{ URL::current() }}';itemPerPage=20"></span>

				<div class="text-xs-center">
					<ul uib-pagination total-items="totalItem" ng-model="currentPage" items-per-page="itemPerPage" max-size="maxSize" template-url="{{ asset('template/pagination.html') }}" class="pagination-md" boundary-link="true" force-ellipses="true" rotate="true" previous-text="Previous" next-text="Next" ng-change="pageChanged()"></ul>
				</div>

			@endif

		</div>

	</div>


@stop



@section('scripts')

	<script type="text/javascript" src="{{ asset('js/hh/search.js') }}"></script>

@stop