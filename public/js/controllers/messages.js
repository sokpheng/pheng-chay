(function (){
	app.controller('MessageCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, CoResource, filterFilter, 
		$mdDialog, $rootScope, $mdToast){	     

	    $scope.listing = [];

	    // $scope.posts = MockService.posts.list();
	    var listing = CoResource.resources.Message.list({
	    	'ignore-offset': 1
	    }, function (){
	    	$scope.listing = listing.result;
	    	updatePagination();

	    });

	    function updatePagination(){

	    	var len  = (filterFilter($scope.listing || [], $scope.search)).length;
		    var amount = len > $scope.pagination.limit ? Math.ceil(len / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });
	    }

	    $scope.$watch('search', updatePagination);

	    $scope.data = {
	    	filter: null
	    };
	    $scope.$watch('data.filter', function (v){

	    });

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

  		$scope.view = function (item, ev){

    		var current = CoResource.resources.Message.get({ messageId: item.id }, function (){
    			current.$read({ messageId: item.id }, function (){
    				$rootScope.loading('hide');
    				$rootScope.$emit('updateMessageUnreadCount');
    				item.is_read = true;
					$mdToast.show(
				      	$mdToast.simple()
				        	.content('Message read')
				        	.position($scope.getToastPosition())
				        	.hideDelay(3000)
				    );
    			}, function (){
    				$rootScope.loading('hide');
    			});
    		});

  			$mdDialog.show({
				controller: 'ViewMessageDialogCtrl',
				templateUrl: '/templates/view-message',
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

	    $scope.read = function (item, $event){
	    	if (item.id){
	    		$location.path('/posts/' + item.id);	
	    	}	    	
	    };

	    // Pagination
	    $scope.pagination = {
	    	limit: 10,
	    	offset: 0
	    };
	    $scope.changeOffset = function (offset){
	    	$scope.pagination.offset = offset;
	    };

	 
	});
}());