<section id="page-posts">

    <md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
       {{--  <md-button class="md-icon-button" aria-label="Settings">
          <md-icon md-svg-icon="img/icons/menu.svg"></md-icon>
        </md-button> --}}
        <h2>
          <span>My Files</span>
        </h2>
        <span flex></span>
        <md-button class="md-icon-button" aria-label="Add Album"
            ng-click="showAdvanced($event)">
          <md-icon md-font-icon="icon-folder-plus"></md-icon>
        </md-button>
        <md-button class="md-icon-button" aria-label="Add"
            ng-click="uploadFile($event)">
          <md-icon md-font-icon="icon-plus"></md-icon>
        </md-button>
      </div>
    </md-toolbar>

    <md-content layout-padding="16" class="transparent-content">
        <md-content layout-padding="16" class="box-shadow-content">        
            <form name="userForm">
            	<div layout layout-sm="column">
	                <md-input-container flex="66">
	                    <label>Search</label>
	                    <input ng-model="search">
	                </md-input-container>

			        <md-select flex="33" placeholder="Album" ng-model="data.album">
			        	<md-option value="">
			        		Select an album
			        	</md-option>
						<md-option ng-repeat="type in albums" value="<% type.id %>"><% type.display_name %></md-option>
					</md-select>
				</div>
            </form>
        </md-content>


        <md-list class="box-shadow-content" style="margin-top: 15px">

            <md-list-item class="md-3-line">
                <div class="md-list-item-text">
                    <div layout="row">
                        <div flex="5"  class="head">
                            No
                        </div>
                        <div flex="35"  class="head">
                            File Name
                        </div>
                        <div flex="15"  class="head">
                            Album
                        </div>
                        <div flex="35"  class="head">
                            Link
                        </div>
                        <div flex="10" class="head">
                            Edited
                        </div>
                    </div>
                </div>        
            </md-list-item>
        </md-list>

        <md-list class="box-shadow-content" style="margin-top: 15px">
            
            <md-list-item class="md-3-line" 
                ng-if="!files.length">
                <div class="md-list-item-text">
                    <h4 class="text-center">
                        There is no listing yet! Please, add one or more from the left menu
                    </h4>
                </div>
            </md-list-item>

            <md-list-item class="md-3-line hoverable" 
                ng-repeat="(i, item) in files | filter: search | startFrom: pagination.offset * pagination.limit | limitTo : pagination.limit ">
                <div class="md-list-item-text" ng-click="editMedia(item, $event)">
                    <div layout="row">
                        <div flex="57" class="col">
                            <% pagination.offset * pagination.limit  + $index + 1 %>
                        </div>
                        <div flex="35" class="col">
                            <% item.caption %>
                        </div>
                        <div flex="15" class="col">
                            <% item.album.display_name %>
                        </div>
                        <div flex="35" class="col">

                            <span ng-init="link = mediaUrl + item.file_name" ng-bind-html="(link || '' | limitTo: 1000) + (link.length > 1000 ? '...' : '')"></span>
                        </div>
                        <div flex="10" class="col">
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