/**
 * Created Date: 10 Mar 2017
 * Developer: Panhna Seng
 * Create By : Flexitech Cambodia Team
 */

// hotel review page controller
app.controller('hotelReviewCtrl', function($rootScope, $scope, $http, $timeout, $location, $window, genfunc, hhModule, Request) {

    console.log('hotelReviewCtrl');

    var _dateFormat = 'MMM DD, YYYY';

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
	        lat: $scope.hotelInfo.geo[1] || 11.622226,
	        lng: $scope.hotelInfo.geo[0] || 104.869947
	    };
	    var map = new google.maps.Map(document.getElementById('map'), {
	        zoom: 14,
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

	var initGalleryPopup = function(){

        $('.hotel-gallery').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: '._photoEle', // the selector for gallery item
                type: 'image',
                removalDelay: 300,
                image: {
                    tError: '<a href="%url%" target="_blank">The image</a> could not be loaded.'
                },
                verticalFit: true, // Fits image in area vertically
                // Class that is added to popup wrapper and background
                // make it unique to apply your CSS animations just to this exact popup
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true
                }
            });
        });

	}

	var initVideoPopup = function(){
        $('.video_pro').magnificPopup({
            removalDelay: 300,

            // Class that is added to popup wrapper and background
            // make it unique to apply your CSS animations just to this exact popup
            mainClass: 'mfp-fade',
            type: 'iframe',
            iframe: {   
                markup: '<div class="mfp-iframe-scaler">'+
                        '<a class="mfp-title _video_title" target="_blank" href="#" style="font-size: 1.3rem; color: white; z-index: 999; position: absolute; display: table; bottom: -30px; text-decoration: underline !important;">Some caption</a>'+
                        '<div class="mfp-close"></div>'+
                        '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                      '</div>',
                patterns: {
                    youtube: {
                      index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

                      id: 'v=', // String that splits URL in a two parts, second part should be %id%
                      // Or null - full URL will be returned
                      // Or a function that should return %id%, for example:
                      // id: function(url) { return 'parsed id'; }

                      src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
                    },
                }
            },
            callbacks: {
                markupParse: function(template, values, item) {
                    
                    // values.title = item.el.attr('title');
                    values.title = '';

                },
                elementParse: function(template, values, item){
                    // console.log(template, values, item);
                    // setTimeout(function(){
                    //     console.log($(template.el)[0].name);
                    //     $('._video_title').attr('href',$(template.el)[0].name);
                    // }, 500)
                    
                },
            },
          
          
        });
	}


	var initPopupFillInfo = function(){
        // console.log('wowr');
        $('.fillInfoPopup').magnificPopup({
            removalDelay: 300,

            // Class that is added to popup wrapper and background
            // make it unique to apply your CSS animations just to this exact popup
            mainClass: 'mfp-fade',
            // closeBtnInside: false,
            type: 'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        });

	}

    $scope.getSecondPhoto = function(item, size){
        if(!item)
            return;


        var _otherPhoto = _.filter($scope.hotelInfo.gallery,function(v,k){
            if(v.id != $scope.hotelInfo.cover_media.id)
                return true;
            else
                return false;
        });

        // console.log($scope.hotelInfo);

        if(size)
            return _otherPhoto[0][size];
        else
            return _otherPhoto[0].zoom_url_link;

    }

    $scope.checkYouOrFBLink = function(_link){
        if(!_link)
            return;
        // var _link = $scope.hotelInfo.youtube_url;
        // console.log(_link);
        if(_link.indexOf('facebook.com') !== -1){
            // console.log('facebook');
            return 'https://www.facebook.com/v2.5/plugins/video.php?href='+_link;
        }
        else{
            return _link;
        }
    }

    $scope.getHotelDetail = function(_id){

        if(!_id)
            return;

        var _url = 'v1/hotels/'+_id+'?&populate=cover';

        if($scope.bookingId)
            _url = 'v1/booking/'+$scope.bookingId;



        Request.get(_url).success(function(data, status, headers, config) {

            
            if (data.code == 200) {
                // console.log("============= loadMore");
                // console.log(data);

                if(!$scope.bookingId)
                    $scope.hotelInfo = data.result;
                else{

                    $scope.bookingInfo = data.result;
        
                    
                    $rootScope.booking.check_in_date = moment($scope.bookingInfo.checkin).format(_dateFormat);
                    $rootScope.booking.check_out_date = moment($scope.bookingInfo.checkout).format(_dateFormat);
                    $rootScope.booking.room = $scope.bookingInfo.room;
                    $rootScope.booking.children = $scope.bookingInfo.children;
                    $rootScope.booking.adult = $scope.bookingInfo.adult;


                    //substract third
                    var _tmpRoomType = angular.copy(data.result.room_type);
                    // console.log(_tmpRoomType);
                    _tmpRoomType.hotel = null;
                    // console.log($scope.bookingInfo);


                    var _tmp = angular.copy(data.result.room_type.hotel);
                    _tmp.room_type = [];
                    _tmp.room_type.push(_tmpRoomType);
                    _tmp.gallery = data.result.gallery;
                    // _.extend(_tmp.gallery, data.result.gallery);
                    $scope.hotelInfo = _tmp;


                }

                if($scope.hotelInfo){
                    var _rateCount = hhModule.getStarRate($scope.hotelInfo.rate);
                    $scope.hotelInfo.rateStar = [];
                    for (var i = 1; i <=5; i++) {
                        // console.log(i);
                        if(i <= _rateCount){
                            $scope.hotelInfo.rateStar.push({
                                id: i,
                                selected: true
                            })
                        }
                        else{
                            $scope.hotelInfo.rateStar.push({
                                id: i,
                                selected: false
                            })
                        }
                    }

                }


                // console.log($scope.hotelInfo);

                initMap();

                initGalleryPopup();

                initVideoPopup();

                $timeout(function(){
                    initPopupFillInfo();
                },500)

            }



        }).error(function(){
            
            genfunc.onError

        });
    }

    // console.log(genfunc.getURL()+genfunc.getUrlLang());

    $scope.completeBooking = function(){

        // window.location.href =genfunc.getURL()+genfunc.getUrlLang()+'/booking/'+'9cea5b6e-5602-4570-bad8-88bb8b48f739?s=1';

        // return;

        $scope.isLoading = true;

        // $timeout(function(){

        //     $scope.isLoading = false;

        // },1000)

        // console.log($scope.hotelInfo)

        var _data = {
            room_type: $scope.hotelInfo.selected_room._id,
            hotel: $scope.hotelId,

            checkin: $rootScope.booking.check_in_date,
            checkout: $rootScope.booking.check_out_date,
            room: $scope.hotelInfo.selected_room.room_selected || $rootScope.booking.room,
            adult: $rootScope.booking.adult || 0,
            children: $rootScope.booking.children || 0,

            first_name: $scope.fillInfo.first_name,
            last_name: $scope.fillInfo.last_name,
            email: $scope.fillInfo.email,
            phone_number: $scope.fillInfo.phone_number,
            remark: $scope.fillInfo.remark || ''
        }

        // console.log(_data);

        // return;

        Request.post('v1/booking/',_data).success(function(data, status, headers, config) {

            
            if (data.code == 200) {
                // console.log("============= loadMore");
                console.log(data);

                // {
                //     "status": "success",
                //     "result": {
                //         "__v": 0,
                //         "_updated_at": "2017-04-06T13:00:34.000Z",
                //         "updated_at": "2017-04-06 13:00:34",
                //         "_created_at": "2017-04-06T13:00:34.000Z",
                //         "created_at": "2017-04-06 13:00:34",
                //         "id": "9cea5b6e-5602-4570-bad8-88bb8b48f739",
                //         "checkin": "2017-06-04T00:00:00.000Z",
                //         "checkout": "2017-08-04T00:00:00.000Z",
                //         "room": 2,
                //         "adult": 1,
                //         "children": 2,
                //         "first_name": "Panhna",
                //         "last_name": "Seng",
                //         "email": "panhaseng12@gmail.com",
                //         "phone_number": "70228414",
                //         "remark": "hi",
                //         "status": "active",
                //         "api_access": "58cb8c204ea0764004476d41",
                //         "_id": "58e63bf2838421cc611afa64"
                //     },
                //     "code": 200
                // }

                $timeout(function(){

                    if(data.result._id){
                        var magnificPopup = $.magnificPopup.instance; // save instance in magnificPopup variable
                        magnificPopup.close(); // Close popup that is currently opened
                        window.location.href = genfunc.getURL()+genfunc.getUrlLang()+'/booking/'+data.result._id+'?s=1';
                    }
                    else{
                        alert('Booking Not Success. Please try again.')
                    }

                },1000);

            }
            else{

                $scope.isLoading = false;

            }


        }).error(function(){
                
            $scope.isLoading = false;

            genfunc.onError

        });


    }


    $scope.selectRoom = function(item){

        console.log(item, $rootScope.booking);

        // return;

        if(!$rootScope.booking.check_in_date && !$rootScope.booking.check_out_date && !$rootScope.booking.adult && !$rootScope.booking.children){
            alert('Please input Check In & Check Out Date')
        }
        else{

            if(!item.room_selected){
                item.erro_select_room = true;
            }
            else{

                $scope.hotelInfo.selected_room = {};

                $scope.hotelInfo.selected_room = item;

                $('.fillInfoPopup').magnificPopup('open');

            }

        }
        // console.log(item);

    }


    $(function(){

        // console.log(genfunc.getURL()+genfunc.getUrlLang());

    	$scope.getHotelDetail($scope.hotelId || $scope.bookingId);


    })

});