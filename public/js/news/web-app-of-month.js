$(function() {


    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
        // console.log(e);
        if (!$(e.target).hasClass('active'))
            $('.header .btn').toggleClass('active');

    })

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        minigrid('.app-grid', '.grid-item');
    })


    // function animate(item, x, y, index) {
    //     dynamics.animate(item, {
    //         translateX: x,
    //         translateY: y
    //     }, {
    //         type: dynamics.spring,
    //         duration: 800,
    //         frequency: 120,
    //         delay: 100 + index * 30
    //     });
    // }

    window.addEventListener('resize', function() {
        minigrid('.app-grid', '.grid-item');
    });



    $('.app-grid').imagesLoaded()
        .always(function(instance) {
            // console.log('all images loaded');
        })
        .done(function(instance) {
            console.log('all images successfully loaded');
            minigrid('.app-grid', '.grid-item');
            $('.app-grid').addClass('show');
            setTimeout(function() {
                minigrid('.app-grid', '.grid-item');
                // $('.collection-grid').addClass('show');
                // console.log('sdf');
            }, 500)
        })
        .fail(function() {
            // console.log('all images loaded, at least one is broken');
        })
        .progress(function(instance, image) {
            // var result = image.isLoaded ? 'loaded' : 'broken';
            // console.log('image is ' + result + ' for ' + image.img.src);
        });


})