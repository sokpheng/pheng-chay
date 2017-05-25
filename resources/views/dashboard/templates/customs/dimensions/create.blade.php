<md-dialog aria-label="New Type" id="dialog-new-type">
    <form name="dialogFormType" ng-submit="save($event)">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Create <% type_name %></h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content class="dimension-create">
            <div layout-gt-xs="column" style="margin-top: 15px;">
              <md-tabs md-dynamic-height md-border-bottom>
                  {{-- Detail Description --}}
                    <md-tab label="detail">
                    	<div style="margin-top: 15px;" layout-gt-xs="column">
            	            <md-input-container flex-gt-xs>
            	                <label>Display Name</label>
            	                <input ng-model="data.display_name" name="display_name" required ng-disabled="noDimensionInfo">
            		          	<div ng-messages="dialogFormType.display_name.$error"
            		          		 ng-show="dialogFormType.display_name.$dirty && dialogFormType.display_name.$invalid">
            			          	<div ng-message="required">Display Name is required</div>
            			        </div>
            	            </md-input-container>
            	            {{-- <md-input-container flex>
            	                <label>Name</label>
            	                <input ng-model="data.name" name="name" required ng-disabled>
            	            </md-input-container>    --}}
                          <md-input-container flex-gt-xs ng-if="data.set_range_price" fng-if="['food', 'drink', 'origin'].indexOf(data.type) != -1">
                              <label>Min Price</label>
                              <input ng-model="data.min_price" step="any" name="min_price" type="number">
                            <div ng-messages="dialogFormType.min_price.$error"
                               ng-show="dialogFormType.min_price.$dirty && dialogFormType.min_price.$invalid">
                              <div ng-message="invalid">Min Price is not valid</div>
                          </div>
                          </md-input-container>
                          <md-input-container flex-gt-xs ng-if="data.set_range_price"  fng-if="['food', 'drink', 'origin'].indexOf(data.type) != -1">
                              <label>Max Price</label>
                              <input ng-model="data.max_price" step="any" name="max_price" type="number">
                            <div ng-messages="dialogFormType.max_price.$error"
                               ng-show="dialogFormType.max_price.$dirty && dialogFormType.max_price.$invalid">
                              <div ng-message="invalid">Max Price is not valid</div>
                          </div>
                          </md-input-container>
            	            <md-input-container flex-gt-xs ng-if="data.set_range_price">
            	                <label>Start Time</label>
            	                <input ng-model="data.start_time" name="start_time" type="text">
            		          	<div ng-messages="dialogFormType.start_time.$error"
            		          		 ng-show="dialogFormType.start_time.$dirty && dialogFormType.start_time.$invalid">
            			          	<div ng-message="invalid">Start Time is not valid</div>
            			        </div>
            	            </md-input-container>
            	            <md-input-container flex-gt-xs ng-if="data.set_range_price" >
            	                <label>End Time</label>
            	                <input ng-model="data.end_time" name="end_time" type="text">
            		          	<div ng-messages="dialogFormType.end_time.$error"
            		          		 ng-show="dialogFormType.end_time.$dirty && dialogFormType.end_time.$invalid">
            			          	<div ng-message="invalid">End Time is not valid</div>
            			        </div>
            	            </md-input-container>
            	            <md-input-container flex-gt-xs ng-if="!noDimensionInfo || data.set_range_price">
            	                <label>Order Number</label>
            	                <input ng-model="data.seq_number" name="seq_number" type="number">
            		          	<div ng-messages="dialogFormType.seq_number.$error"
            		          		 ng-show="dialogFormType.seq_number.$dirty && dialogFormType.seq_number.$invalid">
            			          	<div ng-message="$invalid">Order Number is required</div>
            			        </div>
            	            </md-input-container>
            	            <md-input-container flex-gt-xs ng-if="!noDimensionInfo || data.set_range_price">
            	                <label>Description</label>
            	                <textarea ng-model="data.description" columns="1" name="description"
            	                	fmd-maxlength="150"></textarea>
            	            </md-input-container>
                          <md-checkbox ng-model="data.is_landing_page" ng-if="!noDimensionInfo || data.set_range_price" aria-label="Checkbox 1">
                            Show in Home Page: <% data.is_landing_page %>
                          </md-checkbox>
                        </div>
                    </md-tab>
                    {{-- COVER IMAGE --}}
                    <md-tab label="cover image" ng-if="!noCoverUpload">
                        <div layout-padding-row="16" class="logo-container">
                           <div class="logo-inner" layout="column" layout-align="center center"
                               style="background-image: url('<% uploadingFile.src ? uploadingFile.src : data.logo.thumbnail_url_link %>')">

                               <span class="icon-camera" ng-show="!data.logo"></span>
                               <span class="upload-text" ng-show="!data.logo">Category Logo Here</span>
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
                    </md-tab>

                      <md-tab label="locale khmer">
                      	<div style="margin-top: 15px;" layout-gt-xs="column">
              	            <md-input-container flex-gt-xs>
              	                <label>Display Name (Khmer)</label>
              	                <input ng-model="data.locale.kh.display_name" name="display_name" ng-disabled="noDimensionInfo">
              		          	<div ng-messages="dialogFormType.locale.kh.display_name.$error"
              		          		 ng-show="dialogFormType.locale.kh.display_name.$dirty && dialogFormType.locale.kh.display_name.$invalid">
              			          	<div ng-message="required">Display Name (Khmer) is required</div>
              			        </div>
              	            </md-input-container>

                          <md-input-container flex-gt-xs ng-disabled="noDimensionInfo">
                              <label>Description (Khmer)</label>
                              <textarea ng-model="data.locale.kh.description" columns="1" name="description"
                                fmd-maxlength="150"></textarea>
                          </md-input-container>
                        </div>
                    </md-tab>

                </md-tab>
            </md-tabs>
        </div>
        </md-dialog-content>
        <div class="md-actions" layout="row">
			<div layout="row"
				layout-align="space-around center" style="width: 100%">
	            <md-button type="button" ng-click="close()" class="md-primary">
	                Cancel
	            </md-button>
	            <md-button  type="submit" class="md-primary">
	                Save
	            </md-button>
			</div>
        </div>
    </form>
</md-dialog>
