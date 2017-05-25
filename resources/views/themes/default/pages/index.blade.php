@extends('themes.default.layouts.welcome')

@section('content')

    <?php
        /*
            {INFO}
            {
                "title": "Index",
                "description": "Default Welcome Page",
                "author": "FlexiTech Admin",
                "created_at": "2015-06-19 14:25:00",
                "updated_at": "2015-06-19 14:25:00",
                "id": "1e96bd56-83a3-4220-9241-ca18e2656d84",
                "link": "index",
                "layout": "welcome.blade.php"
            }
           {/INFO}
        */

        $title = CMS::getPiece('Homepage title', '');
        $desc = CMS::getPiece('Homepage description', 'Stay tuned our website will be available soon');
        $contact = CMS::getPiece('Homepage contact', 'Contact us at: <a class="linker" href="mailto:info@flexitech.io">info@flexitech.io</a>');
    ?>

    <div class="container hidden" id="page-welcome">
        <div class="content">
            {{-- <div class="title">{!! $title !!}</div> --}}
            <div class="title">Laravel 5.0</div>
            <div class="quote">{!! $desc !!}</div>
            <div class="contact">
                {!! $contact !!}
            </div>
        </div>
    </div>

@stop