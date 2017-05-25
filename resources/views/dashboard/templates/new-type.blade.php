<md-dialog aria-label="New Type" id="dialog-new-type">
    <form name="dialogFormType">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Create Type</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
            <md-input-container flex>
                <label>Display Name</label>
                <input ng-model="data.display_name" name="display_name" required> 
	          	<div ng-messages="dialogFormType.display_name.$error" 	
	          		 ng-show="dialogFormType.display_name.$dirty && dialogFormType.display_name.$invalid">
		          	<div ng-message="required">Display Name is required</div>
		        </div>
            </md-input-container>
            <md-input-container flex>
                <label>Name</label>
                <input ng-model="data.name" name="name" required ng-disabled> 
            </md-input-container>            
            <md-input-container flex>
                <label>Sequence Number</label>
                <input ng-model="data.seq_number" name="seqNumber" type="number">
            </md-input-container>      
            <md-input-container flex>
                <label>Description</label>
                <textarea ng-model="data.description" columns="1" name="description"
                	md-maxlength="150"></textarea>   
            </md-input-container>
        </md-dialog-content>
        <div class="md-actions" layout="row">
            <md-button ng-click="save($event)" class="md-primary">
                Save
            </md-button>
            <md-button type="button" ng-click="close()" class="md-primary">
                Cancel
            </md-button>
        </div>
    </form>
</md-dialog>