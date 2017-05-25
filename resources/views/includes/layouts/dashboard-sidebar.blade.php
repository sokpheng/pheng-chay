<md-sidenav class="md-sidenav-left md-whiteframe-z2" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')">
    <md-toolbar class="md-theme-indigo">
        <h1 class="md-toolbar-tools">Content System</h1>
    </md-toolbar>
    <md-content layout-padding ng-controller="LeftCtrl" class="co-sidebar-wrapper">
        <md-button ng-click="close()" class="md-primary" hide-gt-md>
          Close Sidebar
        </md-button>
        <!-- <p hide-md show-gt-md>
        	Access one of the below features to start your editing website. You can manage post, menu, category, user access as well as your site information.
        </p> -->

        <div class="co-sidebar-group" ng-repeat="(i, menu) in menus">
	        	
	        <md-subheader class="md-no-sticky co-menu-subheader">
	        	<% menu.text %>
	        </md-subheader>
			<md-list-item 
				ng-click="!item.event ? navigateTo(item.path, $event) : item.event(this)" 
				ng-repeat="item in menu.items">
				<md-icon md-font-icon="<% item.icon %>"></md-icon>
			    <p> <% item.name %> <span ng-if="item.name == 'Message' && stats.message">(<% stats.message %>)</span> </p>
			</md-list-item>
			<div ng-if="i !== menus.length - 1">
				<md-divider></md-divider>
			</div>
        </div>
    </md-content>
</md-sidenav>