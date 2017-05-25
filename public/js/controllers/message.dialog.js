(function (){
	app.controller('ViewMessageDialogCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, $current,
		$mdToast, CoResource){	
		$scope.data = $current ? angular.copy($current) : null;

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};
	});
}());