/**
 * Created Date: 08 Nov 2016
 * Create By : Flexitech Cambodia Team
 */

//  restaurant view controller
app.controller('contactUsCtrl', function($rootScope, $scope, $http, $timeout, CryptService, Request, genfunc, Facebook, $location) {

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


    // contact us
    var initMap =function() { 
        var uluru = {  
            lat: 13.353275,
            lng: 103.8481493
        };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: uluru,
            // scaleControl: false,
            // scrollwheel: false,
            options: {
                styles: styles,
                // disableDefaultUI: false,
            }
        });

        var icon = {
            url: "/img/map-marker-icon.png", // url
            scaledSize: new google.maps.Size(40,40), // scaled size
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(20, 35) // anchor
        };

        var marker = new google.maps.Marker({
            position: uluru,
            map: map,
            options: {
                animation: google.maps.Animation.DROP,
                title: 'The Frangipani Living Arts Hotel and Spa',
                // icon: 'http://icons.iconarchive.com/icons/paomedia/small-n-flat/64/map-marker-icon.png'
                icon: icon
            },
            // scaleControl: false,
            // scrollwheel: false,
            // draggable: false,
        });
    }



    $(function(){

        initMap();


    })

});