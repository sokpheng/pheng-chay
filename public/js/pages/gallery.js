$(function() {

	// var initPhotoSwipeFromDOM = function(gallerySelector) {

	// 	// parse slide data (url, title, size ...) from DOM elements 
	// 	// (children of gallerySelector)
	// 	var parseThumbnailElements = function(el) {
	// 		var thumbElements = el.childNodes,
	// 			numNodes = thumbElements.length,
	// 			items = [],
	// 			figureEl,
	// 			linkEl,
	// 			size,
	// 			item;

	// 		for (var i = 0; i < numNodes; i++) {

	// 			figureEl = thumbElements[i]; // <figure> element

	// 			// include only element nodes 
	// 			if (figureEl.nodeType !== 1) {
	// 				continue;
	// 			}

	// 			linkEl = figureEl.children[0]; // <a> element

	// 			size = linkEl.getAttribute('data-size').split('x');

	// 			// create slide object
	// 			item = {
	// 				src: linkEl.getAttribute('href'),
	// 				w: parseInt(size[0], 10),
	// 				h: parseInt(size[1], 10)
	// 			};



	// 			if (figureEl.children.length > 1) {
	// 				// <figcaption> content
	// 				item.title = figureEl.children[1].innerHTML;
	// 			}

	// 			if (linkEl.children.length > 0) {
	// 				// <img> thumbnail element, retrieving thumbnail url
	// 				item.msrc = linkEl.children[0].getAttribute('src');
	// 			}

	// 			item.el = figureEl; // save link to element for getThumbBoundsFn
	// 			items.push(item);
	// 		}

	// 		return items;
	// 	};

	// 	// find nearest parent element
	// 	var closest = function closest(el, fn) {
	// 		return el && (fn(el) ? el : closest(el.parentNode, fn));
	// 	};

	// 	// triggers when user clicks on thumbnail
	// 	var onThumbnailsClick = function(e) {
	// 		e = e || window.event;
	// 		e.preventDefault ? e.preventDefault() : e.returnValue = false;

	// 		var eTarget = e.target || e.srcElement;

	// 		// find root element of slide
	// 		var clickedListItem = closest(eTarget, function(el) {
	// 			return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
	// 		});

	// 		if (!clickedListItem) {
	// 			return;
	// 		}

	// 		// find index of clicked item by looping through all child nodes
	// 		// alternatively, you may define index via data- attribute
	// 		var clickedGallery = clickedListItem.parentNode,
	// 			childNodes = clickedListItem.parentNode.childNodes,
	// 			numChildNodes = childNodes.length,
	// 			nodeIndex = 0,
	// 			index;

	// 		for (var i = 0; i < numChildNodes; i++) {
	// 			if (childNodes[i].nodeType !== 1) {
	// 				continue;
	// 			}

	// 			if (childNodes[i] === clickedListItem) {
	// 				index = nodeIndex;
	// 				break;
	// 			}
	// 			nodeIndex++;
	// 		}



	// 		if (index >= 0) {
	// 			// open PhotoSwipe if valid index found
	// 			openPhotoSwipe(index, clickedGallery);
	// 		}
	// 		return false;
	// 	};

	// 	// parse picture index and gallery index from URL (#&pid=1&gid=2)
	// 	var photoswipeParseHash = function() {
	// 		var hash = window.location.hash.substring(1),
	// 			params = {};

	// 		if (hash.length < 5) {
	// 			return params;
	// 		}

	// 		var vars = hash.split('&');
	// 		for (var i = 0; i < vars.length; i++) {
	// 			if (!vars[i]) {
	// 				continue;
	// 			}
	// 			var pair = vars[i].split('=');
	// 			if (pair.length < 2) {
	// 				continue;
	// 			}
	// 			params[pair[0]] = pair[1];
	// 		}

	// 		if (params.gid) {
	// 			params.gid = parseInt(params.gid, 10);
	// 		}

	// 		return params;
	// 	};

	// 	var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
	// 		var pswpElement = document.querySelectorAll('.pswp')[0],
	// 			gallery,
	// 			options,
	// 			items;

	// 		items = parseThumbnailElements(galleryElement);

	// 		// define options (if needed)
	// 		options = {

	// 			// define gallery index (for URL)
	// 			galleryUID: galleryElement.getAttribute('data-pswp-uid'),

	// 			getThumbBoundsFn: function(index) {
	// 				// See Options -> getThumbBoundsFn section of documentation for more info
	// 				var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
	// 					pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
	// 					rect = thumbnail.getBoundingClientRect();

	// 				return {
	// 					x: rect.left,
	// 					y: rect.top + pageYScroll,
	// 					w: rect.width
	// 				};
	// 			}

	// 		};

	// 		// PhotoSwipe opened from URL
	// 		if (fromURL) {
	// 			if (options.galleryPIDs) {
	// 				// parse real index when custom PIDs are used 
	// 				// http://photoswipe.com/documentation/faq.html#custom-pid-in-url
	// 				for (var j = 0; j < items.length; j++) {
	// 					if (items[j].pid == index) {
	// 						options.index = j;
	// 						break;
	// 					}
	// 				}
	// 			} else {
	// 				// in URL indexes start from 1
	// 				options.index = parseInt(index, 10) - 1;
	// 			}
	// 		} else {
	// 			options.index = parseInt(index, 10);
	// 		}

	// 		// exit if index not found
	// 		if (isNaN(options.index)) {
	// 			return;
	// 		}

	// 		if (disableAnimation) {
	// 			options.showAnimationDuration = 0;
	// 		}

	// 		// Pass data to PhotoSwipe and initialize it
	// 		gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
	// 		gallery.init();
	// 	};

	// 	// loop through all gallery elements and bind events
	// 	var galleryElements = document.querySelectorAll(gallerySelector);

	// 	for (var i = 0, l = galleryElements.length; i < l; i++) {
	// 		galleryElements[i].setAttribute('data-pswp-uid', i + 1);
	// 		galleryElements[i].onclick = onThumbnailsClick;
	// 	}

	// 	// Parse URL and open gallery if it contains #&pid=3&gid=1
	// 	var hashData = photoswipeParseHash();
	// 	if (hashData.pid && hashData.gid) {
	// 		openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
	// 	}
	// };

	// execute above function
	// initPhotoSwipeFromDOM('.my-gallery');

	/**
	 * [generateGallery generate customize gallery when user click to show popup use for (image gallery init and video iframe init)]
	 * @param  {[type]} item [which link (a tag) that user click from]
	 * @return {[type]}      [description]
	 */
	var generateGallery = function(item) {
		var $gallery = $('.' + $(item.el[0]).data('gallery'));

		if ($gallery.find('a').length > 0) {
			$result = '<div class="mfp-pager fixed_bottom_gallery">' +
				// '<div class="arrow_prev">' +
				// '<button type="button" class="prev arrow" onclick="javascript:$(\'.gallery\').magnificPopup(\'prev\');return false;">Previous</button>' +
				// '</div>' +
				'<div class="dots">' +
				'<ul class="dots">';

			// $galleryInfo = '';

			for (var i = 0; i < $gallery.find('a').length; i++) {
				var $cl_active = '';
				var video_icon = '';
				if (item.index == i) $cl_active = ' class="active"';
				else $cl_active = '';

				var $popup_link = $gallery.find('a:eq(' + i + ')'); // get a element inside magnific-popup that we init with (id or class)

				var $thumb = $popup_link.find('img').attr('src');


				// add icon video to gallery with iframe (video)
				if ($popup_link.hasClass('mfp-iframe'))
					video_icon = '<span class="icon-video icon-youtube"></span>';

				$result += '<li' + $cl_active + '>' +
					'<button type="button" onclick="javascript:$(\'.my-gallery\').magnificPopup(\'goTo\', ' + i + ');return false;"><img src="' + $thumb + '">' + video_icon + '</button>' +
					'</li>';
			}
			$result += '</ul>' +
				'</div>' +
				// '<div class="arrow_next">' +
				// '<button type="button" class="next arrow" onclick="javascript:$(\'.gallery\').magnificPopup(\'next\');return false;">Next</button>' +
				// '</div>' +
				'</div>';
			return $result;
		}
	}


	$('.my-gallery').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
			// Delay in milliseconds before popup is removed
			removalDelay: 300,
			// Class that is added to popup wrapper and background
			// make it unique to apply your CSS animations just to this exact popup
			delegate: 'a', // the selector for gallery item
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-fade mfp-img-mobile mfp-fx-gallery-custom',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
			},
			iframe: {
				markup: '<div class="mfp-iframe-scaler">' +
					'<div class="mfp-close"></div>' +
					'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
					'<div class="mfp-bottom-bar">' +
					'</div>' +
					'</div>'
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				titleSrc: function(item) {
					//return //item.el.attr('title');
					return generateGallery(item);
				}
			},
			callbacks: {
				markupParse: function(template, values, item) {

				},
				// customize gallery information (title, album ...)
				elementParse: function(item) {
					// console.log(item);
					// console.log($('.mfp-content .mfp-bottom-bar'));
					$('.mfp-content .mfp-bottom-bar .gallery-info').remove();
					$ele = $(item.el[0]);
					if ($ele.hasClass('mfp-iframe')) {
						// return;
						$('.mfp-content .mfp-iframe-scaler .fixed_bottom_gallery').remove();
						$('.mfp-content .mfp-iframe-scaler').append(generateGallery(item));
					}
					var albumName = $ele.data('album');
					var caption = $ele.data('caption');
					var desc = $ele.data('desc');
					var galleryInfo = '';
					galleryInfo += '<div class="gallery-info">';
					galleryInfo += '<h4 class="album-name">' + albumName + ' -&nbsp;</h3>';
					galleryInfo += '<h5 class="caption">' + caption + '</h4>';
					galleryInfo += '<h6 class="desc">' + desc + '</h5>';
					galleryInfo += '</div>';
					$('.mfp-content .mfp-bottom-bar').append(galleryInfo);
				}
			}

		});
	});

})