<div id="page-create-post" ng-controller="AppCtrl">
	<md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
       {{--  <md-button class="md-icon-button" aria-label="Settings">
          <md-icon md-svg-icon="img/icons/menu.svg"></md-icon>
        </md-button> --}}
        <h2>
	        <span ng-if="mode!=='locale'">			
			    <span class="md-headline text-center form-create-header" ng-if="mode=='create'">
			    	Post news article
			    </span>
			    <span class="md-headline text-center form-create-header" ng-if="mode=='edit'">
			    	Edit news article
			    </span>
			</span>
          	<span ng-if="mode!=='locale'">Edit your new article's locale</span>

	    	<span class="parent-of before after">
	    		<span class="tag" ng-click="choosePostLocale($event)"><% locales[locale] %> Edition Of</span>
	    	</span>
	    	<span class="parent-of">
	    		<span>
	    			<a target="_blank" href="#/posts/<% data.parent.id %>"><% data.parent.title %></a>
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
	    			<a target="_blank" href="#/posts/<% data.parent.id %>"><% data.parent.title %></a>
	    		</span>
	    	</span>
	    </h4>
	</div>
	<div ng-if="mode!=='locale'">			
	    <h3 class="md-headline text-center form-create-header" ng-if="mode=='create'">
	    	Post news article
	    </h3>
	    <h3 class="md-headline text-center form-create-header" ng-if="mode=='edit'">
	    	Edit news article
	    </h3>
	</div> --}}
	<md-content class="box-shadow-content">
		<form layout-padding="16" name="createPostForm">
	      	<div layout layout-sm="column">
		        <md-input-container flex>
		          	<label>Title</label>
		          	<input ng-model="data.title" name="title" required>
		          	<div ng-messages="createPostForm.title.$error" 	
		          		 ng-show="createPostForm.title.$dirty && createPostForm.title.$invalid">
			          	<div ng-message="required">Title is needed</div>
			        </div>
		        </md-input-container>	     
	      	</div>

	      	<div layout layout-sm="column"> 
	      		<md-input-container flex>
			        <md-select placeholder="Category" ng-model="data.category_id" ng-readonly="!data.type_id || mode === 'locale'"
			        	style="padding-bottom: 0px;" name="category" required>
						<md-option ng-repeat="category in categories" value="<% category.id %>"><% category.display_name %></md-option>
					</md-select>    
		          	<div ng-messages="createPostForm.category.$error" 	
		          		 ng-show="createPostForm.category.$dirty && createPostForm.category.$invalid">
			          	<div ng-message="required">Article should have a category</div>
			        </div>
				</md-input-container>
	      	</div>

	      	<div layout layout-sm="column" ng-if="categoryName == 'collections'"> 
	      		<md-input-container flex>
			        <md-select placeholder="Collection" ng-model="data.collection_id" ng-disabled="!data.category_id"
			        	style="padding-bottom: 0px;" name="collection" required>
						<md-option ng-repeat="collection in collections" value="<% collection.id %>"><% collection.title %></md-option>
					</md-select>    
		          	<div ng-messages="createPostForm.category.$error" 	
		          		 ng-show="createPostForm.category.$dirty && createPostForm.collection.$invalid">
			          	<div ng-message="required">Article collection should select a collection</div>
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
	                <textarea ng-model="field.model" columns="1" name="custom_<% field.name %>"
	                	md-maxlength="500" ></textarea>  
		        </md-input-container>	     
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

	      	<!-- more custom field -->
	      	<div layout="column">
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
			      		<label class="label-container"><% field.display_name %>:</label>
			      		<input ng-model="field.model" name="<% field.name %>" type="<% field.type === 'text' %>">
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

	      	<div layout="column">

	      		<div class="chips-group" flex>
					<md-chips ng-model="select_tags" 
						ng-change="itemChange()"
						md-autocomplete-snap 
						md-require-match="true">
						<md-autocomplete
					          md-selected-item="selectedItem"
					          md-search-text="searchText"
					          md-items="item in querySearch(searchText)"
					          md-search-text-change="itemChange()"
					          md-item-text="item.name"
					          placeholder="Tag article"
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
		          	<label>Sequence Number</label>
		          	<input ng-model="data.seq_no" name="seqNumber" type="number">
		        </md-input-container>	     
	      	</div>

	      	<div ng-if="parentName == 'ArticleCtrl'" class="article-create">    		

		      	<section style="margin-top: 25px;">
		      		<label>Media Gallery</label>
		      	</section>

		      	<section layout="row" layout-sm="column" 
		      		class="media-gallery"
		      		style="margin-top: 15px; margin-bottom: 15px;">
		      		<div class="media" flex="33">
		      			<div class="logo-inner" layout="column" layout-align="center center">
			         		<span class="icon-camera"></span>
			         		<span class="upload-text">Upload gallery/Youtube link here</span>
			         		{{-- <span class="upload-text" ng-show="mode === 'create'">Please, save your listing first before upload</span> --}}
			         		<div class="overlay" ng-show="mode === 'edit'"></div>
			         	</div>
			         	<span class="icon-upload3"
			         		ng-class="{'center': mode === 'create'}"
			         		ngf-select ng-model="files" ngf-change="uploadMedia(files)" 
			         		multiple="false">
			         	</span>
			         	<span class="icon-youtube action" 
			         		ng-show="mode == 'edit'"
			         		ng-click="addYoutubeLink(files)" >
			         	</span>
		      		</div>
		      		{{-- Media --}}
		      		<div class="media uploaded" flex="33" ng-repeat="media in data.photos"
		      			ng-class="{'photo': media.storage_type == 'local', 'youtube': media.storage_type !== 'local'}">
		      			<div class="logo-inner" layout="column" 
		      				layout-align="center center"
		      				ng-if="media.storage_type == 'local'"
		      				style="background-image: url('<% mediaUrl ? mediaUrl + media.file_name : media.file_name %>')">
			         		<div class="overlay"></div>
			         		<div class="remove icon-cross" ng-click="deletePhoto(media)"></div>
			         		<div class="set-primary icon-heart" 
			         			ng-class="{'is-primary': media.is_primary}" 
			         			ng-click="setPrimary(media)"></div>
			         		<div class="set-poster icon-insert-template" 
			         			ng-class="{'is-poster': media.is_poster}" 
			         			ng-click="setPoster(media)"></div>
			         	</div>
			         	<div class="logo-inner" layout="column" 
		      				layout-align="center center"
		      				ng-if="media.storage_type !== 'local'"
		      				style="background-image: url('<% media.file_name ? 'https://img.youtube.com/vi/' + media.file_name + '/maxresdefault.jpg' : '' %>')">
			         		<div class="overlay"></div>
			         		<span class="icon-youtube" ></span>
			         		<div class="remove icon-cross" ng-click="deletePhoto(media)"></div>
			         		<div class="set-primary icon-heart" 
			         			ng-class="{'is-primary': media.is_primary}" 
			         			ng-click="setPrimary(media)"></div>
			         		<div class="set-best-video icon-video-camera" 
			         			ng-class="{'is-best-video': media.is_best_video}" 
			         			ng-click="setBestVideo(media)"></div>
			         		<div class="set-poster icon-blackboard" 
			         			ng-class="{'is-poster': media.is_poster}" 
			         			ng-click="setPoster(media)"></div>
			         	</div>
			         	<span class="icon-search" 
		      				ng-if="media.storage_type === 'local'"
			         		href="<% mediaUrl ? mediaUrl + media.file_name : media.file_name %>" data-title="<% data.name %>"></span>
			         	<span class="icon-search" 
		      				ng-if="media.storage_type !== 'local'"
			         		href="<% media.file_name ? 'https://www.youtube.com/watch?v=' + media.file_name : '' %>" data-title="<% data.title %>"></span>
		      		</div>
		      		{{-- Pending --}}
		      		<div class="media " flex="33" ng-repeat="media in pendingFiles">
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
	      	
	      	<p class="helper-block" ng-if="mode == 'edit'">
	      	    <b>Status:</b>
	      	    <span class="text" ng-show="data.status == 'published' || !data.status">Published: <% fromUtcDate(data.published_at || article.created_at) %></span>
				<span class="text" ng-show="data.status == 'draft'">Draft</span>
				<span class="text" ng-show="data.status == 'scheduled'">Scheduled to: <% formatUtcDate(data.scheduled_at) %></span>
	      	</p>

	        <section layout="row" layout-sm="column" 
	        	style="margin-top: 15px; margin-bottom: 15px;">
	        	<section layout="row" layout-sm="column" layout-align="start center" flex="50">
	        		<md-button class="md-raised" 
		      			ng-click="save($event)">
		      			Save
		      			<md-icon md-font-icon="icon-floppy-disk" style="margin-left: 5px"></md-icon>
		      		</md-button>
	        		<md-button class="md-raised md-primary"     
	        		    ng-if="data.status && data.status === 'draft'"
		      			ng-click="publish($event)">Publish
		      			<md-icon md-font-icon="icon-rocket" style="margin-left: 5px"></md-icon>
		      		</md-button>
		      		<md-button class="md-raised" 
	        		    ng-if="data.status && data.status === 'draft'"
		      			ng-click="schedule($event)">Schedule
		      			<md-icon md-font-icon="icon-history" style="margin-left: 5px"></md-icon>
		      		</md-button>
		      		<md-button class="md-raised" 
	        		    ng-if="data.status !== 'draft'"
		      			ng-click="draft($event)">Put to draft
		      			<md-icon md-font-icon="icon-history" style="margin-left: 5px"></md-icon>
		      		</md-button>
	        	</section>
	        	<section layout="row" layout-sm="column" layout-align="end center" flex="50">
		      		{{-- <md-button class="md-raised">Reset</md-button>	 --}}
		      		<md-button class="md-raised md-warn" ng-if="mode !== 'create'" ng-click="removeArticle($event)">Delete</md-button>	
		      		<md-button class="md-raised" ng-if="mode !== 'create'" ng-click="choosePostLocale($event)">
		      			Edit Locale
		      		</md-button>	
	        	</section>
		      	
		    </section>
	    </form>
    </md-content>
</div>