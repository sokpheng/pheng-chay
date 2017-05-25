<div class="rating-option {{ $rating_cls }}">
	<ul class="clearUL">
		<li class="d-inline-block align-middle"><div class="rate-result tag tag-default {{ $rating_box_size }}">
			<span class="_val">{{  round(isset($restuarntInfo['rating'])?$restuarntInfo['rating']:0, 1, PHP_ROUND_HALF_UP) }}</span>
			<span class="max-rate-num">/ 10</span>
		</div></li>
		<li class="d-inline-block align-middle">

			<?php

				$_like = isset($restuarntInfo['like_total'])?$restuarntInfo['like_total']:0;
				$_like_plural = 2;
				if($_like==0){
					$_like_plural = 1;
				}										
			?>

			<span class="rate_count d-block1" ng-init="like_total='{{ $_like }}'" ng-bind="like_total"></span>
			<span class="_text">{{ trans_choice('content.detail.like', $_like_plural) }}</span>
		</li>
		<li class="d-inline-block align-middle" >
			<button type="button" class="bt-clear-style btn-like" ng-init="is_like_active='{{isset($restuarntInfo['like'])?true:false}}'" ng-class="{'active':is_like_active}"  ng-click="like('{{ $restuarntInfo['_id'] }}')"><span class="icon-favorite"></span></button>
		</li>
	</ul>
</div>