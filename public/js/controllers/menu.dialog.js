
(function (){
	app.controller('MenuDialogCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, $mdDialog, MockService, $rootScope, $mdToast,
		$current, CoResource){	     

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

	  	function loadData(){	   	

		    MockService
		    	.pages
		    	.remote
		    	.list()
		    	.success(function (s){
		    		$scope.listData = s.result;
		    		$scope.pages = $scope.listData.pages;
		    	})
		    	.error(function (f){
		    		$scope.listData = {
		    			pages: []
		    		};
		    	});
	    };

	    loadData();

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	 	$scope.save = function (){
	 		if (!$scope.data || !$scope.data.display_name || !$scope.data.name){
	 			return $mdDialog.show(
			      	$mdDialog.alert()
				        .parent(angular.element(document.body))
				        .title('Create Menu')
				        .content('Sorry, you have not filled in name or link url')
				        .ariaLabel('Create Menu')
				        .ok('Got it!')
			    );
	 		}
	 		$rootScope.loading('show');
	 		if ($scope.data.id){
	 			// MockService.menu.update($scope.data);	
	 			var item = CoResource.resources.Item.update({ itemId: $scope.data.id }, {
	 				display_name: $scope.data.display_name,
	 				name: $scope.data.name,
	 				description: $scope.data.description
	 			}, function (s){
	 				$rootScope.loading('hide');
 					$rootScope.$emit('dataMenuSaved', {
			 			mode: 'edit',
			 			$current: s.result
			 		});

			 		$mdToast.show(
				      	$mdToast.simple()
				        	.content('Menu saved')
				        	.position($scope.getToastPosition())
				        	.hideDelay(3000)
				    );
	 			}, function (e){
 					$rootScope.loading('hide');
 					alert('There was an error while updating the menu');	 				
	 			});
	 		}
	 		else{	 		
		 		if ($scope.$$prevSibling.current){
		 			$scope.data.parent_id = $scope.$$prevSibling.current.id || null;
		 		}
		 		else{
		 			$scope.data.parent_id = null;
		 		}
		 		$current = $scope.data;

		 		$scope.data.seq_number = 99;
	 			// MockService.menu.store($scope.data);	
	 			var item = new CoResource.resources.Item($scope.data);
	 			item.item_type = 'menu';
	 			item = item.$save(function (s){
	 				
	 				$rootScope.loading('hide');
	 				$rootScope.$emit('dataMenuSaved', {
			 			mode: 'create',
			 			$current: s.result
			 		});

			 		$mdDialog.hide();

					$mdToast.show(
				      	$mdToast.simple()
				        	.content('Menu created')
				        	.position($scope.getToastPosition())
				        	.hideDelay(3000)
				    );
	 			}, function (f){
	 				$rootScope.loading('hide');
	 				alert('There was an error while trying to save menu item');
	 			});
	 		}

		    
	 	};
	});
}());