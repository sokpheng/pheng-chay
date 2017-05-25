(function (){
	app.controller('ProductSectionCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, CoResource,
		$mdToast, filterFilter, $routeParams){	     
	 	
	 	$scope.types = [];
	 	$scope.categories = [];
	 	function loadType(){
	 		$scope.types = CoResource.resources.Item.list({ type: 'type', 'ignore-offset': 1}, function (){
				$scope.types = $scope.types.result;		    
				workPagination();
			});
	 	}
	    function loadData(){	  

            $rootScope.loading('show'); 	
			$scope.categoriesTmp = CoResource.resources.Item.list({ type: 'category', 'parent_name': 'product-section', 'ignore-offset': 1}, function (){
				$scope.categories = $scope.categoriesTmp.result;		    

				$scope.data = CoResource.resources.Product.get({ productId: $routeParams.id}, function (){
					$scope.data = $scope.data.result;		 

					_.each($scope.categories, function (val, key){
						// get product section id
						var tmp = _.filter($scope.data.sections, function (v){
							return v.article_section.category_id == val.id;
						});
						$scope.categories[key].related_article = tmp && tmp[0] ? tmp[0] : null;

            			$rootScope.loading('hide');
					}); 
				});	
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
    		
  		};

	 	$scope.enterContent = function(item, ev) {
	 		if ($rootScope.loadingBarVisible){
	 			return;
	 		}
	 		if (item.name == 'solution-product-section'){
	 			// Go to solution product section
	 			$location.path('/solutions');
	 		}
	 		else{

	    		if (item.related_article){
	    			console.log(item.related_article);
	    			$location.path('/products/' + $routeParams.id + '/sections/' + item.id + '/articles/' + item.related_article.article_section.hash);
	    		}
	    		else{
	    			// Create new posts
	    			$location.path('/products/' + $routeParams.id + '/sections/' + item.id + '/articles/' + namespace.guid());
	    		}
	 		}
  		};

	});
}());