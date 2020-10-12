<?php
use framework\tools;
use framework\pdo;
include ('description_pomosch_komputernaya.php');

$marka = $this->_datas['marka']['name'];  // SONY
$address = $this->_datas['partner']['address1'];
$address2 = $this->_datas['partner']['address2'];
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$marka_lower = mb_strtolower($marka);
$region_name = $this->_datas['region']['name'];//Москва
$url = $this->_datas['arg_url'];
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$menu = $this->_datas['menu'];
$urlm = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';

$all_deall_devices = $this->_datas['all_devices'];

$logo_image = "/images/".mb_strtolower($marka)."-logotip.png";
$back='';
if ($this->_datas['hab'] === true) {
	$logo_image = "/images/hab-logo.png"; // RS
	if ($this->_datas['hb'] === true) {
        $logo_image = "/images/hab/logo.png";
	    if (!empty($marka)) {
            $logo_image = "/images/hab/{$marka}/{$marka}-logo.png";
        }
        
        /* код для того чтобы сделать страницу help общую. Rat*/
        // if($this->_datas['arg_url']=='help'){
        //     if(!empty($this->_datas['previous_url']) ){
        //         $back = 'https://'.$this->_datas['previous_url'];
        //         // echo '<div style="display:none">'.$_SERVER['REQUEST_URI'].'</div>';
        //     }
        // }
    }
}

$metrica = $this->_datas['metrica'];

$new_temp_d = [];

foreach ($this->_datas['all_devices'] as $key => $device) {
    if (!empty($new_temp_d[$device['type']])) {
        unset($this->_datas['all_devices'][$key]);
    }
    $new_temp_d[$device['type']] = true;
}

$all_deall_devices = $this->_datas['all_devices'];

if(!empty($this->_datas['gadget'])){
    $gadget = $this->_datas['gadget'];
    $model_type_name_ru = $gadget['type'];
}elseif(!empty($this->_datas['orig_model_type'][0]['name'])){
    $model_type_name_ru = $this->_datas['orig_model_type'][0]['name'];
}

function getGaget($array, $g){
    foreach($array as $key => $value){
        if(!empty($key)){
            if($value['type'] == $g){
                echo  $key;
            }
        }
    }
}

