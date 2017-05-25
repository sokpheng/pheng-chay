app
    .config(['$interpolateProvider', 
        function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    }]);

app.run(['$http', '$rootScope', '$mdSidenav', '$mdUtil', function ($http, $rootScope, $mdSidenav, $mdUtil){
	
}]);