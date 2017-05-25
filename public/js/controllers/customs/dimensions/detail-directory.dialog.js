(function (){
	app.controller('DimensionDetailDialogCtrl', ['$scope', '$timeout', '$mdSidenav',
		'$mdUtil', '$log', '$location', '$mdDialog', '$rootScope', '$current',
		'$mdToast', 'CoResource', 'Upload', '$timeout', function($scope, $timeout, $mdSidenav,
		$mdUtil, $log, $location, $mdDialog, $rootScope, $current,
		$mdToast, CoResource, Upload, $timeout){
		$scope.data = $current ? angular.copy($current) : null;
		$scope.type_name = $rootScope.type_names[$current ? $current.type : ''];
        $scope.noCoverUpload = true;
        $scope.noDimensionInfo = true;

		$scope.toastPosition = {
	    	bottom: false,
	    	top: true,
	    	left: false,
	    	right: true
	  	};

		$scope.mode = !!$scope.data._id ? 'edit' : 'create';

	  	$scope.getToastPosition = function() {
	    	return Object.keys($scope.toastPosition)
	      		.filter(function(pos) { return $scope.toastPosition[pos]; })
	      		.join(' ');
	  	};

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	 	$scope.save = function ($event){
	 		if (!$scope.data || !$scope.data.display_name){
	 			return;
	 		}

	 		var success = function (){
		 		$current = $scope.data;
		 		$rootScope.$emit('dataDimensionDetailSaved', {
		 			mode: $current ? 'edit' : 'create',
		 			$current: $current
		 		});
		 		return $mdDialog.show(
			      	$mdDialog.alert({
	                    preserveScope: true,
	                    autoWrap: true,
	                    skipHide: true,
	                    title: 'Create Dimension',
	                    content: 'Dimension has been saved',
	                    ariaLabel: 'Create dimension',
	                    ok: 'Got it!'
			      	})
			    )
	          	.finally(function() {
	            	$mdDialog.hide();
	          	});
	 		};

	 		var fail = function (f){
		 		return $mdDialog.show(
			      	$mdDialog.alert({
	                    preserveScope: true,
	                    autoWrap: true,
	                    skipHide: true,
	                    // parent: angular.element(document.body),
	                    title: 'Create Dimension',
	                    content: 'There was an error while creating dimension. ' + f,
	                    ariaLabel: 'Create dimension',
	                    ok: 'Got it!'
			      	})
			    );
	 		};
	 		$rootScope.loading('show');

			CoResource.resources.Directory.updateDimensionDetail({directoryId: $scope.data.directory}, $scope.data, function (s, h){
				success();
				$rootScope.loading('hide');
			}, function (e){
				$rootScope.loading('hide');
				fail(CoResource.textifyError(e.data));
			});
	 	};



	}]);
}());
