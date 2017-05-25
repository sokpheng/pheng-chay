(function() {
    app.controller('ArticleListCtrl', function($scope, $timeout, $mdSidenav,
        $mdUtil, $log, $rootScope, MockService, $mdDialog, $routeParams, $location,
        $mdToast, CoResource, filterFilter) {

	    $scope.posts = [];

	    // $scope.posts = MockService.posts.list();
	    var posts = CoResource.resources.Article.list({
	    	'ignore-offset': 1,
	    	'type-name': 'news-type'
	    }, function (){
	    	$scope.posts = posts.result;
	    	updatePagination();
	    	setTimeout(function (){
	    		renderMagnific();
	    	}, 2000);
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
	    	if (item.hash){
	    		$location.path('/articles/' + item.hash);	
	    	}	    	
	    };

	    // Pagination
	    $scope.pagination = {
	    	limit: 10,
	    	current: 0,
	    	offset: 0
	    };
	    $scope.changeOffset = function (offset){
	    	$scope.pagination.current = offset;
	    };


	    // Manific
	    function renderMagnific(){
	        $('.mini-gallery-list .gallery-item.photo').magnificPopup({
	            type: 'image',
	            removalDelay: 300,
	            mainClass: 'mfp-with-zoom',
	            // delegate: 'li.gallery-item', // the selector for gallery item,
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

            $('.mini-gallery-list .gallery-item.youtube').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-with-zoom',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
                callbacks: {
                    open: function() {
                    },
                    close: function() {
                        this.wrap.removeClass('mfp-image-loaded');
                    },
                },
                // delegate: 'li.gallery-item', // the selector for gallery item,
            });
	    }

    });
}());