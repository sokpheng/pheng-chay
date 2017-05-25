
(function (){
	app.controller('AlbumDialogCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, $mdDialog, MockService, $rootScope, $mdToast, CoResource){	     
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

	 	$scope.urlify = function (field){
	 		if (field){
	 			return field.toLowerCase().replace(/ /g, '-');
	 		}
	 		else{
	 			return '';
	 		}
	 	};

	  	$scope.$watch('data.display_name', function (v){
	  		if (v){
	  			$scope.data.name = $scope.urlify(v);
	  		}
	  	});
	      

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	 	$scope.save = function (){
	 		// MockService.albums.store($scope.data);
	 		var item = new CoResource.resources.Item($scope.data);
	 		$rootScope.loading('show');
 			item.item_type = 'album';
 			item.$save(function (s, h){
 				$rootScope.loading('hide');
 				$rootScope.$emit('dataAlbumSaved');
 				$mdDialog.hide();
				$mdToast.show(
			      	$mdToast.simple()
			        	.content('Album created')
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );
 			}, function (e){
				$rootScope.loading('hide');
				return $mdDialog.show(
	      			$mdDialog.alert()
				        .parent(angular.element(document.body))
				        .title('Create Album')
				        .content('There was an error while creating album.')
				        .ariaLabel('Create Album')
				        .ok('Got it!')
			    );
			});
	 	};
	});
}());