<!DOCTYPE html>
<html lang="en" ng-app="StarterApp">
	<head>
		<meta charset ="utf-8" />
		<title>CoCMS - Flexi Tech</title>
		<!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"> -->
		<meta name="description" content="CoCMS"/>
		<meta name="keywords" content="web, system, cms, coding"/>
		<meta name="author" content="nexGenDev"/>
		<meta name="developers" content="nexGenDev"/>
		<meta name="developer" content="nexGenDev"/>
		<meta name="contact" content="biz@flexitech.io"/>

		<link href="img/flexi-tech.png" type="image/x-icon" rel="shortcut icon" />
		<link href="{{ asset('css/vendor.css') }}" rel="stylesheet">	
		<link href="{{ asset('vendors/angular-material/angular-material.min.css') }}" rel="stylesheet">				
		<link href="{{ asset('css/main.css') }}" rel="stylesheet">	
	    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=RobotoDraft:300,400,500,700,400italic">
	    <meta name="viewport" content="initial-scale=1" />
	</head>
	<body layout="column" class="ng-cloak">
		@yield('content')
	</body>


    <!-- Angular Material Dependencies -->
    <script src="/vendors/moment/min/moment.min.js"></script>
    <script src="/vendors/underscore/underscore-min.js"></script>
    <script src="/vendors/angular/angular.min.js"></script>
    <script src="/vendors/angular-animate/angular-animate.min.js"></script>
    <script src="/vendors/angular-resource/angular-resource.min.js"></script>
    <script src="/vendors/angular-drag-and-drop-lists/angular-drag-and-drop-lists.min.js"></script>
    <script src="/vendors/angular-aria/angular-aria.min.js"></script>
    <script src="/vendors/angular-material/angular-material.min.js"></script>
    <!-- App -->
    <script type="text/javascript" src="{{ asset('js/app.browse-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/config.browse-media.js') }}"></script>
    <!-- Service -->
    <script type="text/javascript" src="{{ asset('js/services/resource.js') }}"></script>
    <!-- Controller -->
    <script type="text/javascript" src="{{ asset('js/controllers/browse-media.js') }}"></script>

    @section('scripts')
      
  	@show
	
</html>