@extends('layouts.default')

@section('content')	

	<div class="max-container marg-from-menu">

		<div class="login-with-image-left">

			<div class="row space0 display-flex flex-items-xs-center">
				<div class="col-md-6">
					<form method="POST" novalidate="" name="forgetPassFrm" class="login-frm flat-control-form-border">
						
						<h1 class="_title text-uppercase text-xs-center marg-bottom-50 text-primary-col">{{ trans('content.user.success_request_new_pass') }}</h1>

						<?php
							$_session = Session::all();
							$myEmail =  isset($_session['email'])?$_session['email']:  '';
						?>
						

						<h5 class="text-xs-center marg-bottom-50">{!! trans('content.user.we_already_send_to_your_email',['EMAIL'=>$myEmail]) !!}<br><br> 
						<span>{{ trans('content.user.did_see_email_send') }} <a href="{{$baseUrlLang . '/reset-password?email=' . $myEmail }}" title="">{{ trans('content.user.click_send_again') }}</a></span></h5>

					  	<div class="text-xs-center marg-top-50">
					  		<a href="{{$baseUrlLang . '/login'}}" class="btn btn-primary btn-primary--fx full-radius text-uppercase">{{ trans('content.user.back_log_in') }}</a>
					  	</div>


					</form>
				</div>
			</div>

		</div>

	</div>

@stop