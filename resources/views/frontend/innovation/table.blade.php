<!--  -->
@extends('layouts/innovation')

@section('title','Page title')

@section('content')


  <div ng-controller="tableCtrl" class="selectContainer tb" > 

    <!-- {{-- <pre>{{ print_r($filterData, true) }}</pre> --}} -->


      <div class="selectItem tb upper">

              <select name="singleselect" class="js-example-basic-multiple single" ng-model="select.Country" single id="singleselect" ng-change="countryChange()">
                <option value="" disabled  >---Country---</option>

                 @foreach($filterData['country'] as $item)

                  <option value="{{ $item['_id'] }}">{{ strtoupper ($item['_id']) }}</option>

                 @endforeach

              </select>

              <select name="singleselect" class="js-example-basic-multiple single" ng-model="select.Strategy" signle id="singleselect"  ng-change="strategyChange()">

                <option value="" disabled  >---Strategy---</option>

                 @foreach($filterData['strategies'] as $item)

                   <option value="{{ $item['_id'] }}">{{ strtoupper ($item['_id']) }}</option>

                 @endforeach
                

              </select>


              <select name="singleselect" class="js-example-basic-multiple single" ng-model="select.Industry" single id="singleselect"  ng-change="industryChange()">

                <option value="" disabled  >---Industry---</option>

                  @foreach($filterData['industry'] as $item)

                   <option value="{{ $item['_id'] }}">{{ strtoupper ($item['_id']) }}</option>

                  @endforeach

              </select>


      </div>

  <br>
      <!-- <% select.Industry | json %> -->
      <div class="selectItem2 " ng-init=""> 
        
                <select name="singleselect" class="js-example-basic-multiple multi" ng-model="select.Tags" multiple id="singleselect" ng-change="tagsChange()">
                  <option value="" disabled >---Tags---</option>

                   @foreach($filterData['tags'] as $item)

                      <option value="{{ $item['_id'] }}">{{ strtoupper ($item['_id']) }}</option>

                   @endforeach

                </select>

      </div>          

      <br>
      <div style="text-align: center">
        <button class="btn-success">GENERATE MAP</button>
      </div>
      <br>

      <span id="tmpData" ng-init="listOfDataNew={{ json_encode($tableData) }}"></span>
      <!-- <pre><% listOfDataNew | json %></pre> -->
      <div  class="table-responsive"> 
            <table cellspacing="5px" class="table table-bordered">
                      <tr>
                            <td class="upper" >Country</td>
                            <td class="upper">Strategies</td>
                            <td class="upper">Industry</td>
                            <td class="upper">Tags</td>
                          
                      </tr>

                      <tr ng-repeat="data in listOfDataNew ">

                          <td><% data.country_name | uppercase %></td>
                          <td><% data.strategies | uppercase %></td>
                          <td><% data.industry | uppercase %></td>
                          <td><% data.tags | uppercase %></td>
                                  
                      </tr> 
                      
            </table>
      </div>


      <span ng-init="currentPage=1;totalItem=100;maxSize=10;itemPerPage=20"></span>

      <div class="text-xs-center">
        <ul uib-pagination total-items="totalItem" ng-model="currentPage" items-per-page="itemPerPage" max-size="maxSize" template-url="{{ asset('template/pagination.html') }}" class="pagination-md" boundary-link="true" force-ellipses="true" rotate="true" previous-text="Previous" next-text="Next" ng-change="pageChanged()"></ul>
      </div>

  </div> 

@endsection

@section('myScript')

@if(isset($neverTrue))

  <script>

      var App = angular.module('myapp',[]); 

       App.config(function($interpolateProvider) {
          $interpolateProvider.startSymbol('<%');
          $interpolateProvider.endSymbol('%>');
        })


       App.controller("AppController",function($scope) {
          // $scope.test2.Strategy = [];
          // $scope.listOfData=[

          //       {
          //         "id":"1",
          //         "Country":"Cambodia",      
          //         "City":"Phnum-penh",
          //         "Industry":"Art",
          //         "Strategy":"HQ",       
          //       },
          //       {
          //         "id":"2",
          //         "Country":"Thai",      
          //         "City":"Bang-Kok",
          //         "Industry":"Technology",
          //         "Strategy":"CEO",       
          //       },
          //       {
          //         "id":"3",
          //         "Country":"Lao",      
          //         "City":"Vientiane",
          //         "Industry":"Accounting",
          //         "Strategy":"CNEO",       
          //       },
          //       {
          //         "id":"4",
          //         "Country":"Vietnam",      
          //         "City":"Ho-qi-ming",
          //         "Industry":"Accommodations",
          //         "Strategy":"AK",       
          //       },

          //   ];
            // $scope.listOfDataNew = angular.copy($scope.listOfData);


            // console.log($scope.listOfDataNew);


            // $scope.isFirstTime = false;

            // $scope.$watch('select', function() {
            //   // console.log("here");
            //     // if($scope.isFirstTime)
            //     //   $scope.filter($scope.select);

            //     // $scope.isFirstTime = true;
            // });


            //  $scope.filter = function(item){
            //   console.log('City : ',item);
           
            //     var result_combobox = _.filter($scope.listOfData , function(v,k){


            //       if(v.Country == item.Country || v.City==item.City || v.Industry==item.Industry){
            //         return true;
            //         console.log('City: ',item);
            //       }

            //       return false  ;
            //     })


            //     $scope.listOfDataNew = result_combobox;
            //     // var _tmpCity = _.filter($scope.listOfData, function(v,k){
            //     //   // console.log('V : ',v)
            //     //   return v.City == item.City;
            //     // })        

            // }


            // $scope.myFilter = function(item){
            //      console.log("item.Strategy[0]"+ item.Strategy);
            //   // console.log('City : ',item);
            //   if($scope.select){
            //     var _tmp = _.filter($scope.listOfData , function(v,k){


            //       if(v.Country == item.Country && v.City==item.City && v.Industry==item.Industry && v.Strategy==item.Strategy){
            //         return true;
            //       }

            //       return false  ;
            //     })
            //     // var _tmpCity = _.filter($scope.listOfData, function(v,k){
            //     //   // console.log('V : ',v)
            //     //   return v.City == item.City;
            //     // })        

            //     console.log(_tmp, ' === ');




            //     return _tmp.length>0 ? true : false;
            //   }

            //   else{
            //     return true;
            //   }

            // }
 
        
      });      
 

  </script>
@endif
 

@stop
