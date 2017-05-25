<section class="main-booking padding-section big-padding section-bg-gray display-flex flex-end {{ !isset($is_home) ? 'height-md' : '' }}">

	<div class="max-container no-padd" style="position: relative; width: 100%">
	{{-- <pre><% booking | json %></pre> --}}
		<div class="booking-form-container">
 
			@if(isset($is_home))
				<h2 class="_title text-center {{ $lang }}">{!! trans('content.general.say_something_about_cambodroom') !!}</h2>
			@endif

			@if(!isset($bookingId))
				<span id="b-data" ng-init="booking={{ json_encode($bookingSearchInfo) }}"></span>

				<form name="frmBooking" action="{{$baseUrlLang.'/booking-search' }}" class="booking-form display-flex {{ !isset($is_home) ? 'out-of-box' : '' }} ">
				{{-- <form name="frmBooking" action="{{ URL::to('/booking-search') }}" class="booking-form display-flex {{ !isset($is_home) ? 'out-of-box' : '' }} "> --}}

					<input type="hidden" name="lang" value="{{ $lang }}">

					<div class="form-group search-box border-mobile">
						<input type="text" style="font-size: 20px;" ng-model="booking.search_text" placeholder="{{ trans('content.general.type_your_des') }} ..." class="override-col-placeholder form-control" name="search_text">
					</div>

					<div class="booking-date d-inline-block border-mobile">

						<div class="form-group d-inline-block no-marg" >
				            <span class="icon-insert_invitation"></span>
				            <input type='text' class="override-col-placeholder form-control" name="check_in_date" placeholder="Check In" id="checkIn" />
				        </div>

						<div class="form-group d-inline-block no-marg" >
				            <span class="icon-insert_invitation"></span>
				            <input type='text' class="override-col-placeholder form-control" name="check_out_date" placeholder="Check Out" id="checkOut" />
				        </div>

					</div>

					<div class="dropdown show">
					  	<a class="btn btn-secondary dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span ng-cloak><% booking.room %></span> {{ trans('content.general.room') }}</a>
					  	<input type="hidden" name="room" ng-value="booking.room">
					  	<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					  		@for($i=1;$i<=10;$i++)
						    	<a class="dropdown-item" href="#" ng-click="booking.room={{ $i }}">{{ $i }}</a>
						    @endfor
					  	</div>
					</div>

					<div class="dropdown show">
					  	<a class="btn btn-secondary dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span ng-cloak><% booking.adult %></span> {{ trans('content.general.adult') }}</a>
					  	<input type="hidden" name="adult" ng-value="booking.adult">
					  	<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					  		@for($i=1;$i<=10;$i++)
						    	<a class="dropdown-item" href="#" ng-click="booking.adult={{ $i }}">{{ $i }}</a>
						    @endfor
					  	</div>
					</div>

					<div class="dropdown show">
					  	<a class="btn btn-secondary dropdown-toggle" href="https://example.com" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span ng-cloak><% booking.children %></span> {{ trans('content.general.children') }}</a>
					  	<input type="hidden" name="children" ng-value="booking.children">
					  	<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					  		@for($i=0;$i<=10;$i++)
						    	<a class="dropdown-item" href="#" ng-click="booking.children={{ $i }}">{{ $i }}</a>
						    @endfor
					  	</div>
					</div>

					@if(isset($hotelId))
						<input type="hidden" name="re" value="{{ Request::path() }}">
					@endif

					<button class="btn btn-primary d-inline-block text-uppercase">{{ trans('content.general.search_now') }}</button>

				</form>
			@endif


		</div>

	</div>

</section>