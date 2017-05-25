@extends('layouts.default')

@section('content')	

	<div class="max-container marg-from-menu" ng-controller="HomeCtrl">

		<div class="login-with-image-left">

			<div class="row space0 display-flex flex-items-xs-center">
				<div class="col-md-6">
					<form method="POST" novalidate="" name="forgetPassFrm" class="login-frm flat-control-form-border" action="{{url::to('/change-password')}}">
						{{ csrf_field() }}
						<h1 class="_title text-uppercase text-xs-center marg-bottom-50 text-primary-col">{{ trans('content.user.create_new_pass') }}</h1>

						<h5 class="text-xs-center marg-bottom-50">{{ trans('content.user.pls_input_new_pass') }}</h5>

						<div class="form-group marg-lg">
						    <input type="password" name="password" minlength="8" class="form-control" placeholder="{{ trans('content.user.password') }} *" required="" ng-model="password">
						    <div ng-messages="forgetPassFrm.password.$error" role="alert" ng-show="forgetPassFrm.password.$dirty" ng-cloak>
								<div ng-message="required" class="form-control-feedback">{{ trans('content.user.pls_enter_val_pass') }}</div>
							    <div ng-message="minlength"  class="form-control-feedback">{{ trans('content.user.pass_min_less_char') }}</div>
							</div>
					  	</div>
						<div class="form-group marg-lg">
						    <input type="password" name="confirm_password" class="form-control" placeholder="{{ trans('content.user.confirm_password') }} *" required="" ng-model="confirm_password">
						    <div ng-show="(confirm_password != password) && forgetPassFrm.confirm_password.$dirty && forgetPassFrm.password.$dirty" role="alert" ng-cloak>
								<div class="form-control-feedback">{{ trans('content.user.password_confirm_password_is_not') }}</div>

							</div>
					  	</div>
					  	 	<input id="token" type="hidden" name="token" value="{{$token}}" >


					  	<div class="text-xs-center marg-top-50">
					  		<button class="btn btn-primary btn-primary--fx full-radius text-uppercase" ng-click="resetPasswordComfirm()">{{ trans('content.user.create_new_pass') }}</button>
					  	</div>

					  	<input type="hidden" name="encrypted" value="<%data.encrypted%>" >
					  	<input type="hidden" name="encrypted_pass" value="<%data.encrypted_pass%>">

					 
					</form>
				</div>
			</div>

		</div>

	</div>

@stop