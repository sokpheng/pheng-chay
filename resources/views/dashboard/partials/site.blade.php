<div>
		
	<h3 class="md-headline">
		Update your site information
	</h3>
	<form layout="row" layout-padding="16" name="siteForm" layout-align="center center">
		<md-content style="width: 100%; max-width: 600px;">
	      	<div layout layout-sm="column">
		        <md-input-container flex>
		          	<label>Name</label>
		          	<input ng-model="data.name" name="name" required>
		          	<div ng-messages="siteForm.name.$error" 	
		          		 ng-show="siteForm.name.$dirty && 
		          		 	siteForm.name.$invalid">
			          	<div ng-message="required">Site name is needed</div>
			        </div>
		        </md-input-container>	     
	      	</div>

	      	<div layout layout-sm="column">
	      		<md-input-container flex>
	      			<label>Type</label>
		          	<input ng-model="data.type" name="type" required>
		          	<div ng-messages="siteForm.type.$error" 	
		          		 ng-show="siteForm.type.$dirty && 
		          		 	siteForm.type.$invalid">
			          	<div ng-message="required">Type is required</div>
			        </div>
	      		</md-input-container>
	      		<md-input-container flex>
			        <md-select placeholder="Year" ng-model="data.year"
			        	style="padding-bottom: 0px;" name="year" required>
						<md-option ng-repeat="year in years" value="<% year %>">
							<% year %>
						</md-option>
					</md-select>    
		          	<div ng-messages="siteForm.year.$error" 	
		          		 ng-show="siteForm.year.$dirty && siteForm.year.$invalid">
			          	<div ng-message="required">Year value is invalid</div>
			        </div>
				</md-input-container>
	      	</div>

	      	<md-input-container flex>
                <label>Description</label>
                <textarea ng-model="data.description" columns="1" name="description"
                	md-maxlength="150"></textarea>  
	      	</md-input-container>

	        <section layout="row" layout-sm="column" 
	        	style="margin-top: 15px; margin-bottom: 15px;">
	        	<section layout="row" layout-sm="column" layout-align="start center" flex="50">
	        		<md-button class="md-raised md-primary" 
		      			ng-click="save($event)">Save</md-button>
	        	</section>
		      	
		    </section>
      	</md-content>
    </form>
</div>