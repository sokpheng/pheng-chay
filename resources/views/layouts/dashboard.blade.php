<!DOCTYPE html>
<html lang="en" ng-app="StarterApp">
	<head>
		<meta charset ="utf-8" />
        <meta name="viewport" content="initial-scale=1" />
		<title>CoCMS Dashboard System - Hungry Hungry</title>
		<!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"> -->
		<meta name="description" content="CoCMS"/>
		<meta name="keywords" content="web, system, cms, coding"/>
		<meta name="author" content="nexGenDev"/>
		<meta name="developers" content="nexGenDev"/>
		<meta name="developer" content="nexGenDev"/>
		<meta name="contact" content="biz@flexitech.io"/>

        <meta name="se:remoteUrl" content="{{ base64_encode(env('REMOTE_API', '')) }}">

        <!-- -->
        <meta name="api:session" content="{{ base64_encode(\Session::getId() . 'A') }}">

        @if (AuthGateway::isAdminLogin())
            <meta name="api:bearer" content="{{ AuthGateway::admin()['access_token'] }}">
            <meta name="api:request" content="{{ 'YjgyMDRlODIzMzk4NTFhZGE4YzFhZjZmOWQ2YWU3MTdjOWY2YzM3NDFmNjU3NDJjNDEzMWNlNDZhMjRlMGJhYQ==' }}">
        @endif

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=RobotoDraft:300,400,500,700,400italic">
        
		<link href="{{ URL::asset('img/red.png') }}" type="image/x-icon" rel="shortcut icon" />


        {{-- @if(App::environment('local')) --}}

    		<link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
            <link href="{{ asset('vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet">
    		
    		<link href="{{ asset('vendors/angular-material/angular-material.min.css') }}" rel="stylesheet">
            <link href="{{ asset('vendors/angular-material-datetimepicker/dist/material-datetimepicker.min.css') }}" rel="stylesheet">
    		<link href="/vendors/angular-material-data-table/dist/md-data-table.min.css" rel="stylesheet" type="text/css"/>
            <link href="{{ asset('css/main.css') }}" rel="stylesheet">

        {{-- @else --}}

            {{-- <link href="{{ elixir('css/admin_style.css') }}" rel="stylesheet"> --}}

        {{-- @endif --}}



	    <style>
	        .datepicker.datepicker-inline{
	            margin: auto;
	        }
	    </style>
	</head>
	<body layout="column" class="ng-cloak">
		<md-toolbar layout="row" hide-gt-md>
	      <div class="md-toolbar-tools">
	        <md-button ng-click="toggleSidenav('left')" hide-gt-md class="md-icon-button">
	          <md-icon aria-label="Menu" fmd-svg-icon="https://s3-us-west-2.amazonaws.com/s.cdpn.io/68133/menu.svg"></md-icon>
	        </md-button>
	        <h1>

                <a class="navbar-brand" href="/" style="padding-left: 0px">
                    <span>Hungy Hungry Dashboard</span>
                </a>
            </h1>
	      </div>
	    </md-toolbar>
	    <div layout="row" flex>
	    	@include ('includes.layouts.dashboard-sidebar')
			@yield('content')
		</div>
		<md-progress-linear class="global-loading" ng-show="loadingBarVisible" class="global-progress-bar" md-mode="indeterminate"></md-progress-linear>
	</body>

    <script src='//maps.googleapis.com/maps/api/js?key=AIzaSyCrP9rxOqS4yAxtd-3cT9kJTYnO5fpnJoY&libraries=places'></script>

    {{-- @if(App::environment('local')) --}}

        <!-- Angular Material Dependencies -->
        <script src="/vendors/moment/min/moment.min.js"></script>
        <script src="/vendors/jquery/dist/jquery.min.js"></script>
        <script src="/vendors-download/magnific-popup/jquery.magnific-popup.js"></script>
        <script src="/vendors/underscore/underscore-min.js"></script>
        <script src="/vendors/angular/angular.min.js"></script>
        <script src="/vendors/angular-animate/angular-animate.min.js"></script>

        <script src="/vendors/angular-google-maps/dist/angular-google-maps.min.js"></script>

        <script src="/vendors/angular-material-datetimepicker/dist/angular-material-datetimepicker.min.js"></script>

        <script src="/vendors/lodash/dist/lodash.min.js"></script>
        <script type="text/javascript" src="{{ asset('vendors/angular-simple-logger/dist/angular-simple-logger.min.js') }}"></script>

        <script src="/vendors/ngmap/build/scripts/ng-map.min.js"></script>
        <script src="/vendors/angular-resource/angular-resource.min.js"></script>
        <script src="/vendors/angular-drag-and-drop-lists/angular-drag-and-drop-lists.min.js"></script>
        <script src="/vendors/angular-aria/angular-aria.min.js"></script>
        <script src="/vendors/angular-material/angular-material.min.js"></script>
        <script src="/vendors/angular-route/angular-route.min.js"></script>
        <script src="/vendors/angular-sanitize/angular-sanitize.min.js"></script>
        <script src="/vendors/ng-file-upload/ng-file-upload.min.js"></script>

        <script src="/vendors/material-angular-paging/build/dist.min.js"></script>

        <script src="/vendors/ng-file-upload-shim/ng-file-upload-shim.min.js"></script>
        <script src="/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="/vendors/angular-material-data-table/dist/md-data-table.min.js"></script>

        <!-- Text editor -->
        <script src="/vendors-download/ckeditor/ckeditor.js"></script>
        <!-- App -->
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/env.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/libraries/route.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/libraries/menu.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/libraries/crypt/aes.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/libraries/crypt/pbkdf2.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/libraries/jsencrypt.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/config.js') }}"></script>
        <!-- Service -->
        <script type="text/javascript" src="{{ asset('js/services/mock.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/services/resource.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/services/crypt.js') }}"></script>
        <!-- Directive -->
        <script type="text/javascript" src="{{ asset('js/directives/co-editor.js') }}"></script>
        <!-- Controller -->
        <script type="text/javascript" src="{{ asset('js/controllers/home.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/sidebar.js') }}"></script>
        {{-- <script type="text/javascript" src="{{ asset('js/controllers/posts.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/messages.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/message.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/pages.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/media.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/menu.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/category.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/type.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/site.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/album.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/menu.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/page.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/category.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/type.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/localization.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/media.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/youtube.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/choose-post-locale.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/schedule-article.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/modals/alert.dialog.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/modals/loading.dialog.js') }}"></script> --}}

        {{-- <script type="text/javascript" src="{{ asset('js/controllers/articles.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/article-create.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/collections.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/collection-create.js') }}"></script> --}}
        {{-- Custom --}}
        {{-- <script type="text/javascript" src="{{ asset('js/controllers/customs/products.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/product-sections.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/product-create.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/solutions.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/files.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/file.dialog.js') }}"></script> --}}

        {{-- Custom - Hungry Hungry --}}
        {{-- Custom - Hotel --}}
        <script type="text/javascript" src="{{ asset('js/controllers/customs/hotels/index.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/hotels/create.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/hotels/dialog-roomtype.js') }}"></script>
        {{-- Custom - Bookings --}}
        <script type="text/javascript" src="{{ asset('js/controllers/customs/booking/index.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/booking/dialog.js') }}"></script>
{{--         <script type="text/javascript" src="{{ asset('js/controllers/customs/dimensions/index.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/dimensions/dialog.js') }}"></script>
    	<script type="text/javascript" src="{{ asset('js/controllers/customs/dimensions/detail-directory.dialog.js') }}"></script> --}}
        {{-- Custom - Slider --}}
{{--         <script type="text/javascript" src="{{ asset('js/controllers/customs/sliders/create.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/controllers/customs/sliders/update.dialog.js') }}"></script> --}}
        {{-- Custom - Comment --}}
        {{-- <script type="text/javascript" src="{{ asset('js/controllers/customs/comments/index.js') }}"></script> --}}

    {{-- @else --}}

        {{-- <script type="text/javascript" src="{{ elixir('js/build/hh-admin-script.js') }}"  async="true"></script>  --}}


    {{-- @endif --}}

    @section('scripts')

  	@show

</html>
