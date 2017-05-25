/**
 * Created Date: 04 Nov 2016
 * Create By : Flexitech Cambodia Team
 */

//  restaurant view controller
app.controller('userViewCtrl', function($rootScope, $scope, $http, $timeout, Request, genfunc, Upload,hhModule,CryptService) {

    // console.log('home page');

    // $scope.lat = '';
    // $scope.lng = '';

    $scope.initial = function() {
        $scope.remote = genfunc.getRemote();
        hhModule.controllMenu(window.location.hash);
        // console.log(window.location.hash);
    }

    $scope.initUser = function(full_name,phone_number,description,email){
 		$scope.user.profile.full_name =  full_name;
 		$scope.user.profile.phone_number =  phone_number;
 		$scope.user.profile.description =  description;
 		$scope.user.email =  email;
    }

    $scope.setProfilePhoto = function(photo){
    	// console.log(photo);
    	$rootScope.profilePhoto = photo;
    }

    $scope.getTime = function(date) {
        return genfunc.timeFromNow(date);
    }

    $scope.getUrlFileImage = function(file) {
        if (!file) return;
        console.log("this", window.URL.createObjectURL(file));
        return window.URL.createObjectURL(file);
    }

    $scope.formatTime = function(date) {
        return moment(date).format('MMM DD YYYY');
    }

    $scope.logout = function(){
        Request.post('/logout',{},{})
        .success(function(data, status, headers, config) {
            if (data.code == 200) {
                console.log("============= logout");
                console.dir(data);
            }
        })
        .error(genfunc.onError);
    }


    $scope.saveChangePass = function(){

        var _user = {
            password: $scope.user.password,
            new_password: $scope.user.new_password,
            confirm_new_password: $scope.user.confirm_new_password
        }

        // var data = CryptService.create(_user, 60 * 60);

        $scope.data = CryptService.create(_user, 60 * 60);
        console.log($scope.user);
        console.log($scope.data);

        $timeout(function() {
            ('.flat-control-form-border').submit();
        }, 1000);

        // Request.post('/user/me/password',{
        //     'full_name' : $scope.user.profile.full_name,
        //     'phone_number' : $scope.user.profile.phone_number,
        //     'description' : $scope.user.profile.description

        // },{})
        // .success(function(data, status, headers, config) {
        //     if (data.code == 200) {
        //         console.log("============= save");
        //         console.dir(data);
        //     }
        // })
        // .error(genfunc.onError);
    }


    $scope.save = function(){

		Request.put('/user/me',{
			'full_name' : $scope.user.profile.full_name,
			'phone_number' : $scope.user.profile.phone_number,
			'description' : $scope.user.profile.description

		},{})
        .success(function(data, status, headers, config) {
            if (data.code == 200) {
                console.log("============= save");
                console.dir(data);
            }
        })
        .error(genfunc.onError);
    }

    $scope.uploadProfilePhoto = function(file){
    	if(!file) return;
        $scope.file_upload = file;

        // $rootScope.profilePhoto = $scope.getUrlFileImage(file);

        post_images(file);
    }


    function post_images( file) {

        $scope.isUploading =  true;

        var session = genfunc.getSessionId();
        var token = genfunc.getToken();
        var request_id = genfunc.getRequestId();

        Upload.upload({
            url: $scope.remote + '/user/photo',
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
            console.log(resp.data);
            // console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);

            $timeout(function() {
                $rootScope.profilePhoto = resp.data.result.thumbnail_url_link;
                $scope.isUploading =  false;
            }, 3000);
            

            $http.post(genfunc.getURL()+'/' + genfunc.getUser()._id +'/ud', {
                data: resp.data.result
            }, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).success(function(response) {
                // $scope.myWelcome = response.data;
                console.log(response);

                

            }).then(function(response) {
                // $scope.myWelcome = response.data;
                console.log(response);
            });


            

        }, function(resp) {
            console.log('Error status: ' + resp.status);
        }, function(evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });


    }


    $scope.initial();


    $scope.gotoSetting = function(){
        $('.open-setting').tab('show')
    }

    $(function(){

        
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

        if($('.open-popup-link').length>0){
            $('.open-popup-link').magnificPopup({
              type:'inline',
              midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
            });
        }
        
        
    })

});