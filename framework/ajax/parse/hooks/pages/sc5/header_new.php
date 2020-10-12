<? 

use framework\tools;

$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($this->_datas['phone'], true);
$marka = $this->_datas['marka']['name'];
$marka_lower = mb_strtolower($marka);  
$region_name_pe = $this->_datas['region']['name_pe'];
$region_name = $this->_datas['region']['name'];

$msk = false; 
$sbp = false;
if ( count(explode('.', $this->_datas['site_name'])) == 2 ) $msk = true;
if (mb_strpos($this->_datas['site_name'], 'spb') !== false)  $sbp = true;

$link_citis = $links = ['' => 'Москва', 'spb' => 'Санкт-Петербург'];
$accord_links = ['Москва' => 'Москве', 'Санкт-Петербург' => 'Санкт-Петербурге'];

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/'; 

include __DIR__.'/text/exclude.php';
include __DIR__.'/text/popular.php';

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
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/<?=$marka_lower?>/logo.ico" />
        <title><?=$this->_ret['title']?></title>
        <?php if( $this->_datas['realHost'] != $this->_datas['site_name']):?>
	        <meta name="yandex" content="noindex, nofollow" />
	    <?php else:?>     
	        <meta name="robots" content="index,follow"/>
	    <?php endif; ?>
        <meta name="description" content="<?=$this->_ret['description']?>"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="viewport" content="width=device-width">
        
        <link href="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/css/reset.css" rel="stylesheet" type="text/css"/>
        <link href="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/css/select2.css" rel="stylesheet" type="text/css"/>
        <link href="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/css/promo.css" rel="stylesheet" type="text/css"/>
        
        <? if ($msk):?>
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
         <? endif;?> 
        
         <? if ($sbp):?>
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
         <? endif;?> 
         
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
       <header class="inner-page gray v-overflow">
            <div class="container">
                <div class="grid-12 flex-row padding-little">
                    <div>
                    	<? if ($url != '/') :?>
                                <span href="/" class="logo <?=$marka_lower?> flex-row relative">
                                    <img class="padding-little-right" src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/<?=$marka_lower?>/logo.png">
                                    <div class="logo-title font-little auto-line margin-left-little">Сервисный центр<br /><?=$marka?>
                                     
                                        <? if (in_array($region_name, $link_citis)):?>
                                            в <span class="caret"><span class="decoration"><?=$region_name_pe?></span>&nbsp;<i class="fa fa-caret-down"></i></span>
                                        <?endif;?>
                                       
                                       <? if (in_array($region_name, $link_citis)):?> 
                                           <div class="dropdown-menu font-little">
                                                 <? foreach ($addresis as $key => $value):
                                                        $region_name_pe_temp = ($value['region_name_pe']) ? $value['region_name_pe'] : 'Москве'; ?>
                                                        <a href="https://<?=$value['site'].($url)?>"><?=$region_name_pe_temp?></a>
                                                 <?endforeach; unset($region_name_pe_temp)?>
                                           </div>
                                       <?endif;?>    
                                        
                                   </div>                                    
                                </span>
                                
                        <?else:?>
                                <span class="logo <?=$marka_lower?> flex-row">
                                    <img class="padding-little-right" src="https://<?=$this->_datas['realHost']?>/bitrix/templates/remont/images/<?=$marka_lower?>/logo.png">
                                    <div class="logo-title font-little auto-line margin-left-little relative">Сервисный центр<br /><?=$marka?>
                                    
                                        <? if (in_array($region_name, $link_citis)):?>
                                            в <span class="caret"><span class="decoration"><?=$region_name_pe?></span>&nbsp;<i class="fa fa-caret-down"></i></span>
                                        <?endif;?>
                                                                            
                                       <? if (in_array($region_name, $link_citis)):?> 
                                           <div class="dropdown-menu font-little">
                                                 <? foreach ($addresis as $key => $value):
                                                     $region_name_pe_temp = ($value['region_name_pe']) ? $value['region_name_pe'] : 'Москве'; ?>
                                                        <a href="https://<?=$value['site'].($url)?>"><?=$region_name_pe_temp?></a>
                                                 <?endforeach; unset($region_name_pe_temp)?>
                                           </div>
                                       <?endif;?>  
                                        
                                    </div>                                      
                                    
                                </span>
                        <?endif;?>
                    </div>
                    
                    
                    <div class="align-right">
                        <a href="tel:+<?=$phone?>" class="font-medium" id="mango"><?=$phone_format?></a>
                        <!--<p class="font-little"><?=$this->_datas['region']['name'] . ', ' .(($this->_datas['partner']['address2']) ? $this->_datas['partner']['address2'] : $this->_datas['partner']['address1'])?></p>-->
                        
                        <div class="font-little display-sm relative">Сервисный центр <?=$marka?>

                            <? if (in_array($region_name, $link_citis)):?>
                                в <span class="caret"><span class="decoration"><?=(($region_name_pe == 'Санкт-Петербурге') ? 'СПБ' : $region_name_pe)?></span>&nbsp;<i class="fa fa-caret-down"></i></span>
                            <?endif;?>
                            
                             <div class="dropdown-menu font-little dropdown-right">
                                   <? foreach ($addresis as $key => $value):
                                       $region_name_pe_temp = ($value['region_name_pe']) ? $value['region_name_pe'] : 'Москве';
                                       $region_name_pe_temp = ($value['region_name_pe'] == 'Санкт-Петербурге') ? 'СПБ' : $value['region_name_pe'];?>
                                        <a href="https://<?=$value['site'].($url)?>"><?=$region_name_pe_temp?></a>
                                  <?endforeach; unset($region_name_pe_temp)?>
                             </div>
                        </div>
                    </div>
                </div>                
                    
                <? if ($use_choose_city):?>
                    <div class="align-center padding-little-top padding-little-bottom choose-city">
                        <p class="font-little">Ваш город:</p>
                        <div class="font-little margin-bottom-very-little">
                            <span class="caret"><span class="decoration"><?=$city?></span>&nbsp;<i class="fa fa-caret-down"></i></span>
                            
                            <ul class="dropdown-menu font-little padding-little-all">
                                <?foreach ($address_choose as $key => $value):
                                    echo '<li><a href="'.$value['site'].'">'.$value['region_name'].'</a></li>';
                                endforeach;?>                                              
                            </ul>
                            
                        </div>
                        <button type="button" class="font-button button <?=$marka_lower?>" id="city-yes" data-site=<?=$t_addres_name[$city]['site']?>>Да</button>
                        <button type="button" class="font-button button-reverse <?=$marka_lower?>" id="city-no">Нет</button>
                    </div>
                <?endif;?>
            </div>
       </header>
     