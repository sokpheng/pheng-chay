<md-dialog aria-label="New Menu" id="dialog-new-menu">
    <form name="menuForm">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Create menu</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
            <md-input-container flex>
                <label>Display Name</label>
                <input ng-model="data.display_name" required>                
                <div ng-messages="menuForm.display_name.$error"   
                     ng-show="menuForm.display_name.$dirty && menuForm.display_name.$invalid">
                    <div ng-message="required">Display Name is required</div>
                </div>
            </md-input-container>

            <md-input-container flex>
                <label>Description</label>
                <textarea ng-model="data.description" 
                	columns="1" 
                	md-maxlength="150">
                </textarea>
            </md-input-container>

            <md-input-container flex>
                <md-select placeholder="Uri" ng-model="data.name"
                    style="padding-bottom: 0px;" name="link">
                    <md-option value="">
                        Select a page to link to
                    </md-option>
                    <md-option ng-repeat="page in pages" 
                        value="<% page.info.link || '#' %>">
                        <% (page.info.title) + ' - /' + (page.info.link || '#') + '' %>
                    </md-option>
                </md-select>    
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