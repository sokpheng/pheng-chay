(function (){
	app.controller('LocaleDialogCtrl', function($scope, $timeout, $mdSidenav, 
		$mdUtil, $log, MockService, $location, $mdDialog, $rootScope, $current, $type,
		$mdToast, CoResource){

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

		$scope.item = $current ? angular.copy($current) : {};
		$scope.locale = $scope.item.locale ? angular.fromJson($scope.item.locale) : [];

		$scope.languages = [{
			value: 'kh',
			text: 'Khmer'
		}, {
			value: 'cn',
			text: 'Chinese'
		}];

		$scope.addLocale = function (){
			if ($scope.data && $scope.data.text && $scope.data.language){
				var index = _.findIndex($scope.locale, function (v){
					return v.language === $scope.data.language;
				});
				var localeTmp = angular.copy($scope.locale || []);
				if (index > -1){
					localeTmp[index].text = $scope.data.text;
					// $scope.data = null;
				}
				else{
					localeTmp.push($scope.data);	
					// $scope.data = null;	
				}
				$scope.dialogFormLocale.$setPristine();

				// $scope.item.locale = angular.toJson($scope.locale);
				// MockService[$type].update($scope.item);
				// $mdToast.show(
			 //      	$mdToast.simple()
			 //        	.content('Locale added')
			 //        	.position($scope.getToastPosition())
			 //        	.hideDelay(3000)
			 //    );
			 //    $rootScope.$emit('dataTypeSaved');

				$rootScope.loading('show');
			    $scope.save(localeTmp, function (){	
			    	$rootScope.$emit('dataTypeSaved');	    	
					$mdToast.show(
				      	$mdToast.simple()
				        	.content('Locale added')
				        	.position($scope.getToastPosition())
				        	.hideDelay(3000)
				    );
			    });
				
			}
		};

		$scope.removeLocale = function (){
			for(var i = $scope.locale.length - 1; i >= 0; i-- ){
				if ($scope.locale[i].remove){
					$scope.locale.splice(i, 1);	
				}				
			}			

			$rootScope.loading('show');
		    $scope.save(function (){	
		    	$rootScope.$emit('dataTypeSaved');	    	
				$mdToast.show(
			      	$mdToast.simple()
			        	.content('Locale(s) removed')
			        	.position($scope.getToastPosition())
			        	.hideDelay(3000)
			    );
		    });

			// $scope.item.locale = angular.toJson($scope.locale);
			// MockService[$type].update($scope.item);
			// $rootScope.$emit('dataTypeSaved');
		};

		$scope.save = function (localeTmp, success, error){

 			var item = CoResource.resources.ItemLocale.save({
 				itemId: $scope.item.id
 			}, localeTmp, function(){
				$rootScope.loading('hide');
				$scope.data = null;
				$scope.locale = localeTmp;
				if (success){
					success();
				}
 			}, function (e){
				$rootScope.loading('hide');
				alert(CoResource.textifyError(e.data));
				$scope.data = null;
				if (error){
					error();
				}
			});
		};

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};
	});
}());