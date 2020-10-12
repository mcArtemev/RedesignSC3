<?
use framework\tools;
use framework\pdo;

// var_dump($this->_datas['ololo']);
$marka = $this->_datas['marka']['name'];
$ru_marka =  $this->_datas['marka']['ru_name'];
$marka_lower = mb_strtolower($marka);
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);

$multiMirrorLink='';
// var_dump($this->_datas['multiBrand']);

$multiMirrorLink = (!empty($this->_datas['multiBrand'])) ? '/'.$this->_datas['multiBrand'] : '';

$accord = $this->_datas['accord'];
$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$time = ($this->_datas['partner']['time']) ? mb_strtoupper($this->_datas['partner']['time']): 'БЕЗ ВЫХОДНЫХ, С 10-00 ДО 21-00';

$header_1 = '';
if ($this->_datas['setka_name'] == 'СЦ-2' && (($marka_lower == 'samsung') || ($marka_lower == 'nikon') || ($marka_lower == 'sony')))
    $header_1 = '2';

$status = '';
if (!in_array($marka_lower, array('canon', 'dell', 'nikon', 'toshiba')) && $this->_datas['region']['name'] == 'Москва')
    $status = ' class="menu-status"';

$verify_meta = "";

switch ( $this->_datas['region']['name']  ) {
    case "Уфа" :
        $verify_meta = "<meta name=\"google-site-verification\" content=\"3sdO3SwSdewI7GkdNT8RJeijXT3McvqF-3L-nLVUBhg\" />";
        break;
    case "Новосибирск" :
        $verify_meta = "<meta name=\"google-site-verification\" content=\"PXlNLp4oMx46mRJ2_qgk1V9VN9RKq_uz3XdzDuZW0oA\" />";
        break;
    case "Санкт-Петербург" :
        $verify_meta = '<meta name="google-site-verification" content="LGC_Hqkxubc2cV3unAEmqfjhE00cQ3Yx-Y931Pf_OKg" />';
        break;
    case "Нижний Новгород" :
        $verify_meta = '<meta name="google-site-verification" content="xI8RB7V95P1HFOldWLVNXCc7MAVbgvESAbN6nUS6p0w" />';
        break;
    case "Казань" :
        $verify_meta = '<meta name="google-site-verification" content="JEsV8e18Ee978Lx4WLJ5M6Smn6q3Nxdm-o4NXt6wy58" />';
        break;
    case "Самара" :
        $verify_meta = '<meta name="google-site-verification" content="cG1PRUfBRKuCJbdcvQNpC3494iW7ToAS-Y_Ai88XT2g" />';
        break;
    case "Ростов-на-Дону" :
        $verify_meta = "<meta name=\"google-site-verification\" content=\"cNkFsYi9rgKGRKzjg1fBMmtz6diRIpnsuzDp-mRXQKI\" />";
        break;
    case "Волгоград" :
        $verify_meta = '<meta name="google-site-verification" content="DlsAycwIXo8aAXsijzNZuk0sFxAJfH0j2IHY8FpiyUI" />';
        break;
    case "Саратов" :
        $verify_meta = '<meta name="google-site-verification" content="0aCbSCUCXyanvqhOcVHTJwHeZu5UU0Bu1mmNFbTyp3Y" />';
        break;
    case "Пермь" :
        $verify_meta = "";
        break;
    case "Мурманск" :
        $verify_meta = '<meta name="google-site-verification" content="R_JJmXfKKrONr76_2BH_NcC6MSHK7SM7XIX2vrvWp-A" />';
        break;
}
foreach($this->_datas['all_devices'] as $k => $v){
    if(empty($v["type_id"])){
        foreach($this->_datas['all_devices'] as $key =>$vulue){
            if($key!=$k && in_array($v["type"],$vulue)){
                unset($this->_datas['all_devices'][$k]);
            }
        }
    }      
} 


