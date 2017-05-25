var marker;
var infowindow;
var map
var styles = [{
	"featureType": "administrative",
	"elementType": "labels.text.fill",
	"stylers": [{
		"color": "#444444"
	}]
}, {
	"featureType": "landscape",
	"elementType": "all",
	"stylers": [{
		"color": "#f2f2f2"
	}]
}, {
	"featureType": "poi",
	"elementType": "all",
	"stylers": [{
		"visibility": "off"
	}]
}, {
	"featureType": "road",
	"elementType": "labels.text",
	"stylers": [{
		"hue": "#ff0000"
	}]
}, {
	"featureType": "road.highway",
	"elementType": "all",
	"stylers": [{
		"visibility": "simplified"
	}]
}, {
	"featureType": "road.arterial",
	"elementType": "labels.icon",
	"stylers": [{
		"visibility": "off"
	}]
}, {
	"featureType": "transit",
	"elementType": "all",
	"stylers": [{
		"visibility": "off"
	}]
}, {
	"featureType": "water",
	"elementType": "all",
	"stylers": [{
		"color": "#34b196"
	}, {
		"visibility": "on"
	}]
}];

function initialize() {
	var mapCanvas = document.getElementById('my-map');

	var myLatLng = {
		lat: 11.559270,
		lng: 104.923945
	};

	var mapOptions = {
		center: myLatLng,
		zoom: 15,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		// draggable: false
		// disableDefaultUI: true,
		zoomControl: true,
		scrollwheel: false
	}



	var contentString = '<div id="map-window-info">' +
		'<div id="logo-container">' +
		'<img src="img/logo.png" alt="logo"/> </div>' +
		'<h3 class="text-center main-title">CULTIVATED LANDS / HECTARES OF PLANTATIONS</h3>' +
		// '<div id="bodyContent">' +
		// '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
		// 'sandstone rock formation in the southern part of the ' +
		// 'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) ' +
		// 'south west of the nearest large town, Alice Springs; 450&#160;km ' +
		// '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major ' +
		// 'features of the Uluru - Kata Tjuta National Park. Uluru is ' +
		// 'sacred to the Pitjantjatjara and Yankunytjatjara, the ' +
		// 'Aboriginal people of the area. It has many springs, waterholes, ' +
		// 'rock caves and ancient paintings. Uluru is listed as a World ' +
		// 'Heritage Site.</p>' +
		// '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
		// 'https://en.wikipedia.org/w/index.php?title=Uluru</a> ' +
		// '(last visited June 22, 2009).</p>' +
		// '</div>' +
		'</div>';

	map = new google.maps.Map(mapCanvas, mapOptions);

	// apply theme color to map
	map.setOptions({
		styles: styles
	});

	// add marker and animate it
	marker = new google.maps.Marker({
		position: myLatLng,
		animation: google.maps.Animation.DROP,
		map: map,
		title: 'Chan Sophea Aphivath Co., Ltd'
	});
	// marker.addListener('click', toggleBounce); // animate on click

	infowindow = new google.maps.InfoWindow({
		content: contentString
	});
	// infowindow.open(map, marker);
	marker.addListener('click', function() {
		infowindow.open(map, marker);
	});

	function toggleBounce() {
		if (marker.getAnimation() !== null) {
			marker.setAnimation(null);
		} else {
			marker.setAnimation(google.maps.Animation.BOUNCE);
		}
	}
}

google.maps.event.addDomListener(window, 'load', initialize);

// aimate to show window information of map with Reveal JS
$(function() {
	// header animate
	var default_setting = {
		// Animation
		origin: 'bottom',
		opacity: 0,
		scale: 1,
		distance: '50px',
		duration: 1000,
		delay: 200,
		viewFactor: 0.2,
		reset: false,
		mobile: true,
		easing: 'cubic-bezier( 0.6, 0.2, 0.1, 1 )',
		// container: ''
	};
	// do you know
	var do_you_know_section = jQuery.extend(true, {}, default_setting);
	// do_you_know_section.container = document.getElementById('section_features');
	do_you_know_section.afterReveal = function(domEl) {
		infowindow.open(map, marker);
		var currCenter = map.getCenter();
		google.maps.event.trigger(map, 'resize');
		map.setCenter(currCenter);
	};
	sr.reveal('.map-contact', do_you_know_section);
})