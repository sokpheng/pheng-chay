app
    .config(['$interpolateProvider', '$mdThemingProvider',
        function($interpolateProvider, $mdThemingProvider) {
    	$mdThemingProvider.theme('default')
		    .primaryPalette('teal')
		    .accentPalette('lime');
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    }]);

app.run(['$http', '$rootScope', '$mdSidenav', '$mdUtil', function ($http, $rootScope, $mdSidenav, $mdUtil){
	
}]);