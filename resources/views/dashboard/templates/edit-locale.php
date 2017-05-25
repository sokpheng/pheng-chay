<md-dialog aria-label="Edit item localization" id="dialog-edit-item-locale">
    <form name="dialogFormLocale">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Edit item localization</h2>
                <span flex></span>
                <md-button class="md-icon-button" ng-click="close()" type="button">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog">
                    </md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
        	<md-content layout layout-sm="column">
	            <md-input-container flex="66">
	                <label>Text</label>
	                <input ng-model="data.text" name="text" required> 
		          	<div ng-messages="dialogFormLocale.text.$error" 	
		          		 ng-show="dialogFormLocale.text.$dirty && dialogFormLocale.text.$invalid">
			          	<div ng-message="required">Text is required</div>
			        </div>
	            </md-input-container>
	      		<md-input-container flex="33">
			        <md-select placeholder="Type" ng-model="data.language" required
			        	style="padding-bottom: 0px;" name="language">
			        	<md-option value="">
		        			Select a language
			        	</md-option>
						<md-option ng-repeat="language in languages" value="<% language.value %>">
							<% language.text %>
						</md-option>
					</md-select>     
		          	<div ng-messages="dialogFormLocale.language.$error" 	
		          		 ng-show="dialogFormLocale.language.$dirty && dialogFormLocale.language.$invalid">
			          	<div ng-message="required">Language is requred</div>
			        </div>
				</md-input-container>
			</md-content>

			<md-content layout>
				<div class="md-cus-table">
					<table>
						<thead>
							<tr>
								<th class="text-center" style="width: 6.66%"></th>
								<th style="width: 60%">Text</th>
								<th style="width: 33.33%">Language</th>
							</tr>
						</thead>	
						<tbody>
							<tr ng-repeat="item in locale">	
								<td class="text-center">
							        <md-checkbox
							            ng-model="item.remove"
							            aria-label="Remove item"
							            ng-true-value="true"
							            ng-false-value="false"
							            class="md-warn">
							        </md-checkbox>
								</td>	
								<td>
									<% item.text %>
								</td>
								<td>
									<% item.language %>
								</td>
							</tr>
							<tr ng-if="!locale.length">
								<td colspan="3">
									No locale data
								</td>
							</tr>
						</tbody>
					</table>
					<br/>
					<div>							
			        	<md-button 
			        		ng-click="addLocale($event)" 
			        		class="md-raised">Add</md-button>
			        	<md-button 
			        		type="button"
			        		ng-click="removeLocale($event)" 
			        		class="md-raised md-warn">Remove</md-button>
					</div>
				</div>	
			</md-content>
        </md-dialog-content>
        <div class="md-actions" layout="row">
            <md-button ng-click="close()" type="button" class="md-primary">
                Cancel
            </md-button>
        </div>
    </form>
</md-dialog>