<md-dialog aria-label="Schedule Article Post" id="dialog-new-media">
    <form name="scheduleArticle" ng-submit="schedule($event)" >
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Schedule Article Post</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
	        <md-input-container flex>
	            <div>
	                <label>Date</label>
	            </div>
    	        <div id="datepicker" data-date="<% data.start_date %>" ></div>
                <input type="hidden" ng-model="data.scheduled_at" id="my_hidden_input" />
	        </md-input-container>
            <md-input-container flex>
	            <label>Time</label>
	            <input ng-model="data.time" name="time" required type="text">    
	            <div ng-messages="scheduleArticle.time.$error"   
	                 ng-show="scheduleArticle.time.$dirty && scheduleArticle.time.$invalid">
	                <div ng-message="required">Time is required</div>
	            </div>
	        </md-input-container>
            
        </md-dialog-content>
        <div class="md-actions" layout="row">
            <md-button type="button" ng-click="close()" class="md-primary">
                Cancel
            </md-button>
        	<md-button>Schedule</md-button>	
        </div>
    </form>
</md-dialog>