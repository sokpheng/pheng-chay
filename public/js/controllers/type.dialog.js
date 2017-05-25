(function (){
	app.controller('TypeDialogCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, $current,
		$mdToast, CoResource){	
		$scope.data = $current ? angular.copy($current) : null;

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

	 	$scope.$watch('data.display_name', function (v){
	 		if ($scope.data && v){
	 			$scope.data.name = namespace.urlify(v);
	 		}
	 	});	      

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	 	$scope.save = function ($event){
	 		if (!$scope.data || !$scope.data.name){
	 			return $mdDialog.show(
			      	$mdDialog.alert()
				        .parent(angular.element(document.body))
				        .title('Create type')
				        .content('Sorry, you have not filled in name field')
				        .ariaLabel('Create type')
				        .ok('Got it!')
			    );
	 		}

	 		var success = function (){
		 		$current = $scope.data;		 		
		 		$rootScope.$emit('dataTypeSaved', {
		 			mode: $current ? 'edit' : 'create',
		 			$current: $current
		 		});
		 		$mdDialog.hide();
				$mdToast.show(
			      	$mdToast.simple()
			        	.content($current ? 'Type saved' : 'Type created')
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );
	 		};

	 		var fail = function (f){	 			
				return $mdDialog.show(
	      			$mdDialog.alert()
				        .parent(angular.element(document.body))
				        .title('Create Type')
				        .content('There was an error while creating type. ' + f)
				        .ariaLabel('Create Type')
				        .ok('Got it!')
			    );
	 		};
	 		$rootScope.loading('show');
	 		if ($scope.data.id){
	 			var item = new CoResource.resources.Item.get({
	 				itemId: $scope.data.id
	 			}, function(){
	 				item.display_name = $scope.data.display_name;
	 				item.name = $scope.data.name;
	 				item.description = $scope.data.description;
	 				item.seq_number = $scope.data.seq_number;
	 				item.$update({itemId: $scope.data.id}, function (s, h){
	 					success();
	 					$rootScope.loading('hide');
	 				}, function (e){
	 					$rootScope.loading('hide');
	 					fail(CoResource.textifyError(e.data));
	 				});
	 			}, function (e){
 					$rootScope.loading('hide');
 					fail(CoResource.textifyError(e.data));
 				});
	 		}
	 		else{	 	
		 		$scope.data.seq_number = $scope.data.seq_number || 99;
	 			var item = new CoResource.resources.Item($scope.data);
	 			item.item_type = 'type';
	 			item.$save(function (s, h){
	 				success();
	 				$rootScope.loading('hide');
	 			}, function (e){
 					$rootScope.loading('hide');
 					fail(CoResource.textifyError(e.data));
 				});
	 				
	 		}
	 	};
	});
}());