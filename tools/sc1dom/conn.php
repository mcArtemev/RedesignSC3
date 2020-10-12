<?php

$t_httpHost = $realHost = $_GET['host'];

$isReg = preg_match( '/^([a-z]{3})\.([a-z\-\.]{3,50}\.[a-z]{2,10})$/', $t_httpHost,  $mach );

if ( $isReg )
    $t_httpHost = $mach[2];

switch ( $t_httpHost ) {
    case 'canon-russia.net' : $t_httpHost = 'canon-russia-support.ru'; break;
    case 'huawei-russia.net' : $t_httpHost = 'huawei-russia-support.com'; break;
    case 'hp-russia.net' : $t_httpHost = 'hp-russia-support.com'; break;
    case 'lg-russia.net' : $t_httpHost = 'lg-russia-mobile.com'; break;
    case 'dell-russia.net' : $t_httpHost = 'dell-russia-support.com'; break;
    case 'nokia-russia.net' : $t_httpHost = 'nokia-russia-support.com'; break;
    case 'sony-russia.net' : $t_httpHost = 'sony-russia-mobile.com'; break;
    case 'nikon-russia.net' : $t_httpHost = 'nikon-russia-support.ru'; break;
    case 'toshiba-russia.net' : $t_httpHost = 'toshiba-russia-mobile.ru'; break;
    case 'xiaomi-russia.net' : $t_httpHost = 'xiaomi-russia-support.com'; break;
    case 'msi-russia.net' : $t_httpHost = 'msi-russia-support.com'; break;
    case 'asus-russia.net' : $t_httpHost = 'asus-russia-support.com'; break;
    case 'lenovo-russia.net' : $t_httpHost = 'lenovo-russia-support.com'; break;
    case 'meizu-russia.net' : $t_httpHost = 'meizu-russia-support.com'; break;
    case 'samsung-russia.net' : $t_httpHost = 'galaxy-russia-mobile.com'; break;
    case 'htc-russia.net' : $t_httpHost = 'htc-russia-support.ru'; break;
    case 'apple-russia.net' : $t_httpHost = 'apple-russia-support.com'; break;
}

if ( $isReg )
    $t_httpHost = $mach[1] . '.' . $t_httpHost;

echo $t_httpHost;