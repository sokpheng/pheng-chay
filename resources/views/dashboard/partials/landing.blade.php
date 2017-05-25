
<h2 class="md-display-1">New Post</h2>
<form>

  	<div layout layout-sm="column">
        <md-input-container flex>
          <label>Title</label>
          <input ng-model="user.firstName">
        </md-input-container>	     
  	</div>
  	<div layout layout-sm="column">
        <md-select flex="" placeholder="State" ng-model="ctrl.userState">
			<md-option ng-repeat="category in categories" value="<% category.value %>"><% category.name %></md-option>
		</md-select>    
        <md-select flex="" placeholder="Type" ng-model="ctrl.userState">
			<md-option ng-repeat="type in types" value="<% type.value %>"><% type.name %></md-option>
		</md-select>          
  	</div>
  	<textarea name="post-editor" id="post-editor" rows="10" cols="80">
        This is my textarea to be replaced with CKEditor.
    </textarea>

    <section layout="row" layout-sm="column" layout-align="center right"
    	style="margin-top: 15px; margin-bottom: 15px;">
      	<md-button class="md-raised md-primary">Save</md-button>
      	<md-button class="md-raised">Reset</md-button>
    </section>
</form>