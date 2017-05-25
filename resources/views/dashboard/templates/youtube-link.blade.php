<md-dialog aria-label="New Youtube Link" id="dialog-new-media">
    <form name="mediaForm" ng-submit="save($event)" >
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Embedded youtube</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
	        <md-input-container flex>
	            <label>Youtube link</label>
	            <input ng-model="data.link" name="link" required type="url">    
	            <div ng-messages="mediaForm.link.$error"   
	                 ng-show="mediaForm.link.$dirty && mediaForm.link.$invalid">
	                <div ng-message="required">Youtube link is required</div>
	            </div>
	        </md-input-container>

            <md-input-container flex>
                    <label>Caption</label>
                    <input ng-model="data.caption" name="caption" required>    
                    <div ng-messages="mediaForm.caption.$error"   
                         ng-show="mediaForm.caption.$dirty && mediaForm.caption.$invalid">
                        <div ng-message="required">Caption is required</div>
                    </div>
                </md-input-container>

                <md-input-container flex>
                    <md-select placeholder="Album" ng-model="data.album_id" required
                        style="padding-bottom: 0px;" name="type">
                        <md-option value="">
                            Select an album
                        </md-option>
                        <md-option ng-repeat="album in albums" value="<% album.id %>">
                            <% album.display_name %>
                        </md-option>
                    </md-select>     
                    <div ng-messages="mediaForm.album.$error"   
                         ng-show="mediaForm.album.$dirty && mediaForm.album.$invalid">
                        <div ng-message="required">Album is required</div>
                    </div>
                </md-input-container>

                <md-input-container flex>
                    <label>Sequence Number</label>
                    <input ng-model="data.seq_no" name="seqNumber">    
                </md-input-container>

                <md-input-container flex>
                    <label>Description</label>
                    <textarea ng-model="data.description" columns="1" 
                    md-maxlength="150"></textarea>
                </md-input-container>

        	<div class="photo-uploading">
        		<div class="photo-container" 
        			style="background-image:url('<% data.file_name ? 'https://img.youtube.com/vi/' + data.file_name + '/0.jpg' : '' %>')"
        			layout="row" layout-align="center center">        			
		         	<span class="icon-youtube" style="font-size: 60px;
  							color: rgb(242, 58, 14);">
		         	</span>
        		</div>
        	</div>

        	{{-- <div>

		        <md-input-container flex>
		            <label>Sequence Number</label>
		            <input ng-model="data.seq_no" name="seqNumber">    
		        </md-input-container>

		        
        	</div> --}}
        </md-dialog-content>
        <div class="md-actions" layout="row">
            <md-button type="button" ng-click="close()" class="md-primary">
                Cancel
            </md-button>
        	<md-button ng-click="close()">Save</md-button>	
        </div>
    </form>
</md-dialog>