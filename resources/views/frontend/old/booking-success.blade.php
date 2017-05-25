@extends('layouts.default')

@section('content')	

	@include("includes.elements.section.main-booking")

	<section class="hotel-review padding-section display-flex flex-end" ng-controller="hotelReviewCtrl">

		<div class="max-container no-padd" style="position: relative; width: 100%">

			<div class="hotel-review-container">

				<div class="breadcrums-multi-step text-center">
					<ol class="cd-multi-steps text-bottom count">
						<li class="visited"><a href="#0">Check In</a></li>
						<li class="visited"><em>Select Hotel</em></li>
						<li class="current"><em>Review</em></li>
						<li class="finish"><em>Done <span class="icon-check"></span></em></li>
					</ol>
				</div>


				<hr class="line-col-fade-left-right marg-md md-width">


				{{-- hotel information --}}
				<div class="box-with-shadow bg-gray hotel-basic-info">
					
					<div class="row">
						<div class="col-sm-8">
							<h4 class="title blue-col">The Frangipani Living Arts Hotel and Spa</h4>
							<h6 class="desc">16, Street 123, Toul Tom Pong I, Khan Chamkarmon, Chamkar Morn, Phnom Penh, Cambodia</h5>
						  	<ul class="clearUL rate-star d-inline-block">
						  		<li class="d-inline-block"><span class="icon-star"></span></li>
						  		<li class="d-inline-block"><span class="icon-star"></span></li>
						  		<li class="d-inline-block"><span class="icon-star"></span></li>
						  		<li class="d-inline-block"><span class="icon-star"></span></li>
						  		<li class="d-inline-block"><span class="icon-star"></span></li>
						  	</ul>
						  	<div class="price d-inline-block">
						  		<span class="lb">USD</span> <span class="val">25.00</span>
						  	</div>
						</div>				
						<div class="col-sm-4">
							
							<div class="row space5">
								<div class="col-sm-7">
									<ul class="clearUL check-in-info">
										<li>
											<span class="lb">Check In :</span>
											<span class="val"><b>12 Mar 2017</b></span>
										</li>
										<li>
											<span class="lb">Check Out :</span>
											<span class="val"><b>15 Mar 2017</b></span>
										</li>
									</ul>
								</div>
								<div class="col-sm-5 text-right">
									<ul class="clearUL check-in-info">
										<li>
											<span class="lb">Room :</span>
											<span class="val"><b>2</b></span>
										</li>
										<li>
											<span class="lb">Adult :</span>
											<span class="val"><b>4</b></span>
										</li>
										<li>
											<span class="lb">Children :</span>
											<span class="val"><b>0</b></span>
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
							<a href="{{ asset('img/web-comp/hotel-sample.jpg') }}" class="d-block main-element bg-cover hover-opacity _photoEle" style="background-image: url({{ asset('img/web-comp/hotel-sample.jpg') }})">
								<div class="desc">
									<span>“Location…food n dinning..big bed room”</span>
								</div>
							</a>

							<?php

								// $videoLink = '';
								$videoLink = "http://www.youtube.com/watch?v=7HKoqNJtMTQ";
								if (strpos($videoLink, 'facebook.com') !== false) {
									$videoLink = "https://www.facebook.com/v2.5/plugins/video.php?href=" . $videoLink;
								}

							?>
							<a href="{{ $videoLink }}" class="btn-video video_pro"><span class="icon-play_circle_filled"></span></a>
						</div>
						<div class="col-sm-4">
							<div class="other-element display-flex">
								<a href="{{ asset('img/web-comp/hotel-sample-v1.jpg') }}" class="d-block all-gallery bg-cover hover-opacity _photoEle" style="background-image: url({{ asset('img/web-comp/hotel-sample-v1.jpg') }})">
									<div class="overlay-bg color_md"></div>
									<h4 class="see-all-image center-absolute">View Gallerys (34)</h4>
								</a>
								<div id="map" class="map">
								</div>
							</div>
						</div>
					</div>

					<a href="https://media-cdn.tripadvisor.com/media/photo-s/09/7c/d3/46/breezy-bar-lounge.jpg" class="_photoEle"></a>
					<a href="http://ucd.hwstatic.com/propertyimages/7/73109/6.jpg" class="_photoEle"></a>
					<a href="http://r-ec.bstatic.com/images/hotel/840x460/290/29060837.jpg" class="_photoEle"></a>
					<a href="http://t-ec.bstatic.com/images/hotel/max1024x768/290/29060211.jpg" class="_photoEle"></a>
					<a href="http://g.otcdn.com/imglib/hotelfotos/8/298/the-frangipani-living-arts-hotel-and-spa-phnom-penh-040.jpg" class="_photoEle"></a>


				</div>


				{{-- feature --}}	
				<div class="marg-top-20">
					<h5 class="title">Features</h5>
					<div class="box bg-gray features">
						<ul class="clearUL">
							<li class="d-inline-block"><span class="icon-wifi"></span> <span>Wi-Fi</span></li>
							<li class="d-inline-block"><span class="icon-restaurant"></span>Free Breakfast</li>
							<li class="d-inline-block"><span class="icon-local_bar"></span>Bar</li>
						</ul>
					</div>
				</div>


				{{-- rooms table --}}
				<div class="table-multi-body rooms-table marg-top-20">

					<table class="table table-responsive1 table-bordered1">

						<thead class="thead-inverse">
							<tr>
								<th class="bg-primary">Type</th>
								<th class="bg-primary">What’s included</th>
								<th class="bg-primary">Capacity</th>
								<th class="bg-primary">Price per night</th>
								<th class="bg-primary">Room</th>
								<th class="bg-primary"></th>
							</tr>
						</thead>

						<tbody>
							<tr colspan="6" class="space size-md"><td></td></tr>
						</tbody>

						@for($j=0;$j<5;$j++)
							<tbody class="bg-gray">
								<tr><th scope="row" colspan="6" class="hotel-title"><h5 class="no-marg">Superior Standard Zone</h5></th></tr>
								<tr class="info">
									<td class="type">
										<ul class="clearUL info-list">
											<li><span>City View</span></li>
											<li><span>1 Bathroom</span></li>
											<li><span>2 Single Bed</span></li>
										</ul>
									</td>
									<td class="include">
										<ul class="clearUL info-list">
											<li><span class="icon-check"></span><span>Wi-Fi</span></li>
											<li><span class="icon-check"></span><span>Breakfast</span></li>
										</ul>
									</td>
									<td class="capacity text-center">
										<span class="icon-people"></span>
									</td>
									<td class="price_per_night text-right">
											
										<ul class="clearUL info-list">
											<li class="old-price"><span>USD</span> <span>30.00</span></li>
											<li class="price"><span class="lb">USD</span> <span class="val">22.00</span></li>
										</ul>

									</td>
									<td class="room text-center">
										
										<div class="btn-group">
										  <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Select room
										  </button>
										  <div class="dropdown-menu">
										  	@for($i=1;$i<10;$i++)
										    	<a class="dropdown-item" href="#">{{ $i }}</a>
										    @endfor
										  </div>
										</div>

									</td>
									<td class="action text-center"><a href="#fill-info" class="btn btn-primary full-radius no-border size-sm fillInfoPopup">Book Now</a></td>
								</tr>
								{{-- <tr colspan="6" class="space size-sm"><td></td></tr> --}}
							</tbody>
							<tbody>
								<tr colspan="6" class="space size-sm"><td></td></tr>
							</tbody>
						@endfor

					</table>

				</div>	



				{{-- description --}}	
				<div class="marg-top-20">
					<h5 class="title">More about Baiyoke Sky Hotel</h5>
					<p>
						Strategically located in the heart of downtown Bangkok, the 88-story Baiyoke Sky Hotel is Thailand’s tallest building. The hotel is convenient for those looking to explore the largest fashion square in downtown Bangkok as well as the shopping and entertainment centers of Central World, Gaysorn Plaza, and the Peninsula. The hotel’s business center features a full range of modern equipment and around-the-clock professional assistance. The airport-rail link to Suvarnabhumi International Airport is accessible via the Rajprarop station, which sit about 150 meters away and can be reached by the hotel’s shuttle bus. The shuttle also transports guests to the Chatuchak Weekend Market and to the Suvarnabhumi International Airport. If you’re looking for a special and unique experience, look no further than Baiyoke Sky Hotel.
					</p>
				</div>




			</div>

		</div>


		@include('includes.elements.comp.popup-fill-info')


	</section>

@stop


@section('scripts')


@stop
