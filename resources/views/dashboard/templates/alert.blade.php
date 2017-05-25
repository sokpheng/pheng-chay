<md-dialog aria-label="New Album" id="alert-dialog">
    <form name="alertDialogForm" ng-submit="close($event)" style="overflow: hidden" >
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Alert Dialog</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
        	<p><% data.message %></p>

			
        </md-dialog-content>
        <div class="md-actions">
			<div layout="row" 
				layout-align="center center" style="width: 100%">	
		            <md-button type="button" ng-click="close()" class="md-primary">
		                Close
		            </md-button>		
			</div>
        </div>
    </form>
</md-dialog>