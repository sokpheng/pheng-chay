(function (){
	app.controller('FileCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, $mdDialog, MockService, $rootScope, CoResource, filterFilter){	     
	 	$scope.media = [];
	 	// $scope.albums = MockService.albums.list() || [];
	 	$scope.albums = CoResource.resources.Item.list({ type: 'album' }, function (){
	 		$scope.albums = $scope.albums.result;
	 	});

	 	$rootScope.$on('dataAlbumSaved', function (){
	 		$scope.albums = CoResource.resources.Item.list({ type: 'album' }, function (){
		 		$scope.albums = $scope.albums.result;
		 	});
	 		if (!$scope.$$phase){
	 			$scope.$apply();
	 		}
	 	});

	 	$scope.files = [];

	 	function loadData(){
	 		var files = CoResource.resources.Media.list({ 
	 			limiter: 'off', 
	 			type: 'document', 
	 			album: $scope.data && $scope.data.album_id ? $scope.data.album_id : null  
	 		}, function (){
	 			$scope.files = files.result;
	 			updatePagination();
	 		});
	 	}

	 	loadData();

	 	$rootScope.$on('dataMediaUploaded', function (){
	 		loadData();

	 		if (!$scope.$$phase){
	 			$scope.$apply();
	 		}
	 	});

	 	$scope.showAdvanced = function(ev) {
    		$mdDialog.show({
				controller: 'AlbumDialogCtrl',
				templateUrl: '/templates/new-album',
				parent: angular.element(document.body),
				targetEvent: ev,
    		})
    		.then(function(answer) {
      			$scope.alert = 'You said the information was "' + answer + '".';
			}, function() {
      			$scope.alert = 'You cancelled the dialog.';
    		});
  		};


	 	$scope.uploadFile = function(ev) {
    		$mdDialog.show({
				controller: 'FileDialogCtrl',
				templateUrl: '/templates/customs.upload-file',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$albums: $scope.albums,
					$current: null
				}
    		})
    		.then(function(answer) {
      			$scope.alert = 'You said the information was "' + answer + '".';
			}, function() {
      			$scope.alert = 'You cancelled the dialog.';
    		});
  		};


        $rootScope.$on('dataLinkUploaded', function ($e, data){
            loadData();
	 		if (!$scope.$$phase){
	 			$scope.$apply();
	 		}
        });

  		$scope.editMedia = function(media, ev){
  			
  			$mdDialog.show({
				controller: 'FileDialogCtrl',
				templateUrl: '/templates/customs.upload-file',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					$albums: $scope.albums,
					$current: media
				}
    		})
    		.then(function(answer) {
      			$scope.alert = 'You said the information was "' + answer + '".';
			}, function() {
      			$scope.alert = 'You cancelled the dialog.';
    		});
  		};


	    function updatePagination(){

	    	var len  = (filterFilter($scope.posts || [], $scope.search)).length;
		    var amount = len > $scope.pagination.limit ? Math.ceil(len / $scope.pagination.limit) : 0;

		    $scope.pagination.total = _.map(new Array(amount), function (value, key){
		    	return key + 1;
		    });
	    }

	    $scope.$watch('search', updatePagination);

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