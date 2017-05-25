(function (){
	app.controller('EnterpriseListingCtrl', function($scope, CoResource, 
		$routeParams, $rootScope, $mdDialog, $mdToast, $location){
		$scope.directories = [];
		$scope.getMapUrl = function(directory){
			var url = 'https://maps.googleapis.com/maps/api/staticmap?center=' + directory.latitude + ',' + directory.longitude +
				'&zoom=14&size=200x150&maptype=roadmap&markers=color:blue%7Clabel:E%7C' + directory.latitude + ',' + directory.longitude;
			return url;
		};

		$scope.view = function(directory){
			$location.path('enterprise-listing/' + directory.hash);
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
	    	offset: 0,
	    	current: 1
	    };

	    $scope.changePage = function(current){
	    	$scope.pagination.current = current;
	    };

	    $scope.preparePagination = function (){	    	
		    var amount = $scope.directories.length > $scope.pagination.limit ? Math.round($scope.directories.length / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });
	    };

	    $scope.changeOffset = function (offset){
	    	$scope.pagination.offset = offset;
	    };

		$scope.directories = CoResource.resources.Directory.list({
	    	'ignore-offset': 0
	    }, function(s) {
	    	$scope.directories = s.result;
	    	$scope.preparePagination();
	    	setTimeout(function (){
	    		renderMagnific();
	    	}, 2000);
	    });

		// $scope.directoriesTmp = CoResource.resources.Directory.categories({
	 //    }, function(s) {
	 //    	$scope.directoriesTmp = s.result;
	 //    });

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
			$scope.directories = CoResource.resources.Directory.list({
		    	'ignore-offset': 0,
		    	'q': $scope.search,
		    	'sort': $scope.sort
		    }, function(s) {
		    	$rootScope.loading('hide');
		    	$scope.directories = s.result;
		    	$scope.preparePagination();
		    	setTimeout(function (){
		    		renderMagnific();
		    	}, 2000);
		    }, function (e){
		    	$rootScope.loading('hide');
		    });
	    };

	    $scope.$watch('search', function (v){	    	
	    	$rootScope.loading('show');
			$scope.directories = CoResource.resources.Directory.list({
		    	'ignore-offset': 0,
		    	'q': $scope.search
		    }, function(s) {
		    	$rootScope.loading('hide');
		    	$scope.directories = s.result;
		    	$scope.preparePagination();
		    	setTimeout(function (){
		    		renderMagnific();
		    	}, 2000);
		    }, function (e){
		    	$rootScope.loading('hide');
		    });
	    });
	});


}());