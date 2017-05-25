
app
    .config(['$interpolateProvider', '$routeProvider', '$mdThemingProvider', '$httpProvider', '$mdDialogProvider', 'uiGmapGoogleMapApiProvider',
        function($interpolateProvider, $routeProvider, $mdThemingProvider, $httpProvider, $mdDialogProvider, uiGmapGoogleMapApiProvider) {
		$mdThemingProvider.theme('default')
		    .primaryPalette('teal')
		    .accentPalette('green');
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

        for(var key in namespace.routes){
        	var route = namespace.routes[key];
        	$routeProvider
			   .when('/' + route.url, {
				    templateUrl: route.template,
				    controller: route.controller,
                    reloadOnSearch: route.reloadOnSearch
			  	});
        }

        uiGmapGoogleMapApiProvider.configure({
	        key: 'AIzaSyDN67TG8ur4642nLIlvzyu5KflgyQ11ESc',
	        v: '3.17',
	        libraries: 'weather,geometry,visualization'
	    });
        var mode = 'user';

        $httpProvider.interceptors.push(['$location', '$injector', '$q', '$rootScope', '$timeout',
            function($location, $injector, $q, $rootScope, $timeout) {
            return {
                'request': function(config) {
                    //injected manually to get around circular dependency problem.
                    return config;
                },
                // optional method
                'responseError': function(response) {
                    // Unauthorized access
                    if (mode != 'guest'){

                        if (response.status == 401 && (!response.data || response.data.result == 'Unauthorized.')  && !$rootScope.isOpenDialogSession ) {
                            $rootScope.isOpenDialogSession = true;
                            $rootScope.loading('hide');
                            $rootScope.$emit("onAuthorizedFailed");
                        }
                    }
                    return $q.reject(response);
                }
            };
        }]);

        $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

        $mdDialogProvider.addPreset('stackPreset', {
            options: function() {
                return {
                    controllerAs: 'dialogCtrl',
                    controller: function($mdDialog){
                        this.click = function(){
                            $mdDialog.hide();
                        }
                    },
                    preserveScope: true,
                    autoWrap: true,
                    skipHide: true,
                };
            }
        });



    }]);

app.filter('startFrom', function() {
    return function(input, start) {
        if (!input || !input.slice){
            return input;
        }
        start = +start; //parse to int
        return input.slice(start);
    }
});

app.filter('cut', function () {
    return function (value, wordwise, max, tail) {
        if (!value) return '';

        max = parseInt(max, 10);
        if (!max) return value;
        if (value.length <= max) return value;

        value = value.substr(0, max);
        if (wordwise) {
            var lastspace = value.lastIndexOf(' ');
            if (lastspace != -1) {
                value = value.substr(0, lastspace);
            }
        }

        return value + (tail || ' …');
    };
});


app.run(['$http', '$rootScope', '$mdSidenav', '$mdUtil', '$location', '$mdDialog', '$http', '$interval', 'CoResource',
	function ($http, $rootScope,
	$mdSidenav, $mdUtil, $location, $mdDialog, $http, $interval, CoResource){
    var remoteUrl = angular.element('meta[name="se:remoteUrl"]').attr('content');
    $rootScope.remoteUrl = null;
    $rootScope.mediaUrl = '';
    try{
        if (remoteUrl)
        {
            $rootScope.remoteUrl = atob(remoteUrl);
            $rootScope.mediaUrl = $rootScope.remoteUrl;
        }
    }
    catch (e){
        console.info('Sorry, we cannot parse the remote url, now using local url');
    }

    console.log($rootScope.remoteUrl );

    $rootScope.phoneArrayToString = namespace.phoneArrayToString;

	$rootScope.isOpenDialogSession = false;
    // $interval(function() {
    //     $http.get(namespace.domain + 'v1.1/admin/directories?limit=1').success(function(s) {
    //     });
    // }, 10000 * 5);

    $rootScope.stats = {};
    // var messages = CoResource.resources.Message.list({
    //     'scope': 'not-read'
    // }, function (v){
    //     $rootScope.stats.message = messages.options.count;
    // });

    // $rootScope.$on('updateMessageUnreadCount', function (){
    //     messages = CoResource.resources.Message.list({
    //         'scope': 'not-read'
    //     }, function (v){
    //         $rootScope.stats.message = messages.options.count;
    //     });
    // });

	$rootScope.toggleSidenav = function(menuId) {
	    $mdSidenav(menuId).toggle();

	    $rootScope.toggleLeft = buildToggler('left');
	    $rootScope.toggleRight = buildToggler('right');
	    /**
	     * Build handler to open/close a SideNav; when animation finishes
	     * report completion in console
	     */
	    function buildToggler(navID) {
	      var debounceFn =  $mdUtil.debounce(function(){
	            $mdSidenav(navID)
	              .toggle()
	              .then(function () {
	                $log.debug("toggle " + navID + " is done");
	              });
	          },300);
	      return debounceFn;
	    }

	};

    $rootScope.navigateTo = function (path, $event){
        $location.path(path);
    };

	$rootScope.$on("onAuthorizedFailed", function (v){
        var confirm = $mdDialog.confirm()
            .parent(angular.element(document.body))
            .title('Your session timeout')
            .content('Your session has been timeout! Please, login again to continue your session')
            .ariaLabel('Your session timeout')
            .ok('Yes')
            // .cancel('No')
            .targetEvent(null);
        $mdDialog.show(confirm).then(function() {
        	$rootScope.isOpenDialogSession = false;
            window.location.href = "/dashboard/login";
        }, function() {
        	$rootScope.isOpenDialogSession = false;
        	window.location.href = "/dashboard/login";
        });
	});

	$rootScope.loading = function(type){
		if (type === 'show'){
            $('input:enabled, select:enabled, textarea:enabled, button:enabled').not('[name=post-editor]').attr('data-loading', true);
            $('input[data-loading=true], select[data-loading=true], textarea[data-loading=true], button[data-loading=true]').attr('disabled', 'disabled');
			$rootScope.loadingBarVisible = true;
		}
		else{
            $('input[data-loading=true], select[data-loading=true], textarea[data-loading=true], button[data-loading=true]').removeAttr('disabled');
            $('input:enabled, select:enabled, textarea:enabled, button[data-loading=true]   ').data('data-loading', false);
			$rootScope.loadingBarVisible = false;
		}
	};

    $rootScope.fromDate = function (date){
        return moment(date).fromNow();
    };

    $rootScope.fromUtcDate = function (date){
        return moment.utc(date).local().fromNow();
    };

	$rootScope.formatUtcDate = function (date, format){
		return moment.utc(date).local().format(format || 'MMM DD, YYYY HH:mm:ss');
	};

	$rootScope.formatDate = function (date){
		return moment(date).add(moment().utcOffset(), "minutes").format('MMM DD, YYYY HH:mm:ss');
	};

	$rootScope.createNewArticle = function (){
		$location.path('/articles/' + namespace.guid());
	};

	$rootScope.locales = {
		'kh': 'Khmer',
		'cn': 'Chinese'
	};

    $rootScope.type_names = {
        'origin': 'Cuisine',
        'category': 'Purpose',
        'feature': 'Feature',
        'food': 'Time',
        'drink': 'Category',
        'payment_method': 'Payment methods',
        'parking': 'Parking',
    };

}]);
