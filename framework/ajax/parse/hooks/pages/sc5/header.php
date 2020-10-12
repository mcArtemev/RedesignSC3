<?
use framework\tools;

$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($this->_datas['phone'], true);
$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);
$marka_ru =  $this->_datas['marka']['ru_name'];
$marka_full = ($marka_lower == 'hp') ? 'Hewlett<br>Packard' : '';

$region_name_pe = $this->_datas['region']['name_pe'];
$region_name = $this->_datas['region']['name'];

$geo_address = $this->_datas['partner']['address1'].', '.$this->_datas['region']['name'].', Россия'.(($this->_datas['partner']['index']) ? ', '.$this->_datas['partner']['index'] : '');



$calltracking_array = [
    'acer.re-centre.ru' => 'NkyADyNwMv_H9p2n9tntmWuGha4htiof',
    'apple.re-centre.ru' => 'Bmv7SxaYYh67q3Huc6WGQMI9ekCXp4K1',
    'asus.re-centre.ru' => 'e_TAT_7RSraYsvgGbFPvDLLKGD5hIOkW',
    'canon.re-centre.ru' => '0hGSeXhQCU0dSnGd0x9mSf7OvKPzEg0N',
    'dell.re-centre.ru' => 'e95xNxrYDeBc4xFCGfRyNhD3MRnyV5h9',
    'galaxy.re-centre.ru' => 'nTDOcn05ziO_DufK0Gdg2Ts7ZVf8lgEI',
    'hp.re-centre.ru' => 'u79wn0IXGDBFnCWrtPsiwXwXvvdKH9Fa',
    'htc.re-centre.ru' => 'G64A2paLxgZB2mNGfk8CApxL8nX1pL66',
    'huawei.re-centre.ru' => 'ZMkGylrx6Y9qugmULAGBpe4SigygPPtO',
    'lenovo.re-centre.ru' => '2eQCYq1buSuNqOCegpP4SXcNCqEq5_u6',
    'lg.re-centre.ru' => 'S938sPTsGlzagu2Wr4FQMbgf0HsvWLeN',
    'meizu.re-centre.ru' => 'tfP4fi6RZ6rODCctyVvTte1vONeWNZpf',
    'msi.re-centre.ru' => 'uhXFXyfgyVz4G6S8NphRa_MWGlkFQIDg',
    'nikon.re-centre.ru' => 'yrORfbYQN_dnrQa6Lsh63YUoXP7rgKlS',
    'nokia.re-centre.ru' => 'abzo9bIvhnGGEayFudCAkdixuskDgWqu',
    'sony.re-centre.ru' => 'Ckg0AhonvOqUdB0keizmHLw9FILzElzg',
    'toshiba.re-centre.ru' => '3o7XYv4GMRKDYnETZ0TTsZy0bxD1uvPw',
    'xiaomi.re-centre.ru' => '146rACEYStgvXx8ADCEHFSXeIcg4hUii',
    'zte.re-centre.ru' => 'ZfVOQEQXRDdApb3Ydg1gKa7dqEhDFEeD'
        ];
$calltracking = isset($calltracking_array[$this->_datas['realHost']]) ? $calltracking_array[$this->_datas['realHost']] : '';
$calltracking = false;

$msk = false;
$sbp = false;
if ( count(explode('.', $this->_datas['site_name'])) == 2 ) $msk = true;
if (mb_strpos($this->_datas['site_name'], 'spb') !== false)  $sbp = true;

$link_citis = $links = ['' => 'Москва', 'spb' => 'Санкт-Петербург'];
$accord_links = ['Москва' => 'Москве', 'Санкт-Петербург' => 'Санкт-Петербурге'];

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';

include_once __DIR__.'/text/exclude.php';
include_once __DIR__.'/text/popular.php';

$feed = tools::gen_feed($this->_datas['site_name']);
$site_id = $this->_datas['site_id'];


$addresis = array();
$pass = false;

foreach ($links as $key => $value)
{
    if ($key)
    {
        if (mb_strpos($this->_datas['site_name'], $key) !== false)
        {
            unset($links[$key]);
            $pass = $key;
            break;
        }
    }
}

//print_r($links);

if (!$pass)
{
    unset($links['']);
}

