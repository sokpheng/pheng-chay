var scrollUp = function(ele) {
	var elem = $(ele);
	$('html, body').animate({
		scrollTop: elem.offset().top
	}, 500);
}

var scrollDown = function(ele) {
	// console.log($(ele).data('scroll'));
	goToEle($(ele).data('scroll'));
}

var goToEle = function(eleStr) {

	var widthWin = $(window).width();

	if (!eleStr) {
		return;
	}
	var ele = $('#' + eleStr);

	var offsetMinus = 0;

	// if (eleStr == 'about' || eleStr == 'faq' || eleStr == 'contact') {
	// offsetMinus = 80;
	// }

	if (widthWin < 1024) {
		offsetMinus = 61;
	}

	// console.log(eleStr);
	$('html, body').animate({
		scrollTop: ele.offset().top - offsetMinus
	}, 500);

	$('#fx-navbar li').removeClass('active');
	$('#menu-' + eleStr).toggleClass('active');

	if (widthWin < 768) {
		$('#header .navbar-toggle')[0].click();
	}

}

$(function() {


	$('.fx-carousel-card-scale').slick({
		centerMode: true,
		centerPadding: '60px',
		slidesToShow: 3,
		slidesToScroll: 3,
		// draggable: false,
		arrows: false,
		// responsive: [{
		// 	breakpoint: 768,
		// 	settings: {
		// 		arrows: false,
		// 		centerMode: true,
		// 		centerPadding: '40px',
		// 		slidesToShow: 3
		// 	}
		// }, {
		// 	breakpoint: 480,
		// 	settings: {
		// 		arrows: false,
		// 		centerMode: true,
		// 		centerPadding: '40px',
		// 		slidesToShow: 1
		// 	}
		// }]
	});

	$(".fx-navigator-arrow__right").click(function() {
		// Manually slickNext of slick
		$('.fx-carousel-card-scale').slick('slickNext');
	});

	$(".fx-navigator-arrow__left").click(function() {
		// Manually slickPrev of slick
		$('.fx-carousel-card-scale').slick('slickPrev');
	});

	return;

	// slide
	$(".fx-carousel--slogan").owlCarousel({
		autoPlay: 10000, //Set AutoPlay to 3 seconds
		singleItem: true,
		navigation: true,
		transitionStyle: "fade",
		mouseDrag: false,
		touchDrag: false,
		afterInit: function() {
			// console.log($('.owl-wrapper').height());
			assignOwlCarouselHeight($('.owl-wrapper').height()); // make height with specific can make flexbox center work
		},
	});

	// carousel partners
	$(".fx-carousel--partners").owlCarousel({
		autoPlay: 10000, //Set AutoPlay to 3 seconds
		items: 4,
		itemsDesktop: [1199, 4],
		itemsDesktopSmall: [979, 3],
		itemsMobile: [479, 2],
	});

	setTimeout(function() {
		// full video background
		$('.fx-full-video-back').vide({
			mp4: "/video/plantation-new-2",
			webm: "/video/plantation-new-2",
			// ogv: path/to/video3,
			//poster: "/video/plantation-new.png"
		}, {
			volume: 1,
			playbackRate: 1,
			muted: true,
			loop: true,
			autoplay: true,
			position: '0 0', // Similar to the CSS `background-position` property.
			posterType: 'none', // Poster image type. "detect" — auto-detection; "none" — no poster; "jpg", "png", "gif",... - extensions.
			resizing: true, // Auto-resizing, read: https://github.com/VodkaBears/Vide#resizing
			bgColor: 'transparent' // Allow custom background-color for Vide div
		});
	}, 300);

	var videoContainer = $('.fx-full-video-back video');

	setTimeout(function() {
		videoContainer = $('.fx-full-video-back video');
	}, 200);

	function detechVideoLoaded() {
		if (videoContainer[0].readyState == 4) {
			// Video loaded
		} else {
			setTimeout(detechVideoLoaded, 200);
		}
	}

	if ($(window).width() > 767) {

		// trigger scroll to check toggle scroll-top
		setTimeout(function() {
			$(window).trigger('scroll');
		}, 250);

		// check to disable scroll top
		$(window).scroll(function(e) {
			var st = $(this).scrollTop();
			// console.log(st);
			if (st > 350) {
				$('.scroll-top').fadeIn(200);
			} else {
				$('.scroll-top').fadeOut(200);
			}
		});
	}

	var rtime;
	var timeout = false;
	var delta = 100;
	$(window).resize(function() {
		rtime = new Date();
		if (timeout === false) {
			timeout = true;
			setTimeout(resizeend, delta);
		}
	});

	function resizeend() {
		if (new Date() - rtime < delta) {
			setTimeout(resizeend, delta);
		} else {
			timeout = false;
			// console.log($('.owl-wrapper').height());
			assignOwlCarouselHeight($('.owl-wrapper').height());
		}
	};

	var toggleMenuState = false;
	$('#menuBtn').click(function(v) {
		toggleMenuState = !toggleMenuState;
		if (toggleMenuState) {
			$('.navbar-header').addClass('in');
		} else {
			$('.navbar-header').removeClass('in');
		}
	});


})