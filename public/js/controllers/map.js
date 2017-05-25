var app = angular.module('maps', ['uiGmapgoogle-maps'])
    .config(['$interpolateProvider',
        function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');

        }
    ]);



(function() {
    app.controller('mapsCtrl', function($scope, $timeout, $rootScope) {
        // alert('hi');

        $scope.selectedMarker = -1;
        // $scope.testInfo = false;
        // var infowindow = null;
        // =================== how to buy ==================
        /**
         * [refreshMap init map after user click on how to buy(update page) or save complete spec to prevent map hidden issue init]
         * @return {[type]} [description]
         */
        $scope.marker = {};
        $scope.refreshMap = function() {
            var defaultLat = 11.5580;
            var defaultLng = 104.9112;
            // if ($scope.merchantInfo.profile.latitude && $scope.merchantInfo.profile.longitude) {
            //     defaultLat = $scope.merchantInfo.profile.latitude;
            //     defaultLng = $scope.merchantInfo.profile.longitude;
            // }

            // ======= map init once ======
            if ($scope.activeMap)
                return;
            $timeout(function() {
                $scope.activeMap = true;
            }, 100)

            // ============== map init =============
            $scope.map = {
                center: {
                    latitude: defaultLat,
                    longitude: defaultLng
                },
                options: {
                    scrollwheel: true
                },
                zoom: 13,
                events: {
                    // 'tilesloaded': function(map, eventName, arguments) {
                    //     $scope.$apply(function() {
                    //         google.maps.event.trigger(map, "resize");
                    //     });
                    // },
                    // 'click': function(map, eventName, arguments) {
                    //     var e = arguments[0];
                    //     var lat = e.latLng.lat(),
                    //         lon = e.latLng.lng();
                    //     $scope.marker.coords.latitude = lat;
                    //     $scope.marker.coords.longitude = lon;
                    //     $scope.$apply();
                    // }
                }
            };

            $scope.windowOptions = {
                boxClass: "map-popup",
                // maxWidth: 180,
                disableAutoPan: true,
                pixelOffset: new google.maps.Size(-115, 15),

                // pixelOffset: new google.maps.Size(-140, 15) // center
            };

            // ============== init marker ==============
            $scope.marker = {
                options: {
                    draggable: true,
                    animation: google.maps.Animation.DROP
                },
                events: {
                    dragend: function(marker, eventName, args) {
                        // $log.log('marker dragend');
                        var lat = marker.getPosition().lat();
                        var lon = marker.getPosition().lng();
                        console.log(lat, lon);

                        $scope.marker.options = {
                            draggable: true,
                            labelContent: "lat: " + $scope.marker.coords.latitude + ' ' + 'lon: ' + $scope.marker.coords.longitude,
                            labelAnchor: "100 0",
                            labelClass: "marker-labels"
                        };
                    },
                    position_changed: function(marker, eventName, args) {
                        // marker.setAnimation(google.maps.Animation.BOUNCE);
                    },

                }
            };

            $scope.markers = [{
                id: 0,
                coords: {
                    latitude: 11.5580,
                    longitude: 104.9112
                },
                events: {
                    'click': function(marker, eventName, args) {
                        // console.log(marker, $scope.markers);
                        // _.each($scope.markers, function(v, k) {
                        //     if (v.id !== marker.key) {
                        //         v.show = false;
                        //     } else {
                        //         v.show = true;
                        //     }
                        // })
                        // $scope.$apply();
                        // if (infowindow) {
                        //     infowindow.close();
                        // }
                        // infowindow = new google.maps.InfoWindow();
                    }
                },
                // data: {
                //     title: 'Neque porro quisquam est qui 1'
                // },
                show: false
            }, {
                id: 1,
                coords: {
                    latitude: 11.5719,
                    longitude: 104.8803
                },
                // data: {
                //     title: 'Neque porro quisquam est qui 2'
                // },
                show: false
            }, {
                id: 2,
                coords: {
                    latitude: 11.5812,
                    longitude: 104.9681
                },
                data: {
                    title: 'Neque porro quisquam est qui 3'
                },
                show: false
            }, {
                id: 3,
                coords: {
                    latitude: 11.6082,
                    longitude: 104.9096
                },
                data: {
                    title: 'Neque porro quisquam est qui 4'
                },
                show: false
            }];

        }

        $scope.showShopMap = function() {
            // $('.show-edit-map').trigger('click');
            $scope.showMap = true;
            $scope.refreshMap();
        }

        $scope.checkShowInfoWindow = function(item) {
            if ($scope.selectedMarker < 0)
                return false;
            else {
                if ($scope.selectedMarker === item.id)
                    return true;
                else
                    return false;
            }
        }

        $scope.selectedMarker = function(item) {
            console.log('sdfsdfsd');
            $scope.selectedMarker = item.id;
        }

        $(function() {
            $scope.showShopMap();
        })

    });
}());