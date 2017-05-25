$(function() {

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


    function showMenuOnSectionn(winScrollTop, ele) {

        if (winScrollTop + 50 > navbarHeight) {
            // console.log('show menu');
            if (!$('.menu-container').hasClass('prepare_for_animate'))
                $('.menu-container').addClass('prepare_for_animate');
        } else {
            if ($('.menu-container').hasClass('prepare_for_animate'))
                $('.menu-container').removeClass('prepare_for_animate');
        }

        if (winScrollTop > ele.offset().top) {
            // if (winScrollTop > $('#header').height() / 2) {

            // console.log('show menu');
            if (!$('.menu-container').hasClass('fix_menu'))
                $('.menu-container').addClass('fix_menu');
        } else {
            if ($('.menu-container').hasClass('fix_menu'))
                $('.menu-container').removeClass('fix_menu');
        }
    }

    function hasScrolled() {
        var st = $(this).scrollTop();

        // showMenuOnSectionn(st, $('#about'));
        // return;
        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {
            // Scroll Down
            $('.menu-container').removeClass('nav-down').addClass('nav-up');
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('.menu-container').removeClass('nav-up').addClass('nav-down');
            }
        }

        lastScrollTop = st;
    }

});