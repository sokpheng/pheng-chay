<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SEO Meta Defaults
    |--------------------------------------------------------------------------
    |
    | some default value for seo of meta tag for website
    |
    */

    'defaults' => [
        '_title' => 'Cambodroom | Booking Hotel In Cambodia',
        '_full_title' => 'Cambodroom | Booking Hotel In Cambodia',
        '_desc' => 'Find the best & suitable hotel for relax time and fun with your friend or love one of many city & province in Cambodia.',

        '_keywords' => 'Booking, Booking In Cambodia, Hotel In Cambodia, Hotel In Phnom Penh, Hotel In Siem Reap, Hospitality In Cambodia, Cambodroom, Best Hotel In Cambodia',
        '_author' => 'Flexitech Cambodia Team',
        '_developers' => 'Flexitech Cambodia Web Team, API Team, Design Team',
        '_developer' => 'Flexitech Cambodia Web Team',
        '_contact' => 'info@flexitech.io',
        '_img' => '/img/facebook-share-v1.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Meta - Social
    |--------------------------------------------------------------------------
    |
    | value for social meta tag like twiter, facebook or google ...
    |
    */
    'socials'   =>  [
        // https://dev.twitter.com/cards/getting-started
        '_twitter_card' => 'summary_large_image', //   The card type, which will be one of “summary”, “summary_large_image”, “app”, or “player”.
        '_twitter_site' => 'Cambodroom', // twitter name
        '_twitter_creator' => 'Cambodroom', // twitter creator

        // facebook option
        // https://developers.facebook.com/docs/reference/opengraph#object-type
        '_og_type'  => 'place',
        '_fb_app_id_dev'  => '1917196178563555', // hungry-hungry fb_id for development
        '_fb_app_id_prod'  => '1917182975231542', // hungry-hungry fb_id for production

        // window option
        '_window_color' =>  '#FFF',
    ],




    /*
    |--------------------------------------------------------------------------
    | Analytics
    |--------------------------------------------------------------------------
    |
    | Analytics option to tract the website
    |
    */
   
    'analytics'   =>  [
        'google_analytic_id'   =>   'UA-61935322-7',
    ],

];