(function (){
	app.controller('MediaCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, $mdDialog, MockService, $rootScope, CoResource){	     
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

	 	$scope.data = {};

	 	function loadData(){
	 		$scope.media = CoResource.resources.Media.list({ limiter: 'off', type: 'media', album: $scope.data.album }, function (){
	 			$scope.media = $scope.media.result;
	 			// Group media
	 			$scope.mediaGroups = _.groupBy($scope.media, function (v){
	 				return v.album_id;
	 			});
	 			var tmp = [];
	 			_.each($scope.mediaGroups, function (v){
	 				tmp.push({
	 					group: v[0].album || { id: '', display_name: ''},
	 					media: v
	 				})
	 			});
	 			$scope.mediaGroups = tmp;
	 		});
	 	}

	 	$scope.$watch('data.album', function (v){
	 		if (v){
	 			loadData();
	 		}
	 	});

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
				controller: 'MediaDialogCtrl',
				templateUrl: '/templates/upload-media',
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

        $scope.addYoutubeLink = function(object, ev) {
            if ($scope.mode === 'create'){
                return;
            }
            $mdDialog.show({
                controller: 'YouTubeDialogCtrl',
                templateUrl: '/templates/youtube-link',
                parent: angular.element(document.body),
                targetEvent: ev,
                locals: {
                    $current: object,
					$albums: $scope.albums,
                    $data: {
                        imagable_type: 'Media',
                        imagable_id: 0
                    }
                }
            })
            .then(function(answer) {
                $scope.alert = 'You said the information was "' + answer + '".';
            }, function() {
                $scope.alert = 'You cancelled the dialog.';
            });
        };

  		$scope.editMedia = function(media, ev){
  			
  			if (media.storage_type != 'local'){
  				return $scope.addYoutubeLink(media, ev);
  			}
  			$mdDialog.show({
				controller: 'MediaDialogCtrl',
				templateUrl: '/templates/upload-media',
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
	});
}());