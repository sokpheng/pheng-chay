var limit = 9;
var count = 9;
var offset = 9;
var scrollLoad = true;
var showMore = null;

var getMoreCate = function(url, type, getType) { // url= url get, type = tags or cate, getType = value to get

    $('.ajax-loading').toggleClass('show');

    // Using the core $.ajax() method
    $.ajax({

        // The URL for the request
        url: url,

        // The data to send (will be converted to a query string)
        data: {
            offset: offset,
            type: type,
            getStr: getType
        },

        // Whether this is a POST or GET request
        type: "GET",

        // The type of data we expect back
        dataType: "html",
        // dataType: "json",

        // Code to run if the request succeeds;
        // the response is passed to the function
        success: function(data) {

            // console.log(data.html);
            if (data != '') {
                var data = $.parseJSON(data);
                // console.log(data, status);
                $(".news-category-list .news-list").append(data['html']);
                offset += limit;
                // lazy image load
                var layzr = new Layzr({
                    container: null,
                    selector: '[data-layzr]',
                    attr: 'data-layzr',
                    retinaAttr: 'data-layzr-retina',
                    bgAttr: 'data-layzr-bg',
                    hiddenAttr: 'data-layzr-hidden',
                    threshold: 50,
                    callback: function() {
                        // this.classList.add('class');
                        // console.log(this);
                    }
                });
                showMore = data.showMore;
                scrollLoad = true;
            }

        },

        // Code to run if the request fails; the raw request and
        // status codes are passed to the function
        error: function(xhr, status, errorThrown) {
            // alert("Sorry, there was a problem!");
            // console.log("Error: " + errorThrown);
            // console.log("Status: " + status);
            // console.dir(xhr);
        },

        // Code to run regardless of success or failure
        complete: function(xhr, status) {
            // alert("The request is complete!");
            $('.ajax-loading').toggleClass('show');
        }

    });
}


$(function() {

    var urlAjax = $('#news-category').data('ajaxUrl');
    var getType = $('#news-category').data('getType'); // value of tags = game... or value of category = tech, moblie app
    var type = $('#news-category').data('type'); // tags or category
    showMore = $('#news-category').data('noMore');

    // console.log(urlAjax, type);

    $('#news-slide-container').owlCarousel({
        // Most important owl features
        // items: 1,
        // Navigation
        // navigation: true,
        singleItem: true,
        // mouseDrag: false,
        transitionStyle: "fade",
        lazyLoad: true,
        slideSpeed: 200,
        autoPlay: true,
    })

    $('.poster-container .collective-poster').owlCarousel({
        // carousel thumnail
        items: 6,
        itemsDesktopSmall: [980, 6],
        itemsTablet: [768, 4],
        itemsMobile: [479, 2],
        // lazyLoad: true,
        // itemsScaleUp: false
    });

    $('.poster-container .mobile-poster-game').owlCarousel({
        // carousel thumnail
        items: 9,
        itemsDesktop: [1199, 7],
        itemsDesktopSmall: [1023, 6],
        itemsDesktopSmall: [980, 5],
        // itemsDesktopSmall: [800, 5],
        itemsTablet: [768, 4],
        itemsTablet: [590, 3],
        itemsMobile: [400, 2],
        // lazyLoad: true,
        // itemsScaleUp: false
    });

    if (showMore) {
        $(window).on('scroll', function() {
            if (showMore && scrollLoad && ($(window).scrollTop() > $(document).height() - $(window).height() - ($('footer #footer').height() + 100))) {

                scrollLoad = false;
                // console.log('get ajax');
                getMoreCate(urlAjax, type, getType);

            }
        }).scroll();
    }

})