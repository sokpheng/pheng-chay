(function (){
	app.controller('AdvertisementCreateCtrl', function($scope, uiGmapGoogleMapApi,
		CoResource, $routeParams, $rootScope, $mdDialog, $mdToast, Upload, $timeout, $location, $q){

		$scope.shop = $routeParams.shop;
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
		$rootScope.loading('show');
		$scope.loading = true;
		$scope.selected = [];
		$scope.data = {};
		$scope.mode = 'create';	

		console.log($scope._id);
		
		$scope.data = CoResource.resources.Advertisement
			.get({ advertisementId: $scope._id || 'NO_DATA' }, function (s){
				// $scope.loading = false;
				$scope.data = s.result || {};

				$scope.mode =  s.result && s.result._id ? 'edit' : 'create';	

				// $scope.data.directory_name = $scope.shop.directory_name;
				// $scope.data.directory = $scope.shop._id;

				$rootScope.loading('hide');
				$scope.loading = false;

			}, function (f){
				$rootScope.loading('hide');
				$scope.loading = false;
			});

	
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

    	$scope.chooseFile = function (filetmp, callback){

			filetmp.loading = true;
			$rootScope.loading('show');

			var url = $rootScope.remoteUrl + '/admin/marketing-verses/' + $scope.data._id + '/' + (filetmp.type == 'logo' ? 'logo' : 'galleries');

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
			    	// $scope.data.gallery = $scope.data.gallery || [];
			    	// data.result.thumbnail_url_link = filetmp.src;
			    	// $scope.data.gallery.unshift(data.result);
			    }
			    else if (filetmp.type == 'logo'){
			    	// data.result.thumbnail_url_link = filetmp.src;
			    	// $(function() {
			    	// 	$scope.data.logo = data.result;
			    	// }, 3000);

			    }

            }).error(function(data, status, headers, config) {
            	alert('There was an error while trying to upload file.');
            	console.log(data, status);
            	$scope.uploadingFile.loading = false;
            	$rootScope.loading('hide');
            });
    	};

	    $scope.submit = function (hideDialog){

	    	$rootScope.loading('show');

	    	if ($scope.mode === 'create'){
	    		// $scope.data.hash = $scope.hash;

	 			var item = new CoResource.resources.Advertisement($scope.data);
	 			item.$save(function (s, h){
	 				$scope.data = s.result;
	 				$scope.mode = 'edit';
	 				$rootScope.loading('hide');
	 				$scope.savePendingUploads();
	 				if (!hideDialog){
	 					return $mdDialog.show(
			      			$mdDialog.alert()
						        .parent(angular.element(document.body))
						        .title('Create Advertisement Listing')
						        .content('Advertisement listing is successfully created')
						        .ariaLabel('Create Advertisement Listing')
						        .ok('Got it!')
						)
		                .then(function(answer) {
		                    $location.path('advertisements/' + $scope.data._id);
		                }, function() {
		                    $location.path('advertisements/' + $scope.data._id);
		                });
	 				}
	 			}, function (f){
 					$rootScope.loading('hide');
 					$scope.savePendingUploads();
 					if (!hideDialog){
	 					return $mdDialog.show(
			      			$mdDialog.alert()
						        .parent(angular.element(document.body))
						        .title('Create Advertisement Listing')
						        .content('There was an error while creating shop listing. ' + CoResource.textifyError(f.data))
						        .ariaLabel('Create Advertisement Listing')
						        .ok('Got it!')
					    );
	 				}
 				});

	    	}
	    	else{

	    		var advertisement = new CoResource.resources.Advertisement.update({
	 				advertisementId: $scope.data._id
	 			}, $scope.data, function(){
	 				// advertisement = _.extend(advertisement, $scope.data);
	 				// advertisement.$update({advertisementId: $scope.data._id}, function (s, h){

	 				$rootScope.loading('hide');
	 				if (hideDialog){
						return $mdToast.show(
					      	$mdToast.simple()
					        	.content('Advertisement updated')
					        	.position($scope.getToastPosition())
					        	.hideDelay(3000)
					    );
	 				}
 					return $mdDialog.show(
		      			$mdDialog.alert()
					        .parent(angular.element(document.body))
					        .title('Update Advertisement Listing')
					        .content('Advertisement listing is successfully updated')
					        .ariaLabel('Update Shop Listing')
					        .ok('Got it!')
					    );
 				}, function (e){
 					$rootScope.loading('hide');
 					// fail(CoResource.textifyError(e.data));

	      			return $mdDialog.show(
		      			$mdDialog.alert()
					        .parent(angular.element(document.body))
					        .title('Error Update Advertisement Listing')
					        .content(CoResource.textifyError(e.data))
					        .ariaLabel('Update Advertisement Listing')
					        .ok('Got it!')
					    );
 				});
	 			// }, function (e){
 				// 	$rootScope.loading('hide');
 				// 	return $mdDialog.show(
		   //    			$mdDialog.alert()
					//         .parent(angular.element(document.body))
					//         .title('Update Shop Listing')
					//         .content('There was an error while updating advertisement listing. ' + CoResource.textifyError(e.data))
					//         .ariaLabel('Update Shop Listing')
					//         .ok('Got it!')
					//     );
 				// });
	    	}
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

	  //   $scope.deletePendingPhoto = function (item){
	  //   	for(var i = $scope.pendingFiles.length - 1; i >= 0; i--){
			// 	if (item.id === $scope.pendingFiles.id){
			// 		$scope.pendingFiles.splice(i, 1);
			// 	}
			// }
	  //   };

   //      $scope.deletePhoto = function (item, ev){
   //          // Appending dialog to document.body to cover sidenav in docs app
   //          if (!item){
   //              return;
   //          }
   //          var confirm = $mdDialog.confirm()
   //              .parent(angular.element(document.body))
   //              .title('Delete this gallery?')
   //              .content('Are sure to do so? Once you deleted, you won\'t be able to retrieve it back!')
   //              .ariaLabel('Delete Media')
   //              .ok('Yes')
   //              .cancel('No')
   //              .targetEvent(ev);
   //          $mdDialog.show(confirm).then(function() {
   //              $rootScope.loading('show');
   //              CoResource.resources.Media.delete({
   //              	mediaId: item._id
   //              }, function (s){
   //              	$rootScope.loading('hide');
   //              	for(var i = $scope.data.gallery.length - 1; i >= 0; i--){
   //  					if (item._id === $scope.data.gallery[i]._id){
   //  						$scope.data.gallery.splice(i, 1);
   //  					}
   //  				}
   //              	$mdToast.show(
   //                      $mdToast.simple()
   //                          .content('Gallery removed')
   //                          .position($scope.getToastPosition())
   //                          .hideDelay(3000)
   //                  );
   //              }, function (e){
   //              	$rootScope.loading('hide');
   //              	alert('Sorry, this media cannot be deleted due to some reason, please contact administrator for more information');
   //              });

   //          }, function() {
   //          });
   //      };

   //      $scope.updateCover = function (item, ev){
   //          // Appending dialog to document.body to cover sidenav in docs app
   //          if (!item || item._id == $scope.data.cover_media){
   //              return;
   //          }
   //          var confirm = $mdDialog.confirm()
   //              .parent(angular.element(document.body))
   //              .title('Set this gallery as cover?')
   //              .content('Are sure to do set this image as shop cover?')
   //              .ariaLabel('Set Cover')
   //              .ok('Yes')
   //              .cancel('No')
   //              .targetEvent(ev);
   //          $mdDialog.show(confirm).then(function() {
   //              $rootScope.loading('show');
   //              CoResource.resources.Directory.setCover({
   //              	directoryId: $scope.data._id
   //              }, {
			// 		cover_media: item._id
			// 	}, function (s){
   //              	$rootScope.loading('hide');
			// 		$scope.data.cover_media = item._id;

   //              	$mdToast.show(
   //                      $mdToast.simple()
   //                          .content('Cover set')
   //                          .position($scope.getToastPosition())
   //                          .hideDelay(3000)
   //                  );
   //              }, function (e){
   //              	$rootScope.loading('hide');
   //              	alert('Sorry, this media cannot be set due to some reason, please contact administrator for more information');
   //              });

   //          }, function() {
   //          });
   //      };

		/* START: Update shop listing  */

  		// $scope.edit = function($event){
  		// 	if ($scope.selected.length == 1){
				// $scope.editDimension($scope.selected[0], $event);
  		// 	}
  		// };

  // 		$scope.editDimension = function (item, ev){
  // 			item.set_range_price = true;
  // 			$mdDialog.show({
		// 		controller: 'DimensionDetailDialogCtrl',
		// 		templateUrl: '/templates/customs.dimensions.create',
		// 		parent: angular.element(document.body),
		// 		targetEvent: ev,
		// 		locals: {
		// 			$current: item
		// 		}
  //   		})
  //   		.then(function(answer) {

		// 	}, function() {

  //   		});
  // 		};

		// $rootScope.$on('dataDimensionDetailSaved', function (){
		// 	$scope.loadDimensionDetailInfo();
		// });

		$scope.delete = function ($event){
			if ($scope.data._id){

				var confirm = $mdDialog.confirm()
	                .parent(angular.element(document.body))
	                .title('Remove advertisement?')
	                .content('Are sure to remove this advertisement? You cannot undo after you delete it')
	                .ariaLabel('Remove advertisement')
	                .ok('Yes')
	                .cancel('No')
	                .targetEvent($event);
	            $mdDialog.show(confirm).then(function() {
	                $rootScope.loading('show');
	                CoResource.resources.Advertisement.delete({
	                	advertisementId: $scope.data._id
	                }, {}, function (s){
	                	$rootScope.loading('hide');
						$location.path('/');
	                }, function (e){
	                	$rootScope.loading('hide');
	                	alert('Sorry, this advertisement cannot be set due to some reason, please contact administrator for more information');
	                });

	            }, function() {
	            });
			}
		};

		$scope.publish = function ($event){
			if ($scope.data._id){

				var confirm = $mdDialog.confirm()
	                .parent(angular.element(document.body))
	                .title('Publish advertisement?')
	                .content('Are sure to publish this advertisement?')
	                .ariaLabel('Publish advertisement')
	                .ok('Yes')
	                .cancel('No')
	                .targetEvent($event);
	            $mdDialog.show(confirm).then(function() {
	                $rootScope.loading('show');
	                CoResource.resources.Advertisement.publish({
	                	advertisementId: $scope.data._id
	                }, {}, function (s){
	                	$rootScope.loading('hide');
	                	$scope.data.status = 'published';
						// $location.path('/');
	                }, function (e){
	                	$rootScope.loading('hide');
	                	alert('Sorry, this advertisement cannot be published due to some reason, please contact administrator for more information');
	                });

	            }, function() {
	            });
			}
		};

		$scope.unpublish = function ($event){
			if ($scope.data._id){

				var confirm = $mdDialog.confirm()
	                .parent(angular.element(document.body))
	                .title('Unpublish advertisement?')
	                .content('Are sure to unpublish this advertisement?')
	                .ariaLabel('Unpublish advertisement')
	                .ok('Yes')
	                .cancel('No')
	                .targetEvent($event);
	            $mdDialog.show(confirm).then(function() {
	                $rootScope.loading('show');
	                CoResource.resources.Advertisement.unpublish({
	                	advertisementId: $scope.data._id
	                }, {}, function (s){
	                	$rootScope.loading('hide');
						// $location.path('/');
						$scope.data.status = 'pending';
	                }, function (e){
	                	$rootScope.loading('hide');
	                	alert('Sorry, this advertisement cannot be unpublished due to some reason, please contact administrator for more information');
	                });

	            }, function() {
	            });
			}
		};

        $(function() {

            // uiGmapGoogleMapApi is a promise.
            // The "then" callback function provides the google.maps object.
            // uiGmapGoogleMapApi.then(function(maps) {
            //     console.log(maps.Map.controls);
            // });

            $('#pac-input').keydown(function(e) {
                e.stopPropagation();
            });
        });

        // $scope.showMapSearchBox = false;

        $timeout(function() {
            

        }, 2000);

	});
}());
