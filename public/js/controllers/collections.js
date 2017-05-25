(function() {
    app.controller('CollectionListCtrl', function($scope, $timeout, $mdSidenav,
        $mdUtil, $log, $rootScope, MockService, $mdDialog, $routeParams, $location,
        $mdToast, CoResource, Upload, filterFilter ) {
    	// $scope.parentName = "ArticleCtrl";

    	// $scope.collections = [{
    	// 	hash: '123',
    	// 	created_at: '2015-05-05 01:00:00',
    	// 	status: 'published',
    	// 	url: 'https://www.facebook.com/',
    	// 	title: 'Collection #1',
    	// 	description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    	// 	articles: [1, 2, 3]
    	// }, {
    	// 	hash: '234',
    	// 	created_at: '2015-05-05 01:00:00',
    	// 	status: 'published',
    	// 	url: 'https://www.facebook.com/',
    	// 	title: 'Collection #2',
    	// 	description: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
    	// 	articles: [1, 2, 3, 4]
    	// }];

        CoResource.resources.Collection.list({
            'ignore-offset': 1
        }, function (data){
            $scope.collections = data.result;
            updatePagination();
        });

        function updatePagination(){
            var len  = (filterFilter($scope.collections || [], $scope.search)).length;
            var amount = len > $scope.pagination.limit ? Math.ceil(len / $scope.pagination.limit) : 0;

            $scope.pagination.total = _.map(new Array(amount), function (value, key){
                return key + 1;
            });
        }  

        // Pagination
        $scope.pagination = {
            limit: 10,
            current: 0,
            offset: 0
        };
        $scope.changeOffset = function (offset){
            $scope.pagination.current = offset;
        };


		$scope.create = function (){
			$location.path('/collections/' + namespace.guid());
		};

		$scope.edit = function (collection){
			$location.path('/collections/' + collection.hash);
		};
    });
}());