<div>
	<!-- START: HEADER TOOLBAR -->
	<md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
        <h2>
	        <span ng-show="coupon_type != 'promotions'">
			    Create/Edit Coupon Information
			</span>
	        <span ng-show="coupon_type == 'promotions'">
			    Create/Edit Promotion Information
			</span>

        </h2>
        <span flex></span>
      </div>
    </md-toolbar>

    <!-- START: CONTENT DATA -->
    <md-content layout-padding="16" class="transparent-content">
		<md-content class="box-shadow-content">
			<form layout="row" layout-padding="16" name="enterpriseForm" layout-align="center center"
				ng-submit="submit()" ng-disabled="loading">
				<md-content style="width: 100%; max-width: 960px;"
					class="transparent-content enterprise-create">
					<div class="" layout-gt-xs="row">

				      	<div flex-gt-xs>
				      		<div layout-gt-xs="column">
				      			<h2 class="md-title" ng-show="coupon_type != 'promotions'">Shop to create coupon</h2>
				      			<h2 class="md-title" ng-show="coupon_type == 'promotions'">Shop to create promotion</h2>


					      		<md-input-container flex-gt-xs>
						          	<label>Shop name</label>
						          	<input ng-model="data.directory_name" name="name" required ng-disabled="true">
						          	<div ng-messages="siteForm.name.$error"
						          		 ng-show="siteForm.name.$dirty &&
						          		 	siteForm.name.$invalid">
							          	<div ng-message="required">Shop name is needed</div>
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
						      	<md-input-container fake-md-no-float  flex-gt-xs>
							      	<md-icon md-font-icon="icon-file-text" class="icon-contact"></md-icon>
							      	<input ng-model="data.description" ng-disabled="loading" type="text" placeholder="Description" ng-required="true"  name="description">
							    </md-input-container>
							    <md-input-container  flex-gt-xs>
							      	<!-- Use floating placeholder instead of label -->
							      	<md-icon md-font-icon="icon-coin-dollar" class="email icon-contact"></md-icon>
							      	<input ng-model="data.amount" ng-disabled="loading"
							      		type="number" placeholder="Discount Percentage" name="amount">
							    </md-input-container>
							    <md-input-container  flex-gt-xs>
							      	<md-icon md-font-icon="icon-calendar" class="icon-contact" style="display:inline-block;"></md-icon>
							      	{{-- <input ng-model="data.start_date" ng-disabled="loading" type="text" placeholder="Start Date"> --}}
							      	<input mdc-datetime-picker date="true" time="false" type="text" id="time" short-time="true"
						               placeholder="Start Date"
						               fake-min-date="minDate"
						               max-date="data.end_date"
						               fformat="DD/MM/YYYY"
						               ng-model="data.start_date">
							    </md-input-container>
							    <md-input-container  flex-gt-xs>
							      	<md-icon md-font-icon="icon-calendar" class="icon-contact" style="display:inline-block;"></md-icon>
							      	{{-- <input ng-model="data.end_date" ng-disabled="loading" type="text" placeholder="End Date"> --}}
							      	<input mdc-datetime-picker date="true" time="false" type="text" id="time" short-time="true"
						               placeholder="End Date"
						               min-date="data.start_date"
						               fformat="DD/MM/YYYY"
						               ng-model="data.end_date">
							    </md-input-container>
							    
						      	<md-input-container fake-md-no-float  flex-gt-xs>
							      	<md-icon md-font-icon="icon-file-text" class="icon-contact"></md-icon>
							      	<input ng-model="data.priority" ng-disabled="loading" type="text" placeholder="Order sequence"   name="priority">
							    </md-input-container>
						    </div>
				      	</div>

				      	<div flex-gt-xs>
					         <div layout-padding-row="16" class="logo-container">
					         	<div class="logo-inner" layout="column" layout-align="center center"
					         		style="background-image: url('<% uploadingFile.src ? uploadingFile.src : data.logo.thumbnail_url_link %>')">

					         		<span class="icon-camera" ng-show="!data.logo"></span>
					         		<span class="upload-text" ng-show="!data.logo">Coupon Image Here</span>
					         		{{-- <span class="upload-text" ng-show="mode === 'create'">Please, save your listing first before upload</span> --}}
					         		<div class="overlay"
					         			ng-class="{'show': uploadingFile.loading}"
					         			ng-show="mode === 'edit'"></div>
					         		<md-progress-circular md-mode="determinate"
					         			ng-show="uploadingFile.loading"
					         			value="<% uploadingFile.progress %>"></md-progress-circular>
					         	</div>
					         	<span class="icon-upload3 center" ng-show="!uploadingFile.loading"
					         		ngf-select ng-model="files" ngf-change="uploadLogo(files)" multiple="false">
					         	</span>
					         </div>
							 
						</div>
			      			
			      	</div>

			        <section layout="row" layout-sm="column"
			        	style="margin-top: 15px; margin-bottom: 15px;">
			        	<section layout="row" layout-sm="column" layout-align="start center" flex="50">
			        		<md-button class="md-raised md-primary" type="submit"
				      			fng-click="save($event)">Save</md-button>
			        		<md-button class="md-raised md-danger" type="button"
				      			ng-click="delete($event)">Delete</md-button>
			        	</section>
			        	<section layout="row" layout-sm="column" layout-align="end center" flex="50">
			        		<md-button class="md-raised md-primary" type="button" ng-show="data._id && data.status !== 'published'"
				      			ng-click="publish($event)">Publish</md-button>
			        		<md-button class="md-raised md-danger" type="button" ng-show="data._id && data.status == 'published'"
				      			ng-click="unpublish($event)">Unpublish</md-button>
			        	</section>

				    </section>
			    </md-content>
		    </form>
	    </md-content>
    </md-content>
</div>
