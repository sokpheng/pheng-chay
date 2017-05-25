@extends('layouts.default')



@section('scripts_top')

	<?php

		//	 payment 
		$payment_methods = [];
		if($restuarntInfo['payment_methods']){
			$payment_methods = array_map(function ($item) { 
				return $item['display_name']; 
			}, $restuarntInfo['payment_methods']);
		}
		$payment_methods = implode(', ', $payment_methods);

		// category
		$categories = [];
		if($restuarntInfo['categories']){
			$categories = array_map(function ($item) { 
				return $item['display_name']; 
			}, $restuarntInfo['categories']);
		}

		$categories = json_encode($categories,JSON_PRETTY_PRINT);

		// echo '<pre>'.$categories.'</pre>'; die();
		$lat = '';
		$lag = '';

		if(isset($restuarntInfo['loc'])){
			$lat = $restuarntInfo['loc']['coordinates'][1];
			$lag = $restuarntInfo['loc']['coordinates'][0];
		}

		$galleryTmp = [];

		foreach($restuarntInfo['gallery'] as $galleryItem){
			if($galleryItem['partial_type'] === 'gallery'){	
				$tmp = array(
					  "@type"	=> "ImageObject",
					  "url"	=> $galleryItem['zoom_url_link'],
					  "name"	=> $restuarntInfo['directory_name']
					);

				array_push($galleryTmp, $tmp);
			}
		}

		$galleryTmp = json_encode($galleryTmp,JSON_PRETTY_PRINT);;
		// echo '<pre>'.print_r(json_encode($galleryTmp),true).'</pre>'; die();

		$open_time = '08:00-18:00';
		if(isset($restuarntInfo['open_times']) && sizeof($restuarntInfo['open_times'])>0){
			$time = $restuarntInfo['open_times']['monday'];
			if($time){

				$chkCamma = explode(',', $time);

				if(sizeof($chkCamma)>1){

					$first_time24 = explode('-', $chkCamma[0]);

					if(sizeof($first_time24)>1){
						$starTime = date("H:i", strtotime($first_time24[0]));
					}

					$second_time24 = explode('-', $chkCamma[1]);

					if(sizeof($second_time24)>1){
						$endTime = date("H:i", strtotime($second_time24[1]));
					}


					$open_time = $starTime.'-'.$endTime;
				}
				else{
					$time24 = explode('-', $time);

					if(sizeof($time24)>1){
						$starTime = date("H:i", strtotime($time24[0]));
						$endTime = date("H:i", strtotime($time24[1]));

						$open_time = $starTime.'-'.$endTime;
					}
				}
			}

		}

		$bg_style = 'bg-normal';

		$_logo = asset('img/comp/restaurant-logo.png');

		if(isset($restuarntInfo['logo'])){
			if(isset($restuarntInfo['logo']['small_url_link']) && $restuarntInfo['logo']['small_url_link']!=''){
				$_logo = $restuarntInfo['logo']['small_url_link'];
				$_style = 'box-shadow: 0 0 4px rgba(0, 0, 0, 0.5);';
				$bg_style = 'bg-contain';

			}
		}


	?>


	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "Restaurant",
	  "address": {
	    "@type": "PostalAddress",
	    "addressRegion": "{{ $restuarntInfo['location'] }}",
	    "streetAddress": "{{ $restuarntInfo['address'] }}"
	  },
	  "aggregateRating": {
	    	"@type": "AggregateRating",
	    	"ratingValue": "{{ HungryModule::getStarRate($restuarntInfo) }}",
	    	"reviewCount": "{{ $restuarntInfo['count_comment'] }}",
			"bestRating" : 5,
			"worstRating" : 0
	  },
	  "name": "{{ $restuarntInfo['directory_name'] }}",
	  "description": "{{ $restuarntInfo['description'] }}",
	  "openingHours": "Mo,Tu,We,Th,Fr,Sa,Su {{ $open_time }}",
	  "priceRange": "{{ HungryModule::getDollarSimbol($restuarntInfo['price_rate']) }}",
	  "servesCuisine": {!! $categories !!},
	  "image" : {!! $galleryTmp !!},
	  "logo" : {
		  "@type": "ImageObject",
		  "contentUrl": "{{ $_logo }}",
		  "description": "{{ $restuarntInfo['description'] }}",
		  "name": "{{ $restuarntInfo['directory_name'] }}"
		},
	  "geo": {
	    "@type": "GeoCoordinates",
	    "latitude": "{{ $lat }}",
	    "longitude": "{{ $lag }}"
	  },
	  "paymentAccepted" : "{{ $payment_methods }}",
	  "telephone": "{{ sizeof($restuarntInfo['phone_numbers']) > 0 ? $restuarntInfo['phone_numbers'][0] : '' }}",
	  "url": "{{ HungryModule::getRestDetailLink($restuarntInfo) }}"
	}
	</script>

