<div id="page-create-post" fng-controller="AppCtrl">

	<div ng-if="mode!=='locale'">			
	    <h3 class="md-headline text-center form-create-header" ng-if="mode=='create'">
	    	Post new Collection
	    </h3>
	    <h3 class="md-headline text-center form-create-header" ng-if="mode=='edit'">
	    	Edit collection
	    </h3>
	</div>
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
      	{{-- <div layout layout-sm="column"> 
      		<md-input-container flex>
		        <md-select placeholder="Category" ng-model="data.category_id" ng-disabled="!data.type_id || mode === 'locale'"
		        	style="padding-bottom: 0px;" name="category" required>
					<md-option ng-repeat="category in categories" value="<% category.id %>"><% category.display_name %></md-option>
				</md-select>    
	          	<div ng-messages="createPostForm.category.$error" 	
	          		 ng-show="createPostForm.category.$dirty && createPostForm.category.$invalid">
		          	<div ng-message="required">Article should have a category</div>
		        </div>
			</md-input-container>
      	</div> --}}

      	<div class="textarea-group" ng-show="status['description']">      		
      		<label class="label-container">Your text:</label>
	      	<textarea name="post-editor"
	      		co-editor
	      		id="post-editor" ng-model="data.description" rows="10" 
	      		cols="80">
	            Your text goes here!
	        </textarea>
        </div>
      	
      	<p class="helper-block" ng-if="mode == 'edit'">
      	    <b>Status:</b>
      	    <span class="text" ng-show="data.status == 'published' || !data.status">Published: <% fromUtcDate(data.published_at || article.created_at) %></span>
			<span class="text" ng-show="data.status == 'draft'">Draft</span>
			<span class="text" ng-show="data.status == 'scheduled'">Scheduled to: <% formatUtcDate(data.scheduled_at) %></span>
      	</p>

	    <p class="helper-block" style="margin-bottom: 0px; margin-top: 30px;">Articles in collections</p>

	    <md-list ng-if="mode == 'edit' && data.articles.length">
	        <md-content >
        	{{-- <form name="userForm" layout-padding="16"> --}}
                <md-input-container flex>
                    <label>Search</label>
                    <input ng-model="search" ng-model-options="{ updateOn: 'default blur', debounce: { 'default': 500, 'blur': 0 } }">
                </md-input-container>
	        	<table class="directory-listing table-grid" style="table-layout: fixed;">
	        		{{-- <thead>
	        			<tr>
	        				<td class="col-head" style="width: 40%">
	        					Name
	        					<span class="sort"
	                                ng-click="changeSort()"
	                                ng-class="{'icon-sort-alpha-asc sorted': sort === 'asc', 
	                                    'icon-sort-alpha-desc sorted': sort === 'desc', 
	                                    'icon-text-height': sort === ''
	                                }">               
	                            </span>
	        				</td>
	        				<td class="col-head" colspan="1">Description</td>
	        			</tr>
	        		</thead> --}}
	        		<tbody>
	                    <tr ng-if="!data.articles.length">
	                        <td colspan="3" class="empty-cell">
	                        	There is no listing yet! Please, add one or more from the left menu</td>
	                    </tr>
	        			<tr ng-repeat="article in data.articles | filter: search | startFrom: (pagination.current) * pagination.limit | limitTo : pagination.limit ">
	        				<td class="col-info" style="width: 390px;">
	        					<div class="directory-image" 
	        						ng-if="article.photos.length"
	        						style="background-image: url('<% (article.pimary_media || article.photos[0]).storage_type == 'local' ?  mediaUrl + (article.pimary_media || article.photos[0]).file_name : 'https://img.youtube.com/vi/' + (article.pimary_media || article.photos[0]).file_name + '/maxresdefault.jpg' %>')">
	                            </div>
	        					<div class="directory-basic-info" 
	        						ng-class="{'no-image-left': !article.photos.length}">
	        						<div class="name"><% article.title %></div>
	        						<div style="margin-top: 10px;">
	        							<span class="tag">
	        								<span class="icon-folder"></span> 
	                                        <% article.category.display_name %>
	        							</span>

	                                    <span class="tag tag-success tag-square" ng-repeat="tag in article.tags">
	                                        <span class="icon-price-tag"></span> 
	                                        <% tag.display_name %>
	                                    </span>
	        						</div>
	        						<ul class="mini-gallery-list">
	        							<li class="gallery-item" 
	                                        ng-class="{'photo': item.storage_type == 'local', 'youtube': item.storage_type !== 'local'}"
	                                        href="<% item.storage_type == 'local' ?  mediaUrl + item.file_name : 'https://www.youtube.com/watch?v=' + item.file_name %>"
	        								ng-repeat="item in article.photos | limitTo : 4"
	        								style="background-image: url('<% item.storage_type == 'local' ?  mediaUrl + item.file_name : 'https://img.youtube.com/vi/' + item.file_name + '/maxresdefault.jpg' %>')">
	                                        <div layout="column" 
	                                            layout-align="center center">
	                                            <span class="icon-youtube" ng-show="item.storage_type !== 'local'"></span>
	                                        </div>
	        						</ul>
	        					</div>
	        				</td>
	        				<td class="col-info">
	        					<div class="directory-desc-info">
	        						<p class="desc" ng-bind-html="article.description" style="max-height: 100px; overflow: hidden">
		        					</p>
		        					<ul class="contact-info">
	                                    <li>
	                                        <span class="icon">
	                                            <span class="icon-location"></span>
	                                        </span>
	                                        <span class="text"><% formatUtcDate(article.created_at) %></span>
		        						<li>
		        							<span class="icon">
		        								<span class="icon-link"></span>
		        							</span>
		        							<span class="text"><a target="_blank" href="<% article.url %>"><% article.url %></a></span>
		        						<li>
		        							<span class="icon">
		        								<span class="icon-rocket"></span>
		        							</span>
		        							<span class="text" ng-show="article.status == 'published' || !article.status">Published at: <% formatUtcDate(article.published_at || article.created_at) %></span>
		        							<span class="text" ng-show="article.status == 'draft'">Draft</span>
		        							<span class="text" ng-show="article.status == 'scheduled'">Scheduled to: <% formatUtcDate(article.scheduled_at) %></span>
		        					</ul>
	        					</div>

	        					<div class="edit-action" ng-click="edit(article)">
	        						<span class="icon-search" ></span>
	        					</div>
	        					
	        				</td>
	        			</tr>
	        		</tbody>
	        	</table>
		        <ul class="md-pagination">
		            <li ng-repeat="offset in pagination.total">
		                <md-button ng-click="changeOffset(offset - 1)" ng-class="{'md-primary': offset - 1 == pagination.current}"><% offset %></md-button>
		        </ul>
            {{-- </form> --}}
	        </md-content>
	    </md-list>

        <section layout="row" layout-sm="column" 
        	style="margin-top: 15px; margin-bottom: 15px;">
        	<section layout="row" layout-sm="column" layout-align="start center" flex="50">
        		<md-button class="md-raised" 
	      			ng-click="save($event)">
	      			Save
	      			<md-icon md-font-icon="icon-floppy-disk" style="margin-left: 5px"></md-icon>
	      		</md-button>
        		{{-- <md-button class="md-raised md-primary"     
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
	      		</md-button> --}}
        	</section>
        	<section layout="row" layout-sm="column" layout-align="end center" flex="50">
	      		{{-- <md-button class="md-raised">Reset</md-button>	 --}}
	      		<md-button class="md-raised md-warn" ng-if="mode !== 'create'" ng-click="remove($event)">Delete</md-button>	
	      		{{-- <md-button class="md-raised" ng-if="mode !== 'create'" ng-click="choosePostLocale($event)">
	      			Edit Locale
	      		</md-button>	 --}}
        	</section>
	      	
	    </section>
    </form>
  	<!-- view articles -->
  	{{-- <h3 class="md-headline text-center form-create-header" ng-if="mode == 'edit' && data.articles.length">Articles listing</h3> --}}
    
</div>