(function (){
	app.controller('ShopSeqListingCtrl', function($scope, CoResource, 
		$routeParams, $rootScope, $mdDialog, $mdToast, $location, $timeout){
		$scope.directories = [];

		$scope.search = {
			query: $location.search().search || '',
			filter: $location.search().filter || '',
			sort: $location.search().sort || '',
		};

		$scope.getMapUrl = function(directory){
			var url = 'https://maps.googleapis.com/maps/api/staticmap?key=AIzaSyCrP9rxOqS4yAxtd-3cT9kJTYnO5fpnJoY&center=' + (directory.latitude || '13.3671') + ',' + (directory.longitude || '103.8448') +
				'&zoom=14&size=200x150&maptype=roadmap&markers=color:blue%7Clabel:E%7C' + (directory.latitude || '13.3671') + ',' + (directory.longitude || '103.8448');
			return url;
		};

		$scope.view = function(directory){
			$location.path('shops/' + directory._id);
		};	

		$scope.createShop = function(directory){
			$location.path('shops/create');
		};	


	    // Manific
	    function renderMagnific(){
	        $('.mini-gallery-list').magnificPopup({
	            type: 'image',
	            removalDelay: 300,
	            mainClass: 'mfp-with-zoom',
	            delegate: 'li.gallery-item', // the selector for gallery item,
	            titleSrc: 'title',
	            tLoading: '',
	            gallery: {
	                enabled: true
	            },
	            callbacks: {
	                imageLoadComplete: function() {
	                    var self = this;
	                    setTimeout(function() {
	                        self.wrap.addClass('mfp-image-loaded');
	                    }, 16);
	                },
	                open: function() {
	                    // $('#header > nav').css('padding-right', getScrollBarWidth() + "px");
	                },
	                close: function() {
	                    this.wrap.removeClass('mfp-image-loaded');
	                    // $('#header > nav').css('padding-right', "0px");
	                },
	            }
	        });
	    }

		
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
			$scope.directories = CoResource.resources.Directory.list({
				'offset': (offset - 1) * limit || 0,
				'limit': limit || 10,
		    	'ignore-offset': 0,
		    	'search': $scope.search.query || '',
		    	'filters': $scope.search.filter || '',
		    	'sorts': $scope.search.sort || 'seq_number', // $scope.sort || '',
		    	'scope': 'foods,origins,categories,features,menu,drinks,payment_methods,parkings',
		    }, function(s) {
		    	$scope.directories = s.result;
		    	$scope.pagination.total_record = s.options.total;
		    	$scope.preparePagination();
		    	setTimeout(function (){
		    		renderMagnific();
		    	}, 2000);

		    	if (callback){
		    		callback();
		    	}
		    });
	    }

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

	    $scope.$watch('search.filter', function (v, old){	
			if (v == old){
				return;
			}    	
			console.log(v, old);
	    	// $rootScope.loading('show');

	    	// loadData(function (){
		    // 	$rootScope.loading('hide');
	    	// });
	    	$location.search('filter', v);
	    });

	    $scope.$watch('search.sort', function (v, old){	
			if (v == old){
				return;
			}    	
	    	// $rootScope.loading('show');

	    	// loadData(function (){
		    // 	$rootScope.loading('hide');
	    	// });
	    	$location.search('sort', v);
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

		watchers['filter'] = $scope.$watch(function() {
			return $location.search().filter;
		}, function(v, old) {

			if (v == old){
				return;
			}

			$scope.search.filter = v;
			startCalling();
		});

		watchers['sort'] = $scope.$watch(function() {
			return $location.search().sort;
		}, function(v, old) {

			if (v == old){
				return;
			}

			$scope.search.sort = v;
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

		$scope.$on('$destroy', function (){
			for(var key in watchers){
				watchers[key]();
			}
			$location.search('offset', null);
			$location.search('search', null);
		});

	});



		/***********************/
		/****** declaration ****/
		/***********************/

		/***********************/
		/* init function call **/
		/***********************/

			
	  	/***********************/
		/**** scope function ***/
		/***********************/

		/***********************/
		/******  functions *****/
		/***********************/



}());