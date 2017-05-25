(function (){
	app.controller('PageCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope){	     

	    $scope.pages = [];

	    $scope.pages = MockService.pages.list();

	    $scope.edit = function (item, $event){
	    	   	
	    };

	    function loadData(){	   	

		    MockService
		    	.pages
		    	.remote
		    	.list()
		    	.success(function (s){
		    		$scope.listData = s.result;
		    		$scope.pages = $scope.listData.pages;
		    		workPagination();
		    	})
		    	.error(function (f){
		    		$scope.listData = {
		    			pages: []
		    		};
		    	});
	    };

	    $rootScope.$on('dataPageSaved', function (){
	    	loadData();
	    });

	    // Pagination
	    $scope.pagination = {
	    	limit: 10,
	    	offset: 0
	    };

	    function workPagination(){
		    var amount = $scope.pages.length > $scope.pagination.limit ? Math.round($scope.pages.length / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });

	    }

	    loadData();
	    workPagination();

	    $scope.changeOffset = function (offset){
	    	$scope.pagination.offset = offset;
	    };

	 	$scope.createPage = function(ev) {
    		$mdDialog.show({
				controller: 'PageDialogCtrl',
				templateUrl: '/templates/new-page',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$current: null,
					$layouts: $scope.listData.layouts
				}
    		})
    		.then(function(answer) {
      			$scope.alert = 'You said the information was "' + answer + '".';
			}, function() {
      			$scope.alert = 'You cancelled the dialog.';
    		});
  		};

  		$scope.edit = function (page, ev){
  			$mdDialog.show({
				controller: 'PageDialogCtrl',
				templateUrl: '/templates/new-page',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$current: page,
					$layouts: $scope.listData.layouts
				}
    		})
    		.then(function(answer) {
      			
			}, function() {
      			
    		});
  		};

	 
	});
}());