<md-dialog aria-label="New Menu" id="dialog-new-menu">
    <form name="menuForm">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>View Message</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
            <md-content flex layout-padding>
   				<p>
   					<% data.description %>
   				</p>
   			</md-content>
   			<md-list>
	            <md-list-item class="md-2-line">
			        <md-icon md-font-icon="icon-user-tie"></md-icon>
			        <div class="md-list-item-text">
			          	<h3><% data.sender_name %></h3>
			          	<p>Name</p>
			        </div>
			    </md-list-item>
	            <md-list-item class="md-2-line">
			        <md-icon md-font-icon="icon-phone"></md-icon>
			        <div class="md-list-item-text">
			          	<h3><% data.sender_phone %></h3>
			          	<p>Phone</p>
			        </div>
			    </md-list-item>
	            <md-list-item class="md-2-line">
			        <md-icon md-font-icon="icon-mail3"></md-icon>
			        <div class="md-list-item-text">
			          	<h3><% data.sender_email %></h3>
			          	<p>Email</p>
			        </div>
			    </md-list-item>
		    </md-list>
        </md-dialog-content>
        <div class="md-actions" layout="row">
            <md-button type="button" ng-click="close()" class="md-primary">
                Close
            </md-button>
        </div>
    </form>
</md-dialog>