(function (){
	app.controller('CategoryDialogCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, $current, $types,
		$mdToast, CoResource){	
		$scope.data = $current ? angular.copy($current) : null;

	 	$scope.types = $types || [];

	 	// Extended
	 	if ($scope.data && $scope.data.type_name){
	 		var type = _.filter($scope.types, function(v){
	 			return v.name == $scope.data.type_name;
	 		});
	 		if (type && type[0]){
	 			$scope.data.parent_id = type[0].id;
	 		}

	        $scope.detail = function(){
	        	$mdDialog.hide();
	        	$location.path('products/' + $scope.data.id);
	        };

	 	}

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

	 	$scope.urlify = function (field){
	 		if (field){
	 			return field.toLowerCase().replace(/ /g, '-');
	 		}
	 		else{
	 			return '';
	 		}
	 	};

	 	$scope.$watch('data.name', function (){
	 		if ($scope.data){	 		
		 		$scope.data.key = $scope.urlify($scope.data.name);
		 	}
	 	});

	 	$scope.save = function ($event){
	 		if (!$scope.data || !$scope.data.name || !$scope.data.parent_id){
	 			return $mdDialog.show(
			      	$mdDialog.alert()
				        .parent(angular.element(document.body))
				        .title('Create Category')
				        .content('Sorry, you have not filled in name and description file')
				        .ariaLabel('Create Category')
				        .ok('Got it!')
			    );
	 		}
	 		var success = function (){
		 		$current = $scope.data;		 		
		 		$rootScope.$emit('dataCategorySaved', {
		 			mode: $current ? 'edit' : 'create',
		 			$current: $current
		 		});
		 		$mdDialog.hide();
				$mdToast.show(
			      	$mdToast.simple()
			        	.content($current ? 'Category saved' : 'Category created')
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );
	 		};

	 		var fail = function (f){	 			
				return $mdDialog.show(
	      			$mdDialog.alert()
				        .parent(angular.element(document.body))
				        .title('Create Category')
				        .content('There was an error while creating category. ' + f)
				        .ariaLabel('Create Category')
				        .ok('Got it!')
			    );
	 		};
	 		$scope.data = _.pick($scope.data, 'display_name', 'description', 'name', 'id', 'parent_id', 'seq_number', 'status');

	 		$rootScope.loading('show');
	 		if ($scope.data.id){
	 			var item = new CoResource.resources.Item.get({
	 				itemId: $scope.data.id
	 			}, function(){
	 				item.display_name = $scope.data.display_name;
	 				item.name = $scope.data.name;
	 				item.description = $scope.data.description;
	 				item.parent_id = $scope.data.parent_id;
	 				item.seq_number = $scope.data.seq_number;
	 				item.status = $scope.data.status || 'active';
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
	 			$scope.data.status = $scope.data.status || 'active';
	 			var item = new CoResource.resources.Item($scope.data);
	 			item.item_type = 'category';
	 			item.$save(function (s, h){
	 				success();
	 				$rootScope.loading('hide');
	 			}, function (e){
 					$rootScope.loading('hide');
 					fail(CoResource.textifyError(e.data));
 				});
	 				
	 		}
	 	};

  		$scope.remove = function (ev){
  			var item = $scope.data;
            // Appending dialog to document.body to cover sidenav in docs app
            if ($scope.data.indeletable * 1){
            	return alert('This item cannot be deleted');
            }
            if (!item){
                return;
            }
            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .title('Delete this item `' + item.name + '` ?')
                .content('Are sure to delete this?')
                .ariaLabel('Delete Item')
                .ok('Yes')
                .cancel('No')
                .targetEvent(ev);
            $mdDialog.show(confirm).then(function() {
                $rootScope.loading('show');
                CoResource.resources.Item.delete({
                	itemId: item.id
                }, function (s){
                	$rootScope.loading('hide');
                	$rootScope.$emit('dataCategorySaved');
                	$mdToast.show(
                        $mdToast.simple()
                            .content('Item deleted')
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                    );

		 			$mdDialog.hide();
                }, function (e){
                	$rootScope.loading('hide');
                	fail(CoResource.textifyError(e.data));
                });
                
            }, function() {
            });
        };

	});
}());