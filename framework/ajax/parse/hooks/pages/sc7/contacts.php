<?
use framework\tools;
$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$region_name = $this->_datas['region']['name'];//Москва
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$address = $this->_datas['partner']['address1'];
$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'с 9:00 до 18:00 (без выходных)';
$site_name = $this->_datas['site_name'];
$ymap = $this->_datas['partner']['sid'];
$index = $this->_datas['partner']['index'];
$dop_address1 = $this->_datas['partner']['dop_address1'];
$dop_address2 = $this->_datas['partner']['dop_address2'];
$addresis = $this->_datas['addresis'];
//$breadcumb_contacts = $this->_datas['breadcumb_contacts'];
//$urlm = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';

$akcii = array();
$akcii = array("скидки","снижение стоимости","акционные услуги");
$vakansii = array();
$vakansii = array("карьера","работа в успешной компании");


$uslugi = array();
$uslugi_rand = rand(1,3);
if($uslugi_rand == 1)
{
    $uslugi = array("цены","наименования услуг");
}
if($uslugi_rand == 2)
{
    $uslugi = array("прайслист","названия услуг");
}
if($uslugi_rand == 3)
{
    $uslugi = array("стоимость","перечисление услуг");
}
$akcii = array();
$akcii = array("скидки","снижение стоимости","акционные услуги");

$use_choose_city = $this->_datas['use_choose_city'];

?>
<main>
<section class="breadcrumbs">
    <div class="container">
        <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs">
            <ul class="breadcrumbs-inside">
                   <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                    <li class="breadcrumbs-inside-drop">
                        <span itemprop="name"><a itemprop="url" href="/about/">О компании</a></span>
                        <span class="breadcrumbs-inside-drop-btn"></span>
                        <ul class="drop">
                            <li itemprop="name"><a itemprop="url" href="/about/action/">Акции</a></li>
                            <li itemprop="name"><a itemprop="url" href="/about/vacancy/">Вакансии</a></li>
                            <li itemprop="name"><a itemprop="url" href="/about/price/">Услуги и цены</a></li>
                        </ul>
                    </li>
                <li itemprop="name"><span>Контакты</span></li>
            </ul>
        </div>
    </div>
</section>
<section class="title-block" id="city">
    <div class="container">
        <div class="grid-12">
            <h1><?=$this->_ret['h1']?></h1>
        </div>
    </div>
</section>
<section class="block-section">
    <div class="container">
        <div class="grid-12">
            <div class="block-list">
                <div class="block block-address" itemscope itemtype="http://schema.org/Organization">
                    <div class="block-inside">
                        <div class="block-address-title"><?= $region_name; ?></div>
                        <div class="block-address-row" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                            <p<?=(($this->_datas['partner']['exclude']) ? (" style='display:none'") : '')?>><span>Адрес: </span><?= $index; ?>, <?= $address; ?></p>
                        <?php
                            echo ($this->_datas['hb']==true)? "<p><span>Адрес: </span>Кетчерская улица 13 стр. 2 <br> Метро Новогиреево/Новокосино</p>": ''; 
                        ?>
                            <!--<p><span>Адрес: </span>Кетчерская улица 13 стр. 2 метро Новогиреево/Новокосино</p>-->
                        <?php 
                                if (!empty($dop_address1)) { 
                                    echo '<p>'.$dop_address1.'</p>'; 
                                    
                                } 
                                if (!empty($dop_address2)) { 
                                    echo '<p>'.$dop_address2.'</p>'; 
                                } 
                            
                        ?>
                            <meta content="<?= $address; ?>" itemprop="streetAddress"/>
                            <meta content="<?= $index; ?>" itemprop="postalCode"/>
                            <meta content="<?= $region_name; ?>" itemprop="addressLocality"/>
                            <? if (!$use_choose_city):?><p><span>Телефон: </span><a href="tel:+<?= $phone; ?>"><?= $phone_format; ?></a></p><?endif;?>
                            <p><span>Время работы: </span><?= $time; ?></p>
                            <p><span>Email: </span><a href="mailto:info@<?= $site_name; ?>">info@<?= $site_name; ?></a></p>
                            <p><span>Для партнеров: </span><a href="mailto:partner@<?= $site_name; ?>">partner@<?= $site_name; ?></a></p>
                            <p><span>Руководство: </span><a href="mailto:director@<?= $site_name; ?>">director@<?= $site_name; ?></a></p>
                        </div>
                    </div>
                    <meta content="<?= $phone; ?>" itemprop="telephone"/>
                    <meta content="info@<?= $site_name; ?>" itemprop="email"/>
                </div>
                <div class="block block-image block-map">
                    <!--<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%<?= $ymap; ?>&amp;lang=ru_RU&amp;scroll=true"></script>-->
                   
                    <?//php if ($this->_datas['region']['name'] == 'Москва'):?>
					   <!--<div style="width: 100%; height: 100%; background-image: url('https://static-maps.yandex.ru/1.x/?ll=37.635321,55.79650&size=600,450&z=15&l=map&pt=37.637052,55.799766,org'); background-repeat: no-repeat; background-attachment: scroll; background-position: center; background-size: cover;"></div>-->
                    <?//else:?>
                       <div style="width: 100%; height: 100%; background-image: url('https://static-maps.yandex.ru/1.x/?ll=<?=$this->_datas['partner']['y'];?>,<?=$this->_datas['partner']['x'];?>&size=600,450&z=<?=$this->_datas['zoom']?>&l=map&pt=<?=$this->_datas['partner']['y'];?>,<?=$this->_datas['partner']['x'];?>,org'); background-repeat: no-repeat; background-attachment: scroll; background-position: center; background-size: cover;"></div>
                    <?//endif;?>
                </div>
            </div>
        </div>
        <?php //if ($this->_datas['region']['name'] == 'Москва') { ?>
        <!--<div class="grid-12">
            <div class="block-list">
                <div class="block block-howGo">
                    <div class="block-inside">
                          <div class="block-howGo-title">Как до нас пройти</div>
                          <p>От метро Рижская направо вдоль ТЦ Крестовский через Крестовский мост. Спустившись с моста направо во дворы, вы пришли.</p>
                    </div>
                </div>
                <div class="block block-image">
                    <img src="/templates/russupport/img/schema.jpg" alt="" title=""/>
                </div>
            </div>
        </div>-->
        <?php //} ?>
    </div>
