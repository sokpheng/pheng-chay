(function (){
	app.controller('CouponListingCtrl', ['$scope', '$timeout', '$mdSidenav',
		'$mdUtil', '$log', 'MockService', '$location', '$mdDialog', '$rootScope', 'CoResource',
		'$mdToast', 'filterFilter', '$routeParams', function($scope, $timeout, $mdSidenav,
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, CoResource,
		$mdToast, filterFilter, $routeParams){

	 	$scope.items = [];
	 	$scope.type_name = $rootScope.type_names[$routeParams.type];
	 	$scope.selected = [];
		$scope.coupon_type = location.href.indexOf('promotions') != -1 ? 'promotions' : 'coupons';

	 	$scope.shopId = $routeParams.shop;

	    
	    // Pagination
	    $scope.pagination = {
	    	limit: 15,
	    	offset: $location.search().offset || 1,
	    	current: 1
	    };

	    $scope.changePage = function(current){
	    	$scope.pagination.current = current;
	    };

	    $scope.preparePagination = function (){	    	
		    var amount = $scope.pagination.total_record > $scope.pagination.limit ? Math.round($scope.pagination.total_record / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });
	    };

	    $scope.changeOffset = function (offset){
	    	$scope.pagination.offset = offset;
	    };

	    function loadData(callback, offset, limit){
	    	offset = offset || $scope.pagination.offset;
	    	limit = limit || 10;
	    	console.log('load data');
			CoResource.resources.Coupon.list({
				'offset': (offset - 1) * limit || 0,
				'limit': limit || 10,
		    	'ignore-offset': 0,
		    	'directory': $routeParams.shop || null,
		    	// 'search': $scope.search.query || '',
		    	'sort': '-created_at',
		    	'coupon_type': $scope.coupon_type,
		    	// 'scope': 'foods,origins,categories,features,menu,drinks,payment_methods,parkings',
		    }, function(s) {
		    	$scope.listing = s.result;
		    	$scope.pagination.total_record = s.options.total;
		    	$scope.preparePagination();
		    	// setTimeout(function (){
		    	// 	renderMagnific();
		    	// }, 2000);

		    	if (callback){
		    		callback();
		    	}
		    });
	    }

	    $scope.viewDetail = function (item){
	    	$location.path('coupons/' + item.directory._id + '/' + item._id);
	    };

	    loadData();

	    $scope.onPageChanged = function (){
	    	$location.search('offset', $scope.pagination.offset);
	  //   	$rootScope.loading('show');
			// loadData(function (){
			// 	$rootScope.loading('hide');
			// }, $scope.pagination.offset, 10);
	    };

		$scope.sort = '';
	    $scope.changeSort = function (){
	    	if ($scope.sort == ''){
	    		$scope.sort = 'desc';
	    	}
	    	else if ($scope.sort == 'desc'){
	    		$scope.sort = 'asc';
	    	}
	    	else{
	    		$scope.sort = '';
	    	}

	    	$rootScope.loading('show');
	    	loadData(function (){
		    	$rootScope.loading('hide');
	    	});

	    };

	    $scope.$watch('search.query', function (v, old){	
			if (v == old){
				return;
			}    	
	    	// $rootScope.loading('show');

	    	// loadData(function (){
		    // 	$rootScope.loading('hide');
	    	// });
	    	$location.search('search', v);
	    });

	    var timer = null;
	    function startCalling(){
	    	if (timer){
	    		$timeout.cancel(timer);
	    	}
	    	timer = $timeout(function (){

		    	$rootScope.loading('show');

		    	loadData(function (){
			    	$rootScope.loading('hide');
		    	});
	    	}, 700);

	    }

	    /* EVENT WATCHERS */

		var watchers = {};
		watchers['search'] = $scope.$watch(function() {
			return $location.search().search;
		}, function(v, old) {

			if (v == old){
				return;
			}

			$scope.search.query = v;
			startCalling();
		});

		watchers['offset'] = $scope.$watch(function() {
			return $location.search().offset;
		}, function(v, old) {

			if (v == old){
				return;
			}

			$scope.pagination.offset = v;
			startCalling();
		});

		$scope.createCoupon = function (){
			if (!$routeParams.shop){
				return;
			}
			$location.path('coupons/' + $routeParams.shop + '/create');
		};

		$scope.$on('$destroy', function (){
			for(var key in watchers){
				watchers[key]();
			}
			$location.search('offset', null);
			$location.search('search', null);
		});


	}]);
}());
