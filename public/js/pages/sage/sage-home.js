(function() {

	$("#slide #sage-slide-show").owlCarousel({

		navigation: false, // Show next and prev buttons
		slideSpeed: 300,
		paginationSpeed: 400,
		singleItem: true,
		lazyLoad: true,
		autoPlay: true,
		stopOnHover: true,
		transitionStyle: "fade",
		// autoHeight: true,
		// slideSpeed: 4000,
		// "singleItem:true" is a shortcut for:
		// items : 1, 
		// itemsDesktop : false,
		// itemsDesktopSmall : false,
		// itemsTablet: false,
		// itemsMobile : false

	});

	/*
	 * Replace all SVG images with inline SVG
	 */
	$('img.svg').each(function() {
		var $img = $(this);
		var imgID = $img.attr('id');
		var imgClass = $img.attr('class');
		var imgURL = $img.attr('src');

		$.get(imgURL, function(data) {
			// Get the SVG tag, ignore the rest
			var $svg = $(data).find('svg');

			// Add replaced image's ID to the new SVG
			if (typeof imgID !== 'undefined') {
				$svg = $svg.attr('id', imgID);
			}
			// Add replaced image's classes to the new SVG
			if (typeof imgClass !== 'undefined') {
				$svg = $svg.attr('class', imgClass + ' replaced-svg');
			}

			// Remove any invalid XML tags as per http://validator.w3.org
			$svg = $svg.removeAttr('xmlns:a');

			// Check if the viewport is set, if the viewport is not set the SVG wont't scale.
			if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
				$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
			}

			// Replace image with new SVG
			$img.replaceWith($svg);

		}, 'xml');

	});


	setTimeout(function (){

		$('.other-menu-mobile .btn, .bt-close-menu-mobile').click(function() {
			$('body').toggleClass('hide-scroll');
			$('.other-menu').toggleClass('active-mobile');
		})
	}, 3000);
	

})();