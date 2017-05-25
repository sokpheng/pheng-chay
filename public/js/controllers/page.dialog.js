
(function (){
	app.controller('PageDialogCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, $mdDialog, MockService, $rootScope, $mdToast,
		$current, $rootScope, $layouts){	     

	 	$scope.data = $current ? angular.copy($current.info) : null;

	 	console.log($scope.data);

	 	$scope.layouts = $layouts || [];

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
	      

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	 	$scope.urlify = function (){
	 		if ($scope.data && $scope.data.title){
	 			return $scope.data.title.toLowerCase().replace(/ /g, '-');
	 		}
	 		else{
	 			return '';
	 		}
	 	};

	 	$scope.save = function (){
	 		if (!$scope.data || !$scope.data.title || !$scope.data.description){
	 			return $mdDialog.show(
			      	$mdDialog.alert()
				        .parent(angular.element(document.body))
				        .title('Create Page')
				        .content('Sorry, you have not filled in title and description file')
				        .ariaLabel('Create Page')
				        .ok('Got it!')
			    );
	 		}

	 		if (!$scope.data.link){
	 			$scope.data.link = $scope.urlify();
	 		}
	 		var success = function (){
		 		$current = $scope.data;		 		
		 		$rootScope.$emit('dataPageSaved', {
		 			mode: $current ? 'edit' : 'create',
		 			$current: $current
		 		});
		 		$mdDialog.hide();
				$mdToast.show(
			      	$mdToast.simple()
			        	.content($current ? 'Pages saved' : 'Pages created')
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );
	 		};

	 		var fail = function (f){	 			
				return $mdDialog.show(
	      			$mdDialog.alert()
				        .parent(angular.element(document.body))
				        .title('Create Page')
				        .content('There was an error while creating page. ' + f.result)
				        .ariaLabel('Create Page')
				        .ok('Got it!')
			    );
	 		};
	 		if ($scope.data.id){
	 			$scope.data['page-name'] = $current['page-name'];
	 			MockService
	 				.pages
	 				.remote
	 				.update($scope.data)
	 				.success(function (){
	 					success();
	 				})
					.error(fail);	
	 		}
	 		else{	 	
		 		$scope.data.seq_number = 99;
	 			MockService
	 				.pages
	 				.remote
	 				.store($scope.data)
	 				.success(function (){
	 					success();
	 				})
					.error(fail);	
	 		}
	 	};
	});
}());