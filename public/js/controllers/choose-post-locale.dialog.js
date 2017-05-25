
(function (){
	app.controller('PostLocaleDialogCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, $mdDialog, MockService, $rootScope, $mdToast, $current,
		$location, $locale){	     
	 	$scope.data = {};

		$scope.toastPosition = {
	    	bottom: false,
	    	top: true,
	    	left: false,
	    	right: true
	  	};
	  	$scope.getToastPosition = function() {
	    	return Object.keys($scope.toastPosition)
	      		.filter(function(pos) { return $scope.toastPosition[pos]; })
	      		.join(' ');
	  	};
	      
	    $scope.localesText = _.map(_.omit($rootScope.locales, $locale), function (v, k){
	    	return {
	    		value: k,
	    		text: v
	    	};
	    });

	    if ($locale != null){
	    	$scope.localesText.unshift({
	    		value: 'en',
	    		text: 'English'
	    	});
	    }

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	 	$scope.chooseLocale = function (){
	 		$mdDialog.hide();
	 		if ($scope.data.locale !== 'en'){
	 			$location.path('/posts/' + $current.id + '/locale/' + $scope.data.locale);	
	 		}
	 		else{
	 			$location.path('/posts/' + $current.id);
	 		}
	 		
	 	};
	});
}());