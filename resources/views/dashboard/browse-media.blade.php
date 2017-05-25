@extends('layouts.browse-media')
@section('content')	
	<div ng-controller="BrowseMediaCtrl" id="page-media" ng-cloak>		
		<md-list>
	        <md-content layout-padding="16">
	            <form name="userForm">
	            	<div layout layout-sm="column">
		                <md-input-container flex="66">
		                    <label>Search</label>
		                    <input ng-model="data.search">
		                </md-input-container>

				        <md-select flex="33" placeholder="Album" ng-model="data.album">
				        	<md-option value="">
				        		Select an album
				        	</md-option>
							<md-option ng-repeat="type in albums" value="<% type.id %>"><% type.display_name %></md-option>
						</md-select>
					</div>
	            </form>
	            <md-content layout-padding="16" class="album-content" layout layout-align="center center">
	            	<md-content ng-if="!media.length" >
	            		You have not uploaded any file yet!
	            	</md-content>

	            	<div ng-if="media.length" style="width: 100%;">
	            		<div ng-repeat="group in mediaGroups | filter: { group: { id: data.album, display_name: data.search } }">
	            			<h6 class="md-subhead">
	            				<b>Album: </b>
	            				<%
	            					group.group ? group.group.display_name : 'No'
	            				%>
	            			</h6>
				            <md-grid-list
						        md-cols-sm="1" md-cols-md="2" md-cols-gt-md="5"
						        md-row-height-gt-md="1:1" md-row-height="2:2"
						        md-gutter="12px" md-gutter-gt-sm="8px" >
							    <md-grid-tile class="green"
							    	style="background-image:url('<% item.file_name %>')"
							    	ng-repeat="item in group.media"
							    	ng-click="selectFile(item)">
							      <md-grid-tile-footer>
							        <h3><% item.caption || 'No Caption' %></h3>
							      </md-grid-tile-footer>
							    </md-grid-tile>
						  	</md-grid-list>
					  	</div>
	            	</div>
		            {{-- <md-grid-list
		            	ng-if="media.length"
				        md-cols-sm="1" md-cols-md="2" md-cols-gt-md="5"
				        md-row-height-gt-md="1:1" md-row-height="2:2"
				        md-gutter="12px" md-gutter-gt-sm="8px" >
					    <md-grid-tile class="green" 
					    	style="background-image: url('/<% item.file_name %>')"
					    	ng-repeat="item in media"
					    	ng-click="selectFile(item)">
					      <md-grid-tile-footer>
					        <h3><% item.created_at %></h3>
					      </md-grid-tile-footer>
					    </md-grid-tile>
				  	</md-grid-list> --}}
			  	</md-content>
	        </md-content>
	    </md-list>
	</div>
@stop