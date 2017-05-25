@extends('layouts.default')

@section('content')	

	<div class="user-profile padding-section big-padding" ng-controller="userViewCtrl">

		<div class="max-container no-padd">

			<div class="profile-with-menu-tab display-flex flex-items-xs-middle marg-top-50">
				<div class="profile-info flex-1">
					<div class="media review-item ">
					  	
				  		@if($isMe)

				  			<a class="media-left user-profile-img size-md _opacityLoading bg-cover" href="javascript:void(0)" ng-style="{ 'background-image' : 'url('+profilePhoto+')'}" style="position: relative;" ngf-select="uploadProfilePhoto($file);"  ngf-accept="'image/*'" ng-init="setProfilePhoto(' {{ (isset( $user['profile']['photo'] ) &&   $user['profile']['photo'])?$user['profile']['photo']['thumbnail_url_link']: asset('img/tmp/user.png')}}')">
				    			{{-- <img class="media-object user-profile-img size-md _hover" ng-init="setProfilePhoto(' {{ (isset( $user['profile']['photo'] ) &&   $user['profile']['photo'])?$user['profile']['photo']['thumbnail_url_link']: asset('img/tmp/user.png')}}')" ng-src1="<% profileTmp.profilePhoto %>" alt="{{$user['profile']['full_name']}}" > --}}
				    			<img class="center-absolute _loading-icon size-sm" ng-cloak  ng-class="{'isLoading' : isUploading}" style="width: 40px;" src="{{ asset('img/svg/loading/loading-spin-white.svg') }}" alt="login loading">
				    		</a>
				    	@else
				    		<div class="media-left user-profile-img size-md">
				    			<img class="media-object user-profile-img size-md" src="{{ (isset( $user['profile']['photo'] ) &&   $user['profile']['photo'])?$user['profile']['photo']['thumbnail_url_link']: asset('img/tmp/user.png')}}" alt="{{$user['profile']['full_name']}}"  ng-cloak >
				    		</div>
				    	@endif

					  	<div class="media-body media-middle">
					    	<h4 class="media-heading">
					    		<b class="_name">{{ $user['profile']['full_name'] }}</b> 
					    		@if($isMe)
					    			<a href="javascript:void(0)" class="float-sm-right1 bt-edit"  ng-click="gotoSetting()"><span class="icon-pencil"></span>{{ trans('content.user.edit') }}</a>
					    		@endif
					    	</h4>
					    	<p class="_comment" ng-init="user.profile.description = '{{ $user['profile']['description'] or '' }}'" ng-cloak>
					    	{{-- 	{{isset($user['profile']['description'])?isset($user['profile']['description']):''}} --}}
					    		<% user.profile.description?user.profile.description: '' %>

					    	</p>
					  	</div>
					</div>
				</div>


				<?php

					$_postPlural = 1;
					$_photoPlural = 1;
					$_savePlural = 1;

					if($user['count_comment']>1)
						$_postPlural = $user['count_comment'];

					if($user['count_photo']>1)
						$_photoPlural = $user['count_photo'];

					if($user['count_saved']>1)
						$_savePlural = $user['count_saved'];
				?>

				<ul class="clearUL activities">
					<li><span class="_count">{{ $user['count_comment'] }}</span><span class="_text">{{ trans_choice('content.user.post',$_postPlural) }} </span></li>
					<li><span class="_count">{{ $user['count_photo']}}</span><span class="_text">{{ trans_choice('content.user.photo',$_photoPlural) }} </span></li>
					<li><span class="_count">{{ $user['count_saved'] }}</span><span class="_text">{{ trans_choice('content.user.save',$_savePlural) }} </span></li>
				</ul>
			</div>
			<ul class="nav nav-pills border-bottom bg-primary-col" role="tablist">
			  	<li class="nav-item">
			    	<a class="nav-link open-post" data-toggle="tab" href="#post" role="tab"><span class="icon-paper-plane"></span> <span class="_title">{{ trans_choice('content.user.post',2) }}</span></a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link open-photo" data-toggle="tab" href="#photos" role="tab"><span class="icon-photo_camera"></span><span class="_title">{{ trans_choice('content.user.photo',2) }}</span></a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link open-save" data-toggle="tab" href="#saved" role="tab"><span class="icon-favorite"></span><span class="_title">{{ trans_choice('content.user.save',2) }}</span></a>
			  	</li>
							
			  	@if($isMe)
			  	<li class="nav-item">
			    	<a class="nav-link open-setting" data-toggle="tab" href="#setting" role="tab"><span class="icon-settings"></span><span class="_title">{{ trans('content.user.setting') }}</span></a>
			  	</li>
			  	@endif
			</ul>

			
			<div class="row marg-top-30">
				<div class="col-lg-8">
					<div class="tab-content my-review">


						<?php

                           $profileImg = asset('img/tmp/user.png');

                           if(isset($user['profile'])){ 
                              	if(isset($user['profile']['photo']))
                                 	$profileImg = isset($user['profile']['photo']['thumbnail_url_link']) ? $user['profile']['photo']['thumbnail_url_link'] : $profileImg;


                           }
						?>


						{{-- ----------- POST ---------- --}}
						<div class="tab-pane fade in active" id="post">
				  			@foreach($user['comments'] as $item)
								<div class="media review-item">
								 	 <a class="media-left" href="#">
								    	<img class="media-object  user-profile-img" src="{{ $profileImg }}" alt="{{ $user['profile']['full_name'] }}">
								 	</a>
								  	<div class="media-body">
								    	<h5 class="media-heading">{{ $user['profile']['full_name'] }} <span class="_post-time float-xs-right" ng-cloak><% getTime('{{ $item['_created_at'] }}')  %></span></h5>
								    	<p class="_comment">
								    		{{ $item['description'] }} 
								    	</p>

								    	@if($item['gallery'])
								    		<div class="image-user-uploaded bg-cover" style="background-image: url({{ $item['gallery'][0]['preview_url_link']}});"></div>
								    	@endif
								  	</div>
								</div>

							@endforeach 

							@if(count($user['comments'])<=0)
								<div class="empty-msg-box text-capitalize">
									<span class="_text">{{ trans('content.user.no_review') }}</span>
								</div>
							@endif

						</div>

						{{-- ----------- Photos ---------- --}}
						<div class="tab-pane fade" id="photos">
						
						  	<div class="simple-image-list no-padd">
						  		
						  		<div class="row space10">
						
						  			@foreach($user['comments'] as $item)
							  			@foreach($item['gallery'] as $gallery)
							  				<div class="col-sm-4">
										  		<div class="image-item bg-cover display-flex flex-items-xs-bottom overflow-hidden" style="position: relative;background-image: url({{ $gallery['preview_url_link'] }})">

										  			<a href="{{ $gallery['preview_url_link'] }}" class="center-absolute _photoEle"></a>

										  			<div class="image-info display-flex flex-items-xs-middle flex-1 show-on-hover">
										  				<img class="user-profile-img default-space size-xs" src="{{ $profileImg }}" alt="{{ $user['profile']['full_name'] }}">
										  				<div class="name">
										  					<span class="_user_name d-block">{{ $user['profile']['full_name'] }}</span>
										  					<span class="_post-time"><% formatTime('{{ $item['_created_at'] }}')  %></span>
										  				</div>
										  			</div>
										  		</div>
							  				</div>
							  			@endforeach
						  			@endforeach

						  		</div>


								@if(count($user['comments'])<=0)
									<div class="empty-msg-box text-capitalize">
										<span class="_text">{{ trans('content.user.no_photo') }}</span>
									</div>
								@endif


						  	</div>
						</div>

						{{-- ----------- Saved ---------- --}}
						<div class="tab-pane fade" id="saved">
							
							<div class="simple-product-box">
								<div class="row flex-items-xs-top space10">
									
									@foreach($user['saved-rest'] as $item)
										<?php
											$restItem = $item['directory_detail'];
											$restUrl = URL::action('RestaurantController@restaurantDetail', [$restItem['_id'],$restItem['slug']]);
											// $url = (isset( $restItem['gallery'][0]) &&  $restItem['gallery'][0]['preview_url_link'] )?$restItem['gallery'][0]['preview_url_link']: '';
										?>
										<div class="col-md-4 col-sm-6">
											<a href="{{ $restUrl }}" class="box-item d-block marg-bottom-20 opacity-hover">
												<div class="img-container" style="background-image: url({{ HungryModule::getRestCover($restItem) }})"></div>
												<div class="info">
													<div class="main_title link-black-hover">{{ $restItem['directory_name'] }}</div>
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
																	// $rateCount = 0;
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

														</li>
													</ul>
												</div>
											</a>
										</div>
									@endforeach

								</div>

								@if(count($user['saved-rest'])<=0)
									<div class="empty-msg-box text-capitalize">
										<span class="_text">{{ trans('content.user.no_saved') }}</span>
									</div>
								@endif

							</div>

						</div>
					
					@if($isMe)
						{{-- ----------- Setting ---------- --}}
						<div class="tab-pane fade" id="setting">
											
							<form class="feedback-fmr flat-control-form-border no-padd" method="post" ng-init="initUser('{{ $user['profile']['full_name'] or ''}}','{{$user['profile']['phone_number'] or ''}}','{{ $user['profile']['description'] or ''}}','{{$user['email'] or ''}}')">
						
								<div class="form-group marg-lg">
								    <input type="text" class="form-control" placeholder="{{ trans('content.user.full_name') }} *" required="" ng-model="user.profile.full_name">
							  	</div>

								<div class="form-group marg-lg">
								    <input type="email" class="form-control" placeholder="{{ trans('content.user.email') }} *" disabled ng-model="user.email">
							  	</div>

								<div class="form-group marg-lg">
								    <input type="text" class="form-control" placeholder="(855)-xxx-xxxx" ng-model="user.profile.phone_number">
							  	</div>

								<div class="form-group marg-lg">
								   <input type="password" class="form-control" placeholder="{{ trans('content.user.password') }}" value="love" required="" disabled>
								   <a href="#changePassword" class="float-xs-right bt-change-pass open-popup-link"><span class="icon-pencil"></span>&nbsp;{{ trans('content.user.change_password') }}</a>
							  	</div>

								<div class="form-group marg-lg marg-top-501">
								   <textarea class="form-control" placeholder="Description" required="" ng-model="user.profile.description"></textarea>
							  	</div>

							  	<div class="text-xs-center  marg-top-50">
							  		<button type="" class="btn btn-outline-primary btn-bigger text-uppercase" ng-click="save()"><b>{{ trans_choice('content.user.save',1) }}</b></button>
							  	</div>

							  	<br>

							</form>
						</div>

				@endif	

					</div>
				</div>
				<div class="col-lg-4 hidden-md-down">
					{{-- @include('includes.elements.list.you-might-also-like') --}}
					{{-- {{ print_r($user['you_may_like'],true) }} --}}
					@include('includes.elements.list.you-might-also-like', array('restList'=>$user['you_may_like']))
				</div>
			</div>
			

			<div id="changePassword" class="magnific-popup __default mfp-hide size-sm">
				
				<div class="header-popup">
					<h4 class="title text-primary-col text-xs-center text-uppercase">{{ trans('content.user.change_password') }}</h4>
				</div>

				{{ Form::open(array(
				   'action'	=> 'HomeController@changeUserPassword',
				   'name' => 'change_pass',
				   'accept-charsetme' => 'utf-8',
				   'method' => 'POST',
				   'class' => 'flat-control-form-border padd-top-0'
				   )) }}

						<div class="form-group has-danger">
						    <input type="password" name="password" ng-model="user.password" class="form-control" placeholder="{{ trans('content.user.current_password') }} *" required="" minlength="8">
							<div ng-messages="registerFrm.password.$error" role="alert" ng-show="registerFrm.password.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.pls_enter_val_pass') }}</div>
	
							    <div ng-message="minlength"  class="form-control-feedback">{{ trans('content.user.pass_min_less_char') }}</div>
							</div>
					  	</div>

						<div class="form-group has-danger">
						    <input type="password" name="new_password" ng-model="user.new_password" class="form-control" placeholder="{{ trans('content.user.new_password') }} *" required="" minlength="8">
							<div ng-messages="registerFrm.new_password.$error" role="alert" ng-show="registerFrm.new_password.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.pls_enter_val_pass') }}</div>
	
							    <div ng-message="minlength"  class="form-control-feedback">{{ trans('content.user.pass_min_less_char') }}</div>
							</div>
					  	</div>

						<div class="form-group has-danger" >
						    <input type="password" name="confirm_password" ng-model="user.confirm_new_password" class="form-control" placeholder="{{ trans('content.user.confirm_password') }} *" required="">
							<div ng-show="(USER.confirm_password != USER.password) && registerFrm.confirm_password.$dirty && registerFrm.password.$dirty" role="alert" ng-cloak>
								<div class="form-control-feedback">{{ trans('content.user.password_confirm_password_is_not') }}</div>

							</div>
					  	</div>

					  	<div class="text-xs-center  marg-top-50">
					  		<button type="" class="btn btn-outline-primary btn-bigger text-uppercase" ng-click="saveChangePass()"><b>{{ trans_choice('content.user.save',1) }}</b></button>
					  	</div>

					  	<input type="hidden" name="data" ng-value="data.encrypted">
					  	<input type="hidden" name="data_pass" ng-value="data.encrypted_pass">


				{{ Form::close() }} 

			</div>



		
		</div>

	</div>


@stop