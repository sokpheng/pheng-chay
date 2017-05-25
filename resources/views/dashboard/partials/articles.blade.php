<section id="page-posts">
    <h3 class="md-headline text-center form-create-header">Articles listing</h3>
    <md-list>
        <md-content layout-padding="16">
        	<form name="userForm">
                <md-input-container flex>
                    <label>Search</label>
                    <input ng-model="search" ng-model-options="{ updateOn: 'default blur', debounce: { 'default': 500, 'blur': 0 } }">
                </md-input-container>
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
                    <tr ng-if="!posts.length">
                        <td colspan="3" class="empty-cell">
                        	There is no listing yet! Please, add one or more from the left menu</td>
                    </tr>
        			<tr ng-repeat="article in posts | filter: search | startFrom: (pagination.current) * pagination.limit | limitTo : pagination.limit ">
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
	        							<span class="text" ng-show="article.status == 'scheduled'">Scheduled to: <% article.scheduled_at %></span>
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
        </md-content>
    </md-list>
</section>