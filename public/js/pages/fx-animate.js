var countUp = function($item) {
	return setTimeout(function() {
		var current, newCount, target;
		current = $item.attr('data-current-count') * 1;
		target = $item.attr('data-target-count') * 1;
		newCount = current + Math.ceil((target - current) / 4);
		$item.attr('data-current-count', newCount);
		$item.html(newCount);
		if (newCount < target) {
			return countUp($item);
		}
	}, 100);
};

var setCount = function($item, count) {
	if (count == null || count == '') {
		count = null;
	}
	// console.log(count);
	$item.attr('data-target-count', count);
	$item.attr('data-current-count', 0);
	return countUp($item);
};


$(function() {

	// scrollreveal
	// sr.reveal('#what-we-do', {
	// 	// duration: 200,
	// 	// Animation
	// 	origin: 'bottom',
	// 	distance: '200px',
	// 	duration: 1000,
	// 	delay: 0,
	// 	rotate: {
	// 		x: 0,
	// 		y: 0,
	// 		z: 0
	// 	},
	// 	opacity: 0,
	// 	scale: 0.9,
	// 	easing: 'cubic-bezier( 0.6, 0.2, 0.1, 1 )',

	// 	// Options
	// 	container: null,
	// 	mobile: true,
	// 	// reset: false,
	// 	reset: true,
	// 	useDelay: 'always',
	// 	viewFactor: 0.10,
	// 	viewOffset: {
	// 		top: 0,
	// 		right: 0,
	// 		bottom: 0,
	// 		left: 0
	// 	},
	// 	afterReveal: function(domEl) {
	// 		console.log('after reveal');
	// 	},
	// 	afterReset: function(domEl) {
	// 		console.log('after reset');
	// 	}

	// });

	// header animate
	var default_setting = {
		// Animation
		origin: 'bottom',
		opacity: 0,
		scale: 1,
		distance: '200px',
		duration: 1000,
		delay: 0,
		viewFactor: 0.2,
		reset: false,
		mobile: true,
		easing: 'cubic-bezier( 0.6, 0.2, 0.1, 1 )',
		// container: ''
	};

	// header section
	var header_anim = jQuery.extend(true, {}, default_setting);
	header_anim.viewFactor = 0.8;
	var anim_header_title = jQuery.extend(true, {}, header_anim);
	var anim_header_sub = jQuery.extend(true, {}, header_anim);
	var read_more = jQuery.extend(true, {}, header_anim);

	anim_header_title.delay = 300;
	anim_header_sub.delay = 600;
	read_more.delay = 1000;

	sr.reveal('#header .logo', default_setting)
		.reveal('#header .main_title', anim_header_title)
		.reveal('#header .subtitle', anim_header_sub)
		.reveal('#header .read-more', read_more);
	// end header section


	// about section
	var about_section = jQuery.extend(true, {}, default_setting);
	// about_section.reset = true;
	about_section.delay = 400;
	// about_section.container = document.getElementById('thum-effect');
	about_section.distance = "20px";
	var image_left = jQuery.extend(true, {}, about_section);
	var image_right = jQuery.extend(true, {}, about_section);

	image_left.origin = 'left';
	image_right.origin = 'right';

	sr.reveal('#about .img-left', image_left)
		.reveal('#about .img-right', image_right);
	// end about section


	// do you know
	var do_you_know_section = jQuery.extend(true, {}, default_setting);
	// do_you_know_section.container = document.getElementById('section_features');
	do_you_know_section.afterReveal = function(domEl) {
		// console.log('after reveal', $(domEl).find('number'));
		var numerEle = $(domEl).find('.number');
		setCount(numerEle, $(domEl).data('counter'))
	};
	var item_1 = jQuery.extend(true, {}, do_you_know_section);
	var item_2 = jQuery.extend(true, {}, do_you_know_section);
	var item_3 = jQuery.extend(true, {}, do_you_know_section);
	var item_4 = jQuery.extend(true, {}, do_you_know_section);
	var item_5 = jQuery.extend(true, {}, do_you_know_section);

	item_1.delay = 0;
	item_2.delay = 200;
	item_3.delay = 400;
	item_4.delay = 500;
	item_5.delay = 600;

	sr.reveal('.section-features .item_1', item_1)
		.reveal('.section-features .item_2', item_2)
		.reveal('.section-features .item_3', item_3)
		.reveal('.section-features .item_4', item_4)
		.reveal('.section-features .item_5', item_5);
	// end do you know

	// operation
	var operation = jQuery.extend(true, {}, default_setting);
	// operation.container = document.getElementById('section_features');
	var text = jQuery.extend(true, {}, operation);
	var grid_1 = jQuery.extend(true, {}, operation);
	var grid_2 = jQuery.extend(true, {}, operation);

	text.delay = 200;
	grid_1.delay = 300;
	grid_2.delay = 400;

	sr.reveal('#our-operations .text', text)
		.reveal('#our-operations .grid_1', grid_1)
		.reveal('#our-operations .grid_2', grid_2);
	// end operation

	// our partner
	var partner = jQuery.extend(true, {}, default_setting);
	// operation.container = document.getElementById('section_features');
	var carousel_partners = jQuery.extend(true, {}, partner);
	carousel_partners.delay = 400;
	carousel_partners.distance = "60px";

	sr.reveal('.fx-carousel--partners', carousel_partners);
	// end our partner


	// contact
	var contact = jQuery.extend(true, {}, default_setting);
	// operation.container = document.getElementById('section_features');
	contact.distance = "100px";
	var form = jQuery.extend(true, {}, contact);
	var more_detail = jQuery.extend(true, {}, contact);

	form.delay = 200;
	more_detail.delay = 400;


	sr.reveal('#contact .form_side', form)
		.reveal('#contact .more-info', more_detail);
	// end contact


	// console.log(read_more);

});