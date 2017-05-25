(function (){
	app.controller('CategoryCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, CoResource,
		$mdToast, filterFilter){	     
	 	
	 	$scope.types = [];
	 	$scope.categories = [];
	 	function loadType(){
	 		$scope.types = CoResource.resources.Item.list({ type: 'type', 'ignore-offset': 1}, function (){
				$scope.types = $scope.types.result;		    
				workPagination();
			});
	 	}
	    function loadData(){	   	
			$scope.categoriesTmp = CoResource.resources.Item.list({ type: 'category', 'ignore-offset': 1}, function (){
				$scope.categories = $scope.categoriesTmp.result;		    
				workPagination();
			});		    
	    };

	    $rootScope.$on('dataCategorySaved', function (){
	    	loadData();
	    });

	    $rootScope.$on('dataTypeSaved', function (){
	    	loadType();
	    });

	    // Pagination
	    $scope.pagination = {
	    	limit: 10,
	    	offset: 0
	    };

	    function workPagination(){
	    	var len  = (filterFilter($scope.categories || [], $scope.search)).length;
		    var amount = len > $scope.pagination.limit ? Math.ceil(len / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });
	    }

	    $scope.$watch('search', workPagination);

	    loadData();
	    loadType();

	    $scope.changeOffset = function (offset){
	    	if ($scope.pagination.offset == offset){
	    		return;
	    	}
	    	$scope.pagination.offset = offset;
	    };

	 	$scope.createPage = function(ev) {
    		$mdDialog.show({
				controller: 'CategoryDialogCtrl',
				templateUrl: '/templates/new-category',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$current: null,
					$types: $scope.types || []
				}
    		})
    		.then(function(answer) {
      			$scope.alert = 'You said the information was "' + answer + '".';
			}, function() {
      			$scope.alert = 'You cancelled the dialog.';
    		});
  		};

	 	$scope.createType = function(ev) {
    		$mdDialog.show({
				controller: 'TypeDialogCtrl',
				templateUrl: '/templates/new-type',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$current: null
				}
    		})
    		.then(function(answer) {
      			$scope.alert = 'You said the information was "' + answer + '".';
			}, function() {
      			$scope.alert = 'You cancelled the dialog.';
    		});
  		};

  		$scope.editCategory = function (item, ev){
  			$mdDialog.show({
				controller: 'CategoryDialogCtrl',
				templateUrl: '/templates/new-category',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$current: item,
					$types: $scope.types
				}
    		})
    		.then(function(answer) {
      			
			}, function() {
      			
    		});
  		};

  		$scope.editLocalization = function (item, ev){
  			if (ev){
  				ev.stopPropagation();
  			}
  			$mdDialog.show({
				controller: 'LocaleDialogCtrl',
				templateUrl: '/templates/edit-locale',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$current: item,
					$type: 'categories'
				}
    		})
    		.then(function(answer) {
      			
			}, function() {
      			
    		});
  		};

  		// Delete category
  		$scope.deleteCategory = function (item, ev){
            // Appending dialog to document.body to cover sidenav in docs app
            if (item.indeletable * 1){
            	return alert('This item cannot be deleted');
            }
            if (!item){
                return;
            }
            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .title('Delete this category `' + item.name + '` ?')
                .content('Are sure to delete this?')
                .ariaLabel('Delete Category')
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
                            .content('Category deleted')
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                    );
                }, function (e){
                	$rootScope.loading('hide');
                	alert('Sorry, this item cannot be deleted due to some reason, please contact administrator for more information');
                });
                
            }, function() {
            });
        };

	});
}());