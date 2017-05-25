<!DOCTYPE html>
<html lang="{{ $lang=='kh'?'km-kh':'en-us' }}">
  <head>

    {{-- html5 and css3 for ie --}}
      @include('includes.utility.web-meta')

    {{-- html5 and css3 for ie --}}
      @include('includes.utility.ie-support')

      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Hanuman|Roboto+Condensed:400" rel="stylesheet" type="text/css"> 

      @if(App::environment('local'))
      <link href="{{ asset('css/vendors.css') }}" rel="stylesheet">
      
      <link href="{{ asset('fonts/icomoon-front/style.css') }}" rel="stylesheet">
      <link href="{{ asset('vendors/flickity/dist/flickity.min.css') }}" rel="stylesheet">
      <link href="{{ asset('vendors/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">
      <link href="{{ asset('vendors/nanoscroller/bin/css/nanoscroller.css') }}" rel="stylesheet">
      <link href="{{ asset('vendors/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
      <link href="{{ asset('vendors/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.min.css') }}" rel="stylesheet">
      <link href="{{ asset('vendors/jquery-ui/themes/ui-lightness/jquery-ui.min.css') }}" rel="stylesheet">
      {{-- <link href="{{ asset('vendors/vegas/dist/vegas.css') }}" rel="stylesheet"> --}}
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">
      <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
    @else
      <link href="{{ elixir('css/vendors_mix.css') }}" rel="stylesheet">
      <link href="{{ elixir('css/style.css') }}" rel="stylesheet">
      {{-- <link href="{{ elixir('fonts/icomoon-front/style.css') }}" rel="stylesheet"> --}}
    @endif

      @section('scripts_top')

      @show 

    <!-- start Mixpanel --><script type="text/javascript">(function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+"=([^&]*)")))?l[1]:null};g&&c(g,"state")&&(i=JSON.parse(decodeURIComponent(c(g,"state"))),"mpeditor"===i.action&&(b.sessionStorage.setItem("_mpcehash",g),history.replaceState(i.desiredHash||"",e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split(".");2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,
    0)))}}var d=a;"undefined"!==typeof f?d=a[f]=[]:f="mixpanel";d.people=d.people||[];d.toString=function(b){var a="mixpanel";"mixpanel"!==f&&(a+="."+f);b||(a+=" (stub)");return a};d.people.toString=function(){return d.toString(1)+".people (stub)"};k="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
    for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";c=e.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
    mixpanel.init("715892dba79276a5f32a53da550e2bf8");</script><!-- end Mixpanel -->


  </head>

  <body class="no-underline-link no-outline lang_{{ $lang }}" ng-app="app">

 <!--    <header>
      @include("includes.layouts.simple-nav-bar")
    </header> -->

    <main itemscope itemtype1="http://schema.org/Organization">
      @yield('content')
    </main>
<!-- 
    @if(!isset($onMapSearch))
      <footer>
        @include("includes.layouts.simple-footer")
      </footer> 
    @endif -->

    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCIAiZeLUQtHgd-a0lv9Q1MnDTUOfcLqIo'></script>

    @if(App::environment('local'))



      <script type="text/javascript" src="{{ asset('vendors/jquery/dist/jquery.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/jquery-ui/jquery-ui.min.js') }}"></script>

      <script type="text/javascript" src="{{ asset('vendors/angular/angular.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/angular-route/angular-route.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/angular-messages/angular-messages.min.js') }}"></script>

      <script type="text/javascript" src="{{ asset('vendors/angular-facebook/lib/angular-facebook.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/underscore/underscore.js') }}"></script>

      <script type="text/javascript" src="{{ asset('vendors/ng-file-upload/ng-file-upload.min.js') }}"></script>

      {{-- <script type="text/javascript" src="{{ asset('vendors/angular-google-maps/dist/angular-google-maps.js') }}"></script> --}}
      {{-- <script type="text/javascript" src="{{ asset('vendors/lodash/dist/lodash.min.js') }}"></script> --}}
      {{-- <script type="text/javascript" src="{{ asset('vendors/angular-simple-logger/dist/angular-simple-logger.min.js') }}"></script> --}}

      <script type="text/javascript" src="{{ asset('vendors-download/ui-bootstrap/ui-bootstrap-custom-2.5.0.js') }}"></script>

      <script type="text/javascript" src="{{ asset('vendors/tether/dist/js/tether.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>

      {{-- <script type="text/javascript" src="{{ asset('vendors/vegas/dist/vegas.js') }}"></script> --}}

      <script type="text/javascript" src="{{ asset('vendors/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>

      <script type="text/javascript" src="{{ asset('vendors/sticky-kit/jquery.sticky-kit.min.js') }}"></script>

      <script type="text/javascript" src="{{ asset('vendors/flickity/dist/flickity.pkgd.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/flickity-bg-lazyload/bg-lazyload.js') }}"></script>


      <script type="text/javascript" src="{{ asset('vendors/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.min.js') }}"></script>


      {{-- <script type="text/javascript" src="{{ asset('vendors/salvattore/dist/salvattore.min.js') }}"></script> --}}
      <script type="text/javascript" src="{{ asset('vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/isotope/dist/isotope.pkgd.min.js') }}"></script>


      {{-- <script type="text/javascript" src="{{ asset('vendors/angular-contenteditable/angular-contenteditable.js') }}"></script> --}}

      {{-- <script type="text/javascript" src="{{ asset('vendors/xregexp/xregexp-all.js') }}"></script> --}}

      {{-- <script type="text/javascript" src="{{ asset('vendors/nanoscroller/bin/javascripts/overthrow.js') }}"></script>  --}}
      {{-- <script type="text/javascript" src="{{ asset('vendors/nanoscroller/bin/javascripts/jquery.nanoscroller.js') }}"></script>  --}}

      <script type="text/javascript" src="{{ asset('js/directives/finished-render.js') }}"></script>

      <script type="text/javascript" src="{{ asset('js/hh/app.js') }}"></script>

      <script type="text/javascript" src="{{ asset('js/libraries/crypt/aes.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/libraries/crypt/pbkdf2.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/libraries/jsencrypt.js') }}"></script>

      <script type="text/javascript" src="{{ asset('js/services/crypt.js') }}"></script>

      <script type="text/javascript" src="{{ asset('js/services/request.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/services/genfunc.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/services/hhModule.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/d3/d3.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/topojson/topojson.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/datamaps.all.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/worlddata.json') }}"></script>
      <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendors/lodash/dist/lodash.min.js') }}"></script>

      <script src="/vendors/material-angular-paging/build/dist.min.js"></script>

      <script type="text/javascript" src="{{ asset('js/innovation/map.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/innovation/table.js') }}"></script>

    @else

      <script type="text/javascript" src="{{ elixir('js/build/hh-script.js') }}"  async="true"></script> 
      {{-- <script type="text/javascript" src="{{ asset('js/build-temp/hh-script.js') }}"></script> --}}


    @endif

    <!-- Go to www.addthis.com/dashboard to customize your tools --> 
    {{-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5837f6675ae78e5d"></script>  --}}
    <script>
    
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', '{{ config('seo_config.analytics.google_analytic_id') }}', 'auto');
      ga('send', 'pageview');

    </script>

      @section('scripts')

      @show

  </body>


</html>
