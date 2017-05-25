(function (){
	app.controller('SliderCreateCtrl', function($scope, uiGmapGoogleMapApi,
		CoResource, $routeParams, $rootScope, $mdDialog, $mdToast, Upload, $timeout, $location){

		$scope._id = $routeParams.id;
		$scope.toastPosition = {
	    	bottom: false,
	    	top: true,
	    	left: false,
	    	right: true
	  	};

	  	$scope.getToastPosition = function() {
	    	return Object.keys($scope.toastPosition)
	      		.filter(function(pos) { return $scope.toastPosition[pos]; })
	      		.join(' ');
	  	};
		// Get data
		$rootScope.loading('hide');
		$scope.loading = false;
		$scope.selected = [];
		$scope.data = {};
		$scope.data.gallery = [];
		$scope.mode = 'edit';
		
		// Load slider gallery 

	    function loadData(callback, offset, limit){
	    	limit = limit || 10;
			CoResource.resources.Slider.list({
		    	'ignore-offset': 0,
		    	// 'directory': $routeParams.shop || null,
		    	// 'search': $scope.search || '',
		    	'sort': '-created_at',
		    	// 'scope': 'foods,origins,categories,features,menu,drinks,payment_methods,parkings',
		    }, function(s) {
		    	$scope.data.gallery = s.result;
		    	// setTimeout(function (){
		    	// 	renderMagnific();
		    	// }, 2000);

		    	if (callback){
		    		callback();
		    	}
		    });
	    }

	    loadData();

	
    	$scope.uploadingFile = {
    		src: '',
    		obj: null
    	};

    	$scope.pendingUploads = [];
    	$scope.savePendingUploads = function ()
    	{

    		_.each($scope.pendingUploads, function (v, k){
    			v.loading = true;
    			if (v.type == 'logo'){
		    		$scope.chooseFile(v, function (data){
		            	$scope.uploadingFile.loading = false;
		            	var result = data.result;
		            	$scope.data.logo_id = result.id;
		            	$scope.submit(true);
		            	$rootScope.loading('hide');
		            	$mdDialog.hide();
		            	$scope.data.logo = result;
		    		});
    			}
    			else{
	    			$scope.chooseFile($scope.pendingUploads[k], function (data, file){
	    				$scope.data.photos = $scope.data.photos || [];
	    				$scope.data.photos.push(data.result);
	    				for(var i = $scope.pendingFiles.length - 1; i >= 0; i--){
	    					if (file.id === $scope.pendingFiles[i].id){
	    						$scope.pendingFiles.splice(i, 1);
	    					}
	    				}
	    				setTimeout(function (){
			        		renderMagnific();
			        	}, 200);
	    			});
    			}
    		});
    		$scope.pendingUploads = [];
    	};

    	$scope.uploadLogo = function (files){
    		if (!files.length){
    			return;
    		}
    		$scope.uploadingFile = {
    			file: files[0],
    			type: 'logo',
    			src: window.URL.createObjectURL(files[0])
    		};
    		if ($scope.mode === 'create'){
    			$scope.pendingUploads = _.filter($scope.pendingUploads, function (v){
    				return v.type != 'logo';
    			});
	    		$scope.pendingUploads.push($scope.uploadingFile);
    		}
    		else{
    			$scope.uploadingFile.loading = true;
	    		$scope.chooseFile($scope.uploadingFile, function (data){
	            	$scope.uploadingFile.loading = false;
	            	$scope.uploadingFile.src = false;
	            	var result = data.result;
	            	$scope.data.logo_id = result.id;
	            	$scope.submit(true);
	            	$rootScope.loading('hide');
	            	$mdDialog.hide();
	            	$timeout(function() {
	            		$scope.data.logo = result;
	            	}, 6000);

	    		});
    		}
    	};

    	$scope.pendingFiles = [];
    	$scope.uploadMedia = function (files){
    		_.each(files, function (v, k){
    			var file = {
    				file: files[k],
    				id: namespace.guid(),
    				type: 'gallery',
    				src: window.URL.createObjectURL(v)
    			};
    			$scope.pendingFiles.push(file);
    			if ($scope.mode === 'create'){
    				$scope.pendingUploads.push(file);
    			}
    			else{
    				file.loading = true;
	    			$scope.chooseFile(file, function (data, file){
	    				$scope.data.photos = $scope.data.photos || [];
	    				$scope.data.photos.push(data.result);
	    				for(var i = $scope.pendingFiles.length - 1; i >= 0; i--){
	    					if (file.id === $scope.pendingFiles[i].id){
	    						$scope.pendingFiles.splice(i, 1);
	    					}
	    				}
	    				setTimeout(function (){
			        		renderMagnific();
			        	}, 200);
	    			});
    			}
    		});
    	};

  		$scope.editMedia = function(media, ev){
  			
  			$mdDialog.show({
				controller: 'SliderUpdateDialogCtrl',
				templateUrl: '/templates/customs.sliders.update',
				parent: angular.element(document.body),
				targetEvent: ev,
				locals: {
					
					$current: media
				}
    		})
    		.then(function(answer) {
      			$scope.alert = 'You said the information was "' + answer + '".';
			}, function() {
      			$scope.alert = 'You cancelled the dialog.';
    		});
  		};

    	$scope.chooseFile = function (filetmp, callback){

			filetmp.loading = true;
			$rootScope.loading('show');

			var url = $rootScope.remoteUrl + '/admin/sliders';

			// console.log(url);
			// return;

            $scope.upload = Upload.upload({
                url: url,
                method: 'POST',
                //headers: {'Authorization': 'xxx'}, // only for html5
                //withCredentials: true,
                method: 'POST',
                headers: {
                }, // only for html5
                data: {
                	// upload_session_key: namespace.guid()
                },
                file: filetmp.file,
            }).progress(function(evt) {
                // evt.config.file.progress = parseInt(100.0 * evt.loaded / evt.total);
                filetmp.progress = parseInt(100.0 * evt.loaded / evt.total);
            }).success(function(data, status, headers, config) {
            	if (callback){
            		callback(data, filetmp);
            	}

				$rootScope.loading('hide');
				$mdToast.show(
			      	$mdToast.simple()
			        	.content('File uploaded')
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );

			    if (filetmp.type == 'gallery'){
			    	$scope.data.gallery = $scope.data.gallery || [];
			    	data.result.thumbnail_url_link = filetmp.src;
			    	$scope.data.gallery.unshift(data.result);
			    }
			    else if (filetmp.type == 'logo'){

			    }

            }).error(function(data, status, headers, config) {
            	alert('There was an error while trying to upload file.');
            	console.log(data, status);
            	$scope.uploadingFile.loading = false;
            	$rootScope.loading('hide');
            });
    	};

	    // Manific
	    function renderMagnific(){
	        $('.media-gallery .media.uploaded').magnificPopup({
	            type: 'image',
	            removalDelay: 300,
	            mainClass: 'mfp-with-zoom',
	            delegate: 'span.icon-search', // the selector for gallery item,
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

	    $scope.deletePendingPhoto = function (item){
	    	for(var i = $scope.pendingFiles.length - 1; i >= 0; i--){
				if (item.id === $scope.pendingFiles.id){
					$scope.pendingFiles.splice(i, 1);
				}
			}
	    };

        $scope.deletePhoto = function (item, ev){
            // Appending dialog to document.body to cover sidenav in docs app
            if (!item){
                return;
            }
            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .title('Delete this gallery?')
                .content('Are sure to do so? Once you deleted, you won\'t be able to retrieve it back!')
                .ariaLabel('Delete Media')
                .ok('Yes')
                .cancel('No')
                .targetEvent(ev);
            $mdDialog.show(confirm).then(function() {
                $rootScope.loading('show');
                CoResource.resources.Media.delete({
                	mediaId: item._id
                }, function (s){
                	$rootScope.loading('hide');
                	for(var i = $scope.data.gallery.length - 1; i >= 0; i--){
    					if (item._id === $scope.data.gallery[i]._id){
    						$scope.data.gallery.splice(i, 1);
    					}
    				}
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


        $(function() {

            $('#pac-input').keydown(function(e) {
                e.stopPropagation();
            });
        });

       
	});
}());
