<?php

$_['menu_links'] = array(
    'Shop'      => '/shop',
    'About'     => '/index/about',
    'Contact'   => '/index/contact'
);

$_['menu'] = 'Menu';
$_['HaQ'] = 'Have a Questions?';

$_['newsletter'] = 'Subcribe to our Newsletter';
$_['newsletter_d'] = 'Get e-mail updates about our latest shops and special offers';
$_['sub'] = 'Subscribe';
$_['eye'] = 'Enter email address';

$_['lic'] = 'Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <br/> <span class="text-primary">Ahmed Salheia</span> Who Done The Backend';

if (isset($_SESSION['timer']))
{
    $_['timer'] = $_SESSION['timer'];
}else{
    $randDate = rand(1,30).'-'.rand(date('m'),intval(date('m'))+1).'-2020 '.rand(0,23).':'.rand(0,59).':00';
    $_['timer'] = date('l d F Y H:i:s',strtotime($randDate));
    $_SESSION['timer'] = $_['timer'];
}