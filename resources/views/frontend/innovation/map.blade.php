@extends('layouts/innovation')

@section('title','Page title')

@section('content')

<div style="margin-left:20px; width: 90%;">

	<div ng-controller="mapCtrl" class="selectContainer tb" > 


	{{-- <pre>{{ print_r($filterData, true) }}</pre> --}}

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


        <div id="container"></div>


 
		<span id="tmpData" ng-init="mapData={{ json_encode($mapData) }}"></span>

{{--         <div  class="table-responsive"> 

            <table cellspacing="5px" class="table table-bordered">

                      <tr ng-repeat="data in mapData">

                          <td><% data.lab | uppercase %></td>
                          <td><% data.city | uppercase %></td>
                          <td><% data.industry | uppercase %></td>
                          <td><% data.tags | uppercase %></td>
                                  
                      </tr> 
                      
            </table>

        </div>

        <span ng-init="currentPage=1;totalItem=100;maxSize=10;itemPerPage=20"></span>

	    <div class="text-xs-center">

	        <ul uib-pagination total-items="totalItem" ng-model="currentPage" items-per-page="itemPerPage" max-size="maxSize" template-url="{{ asset('template/pagination.html') }}" class="pagination-md" boundary-link="true" force-ellipses="true" rotate="true" previous-text="Previous" next-text="Next" ng-change="pageChanged()">
	        	
	        </ul>

	    </div> --}}

    </div>

</div>


@endsection

@section('myScript')

