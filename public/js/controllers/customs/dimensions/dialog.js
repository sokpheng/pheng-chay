(function (){
	app.controller('DimensionDialogCtrl', ['$scope', '$timeout', '$mdSidenav',
		'$mdUtil', '$log', '$location', '$mdDialog', '$rootScope', '$current',
		'$mdToast', 'CoResource', 'Upload', '$timeout', function($scope, $timeout, $mdSidenav,
		$mdUtil, $log, $location, $mdDialog, $rootScope, $current,
		$mdToast, CoResource, Upload, $timeout){
		$scope.data = $current ? angular.copy($current) : null;
		$scope.type_name = $rootScope.type_names[$current ? $current.type : ''];

		$scope.toastPosition = {
	    	bottom: false,
	    	top: true,
	    	left: false,
	    	right: true
	  	};

		if (!$scope.data.locale){
			$scope.data.locale =  {
				kh: {}
			};
		}

		if (!$scope.data.locale.kh){
			$scope.data.locale.kh = $scope.data.locale.kh || {};
		}

		$scope.mode = !!$scope.data._id ? 'edit' : 'create';

	  	$scope.getToastPosition = function() {
	    	return Object.keys($scope.toastPosition)
	      		.filter(function(pos) { return $scope.toastPosition[pos]; })
	      		.join(' ');
	  	};

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	 	$scope.save = function ($event){
	 		if (!$scope.data || !$scope.data.display_name){
	 			return;
	 			// return $mdDialog.show(
			  //     	$mdDialog.alert({
	    //                 // controllerAs: 'dialogCtrl',
	    //                 // controller: function($mdDialog){
	    //                 //     this.click = function(){
	    //                 //         $mdDialog.hide();
	    //                 //     }
	    //                 // },
	    //                 preserveScope: true,
	    //                 autoWrap: true,
	    //                 skipHide: true,
	    //                 // parent: angular.element(document.body),
	    //                 title: 'Create dimension',
	    //                 content: 'Sorry, you have not filled in name field',
	    //                 ariaLabel: 'Create dimension',
	    //                 ok: 'Got it!'
			  //     	})
			  //   );
	 		}

	 		var success = function (){
		 		$current = $scope.data;
		 		$rootScope.$emit('dataDimensionSaved', {
		 			mode: $current ? 'edit' : 'create',
		 			$current: $current
		 		});
		 		return $mdDialog.show(
			      	$mdDialog.alert({
	                    preserveScope: true,
	                    autoWrap: true,
	                    skipHide: true,
	                    // parent: angular.element(document.body),
	                    title: 'Create Dimension',
	                    content: 'Dimension has been saved',
	                    ariaLabel: 'Create dimension',
	                    ok: 'Got it!'
			      	})
			    )
	          	.finally(function() {
	            	$mdDialog.hide();
	          	});
				// $mdToast.show(
			 //      	$mdToast.simple()
			 //        	.content($current ? 'Dimension saved' : 'Dimension created')
			 //        	.position($scope.getToastPosition())
			 //        	.hideDelay(3000)
			    // );
	 		};

	 		var fail = function (f){
		 		return $mdDialog.show(
			      	$mdDialog.alert({
	                    preserveScope: true,
	                    autoWrap: true,
	                    skipHide: true,
	                    // parent: angular.element(document.body),
	                    title: 'Create Dimension',
	                    content: 'There was an error while creating dimension. ' + f,
	                    ariaLabel: 'Create dimension',
	                    ok: 'Got it!'
			      	})
			    );
				// return $mdDialog.show(
	   //    			$mdDialog.alert({
			 //                controller: function($mdDialog){
			 //                  this.click = function(){
			 //                    $mdDialog.hide();
			 //                  }
			 //                },
			 //                preserveScope: true,
			 //                autoWrap: true,
			 //                skipHide: true
			 //            })
				//         .parent(angular.element(document.body))
				//         .title('Create Dimension')
				//         .content('There was an error while creating dimension. ' + f)
				//         .ariaLabel('Create Dimension')
				//         .ok('Got it!')
			    // );
	 		};
	 		$rootScope.loading('show');
	 		if ($scope.data.id){
	 			var item = new CoResource.resources.Item.get({
	 				itemId: $scope.data._id
	 			}, function(){

	 				item.display_name = $scope.data.display_name;
	 				item.description = $scope.data.description;
	 				item.seq_number = $scope.data.seq_number;
					item.min_price = $scope.data.min_price;
					item.max_price = $scope.data.max_price;
					item.locale = $scope.data.locale;
					item.is_landing_page = $scope.data.is_landing_page;

	 				item.$update({itemId: $scope.data._id}, function (s, h){
	 					success();
	 					$rootScope.loading('hide');
	 				}, function (e){
	 					$rootScope.loading('hide');
	 					fail(CoResource.textifyError(e.data));
	 				});
	 			}, function (e){
 					$rootScope.loading('hide');
 					fail(CoResource.textifyError(e.data));
 				});
	 		}
	 		else{
		 		$scope.data.seq_number = $scope.data.seq_number || 99;
	 			var item = new CoResource.resources.Item($scope.data);
	 			item.item_type = 'type';
	 			item.$save(function (s, h){
	 				success();
	 				$rootScope.loading('hide');
	 			}, function (e){
 					$rootScope.loading('hide');
 					fail(CoResource.textifyError(e.data));
 				});

	 		}
	 	};

		/** UPLOAD LOGO  */
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
		            	$rootScope.loading('hide');
						$rootScope.$emit('dimensionUploaded');
		            	$mdDialog.hide();
		            	$scope.data.logo = result;
		    		});
				}
				else{
				}
			});
			$scope.pendingUploads = [];
		};

		console.log($scope.mode);
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
	            	$rootScope.loading('hide');
					$rootScope.$emit('dimensionUploaded');
	            	$mdDialog.hide();
	            	$timeout(function() {
	            		$scope.data.logo = result;
	            	}, 6000);

	    		});
			}
		};

		$scope.pendingFiles = [];

		$scope.chooseFile = function (filetmp, callback){

			filetmp.loading = true;
			$rootScope.loading('show');

			var url = $rootScope.remoteUrl + '/admin/dimensions/' + $scope.data._id + '/' + (filetmp.type == 'logo' ? 'logo' : 'galleries');

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


	}]);
}());
