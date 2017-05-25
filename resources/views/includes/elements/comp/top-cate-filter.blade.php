	
		<?php
		  	$filterSelectBox = ['area','category','food_drink','time','purposes','feature','payment_method','parking'];

		  	// feature,origin,payment_method,parking

		  	// $topCategoryHome['payment_method'] = $orgin_payment_parking['payment_method'];
		  	// $topCategoryHome['feature'] = $orgin_payment_parking['feature'];
		  	// $topCategoryHome['parking'] = $orgin_payment_parking['parking'];

		  	$topCateTitle = array(
		  						'all'	=>	array(
		  										'title'	=> trans('content.general.all'),
		  										'icon'	=> 'icon-favorite',
		  									),
		  						'area'	=>	array(
		  										'title'	=> trans('content.general.area'),
		  										'icon'	=> 'icon-pin_drop',
		  									),
		  						'category'	=>	array(
		  										'title'	=> trans('content.general.cuisine'),
		  										'icon'	=> 'icon-restaurant_menu',
		  									),
		  						'food_drink'	=>	array(
		  										'title'	=> trans('content.general.categories'),
		  										'icon'	=> 'icon-local_bar',
		  									),
		  						'purposes'	=>	array(
		  										'title'	=> trans('content.general.purpose'),
		  										'icon'	=> 'icon-weekend',
		  									),
		  						'time'	=>	array(
		  										'title'	=> trans('content.general.time'),
		  										'icon'	=> 'icon-schedule',
		  									),
		  						// 'feature'	=>	array(
		  						// 				'title'	=> trans('content.general.features'),
		  						// 				'icon'	=> 'icon-local_play',
		  						// 			),
		  						// 'payment_method'	=>	array(
		  						// 				'title'	=> trans('content.general.payment_methods'),
		  						// 				'icon'	=> 'icon-monetization_on',
		  						// 			),
		  						// 'parking'	=>	array(
		  						// 				'title'	=> trans('content.general.parking'),
		  						// 				'icon'	=> 'icon-transfer_within_a_station',
		  						// 			)
		  					);
		  	

		?>

		<ul class="menu-with-border-bottom no-border-mobile scroll-on-mobile" ng-init="searchParam='{{ Input::get('s') }}'">


			<?php

				$_searchText = Input::all();

				if(isset($_searchText['s']))
					$_searchTextObj = explode('--', $_searchText['s']);

				$cityPro = trans('content.city_province');

                // echo '<pre>'. print_r($_searchTextObj,true).'</pre>'; 
                // die();
			?>


			@foreach($topCategoryHome as $type => $topCateItem)
			
				@continue($type=='promotion' || $type == 'promotions')

		  		@if(in_array($type, $filterSelectBox))

					<li class="dropdown">

						<?php

							if(isset($_searchText['s'])){

								foreach ($_searchTextObj as $key => $item) {
									// $checkExited = array_where($topCateItem, function ($value, $keySub) {

									// 	// $_titleTmp = '';

									// 	$collection = collect($topCateItem);

									// 	if(isset($value['title']))
									// 		$filtered = $collection->where('title', 100);
									// 	if(isset($value['directory_name']))
									// 		$filtered = $collection->where('directory_name', 100);
									// 	if(isset($value['display_name']))
									// 		$filtered = $collection->where('display_name', 100);	

									//     // return is_string($value);
									//     return str_slug($_titleTmp,'-') == $item;
									// });

									foreach($topCateItem as $sub_key => $topCate){

										// $_titleTmp = '';
										// if(isset($topCate['title']))
										// 	$_titleTmp = $topCate['title'];
										// if(isset($topCate['directory_name']))
										// 	$_titleTmp = $topCate['directory_name'];
										// if(isset($topCate['display_name']))
										// 	$_titleTmp = $topCate['display_name'];

										$_titleTmp = '';
										if(isset($topCate['title'])){
											$_slugTmp = str_slug($topCate['title'],'-');
											$_titleTmp = HungryModule::getLangCate($topCate,'title');
										}
										if(isset($topCate['directory_name'])){
											$_slugTmp = str_slug($topCate['directory_name'],'-');
											$_titleTmp = HungryModule::getLangCate($topCate,'directory_name');
										}
										if(isset($topCate['display_name'])){
											$_slugTmp = str_slug($topCate['display_name'],'-');
											$_titleTmp = HungryModule::getLangCate($topCate,'display_name');
										}


										

                						// echo '<pre>'. print_r($_slugTmp,true).'</pre>'; 

										if($_slugTmp === str_slug($item,'-')){
											$topCateItem[$sub_key]['selected'] = true;
											// $topCateTitle[$type]['title'] = $_titleTmp;

											if($type == 'area'){
												$slugName = str_slug($_titleTmp,'-');
												if(isset($cityPro[$slugName]))
													$_titleTmp = $cityPro[$slugName];
											}

											$topCateTitle[$type]['title'] = $_titleTmp;

										}


									}

									// $collection = collect($topCateItem);


	                				// echo '<pre>'. print_r($filtered->all(),true).'</pre>'; 


									// if(sizeof($checkExited)>0){
									// 	$topCateTitle[$type]['title'] = $_titleTmp;
									// }
								}
							}

						?>

						<a href="javascript:void(0)" class="dropdown-toggle" ng-class="{'active' : tabSelected == '{{ $type }}' }" id="dropdown_{{$type}}" data-toggle1="tab" role1="tab" title=""  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="{{ $topCateTitle[$type]['icon'] }}"></span> 

							<span class="_text text-capitalize">{{ $topCateTitle[$type]['title'] }}</span>

						</a> 

						<a href="#{{$type}}" data-toggle="tab" role="tab" title="" class="hidden-xs-up"></a>
					  	<div class="dropdown-menu" aria-labelledby="dropdown_{{$type}}" ng-init="{{ $type }}=[]">

					    	@foreach($topCateItem as $key => $topCate)

					    		<?php

									$_title = '';
									if(isset($topCate['title'])){
										$_slug = $topCate['title'];
										$_title = HungryModule::getLangCate($topCate,'title');
									}
									if(isset($topCate['directory_name'])){
										$_slug = $topCate['directory_name'];
										$_title = HungryModule::getLangCate($topCate,'directory_name');
									}
									if(isset($topCate['display_name'])){
										$_slug = $topCate['display_name'];
										$_title = HungryModule::getLangCate($topCate,'display_name');
									}
									
									if($type == 'area'){
										$slugName = str_slug($_title,'-');
										if(isset($cityPro[$slugName]))
											$_title = $cityPro[$slugName];
									}

									// echo $type;

					    		?>

					    		{{-- <pre>{{ print_r($cityPro, true) }}</pre> --}}

					    		@continue($_title=='')
					    		
					    		@if(!isset($on_search_page))
					    			<a class="dropdown-item text-capitalize" href="{{ $baseUrlLang . '/search?s=' . str_slug($_slug,'-') }}" ng-click1="selectItem('{{ $_slug }}', {{ $type }} , '{{ $type }}')">{{ $_title }}</a>
					    		@else
					    			<a class="dropdown-item text-capitalize" href="javascript:void(0)" ng-click="filterTopCate('{{ $_slug }}')">
					    				{{ $_title }} 
					    				@if(isset($topCate['selected']))
					    					<span class="icon-check_circle tick-icon float-xs-right" style="color: #d00021;font-size: 22px;"></span> 
					    				@endif
					    			</a>
					    		@endif

					      	@endforeach
					  	</div>

					</li>

		  		@else

		  			@if(!isset($on_search_page))
						<li><a href="#{{ $type }}" class="{{ $type=='all' ? 'active' : '' }} text-capitalize" ng-click="tabSelected = '{{ $type }}'" data-toggle="tab" role="tab" title=""><span class="{{ $topCateTitle[$type]['icon'] }}"></span> <span class="_text">{{ $topCateTitle[$type]['title'] }}</span></a></li>
					@else
						<li><a href="{{ $baseUrlLang }}" class="text-capitalize"><span class="{{ $topCateTitle[$type]['icon'] }}"></span> <span class="_text">{{ $topCateTitle[$type]['title'] }}</span></a></li>

					@endif

		  		@endif

			@endforeach

			<li><a href="{{ $baseUrlLang . '/map' }}" data-toggle1="tab" role1="tab" title=""><span class="icon-transfer_within_a_station"></span> <span class="_text">{{ trans('content.general.near_by') }}</span></a></li>
			{{-- <li><a href="#map_advance_filter" class="popupAdvanceFilter" title="Advance Filter"><span class="icon-tune"></span> <span class="_text">{{ trans('content.general.advance_filter') }}</span></a></li> --}}
		</ul>