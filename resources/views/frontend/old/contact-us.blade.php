@extends('layouts.default')

@section('content')	

	<div ng-controller="contactUsCtrl" class="contact-us">
		
		<div id="map" style="position: relative;" class="_map full-section">
			{{-- <div class="overlay-bg"></div> --}}
{{-- 
				<ui-gmap-google-map center='map.center' zoom='map.zoom' draggable="true" options="map.options" events="map.events" control="map.control">
					<ui-gmap-marker coords="marker.coords" options="marker.options" events="marker.events" idkey="marker.id"></ui-gmap-marker>

					<ui-gmap-marker

							coords="marker.coords" options="marker.options"
							fit="false"
							icon="marker.options.icon" 
							events="marker.events" idkey="marker.id"
							>

				</ui-gmap-google-map> --}}

		</div>


		<section class="feature-section padding-section big-padding">

			<div class="max-container no-padd-sm" style="position: relative;">

				<div class="title-overlay text-xs-center">
					<h2 class="main_title primary_col text-uppercase">{{ trans('content.footer.contact_us') }}</h2>
					<h5 class="sub_title">{!! trans('content.contact.contact_us_desc') !!}</h5> 
				</div>

				<ul class="clearUL simple-section-box-item text-xs-center">
					<li class="lg-size">
						<span class="icon-ring_volume sm-size col-primary"></span>
						<b class="_title sm-size marg-top-20 d-block">{{ trans('content.contact.any_question') }}</b>
						<span class="_sub_title">{{ trans('content.contact.my_phone') }}</span>
					</li>
					<li class="lg-size">
						<span class="icon-markunread sm-size col-primary"></span>
						<b class="_title sm-size marg-top-20 d-block">{{ trans('content.contact.write_us_a_msg') }}</b>
						<span class="_sub_title"><a href="mailto:{{ env('CONTACT_MAIL','panhaseng12@gmail.com') }}?subject=contact our support team">{{ env('CONTACT_MAIL','panhaseng12@gmail.com') }}</a></span>
					</li>
					<li class="lg-size">
						<span class="icon-room sm-size col-primary"></span>
						<b class="_title sm-size marg-top-20 d-block">{{ trans('content.contact.find_us_on_map') }}</b>
						<span class="_sub_title">{{ trans('content.contact.my_address') }}</span>
					</li>
				</ul>

			</div>

		</section>

		<section class="section-bg-gray padding-section big-padding" >
			{{-- <pre>{{ print_r(Session::all()) }}</pre> --}}
			<div class="feedback-frm-container">
				<h2 class="_title text-xs-center text-uppercase">{{ trans('content.contact.how_can_we_help_you') }}</h2>
				{{-- <h5 class="_title text-xs-center" style="line-height: 35px;">{!! trans('content.contact.free_to_put_your_rest') !!}</h5> --}}
				<form class="feedback-fmr flat-control-form-border marg-top-20" method="post" action="{{url::to('/send-mail')}}">
					<?php
						$_session = Session::all();
	 				?>

	 				{{-- <pre>{{ print_r($_session, true) }}</pre> --}}
					
					{{ csrf_field() }}

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group marg-lg">
							    <input type="text" name="name" class="form-control" placeholder="{{ trans('content.contact.name') }} *" required="" value="{{ $_session['name'] or '' }}">
						  	</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group marg-lg">
							    <input type="email" name="email" class="form-control" placeholder="{{ trans('content.contact.email') }} *" required="" value="{{ $_session['email'] or ''}}">
						  	</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group marg-lg">
							    <input type="text" name="phone" class="form-control" placeholder="{{ trans('content.contact.phone') }} *" required="" value="{{ $_session['phone'] or ''}}">
						  	</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12 marg-top-50">

							<div class="form-group marg-lg">
							   <textarea name="message" class="form-control" placeholder="{{ trans('content.contact.description') }} *" required="" >{{ $_session['message'] or ''}}</textarea>
						  	</div>

						  	@if(isset($_session['name']))
						  		<br>
							  	<div class="alert alert-danger" role="alert">
									<strong>Opp!</strong> Cannot send the email. Please try again!
								</div>
							@endif

						  	@if(isset($_session['error_type']))
						  		@if($_session['error_type'] == 'success')
							  		<br>
								  	<div class="alert alert-success" role="alert">
										<strong>Success!</strong> Thank you. Your submission is complete.
									</div>
								@endif
							@endif
							
						</div>
					</div>

				  	<div class="text-xs-center  marg-top-50">
				  		<button class="btn btn-outline-primary btn-bigger text-uppercase" ><b>{{ trans('content.contact.send') }}</b></button>
				  	</div>

				</form>
			</div>

		</section>

	</div>

@stop