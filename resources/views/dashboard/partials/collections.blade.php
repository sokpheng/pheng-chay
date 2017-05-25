<section id="page-posts">
    <h3 class="md-headline text-center form-create-header">Collection listing</h3>
    <md-list>
        <md-content layout-padding="16">
        	<form name="userForm">
	        	<div layout="row" layout-wrap>
	        		<div flex="80">
		                <md-input-container >
		                    <label>Search</label>
		                    <input ng-model="search" ng-model-options="{ updateOn: 'default blur', debounce: { 'default': 500, 'blur': 0 } }">
		                </md-input-container>
	                </div>
	                <div flex="20">
	                	<md-button class="md-raised"
	                		style="width: 100%"
			      			ng-click="create($event)">
			      			Create New
			      			<md-icon md-font-icon="icon-book" style="margin-left: 5px; "></md-icon>
			      		</md-button>
	                </div>
                </div>
            </form>
        	<table class="directory-listing table-grid" style="table-layout: fixed;">
        		<thead>
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
        		</thead>
        		<tbody>
                    <tr ng-if="!collections.length">
                        <td colspan="3" class="empty-cell">
                        	There is no listing yet! Please, add one or more from the left menu</td>
                    </tr>
        			<tr ng-repeat="collection in collections | filter: search | startFrom: (pagination.current) * pagination.limit | limitTo : pagination.limit ">
        				<td class="col-info" style="width: 390px;">
        					{{-- <div class="directory-image" 
        						ng-if="collection.photos.length"
        						style="background-image: url('<% (collection.pimary_media || article.photos[0]).storage_type == 'local' ?  mediaUrl + (article.pimary_media || article.photos[0]).file_name : 'https://img.youtube.com/vi/' + (article.pimary_media || article.photos[0]).file_name + '/maxresdefault.jpg' %>')">
                            </div> --}}
        					<div class="directory-basic-info no-image-left" >
        						<div class="name"><% collection.title %></div>
        						<div style="margin-top: 10px;">
        							<span class="tag">
        								<span class="icon-book"></span> 
                                        <% collection.articles.length %> Articles 
        							</span>
        						</div>
        					</div>
        				</td>
        				<td class="col-info">
        					<div class="directory-desc-info">
        						<p class="desc" ng-bind-html="collection.description" style="max-height: 100px; overflow: hidden">
	        					</p>
	        					<ul class="contact-info">
                                    <li>
                                        <span class="icon">
                                            <span class="icon-location"></span>
                                        </span>
                                        <span class="text"><% collection.created_at %></span>
	        						<li>
	        							<span class="icon">
	        								<span class="icon-link"></span>
	        							</span>
	        							<span class="text"><a target="_blank" href="<% collection.url %>"><% collection.url || ('https://www.flexitech.io/news/collections/' + collection.hash) %></a></span>
	        						<li>
	        							<span class="icon">
	        								<span class="icon-rocket"></span>
	        							</span>
	        							<span class="text" ng-show="collection.status == 'published' || !collection.status">Published at: <% collection.published_at || collection.created_at %></span>
	        							<span class="text" ng-show="collection.status == 'draft'">Draft</span>
	        							<span class="text" ng-show="collection.status == 'scheduled'">Scheduled to: <% collection.scheduled_at %></span>
	        					</ul>
        					</div>

        					<div class="edit-action" ng-click="edit(collection)">
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
        </md-content>
    </md-list>
</section>