(function() {
    app.controller('MediaDialogCtrl', function($scope, CoResource, Upload, 
    	$rootScope, $mdDialog, $mdToast, $current, $albums) {

    	$scope.uploadingFile = {
    		src: '',
    		obj: null
    	};
    	$scope.data = {};
    	$scope.mode = 'create';
    	$scope.albums = $albums || [];

    	if ($current){
    		$scope.data = angular.copy($current);
            $scope.data.is_home_image = $scope.data.is_home_image == 1 ? true : false;
    		$scope.uploadingFile.src =  $scope.data.file_name;
    		$scope.uploadingFile.obj = {};
    		$scope.mode = 'edit';
    	}

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

    	$scope.chooseFile = function (files){
    		if (files.length > 0){
                var file = files[0];
                $scope.uploadingFile.src = window.URL.createObjectURL(file);
    			$scope.uploadingFile.obj = file;
    		}
    	};

    	$scope.save = function ($event){
    		$rootScope.loading('show');
    		var current = CoResource.resources.Media.get({ mediaId: $scope.data.id }, function (){
    			current.description = $scope.data.description;
    			current.caption = $scope.data.caption;
                current.album_id = $scope.data.album_id;
                current.seq_no = $scope.data.seq_no;
    			current.is_home_image = $scope.data.is_home_image;
                current.link = $scope.data.link;
    			current.$update({ mediaId: $scope.data.id }, function (){
    				$rootScope.$emit('dataMediaUploaded');
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
    	};

    	$scope.startUpload = function() {
            if (!$scope.uploadingFile.obj){
            	return;
            }
            $rootScope.loading('show');

            $scope.upload = Upload.upload({
                url: '/api/v1/media', // upload.php script, node.js route, or servlet url
                method: 'POST',
                //headers: {'Authorization': 'xxx'}, // only for html5
                //withCredentials: true,
                method: 'POST',
                headers: {
                }, // only for html5
                data: {
                    "caption": $scope.data.caption,
                    "description": $scope.data.description,
                    "imagable_type": "Media",
                    "imagable_id": 0,
                    "album_id": $scope.data.album_id,
                    "seq_no": $scope.data.seq_no,
                    "link": $scope.data.link,
                    "is_home_image": $scope.data.is_home_image,
                },
                file: $scope.uploadingFile.obj, // single file or a list of files. list is only for html5
                //fileName: 'doc.jpg' or ['1.jpg', '2.jpg', ...] // to modify the name of the file(s)
                //fileFormDataName: myFile, // file formData name ('Content-Disposition'), server side request form name
                // could be a list of names for multiple files (html5). Default is 'file'
                //formDataAppender: function(formData, key, val){}  // customize how data is added to the formData. 
                // See #40#issuecomment-28612000 for sample code
            }).progress(function(evt) {
                // console.log('progress: ' + parseInt(100.0 * evt.loaded / evt.total) + '% file :' + evt.config.file.name);
                evt.config.file.progress = parseInt(100.0 * evt.loaded / evt.total);
            }).success(function(data, status, headers, config) {
            	$rootScope.loading('hide');
            	$mdDialog.hide();

				$mdToast.show(
			      	$mdToast.simple()
			        	.content('File uploaded')
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );
			    $rootScope.$emit('dataMediaUploaded');
                
            }).error(function(data, status, headers, config) {
            	alert('There was an error while trying to upload file.');
            	console.log(data, status);
            	$rootScope.loading('hide');
            });
        };


        $scope.remove = function (media){
            // Appending dialog to document.body to cover sidenav in docs app
            if (media.imagable_type === 'Directory'){
                alert('Sorry, you cannot delete Directory\'s media gallery from here. Please, delete it at directory page');
                return;
            }
            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .title('Delete this gallery?')
                .content('Are sure to do so? Once you deleted, you won\'t be able to retrieve it back!')
                .ariaLabel('Delete Media')
                .ok('Yes')
                .cancel('No')
                .targetEvent(null);
            $mdDialog.show(confirm).then(function() {
                $rootScope.loading('show');
                CoResource.resources.Media.delete({
                    mediaId: media.id
                }, function (s){
                    $rootScope.loading('hide');
                    $rootScope.$emit('dataMediaUploaded');
                    $mdToast.show(
                        $mdToast.simple()
                            .content('Gallery removed')
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                    );
                }, function (e){
                    $rootScope.loading('hide');
                    alert('Sorry, this media cannot be deleted due to some reason, please contact administrator for more information');
                });
                
            }, function() {
            });
        };
        
    });
}());