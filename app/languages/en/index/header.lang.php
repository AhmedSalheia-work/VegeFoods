<?php

$_['headerlinks'] = [
    'Home'      => '/',
    'Shop'      => '/shop',
    'About'     => '/index/about',
//    'Blog'      => '/blog',
    'Contact'   => '/index/contact'
];

if (!isset($_SESSION['user']) || $_SESSION['user'] == '')
{
    $_['headerlinks']['LogIn'] = '/user/login';
    $_['headerlinks']['Register'] = '/user/register';
}else{
    $_['headerlinks']['usr_image'] = $_SESSION['usr_img'];
    $_['headerlinks']['logout'] = '/user/logout';
    $_['headerlinks']['feedback'] = '/index/feedback';
}

$_['head_P'] = '3-5 Business days delivery &amp; Free Returns';
$_['site_description'] = 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.';

$_['shop'] = 'Shop Now';
$_['enterE'] = 'Enter email address';

$_['lang'] = 'Languages';
$_['Login'] = 'Login Now';
$_['no_sizes'] = 'No Sizes Selection For This Product';