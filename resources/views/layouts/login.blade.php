<!DOCTYPE html>
<html lang="en" ng-app="StarterApp">
	<head>
		<meta charset ="utf-8" />
		<title>CoCMS Login - Camboroom</title>
		<!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"> -->
		<meta name="description" content="CoCMS"/>
		<meta name="keywords" content="web, system, cms, coding"/>
		<meta name="author" content="nexGenDev"/>
		<meta name="developers" content="nexGenDev"/>
		<meta name="developer" content="nexGenDev"/>
		<meta name="contact" content="biz@flexitech.io"/>

		<link href="/img/favico.gif" type="image/x-icon" rel="shortcut icon" />
		<link href="{{ asset('vendors/angular-material/angular-material.min.css') }}" rel="stylesheet">		
		<link href="{{ asset('css/main.css') }}" rel="stylesheet">	
	    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=RobotoDraft:300,400,500,700,400italic">
	    <meta name="viewport" content="initial-scale=1" />
	</head>
	<body layout="column" layout-align="center center"
		style="background-image: url(/img/bg/home-background.jpg);background-size: cover;"> 
		@yield('content')
	</body>


    <!-- Angular Material Dependencies -->
    <script src="/vendors/jquery/dist/jquery.min.js"></script>
    <script src="/vendors/angular/angular.min.js"></script>
    <script src="/vendors/angular-animate/angular-animate.min.js"></script>
    <script src="/vendors/angular-aria/angular-aria.min.js"></script>
    <script src="/vendors/angular-material/angular-material.min.js"></script>

    <!-- App -->
    <script type="text/javascript" src="{{ asset('js/app.login.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/config.login.js') }}"></script>

    <!-- Libraries -->
    <script type="text/javascript" src="{{ asset('js/libraries/crypt/aes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/libraries/crypt/pbkdf2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/libraries/jsencrypt.js') }}"></script>

    <!-- Service -->
    <script type="text/javascript" src="{{ asset('js/services/crypt.js') }}"></script>

    <!-- Login -->
    <script type="text/javascript" src="{{ asset('js/controllers/login.js') }}"></script>

    <!-- Dialog -->
    <script type="text/javascript" src="{{ asset('js/controllers/modals/alert.dialog.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/controllers/modals/loading.dialog.js') }}"></script>

    @section('scripts')
      
  	@show
	
</html>