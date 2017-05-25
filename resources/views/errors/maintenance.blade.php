@extends('layouts.news.default')


{{-- =========== include script at bottom of other style --}}
@section('styles')
  	{{-- <link rel="stylesheet" href="{{ URL::to('js/owl.carousel/owl-carousel/owl.carousel.css') }}"> --}}
@show


{{-- =========== include script at bottom but top of other script --}}
@section('scriptsTop')

	@if(App::environment('local'))

		<script type="text/javascript" src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('vendors/layzr.js/dist/layzr.min.js') }}"></script>
		{{-- <script src="{{ URL::asset('js/owl.carousel/owl-carousel/owl.carousel.min.js') }}"></script> --}}
		<script type="text/javascript" src="{{ URL::asset('js/news/news-home.js') }}"></script>
		{{-- <script type="text/javascript" src="{{ URL::asset('js/news/news-search.js') }}"></script> --}}
	
	@else

		<script type="text/javascript" src="{{ elixir('js/build/news-h-script.js') }}"></script>
		
	@endif

@stop

@section('scripts')
	
@stop


@section('content')	


	<section id="maintenance">

		<div class="center-container">
            <div class="content">
                {{-- <div class="title">Page Under Construction</div> --}}
                <div class="title">Coming Soon. Stay Turned !!</div>
                <a href="{{ URL::to('/').(isset($back_home)?$back_home:'') }}" class="bt-flexi">Home</a>
            </div>
        </div>

	</section>


@stop