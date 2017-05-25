(function (){
	app.controller('EnterpriseCreateCtrl', function($scope, uiGmapGoogleMapApi, 
		CoResource, $routeParams, $rootScope, $mdDialog, $mdToast, Upload, $timeout){

		$scope.hash = $routeParams.hash;
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
		$scope.data = {};
		$scope.mode = 'create';
		$scope.data = CoResource.resources.Directory
			.get({ directoryId: $scope.hash }, function (s){
				$scope.loading = false;


				$rootScope.loading('hide');
				if (!s.result){
					$scope.mode = 'create';
					$scope.data = {};

				    if (navigator.geolocation) {
				        navigator.geolocation.getCurrentPosition(function (position){
				        	$scope.map.center.latitude = position.coords.latitude;
				        	$scope.map.center.longitude = position.coords.longitude;
				        	$scope.marker.coords.latitude = position.coords.latitude;
				        	$scope.marker.coords.longitude = position.coords.longitude;
				        	$scope.$apply();
				        });
				    } 
				}
				else{
					$scope.data = $scope.data.result;
					$scope.mode = 'edit';
					$scope.data.is_active = $scope.data.is_active ? true : false;

		        	$scope.map.center.latitude = $scope.data.latitude;
		        	$scope.map.center.longitude = $scope.data.longitude;
		        	$scope.marker.coords.latitude = $scope.data.latitude;
		        	$scope.marker.coords.longitude = $scope.data.longitude;

					$timeout(function (){
						var cat = angular.copy($scope.categories);
						var ids = _.map($scope.data.categories, function (v){
							return v.id
						});
						cat = _.filter(cat, function (v){
							return ids.indexOf(v.id) > -1;
						});
						$scope.select_categories = cat;
					}, 1000);

		        	setTimeout(function (){
		        		renderMagnific();
		        	}, 200);
				}
			});
		$scope.categories = [];
		$scope.map = { center: { latitude: 45, longitude: -73 }, zoom: 13 ,
			events: {
				click: function (e, v, args){
					$scope.marker.coords.latitude = args[0].latLng.lat();
					$scope.marker.coords.longitude = args[0].latLng.lng();
					$scope.data.latitude = args[0].latLng.lat();
					$scope.data.longitude = args[0].latLng.lng();
					$scope.$apply();
				}
			}
		};

		$scope.marker = {
	      	id: 0,
	      	coords: {
	        	latitude: 40.1451,
	        	longitude: -99.6680
	      	},
	      	options: { 
	      		draggable: true ,
	      		title: 'Your selected position is here'
	      	},
	      	events: {
	        	dragend: function (marker, eventName, args) {
					var lat = marker.getPosition().lat();
					var lon = marker.getPosition().lng();
					$scope.data.latitude = lat;
					$scope.data.longitude = lon;
					if ($scope.mode == 'edit'){
						$scope.submit(true);
					}
	        	}
	      	}
	    };


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
	            	$scope.data.logo = result;
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

            $scope.upload = Upload.upload({
                url: $rootScope.remoteUrl ?  $rootScope.remoteUrl + 'api/v1/media' : '/api/v1/media', // upload.php script, node.js route, or servlet url
                method: 'POST',
                //headers: {'Authorization': 'xxx'}, // only for html5
                //withCredentials: true,
                method: 'POST',
                headers: {
                }, // only for html5
                data: {
                    "caption": $scope.data.name,
                    "description": $scope.data.description,
                    "imagable_type": "Directory",
                    "imagable_id": $scope.data.id,
                    "type": filetmp.type,
                    "album_id": 0
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
                
            }).error(function(data, status, headers, config) {
            	alert('There was an error while trying to upload file.');
            	console.log(data, status);
            	$scope.uploadingFile.loading = false;
            	$rootScope.loading('hide');
            });
    	};


		$scope.categories = CoResource.resources.Item.list({
	    	'type': 'category',
	    	'ignore-offset': 1,
	    	'parent_name': 'enterprise-category'
	    }, function(s) {
	    	$scope.categories = s.result;
	    });
		$scope.select_categories = [];
		$scope.itemChange = function (v){
			$scope.select_categories = _.filter($scope.select_categories, function(v){
				return _.isObject(v);
			});
		};	
		$scope.$watch('select_categories', function (v){

		});
		$scope.querySearch = function (query) {
			var results = query && _.isArray($scope.categories) ? _.filter($scope.categories, function (v){
				return v.display_name.toLowerCase().indexOf(query.toLowerCase()) > -1
			}) : [];
			return results;
		}

	    $scope.submit = function (hideDialog){
	    	if (!$scope.data.latitude){
	    		$scope.data.latitude = $scope.map.center.latitude;
	    	}
	    	if (!$scope.data.longitude){
	    		$scope.data.longitude = $scope.map.center.longitude;
	    	}
	    	var categorieIds = _.map($scope.select_categories, function (v){
	    		return v.id;
	    	});
	    	$scope.data.category_ids = categorieIds;
	    	if ($scope.mode === 'create'){
	    		$scope.data.hash = $scope.hash;

	 			var item = new CoResource.resources.Directory($scope.data);
	 			item.$save(function (s, h){
	 				$scope.data = s.result;
	 				$scope.mode = 'edit';
	 				$rootScope.loading('hide');
	 				$scope.savePendingUploads();
	 				if (!hideDialog){	 					
	 					return $mdDialog.show(
			      			$mdDialog.alert()
						        .parent(angular.element(document.body))
						        .title('Create Enterprise Listing')
						        .content('Enterprise listing is successfully created')
						        .ariaLabel('Create Enterprise Listing')
						        .ok('Got it!')
						);
	 				}
	 			}, function (f){
 					$rootScope.loading('hide');
 					$scope.savePendingUploads();
 					if (!hideDialog){
	 					return $mdDialog.show(
			      			$mdDialog.alert()
						        .parent(angular.element(document.body))
						        .title('Create Enterprise Listing')
						        .content('There was an error while creating enterprise listing. ' + CoResource.textifyError(f.data))
						        .ariaLabel('Create Enterprise Listing')
						        .ok('Got it!')
					    );
	 				}
 				});

	    	}
	    	else{
	    		var directory = new CoResource.resources.Directory.get({
	 				itemId: $scope.data.id
	 			}, function(){
	 				directory = _.extend(directory, $scope.data);
	 				directory.$update({directoryId: $scope.data.id}, function (s, h){
	 					
		 				$rootScope.loading('hide');
		 				if (hideDialog){		 					
							return $mdToast.show(
						      	$mdToast.simple()
						        	.content('Map updated')
						        	.position($scope.getToastPosition())
						        	.hideDelay(3000)
						    );
		 				}
	 					return $mdDialog.show(
			      			$mdDialog.alert()
						        .parent(angular.element(document.body))
						        .title('Create Enterprise Listing')
						        .content('Enterprise listing is successfully updated')
						        .ariaLabel('Create Enterprise Listing')
						        .ok('Got it!')
						    );
	 				}, function (e){
	 					$rootScope.loading('hide');
	 					// fail(CoResource.textifyError(e.data));

		      			return $mdDialog.show(
			      			$mdDialog.alert()
						        .parent(angular.element(document.body))
						        .title('Error Create Enterprise Listing')
						        .content(CoResource.textifyError(e.data))
						        .ariaLabel('Create Enterprise Listing')
						        .ok('Got it!')
						    );
	 				});
	 			}, function (e){
 					$rootScope.loading('hide');
 					return $mdDialog.show(
		      			$mdDialog.alert()
					        .parent(angular.element(document.body))
					        .title('Create Enterprise Listing')
					        .content('There was an error while creating enterprise listing. ' + CoResource.textifyError(f.data))
					        .ariaLabel('Create Enterprise Listing')
					        .ok('Got it!')
					    );
 				});
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
                	mediaId: item.id
                }, function (s){
                	$rootScope.loading('hide');
                	for(var i = $scope.data.photos.length - 1; i >= 0; i--){
    					if (item.id === $scope.data.photos[i].id){
    						$scope.data.photos.splice(i, 1);
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
	});
}());