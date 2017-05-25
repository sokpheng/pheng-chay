
@if(!isset($hide_subcription) && isset($neverTrue))
	@include("includes.elements.section.simple-newseltter")
@endif

@include("includes.elements.section.simple-follow-us")

<div class="simple-footer bg-primary">
	<div class="padding-section padd-left-right">
			
		<div class="max-container no-padd need-padd">

			<div class="footer-menu simple-menu padd-sm">

				<ul class="clearUL text-center">
					<li class="d-inline-block"><a href="{{ $baseUrlLang }}">{{ trans('content.navbar.explore_hotels') }}</a></li>
					<li class="d-inline-block"><a href="{{ $baseUrlLang.'/contact-us' }}">{{ trans('content.footer.contact_us') }}</a></li>
					{{-- <li class="d-inline-block"><a href="{{ $baseUrlLang.'/terms-privacy' }}">{{ trans('content.footer.terms_policy_privacy') }}</a></li> --}}
				</ul>

				<hr class="line-col-fade-left-right marg-md less-col md-width">

				<?php

					$startYear = 2017;

					$yearNow = '';

					if(date("Y")>$startYear)
						$yearNow = ' - ' . date("Y");

					$createdSince = $startYear . $yearNow;


				?>
  
				<h6 class="text-center copy-right no-padd">©{{ $createdSince }} Cambodroom. {{ trans('content.footer.copy_right') }} <a href="http://flexitech.io/" target="_blank">Flexitech</a>.</h6>

			</div>

		</div>
	</div>
</div>