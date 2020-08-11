<?php

return [
    'template'=>[
        'header'              => TEMPLATE_PATH . 'header.php',
        'nav'                 => TEMPLATE_PATH . 'nav.php',
        ':view'               => ':action_view',
        'footer'              => TEMPLATE_PATH.'footer.php',
        'loader'              => TEMPLATE_PATH.'loader.php'

    ],

    'header'=>[
        'css' => [
            CSS.'open-iconic-bootstrap.min.css',
            CSS.'animate.css',
            CSS.'owl.carousel.min.css',
            CSS.'owl.theme.default.min.css',
            CSS.'magnific-popup.css',
            CSS.'aos.css',
            CSS.'ionicons.min.css',
            CSS.'bootstrap-datepicker.css',
            CSS.'jquery.timepicker.css',
            CSS.'flaticon.css',
            CSS.'icomoon.css',
            CSS.'style.css',
            'https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap',
            'https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap',
            'https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap'
        ],
        'js'  => [

        ]
    ],

    'footer'=>[
        'js' => [
            JS.'jquery.min.js',
            JS.'jquery-migrate-3.0.1.min.js',
            JS.'popper.min.js',
            JS.'bootstrap.min.js',
            JS.'jquery.easing.1.3.js',
            JS.'jquery.waypoints.min.js',
            JS.'jquery.stellar.min.js',
            JS.'owl.carousel.min.js',
            JS.'jquery.magnific-popup.min.js',
            JS.'aos.js',
            JS.'jquery.animateNumber.min.js',
            JS.'bootstrap-datepicker.js',
            JS.'scrollax.min.js',
            JS.'google-map.js',
            JS.'main.js',
            'https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false'
        ]
    ]
];