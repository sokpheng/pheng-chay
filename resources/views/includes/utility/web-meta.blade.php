<?php 


	if(!isset($description)){
		$description = config('seo_config.defaults._desc');
		// $description=str_limit(strip_tags($description),155);
	}
	else{
		if(isset($isHome))
			$description=strip_tags($description);
		else
			// $description=substr(strip_tags($description),0,157).'...';
			$description=str_limit(strip_tags($description),155);


		$meta_keywords="Flexitech, Flexitech Cambodia";
	}

	if(!isset($meta_keywords)){
		$meta_keywords = "Flexitech, Flexitech Cambodia";
	}

?>

{{-- meta tag verify for bing --}}
{{-- <meta name="msvalidate.01" content="B231079E7C4E3E7EF4D8030D2448F24A" /> --}}

{{-- meta tag verify for https://www.mywot.com/ --}}
{{-- <meta name="wot-verification" content="e96692d346de8d8ee881"/> --}}

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0 , maximum-scale=1.0, user-scalable=no">


<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- =============== GLOBAL VAR ============== --}}
<meta name="se:remoteUrl" content="{{ base64_encode(env('REMOTE_API', '')) }}">

<meta name="se:lang" content="{{ HungryModule::getLang() ? HungryModule::getLang() : '' }}">
<meta name="se:url" content="{{ base64_encode(URL::to('/')) }}">

<!-- -->
<meta name="api:session" content="{{ base64_encode(\Session::getId() . 'U') }}">
<meta name="api:request" content="{{ 'YzUzYzcxNjJkODhjMWEzZGZjNWE4Yzc2MWNkYTZkYzU5MTllZDJhOTYyMmFkZDY1ZDUwZGIwMjI4YTNkYzFhNQ==' }}">

@if (AuthGateway::isLogin())
	
    <meta name="se:info" content="{{ base64_encode( json_encode(AuthGateway::user()) ) }}">
    <meta name="api:bearer" content="{{ AuthGateway::user()['access_token'] }}">
@endif




{{-- To add a Smart App Banner to your website, include the following meta tag in the head of each page where you’d like the banner to appear: --}}
{{-- <meta name="apple-itunes-app" content="app-id=461504587"> --}}
{{-- <meta name="apple-mobile-web-app-capable" content="yes"> --}}

{{-- <meta name="apple-itunes-app" content="app-id=myAppStoreID, affiliate-data=myAffiliateData, app-argument=myURL"> --}}
{{-- https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/PromotingAppswithAppBanners/PromotingAppswithAppBanners.html --}}

@if(isset($noSearchEngine))
	<meta name="robots" content="noindex, nofollow">
@else
	<meta content="index,follow" name="robots">
@endif
{{-- Title (Page Title. Maximum length 60-70 characters) --}}

@if(isset($web_title))
	@if($web_title!='')
		<title itemprop='name'>{{ $web_title }} | {{ config('seo_config.defaults._title') }}</title>
	@else
		<title itemprop='name'>{{ config('seo_config.defaults._title') }}</title>
	@endif
@else
	<title itemprop='name'>{{ config('seo_config.defaults._full_title') }}</title>
@endif

<link href="{{ URL::asset('img/favicon.ico') }}" type="image/x-icon" rel="shortcut icon" />

{{-- Website Meta Tag --}}

<meta name="description" content="{{ $description }}"/>
<meta name="keywords" content="{{ isset($meta_keywords) ? $meta_keywords : config('seo_config.defaults._keywords') }}"/>
<meta name="author" content="{{ config('seo_config.defaults._author') }}"/>
<meta name="developers" content="{{ config('seo_config.defaults._developers') }}"/>
<meta name="developer" content="{{ config('seo_config.defaults._developer') }}"/>
<meta name="contact" content="{{ config('seo_config.defaults._contact') }}"/>

@if(isset($canonical))
	<link href="{{ $canonical }}" rel="canonical" itemprop="url" />
@else
	<link href="{{ URL::current() }}" rel="canonical" itemprop="url" />
@endif


{{-- href lang --}}

<?php

	$alternateLangEN = strtok(LaravelLocalization::getLocalizedURL('en'),'?');
	$alternateLangKH = strtok(LaravelLocalization::getNonLocalizedURL(),'?');

	if(isset($setAlternateLangEN) && isset($setAlternateLangKH)){
		$alternateLangEN = $setAlternateLangEN;
		$alternateLangKH = $setAlternateLangKH;
	}

?>

<link rel="alternate" hreflang="en-us" href="{{ $alternateLangEN }}"> {{-- no lang in url coz it default --}}
<link rel="alternate" hreflang="km-kh" href="{{ $alternateLangKH }}"> {{-- alway get full url with 'en' --}}


{{-- Window 8 --}}
<meta name="application-name" content="{{ config('seo_config.defaults._title') }}">
<meta name="msapplication-TileColor" content="{{ config('seo_config.socials._window_color') }}">
<meta name="msapplication-TileImage" content="{{ URL::asset('/img/touch-icon-iphone-retina-120x120.png') }}">

<link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ URL::asset('/img/') }}/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::asset('/img/') }}/apple-touch-icon-144x144.png">

<link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ URL::asset('/img/') }}/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::asset('/img/') }}/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::asset('/img/') }}/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon-precomposed" href="{{ URL::asset('/img/') }}/apple-touch-icon.png">

<?php 
	// echo $imgSEO;
	$img=isset($imgSEO) && $imgSEO!='' ? $imgSEO : URL::asset(config('seo_config.defaults._img'));
	// $img=URL::asset('img/content/sub-cate/en/fashion/men.jpg');
?>

<!-- Schema.org markup for Google+ -->

{{-- Google+ Direct Connect helps visitors find your Google+ page and add it to their circles from directly within Google Search. After you create your Google+ page, connect it to your site by adding the following code inside the <head> element of your site: --}}
{{-- <link href="https://plus.google.com/115184257458733890124" rel="publisher" /> --}}

<meta itemprop="name" content="{{ isset($web_title) ? $web_title : config('seo_config.defaults._title') }}">
<meta itemprop="description" content="{{ $description }}">
<meta itemprop="image" content="{{ $img }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ config('seo_config.socials._twitter_site') }}">
<meta name="twitter:title" content="{{ isset($web_title)? $web_title : config('seo_config.defaults._title') }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:creator" content="{{ config('seo_config.socials._twitter_creator') }}">
<meta name="twitter:image" content="{{ $img }}">
<meta name="twitter:url" content="{{ isset($canonical) ? $canonical : URL::current() }}" /> 
<!-- Twitter summary card with large image must be at least 280x150px -->
{{-- <meta name="twitter:image:src" content="{{ $img }}"> --}}

<!-- Open Graph data -->

@if(App::environment('local'))
	{{-- facebook app id for testing env --}}
	<meta property="fb:app_id" name="fb:appId" content="{{ config('seo_config.socials._fb_app_id_dev') }}" />
@else  
	{{-- facebook app id for production env --}}
	<meta property="fb:app_id" name="fb:appId" content="{{ config('seo_config.socials._fb_app_id_prod') }}" />
@endif


<meta property="og:title" content="{{ isset($web_title)? $web_title : config('seo_config.defaults._title') }}" />
<meta property="og:type" content="{{ isset($isArticle)? 'article' : config('seo_config.socials._og_type') }}" />
<meta property="og:url" content="{{ isset($canonical) ? $canonical : URL::current() }}" />
<meta property="og:image" content="{{ $img }}" />
<meta property="og:description" content="{{ $description }}" />
<meta property="og:site_name" content="{{ config('seo_config.defaults._title') }}" />