if ($this->_datas['realHost'] == "customers.ru.com")
{    
    
    $dbh = pdo::getPdo();
    $stmt = $dbh->prepare("SELECT regions.* FROM regions 
                            LEFT JOIN sites ON regions.id=sites.region_id
                            WHERE sites.setka_id=2 
                            GROUP BY regions.name");
    $stmt->execute();
    $regionList = $stmt->fetchAll();
    array_unshift($regionList, ['name'=>'Москва','name_pe'=>'Москве','name_re'=>'Москвы']);
    
    foreach ($regionList as $value)
    {
        $str .= '<li class="thisCity"><a>';
        $str .= $value['name'];
        $str .= '</a></li>';
        if($this->_datas['region_name'] == $value['name']){
            $region_name_pe = $value['name_pe'];
            $region_name_re = $value['name_re'];
        }
        
    }
}

if(!empty($this->_datas['validatedCity']) && $this->_datas['validatedCity']=='validatedCity'){
    if($this->_datas['region_name'] =='Москва' || empty($this->_datas['region_name'])){
        $sql = "SELECT phone FROM sites WHERE region_id = 0 AND sites.setka_id =2 LIMIT 1";
    }else{
        $sql="SELECT sites.phone FROM sites
                                LEFT JOIN regions ON sites.region_id = regions.id
                                WHERE regions.name LIKE '".$this->_datas['region_name']."'
                                AND sites.setka_id = 2
                                LIMIT 1";
    }
        $dbh = pdo::getPdo();
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $indexSitePhone = $stmt->fetchColumn();
        // var_dump($indexSitePhone);     
    
}
                    
?>


<!DOCTYPE html>

<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="shortcut icon" href="/img/favicon-<?=$marka_lower?>.ico">

<head>

    <meta viewport="width=device-width">
    <meta name="HandheldFriendly" content="True" />

<!--<meta name="robots" content="noindex, nofollow">-->
	<?php if( $this->_datas['realHost'] != $this->_datas['site_name']):?>
	    <meta name="yandex" content="noindex, nofollow" />
	<?php endif; ?>

<title><?=$this->_ret['title']?></title>
<meta charset="utf-8">
<meta content="Russian" name="language">
<meta content="DIAFAN.CMS http://www.diafan.ru/" name="author">
    <?= $verify_meta; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	    

	
<meta name="description" content="<?=$this->_ret['description']?>">

<link href="/css/reset.css" rel="stylesheet" type="text/css">
<link href="/custom/sony/css/style.css" rel="stylesheet" type="text/css">

<!--[if lt IE 9]><script src="//yandex.st/jquery/1.10.2/jquery.min.js"></script><![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="//yandex.st/jquery/2.0.3/jquery.min.js" charset="UTF-8"></script><!--<![endif]-->
<script type="text/javascript" src="/js/jquery.maskedinput.js" charset="UTF-8"></script>
<script type="text/javascript" src="/custom/sony/js/main.js" charset="UTF-8"></script>



<? if ($this->_datas['arg_url'] == 'order' || $this->_datas['arg_url'] == 'ask'): ?>
    <script type="text/javascript" src="/custom/sony/js/order.js" charset="UTF-8"></script>
<?endif;?>
<? if ($this->_datas['arg_url'] == 'thank-you'): ?>
    <script type="text/javascript" src="/custom/sony/js/thank-you.js" charset="UTF-8"></script>
<?endif;?>
<? if ($this->_datas['arg_url'] == 'status'): ?>
    <script type="text/javascript" src="/custom/sony/js/status.js" charset="UTF-8"></script>
<?endif;?>
</head>

<body>
    <?php if(false):?>
    <div class="nadomu" id="nadomu">
        <div class="nadomu_container">
            <div class="nadomuImg"></div>
            <p>
                Новые условия требуют новых решений. Теперь в <?=$this->_datas['servicename']?> вы можете заказать услуги по 
    		    ремонту техники с бесплатной бесконтактной доставкой. Как это работает?  
    		    В день доставки курьер приедет на указанный адрес для получения техники, которую нужно отремонтировать. 
    		    После окончания обслуживания устройства в СЦ, наш сотрудник привезет технику обратно.
    		</p>
            <span class="close_nadomu" onclick="(document.getElementById('nadomu').style.display='none')"><img src="/img/close.svg" width="24px"></span>
        </div>
     </div>
     <?php endif;?>
    
    <div class="wrapper">
        <div class="choiceCity">
            <?php
                if(!empty($this->_datas['validatedCity']) && $this->_datas['validatedCity'] == 'notValidated'):
                    $TopPopupPosition = 'TopPopupPositionRight';//"right: 0; top: 120px;";
                    if($this->_datas['realHost'] == "customers.ru.com"):?>
                        <div class="city_top">
                            Ваш город
                            <p class="town"><?=$this->_datas['region_name']?></p>
                            <button type="button" class="btn city_top_btn proof" value="validatedCity">Да</button>
                            <button type="button" class="btn city_top_btn notCorrectCity" href="#js_cityTop" data-toggle="modal">Нет</button>
                            <input type="hidden" name="choose" value="<?//=$t_addres_name[$city]['site']?>"/>
                        </div>
            <?php   endif;
                else:
                    $TopPopupPosition = 'TopPopupPositionLeft';//"left: 10px; top: 80px;";
                endif;
                if($this->_datas['realHost'] == "customers.ru.com"):
            ?>        
                        <div class="top-popupCity <?=$TopPopupPosition?>"  id="top-popupCity" >
                            <ul>
                               <?=$str?>
                            </ul>
                            <span class="close">&times;</span>
                        </div>
            <?php
                endif;
            ?>
        
        </div>
        <header>

            <div class="header__top fixed">

                
                <? if ($url != '/') :?>
                    <a href="<?=$multiMirrorLink?>/"><img src="/img/logo-<?=$marka_lower?><?=$header_1?>.png" alt="logo" class="<?=$marka_lower?>"/></a>
                <?else:?>
                    <span><img src="/img/logo-<?=$marka_lower?><?=$header_1?>.png" alt="logo" class="<?=$marka_lower?>"/></span>
                <?endif;?>
                
                <?php if(empty($this->_datas['region_name'])|| !empty($this->_datas['multiBrand'])):?>
                <p class="header__top__tagline">
                    <span>СЕРВИСНЫЙ ЦЕНТР</span>
                    <span>
                    <?php if ($this->_datas['region']['name_pe']=='Москве' && mb_strtoupper($marka) == 'NIKON') { echo 'ФОТОТЕХНИКИ'; } else { echo mb_strtoupper($marka); } ?> 
                    
                    <?php if(!empty($this->_datas['validatedCity']) && $this->_datas['validatedCity'] != 'notValidated'):?> 
                        В <a class="toggleShow" ><?=mb_strtoupper($this->_datas['region']['name_pe'])?></a>
                    <?php else:?>    
                        В <?=mb_strtoupper($this->_datas['region']['name_pe'])?>
                    <?php endif;?>   
                    </span>
                </p>
                <?php else: ?>
                
                    
                    <p class="header__top__tagline"><span>СЕРВИСНЫЙ ЦЕНТР</span>
                    <?php if(!empty($this->_datas['validatedCity']) && $this->_datas['validatedCity'] != 'notValidated'):?>
                        <span class="">REMONT CENTRE В 
                            <a class="toggleShow"><?=mb_strtoupper($region_name_pe)?></a>
                        </span>
                        
                    <?php else:?>
                       <span class="">REMONT CENTRE В <?=mb_strtoupper($region_name_pe)?></span>
                    <?php endif;?>    
                    </p>
                <?php 
                endif;?>
                
                
                
            <?php if(!empty($phone)):?>
                <div class="header__top__phone"><a class="footphone mango_id" href="tel:+<?=$phone?>">+<?=$phone_format?></a></div>
            <?php else:
                $indexSitePhone = (!empty($indexSitePhone)) ? $indexSitePhone : '';
            ?>    
                <div class="header__top__phone"><a class="footphone mango_id" href="tel:+<?=$indexSitePhone ?>">+<?=tools::format_phone($indexSitePhone)?></a></div>
            <?php endif;?>
                <div class = "mobilemenu"><a href = "#" class = "mobtoggle"><img src = "/img/menu.png"></a></div>
                <div class="clear"></div>
                <p class="header__top__worktime"><?=$time?></p>
                <div class="clear"></div>

            </div>
            
            

            
            <?php if(empty($this->_datas['region_name'])|| !empty($this->_datas['multiBrand'])):?>
            <div class="header__menu wrapper">
                <div class=" fixed">
                    <div class = "mobilephone">
						<a class="footphone mango_id" href="tel:+<?=$phone?>">+<?=$phone_format?></a>
					</div>
					<div class="mobileworktime">
						<?=$time?>
					</div>
                    <ul<?=$status?>>
                        <? foreach ($this->_datas['menu'] as $key => $value)
                        {
                            if ($url == $key)
                                echo '<li><span class="active">'.$value.'</span></li>';
                            else
                                echo '<li><a href="'.$multiMirrorLink.$key.'">'.$value.'</a></li>';
                         }
                        ?>
                    </ul>
                </div>
            </div>
            <?endif;?>
        </header>