@if(isset($neverTrue))

	<script>

		var App = angular.module('myApp',[]); 

		    App.config(function($interpolateProvider) {
		          $interpolateProvider.startSymbol('<%');
		          $interpolateProvider.endSymbol('%>');
		    });



			App.controller("AppController",function($scope) {
			          // $scope.test2.Strategy = [];
			          $scope.listOfData=[

			                {
			                  "id":"1",
			                  "Country":"Cambodia",      
			                  "City":"Phnum-penh",
			                  "Industry":"Art",
			                  "Strategy":"HQ",       
			                },
			                {
			                  "id":"2",
			                  "Country":"Thai",      
			                  "City":"Bang-Kok",
			                  "Industry":"Technology",
			                  "Strategy":"CEO",       
			                },
			                {
			                  "id":"3",
			                  "Country":"Lao",      
			                  "City":"Vientiane",
			                  "Industry":"Accounting",
			                  "Strategy":"CNEO",       
			                },
			                {
			                  "id":"4",
			                  "Country":"Vietnam",      
			                  "City":"Ho-qi-ming",
			                  "Industry":"Accommodations",
			                  "Strategy":"AK",       
			                },

			            ];
			}); 
		 

				var worlddata = {

					'BHS':' ',
					'CAN':'Canada',
					'GRL':'Greenlane',
					'USA':'United state',
					'RUS':'Russia',
					'CHN':'China',
					'MEX':'Mexico',
					'BRA':'Brazil',
					'ARG':'Argentina',
					'COL':' ',
					'GBR':'UK',
					'FRA':'France',
					'IND':'India',
					'PAK':'Pakistan',
					'CHN':'China',
					'AUS':'Australia',
					'ZAF':'South Africa',
					'SAU':'Saudi Arabia',
					'DZA':'Algeria',
					'LBY':'Libya',
					'SDN':'Sudan',
					'COG':'Congo',
					'IDN':'Indonasia',
					'-99':' ',

					'AFG':' ',
					'AGO':' ',
					'ALB':' ',
					'ARE':' ',
					
					'ARM':' ',
					'ATF':' ',
					
					'AUT':' ',
					'AZE':' ',
					'BDI':' ',
					'BEL':' ',
					'BEN':' ',
					'BFA':' ',
					'BGD':' ',
					'BGR':' ',
					'BIH':' ',
					'BLR':' ',
					'BLZ':' ',
					'BOL':' ',
					
					'BRN':' ',
					'BTN':' ',
					'BWA':' ',
					'CAF':' ',
					'CHE':' ',
					'CHL':' ',

					'CIV':' ',
					'CMR':' ',
					'COD':' ',
					
					
					'CRI':' ',
					'CUB':' ',
					'CYP':' ',
					'CZE':' ',
					'DEU':' ',
					'DJI':' ',
					'DNK':' ',
					'DOM':' ',
					
					'ECU':' ',
					'EGY':' ',
					'ERI':' ',
					'ESP':' ',
					'EST':' ',
					'ETH':' ',
					'FIN':' ',
					'FJI':' ',
					'FLK':' ',
					
					'GUF':' ',
					'GAB':' ',
					
					'GEO':' ',
					'GHA':' ',
					'GIN':' ',
					'GMB':' ',
					'GNB':' ',
					'GNQ':' ',
					'GRC':' ',
					'GTM':' ',
					'GUY':' ',
					'HND':' ',
					'HRV':' ',
					'HTI':' ',
					'HUN':' ',
					
					
					'IRL':' ',
					'IRN':' ',
					'IRQ':' ',
					'ISL':' ',
					'ISR':' ',
					'ITA':' ',
					'JAM':' ',
					'JOR':' ',
					'JPN':' ',
					'KAZ':' ',
					'KEN':' ',
					'KGZ':' ',
					'KHM':' ',
					'KOR':' ',
					'KWT':' ',
					'LAO':' ',
					'LBN':' ',
					'LBR':' ',
					
					'LKA':' ',
					'LSO':' ',
					'LTU':' ',
					'LUX':' ',
					'LVA':' ',
					'MAR':' ',
					'MDA':' ',
					'MDG':' ',
					
					'MKD':' ',
					'MLI':' ',
					'MMR':' ',
					'MNE':' ',
					'MNG':' ',
					'MOZ':' ',
					'MRT':' ',
					'MWI':' ',
					'MYS':' ',
					'NAM':' ',
					'NCL':' ',
					'NER':' ',
					'NGA':' ',
					'NIC':' ',
					'NLD':' ',
					'NOR':' ',
					'NPL':' ',
					'NZL':' ',
					'OMN':' ',
					
					'PAN':' ',
					'PER':' ',
					'PHL':' ',
					'PNG':' ',
					'POL':' ',
					'PRI':' ',
					'PRK':' ',
					'PRT':' ',
					'PRY':' ',
					'QAT':' ',
					'ROU':' ',
					
					'RWA':' ',
					'ESH':' ',
					

					'SSD':' ',
					'SEN':' ',
					'SLB':' ',
					'SLE':' ',
					'SLV':' ',

					'SOM':' ',
					'SRB':' ',
					'SUR':' ',
					'SVK':' ',
					'SVN':' ',
					'SWE':' ',
					'SWZ':' ',
					'SYR':' ',
					'TCD':' ',
					'TGO':' ',
					'THA':' ',
					'TJK':' ',
					'TKM':' ',
					'TLS':' ',
					'TTO':' ',
					'TUN':' ',
					'TUR':' ',
					'TWN':' ',
					'TZA':' ',
					'UGA':' ',
					'UKR':' ',
					'URY':' ',
					
					'UZB':' ',
					'VEN':' ',
					'VNM':' ',
					'VUT':' ',
					'PSE':' ',
					'YEM':' ',
					
					'ZMB':' ',
					'ZWE':' ',
				};



				var bombMap = new Datamap({
					element: document.getElementById('container'),
					scope: 'world', 
					 responsive: true,
					fills: {
				        'USA': '#1f77b4',
				        'RUS': '#9467bd',
				        'PRK': '#ff7f0e',
				        'PRC': '#2ca02c',
				        'IND': '#e377c2',
				        'GBR': '#8c564b',
				        'FRA': '#d62728',
				        'PAK': '#7f7f7f',
				        defaultFill: '#EDDC4E'
					},
				    data: {
				        'RUS': {fillKey: 'RUS'},
				        'PRK': {fillKey: 'PRK'},
				        'PRC': {fillKey: 'PRC'},
				        'IND': {fillKey: 'IND'},
				        'GBR': {fillKey: 'GBR'},
				        'FRA': {fillKey: 'FRA'},
				        'PAK': {fillKey: 'PAK'},
				        'USA': {fillKey: 'USA'}
				    }
						});

				window.addEventListener('resize', function() {
			        bombMap.resize();
			    });

			    // Alternatively with d3
			    d3.select(window).on('resize', function() {
			        bombMap.resize();
			    });

			    // Alternatively with jQuery
			    $(window).on('resize', function() {
			       bombMap.resize();
			    }); 

			    

				var bombs = [{
					name: 'Joe 4',
					radius: 10,
					yield: 400,
					country: 'USSR',
					fillKey: 'RUS',
					significance: 'First fusion weapon test by the USSR (not "staged")',
					date: '1953-08-12',
					latitude: 50.07,
					longitude: 100.43
					},{
					name: 'RDS-37',
					radius: 10,
					yield: 1600,
					country: 'USSR',
					fillKey: 'RUS',
					significance: 'First "staged" thermonuclear weapon test by the USSR (deployable)',
					date: '1955-11-22',
					latitude: 50.07,
					longitude: 78.43

					},{
					name: 'Tsar Bomba',
					radius: 10,
					yield: 50000,
					country: 'USSR',
					fillKey: 'RUS',
					significance: 'Largest thermonuclear weapon ever tested—scaled down from its initial 100 Mt design by 50%',
					date: '1961-10-31',
					latitude: 73.482,
					longitude: 54.5854
					}
				];
				


//draw bubbles for bombs
		bombMap.bubbles(bombs, {
	        popupTemplate: function (geo, data) {
	            return ['<div class="hoverinfo">' +  data.name,
	            '<br/>Payload: ' +  data.yield + ' kilotons',
	            '<br/>Country: ' +  data.country + '',
	            '<br/>Date: ' +  data.date + '',
	            '<br/> ' + '<button class="btnlist">See full list</button>' + '',
	            '</div>'].join('');
	    }

	});

	bombMap.labels({'customLabelText': worlddata});

	d3.selectAll(".datamaps-bubble").on('click', function(geography) {
	    console.log(bombs);
	    alert(geography.name);
	    '<button>Hello</button>'
	});
	</script>

@endif



@stop



