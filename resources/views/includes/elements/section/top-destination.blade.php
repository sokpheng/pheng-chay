<section class="top-destination padding-section big-padding display-flex flex-end">

	<div class="max-container no-padd" style="position: relative; width: 100%">

		<div class="top-destination-container">

			<h2 class="_title">{{ trans('content.general.top_des_in_cam') }}</h2>

			<?php


				$topDes = array(
						array(
							'title'	=> trans('content.general.sihanouk_ville'),
							'location'	=> 'Sihanouk Ville',
							'slug'	=> 'sihanouk-ville',
							'type'	=> 'grid-item',
							'image'	=> '/img/web-comp/shv.jpg',
						),
						array(
							'title'	=> trans('content.general.angkor_wat'),
							'location'	=> 'Siem Reap',
							'type'	=> 'grid-item grid-item--width2',
							'slug'	=> 'angkor-wat',
							'image'	=> '/img/web-comp/angkor-wat.jpg',
						),
						array(
							'title'	=> trans('content.general.angkor_thom'),
							'slug'	=> 'angkor-thom',
							'location'	=> 'Siem Reap',
							'type'	=> 'grid-item',
							'image'	=> '/img/web-comp/angkor-thom.jpg',
						),
						array(
							'title'	=> trans('content.general.bayon_temple'),
							'location'	=> 'Siem Reap',
							'type'	=> 'grid-item grid-item--width2',
							'slug'	=> 'bayon-temple',
							'image'	=> '/img/web-comp/bayon-temple.jpg',
						),
						array(
							'title'	=> trans('content.general.songsa_island'),
							'location'	=> 'Sihanouk Ville',
							'type'	=> 'grid-item',
							'slug'	=> 'songsa-island',
							'image'	=> '/img/web-comp/songsa-island.jpg',
						),
						array(
							'title'	=> trans('content.general.meusuem'),
							'location'	=> 'Phnom Penh',
							'slug'	=> 'meusuem',
							'type'	=> 'grid-item',
							'image'	=> '/img/web-comp/meusem.jpg',
						),

						array(
							'title'	=> trans('content.general.the_royal_palace'),
							'location'	=> 'Phnom Penh',
							'type'	=> 'grid-item grid-item--width2',
							'slug'	=> 'royal-palace',
							'image'	=> '/img/web-comp/royal-palace.jpg',
						),

						array(
							'title'	=> trans('content.general.sokha_hotel'),
							'location'	=> 'Sihanouk Ville',
							'slug'	=> 'sokha-hotel',
							'type'	=> 'grid-item',
							'image'	=> '/img/web-comp/sokha-hotel.jpg',
						),

						array(
							'title'	=> trans('content.general.khos_rong'),
							'location'	=> 'Sihanouk Ville',
							'slug'	=> 'khos-rong',
							'type'	=> 'grid-item',
							'image'	=> '/img/web-comp/khos-rong.jpg',
						),

						array(
							'title'	=> trans('content.general.kom_pot'),
							'location'	=> 'Kom Pot',
							'type'	=> 'grid-item grid-item--width2',
							'slug'	=> 'kom-pot',
							'image'	=> '/img/web-comp/kom-pot.jpg',
						),


					);

				// shuffle($topDes);

				// $arr = (array)$topDes;

				// shuffle($arr);
			?>
				
			<div class="clearfix masonry-box" ng-cloak>


				<div class="grid">
					<div class="grid-sizer"></div>
					@foreach($topDes as $item)
						<div class="{{ $item['type'] }}">
							<a href="{{ $baseUrlLang.'/select-hotel?l='.$item['location'] }}" class="d-block img-container hover-opacity">	
								<img class="img-fluid" alt="{{ $item['title'] }}" src="{{ asset($item['image']) }}">
								<div class="overlay-bg color_md"></div>
								<div class="info">
									<h5 class="overlay-bg text-overflow">{{ $item['title'] }}</h5>
								</div>
							</a>
						</div>
					@endforeach

				</div>


			</div>


			<div class="text-center marg-top-30">
				<br>
				<a href="{{ $baseUrlLang.'/select-hotel' }}" class="btn btn-outline-primary btn-radius">{{ trans('content.general.check_more') }}</a>
			</div>


		</div>

	</div>

</section>