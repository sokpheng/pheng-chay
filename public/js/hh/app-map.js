/**
 * Created Date: 04 Nov 2016
 * Create By : Flexitech Cambodia Team
 */


var app = angular.module('app', ['ui.bootstrap', 'uiGmapgoogle-maps', 'facebook', 'ngMessages', 'contenteditable', 'ngFileUpload', 'onFinishRenderRepeat','ngRoute']);

var namespace = {};
namespace.routes = [];

// app.config(['$routeProvider','$httpProvider',function($routeProvider, $httpProvider, $rootScope, FacebookProvider) {
app.config(function(FacebookProvider, $interpolateProvider,$routeProvider) {
    // $httpProvider.defaults.headers.common['Access-Control-Allow-Headers'] = '*';


    var fbId = $('meta[name="fb:appId"]');
    fbId = fbId ? fbId.attr('content') : '';
    
    if(!fbId || fbId== "undefined") 
        fbId = '';   
    
    console.log("fbId",fbId);

    // console.log(fbId, "dsfsdfsdfsd");

    FacebookProvider.init({
        appId: fbId
    });


    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

    // for(var key in namespace.routes){
    // 	var route = namespace.routes[key];
    // 	$routeProvider
    //  .when('/' + route.url, {
    //    templateUrl: route.template,
    //    controller: route.controller,
    //             reloadOnSearch: route.reloadOnSearch
    // 	});
    // }

    // console.log($scope.quatation_info);

    $routeProvider.
    when('/', {
        controller: 'restMapCtrl',
        reloadOnSearch: false
    }).
    otherwise({
        redirectTo: '/'
    });

}).run(function($rootScope, $location, hhModule, Request, genfunc, $timeout, $window) {

    // console.log('root run');
    // 
    $rootScope.map_route = '';

    $rootScope.hhModule = hhModule;

    $rootScope.moveToEle = function(ele, isIncludeHeader, delay) {
        // console.log(ele,$(''+ele));
        delay = delay ? delay : 1000;
        var headerOffset = 72;
        if (isIncludeHeader)
            headerOffset = 0;

        if ($(ele).length > 0) {
            $('html, body').stop().animate({
                scrollTop: $('' + ele).offset().top - headerOffset
            }, delay, function() {
                // $scope.success = false;
                // $scope.$apply();
            });
        }
    }

    // get param in js
    $rootScope.getParameterByName = function(name, url) {
        if (!url) {
            url = window.location.href;
        }
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    var num_per_page = 10;
    var cur_page = 1;

    $rootScope.getNotification = function(){
        var _offset = (cur_page - 1) * num_per_page;
        // console.log(_offset);
        var url = '/notifications?limit='+num_per_page+'&offset='+_offset;
        Request.get(url)
            .success(function(data, status, headers, config) {
                if (data.code == 200) {
                    // console.log("============= requestUserAction");
                    // console.log(data.result);
                    if(cur_page===1)
                        $rootScope.notiList = data.result;
                    else
                        $rootScope.notiList = $rootScope.notiList.concat(data.result);

                    cur_page++;
                }
            })
            .error(genfunc.onError);
    }

    $rootScope.getNotificationUnSeen = function(){
        var url = '/notifications/unseen';
        Request.get(url)
            .success(function(data, status, headers, config) {
                if (data.code == 200) {
                    // console.log("============= requestUserAction");
                    // console.log(data.result);
                    $rootScope.unseenCount = data.result;
                }
            })
            .error(genfunc.onError);
    }


    $rootScope.scrollToEle = function(ele) {
        var elem = $(ele);
        if(elem.length>0){
            $('html, body').animate({
                scrollTop: elem.offset().top
            }, 500);
        }
        else{
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        }
    }

    $rootScope.setNotificationAsSeen = function(){

        if($rootScope.unseenCount<=0)
            return;

        var url = '/notifications/seen';
        Request.post(url)
            .success(function(data, status, headers, config) {
                if (data.code == 200) {
                    // console.log("============= requestUserAction");
                    // console.log(data.result);
                    $rootScope.unseenCount = 0;
                }
            })
            .error(genfunc.onError);
    }

    var _defaultUrl = $('.navbar-nav .lang .nav-link').attr('href');
    $rootScope.updateUrlLangNav = function(){
        $('.navbar-nav .lang .nav-link').attr('href',_defaultUrl+'/'+window.location.hash);
        // console.log($('.navbar-nav .lang .nav-link').attr('href'));
    }


    // ========== advance filter for all ==========

    $rootScope.advanceFilterVal = [];
    $rootScope.searchParam = '';

    $rootScope.applyFilter = function(){
        // console.log($rootScope.advanceFilterVal);
        $rootScope.advanceSearchNow();
    }

    // clear filter 
    $rootScope.clearFilter = function(){
        // console.log('cuck');
        $rootScope.advanceFilterVal = [];
        
        _.each($rootScope.advanceOption,function(v, k){

            _.each(v,function(v_sub, k_sub){

                v_sub.checked = false;

            });

        });

        // console.log($rootScope.advanceFilterVal);

    }

    $rootScope.advanceSearchNow = function() {
        var _filterVal = $rootScope.advanceFilterVal.join('--');
        $window.location.href = genfunc.getURL()+ "/search?s=" + _filterVal.toLowerCase();
        $.magnificPopup.close();
    }

    $rootScope.advanceSearchFilter = function(item, isFilterNow){
        // console.log(item);

        var _title = hhModule.urlSlug(item.display_name)

        var chkExist = _.find($rootScope.advanceFilterVal, function(v,k){
            return _title == v;
        });

        if(item.checked){
            // console.log(chkExist);
            if(!chkExist){
                $rootScope.advanceFilterVal.push(_title);
            }
        }
        else{
            // console.log('false wowowowo')
            if(chkExist)
                $rootScope.advanceFilterVal = _.reject($rootScope.advanceFilterVal, function(v,k){
                return _title == v;
            });
        }

        console.log($rootScope.advanceFilterVal);
        
    }

    $rootScope.checkSelectOnFirstLoad = function(item){
        // if()
        var _name = hhModule.urlSlug(item.display_name);
        // console.log(_name);
        // console.log(_.includes($scope.advanceFilterVal, _name));

        // _.each($scope.advanceFilterVal, function(v,k){
        //     console.log(v,' == ',_name);
        // })

        return _.includes($rootScope.advanceFilterVal, _name);
    }

    $rootScope.initAdvanceSearch = function(){

        // var _s = window.location.search;
        // _s = _s.replace('?s=','');
        // console.log($rootScope.searchParam);
        var _s = $rootScope.searchParam;
        // console.log(_s);
        if(_s!='')
            $rootScope.advanceFilterVal = _s.split('--');

        // console.log($rootScope.advanceFilterVal);

        _.each($rootScope.advanceOption,function(v, k){

            _.each(v,function(v_sub, k_sub){

                v_sub.checked = $rootScope.checkSelectOnFirstLoad(v_sub);

            });

        });

    }


    // ========== end advance filter for all ==========



    // {{-- fix tab bug of bootstrap 4 --}}
    // {{-- because we use custom class to create menu tab --}}
    $(function(){

        $rootScope.initAdvanceSearch();


        $('.popupAdvanceFilter').magnificPopup({
            removalDelay: 300,

            // Class that is added to popup wrapper and background
            // make it unique to apply your CSS animations just to this exact popup
            mainClass: 'mfp-fade',
            type: 'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        });

        if(genfunc.getUser())
            $rootScope.getNotification();
        
        if(genfunc.getUser())
            $rootScope.profilePhoto = hhModule.getProfilePic();
        


        // trigger scroll to check toggle scroll-top
        setTimeout(function() {
            $(window).trigger('scroll');
        }, 250);

        // check to disable scroll top
        $(window).scroll(function(e) {
            var st = $(this).scrollTop();
            // console.log(st);
            if (st > 350) {
                $('footer .scroll-top').fadeIn(200);
            } else {
                $('footer .scroll-top').fadeOut(200);
            }
        });

        // $rootScope.getNotificationUnSeen();
        
        // $(".noti-container-list").nanoScroller({preventPageScrolling: true});

        $('.acc-noti .btn-load-more').click(function(e) {
            e.stopPropagation();
        });

        $('.menu-with-border-bottom').on('shown.bs.tab', 'a', function(e) {
            // console.log(e.relatedTarget);
            if (e.relatedTarget) {
                $(e.relatedTarget).removeClass('active');
            }
        });
        
    })

});