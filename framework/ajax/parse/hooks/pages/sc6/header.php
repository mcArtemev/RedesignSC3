<?php
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$partner = $this->_datas['partner'];
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$marka_lower = mb_strtolower($marka);
$region_name = $this->_datas['region']['name'];//Москва
$region_name_pe = $this->_datas['region']['name_pe'];//Москве
$url = $this->_datas['arg_url'];
$topCities = ['Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Нижний Новгород', 'Казань', 'Челябинск', 'Омск', 'Самара', 'Ростов-на-Дону'];

$addresis = $this->_footer_addresis(['Москва'], 100);

if (file_exists('/var/www/www-root/data/www/sc6/_mod_files/_css/'.$marka_lower.'.css')) {
    $cssFile = $marka_lower.'.css';
} else {
    $cssFile = 'brend1.css';
}
if($marka == 'Philips'){
    foreach ($this->_datas['all_devices'] as $key=> $type) {
        if($type['type'] == "телефон"){
            unset($this->_datas['all_devices'][$key]);
        }
    }
}



function cropArrTypes($Arr)
{
    $lowPriority = ['варочная панель', 'водонагреватель', 'вытяжка', 'электрическая плита',
        'сортировщик купюр', 'массажное кресло', 'квадрокоптер', 'домашний кинотеатр',
        'пылесос', 'хлебопечка', 'кухонный комбайн', 'микроволновая печь', 'мфу',
        'лазерный принтер', 'струйный принтер', 'электросамокат', 'моноколесо',
        'сегвей', 'гироскутер', 'кондиционер', 'смарт-часы', 'видеокамера',
        'майнер', 'электрошвабра', 'наручные часы', 'объектив', 'компьютер',
        'видеокарта', 'наушники', 'материнская плата', 'роутер','водонагреватель','плоттер',];

    if (count($Arr) > 18) {
        foreach ($Arr as $key => $value) {
            if (in_array($key, $lowPriority)) {
                unset($Arr[$key]);
            }
            if(count($Arr)<=18){
                break;
            }
        }

    }
    return $Arr;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="GENERATOR" content="
 -= Amiro.CMS (c) =-
 www.amiro.ru
">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="geo.region" content="RU-город <?=$region_name?>" />
    <meta name="geo.placename" content="<?=$partner['address1']?>, <?=$region_name?>, Россия, <?=$this->_datas['partner']['index']?>" />
    <meta name="geo.position" content="<?=$this->_datas['partner']['x']?>;<?=$this->_datas['partner']['y']?>" />
    <meta name="ICBM" content="<?=$this->_datas['partner']['x']?>, <?=$this->_datas['partner']['y']?>" />
    <meta name="yandex-verification" content="1944871e467206a4" />
    <meta name="google-site-verification" content="dIQGl_XYlkasws5-9b18Vaphnj9aSDA7V8V_i4ApMzY" />
    <link rel="icon" type="image/png" href="/_mod_files/_img/fav<?=$marka_lower?>.png" />
    <title><?=$this->_ret['title']?></title>
    <meta name="description" content="<?=$this->_ret['description']?>">
    <link rel="stylesheet" href="/_mod_files/_css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=cyrillic" crossorigin="anonymous">
    <link rel="stylesheet" href="/_mod_files/_css/font-awesome.min.css">
    <link rel="stylesheet" href="/_mod_files/_css/main.css">
    <link rel="stylesheet" href="/_mod_files/_css/owl/owl.carousel.min.css">
    <link rel="stylesheet" href="/_mod_files/_css/owl/owl.theme.green.min.css">
    <link rel="stylesheet" href="/_mod_files/_css/<?=$cssFile?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <?  $moscow = false;
        $spb = false;
        
        if (mb_strpos($this->_datas['site_name'], 'msk') !== false && mb_strpos($this->_datas['site_name'], 'omsk') === false):?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-352621-3CfSk"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-352621-3CfSk" style="position:fixed; left:-999px;" alt=""/></noscript>
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
          fbq('init', '1043951629147473');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=1043951629147473&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    <? $moscow = true;
    endif;?>
    
    <? if (mb_strpos($this->_datas['site_name'], 'spb') !== false):?> 
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-360709-cHP9E"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-360709-cHP9E" style="position:fixed; left:-999px;" alt=""/></noscript>
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
          fbq('init', '2291245701128797');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=2291245701128797&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    <? $spb = true;
    endif;?>
    
    <?if (!$moscow && !$spb):?>
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?161",t.onload=function(){VK.Retargeting.Init("VK-RTRG-378942-8djFu"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-378942-8djFu" style="position:fixed; left:-999px;" alt=""/></noscript>
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
          fbq('init', '476685299754322');
          fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=476685299754322&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    <?endif;?> 
</head>
    <?php if(false):?>
        <div class="block_inform" id="block_inform">
            <div class="container_info">
                <div class="info_img"></div>
                <p>Новые условия требуют новых решений. В связи с эпидемией covid-19, теперь в Сервисном центре <?=$marka?> вы можете заказать 
    			услуги по ремонту техники с бесплатной бесконтактной доставкой.Как это работает?  
    			В день доставки курьер приедет на указанный адрес для получения техники, которую нужно отремонтировать. 
    			После окончания обслуживания устройства в СЦ, наш сотрудник привезет технику обратно.</p>
                <span class="close_info" onclick="(document.getElementById('block_inform').style.display='none')"><img src="/_mod_files/_img/close_info.svg" width="16px"></span>
            </div>
        </div>
    <?php endif;?>    
<div class="page">

    
    <header class="page-head">
        <div class="container">
            <div class="page-head__inner">
                
                    <div class="logo_inner">
                        <a <?if ($url != '/') echo "href=\"/\""?> class="logo">
						    <img src="/_mod_files/_img/l<?=$marka_lower?>.png" alt="" class="logo_img">
						</a>
						<div class="logo_info">
                            Сервисный центр
                            <div class="city-menu">
                                <span class="city-menu__sub"><?=$marka?> в <?=$region_name_pe?></span>
                                
                                <ul class="city-menu__inner">
                                      <?
                                      $check['id']='';
                                      foreach ($addresis as $key => $item) { if ($this->_datas['site_id'] == $item['site_id']) continue;
                                          
                                      if (in_array($item['region_name'], $topCities)) {
                                          
                                          if ($check['id'] == $item['site_id']) continue;
                                        ?>
                                         <li><a href="https://<?=$item["site"]; $check['id'] = $item['site_id'];?>/<?=($url == '/' ? '' : preg_replace('/(^\/|\/$)/', '', $url).'/')?>"><?=($item['region_name'] != '' ? $item['region_name'] : 'Москва')?></a></li>
                                    <?} } ?>
                                 </ul>
                            </div>
                    </div>
                    </div>
                    
                

                <div class="header-right">
                    <!--<div class="header-cities">
                        <div class="city-select">
                            <span class="city-select__title">Город</span>
                            <div class="city-menu">
                                <span class="city-menu__sub"><?=$region_name?></span>
                                <ul class="city-menu__inner">
                                    <?
                                    foreach ($addresis as $key => $item) { if ($this->_datas['site_id'] == $item['site_id']) continue; ?>
                                      <li><a href="https://<?=$item["site"]?>/<?=($url == '/' ? '' : preg_replace('/(^\/|\/$)/', '', $url).'/')?>"><?=($item['region_name'] != '' ? $item['region_name'] : 'Москва')?></a></li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="header-adress">
                            <? if (!$this->_datas['partner']['exclude']): ?>
                                <span>Адрес</span>                           
                                <?=($partner['address2'] ? $partner['address2'] : $partner['address1'])?>
                            <? endif; ?>
                        </div>
                        <div class="header-adress header-timework">
                            <span>Время работы</span>
                            <?=(empty($this->_datas['partner']['time']) ? 'Пн-Вс, с 9:00 до 18:00' : $this->_datas['partner']['time'])?>
                        </div>
                    </div>-->

                    <div class="header-phone">
                        <a href="tel:<?=$phone?>">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            &nbsp;<?=$phone_format?>
                        </a>
                        <span data-toggle="modal" data-target="#requestModal">Заказать звонок</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <nav class="navbar">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <?php
              $menu = [
                '/' => 'Главная',
                'o_kompanii/price_list' => 'Цены',
                #'uslugi' => 'Услуги',
                'komplektuyshie' => 'Комплектующие',
                'neispravnosti' => 'Неисправности',
                'o_kompanii/akciya' => 'Акции',
                'o_kompanii' => 'О компании',
                'o_kompanii/informaciya' => 'Контакты',
              ];
            ?>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-nav-gen">
                  <?php foreach ($menu as $urlMenu => $itemMenu) { ?>
                    <li <?php if($url == $urlMenu) echo 'class="active"';?>>
                        <?php if($url != $urlMenu){ ?>
                          <a href="/<?=($urlMenu == '/' ? '' : preg_replace('/(^\/|\/$)/', '', $urlMenu).'/')?>"><?=$itemMenu?></a>
                        <?php } else { ?>
                          <span><?=$itemMenu?></span>
                        <?php } ?>
                    </li>
                  <?php } ?>
                </ul>
                <div class="order-status">
			<span data-toggle="modal" data-target="#statusModal">
				<i class="fa fa-question-circle-o" aria-hidden="true"> </i>
				&nbsp;Статус заказа
			</span>
                </div>
            </div><!-- /.navbar-collapse -->
            <div class="nav_phone">
                <a href="tel:<?=$phone_format?>">
                    <?=$phone_format?>
                </a>
            </div>
        </div>
    </nav>
