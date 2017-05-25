(function (){
	app.controller('SolutionCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, CoResource, filterFilter, $rootScope){	     

	    $scope.posts = [];

	    $scope.data = {};

	    function checkKhmerLocale(){
	    	_.each($scope.posts, function (v, k){
	    		var temp = _.filter(v.localizations, function (val){
	    			return val.language == 'kh';
	    		});
	    		$scope.posts[k].has_kh_locale = temp && temp.length;
	    	});
	    }

 		$scope.type = CoResource.resources.Item.list({ type: 'type', 'ignore-offset': 1}, function (){
 			var tmp = _.filter($scope.type.result, function (v){
 				return v.name == 'solution';
 			});
			$scope.type = tmp && tmp[0] ? tmp[0] : null;		    
		});

	    // $scope.posts = MockService.posts.list();
	    function callBackLoaded(posts){

	    	$scope.posts = posts.result;
    		checkKhmerLocale();
	    	updatePagination();
	    	_.each($scope.posts, function (v, k){
	    		$scope.posts[k].products_desc = _.map(v.products, function (val){
	    			return val.display_name;
	    		}).join(', ');
	    	});
	    }
	    var posts = CoResource.resources.Article.list({
	    	'ignore-offset': 1,
	    	'type-name': 'solution'
	    }, function (){
	    	callBackLoaded(posts);
	    	// $scope.posts = posts.result;
	    	// checkKhmerLocale();
	    	// _.each($scope.post, function (p){
	    	// 	if (p.description.length > 1000){
	    	// 		p.short_description = p.description.substring(0, 1000) + '...';
	    	// 	}
	    	// });
	    	// updatePagination();

	    });

	    $rootScope.$on('articleUpdated', function (v){
	    	posts = CoResource.resources.Article.list({
		    	'ignore-offset': 1,
	    		'type-name': 'solution'
		    }, function (){

		    });
	    });

	    $scope.$watch('data.filter', function (v){
	    	if (v){
	    		var typeName = v;
	    		$rootScope.loading('show');
	    		posts = CoResource.resources.Article.list({
			    	'ignore-offset': 1,
			    	'category-name': typeName,
	    			'type-name': 'solution'
			    }, function (){

	    			callBackLoaded(posts);
			    	// $scope.posts = posts.result;

	    			// checkKhmerLocale();
			    	// updatePagination();
			    	$rootScope.loading('hide');

			    });
	    	}
	    	else{
	    		$rootScope.loading('show');
	    		posts = CoResource.resources.Article.list({
			    	'ignore-offset': 1,
	    			'type-name': 'solution'
			    }, function (){
			    	$rootScope.loading('hide');
	    			callBackLoaded(posts);
			    	// $scope.posts = posts.result;
	    			// checkKhmerLocale();
			    	// updatePagination();

			    });
	    	}
	    });

	    function updatePagination(){

	    	var len  = (filterFilter($scope.posts || [], $scope.search)).length;
		    var amount = len > $scope.pagination.limit ? Math.ceil(len / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });
	    }

	    $scope.$watch('search', updatePagination);

	    $scope.create = function (){
	    	$location.path('/functions/' + $scope.type.id + '/articles/' + namespace.guid());	
	    };

	    $scope.edit = function (item, $event){
	    	if (item.hash){
	    		$location.path('/functions/' + $scope.type.id + '/articles/' + item.hash);	
	    	}	    	
	    };

	    $scope.editLocale = function (item, $event){
	    	if (item.id){
	    		// $location.path('/posts/' + item.id + '/locale/kh');	
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