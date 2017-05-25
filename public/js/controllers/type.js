(function (){
	app.controller('TypeCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, CoResource,
		$mdToast, filterFilter){	     
	 	
	 	$scope.types = MockService.types.list();

	    function loadData(){	   	

		    $scope.typesTmp = CoResource.resources.Item.list({type: 'type', 'ignore-offset': 1}, function (){
		    	$scope.types = $scope.typesTmp.result;
		    });
		    // $scope.types = MockService.types.list();
		    // _.each($scope.types, function (v, key){
		    // 	$scope.types[key].type_object = MockService.types.get(v.type);
		    // });
		    workPagination();
	    };

	    $rootScope.$on('dataTypeSaved', function (){
	    	loadData();
	    });

	    // Pagination
	    $scope.pagination = {
	    	limit: 10,
	    	offset: 0
	    };

	    function workPagination(){
	    	var len  = (filterFilter($scope.types || [], $scope.search)).length;
		    var amount = len > $scope.pagination.limit ? Math.round(len / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });
	    }
	    
	    $scope.$watch('search', workPagination);

	    loadData();

	    $scope.changeOffset = function (offset){
	    	$scope.pagination.offset = offset;
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

  		$scope.editType = function (item, ev){
  			$mdDialog.show({
				controller: 'TypeDialogCtrl',
				templateUrl: '/templates/new-type',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$current: item
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
					$type: 'types'
				}
    		})
    		.then(function(answer) {
      			
			}, function() {
      			
    		});
  		};

  		// Delete type

        $scope.deleteType = function (item, ev){
            // Appending dialog to document.body to cover sidenav in docs app
            if (item.indeletable * 1){
            	return alert('This type is default and cannot be deleted');
            }
            if (!item){
                return;
            }
            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .title('Delete this type `' + item.name + '` ?')
                .content('Are sure to delete this?')
                .ariaLabel('Delete Type')
                .ok('Yes')
                .cancel('No')
                .targetEvent(ev);
            $mdDialog.show(confirm).then(function() {
                $rootScope.loading('show');
                CoResource.resources.Item.delete({
                	itemId: item.id
                }, function (s){
                	$rootScope.loading('hide');
                	$rootScope.$emit('dataTypeSaved');
                	$mdToast.show(
                        $mdToast.simple()
                            .content('Type deleted')
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                    );
                }, function (e){
                	$rootScope.loading('hide');
                	alert('Sorry, this type item cannot be deleted due to some reason, please contact administrator for more information');
                });
                
            }, function() {
            });
        };

	});
}());