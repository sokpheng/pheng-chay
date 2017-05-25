<md-dialog aria-label="New Album" id="dialog-new-media">
    <form name="mediaForm" ng-submit="save($event)" style="overflow: hidden" >
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Upload files</h2>
                <span flex></span>
                <md-button type="button" class="md-icon-button" ng-click="close()">
                    <md-icon md-font-icon="icon-cross" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content style="    height: 100%;    max-height: 600px;    overflow-y: scroll;    width: 100%;">
        	<div>
        		<div style="display: none">
        			<input type="file" name="file" id="file"/>
        		</div>
		        <md-input-container flex>
		            <label>File</label>
		            <input ng-model="uploadingFile.obj.name" name="fileName" required ng-disabled="true">    
		        </md-input-container>
		        <md-input-container flex ng-if="data.id">
		            <label>Link</label>
		            <input ng-model="data.tmp_link" name="link" required ng-disabled="true">    
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
        	</div>
        	
			
        </md-dialog-content>
        <div class="md-actions">
        	<div ng-if="mode == 'create'" layout="row" layout-align="space-between center" style="width: 100%">							
	        	<md-button 
	        		type="button"
	        		ng-click="startUpload($event)" 
	        		class="fmd-raised">Start upload</md-button>
	        	<md-button 
	        		type="button"
	        		ngf-select ng-model="files" ngf-change="chooseFile(files)" multiple="false"
	        		class="fmd-raised md-primary">Choose File</md-button>

	            <md-button type="button" ng-click="close()" class="md-primary">
	                Cancel
	            </md-button>
			</div>
			<div ng-if="mode == 'edit'" layout="row"  layout-align="space-between center" style="width: 100%">	
				{{-- <div> --}}
		        	<md-button type="button" ng-click="remove(data)"
		        		class="fmd-raised md-warn">Delete</md-button>	
	        	{{-- </div>
	        	<div> --}}
		        	<md-button 
		        		class="fmd-raised">Save</md-button>	
		            <md-button type="button" ng-click="close()" class="md-primary">
		                Cancel
		            </md-button>			
	            {{-- </div>		 --}}
			</div>
        </div>
    </form>
</md-dialog>