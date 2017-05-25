<section id="page-page">
    <h3 class="md-headline">My pages</h3>
    <md-list>
        <md-content layout-padding="16">
            <form name="userForm">
                <md-input-container flex>
                    <label>Search</label>
                    <input ng-model="search">
                </md-input-container>
            </form>
            <md-content ng-show="!pages.length" layout="row" layout-align="center">
            	<p>
            		There is no pages yet
            	</p>
            </md-content>
            <md-list-item class="md-3-line" 
            	ng-show="pages.length"
                ng-repeat="(i, item) in pages | filter: search | orderBy:'-info.created_at'">
                <div class="md-list-item-text">
                    <h3>
                        <% item.info.title %>
                    </h3>
                    <h4>
                    	<span class="icon-folder"></span>
                        <span style="font-size: 11px; color: gray;"><%listData.meta.themePath + 'pages/' + item.name %></span>
                        <br/>
                        <span class="icon-file-text"></span>
                        <% item.info.description %>         
                        <br/>          	
                    </h4>
                    <p>                        
                        <span ng-if="item.info.updated_at">
                            Edited: <% formatDate(item.info.updated_at) %>, 
                        </span>
                        <% formatDate(item.info.created_at) %>
                    </p>

                    <md-menu class="md-menu-list-item">
                        <md-button aria-label="Open phone interactions menu" class="md-icon-button" ng-click="$mdOpenMenu()">
                            <md-icon md-menu-origin md-font-icon="icon-wrench"></md-icon>
                        </md-button>
                        <md-menu-content width="4">
                            <md-menu-item>
                              <md-button ng-click="edit(item, $event)">
                                <md-icon md-font-icon="icon-quill" md-menu-align-target></md-icon>
                                Edit
                              </md-button>
                            </md-menu-item>
                            <md-menu-item>
                              <md-button disabled="disabled" ng-click="ctrl.checkVoicemail()">
                                <md-icon md-font-icon="icon-cross"></md-icon>
                                Delete
                              </md-button>
                            </md-menu-item>
                            <md-menu-divider></md-menu-divider>
                            <md-menu-item>
                              <md-button ng-click="ctrl.toggleNotifications()">
                                <md-icon md-font-icon="icon-notification"></md-icon>Notifications
                              </md-button>
                            </md-menu-item>
                        </md-menu-content>
                    </md-menu>
                    <md-divider ng-if="i !== posts.length - 1"></md-divider>
                </div>
            </md-list-item>
        </md-content>

  		<md-fab-speed-dial md-open="false" md-direction="up">
	        <md-fab-trigger>
	          <md-button aria-label="menu" class="md-fab md-warn">
	            <md-icon md-font-icon="icon-plus"></md-icon>
	          </md-button>
	        </md-fab-trigger>
	        <md-fab-actions>
	          <md-button aria-label="album" 
	          		ng-click="createPage($event)" 
	          		class="md-fab md-raised md-mini">
	            <md-icon md-font-icon="icon-file-empty"></md-icon>
	          </md-button>
	        </md-fab-actions>
      	</md-fab-speed-dial>

        <ul class="md-pagination">
            <li ng-repeat="offset in pagination.total">
                <md-button ng-class="{'md-primary': offset - 1 == pagination.offset}"
                    ng-click="changeOffset(offset - 1)"><% offset %></md-button>
        </ul>
    </md-list>
</section>