if (!empty($this->_datas['hab'])) {
    //$params = unserialize($this->_datas['params']);

    $sql_charset = 'utf8';
    $sql_opt = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $sql_host    = '148.251.19.126';
    $sql_db      = 'cibacrm';
    $sql_user    = 'cibacrm';
    $sql_pass    = 'y0fgdrsVhmgsAVs4vmC4Sm8YAUvV7R6u';
    $sql_dsn     = "mysql:host={$sql_host};dbname={$sql_db};charset={$sql_charset}";

    $this->ciba_pdo = new \PDO($sql_dsn, $sql_user, $sql_pass, $sql_opt);
        
        $ciba_model_type_name = pdo::getPdo()->query('SELECT `name` FROM `model_types` WHERE `id`='.$this->_datas['params']['model_type_id'])->fetchColumn();
        $ciba_model_type_id = $this->ciba_pdo->query('SELECT `id` FROM `model_types` WHERE `name`="'.$ciba_model_type_name.'" AND `organization_id` IS NULL LIMIT 1')->fetchColumn();
        $query = $this->ciba_pdo->prepare('SELECT `name_prices`.`name`, MIN(`s_prices`.`price`) AS `price` FROM `s_prices` LEFT JOIN `models` ON `s_prices`.`model_id`=`models`.`id` LEFT JOIN `name_prices` ON `s_prices`.`name_price_id`=`name_prices`.`id` WHERE `models`.`model_type_id`=? GROUP BY `s_prices`.`name_price_id`');
        $query->execute([$ciba_model_type_id]);
        $all_services = $query->fetchAll();
        
        srand($this->_datas['feed']);
        
        foreach ($all_services as $key => $val) {
            $all_services[$key]['price'] = $val['price']+(rand(1,7)*50+rand(0,1)*49);
            $all_services[$key][0] = $val['name'];
            $all_services[$key][1] = $all_services[$key]['price'];
        }
        
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114748825-19"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-114748825-19');
    </script>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<? if ($this->_datas['hab'] === false) { ?>
		<link rel="shortcut icon" href="/images/<?=mb_strtolower($marka)?>-fav.ico">
	<? } else { ?>
        <? if ($this->_datas['hb'] === true) { echo '<link rel="shortcut icon" type="image/x-icon" href="/images/hab/favicon.ico" />'; } else { echo '<link rel="icon" type="image/png" href="/images/hab-favicon.png" />'; } ?>
	<? } ?>
	<?php if( $this->_datas['realHost'] != $this->_datas['site_name']):?>
	    <meta name="yandex" content="noindex, nofollow" />
	<?php endif; ?>
    <link rel="stylesheet" href="/templates/russupport/styles.css">
    <link rel="stylesheet" href="/templates/russupport/font-awesome.min.css">
    <title><?=$this->_ret['title']?></title>
    <meta name="description" content="<?=$this->_ret['description']?>">
	<?php //if ($this->_datas['hab'] === true) { echo '<meta name="robots" content="none"/>'; } ?>
    <meta name="geo.region" content="RU-город <?=$region_name?>" />
    <meta name="geo.placename" content="<?=$address?>, <?=$region_name?>, Россия, <?=$this->_datas['partner']['index']?>" />
    <meta name="geo.position" content="<?=$this->_datas['partner']['x']?>;<?=$this->_datas['partner']['y']?>" />
    <meta name="ICBM" content="<?=$this->_datas['partner']['x']?>, <?=$this->_datas['partner']['y']?>" />

    <meta name="google-site-verification" content="GCZWe_sUHulgSx3n8UcBC0x_B1GTQ1sPTZaupOeEhac" />

    <script src="/templates/russupport/js/jquery.min.js"></script>
    <script src="/templates/russupport/js/bootstrap.min.js"></script>
    <script src="/templates/russupport/js/jquery.formstyler.min.js"></script>
    <script src="/templates/russupport/js/chart.bundle.min.js"></script>
    <script src="/templates/russupport/js/jquery.maskedinput.js"></script>
    <script src="/templates/russupport/js/cookie.js"></script>
    <script src="/templates/russupport/js/main.js"></script>
    <script src="/templates/russupport/js/ymid.js"></script>
    <? if ($urlm == '/' || $urlm == '/info/' || $urlm == '/about/'):?><script src="/templates/russupport/js/chart.js"></script><?endif;?>
    
    <?php if (!empty($metrica)) :?>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter<?php echo $metrica; ?> = new Ya.Metrika({
                            id:<?php echo $metrica; ?>,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true,
                            triggerEvent:1
                        });
                    } catch(e) { }
                });
                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";
        
                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/<?php echo $metrica; ?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    <?php endif; ?>
    <?
    $vk = 0;
    if ($this->_datas['hab'] === false)
    {
        if (mb_strpos($this->_datas['site_name'], '-') === false)
            $vk = 1;
    }   
    else
    {
       if (mb_strpos($this->_datas['site_name'], 'mos') !== false)
            $vk = 1;
    }
    
    if (!$vk)
    {
        if (mb_strpos($this->_datas['site_name'], 'spb') !== false)
            $vk = 2;
    }
    ?>       
    <? if ($vk == 1):?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-351807-hCiAG"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-351807-hCiAG" style="position:fixed; left:-999px;" alt=""/></noscript>
    <?endif;?>
    <? if ($vk == 2):?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-357331-4bck5"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-357331-4bck5" style="position:fixed; left:-999px;" alt=""/></noscript>
    <?endif;?>
    <? if (!$vk):?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-369533-dfkRV"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-369533-dfkRV" style="position:fixed; left:-999px;" alt=""/></noscript>
    <?endif;?>
    <? if ($vk == 1):?>
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
          fbq('init', '333778397280718');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=333778397280718&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
     <?endif;?>
     <? if ($vk == 2):?>
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
          fbq('init', '1034721756860850');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=1034721756860850&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
     <?endif;?>
     <? if (!$vk):?>
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
          fbq('init', '2350377758617854');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=2350377758617854&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
     <?endif;?>
</head>

<?
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

$use_choose_city = (($p_mode == 'VK' || $p_mode == 'FB') && !$vk);  

$ip = $this->_datas['remote'];
$city = '';

$query = $this->_datas['query'];

