// play video on best video from our website
var playMainVideo = function(video_id) {
    // ?autoplay=1
    // http: //www.youtube.com/embed/M_5twa6PH9k?autoplay=1
    $('#video-player').attr('src', 'https://www.youtube.com/embed/' + video_id + '?autoplay=1');
}


var getSocialCount = function() {
    var countUp, setCount, url, urlGPlus;
    url = $('.social-share').data('socialUrl');
    urlGPlus = $('.social-share').data('socialGUrl');
    $.getJSON('https://urls.api.twitter.com/1/urls/count.json?url=' + url + '&callback=?', function(json) {
        return setCount($('.bt-twitter .count'), json.count);
    }).fail(function() {
        // console.log("error");
        $.getJSON('http://urls.api.twitter.com/1/urls/count.json?url=' + url + '&callback=?', function(json1) {
            // console.log(json1, url);
            return setCount($('.bt-twitter .count'), json1.count);
        })
    });

    $.getJSON('https://graph.facebook.com/' + url, function(json) {
        return setCount($('.bt-fb .count'), json.shares);
    });
    // url = 'https://facebook.com';
    $.getJSON(urlGPlus, function(json) {
        return setCount($('.bt-google .count'), json.count);
    })

    // $.getJSON('http://api.pinterest.com/v1/urls/count.json?url=' + url + '&callback=?', function(json) {
    //     return setCount($('.prCount'), json.count);
    // });
    // $.getJSON('http://www.linkedin.com/countserv/count/share?url=' + url + '&callback=?', function(json) {
    //     return setCount($('.liCount'), json.count);
    // });
    countUp = function($item) {
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
    setCount = function($item, count) {
        if (count == null || count == '') {
            count = null;
        }
        // console.log(count);
        $item.attr('data-target-count', count);
        $item.attr('data-current-count', 0);
        return countUp($item);
    };
}

/**
 * [isValidEmailAddress check email pattern]
 * @param  {[type]}  emailAddress [email]
 * @return {Boolean}              [description]
 */
function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};

/**
 * [subcribe subcribe news by email]
 * @param  {[type]} url   [base url]
 * @param  {[type]} email [subcribe email]
 * @return {[type]}       [description]
 */
var subcribe = function(url, email) {
    // console.log(isValidEmailAddress(email));
    if (isValidEmailAddress(email)) {

        $('.subcribe .alert').hide(100);

        $.ajax({

            // The URL for the request
            url: url + '/api/v1/subscriptions',

            // header
            headers: {
                // header: {
                ApplicationID: "6550FEBDDD4EBEA1CBE302558B5723C81715F9A3"
            },

            // The data to send (will be converted to a query string)
            data: {
                email: email
            },

            // Whether this is a POST or GET request
            type: "POST",

            // The type of data we expect back
            // dataType: "html",
            dataType: "json",

            // Code to run if the request succeeds;
            // the response is passed to the function
            success: function(data) {

                // console.log(data);
                if (data != '' && data.result == "Subscription is completed") {

                    if (typeof ga !== 'undefined') {
                        ga('send', 'event', 'Forms', 'Subcribe', 'Subcribe News');
                    }

                    // var data = $.parseJSON(data);
                    $('.subcribe #msg-success').show(200);
                    setTimeout(function() {
                        $('.subcribe #msg-success').hide(200);
                    }, 10000);
                } else {

                    var errMsg = '';
                    if (data.error && data.error.email[0]) {
                        errMsg = data.error.email[0];
                    } else {
                        errMsg = data.result;
                    }

                    $('.subcribe #msg-error').show(200);
                    $('.subcribe #msg-error .lb-detail').html(errMsg);
                }

            },

            // Code to run if the request fails; the raw request and
            // status codes are passed to the function
            error: function(xhr, status, errorThrown) {
                // alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
                var data = xhr.responseJSON;
                var errMsg = '';
                if (data.error && data.error.email[0]) {
                    errMsg = data.error.email[0];
                } else {
                    errMsg = data.result;
                }

                $('.subcribe #msg-error').show(200);
                $('.subcribe #msg-error .lb-detail').html(errMsg);
            },

            // Code to run regardless of success or failure
            complete: function(xhr, status) {
                // alert("The request is complete!");
                // $('.ajax-loading').toggleClass('show');
            }

        });
    } else {
        $('.subcribe #msg-error').show(200);
        $('.subcribe #msg-error .lb-detail').html('Please input valid email');
        $('#subcribe_email').focus();
    }
}


$(function() {

    getSocialCount(); // get social count

    $('.subcribe .btn').click(function() {
        subcribe($(this).data('url'), $('#subcribe_email').val());
    })

    // play video 
    $('.main-video .overlay-with-icon,.best-video-list .video-item').click(function() {
        // console.log($(this).data('videoId'));
        $('.main-video .overlay-with-icon').hide();
        $('.main-preview-video').hide();
        playMainVideo($(this).data('videoId'));
    })


    // init article gallery
    // $('.gallery,.gallery-thumnail').flickity({
    //     // options
    //     // cellAlign: 'left',
    //     contain: true,
    //     // wrapAround: true,
    //     lazyLoad: true,
    //     imagesLoaded: true
    // });


    // $('.carousel').carousel({
    //     interval: 0
    // })
    // 

    // carousel main
    $('#owl-carousel').owlCarousel({
        // Most important owl features
        // items: 1,
        // Navigation
        // navigation: true,
        singleItem: true,
        lazyLoad: true,
    })

    // carousel thumnail
    $('#owl-carousel-thumnail').owlCarousel({
        items: 6,
        itemsDesktopSmall: [980, 6],
        itemsTablet: [768, 6],
        itemsMobile: [479, 3],
        lazyLoad: true,
        // itemsScaleUp: false
    });

    // carousel main
    var owl = $("#owl-carousel").data('owlCarousel');

    $('.main-carousel .gallery-next').click(function(e) {
        e.preventDefault();
        owl.next();
    })

    $('.main-carousel .gallery-prev').click(function(e) {
        e.preventDefault();
        owl.prev()
    })

    $('#owl-carousel-thumnail .table-layout').click(function(e) {
        owl.goTo($(this).data('id'));
    })


    // carousel thumnail
    var owlThumnail = $("#owl-carousel-thumnail").data('owlCarousel');

    $('.carousel-thumnail-container .gallery-next').click(function(e) {
        e.preventDefault();
        owlThumnail.next();
    })

    $('.carousel-thumnail-container .gallery-prev').click(function(e) {
        e.preventDefault();
        owlThumnail.prev();
    })

})