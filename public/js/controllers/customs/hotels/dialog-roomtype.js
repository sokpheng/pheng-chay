(function() {
    app.controller('RoomtypeDialogCtrl', ['$scope', '$timeout', '$mdSidenav',
        '$mdUtil', '$log', '$location', '$mdDialog', '$rootScope', '$current',
        '$mdToast', 'CoResource', 'Upload', '$timeout', '$routeParams',
        function($scope, $timeout, $mdSidenav,
            $mdUtil, $log, $location, $mdDialog, $rootScope, $current,
            $mdToast, CoResource, Upload, $timeout, $routeParams) {



            /***********************/
            /****** declaration ****/
            /***********************/


            // $scope.data = $current ? angular.copy($current) : null;

            $scope.data = $current;

            $scope.pendingFiles = [];
            $scope.pendingUploads = [];

            $scope.toastPosition = {
                bottom: false,
                top: true,
                left: false,
                right: true
            };



            /***********************/
            /* init function call **/
            /***********************/
            loadData();

            /***********************/
            /**** scope function ***/
            /***********************/





            $scope.getToastPosition = function() {
                return Object.keys($scope.toastPosition)
                    .filter(function(pos) { return $scope.toastPosition[pos]; })
                    .join(' ');
            };

            $scope.close = function() {
                $mdDialog.hide();
            };

            $scope.save = function($event) {

                if (!$scope.data || !$scope.data._id) {
                    // return;
                    return $mdDialog.show(
                        $mdDialog.alert({
                            preserveScope: true,
                            autoWrap: true,
                            skipHide: true,
                            // parent: angular.element(document.body),
                            title: 'Create Hotel',
                            content: 'Sorry, you have not created hotel yet',
                            ariaLabel: 'Create Room Type',
                            ok: 'Got it!'
                        })
                    );
                }

                var success = function(f) {
                    // $current = $scope.data;
                    // $rootScope.$emit('dataDimensionSaved', {
                    // 	mode: $current ? 'edit' : 'create',
                    // 	$current: $current
                    // });
                    return $mdDialog.show(
                            $mdDialog.alert({
                                preserveScope: true,
                                autoWrap: true,
                                skipHide: true,
                                // parent: angular.element(document.body),
                                title: 'Create Room Type',
                                content: 'Room Type has been saved',
                                ariaLabel: 'Create room type',
                                ok: 'Got it!'
                            })
                        )
                        .finally(function() {
                            $mdDialog.hide();
                        });
                };

                var fail = function(f) {
                    return $mdDialog.show(
                        $mdDialog.alert({
                            preserveScope: true,
                            autoWrap: true,
                            skipHide: true,
                            // parent: angular.element(document.body),
                            title: 'Create Room Type',
                            content: 'There was an error while creating room type. ' + f,
                            ariaLabel: 'Create room type',
                            ok: 'Got it!'
                        })
                    );
                };
                $rootScope.loading('show');


                $scope.data.input_type = $scope.selectedType;
                $scope.data.input_include = $scope.selectedInclude;


                if ($scope.data.isCreated) {

                    console.log("**********", $scope.data);
                    var item = CoResource.resources.Hotel.addRoomtype({
                        hotelId: $scope.data._id
                    }, $scope.data, function() {
                        success();
                        // item.result.stock = {
                        // 	qty : $scope.data.qty
                        // } ;
                        $scope.data.room_type.push(item.result);
                        $scope.data.title = '';
                        $scope.data.option = '';
                        $scope.data.discount = null;
                        $scope.data.price = null;
                        $scope.data.capacity = null;
                        $rootScope.loading('hide');
                    }, function(e) {
                        $rootScope.loading('hide');
                        fail(CoResource.textifyError(e.data));
                    });
                } else {
                    var item = CoResource.resources.Hotel.editRoomtype({
                        hotelId: $scope.data._id,
                        roomtypeId: $scope.data.roomtypeId
                    }, $scope.data, function() {
                        success();
                        notifyDataChange();
                        $rootScope.loading('hide');
                    }, function(e) {
                        $rootScope.loading('hide');
                        fail(CoResource.textifyError(e.data));
                    });
                    // var item = new CoResource.resources.Product($scope.data);

                    // item.$updateProductLine(function (s, h){
                    // 	success();
                    // 	$rootScope.loading('hide');
                    // }, function (e){
                    // 	$rootScope.loading('hide');
                    // 	fail(CoResource.textifyError(e.data));
                    // });

                }
            };

            $scope.uploadMedia = function(files) {
                _.each(files, function(v, k) {
                    var file = {
                        file: files[k],
                        id: namespace.guid(),
                        type: 'gallery',
                        src: window.URL.createObjectURL(v)
                    };
                    $scope.pendingFiles.push(file);
                    if ($scope.mode === 'create') {
                        $scope.pendingUploads.push(file);
                    } else {
                        file.loading = true;
                        $scope.chooseFile(file, function(data, file) {
                            $scope.data.photos = $scope.data.photos || [];
                            $scope.data.photos.push(data.result);
                            for (var i = $scope.pendingFiles.length - 1; i >= 0; i--) {
                                if (file.id === $scope.pendingFiles[i].id) {
                                    $scope.pendingFiles.splice(i, 1);
                                }
                            }
                            setTimeout(function() {
                                // renderMagnific();
                            }, 200);
                        });
                    }
                });
            };

            $scope.chooseFile = function(filetmp, callback) {

                filetmp.loading = true;
                $rootScope.loading('show');

                var url = $rootScope.remoteUrl + '/v1/admin/hotels/roomtypes/' + $scope.data.roomtypeId + '/galleries';

                // console.log(url);
                // return;

                $scope.upload = Upload.upload({
                    url: url,
                    method: 'POST',
                    //headers: {'Authorization': 'xxx'}, // only for html5
                    //withCredentials: true,
                    headers: {}, // only for html5
                    data: {
                        // upload_session_key: namespace.guid()
                    },
                    file: filetmp.file,
                }).progress(function(evt) {
                    // evt.config.file.progress = parseInt(100.0 * evt.loaded / evt.total);
                    filetmp.progress = parseInt(100.0 * evt.loaded / evt.total);
                }).success(function(data, status, headers, config) {
                    if (callback) {
                        callback(data, filetmp);
                    }

                    $rootScope.loading('hide');
                    $mdToast.show(
                        $mdToast.simple()
                        .content('File uploaded')
                        .position($scope.getToastPosition())
                        .hideDelay(3000)
                    );

                    if (filetmp.type == 'gallery') {
                        $scope.data.roomtype_gallery = $scope.data.roomtype_gallery || [];
                        data.result.thumbnail_url_link = filetmp.src;
                        $scope.data.roomtype_gallery.unshift(data.result);
                    } else if (filetmp.type == 'logo') {
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


            $scope.savePendingUploads = function() {

                _.each($scope.pendingUploads, function(v, k) {
                    v.loading = true;
                    if (v.type == 'logo') {
                        $scope.chooseFile(v, function(data) {
                            $scope.uploadingFile.loading = false;
                            var result = data.result;
                            $scope.data.logo_id = result.id;
                            $scope.submit(true);
                            $rootScope.loading('hide');
                            $mdDialog.hide();
                            $scope.data.logo = result;
                        });
                    } else {
                        $scope.chooseFile($scope.pendingUploads[k], function(data, file) {
                            $scope.data.photos = $scope.data.photos || [];
                            $scope.data.photos.push(data.result);
                            for (var i = $scope.pendingFiles.length - 1; i >= 0; i--) {
                                if (file.id === $scope.pendingFiles[i].id) {
                                    $scope.pendingFiles.splice(i, 1);
                                }
                            }
                            setTimeout(function() {
                                renderMagnific();
                            }, 200);
                        });
                    }
                });
                $scope.pendingUploads = [];
            };

            $scope.deletePhoto = function(item, ev) {
                // Appending dialog to document.body to cover sidenav in docs app
                if (!item) {
                    return;
                }
                var request_delete = function() {
                    $rootScope.loading('show');
                    CoResource.resources.Hotel.deletePhotoRoomtype({
                        photoId: item._id
                    }, function(s) {
                        $rootScope.loading('hide');
                        for (var i = $scope.data.gallery.length - 1; i >= 0; i--) {
                            if (item._id === $scope.data.roomtype_gallery[i]._id) {
                                $scope.data.roomtype_gallery.splice(i, 1);
                            }
                        }
                        $mdToast.show(
                            $mdToast.simple()
                            .content('Gallery removed')
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                        );
                    }, function(e) {
                        $rootScope.loading('hide');
                        alert('Sorry, this media cannot be deleted due to some reason, please contact administrator for more information');
                    });
                }


                var result = confirm("Want to delete?");
                if (result) {
                    request_delete();
                }
            };

            $scope.updateRoomtypeCover = function(item, ev) {
                // Appending dialog to document.body to cover sidenav in docs app
                if (!item || item._id == $scope.data.cover_media) {
                    return;
                }
                if (confirm('Are sure to do set this image as hotel cover?')) {
                    // Save it!
                    $rootScope.loading('show');
                    CoResource.resources.Hotel.setRoomtypeCoverPhoto({
                        roomtypeId: $scope.data.roomtypeId,
                        photoId: item._id
                    }, {
                        cover_media: item._id
                    }, function(s) {
                        $rootScope.loading('hide');
                        $scope.data.cover_media = item._id;

                        $mdToast.show(
                            $mdToast.simple()
                            .content('Cover set')
                            .position($scope.getToastPosition())
                            .hideDelay(3000)
                        );
                    }, function(e) {
                        $rootScope.loading('hide');
                        alert('Sorry, this media cannot be set due to some reason, please contact administrator for more information');
                    });
                } else {
                    // Do nothing!
                    console.log("no");
                }






                //       var confirm = $mdDialog.confirm()
                //           .parent(angular.element(document.body))
                //           .title('Set this gallery as cover?')
                //           .content('Are sure to do set this image as hotel cover?')
                //           .ariaLabel('Set Cover')
                //           .ok('Yes')
                //           .cancel('No')
                //           .targetEvent(ev);
                //       $mdDialog.show(confirm).then(function() {
                //           $rootScope.loading('show');
                //           CoResource.resources.Hotel.setRoomtypeCoverPhoto({
                // roomtypeId : $scope.data.roomtypeId,
                //              	photoId:item._id
                //           }, {
                //               cover_media: item._id
                //           }, function(s) {
                //               $rootScope.loading('hide');
                //               $scope.data.cover_media = item._id;

                //               $mdToast.show(
                //                   $mdToast.simple()
                //                   .content('Cover set')
                //                   .position($scope.getToastPosition())
                //                   .hideDelay(3000)
                //               );
                //           }, function(e) {
                //               $rootScope.loading('hide');
                //               alert('Sorry, this media cannot be set due to some reason, please contact administrator for more information');
                //           });

                //       }, function() {});
            };


            /* New chip */
            $scope.selectedInclude = [];
            $scope.selectedType = [];
            $scope.category = ["Wifi"];

            $scope.selectedItem = null;
            $scope.searchText = null;



            $scope.querySearchCategory = function(query) {
                return _.map(_.filter($scope.category, function(v) {
                    return v.indexOf((query || '').toLowerCase()) != -1;
                }), function(v) {
                    return v;
                });
            };



            /***********************/
            /******  functions *****/
            /***********************/

            function loadData() {
                //  	$scope.selected = [];
                //   var promise = CoResource.resources.Category.list({
                //   	// type: $routeParams.type,
                //   	type: 'category',
                //   	cache: 0,
                //   }, function (){
                //   	$scope.parents = promise.result;
                // $rootScope.loading('hide');
                //   });

                console.log('=== ', $scope.data.selected_product_lines);



                if (!$scope.data.isCreated) {
                    // $scope.isShowQty = false;
                    $scope.data.roomtypeId = $scope.data.selected_roomtype._id;
                    $scope.data.title = $scope.data.selected_roomtype.title;
                    $scope.data.options = $scope.data.selected_roomtype.options;
                    $scope.data.discount = $scope.data.selected_roomtype.discount * 1;
                    $scope.data.price = $scope.data.selected_roomtype.price * 1;
                    $scope.data.capacity = $scope.data.selected_roomtype.capacity * 1;


                    var item = CoResource.resources.Hotel.getRoomtype({
                        hotelId: $scope.data._id,
                        roomtypeId: $scope.data.roomtypeId
                    }, $scope.data, function() {
                        $scope.data.roomtype_cover_media = item.result.cover_media;
                        $scope.data.roomtype_gallery = item.result.gallery || {};

                        $scope.selectedType = item.result.input_type;
                        $scope.selectedInclude = item.result.input_include;


                        console.log("item", item);
                        $rootScope.loading('hide');
                    }, function(e) {
                        $rootScope.loading('hide');
                        // fail(CoResource.textifyError(e.data));
                    });
                } else {
                    // $scope.isShowQty = true;
                    $scope.data.roomtypeId = null;
                    $scope.data.title = null;
                    $scope.data.options = null;
                    $scope.data.discount = null;
                    $scope.data.price = null;
                    $scope.data.capacity = null;
                }
            };


            function notifyDataChange() {
                _.each($scope.data.room_type, function(v, k) {
                    // console.log($scope.data.lineId ,$scope.data.product_lines[k].id);
                    if ($scope.data.roomtypeId == $scope.data.room_type[k]._id) {
                        $scope.data.room_type[k].title = $scope.data.title;
                        $scope.data.room_type[k].options = $scope.data.options;
                        $scope.data.room_type[k].discount = $scope.data.discount;
                        $scope.data.room_type[k].price = $scope.data.price;
                        $scope.data.room_type[k].capacity = $scope.data.capacity;

                        $scope.data.room_type[k].input_type = $scope.selectedType;
                        $scope.data.room_type[k].input_include = $scope.selectedType;
                    }
                });
            };

            function refreshData(media) {

                var BreakException = {};

                try {
                    _.each($scope.data.product_lines, function(v, k) {
                        if ($scope.data.lineId == $scope.data.product_lines[k].id) {
                            $scope.data.product_lines[k].photo_id = media.id;
                            throw BreakException;
                        }
                    });

                } catch (e) {
                    if (e !== BreakException) throw e;
                }


            };







        }
    ]);
}());