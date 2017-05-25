<md-dialog aria-label="New Update Slider" id="dialog-slider-album">
    <form name="albumForm">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Update slider</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
        	<div  layout-gt-xs="column" style="width: 400px;">
	            <md-input-container flex>
	                <label>Refer Link Name</label>
	                <input ng-model="data.refer_link" name="refer_link"> 
	            </md-input-container>

	            <md-input-container flex>
	                <label>Order</label>
	                <input ng-model="data.priority" name="priority" required>
	            </md-input-container>
            </div>
        </md-dialog-content>
        <div class="md-actions" layout="row">
            <md-button ng-click="save()" class="md-primary">
                Save
            </md-button>
            <md-button type="button" ng-click="close()" class="md-primary">
                Cancel
            </md-button>
        </div>
    </form>
</md-dialog>