if ($query && $use_choose_city) 
{
    parse_str($query, $output);
    if (isset($output['choose']))
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

$this->_datas['use_choose_city'] = $use_choose_city;
$this->_datas['address_choose'] = $address_choose;
$this->_datas['find_city'] = $city;

?>

<body>
    
    
<?php if(false):?>        
    <div class="info_block_top" id="info_block_top">
         <div class="info_block_container">
             <div class="info_block_img"></div>
             <p>Теперь вы можете заказать весь необходимый ремонт в <?=$this->_datas['servicename']?>с бесплатной бесконтактной доставкой. 
				 Наш курьер возьмет на себя перевозку техники в сервис. 
				 Также сотрудник сервисного центра привезет отремонтированную технику на дом.</p>
             <!--<button type="button" class="close x_pos" data-dismiss="modal">&times;</button>-->
              <span class="close_info_block" onclick="(document.getElementById('info_block_top').style.display='none')">
                  
                  <img src="/templates/russupport/img/cross.png" width="16px">
                  </span>  
         </div>
         
    </div>
<?php endif;?>        
            
<header>
    <div class="h-top">
        <div class="container">
            <div class="grid-12">
                <div class="h-top-inside">
                     <span class="logo" >
                        <? if ($this->_datas['arg_url'] != '/'):?>
                             <a href="/"><img class="logo-image" src="<?=mb_strtolower($logo_image)?>"/></a>
                        <?else:?>
                             <img class="logo-image" src="<?=mb_strtolower($logo_image)?>"/>
                        <?endif;?>
                        <div class="logo-title">Сервисный центр в&nbsp;
                            <div class="h-top-address">
                                <div class="city-block">
                                    <div class="city-block-select"><span><?=$region_name_pe?></span></div>
                                    <ul class="city-block-dropdown">
                                        <?foreach ($this->_datas["addresis"] as $item):?>
                                        <?if($item["region_name_pe"] == "") {$item["region_name_pe"] = "Москве";}?>
                                            <?if($region_name_pe != $item["region_name_pe"]):?>
                                                <li><a href="https://<?=$item["site"]?><?if($this->_datas['arg_url']!="/"){echo "/".$this->_datas['arg_url']."/";}?>"><?=$item["region_name_pe"]?></a></li>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </ul>
                                </div>
                            </div>          
                        </div>
                     </span>   
                    <!--<? if (!$this->_datas['partner']['exclude']): ?> 
                    <div class="city-address">
                        <?if($address2 != ""){echo $address2;}else{echo $address;}?>
                    </div>
                    <? endif; ?>-->                    
                    <? if ($use_choose_city):?>
                    <div class="city_top">
                        Ваш город
                        <p class="town"><?=$city?></p>
                        <button type="button" class="btn btn-accent btn-small btn-sm mr-3 js-yes">Да</button>
                        <button type="button" class="btn btn-dark btn-small btn-sm js-no" href="#js_cityTop" data-toggle="modal">Нет</button>
                        <input type="hidden" name="choose" value="<?=$t_addres_name[$city]['site']?>"/>
                    </div>
                    <?endif;?>
                    <div class="h-top-phone">
                    	<div class="phone-number"><a href="tel:<?=$phone;?>"><?=$phone_format;?></a></div>
                        <button href="#callback" class="btn btn-dark" data-toggle="modal">Заказать звонок</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="h-boottom">
        <div class="container">
            <div class="grid-12">
                <nav>
                    <div class="mobile-menu"><i class="fa fa-bars"></i><span>Меню</span></div>
                    <?php if($this->_datas['hab'] !== true):?>
                    <ul class="m-menu" hidden>
                        <?php
                        foreach ($menu as $key => $value)
                        {
                            if ($key == '/about/price/' && count($all_deall_devices) > 1 && empty($this->_datas['hb'])) {
                                echo '<li itemprop="name" class="dropdownMenu">
                                                      <a itemprop="url" href="/about/price/">Услуги и цены</a>';
                                foreach ($all_deall_devices as $all_deall_device) {
                                    if(!empty($this->_datas['accord_image'][$all_deall_device["type"]])){
                                    $url = 'repair-' . $this->_datas['accord_image'][$all_deall_device["type"]];
                                        if ($urlm != '/'.$url.'/') { ?>
                                            <li itemprop="name"><a itemprop="url" href="/<?=$url?>/"><?=tools::mb_ucfirst($all_deall_device["type_m"])?></a></li>
                                        <?php } else { ?>
                                            <li><span><?=tools::mb_ucfirst($all_deall_device["type_m"])?></span></li>
                 <?php                  }
                                    }
                                }
                                echo '</li>';
                            }
                    
                            else if ($urlm == $key)
                                echo '<li class="active"><span>'.$value.'</span></li>';
                            else
                                echo '<li><a href="'.$back.$key.'">'.$value.'</a></li>';
                    
                        }
                        ?>
                    </ul>
                    <?php endif;?>
                    <ul class="menu">
                        <?php
                         foreach ($menu as $key => $value)
                            {
                              if ($key == '/about/price/' && count($all_deall_devices) > 1 && empty($this->_datas['hb'])) {
                                echo '<li itemprop="name" class="dropdownMenu">
                                  <a itemprop="url" href="/about/price/">Услуги и цены</a><ul class="dropdownMenuList">';
                                foreach ($all_deall_devices as $all_deall_device) {
                                    if(!empty($this->_datas['accord_image'][$all_deall_device["type"]])){
                                      $url = 'repair-' . $this->_datas['accord_image'][$all_deall_device["type"]];
                                      if ($urlm != '/'.$url.'/') { ?>
                                      <li itemprop="name"><a itemprop="url" href="/<?=$url?>/"><?=tools::mb_ucfirst($all_deall_device["type_m"])?></a></li>
                                    <?php } else { ?>
                                      <li><span><?=tools::mb_ucfirst($all_deall_device["type_m"])?></span></li>
                                    <?php }
                                    }
                                }
                                echo '</ul></li>';
                              }
                          
                          else if ($urlm == $key)
                              echo '<li class="active"><span>'.$value.'</span></li>';
                             else
                              echo '<li><a href="'.$back.$key.'">'.$value.'</a></li>';
                              
                         }
                       ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
