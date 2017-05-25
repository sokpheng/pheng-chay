
app.controller('tableCtrl', function($rootScope, $scope, $http, $timeout, CryptService, Request, genfunc, Facebook, $location) {

 //  $scope.currentPage = 0;
 // $scope.totalItem= 100;
 // $scope.currentPage=1;

 // currentPage=1;totalItem=100;max-sizexSize=8;itemPerPage=20
 //    // $scope.select={
 //    //   'Country':{
 //    //     _id:''
 //    //   }
 //    // }

 $scope.select = {};

    $scope.pageChanged=function() {


        console.log($scope.currentPage);

        offset = ($scope.currentPage - 1) * $scope.itemPerPage;

        $scope.getFilterTable();
      } 

    $scope.countryChange = function(){
      console.log($scope.select.Country);
      $scope.getFilterTable();
    }

    $scope.strategyChange = function(){
      console.log($scope.select.Strategy);
      $scope.getFilterTable();
    }

    $scope.industryChange = function(){
      console.log($scope.select.Industry);
      $scope.getFilterTable();
    }

    $scope.tagsChange = function(){
      console.log($scope.select.Tags);
      $scope.getFilterTable();
    }
    // get hotel list
    $scope.getFilterTable = function(){

        // var _filterPriceRage = '&min_price='+$scope.min_price+'&max_price='+$scope.max_price;
        var _country = $scope.select.Country||'' ;
        var _strategies=$scope.select.Strategy||'';
        var _industry=$scope.select.Industry||'';
        var _tags=$scope.select.Tags||'';

        offset = ($scope.currentPage - 1) * $scope.itemPerPage;

        Request.get('v1/startups?country=' + _country + '&strategies=' + _strategies + '&industry=' + _industry + '&tags=' + _tags  + '&offset=' + offset + '&limit=' + $scope.itemPerPage ).success(function(data, status, headers, config) {

            // $scope.firstInit = true;

            if (data.code == 200) {
                // console.log("============= loadMore");
                console.log('result filter : ',data);

                $scope.listOfDataNew=data.result;
                $scope.totalItem=data.options.total;

             
            }

        }).error(function(){
            
            genfunc.onError

        });
    }




    $(function(){

    	$(".js-example-basic-multiple").select2();


    })

});