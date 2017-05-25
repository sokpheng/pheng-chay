(function() {
    app.controller('BookingDialogCtrl', ['$scope', '$timeout', '$mdSidenav',
        '$mdUtil', '$log', '$location', '$mdDialog', '$rootScope', '$current',
        '$mdToast', 'CoResource', 'Upload', '$timeout',
        function($scope, $timeout, $mdSidenav,
            $mdUtil, $log, $location, $mdDialog, $rootScope, $current,
            $mdToast, CoResource, Upload, $timeout) {


            /***********************/
            /****** declaration ****/
            /***********************/

            // $scope.data = $current ? angular.copy($current) : null;

            $scope.data = $current;

            console.log($current);



            /***********************/
            /* init function call **/
            /***********************/


            /***********************/
            /**** scope function ***/
            /***********************/

            $scope.close = function() {
                $mdDialog.hide();
            };




            /***********************/
            /******  functions *****/
            /***********************/



        }
    ]);
}());