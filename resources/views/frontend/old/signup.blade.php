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
						<button class="btn btn-primary btn-primary--fx text-capitalize full-radius fb-style bt-align-middle" ng-click="fbSignIn()">{{ trans('content.user.sign_up_with_facebook') }}</button>
						<div class="or"><span class="_text">{{ trans('content.navbar.or') }}</span></div>
					</div>
				</div>
				<div class="col-md-6">
					<form method="POST" action="{{ URL::action('Auth\FrontAuthController@register') }}" novalidate="" name="registerFrm" class="login-frm flat-control-form-border registerForm">
						
						<h1 class="_title text-uppercase text-xs-center marg-bottom-50 text-primary-col">{{ trans('content.navbar.sign_up') }}</h1>
						<div class="form-group has-danger" ng-init="USER.full_name='{{ Session::get('_old_input')['full_name'] }}'">

						    <input type="text" name="full_name" ng-model="USER.full_name" maxlength="200" minlength="2" class="form-control" placeholder="{{ trans('content.user.full_name') }} *" required="">
							<div ng-messages="registerFrm.full_name.$error" role="alert" ng-show="registerFrm.full_name.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.pls_enter_val_full_name') }}</div>
							    <div ng-message="maxlength" class="form-control-feedback">{{ trans('content.user.full_name_max') }}</div>
							    <div ng-message="minlength" class="form-control-feedback">{{ trans('content.user.full_name_min') }}</div>
							</div>

					  	</div>

						<div class="form-group has-danger" ng-init="USER.email='{{ Session::get('_old_input')['email'] }}'">

						    <input type="email" name="email" ng-model="USER.email" class="form-control" placeholder="{{ trans('content.user.email') }} *" required="">
							<div ng-messages="registerFrm.email.$error" role="alert" ng-show="registerFrm.email.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.please_enter_value_email') }}</div>
							    <div ng-message="email" class="form-control-feedback">{{ trans('content.user.this_field_must_be_email') }}</div>
							</div>

					  	</div>

						<div class="form-group has-danger">
						    <input type="password" name="password" ng-model="USER.password" class="form-control" placeholder="{{ trans('content.user.password') }} *" required="" minlength="8">
							<div ng-messages="registerFrm.password.$error" role="alert" ng-show="registerFrm.password.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.pls_enter_val_pass') }}</div>
	
							    <div ng-message="minlength"  class="form-control-feedback">{{ trans('content.user.pass_min_less_char') }}</div>
							</div>
					  	</div>

						<div class="form-group has-danger" >
						    <input type="password" name="confirm_password" ng-model="USER.confirm_password" class="form-control" placeholder="{{ trans('content.user.confirm_password') }} *" required="">
							<div ng-show="(USER.confirm_password != USER.password) && registerFrm.confirm_password.$dirty && registerFrm.password.$dirty" role="alert" ng-cloak>
								<div class="form-control-feedback">{{ trans('content.user.password_confirm_password_is_not') }}</div>

							</div>
					  	</div>

					  	<br>

						<div class="form-check">

						<?php
							$_link = "<a href='/terms-privacy' title='Hungry Hungry Terms & Privacy Policy' target='_blank'>".trans('content.footer.terms_policy_privacy')."</a>"
						?>

				          	<label class="form-check-label">
				            	<input class="form-check-input" name="agree" ng-model="USER.agree" required="" type="checkbox" style="top: -2px;"> 
				            	{!! trans('content.user.agree_our',['LINK'=>$_link]) !!} 
				          	</label>


							<div ng-messages="registerFrm.agree.$error" role="alert" class="has-danger" ng-show="registerFrm.agree.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.please_agree_our_terms_privacy_before') }}</div>
							</div>

			        	</div>

			        	{{ csrf_field() }}

					  	<input type="hidden" name="data" ng-value="_dataRegister.encrypted">
					  	<input type="hidden" name="data_pass" ng-value="_dataRegister.encrypted_pass">

					  	<?php
					  		$input = Input::all();
					  	?>
					  	@if(isset($input['b']))
					  		<input type="hidden" name="redirect_back" value="{{ Input::get('b') }}">
					  	@endif

					  	<div class="text-xs-center marg-top-50">

					  		@if(Session::has('_old_input')['email'])
							  	<div class="form-group has-danger" ng-cloak>
							  		<div class="form-control-feedback">{{ trans('content.user.please_input_valid_info') }}</div>
							  		<br>
							  	</div>
						  	@endif

					  		<button class="btn btn-primary btn-primary--fx full-radius text-uppercase" ng-class="{'btn-loading': isLoading}" ng-disabled1="isLoading || (registerFrm.$invalid && registerFrm.$dirty)" ng-click="emailSignUp()" type="button"> <img class="center-absolute _loading-icon size-sm" src="{{ asset('img/svg/loading/loading-spin-white.svg') }}" alt="login loading"> <span class="_text">{{ trans('content.navbar.sign_up') }}</span></button>


					  		<div class="mobile-fb-action hidden-md-up">
					  			<div class="or"><span class="_text">{{ trans('content.navbar.or') }}</span></div>
					  			<button class="btn btn-primary btn-primary--fx text-capitalize full-radius fb-style bt-align-middle" ng-click="fbSignIn()">{{ trans('content.user.sign_up_with_facebook') }}</button>
					  		</div>


					  	</div>

					  	<div class="have-an-acc-yet text-xs-center marg-top-50">
					  		<?php
					  			$reBack = Input::get('b') != '' ? '?b='.Input::get('b') : '';
					  		?>
					  		{{ trans('content.user.i_already_have_an_acc') }} <a href="{{ URL::action('HomeController@login').$reBack }}" title="Register New Account" class="link-underline text-uppercase">{{ trans('content.navbar.log_in') }}</a>
					  	</div>

					</form>
				</div>
			</div>

		</div>

	</div>

@stop


@section('scripts')

@stop
