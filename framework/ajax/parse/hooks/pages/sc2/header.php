<?
use framework\tools;

$marka = $this->_datas['marka']['name'];
$ru_marka =  $this->_datas['marka']['ru_name'];
$marka_lower = mb_strtolower($marka);
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);

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
?>


<!DOCTYPE html>

<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="shortcut icon" href="/img/favicon-<?=$marka_lower?>.ico">

<head>

    <meta viewport="width=device-width">
    <meta name="HandheldFriendly" content="True" />

<meta name="robots" content="all">
<title><?=$this->_ret['title']?></title>
<meta charset="utf-8">
<meta content="Russian" name="language">
<meta content="DIAFAN.CMS http://www.diafan.ru/" name="author">
    <?= $verify_meta; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php if( $this->_datas['realHost'] != $this->_datas['site_name']):?>
	    <meta name="yandex" content="noindex, nofollow" />
	<?php endif; ?>

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
    <div class="wrapper">
        <header>
            <div class="header__top fixed">
                <? if ($url != '/') :?>
                    <a href="/"><img src="/img/logo-<?=$marka_lower?><?=$header_1?>.png" alt="logo" class="<?=$marka_lower?>"/></a>
                <?else:?>
                    <span><img src="/img/logo-<?=$marka_lower?><?=$header_1?>.png" alt="logo" class="<?=$marka_lower?>"/></span>
                <?endif;?>
                <p class="header__top__tagline"><span>СЕРВИСНЫЙ ЦЕНТР</span><span><?php if ($this->_datas['region']['name_pe']=='Москве' && mb_strtoupper($marka) == 'NIKON') { echo 'ФОТОТЕХНИКИ'; } else { echo mb_strtoupper($marka); } ?> В <?=mb_strtoupper($this->_datas['region']['name_pe'])?></span></p>
                <div class="header__top__phone"><a class="footphone mango_id" href="tel:+<?=$phone?>">+<?=$phone_format?></a></div>
                <div class = "mobilemenu"><a href = "#" class = "mobtoggle"><img src = "/img/menu.png"></a></div>
                <div class="clear"></div>
                <p class="header__top__worktime"><?=$time?></p>
                <div class="clear"></div>
            </div>
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
                                echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                         }
                        ?>
                    </ul>
                </div>
            </div>
        </header>
