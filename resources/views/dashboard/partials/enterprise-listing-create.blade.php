<div>
		
	<h3 class="md-headline text-center form-create-header">
		Add New Enterprise Listing
	</h3>
	<form layout="row" layout-padding="16" name="enterpriseForm" layout-align="center center"
		ng-submit="submit()" ng-disabled="loading">
		<md-content style="width: 100%; max-width: 960px;" class="enterprise-create">
			<div class="" layout layout-sm="column">

		      	<div flex>
		      		<div layout-padding-row="16">
			      		<md-input-container flex>
				          	<label>Organization Name</label>
				          	<input ng-model="data.name" name="name" required ng-disabled="loading">
				          	<div ng-messages="siteForm.name.$error" 	
				          		 ng-show="siteForm.name.$dirty && 
				          		 	siteForm.name.$invalid">
					          	<div ng-message="required">Site name is needed</div>
					        </div>
				        </md-input-container>	

			      		{{-- <md-input-container flex>
					        <md-select placeholder="Organization Category" ng-model="data.category_id"
					        	style="padding-bottom: 0px;" name="category" required  ng-disabled="loading">
								<md-option ng-repeat="category in categories" value="<% category.id %> ">
									<% category.display_name %>
								</md-option>
							</md-select>    
				          	<div ng-messages="siteForm.category.$error" 	
				          		 ng-show="siteForm.category.$dirty && siteForm.category.$invalid">
					          	<div ng-message="required">Year value is invalid</div>
					        </div>
						</md-input-container> --}}
				      	<md-input-container fake-md-no-float>
					      	<md-icon md-font-icon="icon-mobile2" class="icon-contact"></md-icon>
					      	<input ng-model="data.phones" ng-disabled="loading" type="text" placeholder="Phone Number (required)" ng-required="true">
					    </md-input-container>
					    <md-input-container >
					      	<!-- Use floating placeholder instead of label -->
					      	<md-icon md-font-icon="icon-envelop" class="email icon-contact"></md-icon>
					      	<input ng-model="data.emails" ng-disabled="loading" type="email" placeholder="Email (required)" ng-required="true">
					    </md-input-container>
					    <md-input-container>
					      	<md-icon md-font-icon="icon-earth" class="icon-contact" style="display:inline-block;"></md-icon>
					      	<input ng-model="data.websites" ng-disabled="loading" type="text" placeholder="Website" >
					    </md-input-container>
					    <md-input-container>
					      	<md-icon md-font-icon="icon-location2" class="icon-contact" style="display:inline-block;"></md-icon>
					      	<input ng-model="data.address" ng-disabled="loading" type="text" placeholder="Address (required)" ng-required="true">
					    </md-input-container>

				      	<md-input-container flex>
			                <label>Description</label>
			                <textarea ng-model="data.description" 
			                	style="min-height: 200px;"
			                	ng-disabled="loading" columns="1" name="description"
			                	md-maxlength="1000"></textarea>  
				      	</md-input-container>
				    </div>
		      	</div>

		      	<div flex>
			         <div layout-padding-row="16" class="logo-container">
			         	<div class="logo-inner" layout="column" layout-align="center center"
			         		style="background-image: url('<% uploadingFile.src ? uploadingFile.src : (mediaUrl ? mediaUrl + data.logo.file_name : '/' + data.logo.file_name ) %>')">

			         		<span class="icon-camera" ng-show="!data.logo"></span>
			         		<span class="upload-text" ng-show="!data.logo">Company Logo Here</span>
			         		{{-- <span class="upload-text" ng-show="mode === 'create'">Please, save your listing first before upload</span> --}}
			         		<div class="overlay" 
			         			ng-class="{'show': uploadingFile.loading}"
			         			ng-show="mode === 'edit'"></div>
			         		<md-progress-circular md-mode="determinate" 
			         			ng-show="uploadingFile.loading"
			         			value="<% uploadingFile.progress %>"></md-progress-circular>
			         	</div>
			         	<span class="icon-upload3" ng-show="!uploadingFile.loading"
			         		ngf-select ng-model="files" ngf-change="uploadLogo(files)" multiple="false">
			         	</span>
			         </div>
	      			<div layout="column" layout-padding-row="16">
	      				<ui-gmap-google-map center='map.center' 
	      					events="map.events"
	      					zoom='map.zoom'>
	      					<ui-gmap-marker coords="marker.coords" 
	      						options="marker.options" 
	      						events="marker.events" 
	      						idkey="marker.id">
        					</ui-gmap-marker>
	      				</ui-gmap-google-map>
	      			</div>
		      	</div>
	      	</div>
	      
	      	<div layout-padding-row="16">
	      		<div class="chips-group">
					<md-chips ng-model="select_categories" 
						ng-change="itemChange()"
						md-autocomplete-snap 
						md-require-match="true">
						<md-autocomplete
					          md-selected-item="selectedItem"
					          md-search-text="searchText"
					          md-items="item in querySearch(searchText)"
					          md-search-text-change="itemChange()"
					          md-item-text="item.name"
					          placeholder="Tag the categories"
					          md-item-text="item.display_name">
					        <md-item-template>
						        <span >
						        	<% item.display_name %>
						        </span>
					       	</md-item-template>
					    </md-autocomplete>
						<md-chip-template >
							<strong><% $chip['display_name'] %></strong>
						</md-chip-template>
					</md-chips>
				</div>

		      	<md-input-container flex>
	                <label>Social Issues</label>
	                <textarea ng-model="data.social_issues" 
	                	ng-disabled="loading" columns="1" name="social_issues"
	                	md-maxlength="1000"></textarea>  
		      	</md-input-container>

		      	<md-input-container flex>
	                <label>Solutions</label>
	                <textarea ng-model="data.solutions" 
	                	ng-disabled="loading" columns="1" name="solutions"
	                	md-maxlength="1000"></textarea>  
		      	</md-input-container>

		      	<md-input-container flex>
	                <label>Main Activities</label>
	                <textarea ng-model="data.main_activities" 
	                	ng-disabled="loading" columns="1" name="main_activities"
	                	md-maxlength="1000"></textarea>  
		      	</md-input-container>

		      	<md-input-container flex>
	                <label>Impact</label>
	                <textarea ng-model="data.impact" 
	                	ng-disabled="loading" columns="1" name="impact"
	                	md-maxlength="1000"></textarea>  
		      	</md-input-container>


				<div class="switch-active" ng-class="{'active': data.is_active}" style="margin-top: 25px;">
					<md-switch class="md-primary"  ng-disabled="loading" aria-label="Enable this listing" 
						ng-model="data.is_active">
						<label>Make this listing active</label>				          	
					</md-switch>
		        </div>	

		      	{{-- <md-input-container flex>
	                <label>Long Description</label>
	                <textarea ng-model="data.description" ng-disabled="loading" columns="1" name="description"
	                	style="min-height: 120px"
	                	md-maxlength="1200"></textarea>  
		      	</md-input-container> --}}

		      	<section style="margin-top: 25px;">
		      		<label>Media Gallery</label>
		      	</section>

		      	<section layout="row" layout-sm="column" 
		      		class="media-gallery"
		      		style="margin-top: 15px; margin-bottom: 15px;">
		      		<div class="media" flex="33">
		      			<div class="logo-inner" layout="column" layout-align="center center">
			         		<span class="icon-camera"></span>
			         		<span class="upload-text">Upload your gallery here</span>
			         		{{-- <span class="upload-text" ng-show="mode === 'create'">Please, save your listing first before upload</span> --}}
			         		<div class="overlay" ng-show="mode === 'edit'"></div>
			         	</div>
			         	<span class="icon-upload3"
			         		ngf-select ng-model="files" ngf-change="uploadMedia(files)" 
			         		multiple="false">
			         	</span>
		      		</div>
		      		{{-- Media --}}
		      		<div class="media uploaded" flex="33" ng-repeat="media in data.photos">
		      			<div class="logo-inner" layout="column" layout-align="center center"
		      				style="background-image: url('<% mediaUrl ? mediaUrl + media.file_name : '/' + media.file_name %>')">
			         		<div class="overlay"></div>
			         		<div class="remove icon-cross" ng-click="deletePhoto(media)"></div>
			         	</div>
			         	<span class="icon-search" href="<% mediaUrl ? mediaUrl + media.file_name : '/' + media.file_name %>" data-title="<% data.name %>"></span>
		      		</div>
		      		{{-- Pending --}}
		      		<div class="media" flex="33" ng-repeat="media in pendingFiles">
		      			<div class="logo-inner" layout="column" layout-align="center center"
		      				style="background-image: url('<% media.src %>')">
			         		<div class="overlay" ng-show="mode === 'edit'"></div>
			         		<md-progress-circular md-mode="determinate" 
			         			ng-show="media.loading"
			         			value="<% media.progress %>"></md-progress-circular>
			         		<div ng-show="!media.loading" class="remove icon-cross" ng-click="deletePendingPhoto(media)"></div>
			         	</div>
		      		</div>
		      	</section>
	      	</div>

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