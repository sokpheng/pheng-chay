(function (){
	app.controller('PostCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, CoResource, filterFilter, $rootScope,
		$routeParams){	     

	    $scope.posts = [];

	    $scope.data = {};

	    $scope.titleNames = {
	    	'industry': 'Industry Post',
	    	'article': 'Highlight Article',
	    	'service': 'Services',
	    	'training': 'Training',
	    	'about-us': 'About Us',
	    };

	    $scope.showShowAction = true;

	    $scope.titleName = $scope.titleNames[$routeParams.category];

	    $scope.hideFilter = !!$routeParams.category;

	    $scope.categoryId = null;
	    $scope.typeId = null;

		var categoriesTmp = CoResource.resources.Item.list({ 
			type: 'category', 
			'ignore-offset': 1, 
			'name': $routeParams.kind == 'type' ? null : $routeParams.category,
			'parent_name': $routeParams.kind == 'type' ? $routeParams.category : null,
		}, function (){
			categoriesTmp = categoriesTmp.result;	

		    $scope.categoryId = $routeParams.kind == 'type' ? null : categoriesTmp[0].id;
		    $scope.typeId = categoriesTmp[0].parent_id;
		});	

		$scope.action = function (){
			if (!$routeParams.category){
            	$rootScope.navigateTo('posts/create', $event);
			}
			else{
				$rootScope.navigateTo('posts/' + $scope.typeId +  '/' + ($scope.categoryId || 0) + '/create');
			}
		};

	    function checkKhmerLocale(){
	    	_.each($scope.posts, function (v, k){
	    		var temp = _.filter(v.localizations, function (val){
	    			return val.language == 'kh';
	    		});
	    		$scope.posts[k].has_kh_locale = temp && temp.length;
	    	});
	    }

	    // $scope.posts = MockService.posts.list();
	    function loadData (typeName){

		    var posts = CoResource.resources.Article.list({
		    	'ignore-offset': 1,
		    	'ignore-type-name': 'solution,product-section',
		    	'category-name': typeName || ($routeParams.kind != 'type' ? $routeParams.category : null),
		    	'type-name': ($routeParams.kind == 'type' ? $routeParams.category : null),
		    	'strict-type': $routeParams.category ? 1 : 0
		    }, function (){
		    	$scope.posts = posts.result;
		    	checkKhmerLocale();
			    $rootScope.loading('hide');
		    	// _.each($scope.post, function (p){
		    	// 	if (p.description.length > 1000){
		    	// 		p.short_description = p.description.substring(0, 1000) + '...';
		    	// 	}
		    	// });
		    	updatePagination();


			    if ($routeParams.category && $scope.posts.length && $routeParams.category != 'article'  && $routeParams.category != 'services'){
			    	$scope.showShowAction = false;
			    }
			    else{
			    	$scope.showShowAction = true;
			    }

		    });
	    }
	    loadData();

	    $rootScope.$on('articleUpdated', function (v){
	    	loadData();
	    });

	    $scope.$watch('data.filter', function (v){
	    	if (v){
	    		var typeName = v;
	    		$rootScope.loading('show');
	    		loadData(typeName);
	    	}
	    	else{
	    		$rootScope.loading('show');
	    		loadData();
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

	    $scope.edit = function (item, $event){
	    	if (item.id){
	    		if ($routeParams.category){
	    			$location.path('/posts/' + item.type_id + '/' + item.category_id + '/' + item.id);	
	    		}
	    		else{

	    			$location.path('/posts/' + item.id);	
	    		}
	    	}	    	
	    };

	    $scope.editLocale = function (item, $event){
	    	if (item.id){
	    		$location.path('/posts/' + item.id + '/locale/kh');	
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