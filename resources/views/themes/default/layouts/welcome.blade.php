<?php
	/*
	{INFO}{
		"name": "Welcome Layout",
		"description": "Clean welcome layout design",
		"created_by": "Author"
	}{/INFO}
	*/
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Landing - FlexiTech [dot] IO</title>
        <meta name="description" content="Welcome to FlexiTech [dot] IO! We are local Cambodian developers, designers, analyst, freelances, project managers and gamers! We are proud to provide various services from website design, website development, digital marketing, logo design, branding design, web-based system development, project or startup consultant! Ping us for a cafe and we can chip chat through your idea to build your digital content!"/>
        <meta name="keywords" content="flexi tech, web design, web development, cambodia, cheap, reasonable, logo design, design, development, php, laravel, digital marketing, startup, tech, website, web, web-based"/>

        <meta name="author" content="FlexiTeam"/>
        <meta name="developers" content="FlexiTeam"/>
        <meta name="developer" content="FlexiTeam"/>
        <meta name="contact" content="biz@flexitech.io"/>


        <!-- Open Graph data -->
        <meta property="og:title" content="FlexiTech [dot] IO" />
        <meta property="og:type" content="product" />
        <meta property="og:url" content="http://www.flexitech.io" />
        <meta property="og:image" content="http://www.flexitech.io/img/fb.png" />
        <meta property="og:image.width" content="1351" />
        <meta property="og:image.height" content="641" />

        <meta property="og:description" content="Welcome to FlexiTech [dot] IO! We are local Cambodian developers, designers, analyst, freelances, project managers and gamers! We are proud to provide various services from website design, website development, digital marketing, logo design, branding design, web-based system development, project or startup consultant! Ping us for a cafe and we can chip chat through your idea to build your digital content!" />
        <meta property="og:site_name" content="FlexiTech [dot] IO" />
        <meta property="og:price:amount" content="0" />
        <meta property="og:price:currency" content="USD" />

        <link href="img/flexi-tech.png" type="image/x-icon" rel="shortcut icon" />

        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>        
        <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">	
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">	
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet">	

        <style>
        </style>
    </head>
    <body>
    	@yield('content')
    </body>
</html>
