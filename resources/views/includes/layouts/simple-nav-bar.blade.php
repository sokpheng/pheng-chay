
<div class="simple-nav-bar _fixed">

   <nav class="navbar navbar-light {{ isset($full_width)?'navbar-full-width':'' }}">

      <button class="navbar-toggler hidden-md-up marg-top-0" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
         <span class="icon-dehaze"></span>
      </button>

      <div class="navbar-brand {{ !isset($isSearchOnMenu)?'flex-1':'' }}">
         <?php
            $logo = 'cambodroom-logo.png';
            // if(isset($isSearchOnMenu))
            //    $logo = 'red-white.png';
         ?>
         <a href="{{ $baseUrlLang }}" title="">
            <img class="main-logo" height="30px;" src="{{ asset('img/'.$logo) }}" alt="Cambodroom Logo">
         </a>

      </div>

      <div class="collapse navbar-toggleable-sm {{ AuthGateway::isLogin() ? 'is_login' : '' }}" id="navbarResponsive">


         <ul class="nav navbar-nav float-xs-right {{ $lang }}">

{{--             <li class="nav-item">
               <a class="nav-link" href="{{ $baseUrlLang.'/about-us' }}">About Us</a>
            </li> --}}

            <li class="nav-item">
               <a class="nav-link" href="{{ $baseUrlLang.'/' }}">{{ trans('content.navbar.explore_hotels') }}</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="{{ $baseUrlLang.'/contact-us' }}">{{ trans('content.footer.contact_us') }}</a>
            </li>

            <li class="nav-item lang clearfix-xs">

               @if ($lang === 'en')
                  <a class="nav-link" href="{{ LaravelLocalization::getLocalizedURL('kh') }}">
                     <img class="flag" src="{{ asset('img/kh_icon.jpg') }}" alt="english language">
                     <span class="_text">KH</span>
                  </a>
               @else
                  <a class="nav-link" href="{{ LaravelLocalization::getLocalizedURL('en') }}">
                     <img class="flag" src="{{ asset('img/en_icon.jpg') }}" alt="english language">
                     <span class="_text">EN</span>
                  </a>
               @endif
            </li>

         </ul>


      </div>
   </nav>
</div>
