<div id="page-create-post">
	<md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
       {{--  <md-button class="md-icon-button" aria-label="Settings">
          <md-icon md-svg-icon="img/icons/menu.svg"></md-icon>
        </md-button> --}}
        <h2>
	        <span ng-if="mode!=='locale'">			
			    <span ng-if="mode=='create'">
			    	Create post
			    </span>
			    <span ng-if="mode=='edit'">
			    	Edit post
			    </span>
			</span>
          	<span ng-if="mode == 'locale'">
          		Edit your new post's locale          			
			    	<span class="parent-of before after">
			    		<span class="tag" ng-click="choosePostLocale($event)"><% locales[locale] %> Edition Of</span>
			    	</span>
			    	<span class="parent-of">
			    		<span>
			    			<a target="_blank" href="#/posts/<% data.parent.id %>"><% data.parent.title %></a>
			    		</span>
			    	</span>
          	</span>


        </h2>
        <span flex></span>
      </div>
    </md-toolbar>

	{{-- <div ng-if="mode==='locale'">		
	    <h3 class="md-headline text-center form-create-header">Edit your new article's locale</h3>
	    <h4 class="md-title">
	    	<span class="parent-of before after">
	    		<span class="tag" ng-click="choosePostLocale($event)"><% locales[locale] %> Edition Of</span>
	    	</span>
	    	<span class="parent-of">
	    		<span>
	    			<a href="#/posts/<% data.id %>"><% data.title %></a>
	    		</span>
	    	</span>
	    </h4>
	</div>
	<div ng-if="mode!=='locale'">			
	    <h3 class="md-headline text-center form-create-header" ng-if="mode=='create'">
	    	Create your new post
	    </h3>
	    <h3 class="md-headline text-center form-create-header" ng-if="mode=='edit'">
	    	Edit your new post
	    </h3>
	</div> --}}

    <md-content layout-padding="16" class="transparent-content">
		<md-content class="box-shadow-content">
			<form layout-padding="16" name="createPostForm">
		      	<div layout layout-sm="column">
			        <md-input-container flex>
			          	<label>Title</label>
			          	<input ng-model="data.title" name="title" required>
			          	<div ng-messages="createPostForm.title.$error" 	
			          		 ng-show="createPostForm.title.$dirty && createPostForm.title.$invalid">
				          	<div ng-message="required">Post title is needed</div>
				        </div>
			        </md-input-container>	     
		      	</div>
		      	<div layout layout-sm="column">      	
					<md-input-container flex>
				        <md-select placeholder="Type" ng-model="data.type_id"
				        	ng-change="articleTypeChanged(data.type_id)"
				        	name="type" required
				        	ng-disabled="mode === 'locale' || lockedType"
				        	style="padding-bottom: 0px;">
							<md-option ng-repeat="type in types" value="<% type.id %>"><% type.display_name %></md-option>
						</md-select>       
			          	<div ng-messages="createPostForm.type.$error" 	
			          		 ng-show="createPostForm.type.$dirty && createPostForm.type.$invalid">
				          	<div ng-message="required">Post should have type</div>
				        </div>    
			        </md-input-container> 
		      		<md-input-container flex>
				        <md-select placeholder="Category" ng-model="data.category_id" ng-disabled="!data.type_id || mode === 'locale' || lockedCategory"
				        	style="padding-bottom: 0px;" name="category" required>
							<md-option ng-repeat="category in categories" value="<% category.id %>"><% category.display_name %></md-option>
						</md-select>    
			          	<div ng-messages="createPostForm.category.$error" 	
			          		 ng-show="createPostForm.category.$dirty && createPostForm.category.$invalid">
				          	<div ng-message="required">Post should have a category</div>
				        </div>
					</md-input-container>
		      	</div>

		      	<div layout="column">
			        <md-input-container class="custom-field-value" flex ng-repeat="field in customFields">

			        	<md-icon md-font-icon="icon-bin2" 
			        		ng-if="!field.not_removable"
			        		class="remove-field"
			        		ng-click="removeField(field, $index)"></md-icon>
			          	<label><% field.display_name %> <b style="color: #ccc;">(<% field.name %>)</b></label>
			          	{{-- <input ng-model="field.model" name="custom_<% field.name %>" required> --}}
		                <textarea ng-model="field.model" columns="1" name="custom_<% field.name %>"
		                	md-maxlength="500" ></textarea>  
			          	{{-- <div ng-messages="createPostForm['custom_' + field.name].$error" 	
			          		 ng-show="createPostForm['custom_' + field.name].$dirty && createPostForm['custom_' + field.name].$invalid">
				          	<div ng-message="required"><% field.display_name %> is needed</div>
				        </div> --}}
			        </md-input-container>	     
		      	</div>


		      	<!-- more custom field -->
		      	<div layout="column"  ng-if="mode == 'create'">
			        <div ng-repeat="field in categoryCustomFields">
			        	<!-- Specific for game type -->
			        	<div flex ng-if="field.type == 'array-game-type'">
			        		<div class="textarea-group" >
						        <label class="label-container">Game Platforms</label>
						    </div>
			        		<div class="chips-group" flex>
								<md-chips ng-model="select_gameTypes" 
									ng-change="itemGameTypeChange(field.model)"
									md-autocomplete-snap 
									md-require-match="true">
									<md-autocomplete
								          md-selected-item="selectedItem"
								          md-search-text="searchText"
								          md-items="item in querySearchGameType(searchText)"
								          md-search-text-change="itemGameTypeChange(field.model)"
								          md-item-text="item.name"
								          placeholder="Tag game platforms"
								          md-item-text="item.display_name">
								        <md-item-template>
									        <span>
									        	<% item.display_name %>
									        </span>
								       	</md-item-template>
								    </md-autocomplete>
									<md-chip-template >
										<strong><% $chip['display_name'] %></strong>
									</md-chip-template>
								</md-chips>
							</div>
			        	</div> 
			        	<div class="textarea-group" ng-if="field.type === 'editor'">	        		  		
				      		<label class="label-container"><% field.display_name %>:</label>
					      	<textarea name="post-editor"
					      		co-editor ng-model="field.model" rows="10" 
					      		cols="80">
					            Your text goes here!
					        </textarea>
			        	</div>
				        <div fclass="textarea-group" ng-if="field.type === 'text' || field.type === 'number'">	        		  	
				        	<md-input-container flex>
					      		<label class="label-container"><% field.display_name %>:</label>
					      		<input ng-model="field.model" name="<% field.name %>" type="<% field.type === 'text' %>">
				      		</md-input-container>
			        	</div>
			        	<div class="" ng-if="field.type === 'download-link-group'">
			        		<div class="textarea-group" >
						        <label class="label-container">Download Links</label>
						    </div>
					        <div class="" ng-repeat="(key, link) in field.model">				        	
						        <md-input-container flex  class="link-input-groups">
						          	<label>Link Type</label>
						          	<input ng-model="link.display_name" type="text">
						          	<md-button class="md-raised btn-add-link"
						          		type="button"
										ng-if="$index === field.model.length - 1"    
						      			ng-click="field.addDownloadType($event, field.model)">
						      			<md-icon md-font-icon="icon-plus"></md-icon>
						      		</md-button>
						          	<md-button class="md-raised md-warn btn-remove-link"
						          		type="button"   
										ng-if="$index != field.model.length - 1" 
						      			ng-click="field.removeDownloadType($event, link, field.model)">
						      			<md-icon md-font-icon="icon-minus"></md-icon>
						      		</md-button>
						        </md-input-container>
						        <div class="chips-group" flex style="padding-left: 50px;">
									<md-chips ng-model="link.links" 
										md-autocomplete-snap 
									    ng-change="itemDownloadLinkChange(key, link)"
										md-require-match="true">
										<md-autocomplete
									          md-selected-item="selectedItem"
									          md-search-text="searchText"
									          md-items="item in querySearchDownloadLink(searchText, key, link)"
									          md-search-text-change="itemDownloadLinkChange(key, link)"
									          placeholder="Add link"
									          md-item-text="item.display_name">
									        <md-item-template>
										        <span>
										        	<% item.display_name%>
										        </span>
									       	</md-item-template>
									    </md-autocomplete>
										<md-chip-template >
											<strong title="<% $chip %>"><% ($chip.display_name || $chip) | cut:true:70  %></strong>
										</md-chip-template>
									</md-chips>
								</div>
					        </div>	 
			        	</div>
			        </div>	     
		      	</div>

		        <div class="custom-field">
		        	<md-icon md-font-icon="icon-cancel-circle" 
		        		class="add-field" ng-class="{'selected': customFieldStatus.showControl}"
		        		ng-click="toggleControl()"></md-icon>
		        	<div class="custom-options">
		        		<span ng-show="!customFieldStatus.showControl"
		        			ng-click="toggleControl()">Other custom field here</span>
		        		<input type="text" class="field-name-holder" 
		        			ng-model="customFieldStatus.fieldName"
		        			ng-keydown="addCustomField($event)"
		        			placeholder="Type your field name and press Enter"
		        			ng-show="customFieldStatus.showControl"/>
		        	</div>
		        </div>

		      	<div class="textarea-group" ng-show="status['description']">      		
		      		<label class="label-container">Your text:</label>
			      	<textarea name="post-editor"
			      		co-editor
			      		id="post-editor" ng-model="data.description" rows="10" 
			      		cols="80">
			            Your text goes here!
			        </textarea>
		        </div>

		      	<div layout layout-sm="column">
			        <md-input-container flex>
			          	<label>Sequence Number</label>
			          	<input ng-model="data.seq_no" name="seqNumber" type="number">
			        </md-input-container>	     
		      	</div>

		        <section layout="row" layout-sm="column" 
		        	style="margin-top: 15px; margin-bottom: 15px;">
		        	<section layout="row" layout-sm="column" layout-align="start center" flex="50">
		        		<md-button class="md-raised md-primary" 
			      			ng-click="save($event)">Save</md-button>
			      		<md-button class="md-raised">Reset</md-button>	
		        	</section>
		        	<section layout="row" layout-sm="column" layout-align="end center" flex="50"
		        		ng-if="mode !== 'create'">
			      		<md-button class="md-raised" ng-click="choosePostLocale($event)">
			      			Edit Locale
			      		</md-button>	
		        	</section>
			      	
			    </section>
		    </form>
	    </md-content>
    </md-content>