<div>
	<!-- START: HEADER TOOLBAR -->
	<md-toolbar class="md-theme-indigo md-default-theme">
      <div class="md-toolbar-tools">
        <h2>
	        <span>
			    Slider Gallery
			</span>

        </h2>
        <span flex></span>
      </div>
    </md-toolbar>

    <!-- START: CONTENT DATA -->
    <md-content layout-padding="16" class="transparent-content">
		<md-content class="box-shadow-content">
			<form layout="row" layout-padding="16" name="enterpriseForm" layout-align="center center"
				ng-submit="submit()" ng-disabled="loading">
				<md-content style="width: 100%; max-width: 960px;"
					class="transparent-content enterprise-create">
					<div class="" layout-gt-xs="column">

				      	<div fflex-gt-xs>
				      		<md-content class="md-padding" flex-gt-xs>
			        			<h1 class="md-display-2">Slider Gallery </h1>

						      	<section layout="row" flayout-sm="column"
						      		class="media-gallery"
						      		style="margin-top: 15px; margin-bottom: 15px;">
						      		<div class="media flex-33" flex="33">
						      			<div class="logo-inner" layout="column" layout-align="center center">
							         		<span class="icon-camera"></span>
							         		<span class="upload-text">Upload your slider gallery here</span>
							         		{{-- <span class="upload-text" ng-show="mode === 'create'">Please, save your listing first before upload</span> --}}
							         		<div class="overlay" ng-show="mode === 'edit'"></div>
							         	</div>
							         	<span class="icon-upload3 center"
							         		ngf-select ng-model="files" ngf-change="uploadMedia(files)"
							         		multiple="false">
							         	</span>
						      		</div>
						      		{{-- Media --}}
						      		<div class="media uploaded" flex="33" ng-repeat="media in data.gallery" ng-click="editMedia(media)">
						      			<div class="logo-inner" layout="column" layout-align="center center"
						      				style="background-image: url('<% media.thumbnail_url_link %>')">
							         		<div class="overlay"></div>
							         		<div class="remove icon-cross" ng-click="deletePhoto(media); $event.stopPropagation()"></div>
							         	</div>
							         	{{-- <span class="icon-search left" href="<% mediaUrl ? mediaUrl + media.file_name : '/' + media.file_name %>" data-title="<% data.name %>"></span>
							         	<span class="icon-heart right" ng-class="{'selected': data.cover_media == media._id}" href="javascript:void(0)" ng-click="updateCover(media, $event)" data-title="<% data.name %>"></span> --}}
						      		</div>
						      		{{-- Pending --}}
						      		<div class="media" flex="33" ng-repeat="media in pendingFiles">
						      			<div class="logo-inner" layout="column" layout-align="center center"
						      				style="background-image: url('<% media.src %>')">
							         		<div class="overlay" ng-show="mode === 'edit'"></div>
							         		<md-progress-circular md-mode="determinate"
							         			ng-show="media.loading"
							         			value="<% media.progress %>"></md-progress-circular>
							         		<div ng-show="!media.loading" class="remove icon-cross" ng-click="deletePendingPhoto(media)"></div>
							         	</div>
						      		</div>
						      	</section>
					      	</md-content>

				      	</div>

			      	</div>

			    </md-content>
		    </form>
	    </md-content>
    </md-content>
</div>
