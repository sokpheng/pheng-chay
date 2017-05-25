(function (){
	app.controller('LoginCtrl', ['$scope', 'CryptService', '$http', '$mdDialog', function($scope, CryptService, $http, $mdDialog){

		$scope.submit = function ($event){
            if (!$scope.user || !$scope.user.email || !$scope.user.password){
                return;
            }
            var data = CryptService.create($scope.user, 60 * 60);

            $mdDialog.show({
                controller: 'LoadingDialogCtrl',
                templateUrl: '/templates/loading',
                parent: angular.element(document.body),
                targetEvent: $event,
            });

            $http.post('/api/v1/login', {
                'data': {
                    'data': data.encrypted
                },
                'headers': {
                    'key': data.encrypted_pass
                }
            }).success(function(s) {

                var redirect = s.options.redirect;

                $mdDialog.show({
                    controller: 'AlertDialogCtrl',
                    templateUrl: '/templates/alert',
                    parent: angular.element(document.body),
                    targetEvent: $event,
                    locals: {
                        $current: {
                            message: s.result || 'You have successfully logged in to the system.'
                        }
                    }
                })
                .then(function(answer) {
                    window.location = redirect;
                }, function() {
                    window.location = redirect;
                });
            }).error(function(f) {

                $mdDialog.show({
                    controller: 'AlertDialogCtrl',
                    templateUrl: '/templates/alert',
                    parent: angular.element(document.body),
                    targetEvent: $event,
                    locals: {
                        $current: {
                            message: f.result
                        }
                    }
                })
                .then(function(answer) {
                }, function() {
                });
            });
			// $('#page-login')[0].submit();
		};
	}]);
}());