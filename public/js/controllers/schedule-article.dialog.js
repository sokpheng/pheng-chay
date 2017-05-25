(function() {
    app.controller('ScheduleArticleDialogCtrl', function($scope, CoResource, Upload, 
    	$rootScope, $mdDialog, $mdToast, $current, $data, $timeout) {

    	$scope.data = {
    	};
    	$scope.mode = 'create';

    	if ($current){
    		$scope.data = angular.copy($current);
    		$scope.mode = 'edit';
    	}
    	
    	$scope.data.start_date = moment().format('YYYY-MM-DD HH:mm:ss');
    	$scope.data.scheduled_at = moment().format('YYYY-MM-DD HH:mm:ss');

    	$scope.toastPosition = {
	    	bottom: false,
	    	top: true,
	    	left: false,
	    	right: true
	  	};

	 	$scope.close = function (){
	 		$mdDialog.hide();
	 	};

	  	$scope.getToastPosition = function() {
	    	return Object.keys($scope.toastPosition)
	      		.filter(function(pos) { return $scope.toastPosition[pos]; })
	      		.join(' ');
	  	};

    	$scope.schedule = function ($event){
    	    $scope.data.scheduled_at = moment($("#datepicker").datepicker('getFormattedDate')).format('YYYY-MM-DD') + ' ' + $scope.data.time;
            if (!moment($scope.data.scheduled_at).isValid()){
                $scope.data.scheduled_at = moment($("#datepicker").datepicker('getFormattedDate')).format('YYYY-MM-DD') + ' 08:00:00';
            }
    	   // console.log($scope.data);
    	   // return;
    		$rootScope.loading('show');
    		CoResource.resources.Article.schedule({
                articleId: $scope.data.id
            }, {
                scheduled_at: moment($scope.data.scheduled_at).utc().format('YYYY-MM-DD HH:mm:ss')
            }, function(s) {
                $rootScope.loading('hide');
                $mdDialog.hide();
                $scope.data.scheduled_at = s.result.scheduled_at;
                $mdToast.show(
                    $mdToast.simple()
                    .content('Article scheduled')
                    .position($scope.getToastPosition())
                    .hideDelay(3000)
                );
                $rootScope.$emit('articleScheduled', $scope.data);
            }, function(e) {
                $rootScope.loading('hide');
                alert('There was an error while trying to update your article. Error: ' + e.result);
            });
    	};
    	
    	$timeout(function (){
        	$('#datepicker').datepicker({
        	});
            $("#datepicker").on("changeDate", function(event) {
                // $scope.data.scheduled_at = moment($("#datepicker").datepicker('getFormattedDate')).format('YYYY-MM-DD') + ' ' + $scope.data.time;
                // if (!moment($scope.data.scheduled_at).isValid()){
                //     $scope.data.scheduled_at = moment($("#datepicker").datepicker('getFormattedDate')).format('YYYY-MM-DD') + ' 08:00:00';
                // }
                // $scope.$apply();
                // $("#my_hidden_input").val(
                //     $("#datepicker").datepicker('getFormattedDate')
                // );
            });
    	}, 1000);
    });
}());