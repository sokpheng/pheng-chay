<md-dialog aria-label="New Album" id="dialog-new-album">
    <form name="albumForm">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Create album</h2>
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
                <div ng-messages="albumForm.display_name.$error"   
                     ng-show="albumForm.display_name.$dirty && albumForm.display_name.$invalid">
                    <div ng-message="required">Album name is required</div>
                </div>
            </md-input-container>

            <md-input-container flex>
                <label>Name</label>
                <input ng-model="data.name" name="name" required>
                <div ng-messages="albumForm.name.$error"   
                     ng-show="albumForm.name.$dirty && albumForm.name.$invalid">
                    <div ng-message="required">Name is required</div>
                </div>
            </md-input-container>

            <md-input-container flex>
                <label>Description</label>
                <textarea ng-model="data.description" columns="1" 
                md-maxlength="150"></textarea>
            </md-input-container>
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