<md-dialog aria-label="Choose Post Locale" id="dialog-new-post-locale">
    <form>
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Choose locale</h2>
                <span flex></span>
                <md-button class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
            <p>Choose locale of this post to edit</p>
		    <md-radio-group ng-model="data.locale" class="md-primary">
		      	{{-- <md-radio-button value="kh">
		      		<span ng-class="{'hightlighted-text': true}">
		      			Khmer <span class="parenthese-text">edited at 2 minutes ago</span>
		      		</span>
		      	</md-radio-button> --}}
		      	<md-radio-button ng-repeat="locale in localesText" value="<% locale.value%>"><% locale.text %></md-radio-button>
		    </md-radio-group>
        </md-dialog-content>
        <div class="md-actions" layout="row">
            <md-button ng-click="chooseLocale()" class="md-primary">
                Proceed
            </md-button>
            <md-button ng-click="close()" class="md-primary">
                Cancel
            </md-button>
        </div>
    </form>
</md-dialog>