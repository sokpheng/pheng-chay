@extends('layouts.default')

@section('content')	

	<div class="search-filter-section padding-section big-padding marg-top-50" ng-controller="searchCtrl">

		<div class="max-container no-padd">

			<?php
				$main_cate = array('Just Open', 'Most Favorite', 'Best Price', 'Party Place', 'Familry Place');


				$popularCate = array(

									array(
										'name'	=> 'all',
										'display_name'	=> trans('content.general.all'),
										'slug'	=> 'all'
									),
									array(
										'name'	=> 'area',
										'display_name'	=> trans('content.general.area'),
										'slug'	=> 'area'
									),
									array(
										'name'	=> 'category',
										'display_name'	=> trans('content.general.category'),
										'slug'	=> 'category'
									),
									array(
										'name'	=> 'food_drink',
										'display_name'	=> trans('content.general.food_drink'),
										'slug'	=> 'food_drink'
									),
									array(
										'name'	=> 'promotion',
										'display_name'	=> trans('content.general.promotion'),
										'slug'	=> 'promotion'
									),
									array(
										'name'	=> 'purpose',
										'display_name'	=> trans('content.general.purpose'),
										'slug'	=> 'purpose'
									),
									array(
										'name'	=> 'time',
										'display_name'	=> trans('content.general.time'),
										'slug'	=> 'time'
									),
									array(
										'name'	=> 'near_by',
										'display_name'	=> trans('content.general.near_by'),
										'slug'	=> 'near_by'
									),
								);

			$restCate = array(
								array(
									'display_name'	=>	trans('content.general.recommendation'),
									'name'	=>	'recommendation',
									'slug'	=>	'recommendation',
								),
								array(
									'display_name'	=>	trans('content.general.new_restaurant'),
									'name'	=>	'newRes',
									'slug'	=>	'new',
								),
								array(
									'display_name'	=>	trans('content.general.purpose'),
									'name'	=>	'purposes',
									'slug'	=>	'purpose',
								),
								array(
									'display_name'	=>	trans('content.general.coupons'),
									'name'	=>	'coupons',
									'slug'	=>	'coupon',
								),
								// array(
								// 	'display_name'	=>	'Locations',
								// 	'name'	=>	'location',
								// 	'slug'	=>	'location',
								// ),
							);

			?>

			<div class="row">

				@if(isset($neverTrue))
					<div class="col-lg-3 hidden-md-down1">
						<div class="list-group filter-link box-shadow" ng-class="{'active-filter':showFilter}">

							<div class="list-group-item active marg-top-0">
								<h1 class="_title _main_title no-marg text-uppercase">{{ trans('content.general.search') }} <span ng-click="showFilter=false" class="hidden-lg-up float-xs-right">X</span></h1>
							</div>
							<div class="list-group-container gray-style">
								@foreach($restCate as $item)
									<div class="list-group-item">
										<div class="display-flex flex-items-xs-middle" >
											<a href="{{ URL::action('RestaurantController@restaurantType',[$item['slug']]) }}" class="link-black _title flex-1 no-marg text-capitalize">
												{{ $item['display_name'] }}
											</a>
											{{-- <span class="icon-check_circle float-xs-right right-icon"></span> --}}
										</div>
									</div>
								@endforeach
							</div>

							{{-- advance search --}}
							@include('includes.elements.comp.advance-search')


						</div>
					</div>
				@endif

				<div class="col-lg-12" ng-init="text_search='{{ $search_text or '' }}'">
					
					<div class="text-xs-center">
						<img class="img-fluid" src="{{ asset('/img/tmp/ads-smart.gif') }}" alt="promotion smart">
						<br>
					</div>

					@if(isset($neverTrue))
					<div class="search-container marg-bottom-20 hidden-sm-down">

	               {{ Form::open(array(
	                  'action' => 'RestaurantController@searchPostText',
	                  'name' => 'home_search',
	                  'accept-charsetme' => 'utf-8',
	                  'method' => 'POST',
	                  )) }}
							<div class="input-group search-box ">
						      <input type="text" class="form-control" aria-label="Text input with radio button" ng-model="text_search" name="text_search" placeholder="{{ trans('content.general.type_here_to_search') }}" value="">
						      <button type="submit" class="input-group-addon btn btn-primary">
						  			<span class="icon-search"></span>
						  			<span class="_text text-uppercase">{{ trans('content.general.search') }}</span>
						      </button>
						      <a href="{{ URL::to('/map#/?search=') }}<% getUrlToMap() %>" class="input-group-addon btn btn-primary">
							      <span class="icon-room"></span>
							      <span class="_text text-uppercase">{{ trans('content.general.map') }}</span>
						      </a>
						   </div>
					   {{ Form::close() }} 
					</div>
					@endif

					<div class="result-list">

						{{-- top-cate-filter --}}
						@include('includes.elements.comp.top-cate-filter',array('on_search_page'=>true))
						
						<h4 class="result-title marg-bottom-20 marg-top-30 no-padd">
							@if(isset($search_text))
								<span class="text-primary-col">{{ $rest_option['total'] or 0 }} </span>
								@if($search_text!='')
									<span class="normal-col">{{ trans('content.general.result_found_of') }}</span>
									<span class="text-primary-col">{{ $search_text }}</span>
								@else
									<span class="normal-col">{{ trans('content.general.of_all_rest') }}</span>
								@endif

							@elseif(isset($rest_type))
								<span class="text-primary-col">{{ $rest_option['total'] or 0 }} </span>
								<span class="normal-col">{{ trans('content.general.result_found_of') }}</span>
								<span class="text-primary-col">{{ $rest_type }}</span>
							@else
								<span class="text-primary-col">{{ trans('content.general.recent_restaurant') }}</span>
							@endif
							{{-- <span ng-click="showFilter=true;" class="hidden-lg-up float-xs-right"> --}}
							<a href="#map_advance_filter" class="popupAdvanceFilter float-xs-right hidden-xs-up">
								{{-- {{ trans('content.general.show_filter') }} --}}
								<span class="icon-tune"></span> <span class="_text hidden-sm-down">{{ trans('content.general.show_filter') }}</span>
							{{-- </span> --}}
							</a>
							<?php

								$_searchText = Input::all();

							?>
							@if(isset($_searchText['s']) && $_searchText['s']!='')
								<a href="{{ $baseUrlLang.'/search?s=' }}" class="float-xs-right">{{ trans('content.general.clear_filter') }}</a>
							@endif
						</h4>

						<div class="simple-product-box">

							@if(!isset($isLocation) && !isset($isCateogry))

							<div class="row flex-items-xs-top space10">
								{{-- @for($i=1;$i<=20;$i++) --}}

								@foreach($restuarntList as $restItem)

									<?php
										$img_by_cate = array('food','food_1','food_2','food_3','ads','recommend-rest-1','recommend-rest-2','recommend-rest-3','recommend-rest-4');

										$img_by_cate_rand =$img_by_cate[rand(0, sizeof($img_by_cate)-1)];

										if($isCoupon)
											$restUrl = 'javascript:void(0)';
										else
											$restUrl = HungryModule::getRestDetailLink($restItem);
										// echo '<pre>'. print_r($restItem,true).'</pre>';

						  				$_directory_name = HungryModule::getLangCate($restItem,'directory_name');
									?>

									{{-- <div class="col-md-4 col-sm-6"> --}}
									<div class="col-lg-3 col-md-6 col-sm-6">
										{{-- URL::to('/restaurant/1023-metro-hassakan') --}}
										<a href="{{ $restUrl }}" class="box-item d-block marg-bottom-20 opacity-hover">
											<div class="img-container" style="background-image: url({{ HungryModule::getRestCover($restItem)  }})">
												@if($isCoupon)
													<div class="discount">
														<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="70" viewBox="0 0 23 32">
															<path fill="#fff" d="M20.786 2.286q0.411 0 0.786 0.161 0.589 0.232 0.938 0.732t0.348 1.107v23.018q0 0.607-0.348 1.107t-0.938 0.732q-0.339 0.143-0.786 0.143-0.857 0-1.482-0.571l-7.875-7.571-7.875 7.571q-0.643 0.589-1.482 0.589-0.411 0-0.786-0.161-0.589-0.232-0.938-0.732t-0.348-1.107v-23.018q0-0.607 0.348-1.107t0.938-0.732q0.375-0.161 0.786-0.161h18.714z"></path>
														</svg>
														<span class="_dis_value">{{ $restItem['discount'] }}%</span>
													</div>
												@endif
											</div>
											{{-- <div class="overlay-bg color_md"></div> --}}
											@if(!$isCoupon)
												<div class="info">
													<div class="main_title link-black-hover">{{ $_directory_name }}</div>
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
												</div>
											@endif
										</a>
									</div>

								@endforeach
							</div>

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
		
		</div>


		{{-- popup advance filter for restaurant --}}
		@include('includes.elements.comp.popup-advance-filter')


	</div>


@stop



@section('scripts')

@stop