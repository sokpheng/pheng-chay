(function() {
    app.controller('CollectionCtrl', function($scope, $timeout, $mdSidenav,
        $mdUtil, $log, $rootScope, MockService, $mdDialog, $routeParams, $location,
        $mdToast, CoResource, Upload) {
    	// $scope.parentName = "ArticleCtrl";


        if ($scope.$parent){
            $scope.parentName = $scope.$parent.parentName;
        }

        $scope.toastPosition = {
            bottom: false,
            top: true,
            left: false,
            right: true
        };

        $scope.getToastPosition = function() {
            return Object.keys($scope.toastPosition)
                .filter(function(pos) {
                    return $scope.toastPosition[pos];
                })
                .join(' ');
        };

        // Custom field

        $scope.status = {
            description: true
        };

        // $scope.categories = MockService.categories.list();
        // $scope.categories = CoResource.resources.Item.list({
        //     type: 'category',
        //     'offset-limitor': 0
        // }, function(s) {
        //     $scope.categories = $scope.categories.result;
        // });

        // $scope.types = MockService.types.list();

        $scope.data = {};
        $scope.mode = "create";
      

        if ($routeParams.id || $routeParams.hash) {
            // Load data from mock
            // $scope.data = MockService.posts.get($routeParams.id);
            $rootScope.loading('show');
            if (($routeParams.id || $routeParams.hash) && !$routeParams.locale) {
                $scope.data = CoResource.resources.Collection.get({
                    collectionId: $routeParams.id || $routeParams.hash
                }, function() {
                    if ($scope.data.result){

                        $scope.data = $scope.data.result;
                        $scope.data.seq_no = $scope.data.seq_no * 1;
						$rootScope.loading('hide');
                        $scope.mode = "edit";

                    }
                    else{

                        $scope.mode = "create";
                        $rootScope.loading('hide');
                    }            
                }, function() {                        
                    $scope.mode = "create";
                    $rootScope.loading('hide');
                });
            } 
        }

        $scope.save = function($event, callback) {
           
            $rootScope.loading('show');
            if ($scope.mode == 'edit') {
                // $scope.data.updated_time = new Date();
                // MockService.posts.update($scope.data);	
                CoResource.resources.Collection.update({
                    collectionId: $scope.data.id
                }, {
                    description: $scope.data.description,
                    title: $scope.data.title
                }, function(s) {

                    $rootScope.loading('hide');
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Collection updated')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to update your collection.');
                });
            } else if ($scope.mode == 'create') {
                // $scope.data.time = new Date();
                // $scope.data = MockService.posts.store($scope.data);	
                $scope.data.hash = $routeParams.hash;
                var collection = new CoResource.resources.Collection($scope.data);
                collection.$save(function(s) {
                    $scope.data = s.result;

                    $scope.mode = 'edit'
                    $rootScope.loading('hide');
                        
                    if (callback){
                        callback();
                    }
                    else{
                        var dialog =
                            $mdDialog.confirm()
                            .parent(angular.element(document.body))
                            .title('Collection Saved')
                            .content('Your collection has been saved')
                            .ariaLabel('Your collection has been saved')
                            .ok('Got it!')
                            .targetEvent($event);

                        $mdDialog.show(dialog).then(function() {
                            if (!$scope.parentName){
    
                                $location.path('/collections/' + $scope.data.hash);
                            }
                        });
                        
                    }
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to save your collection');
                });
            }
        };
        
        $scope.remove = function ($event){
            if ($scope.mode == 'edit') {
                var result = confirm("Are you sure to remove this collection?");
                if (!result){
                    return;
                }
                CoResource.resources.Collection.delete({
                    collectionId: $scope.data.id
                }, {}, function(s) {
                    $rootScope.loading('hide');

                    $location.path('/collections');
                    $mdToast.show(
                        $mdToast.simple()
                        .content('Collection has been deleted')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to delete your collection. Error: ' + e.result);
                });
            }
            else{
            }
        };

        // For articles
         function updatePagination(){
            var len  = (filterFilter($scope.data.articles || [], $scope.search)).length;
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