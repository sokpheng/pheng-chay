
{{-- ========= Map Advance Filter ======== --}}
<div id="coupon_promotion" class="magnific-popup __default mfp-hide size-smm no-padd coupon-promotion" ng-if="couponPromoSelected">
	

	<div class="content no-padd" ng-init1="_img = hhModule.getRestCover(couponPromoSelected);">

		<a style="display: block;" href="{{ $baseUrlLang }}/restaurant/<% hhModule.getRestDetail(couponPromoSelected) %>" class="img-container">
			<img ng-src="<% hhModule.getRestCover(couponPromoSelected).src %>" alt="<% couponPromoSelected.directory_name %>" style="width: 100%;">
			<div class="coupon">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" viewBox="0 0 23 32">
					<path fill="#fff" d="M20.786 2.286q0.411 0 0.786 0.161 0.589 0.232 0.938 0.732t0.348 1.107v23.018q0 0.607-0.348 1.107t-0.938 0.732q-0.339 0.143-0.786 0.143-0.857 0-1.482-0.571l-7.875-7.571-7.875 7.571q-0.643 0.589-1.482 0.589-0.411 0-0.786-0.161-0.589-0.232-0.938-0.732t-0.348-1.107v-23.018q0-0.607 0.348-1.107t0.938-0.732q0.375-0.161 0.786-0.161h18.714z"></path>
				</svg>
				<span class="_dis_value"><% couponPromoSelected.discount %>%</span>
			</div>
			
		</a>

		<div class="info">
			<div class="main_title link-black-hover">
				<a href="{{ $baseUrlLang }}/restaurant/<% hhModule.getRestDetail(couponPromoSelected) %>"><% couponPromoSelected.directory_name %></a>
				<div class="hungry-logo-container float-sm-right marg-top-20">
					<img class="water-mark" src="{{ asset('img/logo-text.png') }}" alt="Hungry Hungry Cambodia">
				</div>
			</div>
			<ul class="clearUL terms">
				<li><span>{{ trans('content.general.coupon_term_1') }}</span></li>
				<li><span>{{ trans('content.general.coupon_term_2') }}</span></li>
			</ul>

			<h5 class="expire-date">
				<span class="1icon-schedule1">{{ trans('content.general.expired_on') }} </span>
				<span class="_date float-xs-right"><% couponPromoSelected.end_date | date: 'MMM d, y' %> </span>
			</h5>
		</div>
	</div>


{{-- 	<div class="footer-popup no-padd-top1 bt-gray">
		<div class="text-xs-right">
			<button class="btn btn-primary btn-apply" ng-click="applyFilter()">{{ trans('content.general.close') }}</button>
		</div>
	</div> --}}


</div>

