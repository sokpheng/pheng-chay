{{-- hotel roomtype create --}}

<md-dialog aria-label="New Type" id="dialog-new-type">
    <form name="dialogFormType" class="size-lg" ng-submit="save($event)">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Create Room Type</h2>
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
            	                <label>Title</label>
            	                <input ng-model="data.title" name="title" required ng-disabled="noDimensionInfo">
            		          	   <div ng-messages="dialogFormType.title.$error"
            		          		 ng-show="dialogFormType.title.$dirty && dialogFormType.title.$invalid">
            			          	    <div ng-message="required">Title is required</div>
            			           </div>
            	            </md-input-container>

                          <md-input-container flex-gt-xs>
                              <label>Option</label>
                              <input ng-model="data.options" name="options" required ng-disabled="noDimensionInfo">
                               <div ng-messages="dialogFormType.options.$error"
                               ng-show="dialogFormType.options.$dirty && dialogFormType.options.$invalid">
                                  <div ng-message="required">Options is required</div>
                             </div>
                          </md-input-container>

                             <md-input-container flex-gt-xs>
                                    <label>Discount</label>
                                    <input ng-model="data.discount" name="discount" type="number">
                                  <div ng-messages="dialogFormType.discount.$error"
                                     ng-show="dialogFormType.discount.$dirty && dialogFormType.discount.$invalid">
                                    <div ng-message="invalid">Discount number is not valid</div>
                                </div>
                            </md-input-container>

                             <md-input-container flex-gt-xs>
                                    <label>Price</label>
                                    <input ng-model="data.price" step="any" name="price" type="number">
                                  <div ng-messages="dialogFormType.price.$error"
                                     ng-show="dialogFormType.price.$dirty && dialogFormType.price.$invalid">
                                    <div ng-message="invalid">Price number is not valid</div>
                                </div>
                            </md-input-container>

                            <md-input-container flex-gt-xs>
                                    <label>Capacity</label>
                                    <input ng-model="data.capacity" name="capacity" type="number">
                                  <div ng-messages="dialogFormType.capacity.$error"
                                     ng-show="dialogFormType.capacity.$dirty && dialogFormType.capacity.$invalid">
                                    <div ng-message="invalid">Capacity number is not valid</div>
                                </div>
                            </md-input-container>

                           






                        {{--   <md-input-container flex-gt-xs ng-show="isShowQty">
                              <label>Qty</label>
                              <input ng-model="data.stock.qty" name="qty" type="number" required ng-disabled="noDimensionInfo">
                              <div ng-messages="dialogFormType.qty.$error"
                                   ng-show="dialogFormType.qty.$dirty && dialogFormType.qty.$invalid">
                                  <div ng-message="$invalid">Qty is required</div>
                              </div>
                          </md-input-container>
 --}}
                  
            	            {{-- <md-input-container flex>
            	                <label>Name</label>
            	                <input ng-model="data.name" name="name" required ng-disabled>
            	            </md-input-container>    --}}
                            
                          {{-- <md-input-container flex-gt-xs>
                              <label>Type</label>
                              <md-select placeholder="Type" ng-model="data.type" 
                              style="padding-bottom: 0px;" flex-gt-xs>
                                <md-option value="">None</md-option>
                                <md-option value="category">Category</md-option>
                                <md-option value="subcategory">Sub Category</md-option>
                            </md-select>  
                          </md-input-container>
                          <md-input-container flex-gt-xs>
                              <label>First Constraint</label>
                              <md-select placeholder="First constraint" ng-model="data.first_constraint" 
                              style="padding-bottom: 0px;" flex-gt-xs>
                                <md-option value="">None</md-option>
                                <md-option value="top">Top</md-option>
                                <md-option value="inside">Inside</md-option>
                            </md-select>  
                          </md-input-container> --}}
            	           
            	          
                      </div>
                    </md-tab>
                    {{-- Parent --}}
                     <md-tab label="feature">
                        <div style="margin-top: 15px;" layout-gt-xs="column">

                            <md-input-container flex-gt-xs>
                                <md-chips ng-model="selectedType" md-autocomplete-snap
                                fake-md-transform-chip="ctrl.transformChip($chip)"  placeholder="Type"
                                fake-md-require-match="ctrl.autocompleteDemoRequireMatch">
                                    <md-autocomplete
                                    md-selected-item="selectedItem"
                                    md-search-text="searchText"
                                    md-items="item in querySearchCategory(searchText)"
                                    md-item-text="item"
                                    placeholder="Search for a type">
                                    <md-item-template>
                                        <span >
                                          <% item %>
                                        </span>
                                        </md-item-template>
                                        </md-autocomplete>
                                        <md-chip-template>
                                        <span>
                                          <strong ng-bind="$chip"><% $chip %></strong>
                                        </span>
                                    </md-chip-template>
                                </md-chips>
                            </md-input-container>

                            


                            <md-input-container flex-gt-xs >
                                <md-chips ng-model="selectedInclude" md-autocomplete-snap
                                fake-md-transform-chip="ctrl.transformChip($chip)" placeholder="Include"
                                fake-md-require-match="ctrl.autocompleteDemoRequireMatch">
                                    <md-autocomplete
                                    md-selected-item="selectedItem"
                                    md-search-text="searchText"
                                    md-items="item in querySearchCategory(searchText)"
                                    md-item-text="item"
                                    placeholder="Search for a include">
                                    <md-item-template>
                                        <span >
                                          <% item %>
                                        </span>
                                        </md-item-template>
                                        {{-- <span md-highlight-text="searchText"><span ng-bind="item.value"></span></span> --}}
                                        </md-autocomplete>
                                        <md-chip-template>
                                        <span>
                                          <strong ng-bind="$chip"><% $chip %></strong>
                                        </span>
                                    </md-chip-template>
                                </md-chips>
                            </md-input-container>

                          
                        
                        </div>
                    </md-tab>

                    {{-- COVER IMAGE --}}
                    <md-tab label="cover image" ng-if="!data.isCreated">
                        <md-content class="md-padding">
                      <h1 class="md-display-2">Media & Gallery </h1>

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
                          <span class="icon-upload3 center"
                            ngf-select ng-model="files" ngf-change="uploadMedia(files)"
                            multiple="false">
                          </span>
                        </div>
                        {{-- Media --}}
                        <div class="media uploaded" flex="33" ng-repeat="media in data.roomtype_gallery">
                          <div class="logo-inner" layout="column" layout-align="center center"
                            style="background-image: url('<% media.thumbnail_url_link %>')">
                            <div class="overlay"></div>
                            <div class="remove icon-cross" ng-click="deletePhoto(media)"></div>
                          </div>
                          <span class="icon-search left" href="<% mediaUrl ? mediaUrl + media.file_name : '/' + media.file_name %>" data-title="<% data.name %>"></span>
                          <span class="icon-heart right" ng-class="{'selected': data.roomtype_cover_media == media._id}" href="javascript:void(0)" ng-click="updateRoomtypeCover(media, $event)" data-title="<% data.name %>"></span>
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
                    </md-content>
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
