<md-dialog aria-label="New Product" id="dialog-new-product" class="dialog-custom-width">
    <form name="dialogFormCategory">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Create Product Type</h2>
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
	          	<div ng-messages="dialogFormCategory.display_name.$error" 	
	          		 ng-show="dialogFormCategory.display_name.$dirty && dialogFormCategory.display_name.$invalid">
		          	<div ng-message="required">Display Name is required</div>
		        </div>
            </md-input-container>
            <md-input-container flex>
                <label>Name</label>
                <input ng-model="data.name" name="name" required ng-disabled> 
            </md-input-container>
      		<md-input-container flex>
		        <md-select placeholder="Type" ng-model="data.parent_id" required
		        	ng-disabled="true"
		        	style="padding-bottom: 0px;" name="type">
		        	<md-option value="">
	        			Select a type
		        	</md-option>
					<md-option ng-repeat="type in types" value="<% type.id %>">
						<% type.display_name %>
					</md-option>
				</md-select>     
	          	<div ng-messages="dialogFormCategory.type.$error" 	
	          		 ng-show="dialogFormCategory.type.$dirty && dialogFormCategory.type.$invalid">
		          	<div ng-message="required">Category should have a type</div>
		        </div>
			</md-input-container>
            <md-input-container flex>
                <label>Sequence Number</label>
                <input ng-model="data.seq_number" name="seqNumber" type="text">
            </md-input-container>      
            <md-input-container flex>
                <label>Description</label>
                <textarea ng-model="data.description" columns="1" name="description"
                	md-maxlength="150"></textarea>   
            </md-input-container>
      		<md-input-container flex>
		        <md-select placeholder="Status" ng-model="data.status" required
		        	style="padding-bottom: 0px;" name="type">
		        	<md-option value="">
	        			Select a Status
		        	</md-option>
					<md-option value="inactive">
						Disabled
					</md-option>
					<md-option value="active">
						Active
					</md-option>
				</md-select>     
	          	<div ng-messages="dialogFormCategory.type.$error" 	
	          		 ng-show="dialogFormCategory.type.$dirty && dialogFormCategory.type.$invalid">
		          	<div ng-message="required">Category should have a type</div>
		        </div>
			</md-input-container>
        </md-dialog-content>
        <div class="md-actions">

			<div layout="row"  layout-align="space-between center" style="width: 100%">	

	            <md-button type="button" ng-disabled="!data.id"
	                ng-click="remove(data)" class="md-warn">Delete</md-button>   
	            <md-button ng-click="detail($event)" class="md-primary">
	                View Detail
	            </md-button>
	            <md-button ng-click="save($event)" class="md-primary">
	                Save
	            </md-button>
	            <md-button type="button" ng-click="close()" class="md-primary">
	                Cancel
	            </md-button>
			</div>
        </div>
    </form>
</md-dialog>