@stop

@section('content')	

	
	<div class="restaurant-detail" ng-controller="restaurantViewCtrl">


		{{-- <span ng-init="restId='{{ $restuarntInfo['_id'] }}'"></span> --}}

		@if(isset($setAsRead) && $setAsRead != '')
			<span ng-init="setNotificationAsRead('{{ $setAsRead }}')"></span>
		@endif

		<div class="bg-blur bg-cover" style="background-image: url({{ asset('img/tmp/detail/blur-bg.jpg') }})"></div>

		<div class="padding-section big-padding no-padd-xs">

			<div class="max-container no-padd">

				<div class="restaurant-info-box marg-bottom-30">
					
					<div class="basic-info display-flex dis-col-xxs flex-items-xs-middle">
						
						<div class="info flex-1">
							<div class="media text-xs-center text-md-left">

								<?php

									$_style = '';

									$_directory_name = HungryModule::getLangCate($restuarntInfo,'directory_name');
									$_address = HungryModule::getLangCate($restuarntInfo,'address');
									$_description = HungryModule::getLangCate($restuarntInfo,'description');
									$_short_description = HungryModule::getLangCate($restuarntInfo,'short_description');

								?>

							  	<div class="media-left {{ $bg_style }}" style="background-image: url({{ $_logo }}); {{ $_style  }}"></div>
							  	<div class="media-body">
							  		
								    <h1 class="media-heading link-secondary-col1">{{ $_directory_name }}</h1>
								  	<div class="feature">
								  		{{ $_short_description }}

								  		@if(sizeof($restuarntInfo['categories'])>0)
									  		<b>
									  			{{ HungryModule::getHighlightCate($restuarntInfo['categories']) }}
									  		</b>
									  		<span>&nbsp;&nbsp; -- &nbsp;&nbsp;</span>
								  		@endif
								  		<b class="_price hidden-xs-up1" style="font-size: 18px; color: #d0021b;">
											{{ HungryModule::getDollarSimbol($restuarntInfo['price_rate']) }}
								  		</b>
								  	</div>
								  	
								  	<div>
								  		<span class="address">{{ $_address }}</span>
								  	</div>

								  	<span class="phone">
								  		@foreach($restuarntInfo['phone_numbers'] as $key => $_phones)
								  			@if($_phones !='')
									  			<span>
									  				(855) {{ $_phones }}
									  			</span>
								  			@endif
								  			@if(!$loop->last)
								  				<span> / </span>
								  			@endif
								  		@endforeach
								  	</span>

								  	@if(isset($restuarntInfo['commune']['display_name']) && $restuarntInfo['commune']['display_name']!='')
									  	<span>&nbsp;&nbsp; -- &nbsp;&nbsp;</span>
									  	<span class="address">{{ $restuarntInfo['commune']['display_name'] or '' }}</span>
								  	@endif

								  	@if(isset($neverTrue) && isset($restuarntInfo['min_price']) && isset($restuarntInfo['max_price']))
									  	<span>&nbsp;&nbsp; -- &nbsp;&nbsp;</span>
									  	<b>{{ trans('content.general.price_range') }} : </b>
									  	<?php
											// setlocale(LC_MONETARY,"en_US");
											$_minPrice = '$'. number_format($restuarntInfo['min_price'], 2, '.', ',');
											$_maxPrice = '$'. number_format($restuarntInfo['max_price'], 2, '.', ',');
									  	?>
									  	<span class="price_range">{{ $_minPrice }}</span> {{ trans('content.general.to') }} <span class="price_range">{{ $_maxPrice }}</span>
								  	@endif


								  	{{-- correct br for some empty value --}}
								  	@if(sizeof($restuarntInfo['phone_numbers'])>0)

								  		@if($restuarntInfo['phone_numbers'][0]!= '')

								  			<br/>

								  		@endif

								  	@else

								  		@if(isset($restuarntInfo['commune']['display_name']) && $restuarntInfo['commune']['display_name']!='')

								  			<br/>

								  		@endif

								  	@endif

								  	{{-- <br> --}}
								  	<br>
								  	<!-- Go to www.addthis.com/dashboard to customize your tools --> 
								  	<div class="addthis_inline_share_toolbox"></div>

							  	</div>
								{{-- 						  	<div class="_rate display-flex flex-items-xs-middle">
							  		<span class="_val">8.4</span>
							  	</div> --}}
							</div>
						</div>
						{{-- ------------------------- --}}
						{{--  button favorite and share--}}
						{{-- ------------------------- --}}
						<div class="option">  {{-- <pre> {{print_r($restuarntInfo,true)}}</pre> --}}

							@if(AuthGateway::isLogin())
								<button type="button" class="btn btn-primary full-radius icon_inside no-border btn-toggle" ng-init="is_save_active='{{ isset($restuarntInfo['saved'])?true:false}}'" ng-class="{'active':is_save_active}" ng-click="save('{{ $restuarntInfo['_id'] }}')" ng-cloak>
									<span class="icon-turned_in"></span>
									<span class="_text text-uppercase" ng-show="is_save_active">{{ trans('content.user.saved') }}</span>
									<span class="_text text-uppercase" ng-show="!is_save_active">{{ trans('content.user.save') }}</span>
								</button>
							@else

								<a href="{{ $baseUrlLang.'/login?b='.URL::full() }}" class="btn btn-primary full-radius icon_inside no-border btn-toggle">
								<span class="icon-turned_in"></span> {{ trans('content.user.save') }}
								</a>

							@endif

							@include('includes.elements.comp.rating-option',['rating_cls'=>'hidden-md-up d-inline-block','rating_box_size'=>'size-md'])

						</div>

					</div>
					<div class="gallery-group-cell">

						<div class="carousel" data-flickity='{ "groupCells": true, "contain": true,"draggable": false , "pageDots": false, "lazyLoad": true, "bgLazyLoad": true, "bgLazyLoad": 1 }'>

							@if(count($restuarntInfo['gallery'])>0)

								@foreach($restuarntInfo['gallery'] as $galleryItem)
									@if($galleryItem['partial_type'] === 'gallery')
								  		<a href="{{ $galleryItem['zoom_url_link'] }}" class="carousel-cell" data-flickity-bg-lazyload="{{ $galleryItem['thumbnail_url_link'] }}"></a>
								  	@endif
								@endforeach

							@else



							@foreach(array(1,2,3,4,5) as $item)
							  	<div class="carousel-cell"></div>
							@endforeach

							@endif

						</div>
					</div>

					<div class="restaurant-menu-bar">
						<div class="display-flex flex-items-xs-middle">
							<div class="flex-1">

								<?php

									$_photoCount = isset($restuarntOptions['count_photo_comment'])?$restuarntOptions['count_photo_comment']:0;

									$_reviewCount = $restuarntOptions['count'];

								?>

								<ul class="nav nav-pills border-bottom" role="tablist">
								  	<li class="nav-item">
								    	<a class="nav-link active" data-toggle="tab" href="#about-restaurant" role="tab"><span class="_title">{{ trans('content.general.overview') }}</span></a>
								  	</li>
								  	<li class="nav-item">
								    	<a class="nav-link" data-toggle="tab" href="#review" role="tab"><span class="_title">{{ trans_choice('content.detail.review', $_reviewCount) }}</span> <span class="_count" ng-cloak  ng-init="count_review='{{ $_reviewCount }}'" ><%count_review%> </span></a>
								  	</li>
								  	<li class="nav-item">
								    	<a class="nav-link" data-toggle="tab" href="#photos" role="tab"><span class="_title">{{ trans_choice('content.user.photo', $_photoCount) }}</span> <span class="_count" ng-cloak  ng-init="count_photo='{{ $_photoCount }}'"><%count_photo%></span></a>
								  	</li>
{{-- 								  	<li class="nav-item hidden-lg-up">
								    	<a class="nav-link" data-toggle="tab" href="#restInfo" role="tab"><span class="_title">{{ trans('content.general.rest_info') }}</span></a>
								  	</li> --}}
								</ul>
							</div>
							@include('includes.elements.comp.rating-option',['rating_cls'=>'hidden-sm-down','rating_box_size'=>'size-md'])
						</div>

					</div>

				</div>

				<div class="row space10 space0-md space0-xs">
					{{-- ------------------------- --}}
					{{-- comment block --}}
					{{-- ------------------------- --}}
					<div class="col-lg-8">

						<div class="tab-content tab-default tab-reviews">


							{{-- tap review --}}
						  	<div class="tab-pane fade in active" id="about-restaurant" role="tabpanel">

						  		@include('includes.elements.comp.rest-overview')

						  	</div>

						  	<div class="tab-pane fade" id="review" role="tabpanel">

								<div class="comment-form-control display-flex1 flex-items-xs-top1" style="position: relative;">

									<img class="user-profile-img size-xs float-xs-left" ng-cloak ng-show="user.profile.photo" ng-src="<%user.profile.photo.thumbnail_url_link%>" alt="<%user.profile.full_name%>">
									<img class="user-profile-img size-xs float-xs-left" ng-cloak ng-hide="user.profile.photo" src=" {{asset('img/tmp/user.png')}}" alt="<%user.profile.full_name%>">

									{{-- <textarea name="" class="flex-1 form-control" placeholder="say something about mails restaurant ..."></textarea> --}}
									<div class="flex-1 comment-editor" contenteditable="true" ng-model="comment_text" strip-br="true" strip-tags="true" select-non-editable="true" placeholder="{{ trans('content.detail.write_your_comment_here') }} ..."></div>

								    {{-- <div class="flex-1 comments-editor" contenteditable="true" placeholder="Enter text here..."></div> --}}

								    <div class="post-action">
										<button type="" class="bt-clear-style upload-img" ng-class="{'has-image':file_upload.length>0}" ngf-select="upload_image($files)"  ngf-accept="'image/*'" ngf-multiple="true" > <span class="_val" ng-show="file_upload.length>0"> <% file_upload.length %> {{ trans_choice('content.general.image',1) }}</span> <span class="icon-add_a_photo"></span></button>		
										<button  type="button" class="btn btn-primary btn-primary--fx text-uppercase" ng-click="post('{{ $restuarntInfo['_id'] }}')" ng-class="{'btn-loading': isPosting}" ng-disabled="isPosting">
											<img class="center-absolute _loading-icon size-sm" src="{{ asset('img/svg/loading/loading-spin-white.svg') }}" alt="login loading"> 
											<span class="_text">{{ trans_choice('content.user.post',1) }}</span>
										</button>
								    </div>

								</div>

								<div class="white-border"></div>

						  		<div class="header border-bottom"><h2 class="_title"><span class="icon-question_answer"></span><span class="_text" ><span ng-cloak><% count_review %></span> {{ trans_choice('content.detail.review', $_reviewCount) }}</span></h2></div>
						  		<div class="content-tab review-list">
						  			{{-- <pre>{{print_r($restuarntOptions['comments'],true)}}</pre> --}}
						  			{{-- ------------------------- --}}
						  			{{-- render comment items --}}
						  			{{-- ------------------------- --}}
						  			<div ng-cloak ng-show="comments">
					  					<div class="media review-item" ng-repeat = "comment in comments | orderBy: '_created_at':true ">
										  	<a class="media-left" href="#">
										    	
										    	<img class="media-object" ng-cloak ng-show="user.profile.photo" ng-src="<%user.profile.photo.thumbnail_url_link%>" alt="<%user.profile.full_name%>">
										    	<img class="media-object" ng-cloak ng-hide="user.profile.photo" src=" {{asset('img/tmp/user.png')}}" alt="<%user.profile.full_name%>">
										 	</a>
										  	<div class="media-body">
										    	<h5 class="media-heading"><%user.profile.full_name%> <span class="_post-time float-xs-right" ng-cloak><% getTime(comment._created_at) %></span></h5>
										    	<p class="_comment">
										    		<%comment.description%>
										    	</p>

										    	
										    	{{-- <div class="image-user-uploaded bg-cover" style="background-image: url(<% comment.gallery[0].src %>);" ng-show="comment.gallery"></div> --}}
										    	
										    	{{-- <pre> --}}
										    		{{-- <% comment.gallery | json %> --}}
										    	{{-- </pre> --}}

									    		<div class="row space5" ng-show="comment.gallery">
										    		
									    			<div ng-class="{ 'col-xs' : comment.gallery.length <= 4, 'col-sm-3 col-xs-4' : comment.gallery.length > 4, 'hidden-xs-up' : checkMoreThenEight($index) }" ng-repeat="_galleryItem in comment.gallery" on-finish-render="finishedPhotoUpload">
									    				<a href="<% _galleryItem.src %>" class="photoReview">

									    					<div class="image-user-uploaded bg-cover marg-bottom-10" ng-class="{ 'size-sm' : comment.gallery.length > 4, 'hidden-xs-up' : checkHidden($index, comment.gallery) && checkShowMore($index, comment.gallery) }" style="background-image: url(<% _galleryItem.src %>);"></div>

									    					<div class="image-user-uploaded bg-cover marg-bottom-10" ng-class="{'size-sm' : comment.gallery.length > 4, 'hidden-xs-up' : !checkShowMore($index, comment.gallery)}">
									    						<span class="_text center-absolute">{{ trans('content.general.see_more') }}</span>
									    					</div>

									    				</a>
									    			</div>

									    		</div>

										  	</div>
										</div>
						  			</div>
						  		

						  			@foreach($restuarntOptions['comments'] as $item)
										<div class="media review-item">
										  	<a class="media-left" href="{{$baseUrlLang . '/' .$item['user']['_id'].'/'. str_slug($item['user']['profile']['full_name'],'-')  }}">
										    	<img class="media-object" src=" {{ (isset( $item['user']['profile']['photo'] ) &&   $item['user']['profile']['photo'])?$item['user']['profile']['photo']['thumbnail_url_link']: asset('img/tmp/user.png')}}" alt="panhna">
										 	</a>
										  	<div class="media-body">

										    	<h5 class="media-heading">
										    		<a href="{{$baseUrlLang . '/' .$item['user']['_id'].'/'. str_slug($item['user']['profile']['full_name'],'-')  }}">
										    			{{ $item['user']['profile']['full_name'] }} <span class="_post-time float-xs-right" ng-cloak><% getTime('{{ $item['_created_at'] }}')  %></span>
										    		</a>
										    	</h5>
										    	<p class="_comment">
										    		{{ $item['description'] }} 
										    	</p>

										    	@if($item['gallery'])
										    		{{-- <div class="image-user-uploaded bg-cover" style="background-image: url({{ $item['gallery'][0]['preview_url_link']}});"></div> --}}
										    		<div class="row space5">
											    		@foreach($item['gallery'] as $galKey => $itemGallery)

											    			<?php

											    				$cls = 'col-xs';

											    				if(sizeof($item['gallery']) > 4){
											    					$cls = 'col-sm-3 col-xs-4';
											    				}

											    				if($galKey>=7){
											    					$cls .= ' hidden-xs-up';
											    				}

											    			?>


												    		@if(sizeof($item['gallery'])>8)

												    			@if($galKey==7)
													    			<div class="col-sm-3 col-xs-4"> 
													    				<a href="{{ $item['gallery'][7]['zoom_url_link']}}" class="photoReview">
													    					<div class="image-user-uploaded bg-cover marg-bottom-10 {{ sizeof($item['gallery'])> 4 ? 'size-sm' : '' }}">
													    						<span class="_text center-absolute">{{ trans('content.general.see_more') }}</span>
													    					</div>
													    				</a>
													    			</div>
													    			@continue
												    			@endif

												    		@endif

											    			<div class="{{ $cls }}">
											    				<a href="{{ $itemGallery['zoom_url_link']}}" class="photoReview">
											    					<div class="image-user-uploaded bg-cover marg-bottom-10 {{ sizeof($item['gallery'])> 4 ? 'size-sm' : '' }}" style="background-image: url({{ $itemGallery['preview_url_link']}});"></div>
											    				</a>
											    			</div>

											    			{{-- @break($galKey == 6) --}}

											    		@endforeach



										    		</div>
										    	@endif
										  	</div>
										</div>

									@endforeach
									

									@if(count($restuarntOptions['comments'])<=0)
										<div class="empty-msg-box text-capitalize">
											<span class="_text">{{ trans('content.detail.no_review_on_this_restaurant') }}</span>
										</div>
									@endif

									{{-- <br> --}}

						  		</div>
						  	</div>
						  	{{-- ------------------------- --}}

						  	{{-- tap photo --}}
						  	{{-- ------------------------- --}}
						  	<div class="tab-pane fade" id="photos" role="tabpanel">
						  		
						  		<div class="header border-bottom"><h2 class="_title"><span class="icon-photo_camera"></span><span class="_text"><span ng-cloak><% count_photo%></span> {{ trans_choice('content.user.photo', $_photoCount) }}</span></h2></div>

								@if(count($restuarntOptions['comments'])<=0)
									<div class="empty-msg-box text-capitalize">
										<span class="_text">{{ trans('content.detail.no_photo_post_on_this_restaurant') }}</span>
									</div>
								@else

								  	<div class="simple-image-list" >
								  		
								  		<div class="row space10">
							  				<div class="col-sm-4" ng-repeat="gallery in galleries" ng-show = "galleries">
										  		<div class="image-item bg-cover display-flex flex-items-xs-bottom overflow-hidden" style="background-image: url(<%gallery.photo%>)">
										  			<div class="image-info display-flex flex-items-xs-middle flex-1 show-on-hover">
										  				<img class="user-profile-img default-space size-xs" ng-src="<%gallery.user.profile.photo.thumbnail_url_link%>" alt="panhna" ng-show="gallery.user.profile.photo">
										  				<img class="user-profile-img default-space size-xs" src="{{ asset('img/tmp/user.png')}}" alt="panhna" ng-hide="gallery.user.profile.photo">
										  				<div class="name">
										  					<span class="_user_name d-block"><%gallery.user.profile.full_name%></span>
										  					<span class="_post-time"><% formatTime() %></span>
										  				</div>
										  			</div>
										  		</div>
							  				</div>

								  			@foreach($restuarntOptions['comments'] as $item)
									  			@foreach($item['gallery'] as $gallery)
									  				<div class="col-sm-4">

												  		<div class="image-item bg-cover display-flex flex-items-xs-bottom overflow-hidden" style="position: relative;background-image: url({{ $gallery['preview_url_link'] }})" >

												  			<a href="{{ $gallery['zoom_url_link'] }}" class="center-absolute _photoEle"></a>

												  			<div class="image-info display-flex flex-items-xs-middle flex-1 show-on-hover">


												  				<a href="{{$baseUrlLang . '/' .$item['user']['_id'].'/'. str_slug($item['user']['profile']['full_name'],'-')  }}">
												  					<img class="user-profile-img default-space size-xs" src="{{  (isset( $item['user']['profile']['photo'] ) &&   $item['user']['profile']['photo'])?$item['user']['profile']['photo']['thumbnail_url_link']: asset('img/tmp/user.png')}}" alt="panhna">
												  				</a>
												  				{{-- <div class="name"> --}}
												  					<a href="{{$baseUrlLang . '/' .$item['user']['_id'].'/'. str_slug($item['user']['profile']['full_name'],'-')  }}" class="name"> 
												  						<span class="_user_name d-block">{{ $item['user']['profile']['full_name'] }}</span>
												  						<span class="_post-time"><% formatTime('{{ $item['_created_at'] }}')  %></span>
												  					</a>
												  				
												  				{{-- </div> --}}
												  			</div>
												  		</div>
									  				</div>
									  			@endforeach
								  			@endforeach
								  		</div>

								  	</div>

								@endif

						  	</div>

						</div>

					</div>

					<div class="col-lg-4">

						@include('includes.elements.comp.right-side-info-detail',['_cls'=>'hidden-md-down'])
						
					</div>

				</div>	
			
			</div>

		</div>

	</div>


@stop


@section('scripts')


@stop

