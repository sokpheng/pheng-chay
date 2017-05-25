(function (){
	app.controller('SiteCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope){	 
		$scope.data = {};

		$scope.years = [];
		var currentYear = moment().year();
		for(var i = currentYear - 10; i < currentYear + 5;i ++){
			$scope.years.push(i);
		}
	});
}());