{{-- ========= Map Advance Filter ======== --}}
<div id="fill-info" class="magnific-popup __default mfp-hide size-smm no-padd1 simple-fill-info">

	<div class="header-popup text-center">
		<h3 class="text-uppercase">{{ trans('content.general.contact_info') }}</h3>
		<h5 class="text-capitalize">{{ trans('content.general.we_will_contact_soon') }}</h5>
	</div>

	<div class="content size-xs marg-top-20">

		<form name="frmFillInfo" class="frmFillInfo" novalidate>

			<div class="row">

				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" class="form-control" ng-model="fillInfo.first_name" placeholder="{{ trans('content.general.first_name') }} *" name="first_name" required="">

						<div class="msg_err" ng-messages="frmFillInfo.first_name.$error" role="alert" ng-show="frmFillInfo.first_name.$dirty" ng-cloak>
							<div ng-message="required" class="form-control-feedback">{{ trans('content.general.pls_input_data') }}</div>
						</div>
					</div>	
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" class="form-control" ng-model="fillInfo.last_name" placeholder="{{ trans('content.general.last_name') }} *" name="last_name" required="">
						<div class="msg_err" ng-messages="frmFillInfo.last_name.$error" role="alert" ng-show="frmFillInfo.last_name.$dirty" ng-cloak>
							<div ng-message="required" class="form-control-feedback">{{ trans('content.general.pls_input_data') }}</div>
						</div>
					</div>	
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<input type="text" class="form-control" ng-model="fillInfo.phone_number" placeholder="{{ trans('content.general.phone_number') }} *" name="phone_number" required="">
						<div class="msg_err" ng-messages="frmFillInfo.phone_number.$error" role="alert" ng-show="frmFillInfo.phone_number.$dirty" ng-cloak>
							<div ng-message="required" class="form-control-feedback">{{ trans('content.general.pls_input_data') }}</div>
						</div>
					</div>	
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<input type="email" class="form-control" ng-model="fillInfo.email" placeholder="{{ trans('content.general.email') }} *" name="email" required="">
						<div class="msg_err" ng-messages="frmFillInfo.email.$error" role="alert" ng-show="frmFillInfo.email.$dirty" ng-cloak>
							<div ng-message="required" class="form-control-feedback">{{ trans('content.general.pls_input_data') }}</div>
						    <div ng-message="email" class="form-control-feedback">{{ trans('content.general.this_must_be_email') }}</div>
						</div>
					</div>	
				</div>

				<div class="col-sm-12">
					<div class="form-group">
						<textarea class="form-control" ng-model="fillInfo.remark" placeholder="{{ trans('content.general.remark') }}"></textarea>
					</div>	
					<p>{!! trans('content.general.note') !!}</p>
				</div>

			</div>

		</form>

	</div>


	<div class="footer-popup size-xs text-right simple-btn" ng-init="isLoading=false">
		<button class="btn btn-secondary" ng-click="closePopup()">{{ trans('content.general.cancel') }}</button>
		<button class="btn btn-primary btn-primary--fx full-radius text-uppercase1" ng-click="completeBooking()" ng-class="{'btn-loading': isLoading}" ng-disabled="isLoading || (frmFillInfo.$invalid && frmFillInfo.$dirty)">
			<img class="center-absolute _loading-icon size-sm" src="https://www.hungryhungry.io/img/svg/loading/loading-spin-white.svg" alt="login loading"> <span class="_text">{{ trans('content.general.complete_booking') }}</span>
		</button>
	</div>

</div>