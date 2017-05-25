<div class="simple-footer border-top">
	<div class="padding-section padd-left-right">
			
		<div class="max-container no-padd need-padd">
			<div class="footer-menu">
			  	<div class="row space0-xs flex-items-xs-top">
			    	<div class="col-md-3 col-sm-12">
			    		<div>
				    		<a class="" href="{{ $baseUrlLang }}">
			            	<img class="main-logo img-fluid" style="max-height: 55px;" src="{{ asset('img/logo-text.png') }}" alt="Camboroom">
			         	</a>
			    		</div>
		         	<p class="desc-company">
		         		{{ trans('content.footer.say_something_about_hungry') }}
		         	</p>
			    	</div>
			    	<div class="col-md-2 col-sm-3">
			    		<h5>{{ trans('content.footer.hungry_hungry') }}</h5>
			    		<ul class="menu_list">
			    			{{-- <a href="{{ URL::action('RestaurantController@restaurantType', [$type]) }}" class="btn btn-outline-primary btn-radius">{{ trans('content.general.check_more') }}</a> --}}
			    			<li><a href="{{ $baseUrlLang.'/restaurant/new' }}" title="{{ trans('content.general.new_restaurant') }}">{{ trans('content.general.new_restaurant') }}</a></li>
			    			<li><a href="#" title="{{ trans('content.general.categories') }}">{{ trans('content.general.category') }}</a></li>
			    			<li><a href="{{ $baseUrlLang.'/restaurant/locations' }}" title="{{ trans('content.general.locations') }}">{{ trans('content.general.locations') }}</a></li>
			    			<li><a href="{{ $baseUrlLang.'/restaurant/recommendation' }}" title="{{ trans('content.general.recommendation') }}">{{ trans('content.general.recommendation') }}</a></li>
			    		</ul>
			    	</div>
			    	<div class="col-md-2 col-sm-3">
			    		<h5>{{ trans('content.footer.about_us') }}</h5>
			    		<ul class="menu_list">
			    			<li><a href="{{ $baseUrlLang.'/contact-us' }}" title="{{ trans('content.footer.hungry_hungry') }}">{{ trans('content.footer.hungry_hungry') }}</a></li>
			    			<li><a href="{{ $baseUrlLang.'/contact-us' }}" title="{{ trans('content.general.advertisment') }}">{{ trans('content.general.advertisment') }}</a></li>
			    			<li><a href="{{ $baseUrlLang.'/contact-us' }}" title="{{ trans('content.general.our_partners') }}">{{ trans('content.general.our_partners') }}</a></li>
			    			<li><a href="{{ $baseUrlLang.'/contact-us' }}" title="{{ trans('content.footer.sponsor') }}">{{ trans('content.footer.sponsor') }}</a></li>
			    		</ul>
			    	</div>
			    	<div class="col-md-2 col-sm-3">
			    		<h5>{{ trans('content.footer.learn_more') }}</h5>
			    		<ul class="menu_list">
			    			<li><a href="{{ $baseUrlLang.'/terms-privacy' }}" title="{{ trans('content.footer.terms_policy_privacy') }}">{{ trans('content.footer.terms_policy_privacy') }}</a></li>
			    			<li><a href="{{ $baseUrlLang.'/contact-us' }}" title="{{ trans('content.footer.contact_us') }}">{{ trans('content.footer.contact_us') }}</a></li>
			    			<li><a href="{{ $baseUrlLang.'/feedback' }}" title="{{ trans('content.footer.feedback') }}">{{ trans('content.footer.feedback') }}</a></li>
			    			<li><a href="{{ $baseUrlLang.'/sitemap' }}" title="{{ trans('content.footer.sitemap') }}">{{ trans('content.footer.sitemap') }}</a></li>
			    		</ul>
			    	</div>
			    	<div class="col-md-2 col-sm-3">
			    		<h5>{{ trans('content.footer.connect') }}</h5>
			    		<ul>
			    			<li class="_social">
			    				<a href="#" title=""><span class="icon-facebook"></span></a>
			    		{{-- 		<a href="#" title=""><span class="icon-twitter"></span></a>
			    				<a href="#" title=""><span class="icon-instagram"></span></a>
			    				<a href="#" title=""><span class="icon-google"></span></a> --}}
			    				<a href="#" title=""><span class="icon-youtube"></span></a>
			    			</li>
			    			<li class="_email">
			    				<a href="mailto:info@hungryhungry?subject=feedback">info@hungryhungry</a>
			    			</li>
			    			<li class="_lang">
								<div class="btn-group">

									@if ($lang === 'en')
									  	<a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									   	<img src="{{ asset('img/en_icon.jpg') }}" alt="english language">
									   	<span class="_text">{{ trans('content.footer.english') }}</span>
									  	</a>
									  	<div class="dropdown-menu dropdown-menu-right">
										   <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('kh') }}">
										    	<img src="{{ asset('img/kh_icon.jpg') }}" alt="english language">
										    	<span class="_text">{{ trans('content.footer.khmer') }}</span>
										   </a>
									  	</div>
								  	@else
									  	<a href="{{ LaravelLocalization::getLocalizedURL('kh') }}" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									   	<img src="{{ asset('img/kh_icon.jpg') }}" alt="english language">
									   	<span class="_text">{{ trans('content.footer.khmer') }}</span>
									  	</a>
									  	<div class="dropdown-menu dropdown-menu-right">
										   <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('en') }}">
										    	<img src="{{ asset('img/en_icon.jpg') }}" alt="english language">
										    	<span class="_text">{{ trans('content.footer.english') }}</span>
										   </a>
									  	</div>
								  	@endif
								</div>
			    			</li>
			    		</ul>
			    	</div>
			  	</div>
		  	</div>

			<a class="scroll-top" href="#" ng-click="scrollToEle('')">
			   	<span class="icon-arrow-up"></span>
			</a>

	  	</div>

  	</div>
  	<div class="copy-right">
  		<h6 class="_text">{{ trans('content.footer.copy_right') }} <a href="http://www.flexitech.io" target="_blank" class="dev_link" title="Flexitech Cambodia">Flexitech</a>.</h6>
  	</div>
</div>