@extends('layouts.default')

@section('content')	

	<div class="bg-img-title-hover bg-cover _md-height display-flex flex-items-xs-bottom" style="background-image: url({{ asset('img/tmp/food_bg.jpg') }});">
		<div class="overlay-bg"></div>
		<div class="_title-container">
			<h1 class="_title border-bottom text-uppercase">{{ trans('content.footer.sitemap') }}</h1>
			<hr class="normal-line _under-title-xs"> 
		</div>		
	</div>


	<div class="max-container padding-section big-padding">

		<div class="row">
			<div class="col-md-8">



				<?php

					$alphaKh = array('ក','ខ','គ','ឃ','ង','ច','ឆ','ជ','ឈ','ញ','ដ','ឋ','ឌ','ឍ','ណ','ត','ថ','ទ','ធ','ន','ប','ផ','ព','ភ','ម','យ','រ','ល','វ','ស','ហ','ឡ','អ');


				?>


				<div class="simple-list-with-text">
					<h2 class="_title text-primary-col font-size-md marg-bottom-20">{{ trans('content.general.a_z') }}</h2>
					<ul class="clearUL">
						@if(HungryModule::getLang()=='')
							@foreach(range('A', 'Z') as $alpha)
								<li class="d-inline-block"><a href="{{'/search?s=' .strtolower($alpha)  }}" class="link-black text-capitalize">{{ $alpha }}</a></li>
							@endforeach
						@else
							@foreach($alphaKh as $item)
								<li class="d-inline-block"><a href="{{'/search?s=' .strtolower($item)  }}" class="link-black text-capitalize">{{ $item }}</a></li>
							@endforeach
						@endif
					</ul>
				</div>	

				<br>
				<br>

				{{--    all: all,
                area: area,
                category: category,
                food_drink: food_drink,
                promotion: promotion,
                purposes: purposes,
                time: time,
                near_by: near_by --}}

				{{-- <pre>{{print_r($topCategoryHome,true)}}</pre> --}}

				{{-- ------- Area ------- --}}
				<div class="simple-list-with-text">
					<h2 class="_title text-primary-col font-size-md marg-bottom-20">{{ trans('content.general.area') }}</h2>

					<?php

						$cityPro = trans('content.city_province');

					?>
					
					@foreach($restSection['locations']['cities'] as $index => $item)

						<?php

							// $_slug = $topCate['display_name'];
							$_title = HungryModule::getLangCate($item,'display_name');

							$slugName = str_slug($_title,'-');
							if(isset($cityPro[$slugName]))
								$_title = $cityPro[$slugName];												

						?>

						<ul class="clearUL">
							
								<li class="d-inline-block"><a href="{{ URL::to($baseUrlLang.'/search?s='.str_slug($item['name'], '-')) }}" class="link-black-hover text-capitalize">{{ $_title }}</a></li>

									@foreach($item['districts'] as $district)

										<?php

											// $_slug = $topCate['display_name'];
											$_title = HungryModule::getLangCate($district,'display_name');

											$slugName = str_slug($_title,'-');
											if(isset($cityPro[$slugName]))
												$_title = $cityPro[$slugName];												

										?>

										<li class="d-inline-block"><a href="{{ URL::to($baseUrlLang.'/search?s='.str_slug($district['name'], '-')) }}" title="" class="link-black text-capitalize">{{  $_title }}</a></li>

									@endforeach
							@if($index==0)
								<br><br>
							@endif
							
						</ul>
					@endforeach

				</div>	

				<br>
				<br>

				{{-- ------- Category ------- --}}
				<div class="simple-list-with-text">
					<h2 class="_title text-primary-col font-size-md marg-bottom-20">{{ trans('content.general.category') }}</h2>
					<ul class="clearUL">
						@foreach($topCategoryHome['category'] as $index => $item)
							<li class="d-inline-block"><a href="{{ $baseUrlLang.'/search?s=' . str_slug($item['display_name']) }}" class="link-black text-capitalize">{{ HungryModule::getLangCate($item,'display_name') }}</a></li>
						@endforeach
					</ul>
				</div>	

				<br>
				<br>

				{{-- ------- Food & Drink ------- --}}
				<div class="simple-list-with-text">
					<h2 class="_title text-primary-col font-size-md marg-bottom-20">{{ trans('content.general.categories') }}</h2>
					<ul class="clearUL">
						@foreach($topCategoryHome['food_drink'] as $index => $item)
							<li class="d-inline-block"><a href="{{ $baseUrlLang.'/search?s=' . str_slug($item['display_name'])  }}" class="link-black text-capitalize">{{ HungryModule::getLangCate($item,'display_name') }}</a></li>
						@endforeach
					</ul>
				</div>	

				<br>
				<br>

				{{-- ------- Promotions ------- --}}
				{{-- <div class="simple-list-with-text">
					<h2 class="_title text-primary-col font-size-md marg-bottom-20">Promotions</h2>
					<ul class="clearUL">
						@foreach($topCategoryHome['promotion'] as $index => $item)
							<li class="d-inline-block"><a href="#" class="link-black text-capitalize">{{$item['display_name']}}</a></li>
						@endforeach
					</ul>
				</div>

				<br>
				<br> --}}

				{{-- ------- Purpose ------- --}}
				<div class="simple-list-with-text">
					<h2 class="_title text-primary-col font-size-md marg-bottom-20">{{ trans('content.general.purpose') }}</h2>
					<ul class="clearUL">
						@foreach($topCategoryHome['purposes'] as $index => $item)
							<li class="d-inline-block"><a href="{{ $baseUrlLang.'/search?s=' . str_slug($item['display_name'])  }}" class="link-black text-capitalize">{{ HungryModule::getLangCate($item,'display_name') }}</a></li>
						@endforeach
					</ul>
				</div>

				<br>
				<br>

				{{-- ------- Time ------- --}}
				<div class="simple-list-with-text">
					<h2 class="_title text-primary-col font-size-md marg-bottom-20">{{ trans('content.general.time') }}</h2>
					<ul class="clearUL">
						@foreach($topCategoryHome['time'] as $index => $item)
							<li class="d-inline-block"><a href="{{ $baseUrlLang.'/search?s=' . str_slug($item['display_name'])  }}" class="link-black text-capitalize">{{ HungryModule::getLangCate($item,'display_name') }}</a></li>
						@endforeach
					</ul>
				</div>

			</div>
			

				{{-- <pre>{{print_r($restSection['recomendations'][0])}}</pre> --}}

			<div class="col-md-4 hidden-md-down">
				

				@include('includes.elements.list.you-might-also-like', array('restList'=>$restSection['recomendations']))
			</div>

		</div>

	</div>


@stop