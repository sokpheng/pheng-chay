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
                $(".search-list-container .search-list").append(data['html']);
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

    var ele = $('#news-search');
    var urlAjax = ele.data('ajaxUrl');
    var getType = ele.data('getType'); // value of tags = game... or value of category = tech, moblie app
    var type = ele.data('type'); // tags or category
    showMore = ele.data('noMore');


    if (showMore) {
        $(window).on('scroll', function() {
            if (showMore && scrollLoad && ($(window).scrollTop() > $(document).height() - $(window).height() - ($('footer #footer').height() + 100))) {

                scrollLoad = false;
                // console.log('get ajax');
                getMoreCate(urlAjax, type, getType);

            }
        }).scroll();
    }


    $("#news-search .main-search-text").focus();

    var baseUrl = $('#news-search .main-search-text').data('url');

    $('#news-search .main-search-text').keyup(function(e) {
        var urlToGo = baseUrl + '?q=' + convertToSlug($('#news-search .main-search-text').val());
        $('#news-search .goTo').attr('href', urlToGo);
    })

    $('#news-search .main-search-text').bind('keypress', function(e) {

        var code = e.keyCode || e.which;
        if (code == 13) { //Enter keycode
            //Do something
            window.location.href = $('#news-search .goTo').attr('href');
        }
    });

})