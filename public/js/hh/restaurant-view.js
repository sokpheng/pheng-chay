/**
 * Created Date: 04 Nov 2016
 * Create By : Flexitech Cambodia Team
 */

//  restaurant view controller
app.controller('restaurantViewCtrl', function($rootScope, $scope, $http, $timeout, Request, genfunc, Upload) {

    console.log('home page');

    // $scope.lat = '';
    // $scope.lng = '';

    $scope.initial = function() {

        // console.log("$scope.time_ago", $scope.time_ago);
        $('.gallery-group-cell .carousel').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                removalDelay: 300,
                image: {
                    tError: '<a href="%url%" target="_blank">The image</a> could not be loaded.'
                },
                verticalFit: true, // Fits image in area vertically
                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true
                }
            });
        });

        $('.simple-image-list ').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: '._photoEle', // the selector for gallery item
                type: 'image',
                removalDelay: 300,

                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true
                }
            });
        });

        $('.review-item').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: '.photoReview', // the selector for gallery item
                type: 'image',
                removalDelay: 300,

                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true
                }
            });
        });

        $scope.user = genfunc.getUser();
        $scope.remote = genfunc.getRemote();
        // console.log($scope.remote);
    }


    $scope.$on('finishedPhotoUpload', function() {

        // console.log('done render');
        $('.review-item').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: '.photoReview', // the selector for gallery item
                type: 'image',
                removalDelay: 300,

                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true
                }
            });
        });

    });

    $scope.checkHidden = function(index, galleries){
        // console.log(index);
        if(index >= 7)
            return true;
        else
            return false;
    }

    $scope.checkMoreThenEight = function(index){
        // console.log(index);
        if(index > 7)
            return true;
        else
            return false;
    }

    $scope.checkShowMore = function(index, galleries){
        // console.log(index);
        if(galleries.length>8){
            if(index == 7)
                return true;
            else
                return false;
        }
        else{
            return false;
        }
    }

    $scope.getTime = function(date) {
        return genfunc.timeFromNow(date);
    }


    $scope.getUrlFileImage = function(file) {
        if (!file) return;
        // console.log("this", window.URL.createObjectURL(file));
        return window.URL.createObjectURL(file);
    }

    $scope.formatTime = function(date) {
        return moment(date).format('MMM DD YYYY');
    }
    $scope.initMap = function() {
        // console.log($scope.lat, $scope.lng);
        // $scope.map = { center: { latitude: 11.557952, longitude: 104.908519 }, zoom: 15 };

        var icon = {
            url: "/img/map-marker-icon.png", // url
            scaledSize: new google.maps.Size(40,40), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(20, 35) // anchor
        };

        $scope.map = {
            center: {
                latitude: $scope.lat,
                longitude: $scope.lng
            },
            zoom: 15
        };
        $scope.options = {
            scrollwheel: true
        };
        $scope.marker = {
            id: 0,
            coords: {
                latitude: $scope.lat,
                longitude: $scope.lng
            },
            options: {
                draggable: false,
                animation: google.maps.Animation.DROP,
                title: $scope.directory_name,
                // icon: 'http://icons.iconarchive.com/icons/paomedia/small-n-flat/64/map-marker-icon.png'
                icon: icon
            },
            events: {
                dragend: function(marker, eventName, args) {
                    // $log.log('marker dragend');
                    // var lat = marker.getPosition().lat();
                    // var lon = marker.getPosition().lng();
                    // $log.log(lat);
                    // $log.log(lon);

                    // $scope.marker.options = {
                    //   draggable: true,
                    //   labelContent: "lat: " + $scope.marker.coords.latitude + ' ' + 'lon: ' + $scope.marker.coords.longitude,
                    //   labelAnchor: "100 0",
                    //   labelClass: "marker-labels"
                    // };
                }
            }
        };

        // console.log($scope.map);

    }
    $scope.share = function() {}

    $scope.like = function(_id) {
        // console.log('_id', _id, $scope.is_like_active);
        if (!authLogin()) return;
        if ($scope.is_like_active) {
            $scope.like_total-- < 0 ? 0 : $scope.like_total;
            $scope.is_like_active = false;
            Request.get('/user/directories/unlike/' + _id)
                .success(function(data, status, headers, config) {
                    if (data.code == 200) {
                        // console.log("============= finish");
                        // console.dir(data);
                    }
                })
                .error(genfunc.onError);
        } else {
            $scope.like_total++;
            $scope.is_like_active = true;
            Request.get('/user/directories/like/' + _id)
                .success(function(data, status, headers, config) {
                    if (data.code == 200) {
                        // console.log("============= finish");
                        // console.dir(data);
                    }
                })
                .error(genfunc.onError);
        }


    }

    $scope.save = function(_id) {
        // console.log('_id', _id, $scope.is_save_active);
        if (!authLogin()) return;
        if ($scope.is_save_active) {
            $scope.is_save_active = false;
            Request.get('/user/directories/unsave/' + _id)
                .success(function(data, status, headers, config) {
                    if (data.code == 200) {
                        // console.log("============= finish");
                        // console.dir(data);
                    }
                })
                .error(genfunc.onError);
        } else {
            $scope.is_save_active = true;
            Request.get('/user/directories/save/' + _id)
                .success(function(data, status, headers, config) {
                    if (data.code == 200) {
                        // console.log("============= finish");
                        // console.dir(data);
                    }
                })
                .error(genfunc.onError);
        }
    }

    $scope.upload_image = function(files) {
        if (!authLogin()) return;
        // console.log(files);
        $scope.file_upload = files;

        // for (var i = 0; i < $scope.file_upload.length; i++) {
        //     $scope.file_upload[i].src = $scope.getUrlFileImage($scope.file_upload[i]);
        // }
        // $scope.comment = {};
        // $scope.comment.gallery = $scope.file_upload;
        // console.log($scope.file_upload);
    }

    $scope.post = function(_id) {
        if (!authLogin()) return;
        // console.log(_id, $scope.comment_text);
        if (!$scope.comment_text || $scope.comment_text == '') {
            alert("please input description");
            return;
        }

        $scope.isPosting = true;


        Request.post('/directories/' + _id + '/comments', {
                "description": $scope.comment_text
            })
            .success(function(data, status, headers, config) {
                if (data.code == 200) {
                    // console.log("============= comment_text finish");
                    // console.dir(data);
                    // $scope.comment = data.result;
                    $scope.count_review++;
                    $scope.comment_text = '';
                    if ($scope.file_upload) {
                        for (var i = 0; i < $scope.file_upload.length; i++) {
                            post_images(data.result._id, $scope.file_upload[i]);
                            $scope.file_upload[i].src = $scope.getUrlFileImage($scope.file_upload[i]);
                            $scope.count_photo++;
                            updateGallery($scope.file_upload[i]);
                        }
                        data.result.gallery = $scope.file_upload;
                        // console.log($scope.file_upload);
                        // $scope.comment.gallery = $scope.file_upload;
                    }

                    if (!$scope.comments) {
                        $scope.comments = [];
                        $scope.comments.push(data.result);
                    } else {
                        // console.log("mean hoay ");
                        $scope.comments.push(data.result);
                    }


                }
                $scope.isPosting = false;
            })
            .error(function(){
                $scope.isPosting = false;
                genfunc.onError();
            });
    }

    function updateGallery(file) {
        if (!$scope.galleries) {
            $scope.galleries = [];
            $scope.galleries.push({
                photo : file.src,
                user : genfunc.getUser()
            });
        } else {
            $scope.galleries.push({
                photo : file.src,
                user : genfunc.getUser()
            });
        }
    }

    function authLogin() {
        var isLogin = false;
        if ($scope.user) isLogin = true
        if (!isLogin) 
            window.location.href = genfunc.getURL() + '/' + genfunc.getLang() + '/login?b=' + window.location.href;
            // alert("Please login");
        return isLogin;

    }

    function post_images(_id, file) {
        var session = genfunc.getSessionId();
        var token = genfunc.getToken();
        var request_id = genfunc.getRequestId();
        // console.log($scope.remote + '/comments/' + _id + '/galleries');
        Upload.upload({
            url: $scope.remote + '/comments/' + _id + '/galleries',
            method: 'POST',
            data: {
                // file: $scope.file_upload,
            },
            file: file,
            headers: {
                'X-HH-Request-ID': request_id,
                'Authorization': 'Bearer ' + token,
                'X-HH-Connect-ID': session
            }
        }).then(function(resp) {
            // console.log(resp.data);
            // console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
        }, function(resp) {
            // console.log('Error status: ' + resp.status);
        }, function(evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            // console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });


    }



    $scope.setNotificationAsRead = function(_id){

        if($rootScope.unseenCount<=0)
            return;

        var url = '/notifications/'+ _id +'/read';
        Request.post(url)
            .success(function(data, status, headers, config) {
                if (data.code == 200) {
                    // console.log("============= requestUserAction");
                    // console.log(data.result);
                    // $rootScope.unseenCount = 0;
                }
            })
            .error(genfunc.onError);
    }
    


    // uiGmapGoogleMapApi is a promise.
    // The "then" callback function provides the google.maps object.
    // uiGmapGoogleMapApi.then(function(maps) {
    // 	console.log('map ready');
    // });

    $scope.initial();

    $(function() {

        setTimeout(function() {
            
            // $scope.initMap();

        }, 5000);

        var hash = window.location.hash.substr(1);
        hash = hash.replace("/", "");
        // console.log(hash);
        if (hash) {
            $('a[href="#' + hash + '"]').tab('show');
        }
    })

});