foreach ($links as $key => $value)
{
    $val = [];
    $val['region_name_pe'] = $accord_links[$value];

    if (mb_strpos($this->_datas['realHost'], '-recentre.ru') !== false ||
        mb_strpos($this->_datas['realHost'], '-recentre.com') !== false ||
        mb_strpos($this->_datas['realHost'], '-recentre.net') !== false)
    {
        if ($key)
        {
            if ($pass)
                $site = str_replace($pass, $key, $this->_datas['realHost']);
            else
                $site = $key.'.' . $this->_datas['realHost'];
        }
        else
        {
            if ($pass) $site =  str_replace($pass.'.', '', $this->_datas['realHost']);
        }
    }
    else
    {
        if ($key)
        {
            if ($pass)
            {
                $site = str_replace($pass, $key, $this->_datas['realHost']);
            }
            else
            {
                $ar = explode('.',$this->_datas['realHost']);
                $site = $ar[0].'-'.$key.'.'.$ar[1].'.'.$ar[2];
            }
        }
        else
        {
            if ($pass) $site = str_replace('-'.$pass, '', $this->_datas['realHost']);
        }
    }

    $val['site'] = $site;
    $addresis[] = $val;
}

$merge_popular = get_popular($site_id, $marka_lower, $feed);

if ($merge_popular)
{
    $popular = tools::get_rand($merge_popular, $feed);
}
else
{
    $popular['name'] = $marka;
}

$default_textarea_tip = $popular['name'] . ' после падения перестал заряжать батарею';
$courier_textarea_tip = 'курьер на ' . (($this->_datas['partner']['address2']) ? $this->_datas['partner']['address2'] : $this->_datas['partner']['address1']) .', ' . $default_textarea_tip;


//address
$address_choose = $this->_datas['addresis'];

$t_addres = [];
$t_addres_name = [];

foreach ($address_choose as $value)
{
    $value['region_name'] = ($value['region_name']) ? $value['region_name'] : 'Москва';

    $t_addres[] = $value;
    $t_addres_name[$value['region_name']] = $value;
}

uasort($t_addres, function($a, $b){
    return strcmp($a['region_name'], $b['region_name']);
});

$address_choose = $t_addres;

$p_mode = $this->_datas['p_mode'];

$use_choose_city = (($p_mode == 'VK' || $p_mode == 'FB') && !$msk && !$sbp);

$ip = $this->_datas['remote'];
$city = '';

$query = $this->_datas['query'];

if ($query && $use_choose_city)
{
    parse_str($query, $output);
    if (isset($output['city_yes']))
    {
        $use_choose_city = false;
    }
}

if ($use_choose_city)
{
    $use_choose_city = false;

    if ($ip)
    {
        /* подключаем библиоткеу для определения ip */
        require_once(__DIR__.'/sxgeo/SxGeo.php');
        $SxGeo = new SxGeo(__DIR__.'/sxgeo/SxGeoCity.dat');

        mb_internal_encoding("8bit");
        $region = $SxGeo->getCity($ip);

        mb_internal_encoding("UTF-8");

        if (isset($region['city']['name_ru']))
        {
            $city = $region['city']['name_ru'];

            if (isset($t_addres_name[$city]))
            {
                $use_choose_city = true;
            }
        }
    }
}

//$use_choose_city = ($region_name == 'Казань') && $use_choose_city;
/*echo '<div style="display:none">'.$ip.'</div>';
echo '<div style="display:none">'.(integer) $use_choose_city.'</div>';*/

$this->_datas['use_choose_city'] = $use_choose_city;
$this->_datas['address_choose'] = $address_choose;
$this->_datas['find_city'] = $city;

// < Create stylesheet link meta teg
$styledBrands = ['apple', 'acer', 'dell'];

$styleSheets = [
    'vendor/normalize.css',
    'vendor/skeleton.css',
    'select2.css',
    'vendor/owl.carousel.min.css',
    'vendor/owl.theme.green.min.css',
    'all.css',
    '_fonts.css'
];

$styledBrand = 'acer';

if (in_array($styledBrand, $styledBrands)) {
    $styleSheets[] = 'brand/'.$styledBrand.'.css';
}

$styleSheets[] = 'media.css';
$styleSheets[] = 'style.css';
$styleSheets[] = 'custom.css';

$styleSheetsStr = '/bitrix/templates/remont/css/' . implode(',/bitrix/templates/remont/css/', $styleSheets);

$styleSheetsTag = sprintf('<link href="/min/f=%s&123456" rel="stylesheet" type="text/css">', $styleSheetsStr);

unset($styledBrands, $styledBrand, $styleSheets, $styleSheetsPromo, $styleSheetsStr);

