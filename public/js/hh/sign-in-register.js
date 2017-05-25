/**
 * Created Date: 11 Nov 2016
 * Create By : Flexitech Cambodia Team
 */

//  restaurant view controller
app.controller('signInRegister', function($rootScope, $scope, $http, $timeout, Request, CryptService, Facebook) {

    // console.log('Sig In or Register');


    /**
     * [fbSignIn facebook sign-in]
     * @return {[type]} [description]
     */
    $scope.fbSignIn = function() {

        // disableButtons();
        // $scope.signInProcessing = false;
        // $scope.signInSocialProcessing = true;

        // // From now on you can use the Facebook service just as Facebook api says
        // var fbUser = {};

        Facebook.login(function(response) {

            console.log(response);

            if (!response || !response.authResponse) {

                $scope.signInProcessing = false;
                $scope.signInSocialProcessing = false;
                // enableButons();
                // return;
            }


            $scope._dataFbLogin = CryptService.create({

                access_token: response.authResponse.accessToken

            }, 60 * 60);

            // console.log($scope._dataLogin);

            setTimeout(function() {
                $('.fb_login').submit();
            }, 500);

        }, {

            scope: 'email'

        });

    };


    $scope._dataLogin = {};

    /**
     * [emailSignIn user sign-in with email]
     * @return {[type]} [description]
     */
    $scope.emailSignIn = function() {
        $scope.loginFrm.password.$dirty = true;
        $scope.loginFrm.email.$dirty = true;
        
        // console.log($scope.loginFrm);
        if($scope.loginFrm.$invalid)
            return;

        $scope.isLoading = true;

        var _user = {
            email: $scope.USER.email,
            password: $scope.USER.pass
        }

        $scope._dataLogin = CryptService.create(_user, 60 * 60);

        // console.log($scope._dataLogin);

        if($scope.loginFrm.$valid){

            setTimeout(function() {
                $('.login-frm').submit();
            }, 500);

        }


        // return;

        // Request.post('/login', {

        //    'data': data.encrypted
        
        // }, {
        //    'X-HH-Sign-Key' : data.encrypted_pass,
        //    // 'X-HH-Request-ID' : 'ZDZmY2FhZWZjMmNhOGNmOWM4MGVkMTZhYjhmMWE0ZjdjOWZjMmI1M2VhYzEwZDlhYzIyNzEwZWRmZjAzNThmYw=='
        // }).success(function(data, status){

        //     console.log(data,status);
        //     $scope.isLoading = false;

        // }).error(function(err, status){
        //     $scope.errMsg = true;
        //     $scope.isLoading = false;

        // });     

    }

    $scope._dataRegister = {};

    $scope.emailSignUp = function(){

        // $scope.registerFrm.$setSubmitted();

        $scope.registerFrm.agree.$dirty = true;
        $scope.registerFrm.confirm_password.$dirty = true;
        $scope.registerFrm.password.$dirty = true;
        $scope.registerFrm.email.$dirty = true;
        $scope.registerFrm.full_name.$dirty = true;

        // console.log($scope.registerFrm);
        if($scope.registerFrm.$invalid)
            return;

        $scope.isLoading = true;

        var _user = {
            email: $scope.USER.email,
            password: $scope.USER.password
        }

        $scope._dataRegister = CryptService.create(_user, 60 * 60);

        // console.log($scope._dataRegister);

        if($scope.registerFrm.$valid){

            setTimeout(function() {
                $('.registerForm').submit();
            }, 500);

        }   
    }





});