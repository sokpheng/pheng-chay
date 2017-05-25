<section id="page-categories" class="data-content">

    <md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
        <h2>
          <span>Manage Post Categories</span>
        </h2>
        <span flex></span>
        <md-button class="md-icon-button" aria-label="Add Type"
            ng-click="createType($event)">
          <md-icon md-font-icon="icon-folder-plus"></md-icon>
        </md-button>
        <md-button class="md-icon-button" aria-label="Add"
            ng-click="createPage($event)">
          <md-icon md-font-icon="icon-plus"></md-icon>
        </md-button>
      </div>
    </md-toolbar>


    <md-content layout-padding="16" class="transparent-content">
        <md-content layout-padding="16" class="box-shadow-content">

	        <form name="userForm">
	            <md-input-container flex>
	                <label>Search</label>
	                <input ng-model="search">
	            </md-input-container>
	        </form>
        </md-content>

        <md-list class="box-shadow-content" style="margin-top: 15px">

            <md-list-item class="md-3-line">
                <div class="md-list-item-text">
                    <div layout="row">
                        <div flex="7"  class="head">
                            No
                        </div>
                        <div flex="20"  class="head">
                            Display Name
                        </div>
                        <div flex="12"  class="head">
                            Name
                        </div>
                        <div flex="25"  class="head">
                            Description
                        </div>
                        <div flex="12" class="head">Locale</div>
                        <div flex="12" class="head">Type</div>
                        <div flex="12" class="head">
                            Edited
                        </div>
                    </div>
                </div>        
            </md-list-item>
        </md-list>

        <md-list class="box-shadow-content" style="margin-top: 15px">
            
            <md-list-item class="md-3-line" 
                ng-if="!categories.length">
                <div class="md-list-item-text">
                    <h4 class="text-center">
                        There is no listing yet! Please, add one or more from the left menu
                    </h4>
                </div>
            </md-list-item>

            <md-list-item class="md-3-line hoverable" 
                ng-repeat="(i, item) in categories | filter: search | startFrom: pagination.offset * pagination.limit | limitTo : pagination.limit ">
                <div class="md-list-item-text" ng-click="editCategory(item, $event)">
                    <div layout="row">
                        <div flex="7" class="col">
                            <% pagination.offset * pagination.limit  + $index + 1 %>
                        </div>
                        <div flex="20" class="col">
                            <% item.display_name %>
                        </div>
                        <div flex="12" class="col">
                            <% item.name %>
                        </div>
                        <div flex="25" class="col">
                            <span ng-bind-html="(item.description | limitTo: 1000) + (item.description.length > 1000 ? '...' : '')"></span>
                        </div>
                        <div flex="12" class="col">                        	
                        	<span ng-click="editLocalization(item, $event)" 
								ng-class="{'active': item.locale && item.locale.length}"
								class="extra-option">...</span>
                        </div>
                        <div flex="12" class="col"><% item.type.display_name %></div>
                        <div flex="12" class="col">
                            <span>
                                <% fromDate(item.updated_at) %>
                            </span>
                        </div>
                    </div>
                </div>
            </md-list-item>
        </md-list>
        <md-content layout-padding="16" 
            ng-show="pagination.total.length"
            class="box-shadow-content" style="margin-top: 15px;">            
            <ul class="md-pagination">
                <li ng-repeat="offset in pagination.total">
                    <md-button class="md-raised" 
                        ng-class="{'md-primary': offset - 1 == pagination.offset}"
                        ng-click="changeOffset(offset - 1)"><% offset %></md-button>
            </ul>
        </md-content>    
    </md-content>

</section>