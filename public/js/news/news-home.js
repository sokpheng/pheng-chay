// toogle search container
var toogleSearch = function() {
    $('.menu-container .search-box').toggleClass('show-search');
    $('#header .menu').removeClass('active');
    if ($('#header .search-box').hasClass('show-search')) {
        $("#header .search-box .top-search").focus();
    }
}

var goToEle = function(eleStr) {
    if (!eleStr) {
        return;
    }
    var ele = $(eleStr);
    if (eleStr == 'body') {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    } else {
        $('html, body').animate({
            scrollTop: ele.offset().top
        }, 500);
    }
}

var toggleMenu = function() {
    $('#header .menu').toggleClass('active');
}

var scrollDown = function(e) {
    goToEle('body');
}


var convertToSlug = function(Text) {
    return Text
        .toLowerCase()
        .replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
}


// ============= track on click social link ==============
var triggerGAnalytic = function(ele) {
    // console.log(ele, $(ele.currentTarget).data('cate'));
    if (typeof ga !== 'undefined') {
        ga('send', 'event', 'button', 'click', 'vistor click ' + $(ele.currentTarget).data('cate'));
    }
}

$(function() {


    // trigger event google analytic
    $('#fx-navbar .nav a').click(function(e) {
        triggerGAnalytic(e);
    })


    var baseUrl = $('#header .top-search').data('url');

    // ============ search ===========
    $('#fx-navbar .bt-search,.search-box .icon-close').click(function() {
        toogleSearch();
    })

    $('#header .top-search').keyup(function(e) {
        var urlToGo = baseUrl + '?q=' + convertToSlug($('#header .top-search').val());
        $('#header .goTo').attr('href', urlToGo);
    })

    // ============ slide up search =============
    $('#header .top-search').bind('keypress', function(e) {

        var code = e.keyCode || e.which;
        if (code == 13) { //Enter keycode
            //Do something
            window.location.href = $('#header .goTo').attr('href');
        }
    });


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


    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('.menu-container').outerHeight();

    $(window).scroll(function(event) {
        if (!$('#header .menu').hasClass('active'))
            didScroll = true;
    });

    setInterval(function() {
        $(window).trigger('scroll');
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {
            // Scroll Down
            $('#header').removeClass('nav-down').addClass('nav-up');
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('#header').removeClass('nav-up').addClass('nav-down');
            }
        }

        lastScrollTop = st;
    }


})