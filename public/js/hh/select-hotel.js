/**
 * Created Date: 10 Mar 2017
 * Developer: Panhna Seng
 * Create By : Flexitech Cambodia Team
 */

// select hotel page controller
app.controller('selectHotelCtrl', function($rootScope, $scope, $http, $timeout, $location, $window, genfunc, hhModule, Request) {

    console.log('selectHotelCtrl');

    // $scope.hhModule = hhModule;


    $scope.hotelList = [];
    $scope.min_price = 10;
    $scope.max_price = 120;

    $scope.firstInit = false;


    $scope.itemLimit = 10;
    $scope.offset = 0;



    $scope.location = ''; 
    $scope.filterRate = '';


    $scope.filter = {};

    // page chanage pagination
    $scope.pageChanged = function() {
        // console.log('Page changed to: ' + $scope.currentPage);

        $scope.offset = ($scope.currentPage * $scope.itemLimit) - $scope.itemLimit;
        // console.log($scope.offset);
        $scope.getHotelList();

    };

    // init star
    $scope.initStar = function(item){

        var _rateCount = hhModule.getStarRate(item.rate);

        item.rateStar = [];

        for (var i = 1; i <=5; i++) {
            // console.log(i);
            if(i <= _rateCount){
                item.rateStar.push({
                    id: i,
                    selected: true
                })
            }
            else{
                item.rateStar.push({
                    id: i,
                    selected: false
                })
            }
        }
                
    }


    // get hotel list
    $scope.getHotelList = function(){

        var _filterPriceRage = '&min_price='+$scope.min_price+'&max_price='+$scope.max_price;

        Request.get('v1/hotels?cache=false&filters=&limit=' + $scope.itemLimit + _filterPriceRage + '&rate='+$scope.filterRate+'&location='+$scope.location+'&offset='+$scope.offset+'&search='+($rootScope.booking.search_text || $scope.filter.searchTxt || '')+'&sorts=&populate=cover').success(function(data, status, headers, config) {

            $scope.firstInit = true;

            if (data.code == 200) {
                // console.log("============= loadMore");
                console.log(data);

                $scope.options = data.options;

                $scope.hotelList = data.result;

                console.log($scope.options);

            }

        }).error(function(){
            
            genfunc.onError

        });
    }

    //
    $scope.$watch('rate', function(newValue, oldValue) {
        // console.log(newValue);
        if(!newValue)
            return;
        $scope.filterRate = newValue || '';

        $scope.getHotelList();

    });


    // search now with search text-box
    $scope.searchNow = function(){

        console.log($scope.filter);

        $scope.getHotelList();

    }

    // hovering over onstar
    $scope.hoveringOver = function(value) {
        $scope.overStar = value;
        $scope.percent = 100 * (value / $scope.max);
    };

    // init filter option of price range
    $scope.initFilterOption = function() {
        $scope.rate = 1;
        $scope.max = 5;
        // $scope.isReadonly = false;
    }

    // lcoation search
    $scope.locationSearch = function(item){

        // console.log(item);

        _.each($scope.popular, function(v,k){
            // console.log(v.slug, item.slug)
            if(v.slug != item.slug)
                v.checked = false;
        })

        // if(item.checked == true)
        //     item.checked = false
        // else
        //     item.checked = true;
        if(item.checked)
            $scope.location = item.title;
        else
            $scope.location = '';

        $scope.getHotelList();

    }

    // $.getJSON('http://freegeoip.net/json/', function(result) {
    //     console.log(result);
    // });

    $(function(){


        $("#price-range-slider").slider({
            max: 200,
            min: 10,
            range: true,
            values: [$scope.min_price, $scope.max_price],
            step: 5 
        }).on("slidechange", function(e, ui) {
            console.log(ui)

            $scope.min_price = ui.values[0];
            $scope.max_price = ui.values[1];
            $scope.$apply();

            $scope.getHotelList();


        });

    	$scope.getHotelList();

    })


});