// > Create stylesheet link meta teg
$moscow = ($this->_datas['region']['name'] == 'Москва');
$spb = ($this->_datas['region']['name'] == 'Санкт-Петербург' && $this->_datas['partner']['id'] == 27);
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?=$this->_ret['title']?></title>
        
        <meta name="description" content="<?=$this->_ret['description']?>"/>
        <meta name="geo.region" content="RU<?=(($this->_datas['region']['geo_region']) ? '-'.mb_strtoupper($this->_datas['region']['geo_region']) : '')?>" />
        <meta name="geo.placename" content="<?=$geo_address?>"/>
        <? if ($this->_datas['partner']['x'] && $this->_datas['partner']['y']):?>
        <meta name="geo.position" content="<?=$this->_datas['partner']['x']?>;<?=$this->_datas['partner']['y']?>" />
        <meta name="ICBM" content="<?=$this->_datas['partner']['x']?>, <?=$this->_datas['partner']['y']?>" />
        <? endif; ?>
        <meta name="format-detection" content="telephone=no"/>
		<meta name="google-site-verification" content="vp7fDRJ9Zbi-MIgIyVfYQE5kmGA_T7KbAkTdiWVCr7E" />
		<meta name="google-site-verification" content="vFZzzS4OWvXUfILQukptPe50IG28jEkGfW07Dk8Evas" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/bitrix/templates/remont/images/<?=$marka_lower?>/logo.ico" />
        
        <?php if( $this->_datas['realHost'] != $this->_datas['site_name']):?>
	        <meta name="yandex" content="noindex, nofollow" />
	    <?php else:?>     
	        <meta name="robots" content="index,follow"/>
	    <?php endif; ?>
        
        
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet"/>
        
        <?php // Render all project specific stylesheets, with ar formed above
            echo $styleSheetsTag ; unset($styleSheetsTag); ?>
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->

        <?php if(!empty($this->_datas['original_setka_id']) && $this->_datas['original_setka_id']==20):?>
            <link rel="stylesheet"  type="text/css" href="/bitrix/templates/remont/css/styleB.css" />
        <?php endif; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('.js_mobactive').click(function() {
                    $('.js_mobilemenu').toggleClass('active')
                })
            });
        </script>

        <? if ($calltracking):?>
            <script type="text/javascript">
            var __cs = __cs || [];
            __cs.push(["setCsAccount", "<?=$calltracking?>"]);
            </script>
            <script type="text/javascript" async src="https://app.uiscom.ru/static/cs.min.js"></script>
        <?endif;?>
             
             <? $msk = false; $sbp = false; ?>
                 
             <? if ( count(explode('.', $this->_datas['site_name'])) == 2 ):?>
                <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-338858-3sFnv"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-338858-3sFnv" style="position:fixed; left:-999px;" alt=""/></noscript>
                <!-- Facebook Pixel Code -->
                <script>
                  !function(f,b,e,v,n,t,s)
                  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                  n.queue=[];t=b.createElement(e);t.async=!0;
                  t.src=v;s=b.getElementsByTagName(e)[0];
                  s.parentNode.insertBefore(t,s)}(window, document,'script',
                  'https://connect.facebook.net/en_US/fbevents.js');
                  fbq('init', '653029368452902');
                  fbq('track', 'PageView');
                </script>
                <noscript><img height="1" width="1" style="display:none"
                  src="https://www.facebook.com/tr?id=653029368452902&ev=PageView&noscript=1"
                /></noscript>
                <!-- End Facebook Pixel Code -->
             <? $msk = true;
             endif;?>
             
             <? if (mb_strpos($this->_datas['site_name'], 'spb') !== false) :?>
                <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-352614-esa2O"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-352614-esa2O" style="position:fixed; left:-999px;" alt=""/></noscript>
                <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-356341-59Khr"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-356341-59Khr" style="position:fixed; left:-999px;" alt=""/></noscript>
                
                <!-- Facebook Pixel Code -->
                <script>
                  !function(f,b,e,v,n,t,s)
                  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                  n.queue=[];t=b.createElement(e);t.async=!0;
                  t.src=v;s=b.getElementsByTagName(e)[0];
                  s.parentNode.insertBefore(t,s)}(window, document,'script',
                  'https://connect.facebook.net/en_US/fbevents.js');
                  fbq('init', '430318514210931');
                  fbq('track', 'PageView');
                </script>
                <noscript><img height="1" width="1" style="display:none"
                  src="https://www.facebook.com/tr?id=430318514210931&ev=PageView&noscript=1"
                /></noscript>
                <!-- End Facebook Pixel Code -->
             <? $sbp = true;
             endif;?>   
             
             <? if (!$msk && !$sbp):?>
                <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-366866-b4c6G"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-366866-b4c6G" style="position:fixed; left:-999px;" alt=""/></noscript>
                <!-- Facebook Pixel Code -->
                <script>
                  !function(f,b,e,v,n,t,s)
                  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                  n.queue=[];t=b.createElement(e);t.async=!0;
                  t.src=v;s=b.getElementsByTagName(e)[0];
                  s.parentNode.insertBefore(t,s)}(window, document,'script',
                  'https://connect.facebook.net/en_US/fbevents.js');
                  fbq('init', '2891078890934725');
                  fbq('track', 'PageView');
                </script>
                <noscript><img height="1" width="1" style="display:none"
                  src="https://www.facebook.com/tr?id=2891078890934725&ev=PageView&noscript=1"
                /></noscript>
                <!-- End Facebook Pixel Code -->
            <?endif;?>
    </head>
    <body>
        <?php if(false):?>
            <div class="cov_block" id="cov_block">
                <div class="cov_block_container">
                    <!--<div class="cov_block_img"></div>-->
                    <div class="container">
                        <p> <?= (!empty($this->_datas['original_setka_id']) && $this->_datas['original_setka_id'] == 20) ? 
                        "Если возникла необходимость отремонтировать технику, просто вызовите мастера на дом, 
                        и он устранит неисправность. Наш сотрудник приедет на указанный адрес ивыполнит работу, 
                        соблюдая все рекомендованные ВОЗ меры, 
                        по профилактике вируса covid-19. Все мастера снабжены комплектами одноразовых масок, перчаток и антисептиками." :
                        "Оставьте заявку на ремонт привычным способом через сайт. Курьер бесплатно 
                        приедет на ваш адрес, чтобы забрать неисправную технику. Он же выполнит обратную доставку из сервиса – вам достаточно 
                        лишь открыть дверь, чтобы забрать отремонтированную технику."?>
                        <br><a  onclick="(document.getElementById('cov_block').style.display='none')">Закрыть</a>
                        </p>
                    </div> 
                    
                    <div class="cov_block_img"></div>
                    <!--<span class="cov_block_close" onclick="(document.getElementById('cov_block').style.display='none')"><img src="/bitrix/templates/remont/images/btnclose.svg" width="16px"></span>  -->
                </div>
         
            </div>
         <? endif; ?>
        <? //if ($this->_datas['region']['name'] == 'Новосибирск'): 
           if (0):?>
            <div style="background: #4b4b4b"><div class="container" style="overflow: hidden;"><img src="/bitrix/templates/remont/images/shared/discount.jpg" class="discount"/></div></div>
        <? endif; ?>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="logo">
                            <span class="mobile-menu js_mobactive"><i class="fa fa-bars"></i></span>
                            <? if ($url != '/') :?>
                                <a href="/"><img src="/bitrix/templates/remont/images/<?=$marka_lower?>/logo.png"></a>
                            <?else:?>
                                <img src="/bitrix/templates/remont/images/<?=$marka_lower?>/logo.png">
                            <?endif;?>
                            <div class="slogan displayMoble">
                                Ремонт <br><?=$marka?> в <?=$this->_datas['region']['name_pe']?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="phone displayLille phone-block">
                            <a href="tel:+<?php echo $this->_datas['phone']?>" id="mango" class="">
                                <span class="phone" name="tracking_phone"><?=$phone_format?></span>
                            </a>
                            <a href="#"  class="link callback-modal"><span>Заказать обратный звонок</span></a>
                        </div>
                        <a href="#" class="mobilephone callback-modal"
                           data-title="Запишитесь на ремонт"
                           data-button="записаться на ремонт"
                           data-textarea="ваша неисправность"
                           data-title-tip="и мы свяжемся с вами в течении 3х минут"
                        ><img src="/bitrix/templates/remont/images/telephone.svg"></a>
                    </div>
                </div>
            </div>
        </header>
        <nav class="menu js_mobilemenu">
            <div class="container">
                <ul>
                    <?
                    foreach ($this->_datas['menu'] as $key => $value)
                    {
                        if ($url == $key)
                            echo '<li class="active"><span>'.$value.'</span></li>';
                        else
                            echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>