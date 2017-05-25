@extends('layouts.default')

@section('content')	

	<div class="bg-img-title-hover bg-cover _md-height display-flex flex-items-xs-bottom" style="background-image: url(/img/tmp/food_bg.jpg);">
		<div class="overlay-bg"></div>
		<div class="_title-container">
			<h1 class="_title border-bottom text-uppercase">{{ trans('content.feedback.feedback') }}</h1>
			<hr class="normal-line _under-title-xs"> 
		</div>		
	</div>

		<?php
			$_session = Session::all();
		?>
	<div class="max-container padding-section big-padding">

		<div class="feedback-frm-container">
			<h2 class="_title text-xs-center text-uppercase">{{ trans('content.feedback.how_do_you_feel') }}</h2>
			<form class="feedback-fmr flat-control-form-border marg-top-20" method="post" action="{{url::to('/send-feedback')}}">
					
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group marg-lg">
						    <input type="text" name="name" class="form-control" placeholder="{{ trans('content.contact.name') }} *" required="" value="{{ $_session['name'] or '' }}">
					  	</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group marg-lg">
						    <input type="email" name="email" class="form-control" placeholder="{{ trans('content.contact.email') }} *" required="" value="{{ $_session['name'] or '' }}">
					  	</div>
					</div>
				</div>

				<div class="form-group marg-lg marg-top-50">
				   <textarea name="message" class="form-control" placeholder="{{ trans('content.contact.description') }} *" required="">{{ $_session['message'] or ''}}</textarea>
			  	</div>

			  	<input type="hidden" name="feeling" value="<% feeling %>" ng-init="feeling = '{{ $_session['feeling'] or ''}}'">

			  	<div class="emojicon-feeling marg-top-50">
			  		<h3 class="_title text-xs-center marg-bottom-20">{{ trans('content.feedback.choose_your_feeling') }}</h3>
			  		<ul class="clearUL feeling-list">
			  			<li class="d-inline-block" ng-class="{'active':feeling=='bad'}" ng-click="feeling='bad'"><img src="{{ asset('img/comp/feel-every-bad.png') }}" alt="" ></li>
			  			<li class="d-inline-block" ng-class="{'active':feeling=='not_good'}" ng-click="feeling='not_good'" ><img src="{{ asset('img/comp/feel-not-good.png') }}" alt=""></li>
			  			<li class="d-inline-block" ng-class="{'active':feeling=='simple'}" ng-click="feeling='simple'"><img src="{{ asset('img/comp/feel-simple.png') }}" alt=""></li>
			  			<li class="d-inline-block" ng-class="{'active':feeling=='good'}" ng-click="feeling='good'"><img src="{{ asset('img/comp/feel-good.png') }}" alt=""></li>
			  			<li class="d-inline-block" ng-class="{'active':feeling=='happy'}" ng-click="feeling='happy'"><img src="{{ asset('img/comp/feel-happy.png') }}" alt=""></li>
			  		</ul>
			  	</div>
			  	@if(isset($_session['name']))
			  		<br>
				  	<div class="alert alert-danger" role="alert">
						<strong>Opp!</strong> Cannot send the email. Please try again!
					</div>
				@endif
			  	<div class="text-xs-center  marg-top-50">
			  		<button class="btn btn-outline-primary btn-bigger text-uppercase"><b>{{ trans('content.feedback.submit') }}</b></button>
			  	</div>

			</form>
		</div>

	</div>


@stop