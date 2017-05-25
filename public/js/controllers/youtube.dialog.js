(function() {
    app.controller('YouTubeDialogCtrl', function($scope, CoResource, Upload, 
    	$rootScope, $mdDialog, $mdToast, $current, $data, $albums) {

    	$scope.data = {
    		storage_type: 'youtube',
    		album_id: 0,
    		caption: 'YouTube Video',
    		description: 'YouTube Video',
    		type: 'gallery',
    		seq_no: 0,
    		imagable_id: $data.imagable_id,
    		imagable_type: $data.imagable_type
    	};
    	$scope.mode = 'create';

    	if ($current){
    		$scope.data = angular.copy($current);
    		$scope.data.link = 'https://www.youtube.com/watch?v=' + $scope.data.file_name;
    		$scope.mode = 'edit';
    	}

    	$scope.albums = $albums || [];

    	$scope.toastPosition = {
	    	bottom: false,
	    	top: true,
	    	left: false,
	    	right: true
	  	};

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	  	$scope.getToastPosition = function() {
	    	return Object.keys($scope.toastPosition)
	      		.filter(function(pos) { return $scope.toastPosition[pos]; })
	      		.join(' ');
	  	};

	  	$scope.$watch('data.link', function (v){
	  		if (v){
	  			var video_id = v.split('v=')[1];
				var ampersandPosition = video_id.indexOf('&');
				if(ampersandPosition != -1) {
				  	video_id = video_id.substring(0, ampersandPosition);
				}
				$scope.data.path_name = v;
				$scope.data.file_name = video_id;
	  		}
	  		else{

	  		}
	  	});

    	$scope.save = function ($event){
    		$rootScope.loading('show');
    		console.log($scope.data);
    		if ($scope.mode === 'edit'){
	    		var current = CoResource.resources.Media.get({ mediaId: $scope.data.id }, function (){
	    			current.description = $scope.data.description;
	    			current.caption = $scope.data.caption;
	    			current.album_id = $scope.data.album_id;
	    			current.seq_no = $scope.data.seq_no;
	    			current.path_name = $scope.data.path_name;
	    			current.file_name = $scope.data.file_name;
	    			current.$update({ mediaId: $scope.data.id }, function (s){
	    				$rootScope.$emit('dataLinkUploaded', {
	    					data: s.result,
	    					mode: 'edit'
	    				});
	    				$rootScope.loading('hide');
						$mdToast.show(
					      	$mdToast.simple()
					        	.content('Media updated')
					        	.position($scope.getToastPosition())
					        	.hideDelay(3000)
					    );
	    			}, function (){
	    				$rootScope.loading('hide');
	    				alert('There was an error while trying to update media meta data');
	    			});
	    		});
    		}
    		else{

                var article = new CoResource.resources.Media($scope.data);
                article.$saveLink(function(s) {
                    $scope.data = s.result;
                    $rootScope.loading('hide');
                    $rootScope.$emit('dataLinkUploaded', {
    					data: s.result,
    					mode: 'create'
    				});
    				$rootScope.loading('hide');
					$mdToast.show(
				      	$mdToast.simple()
				        	.content('Media saved')
				        	.position($scope.getToastPosition())
				        	.hideDelay(3000)
				    );
                }, function(e) {
                    $rootScope.loading('hide');
                    alert('There was an error while trying to store link');
                });
    		}
    	};
    });
}());