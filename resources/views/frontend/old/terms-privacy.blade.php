@extends('layouts.default')

@section('content')	

	<div class="bg-img-title-hover bg-cover _md-height display-flex flex-items-xs-bottom" style="background-image: url(img/tmp/food_bg.jpg);">
		<div class="overlay-bg"></div>
		<div class="_title-container">
			<h1 class="_title border-bottom text-uppercase">{{ trans('content.terms_privacy_policy.terms_privacy_policy_title') }}</h1>
			<hr class="normal-line _under-title-sm"> 
		</div>		
	</div>


	<div class="max-container padding-section section-responsive">

		<div class="text-content terms-privacy">
			<div class="col-fade">{{ trans('content.terms_privacy_policy.last_updated') }}</div>
			<br>
			<h1>{{ trans('content.terms_privacy_policy.note_1_title') }}</h1>
			<p>
				{{ trans('content.terms_privacy_policy.note_1_desc') }}
			</p>

			<h2>{{ trans('content.terms_privacy_policy.note_2_title') }}</h2>
			<p>{{ trans('content.terms_privacy_policy.note_2_desc') }}</p>
			
			<h2>{{ trans('content.terms_privacy_policy.note_3_title') }}</h2>
			<p>{{ trans('content.terms_privacy_policy.note_3_desc') }}</p>

			<h2>{{ trans('content.terms_privacy_policy.note_4_title') }}</h2>
			<p>{{ trans('content.terms_privacy_policy.note_4_desc') }}</p>

			<h2>{{ trans('content.terms_privacy_policy.note_5_title') }}</h2>
			<p>{{ trans('content.terms_privacy_policy.note_5_sub_1') }} <a href="mailto:info@hungryhungry.io?subject=Hi HungryHungry">info@hungryhungry.io</a> {{ trans('content.terms_privacy_policy.note_5_sub_2') }}</p>

		</div>

	</div>


@stop