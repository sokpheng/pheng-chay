<md-dialog aria-label="New Album" id="dialog-new-page">
    <form>
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Create page</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
            <md-input-container flex>
                <label>Name</label>
                <input ng-model="data.title">
            </md-input-container>
            <md-input-container flex>
                <label>Link <% data.title ? '(' + urlify() + ')' : '' %></label>
                <input ng-model="data.link">
            </md-input-container>
      		<md-input-container flex>
		        <md-select placeholder="Layout" ng-model="data.layout"
		        	style="padding-bottom: 0px;" name="layout">
		        	<md-option value="">
	        			Select a layout
		        	</md-option>
					<md-option ng-repeat="layout in layouts" value="<% layout.name %>">
						<% layout.info.name %>
					</md-option>
				</md-select>    
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