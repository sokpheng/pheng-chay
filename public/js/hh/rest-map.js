/**
 * Created Date: 08 Nov 2016
 * Create By : Flexitech Cambodia Team
 */

//  restaurant view controller
app.controller('restMapCtrl', function(uiGmapGoogleMapApi, $rootScope, $scope, $http, $timeout, CryptService, Request, genfunc, Facebook, $location, hhModule) {

    $scope.hhModule = hhModule;
    $scope.isFirstRun = false;


    // map style
    var styles = [{
        "featureType": "all",
        "elementType": "labels",
        "stylers": [{
            "visibility": "on"
        }]
    }, {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#f3f4f4"
        }]
    }, {
        "featureType": "road.local",
        "elementType": "labels.text",
        "stylers": [{
            "visibility": "simplified"
        }, {
            "color": "#fc0303"
        }]
    }, {
        "featureType": "landscape.man_made",
        "elementType": "geometry",
        "stylers": [{
            "weight": 0.9
        }, {
            "visibility": "on"
        }]
    }, {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#83cead"
        }]
    }, {
        "featureType": "road",
        "elementType": "all",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#ffffff"
        }]
    }, {
        "featureType": "road",
        "elementType": "labels",
        "stylers": [{
            "visibility": "simplified"
        }, {
            "color": "#949191"
        }]
    }, {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#fee379"
        }]
    }, {
        "featureType": "road.arterial",
        "elementType": "all",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#fee379"
        }]
    }, {
        "featureType": "water",
        "elementType": "all",
        "stylers": [{
            "visibility": "on"
        }, {
            "color": "#7fc8ed"
        }]
    }];


    // console.log('map page');

    $scope.map = {
        control: {},
        center: {
            latitude: 11.557952,
            longitude: 104.908519
        },
        options: {
            // scrollwheel: false,
            styles: styles,
            disableDefaultUI: false,
        },
        events: {
            click: function(map) {
                onMapUpdate(map);
                // console.log(map);
                $scope.clearInfoWindow();
            },
            zoom_changed: function(map) {
                onMapUpdate(map);
            },
            center_changed: function(map) {
                onMapUpdate(map);
            }
        },
        zoom: 13
    };

    $scope.marker = {
        id: 0,
        coords: {
            latitude: 11.557952,
            longitude: 104.908519
        },
        options: {
            draggable: false
                // animation: google.maps.Animation.DROP,
                // title: v.name         
        },
        events: {
            dragend: function(marker, eventName, args) {
                // $log.log('marker dragend');
                // var lat = marker.getPosition().lat();
                // var lon = marker.getPosition().lng();
                // $log.log(lat);
                // $log.log(lon);

                // $scope.marker.options = {
                //   draggable: true,
                //   labelContent: "lat: " + $scope.marker.coords.latitude + ' ' + 'lon: ' + $scope.marker.coords.longitude,
                //   labelAnchor: "100 0",
                //   labelClass: "marker-labels"
                // };
            }
        }
    };

    $scope.cur_page = 1;
    $scope.num_per_page = 20;

    function onMapUpdate(map) {
        $scope.lat = map.getCenter().lat();
        $scope.lng = map.getCenter().lng();
        $scope.zoom = map.zoom

        $location.search('zoom', $scope.zoom);
        $location.search('lat', $scope.lat);
        $location.search('lng', $scope.lng);
        // console.log(map.zoom, $scope.lat, $scope.lng);
    }

    /**
     * [fbSignIn facebook sign-in]
     * @return {[type]} [description]
     */
    $scope.fbSignIn = function() {

        // disableButtons();
        // $scope.signInProcessing = false;
        // $scope.signInSocialProcessing = true;

        // // From now on you can use the Facebook service just as Facebook api says
        // var fbUser = {};

        Facebook.login(function(response) {

            // console.log(response);

            if (!response || !response.authResponse) {

                $scope.signInProcessing = false;
                $scope.signInSocialProcessing = false;
                enableButons();
                return;
            }


            $scope._dataFbLogin = CryptService.create({

                access_token: response.authResponse.accessToken

            }, 60 * 60);

            // console.log($scope._dataLogin);

            setTimeout(function() {
                $('.fb_login').submit();
            }, 500);

        }, {

            scope: 'email'

        });

    };


    // uiGmapGoogleMapApi is a promise.
    // The "then" callback function provides the google.maps object.
    // $scope.control = {};
    uiGmapGoogleMapApi.then(function(map) {


        // wait to get obj from orignal map obj from angular-map and get current location of google
        $timeout(function() {

            var map = $scope.map.control.getGMap();
            // console.log(map);
        
            getLocation();

            function getLocationSuccFn(position) {
                console.log('=== ',position, ' ===');
                $scope.map.center.latitude = position.coords.latitude;
                $scope.map.center.longitude = position.coords.longitude;
                $scope.marker.coords.latitude = position.coords.latitude;
                $scope.marker.coords.longitude = position.coords.longitude;
                $scope.map.control.refresh({
                    latitude: $scope.map.center.latitude,
                    longitude: $scope.map.center.longitude
                });
                // map.setCoords($scope.marker.coords);

                // wait google to check current location
                $scope.requestNearby($scope.map.center.latitude, $scope.map.center.longitude, true); // start first request to get near by restaurant

            }

            function getLocationErrFn(error) {
                // console.log("fail");
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        console.log("User denied the request for Geolocation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        console.log("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        console.log("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        console.log("An unknown error occurred.");
                        break;
                }

                // get location error
                $scope.requestNearby();
            }

            function getLocation() {
                if (navigator.geolocation) {
                    // console.log('wowrk');
                    navigator.geolocation.getCurrentPosition(getLocationSuccFn, getLocationErrFn, {
                        timeout: 10000
                    });

                    // getLocationSuccFn({
                    //     coords: {
                    //         latitude: 11.547367062153027,
                    //         longitude: 104.85958023661806
                    //     }
                    // });

                }
                else{
                    // wait google to check current location
                    $scope.requestNearby(); // start first request to get near by restaurant
                }

            }

        }, 500);


    });

    $scope.$on('finishedRenderList', function() {
        // console.log('done render');
        if($location.search().selected){
            if($('.list-item.item_' + $location.search().selected).length>0){
                $('.side-bar-fixed-container').animate({
                    scrollTop: ($('.list-item.item_' + $location.search().selected ).offset().top - 150) + 'px'
                }, 'fast'); 
            }
        }

    });

    // move map to the center by coords
    function map_recenter(map, latlng, offsetx, offsety) {
        var point1 = map.getProjection().fromLatLngToPoint(
            (latlng instanceof google.maps.LatLng) ? latlng : map.getCenter()
        );
        var point2 = new google.maps.Point(
            ((typeof(offsetx) == 'number' ? offsetx : 0) / Math.pow(2, map.getZoom())) || 0, ((typeof(offsety) == 'number' ? offsety : 0) / Math.pow(2, map.getZoom())) || 0
        );
        map.panTo(map.getProjection().fromPointToLatLng(new google.maps.Point(
            point1.x - point2.x,
            point1.y + point2.y
        )));
    }

    // clear selected list or map info-window
    $scope.clearMapSelected = function(itemSelected){
        _.each($scope.restList.result, function(v, k) {
            if(itemSelected._id != v._id){
                v.centerMap = false;
            }
        });
        _.each($scope.markers, function(v, k) {
            // console.log(itemSelected._id,' == id == ',v.id);
            if(itemSelected._id != v.id){
                v.show = false;
                v.isSelected = false;
            }
            else{
                if(!v.show){
                    v.show = !v.show;
                    v.isSelected = !v.isSelected;
                }
                else{
                    v.isSelected = !v.isSelected;
                }
            }
            // console.log(v.show);
        });
        // console.log($scope.restList.result);
    }

    // center the map after user click on list of restaurant
    $scope.centerMap = function(itemSelected){
        // console.log(itemSelected);
        // return;
        if(itemSelected.loc.coordinates.length<=0)
            return;
        // console.log($scope.markers);
        $timeout(function() {

            $scope.clearMapSelected(itemSelected);
            itemSelected.centerMap = !itemSelected.centerMap;

            map_recenter($scope.map.control.getGMap(), new google.maps.LatLng(itemSelected.loc.coordinates[1], itemSelected.loc.coordinates[0]), 0, 0);

            $location.search().selected = itemSelected._id;

            $timeout(function(){
                // $rootScope.map_route = window.location.hash;
                $rootScope.updateUrlLangNav();
            },500);

        }, 100);
    }

    // event callback
    var markerCallback = function(marker, eventName, args) {
        // console.log(marker, eventName, args);
        // marker.model.show = !marker.model.show;
        var tmpCoords = {};
        angular.copy(marker.model.coords, tmpCoords);
        // console.log(tmpCoords);
        // $scope.map.center = tmpCoords;
        // var distance = getDistanceFromLatLonInKm(
        //     $scope.map.center.latitude, $scope.map.center.longitude,
        //     tmpCoords.latitude, tmpCoords.longitude);
        // if (distance >= 2){
        // var map = $scope.map.control.getGMap();
        // map.panTo(new google.maps.LatLng(tmpCoords.latitude, tmpCoords.longitude));
        // console.log(marker.model);
        $timeout(function() {
            map_recenter($scope.map.control.getGMap(), new google.maps.LatLng(tmpCoords.latitude, tmpCoords.longitude), 0, 0);
        }, 100);

        _.each($scope.markers, function(v, k) {
            // console.log(v.id,'==',marker.key);
            if (v.id != marker.key) {
                v.show = false;
            } else {
                v.show = true;
            }
        });

    }

    // ======================= map functional ======================


    // =================== map service ====================
    // var promise;

    $scope.clearInfoWindow = function(){
        _.each($scope.markers, function(v,k){
            v.show = false;
        });
        // console.log($scope.markers);
    }

    $scope.restItemHover = function(item, isEnter, _index) {

        // if (promise)
        //     $timeout.cancel(promise);
        // console.log(item, isEnter, _index);
        // Start a timeout
        // promise = $timeout(function() {

        // console.log($scope.marker[_index]);
        if ($scope.markers[_index]) {
            if (isEnter === true){
                $scope.markers[_index].show = true;

                // _.each($scope.markers, function(v, k) {
                //     if (v.id != item.id) {
                //         v.show = false;
                //     } else {
                //         v.show = true;
                //     }
                // });

                // $scope.markers[_index].options.animation = google.maps.Animation.BOUNCE;
            }
            else{
                // console.log($scope.markers[_index].isSelected);
                if(!$scope.markers[_index].isSelected)
                    $scope.markers[_index].show = false;
                // 
                // _.each($scope.markers, function(v, k) {
                //     if (v._id != item._id) {
                //         v.show = false;
                //     } else {
                //         v.show = true;
                //     }
                // });

                // $scope.markers[_index].options.animation = 4;
            }
        }

        // }, 200);

    }

    // generate marker from the restaurant list obj
    $scope.generateMarkers = function(_restList) {

        var icon = {
            url: "/img/map-marker-icon.png", // url
            scaledSize: new google.maps.Size(40,40), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(20, 35) // anchor
        };

        var icon_cur = {
            url: "/img/maps/cur_loc_logo.png", // url
            scaledSize: new google.maps.Size(25, 25), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(5, 10) // anchor
        };
        var _markers = [];

        _.each(_restList, function(v, k) {
            // console.log(v.loc.coordinates[1], v.loc.coordinates[0]);
            if(v.loc){
                // console.log(v.cover);
                var _tmpObj = {
                    id: v._id,
                    // id: k+1,
                    show: v.centerMap, // show or hide info window
                    directory_name: v.directory_name,
                    slug: v.slug,
                    price_rate: v.price_rate,
                    loc: v.loc,
                    address: v.address,
                    cover: v.cover,
                    logo: v.logo,
                    distance : v.distance,
                    coords: {
                        latitude: v.loc.coordinates[1],
                        longitude: v.loc.coordinates[0],
                    },
                    options: {
                        animation: google.maps.Animation.DROP,
                        title: v.directory_name,
                        // icon: 'http://icons.iconarchive.com/icons/paomedia/small-n-flat/64/map-marker-icon.png'
                        icon: icon
                    },
                    windowOptions : {
                        boxClass: "simple-place-info-box",
                        // boxStyle: {
                        //     backgroundColor: "#CCC",
                        //     border: "1px solid red",
                        //     borderRadius: "5px",
                        //     // width: "60px",
                        //     // height: "60px"
                        // },
                        // disableAutoPan: true,
                        // maxWidth: 600,
                        // // zIndex: null,
                        // closeBoxMargin: "10px",
                        // pixelOffset: new google.maps.Size(0, 0),
                        closeBoxURL: "https://www.google.com/intl/en_us/mapfiles/close.gif",
                        // infoBoxClearance: new google.maps.Size(1, 1),
                        // isHidden: false,
                        // visible: false,
                        // pixelOffset: new google.maps.Size(-300, 35),
                        disableAutoPan: true,
                        // maxWidth: 600,
                        pixelOffset: new google.maps.Size(-165, -145),
                    },
                    events: {
                        // when user click on marker hide other info-window that shown and view this info-window with center map
                        click: markerCallback
                    }
                }

                // console.log(_tmpObj.coords);
                // console.log('=======================');

                _markers.push(_tmpObj);
            }

        });
    
        // set static for current location

        var _curLocDefault = {
            lat : 11.557952,
            lng : 104.908519
        }

        if($scope.current_loc_google_map){

        }

        var _tmpCur = {
            id: 1000000,
            // id: k+1,
            // directory_name: 'My Location',
            coords: {
                latitude: $scope.map.center.latitude || _curLocDefault.lat,
                longitude: $scope.map.center.longitude || _curLocDefault.lng,
            },
            options: {
                animation: google.maps.Animation.DROP,
                title: 'My Location',
                draggable: true ,
                // icon: 'http://icons.iconarchive.com/icons/paomedia/small-n-flat/64/map-marker-icon.png'
                icon: icon_cur
            },
            events: {
                // when user click on marker hide other info-window that shown and view this info-window with center map
                dragend: function (marker, eventName, args) {
                    var lat = marker.getPosition().lat();
                    var lng = marker.getPosition().lng();

                    $scope.map.latitude = lat;
                    $scope.map.longitude = lng;

                    $scope.lat = lat;
                    $scope.lng = lng;
               
                    $location.search('lat', $scope.lat);
                    $location.search('lng', $scope.lng);

                    $scope.requestNearby(lat,lng,true);
                }
            }
        }

        console.log(_tmpCur);

        if(!$scope.noMyCur)
            _markers.push(_tmpCur);

        // end set static for current location

        $scope.markers = angular.copy(_markers);

        // console.log(_markers);

    }

 

    $scope.requestNearby = function(_lat, _lng, _isReset) {

        // concat string for change language on top-nav
        $timeout(function(){
            // $rootScope.map_route = window.location.hash;
            $rootScope.updateUrlLangNav();
            // console.log($('.navbar-nav .lang .nav-link').attr('href'))
        },500);

        // console.log($rootScope.map_route);

        $scope.isLoading = true;

        // Get value from query
        var current = $location.search().current;

        var offset = 0;
        var limit = 20;
        var lat = _lat || 11.557952;
        var lng = _lng || 104.908519;
        var radius = 101;
        var zoom = 13;
        // console.log(value, offset);

        if (current ) {
            // console.log(value, offset);
            offset = ($scope.cur_page - 1) * $scope.num_per_page;
            // offset = value;
            // console.log("here",value, offset);

            if(!$scope.isFirstRun)
                limit =  current * $scope.num_per_page;

        }

        if ($location.search().zoom) {
            // console.log($location.search().lat, $location.search().lng, $location.search().zoom);
            $scope.map.center.latitude = $location.search().lat * 1.0;
            $scope.map.center.longitude = $location.search().lng * 1.0;
            $scope.map.zoom = $location.search().zoom * 1.0;
            // if(!$location.search().search)
            // zoom = $location.search().zoom*1 || 13;
        }else{
            // zoom = $location.search().zoom*1 || 13;
        }

        // radius = getRadius( zoom);
        // console.log("radius", radius);

        if (_isReset) {
            $scope.restList = null;
            offset = 0;
            // limit = 20;
        }

        var query = '&offset=' + offset + '&limit=' + limit;

        if ($location.search().search) {
            // $scope.advanceFilterVal = _s.split('--');
            // console.log($location.search().search.split('--'));
            var _search = $location.search().search.split('--');
            
            query += '&search=' + _search.join('+');
        }

        // controll the end of the list
        // if ($scope.restList) {
        //     if ($scope.restList.options.total >= limit && $scope.restList.result.length >= limit) {
        //         $scope.isLoadMoreHide = true;
        //         console.log("return");
        //         return;
        //     }
        // }

        $scope.isRequesting = true;

        // console.log('==== ',query,' ===');

        // console.log('/directories?radius=' + radius + '&lat=' + lat + '&lng=' + lng + query);
        Request.get('/directories/nearby?radius=' + radius + '&lat=' + lat + '&lng=' + lng + query)
            .success(function(data, status, headers, config) {
                $scope.isRequesting = false;
                if (data.code == 200) {
                    // console.log("============= loadMore");
                    // console.log(data);
                    $scope.cur_page++;
                    if(data.result.length == 0){
                        $scope.isLoadMoreHide = true;  
                    }else{
                        if ($scope.restList)
                            $scope.restList.result = $scope.restList.result.concat(data.result);
                        else
                            $scope.restList = data;
                    }
                    // $scope.restList.result =  _.sortBy( $scope.restList.result , 'loc.distance_km');
                    
                    if($scope.restList){
                        _.each($scope.restList.result,function(v,k){
                            if(v._id ==   $location.search().selected){
                                v.centerMap = true;
                            }else{
                                v.centerMap = false;
                            }
                        });

                        $scope.generateMarkers($scope.restList.result);
                    }
                    else{
                        $scope.restList = []
                    }
                    
                    $scope.isFirstRun = true;
                }

                $scope.isLoading = false;

            })
            .error(function(){
                $scope.isLoading = false;
                genfunc.onError
            });

        if (current) {
            $scope.cur_page = $location.search().current;
        }
    };


    $scope.requestUserAction = function() {

        // concat string for change language on top-nav
        $timeout(function(){
            // $rootScope.map_route = window.location.hash;
            $rootScope.updateUrlLangNav();
        },500);

        var _type = $location.search().cat;
        var user = genfunc.getUser();
        // console.log('user',user);
        var url = '/directories/';
        if(user){
            url = '/user/directories/';
        }

        Request.get(url + _type)
            .success(function(data, status, headers, config) {
                if (data.code == 200) {
                    // console.log("============= requestUserAction");
                    // console.log(data.result);

                    $scope.cur_page++;

                    data.result = _.map(data.result,function(v){
                        return v.directory;
                    });

                    if ($scope.restList)
                        $scope.restList.result = $scope.restList.result.concat(data.result);
                    else
                        $scope.restList = data;
                    $scope.generateMarkers($scope.restList.result);
                }
            })
            .error(genfunc.onError);
    }


    $scope.requestNewRec = function() {
        var _type = $location.search().cat;
        var offset = 0;
        var limit = 20;
        var value = $location.search().limit;

        var url = '/directories/';

        if(_type == 'rec'){
            url += 'recommendation';
        }else if(_type == 'new'){
            url += 'new';
        }

        if (value) {
            // console.log(value, offset);
            offset = ($scope.cur_page - 1) * $scope.num_per_page;
            limit = value;
        }


        var query = '?offset=' + offset + '&limit=' + limit;

        // console.log(query);

        Request.get(url + query)
            .success(function(data, status, headers, config) {
                if (data.code == 200) {
                    // console.log("============= _type" + _type);
                    // console.log(data);

                    $scope.cur_page++;

                    // data.result = _.map(data.result,function(v){
                    //     return v.directory;
                    // });
                    // if ($scope.restList)
                    //     console.log("why have this if ($scope.restList)");

                    if ($scope.restList)
                        $scope.restList.result = $scope.restList.result.concat(data.result);
                    else
                        $scope.restList = data;

                    $scope.generateMarkers($scope.restList.result);
                }
            })
            .error(genfunc.onError);
    }

    // design which requset should be performed
    // $scope.requestFactory = function() {
    //     var cat = $location.search().cat;
    //     if (cat) {
    //         switch (cat) {
    //             case 'new':
    //                 break;
    //             case 'rec':
    //                 break;
    //             case 'saves':
    //             case 'likes':
    //                 $scope.requestUserAction(cat);
    //                 break;

    //         }
    //     } else {
    //         $scope.requestNearby();
    //     }
    // }

    // category click listener
    $scope.filter = function(mode,isNotReset) {
        // console.log("mode",mode);
        switch (mode) {
            case 'new':
            case 'rec':
                if(!isNotReset){ reset();console.log("reset ===========");}
                $location.search('cat', mode);
                $scope.requestNewRec();
                break;
            case 'saves':
            case 'likes':
                if(!isNotReset) { reset();console.log("reset ===========");}
                $location.search('cat', mode);
                $scope.requestUserAction();
                break;
            case 'nearby':
                if(!isNotReset){ reset();console.log("reset ===========");}
                $location.search('cat', mode);
                $scope.requestNearby($scope.lat, $scope.lng, !isNotReset);

                break;
            default:

        }
    }

    $scope.filterCategory = function(_cat){

        if(!$scope.isRequesting){ 
            $location.search('search', _cat);
            $scope.requestNearby(null, null, true);
        }
    }

    $scope.loadMore = function() {

        // console.log("total", $scope.restList.options.total);

        // var limit = $scope.cur_page * $scope.num_per_page;
        // if ($scope.restList.options.total <= limit) {
        //     limit = $scope.restList.options.total;
        //     $scope.isLoadMoreHide = true;
        // }


        // $location.search('limit', limit);
        $location.search('current', $scope.cur_page);


    };

    function getRadius(zoom){
        var radius = 0 ;

        return 20;

        if(zoom<10){
            return 500;
        }else if(zoom>=10 && zoom<13){
            return 200;
        }else if(zoom<=13 && zoom<14){
            return 50; 
        }else if(zoom<=14 && zoom<16){
            return 30; 
        }else if(zoom<=16 && zoom<20){
            return 10; 
        }

    }

    function reset() {
        $location.search('limit', null);
        $location.search('current', null);
        $scope.cur_page = 1;
        $scope.restList = null;
        $scope.isLoadMoreHide = false;
    }



    /* EVENT WATCHERS */

    var watchers = {};

    watchers['current'] = $scope.$watch(function() {
        return $location.search().current;
    }, function(v, old) {

        if (v == old) {
            return;
        }

        if($location.search().current){
            var _type = $location.search().cat || 'nearby';
            $scope.filter(_type,true);
            // console.log("watch watch");
        }
        // $scope.requestNearby();

        // $scope.requestFactory();
    });

    $scope.$on('$destroy', function() {
        for (var key in watchers) {
            watchers[key]();
        }
        $location.search('limit', null);
        // $location.search('search', null);
    });

    

    $scope.advanceFilterVal = [];

    $scope.applyFilter = function(){
        // console.log($scope.advanceFilterVal);
        $scope.advanceSearchNow();
    }

    // clear filter 
    $scope.clearFilter = function(){
        // console.log('cuck');
        $scope.advanceFilterVal = [];
        
        _.each($scope.advanceOption,function(v, k){

            _.each(v,function(v_sub, k_sub){

                v_sub.checked = false;

            });

        });

        // console.log($scope.advanceFilterVal);

    }

    $scope.advanceSearchNow = function() {
        // console.log($scope.advanceOption);
        var _filterVal = $scope.advanceFilterVal.join('--');
        // console.log(_filterVal.toLowerCase(),'=',genfunc.getURL());
        // $window.location.href = genfunc.getURL()+ "/search?s=" + _filterVal.toLowerCase();
        $location.search('search', _filterVal.toLowerCase());
        $scope.requestNearby(null, null, true);
        $.magnificPopup.close();
    }

    $scope.advanceSearchFilter = function(item, isFilterNow){
        // console.log(item.checked);

        var _title = hhModule.urlSlugFixCafe(item.display_name);

        var chkExist = _.find($scope.advanceFilterVal, function(v,k){
            return _title == v;
        });

        if(item.checked){
            // console.log(chkExist);
            if(!chkExist){
                $scope.advanceFilterVal.push(_title);
            }
        }
        else{
            // console.log('false wowowowo')
            if(chkExist)
                $scope.advanceFilterVal = _.reject($scope.advanceFilterVal, function(v,k){
                return _title == v;
            });
        }

        console.log($scope.advanceFilterVal);
        
    }

    $(function() {

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
    })

});