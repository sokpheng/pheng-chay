/**
 * Created Date: 22 Nov 2016
 * Create By : Flexitech Cambodia Team
 */

// home page controller
app.controller('searchCtrl', function($rootScope, $scope, $http, $timeout, $location, $window, genfunc, hhModule) {

    console.log('searchCtrl');

    $scope.pageChanged = function() {
        // console.log('Page changed to: ' + $scope.currentPage);
        var _s = $rootScope.getParameterByName('s');
        // console.log(s,"===",page);
        if (_s)
            window.location.href = $scope._url + '?s=' + _s + '&page=' + $scope.currentPage;
        else
            window.location.href = $scope._url + '?page=' + $scope.currentPage;

    };

    // $scope.advanceOption = [];
    $scope.searchParam = '';
    $scope.advanceFilterVal = [];

    $scope.getUrlToMap = function(){
        var _filterVal = $scope.advanceFilterVal.join('--');
        return _filterVal.toLowerCase();
    }

    $scope.applyFilter = function(){
        // console.log($scope.advanceFilterVal);
        $scope.advanceSearchNow();
    }

    // clear filter 
    $scope.clearFilter = function(){ 
        // console.log('fuck');
        $scope.advanceFilterVal = [];
        // console.log($scope.advanceOption);

        _.each($scope.advanceOption,function(v, k){
            // console.log(v);
            _.each(v,function(v_sub, k_sub){

                v_sub.checked = false;

            });

        });

        // console.log($scope.advanceOption);

    }

    $scope.advanceSearchNow = function() {
        // console.log($scope.advanceFilterVal);
        var _filterVal = $scope.advanceFilterVal.join('--');
        // var _filterVal = '';
        // if($scope.advanceFilterVal.length > 1){
        //     _filterVal = $scope.advanceFilterVal.join('--');
        // }
        // console.log(_filterVal.toLowerCase(),'=',genfunc.getURL());
        $window.location.href = genfunc.getURL() + genfunc.getUrlLang() + "/search?s=" + _filterVal.toLowerCase();
    }

    $scope.advanceSearchFilter = function(item, isFilterNow){
        console.log(item);

        var chkExist = _.find($scope.advanceFilterVal, function(v,k){
            return hhModule.urlSlug(item.display_name) == hhModule.urlSlug(v);
        });

        if(item.checked){
            // console.log(chkExist);
            if(!chkExist){
                $scope.advanceFilterVal.push(hhModule.urlSlug(item.display_name));
            }
        }
        else{
            // console.log('false wowowowo')
            if(chkExist)
                $scope.advanceFilterVal = _.reject($scope.advanceFilterVal, function(v,k){
                return hhModule.urlSlug(item.display_name) == hhModule.urlSlug(v);
            });
        }

        console.log($scope.advanceFilterVal);

        // if(isFilterNow){
            $scope.advanceSearchNow();
        // }
        
    }

    // filter top cate option
    $scope.filterTopCate = function(itemVal){


        var _titleVal = hhModule.urlSlugFixCafe(itemVal);

        console.log($scope.advanceFilterVal);

        var chkExist = _.find($scope.advanceFilterVal, function(v,k){ 
            return v == _titleVal
        });

        console.log(chkExist);

        if(chkExist && chkExist.length>0){
            $scope.advanceFilterVal = _.filter($scope.advanceFilterVal, function(v,k){
                return v != _titleVal;
            });
        }
        else{
            $scope.advanceFilterVal.push(_titleVal);
        }

        console.log($scope.advanceFilterVal);

        $scope.advanceSearchNow();
    }


    $scope.checkSelectOnFirstLoad = function(item){
        // if()
        var _name = hhModule.urlSlug(item.display_name);
        // console.log(_name);
        // console.log(_.includes($scope.advanceFilterVal, _name));

        // _.each($scope.advanceFilterVal, function(v,k){
        //     console.log(v,' == ',_name);
        // })

        return _.includes($scope.advanceFilterVal, _name);
    }

    $scope.initAdvanceSearch = function(){

        // var _s = window.location.search;
        // _s = _s.replace('?s=','');

        var _s = $scope.searchParam;
        // console.log(_s);
        if(_s!='')
            $scope.advanceFilterVal = _s.split('--');

        console.log($scope.advanceFilterVal);

    }

    // $scope.$on('finishedRenderList', function() {
       
    //     if ($('.popupFilterMore').length > 0) {
    //         $('.popupFilterMore').magnificPopup({
    //             type: 'inline',
    //             midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
    //         });
    //     }

    // });

    $scope.selectCouponPromo = function(_id){
        console.log(_id,' == ', $scope.couponPromo);
        _.each($scope.couponPromo, function(v,k){

            if(k==_id){
                $scope.couponPromoSelected = v;
            }

        });
        console.log($scope.couponPromoSelected);
    }

    $(function() {

        $(".menu-with-border-bottom").stick_in_parent({offset_top: -80});
        // $rootScope.searchParam = $scope.searchParam;
        $scope.initAdvanceSearch();

        // console.log( window.location.hash);
        // $scope.getRestNearBy();
        $('.popupAdvanceFilter').magnificPopup({
            removalDelay: 300,

            // Class that is added to popup wrapper and background
            // make it unique to apply your CSS animations just to this exact popup
            mainClass: 'mfp-fade',
            type: 'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        });

        // if ($('.popupFilterMore').length > 0) {
            $('.popupFilterMore').magnificPopup({
                removalDelay: 300,

                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                mainClass: 'mfp-fade',
                type: 'inline',
                midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
            });
        // }

    })

});