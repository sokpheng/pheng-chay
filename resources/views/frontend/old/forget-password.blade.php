@extends('layouts.default')

@section('content')	

	<div class="max-container marg-from-menu" ng-controller="HomeCtrl">

		<div class="login-with-image-left">

			<div class="row space0 display-flex flex-items-xs-center">
				<div class="col-md-6">
					<form method="POST" name="forgetPassFrm" novalidate1="" class="login-frm flat-control-form-border" action="{{url::to($baseUrlLang.'/reset-password')}}">
						
						<h1 class="_title text-uppercase text-xs-center marg-bottom-50 text-primary-col">{{ trans('content.user.forget_password') }}</h1>

						<h5 class="text-xs-center marg-bottom-50">{{ trans('content.user.instruction_request_password') }}</h5>

						<div class="form-group marg-lg">
						    <input type="email" name="email" class="form-control" placeholder="{{ trans('content.user.email') }} *" required="" ng-model="email">
					  	</div>

					  	<?php
							$_session = Session::all();
						?>
						
						@if(isset($_session['error']))
							<div class="alert alert-danger" role="alert">
							  {!! trans('content.user.forget_password_err_msg') !!} 
							</div>
						@endif
					  	
					  	<div class="text-xs-center marg-top-50">
					  		<button type="button" class="btn btn-primary btn-primary--fx full-radius text-uppercase" ng-click="resetPassword()">{{ trans('content.user.request') }}</button>
					  	</div>

					    {{ csrf_field() }}

					  	<input type="hidden" name="encrypted" value="<%data.encrypted%>" >
					  	<input type="hidden" name="encrypted_pass" value="<%data.encrypted_pass%>">




					</form>
				</div>
			</div>

		</div>

	</div>

@stop