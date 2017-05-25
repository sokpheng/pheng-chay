@extends('layouts.default')

@section('content')	

	<div class="max-container marg-from-menu" ng-controller="signInRegister">

		<div class="login-with-image-left">

			<div class="row space0">
				<div class="col-md-6 hidden-sm-down">


					{{ Form::open(array(
	                  'action' => 'Auth\FrontAuthController@fbLogin',
	                  'name' => 'fbLogin',
	                  'accept-charsetme' => 'utf-8',
	                  'method' => 'POST',
	                  'class' => 'fb_login',
	                  )) }}

					  	<input type="hidden" name="data" ng-value="_dataFbLogin.encrypted">
					  	<input type="hidden" name="data_pass" ng-value="_dataFbLogin.encrypted_pass">


	            {{ Form::close() }} 


					<div class="img-container bg-cover text-xs-center display-flex flex-items-xs-middle"  style="background-image: url('{{ asset('img/tmp/food_bg.jpg') }}'); position: relative;">
						<div class="overlay-bg"></div> 
						<button class="btn btn-primary btn-primary--fx text-capitalize full-radius fb-style bt-align-middle" ng-click="fbSignIn()">{{ trans('content.user.sign_in_with_facebook') }}</button>
						<div class="or"><span class="_text">{{ trans('content.navbar.or') }}</span></div>
					</div>
				</div>
				<div class="col-md-6">

					<form method="POST" action="{{ URL::action('Auth\FrontAuthController@apiLogin') }}" novalidate="" name="loginFrm" class="login-frm flat-control-form-border">
						
						<h1 class="_title text-uppercase text-xs-center marg-bottom-50 text-primary-col">{{ trans('content.navbar.log_in') }}</h1>

						<div class="form-group marg-lg has-danger" ng-init="USER.email='{{ isset(Session::get('_old_input')['email']) ? Session::get('_old_input')['email'] : '' }}'">
						    <input type="email" name="email" ng-model="USER.email" class="form-control" placeholder="{{ trans('content.user.email') }} *" required="">
						    {{-- <pre><% loginFrm | json%></pre> --}}
							<div ng-messages="loginFrm.email.$error" role="alert" ng-show="loginFrm.email.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.please_enter_value_email') }}</div>
							    <div ng-message="email" class="form-control-feedback">{{ trans('content.user.this_field_must_be_email') }}</div>
							</div>

					  	</div>

						<div class="form-group marg-lg has-danger">
						    <input type="password" name="password" ng-model="USER.pass" class="form-control" placeholder="{{ trans('content.user.password') }} *" required="">
						    <a href="{{ URL::to($baseUrlLang.'/forget-password') }}" class="forget-pass-link" >{{ trans('content.user.forget_password') }}</a>
							<div ng-messages="loginFrm.password.$error" role="alert" ng-show="loginFrm.password.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.please_enter_value_password') }}</div>
							    {{-- <div ng-message="email" class="form-control-feedback">This field must be a valid email address.</div> --}}
							</div>
					  	</div>

					  	{{ csrf_field() }}

					  	{{-- <pre>{{ Session::all() }}</pre> --}}

					  	<input type="hidden" name="data" ng-value="_dataLogin.encrypted">
					  	<input type="hidden" name="data_pass" ng-value="_dataLogin.encrypted_pass">
					  	<?php
					  		$input = Input::all();
					  	?>
					  	@if(isset($input['b']))
					  		<input type="hidden" name="redirect_back" value="{{ Input::get('b') }}">
					  	@endif


					  	<div class="text-xs-center marg-top-50">
					  		@if(Session::has('_old_input')['email'])
							  	<div class="form-group has-danger" ng-cloak>
							  		<div class="form-control-feedback">{{ trans('content.user.your_password_email_incorrect') }}</div>
							  		<br>
							  	</div>
						  	@endif
					  		<button class="btn btn-primary btn-primary--fx full-radius text-uppercase" ng-class="{'btn-loading': isLoading}" ng-disabled="isLoading || (loginFrm.$invalid && loginFrm.$dirty)" ng-click="emailSignIn()" type="button"> <img class="center-absolute _loading-icon size-sm" src="{{ asset('img/svg/loading/loading-spin-white.svg') }}" alt="login loading"> <span class="_text">{{ trans('content.navbar.log_in') }}</span></button>

					  		<div class="mobile-fb-action hidden-md-up">
					  			<div class="or"><span class="_text">{{ trans('content.navbar.or') }}</span></div>
					  			<button class="btn btn-primary btn-primary--fx text-capitalize full-radius fb-style bt-align-middle" ng-click="fbSignIn()">{{ trans('content.user.sign_in_with_facebook') }}</button>
					  		</div>

					  	</div>

					  	<div class="have-an-acc-yet text-xs-center marg-top-50">
					  		<?php
					  			$reBack = Input::get('b') != '' ? '?b='.Input::get('b') : '';
					  		?>
					  		{{ trans('content.user.i_did_not_have_an_acc_yet') }} <a href="{{ URL::action('HomeController@signup').$reBack }}" title="Register New Account" class="link-underline text-uppercase">{{ trans('content.navbar.sign_up') }}</a>
					  	</div>

					</form>
					
				</div>
			</div>

		</div>

	</div>

@stop

@section('scripts')


@stop