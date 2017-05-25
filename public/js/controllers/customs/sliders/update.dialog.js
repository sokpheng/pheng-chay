(function() {
    app.controller('SliderUpdateDialogCtrl', function($scope, CoResource, Upload, 
    	$rootScope, $mdDialog, $mdToast, $current) {

    	$scope.uploadingFile = {
    		src: '',
    		obj: null
    	};
    	$scope.data = {};
    	$scope.mode = 'create';

    	if ($current){
    		$scope.data = angular.copy($current);
    		$scope.mode = 'edit';
    		
    	}

    	$scope.toastPosition = {
	    	bottom: false,
	    	top: true,
	    	left: false,
	    	right: true
	  	};

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	  	$scope.getToastPosition = function() {
	    	return Object.keys($scope.toastPosition)
	      		.filter(function(pos) { return $scope.toastPosition[pos]; })
	      		.join(' ');
	  	};

    	$scope.save = function ($event){
    		$rootScope.loading('show');
    		CoResource.resources.Media.update({ mediaId: $scope.data._id }, $scope.data, function (){
				$rootScope.$emit('updateSlider');
				$rootScope.loading('hide');
				$mdToast.show(
			      	$mdToast.simple()
			        	.content('Slider updated')
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );
			}, function (){
				$rootScope.loading('hide');
				alert('There was an error while trying to update slider data');
			});
    	};
    });
}());