<section id="page-media">

    <md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
       {{--  <md-button class="md-icon-button" aria-label="Settings">
          <md-icon md-svg-icon="img/icons/menu.svg"></md-icon>
        </md-button> --}}
        <h2>
          <span>My Media</span>
        </h2>
        <span flex></span>
        <md-button class="md-icon-button" aria-label="Add Album"
            ng-click="showAdvanced($event)">
          <md-icon md-font-icon="icon-folder-plus"></md-icon>
        </md-button>
        <md-button class="md-icon-button" aria-label="Add Youtube"
            ng-click="addYoutubeLink(null, $event)">
          <md-icon md-font-icon="icon-youtube"></md-icon>
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
    </md-content>

   	
    <md-content layout-padding="16" class="transparent-content">
	    <md-list class="">
	        <md-content layout-padding="16" class="album-content box-shadow-content" layout layout-align="top center">
	        	<md-content ng-if="!media.length" >
	        		You have not uploaded any file yet!
	        	</md-content>
	        	<div ng-if="media.length" style="width: 100%;">
	        		<div ng-repeat="group in mediaGroups">
	        			<h6 class="md-subhead">
	        				<b>Album: </b>
	        				<%
	        					group ? (group.group ? (group.group.display_name || 'Others') : 'No') : 'Others'
	        				%>
	        			</h6>
			            <md-grid-list
					        md-cols-sm="1" md-cols-md="2" md-cols-gt-md="5"
					        md-row-height-gt-md="1:1" md-row-height="2:2"
					        md-gutter="12px" md-gutter-gt-sm="8px" >
						    <md-grid-tile class="green"
						    	style="background-image:url('<% item.storage_type == 'local' ?  mediaUrl + item.file_name : 'https://img.youtube.com/vi/' + item.file_name + '/0.jpg' %>')"
						    	ng-repeat="item in group.media"
						    	ng-click="editMedia(item)">
						      <md-grid-tile-footer>
						        	<h3>
						        		<% item.caption || 'No Caption' %>
						        		<span ng-show="item.is_home_image * 1" class="icon-star-full" style=" color: rgb(0,150,136);">
						        		</span>
						        	</h3>
						      </md-grid-tile-footer>
						    </md-grid-tile>
					  	</md-grid-list>
				  	</div>
	        	</div>
		  	</md-content>
	  		{{-- <md-fab-speed-dial md-open="demo.isOpen" md-direction="up"
	                         ng-class="demo.selectedMode">
		        <md-fab-trigger>
		          <md-button aria-label="menu" class="md-fab md-warn">
		            <md-icon md-font-icon="icon-plus"></md-icon>
		          </md-button>
		        </md-fab-trigger>
		        <md-fab-actions>
		          <md-button aria-label="album" ng-click="showAdvanced($event)" class="md-fab md-raised md-mini">
		            <md-icon md-font-icon="icon-folder"></md-icon>
		          </md-button>
		          <md-button aria-label="image" ng-click="uploadFile($event)" class="md-fab md-raised md-mini">
		            <md-icon md-font-icon="icon-image"></md-icon>
		          </md-button>
		        </md-fab-actions>
	      	</md-fab-speed-dial> --}}
	    </md-list>
    </md-content>
</section>