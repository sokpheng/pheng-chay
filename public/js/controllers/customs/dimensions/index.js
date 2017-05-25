(function (){
	app.controller('DimensionListingCtrl', ['$scope', '$timeout', '$mdSidenav',
		'$mdUtil', '$log', 'MockService', '$location', '$mdDialog', '$rootScope', 'CoResource',
		'$mdToast', 'filterFilter', '$routeParams', function($scope, $timeout, $mdSidenav,
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, CoResource,
		$mdToast, filterFilter, $routeParams){

	 	$scope.items = [];
	 	$scope.type_name = $rootScope.type_names[$routeParams.type];
	 	$scope.selected = [];

	    // Pagination
	 	$scope.pagination = {
	 		count: 0,
	    	limit: 10,
	    	offset: 0,
	    	page: 1
	 	};

	    function loadData(){

		    var promise = CoResource.resources.Item.list({
		    	type: $routeParams.type,
		    	'ignore-offset': 1,
		    	// limit: $scope.pagination.limit,
		    	// offset: ($scope.pagination.page - 1) * $scope.pagination.limit
		    }, function (){
		    	$scope.items = promise.result;
		    	$scope.pagination.count = promise.options.total;
				$rootScope.loading('hide');
		    });

		    workPagination();
	    };

	    $rootScope.$on('dataDimensionSaved', function (){
	    	loadData();
	    });

		$rootScope.$on('dimensionUploaded', function (){
			loadData();
		});

	    $scope.loadMoreData = function (){
	    	loadData();
	    };

	    function workPagination(){
	    	var len  = $scope.pagination.count;
		    var amount = len > $scope.pagination.limit ? Math.round(len / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });
	    }

	    loadData();

	    $scope.changeOffset = function (page){
	    	$scope.pagination.page = page;
	    	loadData();
	    };

	 	$scope.createDimension = function(ev) {
    		$mdDialog.show({
				controller: 'DimensionDialogCtrl',
				templateUrl: '/templates/customs.dimensions.create',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$current: {
						type: $routeParams.type
					}
				},
				skipHide: true,
          		autoWrap: false,
	          	clickOutsideToClose: true,
    		})
    		.then(function(answer) {
      			$scope.alert = 'You said the information was "' + answer + '".';
			}, function() {
      			$scope.alert = 'You cancelled the dialog.';
    		});
  		};

  		$scope.edit = function($event){
  			if ($scope.selected.length == 1){
				$scope.editDimension($scope.selected[0], $event);
  			}
  		};

  		$scope.editDimension = function (item, ev){
  			$mdDialog.show({
				controller: 'DimensionDialogCtrl',
				templateUrl: '/templates/customs.dimensions.create',
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
				},
    		})
    		.then(function(answer) {

			}, function() {

    		});
  		};

  		// Delete type
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

        $scope.delete = function (item, ev){

  			if ($scope.selected.length != 1){
				return;
			}
            // Appending dialog to document.body to cover sidenav in docs app
            // if (item.indeletable * 1){
            // 	return alert('This type is default and cannot be deleted');
            // }
			item = $scope.selected[0];
            if (!item){
                return;
            }
            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .title('Delete this item `' + item.display_name + '` ?')
                .content('Are sure to delete this?')
                .ariaLabel('Delete Item')
                .ok('Yes')
                .cancel('No')
                .targetEvent(ev);
            $mdDialog.show(confirm).then(function() {
                $rootScope.loading('show');
                CoResource.resources.Item.delete({
                	itemId: item._id
                }, function (s){
                	$rootScope.loading('show');
                	$rootScope.$emit('dataTypeSaved');
					$scope.selected = [];
					loadData();
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

	}]);
}());
