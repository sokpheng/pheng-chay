<div class="_you-might-also-like">

	<div class="list-container">

		@for($i=1;$i<=10;$i++)
			<div class="list-item mock-up-font">

				<div class="media">
				  	<a class="media-left" href="#"></a>
				  	<div class="media-body">
					    {{-- <a href="#" class="media-heading link-secondary-col"> --}}
					    	------------------
					    {{-- </a> --}}
					  	<div class="feature">
					  		---------------------------------------
					  		<b class="_price no-marg">
								----
					  		</b>
					  	</div>
					  	<span class="address" ng-show1="restItem.address">--------------------</span>
				  	</div>
				  	<div class="_rate display-flex flex-items-xs-middle hidden-xs-up">
				  		<span class="_val">0.0</span>
				  	</div>
				</div>
			</div>
		@endfor

	</div>

</div>