</section>
<section class="link-block-section">
    <div class="container">
        <div class="grid-12">
            <?php if ($this->_datas['hb'] !== false || $this->_datas['hab'] === false): ?>
            <div class="link-block-list">
                <?php
                    
                        //var_dump($this->_datas['hab']);
                   
                    $i = 0;
                    for ($d=0; $d<=3 ; $d++) {
                    if (!$addresis[$i]['region_name']) $addresis[$i]['region_name'] = 'Москва';
                    if ($region_name == $addresis[$i]['region_name']) $i++; ?>
                <a href="https://<?php echo $addresis[$i]['site']; ?>/about/contacts/#city" class="link-block">
                    <div class="link-block-city"><?=$addresis[$i]['region_name']?></div>
                    <div class="link-block-address">
                        <p>
                        <?php 
                            
                            if(mb_stristr($addresis[$i]['address1']," офис")){
                                $addresis[$i]['address1'] = strstr($addresis[$i]['address1'], " офис", true);
                                $addresis[$i]['address1'] = trim($addresis[$i]['address1']);
                                if($addresis[$i]['address1'][strlen($addresis[$i]['address1'])-1]==','){
                                    $addresis[$i]['address1'] = substr($addresis[$i]['address1'],0,-1);
                                }
                            }
                            echo $addresis[$i]['address1'];
                        ?>
                        </p>
                        
                        <p><?php echo tools::format_phone($addresis[$i]['phone']); ?></p>
                        <p>
                        <?php 
                        if($addresis[$i]['time']){ 
                            if(!mb_stristr($addresis[$i]['time'],"ЕЖЕДНЕВНО")){
                                if(!mb_stristr($addresis[$i]['time'],"с")){
                                    $addresis[$i]['time'] = str_replace('-', ' до ',$addresis[$i]['time']);
                                    $addresis[$i]['time'] ='c '.$addresis[$i]['time'];
                                    
                                }
                                $addresis[$i]['time']=  'Без выходных '.$addresis[$i]['time'];
                            }
                            echo $addresis[$i]['time'];
                        }else{
                            echo 'с 9:00 до 18:00 (без выходных)';
                        }
                        ?>
                        </p>
                        
                    </div>
                </a>
                <?php  $i++; } ?>
            </div>
            <? endif; ?>
            
            <div class="link-block-list perelink">
                    <a href="/about/vacancy/" class="link-block">
                        <div class="link-block-title-strong">Вакансии</div><?=$this->firstup($this->rand_arr_str($vakansii))?>
                    </a>
                    <a href="/about/price/" class="link-block">
                        <div class="link-block-title-strong">Услуги</div><?=$this->firstup($this->rand_arr_str($uslugi))?>
                    </a>
                    <a href="/about/action/" class="link-block">
                        <div class="link-block-title-strong">Акции</div><?=$this->firstup($this->rand_arr_str($akcii))?>
                    </a>
            </div>
        </div>
</section>
</main>
