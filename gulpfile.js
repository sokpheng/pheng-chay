var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    var gulp = require('gulp');
    var sass = require('gulp-sass');
    var minifyCss = require('gulp-minify-css');

    // console error 
    var gutil = require('gulp-util');

    //  Strip console, alert, and debugger statements from JavaScript code
    var stripDebug = require('gulp-strip-debug');

    // var sass = require('gulp-sass');
    //var sourcemaps = require('gulp-sourcemaps');
    var uglify = require('gulp-uglify');

    var pump = require('pump');

    var concat = require('gulp-concat');
    var count = require('gulp-count');
    var clean = require('gulp-rimraf');

    var autoprefixer = require('gulp-autoprefixer');

    // var gutil = require('gulp-util');

    gulp.task('bcss', function() {
        mix.sass('main.scss', 'public/css/main.css');
        mix.sass('theme.scss', 'public/css/theme.css');
        mix.sass('vendor.scss', 'public/css/vendor.css');
    });

    gulp.task('styles', function() {
        mix.sass('style.scss', 'public/css/style.css');
        mix.sass('vendors.scss', 'public/css/vendors.css');
    });


    // minify js for front-end
    gulp.task('minify_js', function() {

        return gulp.src([
            './public/vendors/jquery/dist/jquery.min.js',
            './public/vendors/angular/angular.min.js',
            './public/vendors/angular-route/angular-route.min.js',
            './public/vendors/angular-messages/angular-messages.min.js',
            './public/vendors/angular-facebook/lib/angular-facebook.js',

            './public/vendors/underscore/underscore-min.js',
            './public/vendors/ng-file-upload/ng-file-upload.min.js',
            './public/vendors/angular-google-maps/dist/angular-google-maps.min.js',
            './public/vendors/lodash/dist/lodash.min.js',
            './public/vendors/angular-simple-logger/dist/angular-simple-logger.min.js',

            './public/vendors-download/ui-bootstrap/ui-bootstrap-custom-2.2.0.js',

            './public/vendors/tether/dist/js/tether.min.js',
            './public/vendors/bootstrap/dist/js/bootstrap.min.js',
            './public/vendors/moment/min/moment.min.js',
            // './public/vendors/vegas/dist/vegas.js',
            './public/vendors/magnific-popup/dist/jquery.magnific-popup.min.js',
            './public/vendors/sticky-kit/jquery.sticky-kit.min.js',
            
            './public/vendors/flickity/dist/flickity.pkgd.min.js',
            './public/vendors/flickity-bg-lazyload/bg-lazyload.js',
            './public/vendors/angular-contenteditable/angular-contenteditable.js',
            
            './public/vendors/xregexp/xregexp-all.js',

            './public/js/directives/finished-render.js',
            './public/js/hh/app.js',
            // './public/js/hh/app-map.js', 
            './public/js/libraries/crypt/aes.js',
            './public/js/libraries/crypt/pbkdf2.js',
            './public/js/libraries/jsencrypt.js',
            './public/js/services/crypt.js',
            './public/js/services/request.js',
            './public/js/services/genfunc.js',
            './public/js/services/hhModule.js',

            './public/js/hh/user_view.js',
            './public/js/hh/home.js',
            './public/js/hh/contact-us.js',
            './public/js/hh/restaurant-view.js',
            './public/js/hh/rest-map.js',
            './public/js/hh/sign-in-register.js', 
            './public/js/hh/search.js'

        ])
        .pipe(count('## js-files selected'))
        .pipe(stripDebug())   
        .pipe(concat('hh-script.js'))
        // .pipe(stripDebug())
        .pipe(uglify({mangle: false, compress: true}).on('error', gutil.log))
        // .pipe(uglify({
        //     mangle: {
        //         except: ['angular', '_', 'app', 'namespace', 'dataMock']
        //     }
        // })) 
        .pipe(gulp.dest('./public/js/build/'));
    });


    // minify js for admin 
    gulp.task('minify_js_admin', function() {

        return gulp.src([
            // './public/js/app.js',
            './public/vendors/moment/min/moment.min.js',
            './public/vendors/jquery/dist/jquery.min.js',
            './public/vendors/magnific-popup/dist/jquery.magnific-popup.min.js',
            './public/vendors/underscore/underscore-min.js',
            './public/vendors/angular/angular.min.js',
            './public/vendors/angular-animate/angular-animate.js',
            './public/vendors/angular-google-maps/dist/angular-google-maps.min.js',
            './public/vendors/lodash/dist/lodash.min.js',
            './public/vendors/angular-simple-logger/dist/angular-simple-logger.min.js',

            './public/vendors/ngmap/build/scripts/ng-map.min.js',
            './public/vendors/angular-resource/angular-resource.min.js',
            './public/vendors/angular-drag-and-drop-lists/angular-drag-and-drop-lists.min.js',
            './public/vendors/angular-aria/angular-aria.min.js',
            './public/vendors/angular-material/angular-material.min.js',
            './public/vendors/angular-route/angular-route.min.js',
            './public/vendors/angular-sanitize/angular-sanitize.min.js',
            './public/vendors/ng-file-upload/ng-file-upload.min.js',

            './public/vendors/material-angular-paging/build/dist.min.js',
            './public/vendors/ng-file-upload-shim/ng-file-upload-shim.min.js',
            './public/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
            './public/vendors/angular-material-data-table/dist/md-data-table.min.js',

            './public/vendors-download/ckeditor/ckeditor.js',

            './public/js/app.js',
            './public/js/env.js',
            './public/js/libraries/route.js',
            './public/js/libraries/menu.js',
            './public/js/libraries/crypt/aes.js',
            './public/js/libraries/crypt/pbkdf2.js',
            './public/js/libraries/jsencrypt.js',
            './public/js/config.js',

            './public/js/services/mock.js',
            './public/js/services/resource.js',
            './public/js/services/crypt.js',

            './public/js/directives/co-editor.js',

            './public/js/controllers/home.js',
            './public/js/controllers/posts.js',
            './public/js/controllers/messages.js',
            './public/js/controllers/message.dialog.js',
            './public/js/controllers/pages.js',
            './public/js/controllers/media.js',
            './public/js/controllers/menu.js',
            './public/js/controllers/category.js',
            './public/js/controllers/type.js',
            './public/js/controllers/site.js',
            './public/js/controllers/album.dialog.js',
            './public/js/controllers/menu.dialog.js',
            './public/js/controllers/page.dialog.js',
            './public/js/controllers/category.dialog.js',
            './public/js/controllers/type.dialog.js',
            './public/js/controllers/localization.dialog.js',
            './public/js/controllers/media.dialog.js',
            './public/js/controllers/youtube.dialog.js',
            './public/js/controllers/choose-post-locale.dialog.js',

            './public/js/controllers/schedule-article.dialog.js',

            './public/js/controllers/modals/alert.dialog.js',
            './public/js/controllers/modals/loading.dialog.js',

            './public/js/controllers/articles.js',
            './public/js/controllers/article-create.js',
            './public/js/controllers/collections.js',
            './public/js/controllers/collection-create.js',
            './public/js/controllers/customs/products.js',
            './public/js/controllers/customs/product-sections.js',
            './public/js/controllers/customs/product-create.js',
            './public/js/controllers/customs/solutions.js',
            './public/js/controllers/customs/files.js',
            './public/js/controllers/customs/file.dialog.js',

            './public/js/controllers/customs/shops/index.js',
            './public/js/controllers/customs/shops/create.js',
            './public/js/controllers/customs/dimensions/index.js',
            './public/js/controllers/customs/dimensions/dialog.js',
            './public/js/controllers/customs/dimensions/detail-directory.dialog.js',
            './public/js/controllers/customs/.js',

        ])
        .pipe(count('## js-files selected admin script'))   
        .pipe(concat('hh-admin-script.js'))
        // .pipe(uglify({
        //     // mangle: false
        //     mangle: {
        //         except: ['angular', '_', 'app', 'namespace', 'dataMock']
        //     }
        // }))
        .pipe(gulp.dest('./public/js/build/'));
    });


    gulp.task('mix_css', function() {

        return gulp.src([
            './public/css/vendors.css',
            './public/fonts/icomoon-front/style.css',
            './public/vendors/flickity/dist/flickity.min.css',
            './public/vendors/magnific-popup/dist/magnific-popup.css',
            // './public/vendors/vegas/dist/vegas.min.css',
        ])
        .pipe(count('## css-files selected'))
        .pipe(autoprefixer())   
        .pipe(concat('vendors_mix.css'))
        .pipe(gulp.dest('./public/css/'));

    });

    gulp.task('mix_css_admin', function() {

        return gulp.src([
            './public/css/vendor.css',
            './public/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
            './public/vendors/angular-material/angular-material.min.css',
            './public/vendors/angular-material-data-table/dist/md-data-table.min.css',
            './public/css/main.css',
        ])
        .pipe(count('## css-files admin selected'))
        .pipe(autoprefixer())      
        .pipe(concat('admin_style.css'))
        .pipe(gulp.dest('./public/css/'));

    });

    gulp.task('minify_css', function() {
        return gulp.src('./public/css/*.css')
            .pipe(minifyCss())
            .pipe(gulp.dest('./public/css'));
    });

    gulp.task('copy_file', function(cb) {

        gulp.src('./public/fonts/BLOKKNeue/*')
             .pipe(gulp.dest('./public/build/fonts/BLOKKNeue'));

        return gulp.src('./public/fonts/icomoon-front/fonts/*')
             .pipe(gulp.dest('./public/build/css/fonts'));

    });

    gulp.task('version', function() {
        mix.version(["public/css/style.css", "public/css/vendors_mix.css", "public/js/build/hh-script.js", "public/css/admin_style.css"]);
        // mix.version(["public/css/style.css", "public/css/vendors_mix.css", "public/js/build/hh-script.js", "public/css/admin_style.css", "public/js/build/hh-admin-script.js"]);
        // mix.version(["public/css/admin_style.css", "public/js/build/hh-admin-script.js"]);
    });

    gulp.task('clean_before', function() {
        return gulp.src('./public/build', {read: false, force: true})
            .pipe(clean());
    });

    gulp.task('prod', ['mix_css', 'mix_css_admin','minify_css', 'minify_js', 'version', 'copy_file']);
    // gulp.task('prod_admin', ['clean_before','mix_css', 'minify_css', 'minify_js_admin' , 'version', 'copy_file']);

});