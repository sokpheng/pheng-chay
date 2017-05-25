app.controller('mapCtrl', function($rootScope, $scope, $http, $timeout, CryptService, Request, genfunc, Facebook, $location) {


 
    $scope.select = {};

    $scope.pageChanged = function() {


        console.log($scope.currentPage);

        offset = ($scope.currentPage - 1) * $scope.itemPerPage;

        $scope.getMapData();
    }

    $scope.countryChange = function() {
        console.log($scope.select.Country);
        $scope.getFilterTable();
    }

    $scope.strategyChange = function() {
        console.log($scope.select.Strategy);
        $scope.getFilterTable();
    }

    $scope.industryChange = function() {
        console.log($scope.select.Industry);
        $scope.getFilterTable();
    }

    $scope.tagsChange = function() {
            console.log($scope.select.Tags);
            $scope.getFilterTable();
        }
        // get hotel list
        // $scope.getFilterTable = function() {

    //     // var _filterPriceRage = '&min_price='+$scope.min_price+'&max_price='+$scope.max_price;
    //     var country = $scope.select.Country || '';
    //     var strategies = $scope.select.Strategy || '';
    //     var industry = $scope.select.Industry || '';
    //     var tags = $scope.select.Tags || '';

    //     offset = ($scope.currentPage - 1) * $scope.itemPerPage;

    //     Request.get('v1/startups?country=' + country + '&strategies=' + strategies + '&industry=' + industry + '&tags=' + tags + '&offset=' + offset + '&limit=' + $scope.itemPerPage).success(function(data, status, headers, config) {

    //         // $scope.firstInit = true;

    //         if (data.code == 200) {
    //             // console.log("============= loadMore");
    //             console.log('result filter : ', data);

    //             $scope.listOfDataNew = data.result;
    //             $scope.totalItem = data.options.total;


    //         }

    //     }).error(function() {

    //         genfunc.onError

    //     });
    // }


    $scope.prepareDataForMap = function(_result) {


        var _newData = [];
        _.each(_result, function(v, k) {

            var _tmp = {
                radius: 10,
                // yield: 400,
                city:v.capital,
                country: v.name.common,
                // fillKey: v.name.common,
                // significance: v.lab,
                date: v.created_at,
                latitude: v.latitude,
                longitude: v.longitude
            }
            _newData.push(_tmp);

        })

        return _newData;
        console.log('New Data : ', _newData);

    }

    $scope.getMapData = function() {

        var lab = "";
        var city = "";
        var country = "";
        var industry = "";
        var strategies = "";
        var website = "";
        var tags = "";


        Request.get('v1/startups?city=' + city +
            '&country=' + country +
            '&industry=' + industry +
            '&strategies=' + strategies +
            '&website=' + website +
            '&tags=' + tags
        ).success(function(data, status, headers, config) {
            // $scope.firstInit = true;
            if (data.code == 200) {



                $scope.prepareDataForMap(data.result);


                // console.log("============= loadMore");
                console.log('result map : ', data);

                $scope.mapData = data.result;
                $scope.totalItem = data.options.total;


            }

        }).error(function() {

            genfunc.onError

        });


    }



    var worlddata = {

        'BHS': ' ',
        'CAN': ' ',
        'GRL': ' ',
        'USA': ' ',
        'RUS': ' ',
        'CHN': ' ',
        'MEX': ' ',
        'BRA': ' ',
        'ARG': ' ',
        'COL': ' ',
        'GBR': ' ',
        'FRA': ' ',
        'IND': ' ',
        'PAK': ' ',
        'CHN': ' ',
        'AUS': ' ',
        'ZAF': ' ',
        'SAU': ' ',
        'DZA': ' ',
        'LBY': ' ',
        'SDN': ' ',
        'COG': ' ',
        'IDN': ' ',
        '-99': ' ',

        'AFG': ' ',
        'AGO': ' ',
        'ALB': ' ',
        'ARE': ' ',

        'ARM': ' ',
        'ATF': ' ',

        'AUT': ' ',
        'AZE': ' ',
        'BDI': ' ',
        'BEL': ' ',
        'BEN': ' ',
        'BFA': ' ',
        'BGD': ' ',
        'BGR': ' ',
        'BIH': ' ',
        'BLR': ' ',
        'BLZ': ' ',
        'BOL': ' ',

        'BRN': ' ',
        'BTN': ' ',
        'BWA': ' ',
        'CAF': ' ',
        'CHE': ' ',
        'CHL': ' ',

        'CIV': ' ',
        'CMR': ' ',
        'COD': ' ',


        'CRI': ' ',
        'CUB': ' ',
        'CYP': ' ',
        'CZE': ' ',
        'DEU': ' ',
        'DJI': ' ',
        'DNK': ' ',
        'DOM': ' ',

        'ECU': ' ',
        'EGY': ' ',
        'ERI': ' ',
        'ESP': ' ',
        'EST': ' ',
        'ETH': ' ',
        'FIN': ' ',
        'FJI': ' ',
        'FLK': ' ',

        'GUF': ' ',
        'GAB': ' ',

        'GEO': ' ',
        'GHA': ' ',
        'GIN': ' ',
        'GMB': ' ',
        'GNB': ' ',
        'GNQ': ' ',
        'GRC': ' ',
        'GTM': ' ',
        'GUY': ' ',
        'HND': ' ',
        'HRV': ' ',
        'HTI': ' ',
        'HUN': ' ',


        'IRL': ' ',
        'IRN': ' ',
        'IRQ': ' ',
        'ISL': ' ',
        'ISR': ' ',
        'ITA': ' ',
        'JAM': ' ',
        'JOR': ' ',
        'JPN': ' ',
        'KAZ': ' ',
        'KEN': ' ',
        'KGZ': ' ',
        'KHM': ' ',
        'KOR': ' ',
        'KWT': ' ',
        'LAO': ' ',
        'LBN': ' ',
        'LBR': ' ',

        'LKA': ' ',
        'LSO': ' ',
        'LTU': ' ',
        'LUX': ' ',
        'LVA': ' ',
        'MAR': ' ',
        'MDA': ' ',
        'MDG': ' ',

        'MKD': ' ',
        'MLI': ' ',
        'MMR': ' ',
        'MNE': ' ',
        'MNG': ' ',
        'MOZ': ' ',
        'MRT': ' ',
        'MWI': ' ',
        'MYS': ' ',
        'NAM': ' ',
        'NCL': ' ',
        'NER': ' ',
        'NGA': ' ',
        'NIC': ' ',
        'NLD': ' ',
        'NOR': ' ',
        'NPL': ' ',
        'NZL': ' ',
        'OMN': ' ',

        'PAN': ' ',
        'PER': ' ',
        'PHL': ' ',
        'PNG': ' ',
        'POL': ' ',
        'PRI': ' ',
        'PRK': ' ',
        'PRT': ' ',
        'PRY': ' ',
        'QAT': ' ',
        'ROU': ' ',

        'RWA': ' ',
        'ESH': ' ',


        'SSD': ' ',
        'SEN': ' ',
        'SLB': ' ',
        'SLE': ' ',
        'SLV': ' ',

        'SOM': ' ',
        'SRB': ' ',
        'SUR': ' ',
        'SVK': ' ',
        'SVN': ' ',
        'SWE': ' ',
        'SWZ': ' ',
        'SYR': ' ',
        'TCD': ' ',
        'TGO': ' ',
        'THA': ' ',
        'TJK': ' ',
        'TKM': ' ',
        'TLS': ' ',
        'TTO': ' ',
        'TUN': ' ',
        'TUR': ' ',
        'TWN': ' ',
        'TZA': ' ',
        'UGA': ' ',
        'UKR': ' ',
        'URY': ' ',

        'UZB': ' ',
        'VEN': ' ',
        'VNM': ' ',
        'VUT': ' ',
        'PSE': ' ',
        'YEM': ' ',

        'ZMB': ' ',
        'ZWE': ' ',
    };


    var bombMap = null;

    var initMap = function() {

        bombMap = new Datamap({
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

                'BHS': ' ',
                'CAN': ' ',
                'GRL': ' ',
                'CHN': ' ',
                'MEX': ' ',
                'BRA': ' ',
                'ARG': ' ',
                'COL': ' ',
                'CHN': ' ',
                'AUS': ' ',
                'ZAF': ' ',
                'SAU': ' ',
                'DZA': ' ',
                'LBY': ' ',
                'SDN': ' ',
                'COG': ' ',
                'IDN': ' ',
                '-99': ' ',

                'AFG': ' ',
                'AGO': ' ',
                'ALB': ' ',
                'ARE': ' ',

                'ARM': ' ',
                'ATF': ' ',

                'AUT': ' ',
                'AZE': ' ',
                'BDI': ' ',
                'BEL': ' ',
                'BEN': ' ',
                'BFA': ' ',
                'BGD': ' ',
                'BGR': ' ',
                'BIH': ' ',
                'BLR': ' ',
                'BLZ': ' ',
                'BOL': ' ',

                'BRN': ' ',
                'BTN': ' ',
                'BWA': ' ',
                'CAF': ' ',
                'CHE': ' ',
                'CHL': ' ',

                'CIV': ' ',
                'CMR': ' ',
                'COD': ' ',


                'CRI': ' ',
                'CUB': ' ',
                'CYP': ' ',
                'CZE': ' ',
                'DEU': ' ',
                'DJI': ' ',
                'DNK': ' ',
                'DOM': ' ',

                'ECU': ' ',
                'EGY': ' ',
                'ERI': ' ',
                'ESP': ' ',
                'EST': ' ',
                'ETH': ' ',
                'FIN': ' ',
                'FJI': ' ',
                'FLK': ' ',

                'GUF': ' ',
                'GAB': ' ',

                'GEO': ' ',
                'GHA': ' ',
                'GIN': ' ',
                'GMB': ' ',
                'GNB': ' ',
                'GNQ': ' ',
                'GRC': ' ',
                'GTM': ' ',
                'GUY': ' ',
                'HND': ' ',
                'HRV': ' ',
                'HTI': ' ',
                'HUN': ' ',


                'IRL': ' ',
                'IRN': ' ',
                'IRQ': ' ',
                'ISL': ' ',
                'ISR': ' ',
                'ITA': ' ',
                'JAM': ' ',
                'JOR': ' ',
                'JPN': ' ',
                'KAZ': ' ',
                'KEN': ' ',
                'KGZ': ' ',
                'KHM': ' ',
                'KOR': ' ',
                'KWT': ' ',
                'LAO': ' ',
                'LBN': ' ',
                'LBR': ' ',

                'LKA': ' ',
                'LSO': ' ',
                'LTU': ' ',
                'LUX': ' ',
                'LVA': ' ',
                'MAR': ' ',
                'MDA': ' ',
                'MDG': ' ',

                'MKD': ' ',
                'MLI': ' ',
                'MMR': ' ',
                'MNE': ' ',
                'MNG': ' ',
                'MOZ': ' ',
                'MRT': ' ',
                'MWI': ' ',
                'MYS': ' ',
                'NAM': ' ',
                'NCL': ' ',
                'NER': ' ',
                'NGA': ' ',
                'NIC': ' ',
                'NLD': ' ',
                'NOR': ' ',
                'NPL': ' ',
                'NZL': ' ',
                'OMN': ' ',

                'PAN': ' ',
                'PER': ' ',
                'PHL': ' ',
                'PNG': ' ',
                'POL': ' ',
                'PRI': ' ',
                'PRT': ' ',
                'PRY': ' ',
                'QAT': ' ',
                'ROU': ' ',

                'RWA': ' ',
                'ESH': ' ',


                'SSD': ' ',
                'SEN': ' ',
                'SLB': ' ',
                'SLE': ' ',
                'SLV': ' ',

                'SOM': ' ',
                'SRB': ' ',
                'SUR': ' ',
                'SVK': ' ',
                'SVN': ' ',
                'SWE': ' ',
                'SWZ': ' ',
                'SYR': ' ',
                'TCD': ' ',
                'TGO': ' ',
                'THA': ' ',
                'TJK': ' ',
                'TKM': ' ',
                'TLS': ' ',
                'TTO': ' ',
                'TUN': ' ',
                'TUR': ' ',
                'TWN': ' ',
                'TZA': ' ',
                'UGA': ' ',
                'UKR': ' ',
                'URY': ' ',

                'UZB': ' ',
                'VEN': ' ',
                'VNM': ' ',
                'VUT': ' ',
                'PSE': ' ',
                'YEM': ' ',

                'ZMB': ' ',
                'ZWE': ' ',
                defaultFill: '#EDDC4E'
            },
            data: {
                'RUS': {
                    fillKey: 'RUS'
                },
            }
        });

        // var bombs = [{
        //     name: 'Joe 4',
        //     radius: 10,
        //     yield: 400,
        //     country: 'USSR',
        //     fillKey: 'RUS',
        //     significance: 'First fusion weapon test by the USSR (not "staged")',
        //     date: '1953-08-12',
        //     latitude: -23,
        //     longitude: 133,
        // }, ];

        var _newData = $scope.prepareDataForMap($scope.mapData);

        //draw bubbles for bombs
        bombMap.bubbles(_newData, {
            popupTemplate: function(geo, data) {
                return ['<div class="hoverinfo">' + data.name,
                    '<br/>Payload: ' + data.yield + ' kilotons',
                    '<br/>Country: ' + data.country + '',
                    '<br/>Date: ' + data.date + '',
                    '<br/> ' + '<button class="btnlist">See full list</button>' + '',
                    '</div>'
                ].join('');
            }

        });

        bombMap.labels({
            'customLabelText': worlddata
        });

        d3.selectAll(".datamaps-bubble").on('click', function(geography) {
            console.log(bombs);
            alert(geography.name);
            '<button>Hello</button>'
        });
    }

    $(function() {


        console.log('wowowowo starat', $scope.mapData);

        


        console.log('starat');
        initMap();
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



        $(".js-example-basic-multiple").select2();




    })


});