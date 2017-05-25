
(function (){
	app.controller('AlertDialogCtrl', ['$scope', '$timeout', '$mdSidenav', 
		'$mdUtil', '$log', '$mdDialog', '$current', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, $mdDialog, $current){	     
	 	$scope.data = {};

	 	$scope.data = $current ? angular.copy($current) : null;

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};
	}]);
}());