<section class="simple-newseltter padding-section big-padding display-flex flex-end" style="padding-top: 20px;">

	<div class="max-container no-padd" style="position: relative; width: 100%">

		<div class="newseltter-container display-flex flex-center">

			<div class="info">
				<h2 class="text-uppercase">new seltter <br> sign up</h2>
				<p>
					Only members of our special secret Opportunities earn a 5% <br> discount on your next trip. 
				</p>
			</div>
			<div class="subscription-form text-right flex-1">
			   <div class="flat-control-full-radius">
			      <div class="form-group no-marg d-inline-block">

			        <input type="text" class="form-control search-on-nav {{ isset($onMapSearch) ? 'size-lg' : '' }}" name="text_search" id="mega_search" aria-describedby1="emailHelp" placeholder="YOUR EMAIL ADDRESS" value="{{
			            $search_text or ''
			            }}">

			        <button type="submit" class="btn btn-primary btn-search" href="{{ URL::to('/search/top-restaurant') }}" title="">
			         	<span class="icon-send"></span>
			         	<span class="text-uppercase">Search</span>
			        </button>


			      </div>

			   </div>
			</div>

		</div>

	</div>

</section>
