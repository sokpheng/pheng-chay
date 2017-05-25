<section id="page-posts">
    <h3 class="md-headline text-center form-create-header">Enterprise listing</h3>
    <md-list>
        <md-content layout-padding="16">
        	<form name="userForm">
                <md-input-container flex>
                    <label>Search</label>
                    <input ng-model="search" ng-model-options="{ updateOn: 'default blur', debounce: { 'default': 500, 'blur': 0 } }">
                </md-input-container>
            </form>
        	<table class="directory-listing table-grid">
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
        				<td class="col-head" colspan="2">Description</td>
        			</tr>
        		</thead>
        		<tbody>
                    <tr ng-if="!directories.length">
                        <td colspan="3" class="empty-cell">There is no listing yet! Please, add one or more from the left menu</td>
                    </tr>
        			<tr ng-repeat="directory in directories | startFrom: (pagination.current - 1) * pagination.limit | limitTo : pagination.limit ">
        				<td class="col-info" style="width: 390px;">
        					<div class="directory-image" style="background-image: url('<% mediaUrl + directory.logo.file_name %>')"></div>
        					<div class="directory-basic-info">
        						<div class="name"><% directory.name %></div>
        						<div>
        							<span class="tag" ng-repeat="category in directory.categories">
        								<span class="icon-price-tag"></span> 
                                        <% category.display_name %>
        							</span>
        						</div>
        						<ul class="mini-gallery-list">
        							<li class="gallery-item" 
                                        href="<% mediaUrl + item.file_name %>"
        								ng-repeat="item in directory.photos | limitTo : 4"
        								style="background-image: url('<% mediaUrl + item.file_name %>')">
        						</ul>
        					</div>
        				</td>
        				<td class="col-info">
        					<div class="directory-desc-info">
        						<p class="desc">
	        						<% directory.description %>
	        					</p>
	        					<ul class="contact-info">
	        						<li>
	        							<span class="icon">
	        								<span class="icon-location"></span>
	        							</span>
	        							<span class="text"><% directory.address %></span>
	        						<li>
	        							<span class="icon">
	        								<span class="icon-mobile2"></span>
	        							</span>
	        							<span class="text"><% directory.phones %></span>
	        						<li>
	        							<span class="icon">
	        								<span class="icon-envelop"></span>
	        							</span>
	        							<span class="text"><% directory.emails %></span>
	        						<li>
	        							<span class="icon">
	        								<span class="icon-earth"></span>
	        							</span>
	        							<span class="text"><% directory.websites %></span>
	        					</ul>
        					</div>
        					
        				</td>
        				<td class="col-info">
        					<div class="directory-static-map">
        						<img src="<% getMapUrl(directory) %>">
        					</div>

        					<div class="edit-action">
        						<span class="icon-search" ng-click="view(directory)"></span>
        					</div>
        				</td>
        			</tr>
        		</tbody>
        	</table>
	        <ul class="md-pagination">
	            <li ng-repeat="offset in pagination.total">
	                <md-button ng-click="changePage(offset)" ng-class="{'md-primary': offset - 1 == pagination.offset}"><% offset %></md-button>
	        </ul>
        </md-content>
    </md-list>
</section>