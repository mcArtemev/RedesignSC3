<?
use framework\tools;
use framework\ajax\boost\amp;

$amp_host = $this->_datas['https'] === 1 ? 'https://' . $this->_datas['site_name'] : 'http://' . $this->_datas['site_name'] ;
$amp_url = $this->_datas['arg_url'];

$_delimiter = '';

if ( '/' !== $amp_url )
    $_delimiter = '/';

$req_rel = 'canonical';
$req_uri = $amp_host . $_delimiter . $amp_url;

if ( !$this->_datas['isAMP'] ) {
    $_pref = '/amp';

    if ( '/' !== $amp_url )
        $_pref .= '/';

    $req_uri = $amp_host . $_pref . $amp_url;
    $req_rel = 'amphtml';
}

$amp_link = "<link rel=\"{$req_rel}\" href=\"{$req_uri}\">";

$status = '';
$header_1 = '';

if (isset($this->_datas['marka'])) {
  $marka = $this->_datas['marka']['name'];
  $ru_marka =  $this->_datas['marka']['ru_name'];
  $marka_lower = mb_strtolower($marka);
  if ((($marka_lower == 'samsung') || ($marka_lower == 'nikon') || ($marka_lower == 'sony') || ($marka_lower == 'xiaomi')))
      $header_1 = '2';
  if (!in_array($marka_lower, array('canon', 'dell', 'nikon', 'toshiba')) && $this->_datas['region']['name'] == 'Москва')
      $status = ' menu-status';

  $accord = $this->_datas['typeUrl'];
  $home = '/servis-'.$marka_lower.'/';
  $this->_datas['menu'] = [$home => $this->_datas['menu']['/']] + $this->_datas['menu'];
  unset($this->_datas['menu']['/']);
}
else {
  $home = '/';
}
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);


$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$time = ($this->_datas['partner']['time']) ? mb_strtoupper($this->_datas['partner']['time']) : 'БЕЗ ВЫХОДНЫХ, С 10-00 ДО 21-00';

if (!isset($this->_datas['marka'])) {
  foreach (['diagnostika' => 'left', 'ceny-remonta' => 'right'] as $itemMenu=>$pos) {
    $this->_datas['menu'][$itemMenu] = [
      'name' => $this->_datas['menu'][$itemMenu],
      'pos' => $pos,
      'list' => [],
    ];

    foreach ($this->_datas['markaTypes'] as $mark=>$types) {
      $this->_datas['menu'][$itemMenu]['list']['/'.$itemMenu.'-'.strtolower($mark).'/'] = $mark;
    }
  }
}
else {
  $find = ['diagnostika', 'ceny-remonta'];
  $newMenu = [];
  foreach ($this->_datas['menu'] as $k=>$v) {
    if (in_array($k, $find)) {
      $k = '/'.$k.'-'.strtolower($this->_datas['marka']['name']).'/';
    }
    $newMenu[$k] = $v;
  }
  $this->_datas['menu'] = $newMenu;
}

?>


<!DOCTYPE html>

<html <?= $this->_datas['isAMP'] ? 'amp' : '' ;?>>
<head>

    <?php if ( $this->_datas['isAMP'] ):; ?>
        <meta charset="utf-8">
    <?php else:; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php endif; ?>
<meta name="msvalidate.01" content="FA249661CFA2617BD8760C34320E6799" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?= $amp_link; ?>
<?php $favicon = '/bitrix/templates/centre/img/favicon'.(isset($marka) && $header_1 != '2' ? ucfirst($marka_lower).'.ico' : '.png'); ?>
<link rel="shortcut icon" href="<?=$favicon?>">


    <meta name="HandheldFriendly" content="True" />

<meta name="robots" content="all">
<title><?=$this->_ret['title']?></title>

<meta content="Russian" name="language">

    <?php if ( $this->_datas['isAMP'] ):; ?>
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <?php else:; ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php endif; ?>
<meta name="description" content="<?=$this->_ret['description']?>">



    <?php if ( !$this->_datas['isAMP'] ):; ?>
        <link href="/bitrix/templates/centre/css/reset.css" rel="stylesheet" type="text/css">
        <link href="/bitrix/templates/centre/css/style2.css" rel="stylesheet" type="text/css">
    <?php endif; ?>


<meta name="yandex-verification" content="505013464432f250" />

<?php if ( !$this->_datas['isAMP'] ):; ?>
    <!--[if lt IE 9]><script src="//yandex.st/jquery/1.10.2/jquery.min.js"></script><![endif]-->
    <!--[if gte IE 9]><!-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><!--<![endif]-->
    <script type="text/javascript" src="/bitrix/templates/centre/js/jquery.maskedinput.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/bitrix/templates/centre/js/main.js" charset="UTF-8"></script>
<?php endif; ?>

<? if ($this->_datas['arg_url'] == 'zakaz' || $this->_datas['arg_url'] == 'sprosi'): ?>
    <?php if ( !$this->_datas['isAMP'] ); ?>
        <script type="text/javascript" src="/bitrix/templates/centre/js/zakaz.js" charset="UTF-8"></script>
<?endif;?>
<? if ($this->_datas['arg_url'] == 'spasibo'): ?>
    <?php if ( !$this->_datas['isAMP'] ); ?>
        <script type="text/javascript" src="/bitrix/templates/centre/js/spasibo.js" charset="UTF-8"></script>
<?endif;?>
<? if ($this->_datas['arg_url'] == 'status'): ?>
    <?php if ( !$this->_datas['isAMP'] ); ?>
        <script type="text/javascript" src="/bitrix/templates/centre/js/status.js" charset="UTF-8"></script>
<?endif;?>

    <?php if ( $this->_datas['isAMP'] ):; ?>
        <script type="application/ld+json">
          {
            "@context": "http://schema.org",
            "@type": "Article",
            "headline": "Open-source framework for publishing content",
            "datePublished": "2015-10-07T12:02:41Z",
            "image": [
              "<?php echo $amp_host . '/bitrix/templates/centre/img/logo'.(isset($marka) ? ucfirst($marka_lower).$header_1 : '').'.png';?>"
            ],
            "author": {
              "@type": "Person",
              "name": "Jordan M Adler"
            },
            "publisher": {
              "@type": "Organization",
              "name": "<?php echo ucwords( str_replace('.', ' ', $this->_datas['site_name'] ) ) . ' LTD'; ?>",
              "logo": "<?php echo $amp_host . '/bitrix/templates/centre/img/logo'.(isset($marka) ? ucfirst($marka_lower).$header_1 : '').'.png';?>"
            }
          }
        </script>
        <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
        <script async src="https://cdn.ampproject.org/v0.js"></script>
		<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
		<style amp-custom>
			@import url('https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&subset=latin-ext');
			
			html, body, div, span, applet, object, iframe,
			h1, h2, h3, h4, h5, h6, p, blockquote, pre,
			a, abbr, acronym, address, big, cite, code,
			del, dfn, em, img, ins, kbd, q, s, samp,
			small, strike, strong, sub, sup, tt, var,
			b, u, i, center,
			dl, dt, dd, ol, ul, li,
			fieldset, form, label, legend,
			table, caption, tbody, tfoot, thead, tr, th, td,
			article, aside, canvas, details, embed, 
			figure, figcaption, footer, header, hgroup, 
			menu, nav, output, ruby, section, summary,
			time, mark, audio, video {
				margin: 0;
				padding: 0;
				border: 0;
				font-size: 100%;
				font: inherit;
				vertical-align: baseline;
			}
			/* HTML5 display-role reset for older browsers */
			article, aside, details, figcaption, figure, 
			footer, header, hgroup, menu, nav, section {
				display: block;
			}
			body {
				line-height: 1;
			}
			ol, ul {
				list-style: none;
			}
			blockquote, q {
				quotes: none;
			}
			blockquote:before, blockquote:after,
			q:before, q:after {
				content: '';
				content: none;
			}
			table {
				border-collapse: collapse;
				border-spacing: 0;
			}

			/* Generated by less 2.5.1 */
			/* FONTS */
			@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&subset=latin,cyrillic);
			@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700,900);
			@import url(https://fonts.googleapis.com/css?family=Comfortaa:400,700,300&subset=latin,cyrillic);
			@import url(https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic);
			html * {
			  max-height: 1000000px;
			}
			/* COLORS */
			*::selection {
			  color: white;
			  background-color: #000;
			}
			input {
			  line-height: normal;
			}
			*,
			:after,
			:before {
			  -webkit-box-sizing: border-box;
			  -moz-box-sizing: border-box;
			  box-sizing: border-box;
			}
			input[type="text"] {
			  line-height: 36px\9;
			}
			html {
			  width: 100%;
			  font-size: 65.5%;
			}
			html body {
			  width: 100%;
			  font-size: 16px;
			  font-size: 1.5rem;
			  font-family: "PT Sans", sans-serif;
			}
			html body h1 {
			  color: #111;
			  font-size: 3.6rem;
			  font-weight: 700;
			  line-height: 16px;
			}
			html body h2,
			.h2 {
			  margin-bottom: 25px;
			  font-family: "PT Sans";
			  font-size: 2.8rem;
			  font-weight: 700;
			  line-height: 16px;
			  display: block;
			}
			html body h3 {
			  color: #0067be;
			  font-size: 1.7rem;
			  font-weight: 700;
			  line-height: 24px;
			  margin-bottom: 15px;
			}
			html body p {
			  color: #535353;
			  font-family: "PT Sans";
			  font-size: 1.5rem;
			  font-weight: 400;
			  line-height: 24px;
			}
			html body a {
			  text-decoration: none;
			}
			html body a:hover {
			  text-decoration: none;
			}
			html body ul.list {
			  padding: 10px 0 10px 0;
			}
			html body ul.list li {
			  margin-left: 20px;
			  margin-bottom: 10px;
			  list-style: circle;
			  color: #0067be;
			  line-height: 20px;
			}
			html body ul.list li span {
			  color: #535353;
			  font-size: 1.5rem;
			}
			html body table {
			  width: 100%;
			  margin: 30px 0 35px 0;
			}
			html body table tr:first-child {
			  color: #3f4244;
			}
			html body table tr:first-child td {
			  background-color: #f7f7f7;
			  font-size: 1.5rem;
			  font-weight: 700;
			  line-height: 24px;
			}
			html body table tr td:first-child {
			  width: 460px;
			}
			html body table td {
			  font-weight: 400;
			  line-height: 24px;
			  padding: 10px 0px 10px 20px;
			  background-color: #fdfdfd;
			}
			html body table td:last-child {
			  width: 145px;
			}
			html body table td:nth-child(2) {
			  width: 195px;
			}
			.header__contacts {
			  float: right;
			  margin-top: -20px;
			}
			.header__top {
			  height: 105px;
			  padding-top: 15px !important;
			  padding-bottom: 15px !important;
			}
			.header__top .logo {
			  float: left;
			}
			.header__top .img {
			  float: left;
			  display: inline-block;
			  margin-right: 15px;
			  margin-top: 14px;
			  max-height: 40px;
			}
			.header__top .img.hp {
			  margin-top: -20px;
			}
			.header__top .img.xiaomi {
			  margin-top: 0px;
			}
			.header__top .img.apple {
			  margin-top: -24px;
			}
			.header__top .img.samsung {
			  margin-top: 15px;
			}
			.header__top .img.sony {
			  margin-top: 15px;
			}
			.header__top .img.nikon {
			  margin-top: 15px;
			}
			.header__top__tagline {
			  display: inline-block;
			  color: black;
			  font-size: 12px;
			  font-weight: 400;
			  line-height: 18px;
			  margin-top: 10px;
			}

			.header__top__tagline span {
			  display: block;
			  font-family: "PT Sans";
			}

			.header__top__phone {
			  float: right;
			  font-size: 26px;
			  font-weight: 700;
			  line-height: 40px;
			}
			.header__top__phone a {
			  color: black;
			}
			.header__top__worktime {
			  margin-top: -5px;
			  float: right;
			  color: #343434;
			  font-size: 12px;
			  font-weight: 400;
			  line-height: 24px;
			}
			.header__menu {
			  height: 50px;
			  /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#e4e4e4+0,ffffff+100 */
			  background: #e4e4e4;
			  /* Old browsers */
			  #background: -moz-linear-gradient(top, #e4e4e4 0%, #ffffff 100%);
			  /* FF3.6-15 */
			  #background: -webkit-linear-gradient(top, #e4e4e4 0%, #ffffff 100%);
			  /* Chrome10-25,Safari5.1-6 */
			  #background: linear-gradient(to bottom, #e4e4e4 0%, #ffffff 100%);
			  /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			  /* IE6-9 */
			  color: white;
			  z-index: 2;
			  opacity: 1;
			}
			.header__menu ul {
			  margin: 0 auto;
			  display: flex;
			  align-content: stretch;
			}
			.header__menu.brandNav {
			  opacity: .999999;
			}
			.header__menu ul li {
			  #display: inline-block;
			  position: relative;
			  z-index: 9;
			}

			.header__menu div > ul > li {
			  flex-grow: 1;
			}

			.header__menu ul li a, .header__menu ul li span {
			  display: block;
			  padding: 0px 15px;
			  color: #666666;
			  font-size: 1.6rem;
			  font-weight: 700;
			  line-height: 50px;
			  transition-property: background-color;
			  transition-duration: .5s;
			  text-align: center;
			}
			.header__menu ul.menu-status > li a, .header__menu ul.menu-status > li span {
			  padding: 0px 15px;
			}
			.header__menu ul li span {
				cursor: default;
			}
			.header__menu ul li a {
			  cursor: pointer;
			}
			.header__menu ul li:hover > a {
			  background-color: #d4d4d4;
			  color: #222;
			}
			.header__menu ul li a.active, .header__menu ul li span.active  {
			  background-color: #8c8c8c;
			  color: #fff;
			  text-shadow: 0 0 1px rgba(0,0,0,.15);
			}

			.header__menu li > ul {
			  position: absolute;
			  top: 100%;
			  left: 0;
			  background: #eaeaea;
			  width: 325px;
			  margin-top: -2px;
			  padding: 5px 0;
			  box-shadow: 1px 1px 3px 1px rgba(0,0,0,.15);
			  visibility: hidden;
			  opacity: 0;
			  transition: all .25s;
			}

			.header__menu li > ul.right {
			  right: 0;
			  left: unset;
			}

			.header__menu li:hover > a {
			  background-color: #d4d4d4;
			  color: #222;
			}

			.header__menu li:hover > ul {
			  margin-top: 8px;
			  visibility: visible;
			  opacity: 1;
			}

			.header__menu li.subItem::before,
			.header__menu li.subItem::after {
			  position: absolute;
			  pointer-events: none;
			  border: solid transparent;
			  content: '';
			  height: 0;
			  width: 0;
			  bottom: 0;
			  left: 50%;
			  margin-bottom: 2px;
			  visibility: hidden;
			  opacity: 0;
			  transition: all .25s;
			}

			.header__menu li.subItem::after {
			  border-width: 8px;
			  margin-left: -7px;
			  margin-right: -7px;
			  border-bottom-color: #eaeaea;
			}

			.header__menu li.subItem::before {
			  border-width: 9px;
			  margin-left: -8px;
			  margin-right: -8px;
			  border-bottom-color: rgba(0,0,0,.05);}

			.header__menu li.subItem:hover::before,
			.header__menu li.subItem:hover::after {
			  margin-bottom: -9px;
			  visibility: visible;
			  opacity: 1;
			}


			.header__menu li > ul > li {
			  float:left;
			  width: calc(100% / 4);
			  text-align: center;
			}

			.header__menu li > ul > li > * {
			  font-size: .9em;
			  line-height: 38px;
			}

			.hello {
			  margin-top: 20px;
			  padding: 30px 0 0 0;
			  margin-bottom: 40px;
			}
			.hello__info {
			  float: left;
			  padding-left: 60px;
			  padding-top: 30px;
			}
			.hello__photo {
			  float: left;
			  margin-top: 30px;
			}
			.hello h1 {
			  margin-bottom: 30px;
			}
			.hello p {
			  width: 450px;
			  margin-bottom: 20px;
			}
			.experts {
			  background-color: #fbfbfb;
			}
			.experts h2,
			.experts .h2 {
			  margin-bottom: 25px;
			  padding-top: 50px;
			}
			.experts p {
			  margin-bottom: 25px;
			}
			.experts-item {
			  margin-top: 25px;
			  margin-bottom: 25px;
			}
			.experts-item p {
			  color: #535353;
			  font-size: 1.5rem;
			  font-weight: 400;
			  line-height: 20px;
			  margin-bottom: 20px;
			}
			.experts-item img {
			  width: 100%;
			  height: auto;
			}
			.help .fixed {
			  padding: 80px 0 0 15px;
			  min-height: 360px;
			  overflow: hidden;
			  position: relative;
			}
			.help img {
			  position: absolute;
			  right: 25px;
			  bottom: 0;
			}
			.help p {
			  float: left;
			  width: 525px;
			  margin-bottom: 10px;
			}
			.help .btn {
			  margin-top: 45px;
			  display: inline-block;
			}
			.fixed.content-wrapper {
			  padding-top: 50px;
			}
			.content-block {
			  width: 730px;
			  float: right;
			  padding-left: 25px;
			  padding-bottom: 30px;
			}
			.content-block__top {
			  padding-bottom: 30px;
			  overflow: hidden;
			}
			.content-block__top p.text {
			  width: 420px;
			  margin-bottom: 25px;
			}
			.content-block__top .map-top {
			  margin-bottom: 30px;
			}
			.content-block__top .info-block img {
			  float: right;
			  margin: 10px 0 10px 30px;
			}
			.content-block__table {
			  border-top: 3px solid #f6f6f6;
			  padding-top: 30px;
			  padding-bottom: 35px;
			}
			.aside-menu {
			  width: 240px;
			  float: left;
			  padding-right: 25px;
			}
			.aside-menu ul {
			  margin-bottom: 20px;
			}
			.aside-menu ul > li {
			  width: 100%;
			  background-color: #f5f5f5;
			  margin-bottom: 2px;
			}
			.aside-menu ul > li a, .aside-menu ul > li span {
			  display: inline-block;
			  padding-left: 20px;
			  background-color: #f5f5f5;
			  width: 100%;
			  height: 45px;
			  line-height: 45px;
			  font-weight: 700;
			  color: #5f6062;
			  #opacity: 0.7;
			}
			.aside-menu ul > li a:hover,
			.aside-menu ul > li a.active,
			.aside-menu ul > li span.active {
			  #opacity: 1;
			  color: #1f2024;
			  background-color: #e0e0e0;
			}
			.aside-menu__phone {
			  width: 100%;
			  height: 120px;
			}
			.aside-menu__phone a {
			  display: inline-block;
			  text-align: center;
			  color: #1f2024;
			  opacity: .7;
			  font-size: 17px;
			  font-size: 1.7rem;
			  font-weight: 700;
			  line-height: 16px;
			  margin-bottom: 24px;
			}
			.aside-menu__phone ahover {
			  opacity: 1;
			}
			.aside-menu__phone p {
			  font-size: 14px;
			  font-weight: 400;
			  line-height: 18px;
			}
			.aside-menu__panel {
			  background-color: #f5f5f5;
			  width: 100%;
			  padding: 25px 20px 20px 20px;
			  margin-bottom: 20px;
			}
			.footer {
			  margin-top: 40px;
			}

			.footer__nav ul {
			  display: flex;
			}

			.footer__nav ul li {
			  #display: inline-block;
			  position: relative;
			}

			.footer__nav > ul > li {
			  flex-grow: 1;
			}

			.footer__nav ul li a, .footer__nav ul li span {
			  display: inline-block;
			  padding: 20px 22px 20px 22px;
			  color: #666666;
			  font-size: 1.6rem;
			  font-weight: 700;
			  line-height: 16px;
			  transition-property: background-color;
			  transition-duration: .5s;
			  width: 100%;
			  text-align: center;
			}
			.footer__nav ul.menu-status > li > a, .footer__nav ul.menu-status > li > span {
			   padding: 20px 15px 20px 15px;
			}
			.footer__nav ul.menu-status > li > a {
			  cursor: pointer;
			}
			.footer__nav ul li a.active, .footer__nav ul > li span.active {
				#background-color: #ffffff;
				color: #0082db;
			}
			.footer__nav ul li span {
			  cursor: default;
			}
			.footer__nav ul li:hover > a {
			  background-color: #1f2024;
			  color: #ccc;
			}

			.footer__nav li > ul {
			  position: absolute;
			  bottom: 100%;
			  left: 0;
			  background: #1f2024;
			  width: 325px;
			  margin-bottom: -2px;
			  padding: 5px 0;
			  box-shadow: 1px 1px 3px 1px rgba(0,0,0,.15);
			  flex-wrap: wrap;
			  visibility: hidden;
			  opacity: 0;
			  transition: all .25s;
			}

			.footer__nav li > ul.right {
			  right: 0;
			  left: unset;
			}

			.footer__nav li:hover > span:not(.active) {
			  background-color: #1f2024;
			  color: #222;
			}

			.footer__nav li:hover a {
			  color: #ccc;
			}

			.footer__nav li:hover > ul {
			  margin-bottom: 10px;
			  visibility: visible;
			  opacity: 1;
			}

			.footer__nav li.subItem::before,
			.footer__nav li.subItem::after {
			  position: absolute;
			  pointer-events: none;
			  border: solid transparent;
			  content: '';
			  height: 0;
			  width: 0;
			  bottom: 100%;
			  left: 50%;
			  margin-bottom: -18px;
			  visibility: hidden;
			  opacity: 0;
			  transition: all .25s;
			}

			.footer__nav li.subItem::after {
			  border-width: 8px;
			  margin-left: -7px;
			  margin-right: -7px;
			  border-top-color: #1f2024;
			}

			.footer__nav li.subItem::before {
			  border-width: 9px;
			  margin-left: -8px;
			  margin-right: -8px;
			  border-top-color: rgba(0,0,0,.05);
			}

			.footer__nav li.subItem:hover::before,
			.footer__nav li.subItem:hover::after {
			  margin-bottom: -6px;
			  visibility: visible;
			  opacity: 1;
			}


			.footer__nav li > ul > li {
			  float:left;
			  width: calc(100% / 4);
			  text-align: center;
			}

			.footer__nav li > ul > li > * {
			  font-size: .9em;
			  line-height: 30px;
			  padding: 5px;
			  color: #d2d2d3;
			  width: 100%;
			}

			.footer__nav li > ul > li > a:not(.active):hover {
			  color: #fff;
			  background: #1d1d1d;
			}


			.footer__links {
			  padding-top: 45px;
			  height: 240px;
			}
			.footer__links p {
			  line-height: 30px;
			}
			.footer__links ul > li {
			  float: left;
			  width: 150px;
			}
			.footer__links ul > li span {
				cursor: default;
			}
			.footer__links ul > li a {
			  color: white;
			  font-size: 1.5rem;
			  font-weight: 400;
			  line-height: 30px;
			  opacity: 0.8;
			}
			.footer__links ul > li a:hover {
			  opacity: 1;
			}
			.footer__line {
			  height: 1px;
			  background-color: #39393a;
			}
			.footer__bottom {
			  height: 70px;
			  padding: 15px 0 25px 0;
			}
			.footer__bottom__copy {
			  float: left;
			}
			.footer__bottom__copy p {
			  text-transform: uppercase;
			  font-size: 1.0rem;
			  font-weight: 400;
			  line-height: 18px;
			  color: #c8c8c8;
			}
			.footer__bottom__social {
			  float: right;
			  margin-right: 10px;
			}
			/*.footer__bottom__social ul > li {
				display: inline-block;
			}

			.footer__bottom__social ul > li a {
				display: inline-block;
				opacity: 0.8;
				width: 35px;
				height: 35px;
				background-color: red;
				background: url(/bitrix/templates/centre/img/soc.png) no-repeat;
			}

			.footer__bottom__social ul > li a:hover {
				opacity: 1;
			}

			.footer__bottom__social--fb {
				background-position: -39px 0 !important;
			}

			.footer__bottom__social--tw {
				background-position: -76px 0 !important;
			}

			.footer__bottom__social--yt {
				background-position: -115px 0 !important;
			}

			.footer__bottom__social--inst {
				background-position: -152px 0 !important;
			}*/
			/*.modalDialog {
			  position: absolute;
			  top: 0;
			  right: 0;
			  bottom: 0;
			  left: 0;
			  background: rgba(0, 0, 0, 0.8);
			  z-index: 99999;
			  -webkit-transition: opacity 400ms ease-in;
			  -moz-transition: opacity 400ms ease-in;
			  transition: opacity 400ms ease-in;
			  display: none;
			  pointer-events: none;
			}

			.modalDialog:target {
			  display: block;
			  pointer-events: auto;
			}

			.modalDialog > div {
			  width: 450px;
			  position: relative;
			  margin: 10% auto;
			  padding: 30px 30px 40px 30px;
			  background: #f5f5f5;
			}

			.modalDialog h2 {
			  font-size: 25px;
			  font-weight: 700;
			  line-height: 24px;
			}*/
			.modalDialog input,
			.modalDialog select {
			  height: 40px;
			  font-size: 15px;
			  font-weight: 400;
			  line-height: 24px;
			}
			.modalDialog span {
			  font-size: 30px;
			  position: absolute;
			  top: 140px;
			  right: 40px;
			  color: red;
			}
			.modalDialog textarea {
			  height: 75px;
			  font-size: 15px;
			  font-weight: 400;
			  line-height: 24px;
			  padding-top: 5px;
			}
			.modalDialog .btn {
			  //float: right;
			  margin-bottom: 0;
			  padding: 10px 20px;
			  width: auto;
			  margin-top: 20px;
			}
			.modalDialog p {
			  color: #A59F9F;
			  font-size: 1.4rem;
			}
			.close {
			   position: absolute;
			   right: 6px;
			   top: 6px;
			   width: 26px;
			   height: 26px;
			   font-size: 24px;
			   line-height: 26px;
			   text-align: center;
			   color: #535353 !important;
			   text-decoration: none !important;
			}
			.close:hover {
				text-decoration: none !important;
			}
			.icons-block {
			  width: 100%;
			  background-color: #fbfbfb;
			  display: flex;
			  flex-direction: row;
			  justify-content: space-between;
			  padding: 30px 25px;
			}
			.icons-block .icon {
			  position: relative;
			  width: 25%;
			  margin-left: 70px;
			}
			.icons-block .icon:before {
			  content: "";
			  position: absolute;
			  left: -40px;
			  top: 2px;
			}
			.icons-block .icon a {
			  text-decoration: underline;
			  color: #535353;
			  font-size: 14px;
			  font-weight: 400;
			  line-height: 6px;
			}
			.icons-block .icon a:hover {
			  text-decoration: none;
			}
			.icons-block .icon:nth-child(1)::before {
			  content: url("/bitrix/templates/centre/img/diagnstic.png");
			}
			.icons-block .icon:nth-child(2)::before {
			  content: url("/bitrix/templates/centre/img/diagnstic.png");
			}
			.icons-block .icon:nth-child(3)::before {
			  content: url("/bitrix/templates/centre/img/diagnstic.png");
			}
			.icons-block .icon:nth-child(4)::before {
			  content: url("/bitrix/templates/centre/img/diagnstic.png");
			}
			.info-block {
			  padding: 35px 0px 10px;
			}
			.info-block img {
			  float: left;
			  margin: 0px 30px 20px 0px;
			}
			.info-block h1 {
			  margin-bottom: 20px;
			  width: 100%;
			  display: block;
			}
			.info-block p {
			  color: #535353;
			  font-family: 'PT Sans';
			  font-size: 1.5rem;
			  font-weight: 400;
			  line-height: 24px;
			  margin-bottom: 20px;
			}
			.price {
			  padding-left: 35px;
			  color: #1f2024;
			  font-weight: 700;
			  line-height: 24px;
			  font-size: 20px;
			}
			.price span {
			  font-size: 30px;
			}
			.wrapper {
			  position: relative;
			  min-width: 1000px;
			  margin: 0 auto;
			  min-height: 100%;
			}
			.fixed {
			  width: 1000px;
			  margin-left: auto;
			  margin-right: auto;
			  padding: 0px 15px;
			  #position: relative;
			  #z-index: 1;
			}
			.btn {
			  position: relative;
			  display: inline-block;
			  border-radius: 3px;
			}
			.btn--fill {
			  padding: 15px 15px;
			  width: 200;
			  background-color: #7b0;
			  background-image: linear-gradient(to top, #0067be 0%, #0089e2 100%);
			  text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.3);
			  color: white;
			  font-size: 1.8rem;
			  font-weight: 700;
			  line-height: 24px;
			  text-align: center;
			  float: right;
			}
			.btn--fill--mini {
			  width: 155px;
			  padding: 10px 10px;
			}
			.btn--fill:hover {
			  background-image: linear-gradient(to top, #0089e2 0%, #0067be 100%);
			}
			.btn--fill + img {
			  position: relative;
			  margin-left: 12px;
			  opacity: 0.7;
			  bottom: 0;
			  display: none;
			}
			.btn--empty {
			  padding: 6px 25px 9px 10px;
			  border: 1px solid #0067be;
			  color: #0067be;
			  font-size: 1.6rem;
			  font-weight: 700;
			  line-height: 20px;
			  width: 125px;
			  text-decoration: none;
			}
			.btn--empty:after {
			  width: 11px;
			  height: 11px;
			  content: ' ';
			  position: absolute;
			  background: url(/bitrix/templates/centre/img/btn-arrpw.png) no-repeat;
			  right: 7px;
			  top: 14px;
			}
			.btn--empty:hover {
			  background-image: linear-gradient(to top, #0067be 0%, #0089e2 100%);
			  color: white;
			}
			.btn--empty:hover:after {
			  background: url(/bitrix/templates/centre/img/btn-arrow--hover.png) no-repeat;
			}
			.aside-menu .btn--empty {
			  width: auto;
			  font-size: 1.5rem;
			  font-weight: 500;
			}
			.btn--download {
			  padding: 5px 20px 5px 35px;
			  border: 1px solid #0067be;
			  color: #0067be !important;
			  font-size: 1.5rem;
			  font-weight: 700;
			  line-height: 24px;
			}
			.btn--download:before {
			  width: 11px;
			  height: 11px;
			  content: ' ';
			  position: absolute;
			  background: url(/bitrix/templates/centre/img/download.png) no-repeat;
			  left: 13px;
			  top: 13px;
			}
			.btn--download:hover {
			  background-image: linear-gradient(to top, #0067be 0%, #0089e2 100%);
			  color: white !important;
			}
			.btn--download:hover:before {
			  background: url(/bitrix/templates/centre/img/download--hover.png) no-repeat;
			}
			.crumbs a {
			  display: inline-block;
			  color: #343434;
			}
			.lgray {
			  background-color: #fbfbfb;
			}
			.gray {
			  /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+0,e4e4e4+100 */
			  background: #ffffff;
			  /* Old browsers */
			  background: -moz-linear-gradient(top, #ffffff 0%, #e4e4e4 100%);
			  /* FF3.6-15 */
			  background: -webkit-linear-gradient(top, #ffffff 0%, #e4e4e4 100%);
			  /* Chrome10-25,Safari5.1-6 */
			  background: linear-gradient(to bottom, #ffffff 0%, #e4e4e4 100%);
			  /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#e4e4e4', GradientType=0);
			  /* IE6-9 */
			}
			.dgray {
			  background-color: #1f2024;
			  color: #ccc;
			}
			.half {
			  width: 49.5%;
			  height: auto;
			  float: left;
			}
			.halfMin {
			  float: left;
			  line-height: 30px;
			}
			.halfMin:nth-child(1) {
			  width: 410px;
			}
			.halfMin:nth-child(2) {
			  width: 390px;
			}
			.halfMin:nth-child(3) {
			  width: 170px;
			}
			.halfMin a {
			  color: #fff;
			}
			.halfMin p {
			  color: #fff;
			}
			.halfMin p.title {
			  color: #83838f;
			  font-size: 1.7rem;
			  font-weight: 400;
			  line-height: 24px;
			  padding-bottom: 15px;
			}
			.footlink {
			  border-radius: 3px;
			  border: 1px solid #ffffff;
			  padding: 2px 10px;
			  margin-top: 20px;
			  display: block;
			  width: 145px;
			}
			.footphone {
			  font-weight: bold;
			}
			.quarter {
			  display: inline-block;
			  width: 25%;
			  height: auto;
			}
			.container {
			  display: inline-block;
			  width: 100%;
			  height: 200px;
			}
			.clear {
			  clear: both;
			}
			.right {
			  float: right;
			}
			.left {
			  float: left;
			}
			.divider {
			  height: 1px;
			  width: 100%;
			  background: #dbdbdb;
			}
			.divider--three {
			  height: 3px;
			  background-color: #f6f6f6;
			}
			.ask-sony {
			  padding-top: 20px;
			}
			.ask-sony__header {
			  margin-bottom: 20px;
			  color: #343434;
			  font-size: 17px;
			  font-weight: 700;
			  line-height: 16px;
			}
			.ask-sony__text {
			  margin-bottom: 25px;
			  color: #535353;
			  font-size: 14px;
			  font-weight: 400;
			  line-height: 18px;
			}
			.ask-sony form textarea {
			  height: 55px;
			  padding-top: 3px;
			}
			.ask-sony form.btn--fill {
			  cursor: pointer;
			  padding: 5px 20px;
			  text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.3);
			  color: white;
			  font-family: "PT Sans";
			  font-size: 16px;
			  font-weight: 700;
			  line-height: 24px;
			  height: auto;
			}
			form input,
			form textarea,
			form select {
			  resize: none;
			  padding: 0 5px 0 10px;
			  width: 100%;
			  height: 29px;
			  margin-bottom: 15px;
			  background-color: #ebebeb;
			  border: 1px solid #dbdbdb;
			  border-radius: 3px;
			  font-family: "PT Sans";
			  color: black;
			}
			form input.btn--fill,
			form textarea.btn--fill,
			form select.btn--fill {
			  cursor: pointer;
			  padding: 15px 15px !important;
			  text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.3);
			  color: white;
			  font-family: "PT Sans";
			  font-size: 1.8rem;
			  font-weight: 700;
			  line-height: 24px;
			  height: auto;
			  width: 100%;
			  border: none;
			}
			.h4 {
			  color: #3f4244;
			  font-family: "PT Sans";
			  font-size: 15px;
			  line-height: 24px;
			  font-weight: 700;
			}
			.text {
			  color: #3f4244;
			  font-family: "PT Sans";
			  font-size: 15px;
			  line-height: 24px;
			  font-weight: 400;
			}
			.text--full-width {
			  width: 100%;
			}
			.text--three-quater {
			  width: 75%;
			}
			.content-block__center h3 {
			  margin-top: 30px;
			  color: #3f4244;
			  font-family: "PT Sans";
			  font-size: 30px;
			  font-weight: 700;
			  line-height: 24px;
			}
			.table-price:after {
			  display: block;
			  content: '';
			  margin-top: 45px;
			  height: 3px;
			  background-color: #f6f6f6;
			}
			.map-detail {
			  margin-right: 40px;
			  float: left;
			}
			.contacts ul > li {
			  display: inline;
			  margin-bottom: 35px;
			  width: 33%;
			  float: left;
			}
			.contacts ul > li:nth-child(2) {
			  padding-left: 25px;
			}
			.contacts a {
			  color: #3f4244;
			  font-family: "PT Sans";
			  font-size: 15px;
			  line-height: 24px;
			}
			section {
			  clear: both;
			  overflow: hidden;
			}
			/*# sourceMappingURL=style.css.map */
			.prefMain {
			  background: #fcfcfc;
			  /* Old browsers */
			  background: -moz-linear-gradient(top, #fcfcfc 1%, #ffffff 49%, #ffffff 100%);
			  /* FF3.6-15 */
			  background: -webkit-linear-gradient(top, #fcfcfc 1%, #ffffff 49%, #ffffff 100%);
			  /* Chrome10-25,Safari5.1-6 */
			  background: linear-gradient(to bottom, #fcfcfc 1%, #ffffff 49%, #ffffff 100%);
			  /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fcfcfc', endColorstr='#ffffff', GradientType=0);
			  /* IE6-9 */
			}
			.content-block--contacts .prefMain {
			  background: none;
			}
			.prefMain.no-height {
			  height: auto;
			}
			.block-new {
			  width: 100%;
			  margin-top: 50px;
			  overflow: hidden;
			  padding: 10px 0;
			  margin-bottom: 20px;
			}
			.block-new-r {
			  width: 100%;
			  overflow: hidden;
			  padding: 10px 0;
			  margin-bottom: 20px;
			}
			.content-block--contacts .block-new {
			  margin-top: 0px;
			}
			.block-new .pref {
			  float: left;
			  width: 290px;
			  margin: 15px 45px 30px 0;
			  border-radius: 3px;
			  border: 1px #222 dashed;
			  box-sizing: border-box;
			  padding: 20px 15px;
			  position: relative;
			}
			.block-new-r .pref {
			  float: left;
			  width: 290px;
			  height: 130px;
			  margin: 15px 45px 30px 0;
			  border-radius: 3px;
			  border: 1px #222 dashed;
			  box-sizing: border-box;
			  padding: 20px 15px;
			  position: relative;
			}
			.content-block--contacts .block-new .pref {
			  margin-bottom: 5px;
			  width: 220px;
			  margin-right: 20px;
			  border: none;
			  padding: 0 15px;
			}
			.block-new .pref:hover,
			.block-menu-new .pref:hover {
			  border: 1px #0067be dashed;
			}
			.content-block--contacts .block-new .pref:hover {
			  border: none;
			}
			.block-menu-new .pref {
			  border-radius: 3px;
			  border: 1px #222 dashed;
			  box-sizing: border-box;
			  padding: 10px 20px;
			  margin-bottom: 20px;
			  width: 100%;
			}
			.block-new .pref a,
			.block-new .pref .h4,
			.block-menu-new .pref a,
			.experts-item a,
			.experts-item span {
			  color: #0067be;
			  font-size: 1.7rem;
			  font-weight: 700;
			  line-height: 24px;
			  margin-bottom: 15px;
			  display: block;
			  text-decoration: none;
			}
			.block-menu-new .pref a {
			  margin-bottom: 0;
			  font-size: 1.4rem;
			  color: #1f2024;
			}
			.content-block--contacts .block-new .pref a {
			  color: #535353;
			  font-weight: 700;
			}
			.block-new .pref .h4 {
			  color: #1f2024;
			}
			.content-block--contacts .block-new .pref .h4 {
			  font-weight: 400;
			}
			.content-block--contacts .block-new .pref p {
			  font-weight: 700;
			  font-size: 1.7rem;
			}
			.block-new .pref a:hover,
			.block-menu-new .pref a:hover {
			  text-decoration: underline;
			  opacity: 0.9;
			}
			.content-block--contacts .block-new .pref a:hover {
			  text-decoration: none;
			  opacity: 1;
			}
			.experts-item a:hover,
			.experts-item-link:hover {
			  text-decoration: none;
			  opacity: 0.9;
			}
			.block-new .last,
			.block-new-r .last {
			  margin-right: 0% !important;
			}
			.block-new .pref p,
			.block-menu-new .pref p {
			  width: auto;
			}
			.block-menu-new .pref p {
			  font-size: 1.3rem;
			}
			#mymap {
			  margin-bottom: 35px;
			}
			.info-block.remont-block img {
			  float: left;
			  margin: 10px 30px 10px 0;
			}
			.info-block.remont-block .block-wrp {
			  float: left;
			  width: 350px;
			}
			.info-block.remont-block .block-wrp p {
			  text-align: justify;
			}
			.remont-block .price {
			  padding-right: 35px;
			  padding-left: 0;
			  font-size: 30px;
			  margin-bottom: 20px;
			  display: block;
			}
			strong {
			  font-weight: bold;
			}
			.modalDialog .error div {
			  text-align: left;
			  font-size: 16px;
			  font-weight: 400;
			  line-height: 24px;
			  margin: 2em 0;
			}
			/* ac */
			table.priceTable tr td:nth-child(1) {
			  width: 233px;
			}
			table.priceTable td:nth-child(2) {
			  width: 164px;
			}
			table.priceTable td:nth-child(3) {
			  width: 95px;
			}
			table.priceTable td:nth-child(4) {
			  width: 213px;
			}
			table.priceTable tr td {
			  vertical-align: middle;
			  height: 44px;
			}
			.priceTable td {
			  line-height: 20px !important;
			}
			.priceTable a {
			  color: #0067be;
			  text-decoration: none;
			}
			.priceTable a.btn {
			  font-size: 1.5rem;
			  width: auto;
			  font-weight: 400;
			  text-decoration: none;
			  color: #0067be;
			}
			.priceTable a:hover {
			  text-decoration: underline;
			}
			.priceTable a.btn:hover {
			  color: white;
			}
			html body table tr.nth {
			  color: #000000;
			}
			html body table tr.nth td {
			  background-color: #fdfdfd;
			  font-size: 1.5rem;
			  font-weight: 400;
			  line-height: 24px;
			}
			html body .tab-block table {
			  margin-top: 0;
			  margin-bottom: 0;
			  border: 1px solid #dbdbdb;
			}
			.tab-block input {
			  display: none;
			}
			.tab-block section {
			  display: none;
			}
			.tab-block label {
			  display: inline-block;
			  padding: 0 20px;
			  line-height: 45px;
			  font-weight: 400;
			  color: #000;
			  cursor: pointer;
			  font-size: 1.6rem;
			  border: 1px solid transparent;
			  border-bottom: none;
			  white-space: nowrap;
			  max-width: 49%;
			  text-overflow: ellipsis;
			  overflow: hidden;
			  box-sizing: border-box;
			}
			.tab-block input:checked + label,
			.tab-block label:hover {
			  background-color: #f7f7f7;
			  border: 1px solid #dbdbdb;
			  border-bottom: none;
			}
			#tab1:checked ~ #content1,
			#tab2:checked ~ #content2,
			#tab3:checked ~ #content3,
			#tab4:checked ~ #content4 {
			  display: block;
			}
			.btn--empty:after {
			  top: 13px;
			}
			section.frame {
			  margin-bottom: 35px;
			  margin-top: -3px;
			}
			section.def {
			  border: none;
			}
			section.frame ul.list {
			  padding: 0px 20px 0px 20px;
			  overflow: hidden;
			}
			section.frame ul.list li {
			  margin-top: 10px;
			}
			section.frame ul.list a {
			  color: #0067be;
			  text-decoration: none;
			}
			section.frame ul.list a:hover {
			  text-decoration: underline;
			}
			section.def ul.list {
			  padding-left: 0;
			}
			section.def ul.list li {
			  list-style: none;
			  font-size: 1.4rem;
			  margin-left: 0px;
			}
			.order-btn {
			  position: relative;
			  padding-right: 25px;
			}
			.order-btn:after {
			  width: 11px;
			  height: 11px;
			  content: ' ';
			  position: absolute;
			  background: url(/bitrix/templates/centre/img/btn-arrpw.png) no-repeat;
			  right: 7px;
			  top: 7px;
			}
			.amount-item {
			  height: 20px;
			  width: 8px;
			  border: 1px solid #dbdbdb;
			  display: inline-block;
			}
			.amount-item.active {
			  background: #585858;
			  border: 1px solid transparent;
			  margin-right: 2px;
			}
			.info-block h1 {
			  line-height: 1;
			  width: 80%;
			}
			.info-block h1 span {
			  white-space: nowrap;
			}
			[itemprop=description] {
			  margin-top: 30px;
			}
			section.frame p {
			  margin: 40px 0px 20px 0px;
			}
			span.h2 {
			  line-height: 1;
			}
			section.frame ul.list.three {
			  padding: 0;
			}
			section.frame ul.list.three li {
			  list-style: none;
			  float: left;
			  font-size: 1.4rem;
			  margin-left: 0;
			  width: 31%;
			  margin-right: 10px;

			  text-overflow: ellipsis;
			  overflow-x: hidden;
			  white-space: nowrap;
			}
			section.frame ul.list.three li:nth-child(3n) {
			  margin-right: 0px;
			}
			.thankyou h1 {
			  line-height: 1;
			}
			.thankyou {
			  text-align: center;
			}
			.thankyou-text {
			  margin: 50px 0;
			}
			.thankyou-text p {
			  font-size: 1.5rem;
			  line-height: 1.5;
			}
			.thankyou a {
			  font-size: 1.5rem;
			  text-decoration: underline;
			  color: #0067be;
			}
			.thankyou .auto {
			  margin-top: 20px;
			}
			.thankyou .promo {
			  font-size: 3.6rem;
			  margin: 15px 0 30px 0;
			}
			.thankyou .promo-info {
			  display: none;
			}
			.thankyou .promo span,
			.promo-order .promo span {
			  color: #0067be;
			  display: inline-block;
			  width: 40px;
			  height: 40px;
			  border: 2px solid #0067be;
			  font-weight: 700;
			}
			.promo-order {
			  overflow: hidden;
			  margin: 40px 0 30px 0;
			}
			.promo-order .promo-left p {
			  margin-bottom: 0;
			  margin-top: 9px;
			  line-height: 18px;
			}
			.promo-order .promo-info.promo-left {
			  float: left;
			  width: 65%;
			  margin-bottom: 39px;
			}
			.promo-order .promo-info.promo-right {
			  float: right;
			  width: 35%;
			}
			.promo-order .promo-tooltip {
			  float: right;
			  text-align: center;
			  clear: both;
			  width: 160px;
			  display: none;
			}
			.promo-order .promo-tooltip p {
			  font-size: 1.2rem;
			  margin-bottom: 0;
			}
			.promo-order .promo {
			  font-size: 3.6rem;
			  float: right;
			  text-align: center;
			  margin: 7px 0 0 0;
			}
			.promo-order .btn {
			  background-image: linear-gradient(to top, #f44336 0%, #ff9800 100%);
			}
			.promo-kod#text-2 {
			  display: none;
			}
			.ask-section {
			  margin-bottom: 35px;
			}
			.ask-section .btn--fill {
			  float: left;
			  margin-right: 24px;
			  background-image: linear-gradient(to top, #f44336 0%, #ff9800 100%);
			}
			.ask-section p {
			  font-weight: bold;
			}
			.ask-section p:first-of-type {
			  margin-bottom: 0;
			}
			.mobilemenu,
			.mobilephone,
			.mobileworktime {
			  display: none;
			}
			.popup {
				display: none;
				position: absolute;
				background-color: #f5f5f5;
				color: #535353;
				border: 1px solid #dbdbdb;
				padding: 25px;
				z-index: 10;

			}
			#footer-popup {
				bottom: 0;
				width: 612px;
				left: 179px;
				padding: 35px 50px 20px 50px;
			}
			.current-region:after {
				content: "";
				width: 0;
				height: 0;
				position: absolute;
				margin-top: 12px;
				margin-left: 6px;
				border-width: 6px 6px 0 6px;
				border-style: solid;
				border-color: #ffffff transparent;
			}
			.current-region.open:after {
				border-width: 0 6px 6px 6px;
			}

			#footer-popup li {
				width: 230px;
				float: left;
				margin-bottom: 25px;
				box-sizing: border-box;
				line-height: 10px;
			}
			#footer-popup li:nth-child(odd) {
				margin-right: 50px;
			}

			#footer-popup a {
				color: #0067be;
			}
			#footer-popup a:hover {
				text-decoration: underline;
			}
			#popup-wrapper {
				position: relative;
			}

			@media screen and (max-width: 840px) {
			  .wrapper {
				min-width: 320px;
			  }
			  .fixed {
				width: auto;
			  }
			  .content-block {
				padding-left: 9px;
				width: 74%;
			  }
			  .aside-menu {
				width: 25.9%;
				padding-right: 9px;
			  }
			  .aside-menu__panel {
				padding: 25px 14px 20px;
			  }
			  html body ul.list li span {
				font-size: 14px;
			  }
			  html body ul.list li {
				margin-left: 16px;
			  }
			  .content-block__top .info-block img {
				width: 50%;
				margin: 10px 0 10px 10px;
			  }
			  .info-block img {
				max-width: 100%;
				height: auto;
			  }
			  .halfMin:nth-child(1) {
				width: 31.8%;
				padding-right: 4%;
			  }
			  .halfMin:nth-child(2) {
				width: 34%;
				padding-left: 4%;
			  }
			  .halfMin:nth-child(3) {
				width: 31.8%;
				padding-left: 4%;
			  }
			  .header__menu ul > li a {
				padding: 0 13px;
				font-size: 16px;
			  }
			  .footer__nav ul > li a {
				padding: 20px 13px;
				font-size: 16px;
			  }
			  .header__menu ul {
				text-align: center;
			  }
			  .fixed.content-wrapper {
				padding-top: 20px;
			  }
			  .hello__photo {
				width: 49.9%;
			  }
			  .hello__photo img {
				max-width: 100%;
				height: auto;
			  }
			  .hello p {
				width: auto;
			  }
			  .hello__info {
				width: 50%;
			  }
			  .help p {
				width: 55%;
				float: none;
			  }
			  .help span {
				width: 55%;
			  }
			  .block-new .pref {
				margin: 15px 18px 30px 0;
				width: 31.6%;
			  }
			  .content-block--contacts .block-new .pref {
				width: 30.5%;
			  }
			  .info-block.remont-block .block-wrp {
				width: auto;
			  }
			  .order-btn::after {
				background: none;
			  }
			}
			@media screen and (max-width: 809px) {
			  .header__menu ul > li a {
				padding: 0 10px;
			  }
			  .footer__nav ul > li a {
				padding: 20px 10px;
			  }
			}
			@media screen and (max-width: 700px) {
			  .header__menu ul > li a {
				padding: 0 10px;
			  }
			  .footer__nav ul > li a {
				padding: 20px 10px;
			  }
			  .header__top__phone,
			  .header__top__worktime {
				display: none;
			  }
			  .mobilemenu,
			  .mobilephone,
			  .mobileworktime {
				display: inline-block;
			  }
			  .mobilemenu {
				width: 40px;
				height: 40px;
				float: right;
			  }
			  .mobilemenu .imgmenu {
				margin-top: 0;
			  }
			  .header__menu ul {
				display: none;
			  }
			  .mobilephone {
				#margin-top: 10px;
				line-height: 50px;
				float: left;
			  }
			  .mobilephone a {
				color: #000;
				font-size: 17px;
			  }
			  .mobileworktime {
				color: #000;
				float: left;
				font-size: 12px;
				margin-left: 20px;
				#margin-top: 13px;
				overflow: hidden;
				#margin-bottom: 22px;
				line-height: 50px;
				text-indent: -90px;
			  }
			  .header__top .img {
				margin-top: 6px;
			  }
			  .header__top__tagline {
				margin-top: 0;
			  }
			  .header__menu {
				text-align: center;
				z-index: 5;
			  }
			  .header__menu ul {
				background: #fff none repeat scroll 0 0;
				clear: both;
				padding-bottom: 10px;
			  }
			  .header__menu ul > li a {
				line-height: 35px;
			  }
			  .fixed {
				padding: 0 8px;
			  }
			  .header__top .img {
				margin-right: 10px;
			  }
			  .header__top {
				height: auto;
				padding-bottom: 15px !important;
				padding-top: 15px !important;
			  }
			  .content-block {
				width: 100%;
				float: none;
				padding: 0;
			  }
			  .aside-menu {
				width: 100%;
				float: none;
				padding: 0;
				margin-top: 40px;
			  }
			  .info-block h1 {
				width: 100%;
			  }
			  .content-block__top .info-block img {
				float: none;
				height: auto;
				margin-left: 0;
				max-width: 100%;
				width: 100%;
			  }
			  .btn--fill {
				display: block;
				float: none;
				margin: 0 auto;
				max-width: 220px;
				clear: both;
				position: relative;
			  }
			  .info-block.remont-block .block-wrp {
				width: 100%;
			  }
			  .remont-block .price {
				margin-left: 15px;
			  }
			  .priceTable tr td:nth-child(2),
			  .priceTable tr td:nth-child(4) {
				display: none;
			  }
			  .priceTable tr td:nth-child(3) {
				padding-left: 0;
				text-align: center;
			  }
			  .tab-block label {
				line-height: 22px;
				white-space: normal;
				padding: 15px 20px;
				font-size: 14px;
				line-height: 20px;
			  }
			  .priceTable td {
				font-size: 14px;
			  }
			  footer {
				display: none;
			  }
			  [itemprop="description"] {
				margin-top: 0;
			  }
			  .info-block {
				padding-top: 10px;
			  }
			  .crumbs {
				display: none;
			  }
			  .fixed.content-wrapper {
				padding-top: 0;
			  }
			  .hello__photo {
				float: none;
				width: 100%;
			  }
			  .hello h1 {
				line-height: 1.1;
				margin-top: 20px;
			  }
			  .hello {
				margin: 0;
				padding: 0;
			  }
			  .hello__info {
				width: 100%;
				float: none;
				padding-left: 0;
			  }
			  .hello__info p {
				width: auto;
			  }
			  .half {
				width: 100%;
				float: none;
			  }
			  .experts-item {
				height: auto;
			  }
			  .experts-item img {
				width: auto;
				display: block;
				margin: 0 auto;
			  }
			  .help img {
				display: none;
			  }
			  .help p,
			  .help span {
				width: 100%;
			  }
			  .help .fixed {
				padding: 10px 8px 0;
			  }
			  .block-new .pref {
				width: auto;
				margin: 10px 8px !important;
			  }
			  span.h2 {
				font-size: 20px;
			  }
			  .info-block h1 {
				font-size: 26px;
			  }
			  .content-block--contacts .block-new .pref {
				width: 100%;
				margin: 0;
				padding: 0;
			  }
			  .content-block--contacts .block-new .pref .h4 {
				padding-right: 10px;
			  }
			  .content-block--contacts .block-new .pref p,
			  .content-block--contacts .block-new .pref .h4,
			  .content-block--contacts .block-new .pref a {
				width: 49%;
				display: inline-block;
				font-size: 16px;
				vertical-align: middle;
			  }
			  .promo-order .promo-info.promo-left {
				width: 100%;
			  }
			  .promo-order .promo-info.promo-right {
				width: 100%;
				margin-bottom: 39px;
			  }
			  .promo-order .promo {
				margin: 0 auto;
				float: none;
			  }
			  .promo-order .promo-tooltip {
				float: none;
				margin: 0 auto;
			  }
			  .info-block {
				padding-top: 0px;
			  }
			  .content-block__top {
				padding-bottom: 0px;
			  }
			  .btn--fill {
				margin: 20px auto;
			  }
			  .divider--three {
				height: 10px;
				background-color: #fff;
			  }
			}

			.footer__links .halfMin:nth-child(1) {
				padding-right: 20px;
			}

			a.politica {
				float: right;
				display: block;
				color: white;
				font-size: 1rem;
				font-weight: 400;
				line-height: 1.6;
				opacity: 0.8;
				text-transform: uppercase;
			}

			a.politica:hover {
				opacity: 1;
			}

			#req-download {
				color: #0067be;
				text-decoration: none;
			}

			#requisites {
				color: #0067be;
				text-decoration: none;
				margin: 0px 0 20px 15px;
				display: block;
			}

			#requisites:hover, #req-download:hover {
				text-decoration: underline;
			}

			.status-block {
				display: none;
				margin-top: 35px;
			}

			.status-none, .status-man, .status-more-text {
				display: none;
			}

			.status-man {
				border-top: 0 !important;
			}

			.status-more {
				text-align: right;
			}

			.status-more, .status-more-text {
				margin-top: 20px;
			}

			.status-more a {
				color: #0067be;
				text-decoration: none;
			}

			.status-more a:hover {
				text-decoration: underline;
			}

			.listUl {
			  list-style: disc;
			  margin-bottom: 15px;
			  margin-left: 1.25em;
			}

			.listUl li + li {
			  margin-top: 7px;
			}

			.info-block .listUl li {
			  color: #535353;
			  line-height: 1.2;
			}

			.form-zakaz input,
			.form-zakaz select {
			  width: 48.5%;
			  margin-right: 2%;
			}

			.form-zakaz input:nth-child(2n),
			.form-zakaz select:nth-child(2n) {
			  margin-right: 0;
			}

			.brandNav {
			  background: #1f2024;
			}

			.header__menu.brandNav ul > li > a,
			.header__menu.brandNav ul > li > span,
			.header__menu.brandNav ul.menu-status > li > a,
			.header__menu.brandNav ul.menu-status > li > span {
			  font-size: 13px;
			  padding: 0 11px;
			  color: #ccc;
			  white-space: nowrap;
			}

			.header__menu.brandNav ul > li:not(.active) > a:hover {
			  color: #fff;
			  background: inherit;
			}

			.header__menu.brandNav ul > li.active > a,
			.header__menu.brandNav ul > li:hover > a {
			  background: #000;
			}

			.header__menu.brandNav ul > li:hover > a {
			  color: #fff;
			}

			.header__menu.brandNav li > ul {
			  background: #1f2024;
			  width: auto;
			  font-size: 1em;
			  z-index: 9;
			}

			.header__menu.brandNav li > ul > li {
			  float: none;
			  width: 100%;
			}

			.header__menu.brandNav li.subItem::after {
			  border-bottom-color: #1f2024;
			}

			.header__menu.brandNav .fixed {
			  position: inherit;
			}

			.header__menu.brandNav ul li a.active,
			.header__menu.brandNav ul li span.active {
			  background: #000;
			  color: #0082db;
			}

			.header__menu li > ul {
			  flex-wrap: wrap;
			}

			@media screen and (max-width: 870px) {
			  .header__menu.brandNav {
				display: none;
			  }
			}

			.mainBrand {
			  width: calc(100% / 3);
			  float: left;
			  text-align: center;
			  color: inherit;
			  padding: 15px 25px;
			  box-sizing: border-box;
			  border: 1px solid transparent;
			}

			.mainBrand > img {
			  max-width: 80%;
			  margin-bottom: 15px;
			  display: block;
			  margin: 0 auto 20px auto;
			}

			.mainBrand > span {
			  font-size: 20px;
			  #display: block;
			  color: #0082db;
			}

			.mainBrand:hover > span {
			  border-bottom: 1px solid;
			  #text-decoration: underline;
			}

			.mainBrand:hover {
			  border: 1px solid #ccc;
			}

			@media screen and (max-width: 480px) {
			  .mainBrand {
				width: 100%;
			  }

			  .form-zakaz input, .form-zakaz select {
				width: 100%;
				margin-right: 0;
			  }
			}

			@media screen and (max-width: 700px) {
			  .header__menu ul li a, .header__menu ul li span {
				line-height: 40px;
			  }

			  .header__menu li > ul {
				display: none !important;
				position: relative;
				top: unset;
				left: unset;
				background: #efefef;
				width: 100%;
				margin-top: 0;
				box-shadow: unset;
			  }

			  .header__menu li > ul > li {
				float: none;
			  }

			  .header__menu li.open > ul {
				display: flex !important;
				margin-top: 0;
				visibility: visible;
				opacity: 1;
			  }

			  .header__menu li.subItem::before, .header__menu li.subItem::after {
				display: none;
			  }

			  .header__menu ul {
				position: absolute;
				top: 50px;
				left: 0;
				right: 0;
				padding-bottom: 0;
				box-shadow: 0 1px 1px 2px rgba(0,0,0,.1);
			  }

			  .header__menu ul li {
				position: relative;
			  }

			  .header__menu ul li a, .header__menu ul li span {
				display: flex;
				justify-content: center;
			  }

			  .header__menu div > ul > li:not(:last-child ) {
				border-bottom: 1px solid #efefef;
			  }

			  .header__menu li > ul.right {
				right: inset;
				float: none;
			  }
			}

			.typesIndex .half,
			.typesIndex .half.right {
			  display: inline-block;
			  vertical-align: top;
			  float: none;
			}

			.crumbs {
			  font-size: .95em;
			}

			/*For amp validation*/

			.display-none {
			  display: none !important;
			}

			.overflow-hidden {
			  overflow: hidden !important;
			}

			.mb-25 {
			  margin-bottom: 25px !important;
			}

			.ya-style {
			  position: absolute !important;
			  display: none !important;
			  left: -9999px !important;"
			}
			
			.img {
				height: 26px;
				width: 169px;
			}
			
			.hamburger {
			  padding-left: 10px;
			}      
			.sidebar {
			  padding: 10px;
			  margin: 0;
			}
			.sidebar > li {
			  display: block;
			  border-top: 1px solid #a1a1a1;
			  margin: 10px 0px;
			  padding-top: 10px;
			}
			.sidebar > li > ul {
			  display: block;
			  padding-left: 5px;
			}
			.sidebar > li > ul > li {
			  display: block;
			  margin-top: 5px;
			}
			.sidebar a {
			  text-decoration: none;
			}
			.close-sidebar {
			  font-size: 1.5em;
			  padding-left: 5px;
			}
			
			.btn-close {
				text-align: center;
				line-height: 40px;
				font-size: 20px;
			}
		</style>
    <?php endif; ?>
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="header__top fixed">
                <?php $logo = '/bitrix/templates/centre/img/logo'.(isset($marka) ? ucfirst($marka_lower).$header_1 : '').'.png';
                    // Logo img tag for amp
                    $logo_tag = "<img src=\"{$logo}\" alt=\"Логотип компании CENTRE\">";
                    if ( $this->_datas['isAMP'] )
                        $logo_tag =  "<amp-img src=\"{$logo}\" alt=\"Логотип компании CENTRE\" class=\"img\" height=\"26\" width=\"169\"  layout=\"responsive\"></amp-img>";

                if ($url != $home) :; ?>
                    <a href="<?=$home?>"><?= $logo_tag; ?></a>
                <?php else :; ?>
                    <span><?= $logo_tag; ?></span>
                <?php endif; ?>
                <p class="header__top__tagline"><span>СЕРВИСНЫЙ ЦЕНТР</span>
				<span><?php if (isset($marka)) if ($this->_datas['region']['name_pe']=='Москве' && mb_strtoupper($marka) == 'NIKON') { echo 'ФОТОТЕХНИКИ'; } elseif ($marka == 'Sony') { echo 'CENTRE'; } else { echo mb_strtoupper($marka); } ?> В <?=mb_strtoupper($this->_datas['region']['name_pe'])?></span></p>
                <div class="header__top__phone"><a class="footphone mango_id" href="tel:+<?=$phone?>">+<?=$phone_format?></a></div>
                <?php if ( $this->_datas['isAMP'] ) :; ?>
                    <div class = "mobilemenu"><a on='tap:sidebar1.toggle' href = "#" class = "mobtoggle"><amp-img class="imgmenu" src = "/bitrix/templates/centre/img/menu.png" width="40" height="40" layout="responsive"></a></div>
					<amp-sidebar id="sidebar1" layout="nodisplay" side="right">
						<div role="button" aria-label="close sidebar" on="tap:sidebar1.toggle" tabindex="0" class="btn-close close-sidebar">Закрыть</div>
						<ul class="sidebar">
							<? foreach ($this->_datas['menu'] as $key => $value)
							{
							  if ($key[0] == '/')
								if ($url == $key)
									echo '<li><span class="active">'.$value.'</span></li>';
								else
									echo '<li><a href="'.$key.'">'.$value.'</a></li>';
							  else if (isset($value['name']) && isset($value['list']) && isset($value['pos'])) {
								$pos = $value['pos'] == 'right' ? ' class = "right"' : '';
								echo '<li class = "subItem"><a>'.$value['name'].'</a><ul>';
								foreach ($value['list'] as $urlItem => $item) {
								  if ($url == $urlItem)
									  echo '<li><span class="active">'.$item.'</span></li>';
								  else
									  echo '<li><a href="'.$urlItem.'">'.$item.'</a></li>';
								}
								echo '</ul></li>';
							  }
							 }
							?>
						</ul>
					</amp-sidebar>
				<?php else :; ?>
                    <div class = "mobilemenu"><a href = "#" class = "mobtoggle"><img src = "/bitrix/templates/centre/img/menu.png"></a></div>
                <?php endif; ?>
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
                    <ul class = "<?=$status?>">
                        <? foreach ($this->_datas['menu'] as $key => $value)
                        {
                          if ($key[0] == '/')
                            if ($url == $key)
                                echo '<li><span class="active">'.$value.'</span></li>';
                            else
                                echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                          else if (isset($value['name']) && isset($value['list']) && isset($value['pos'])) {
                            $pos = $value['pos'] == 'right' ? ' class = "right"' : '';
                            echo '<li class = "subItem"><a>'.$value['name'].'</a><ul'.$pos.'>';
                            foreach ($value['list'] as $urlItem => $item) {
                              if ($url == $urlItem)
                                  echo '<li><span class="active">'.$item.'</span></li>';
                              else
                                  echo '<li><a href="'.$urlItem.'">'.$item.'</a></li>';
                            }
                            echo '</ul></li>';
                          }
                         }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="header__menu brandNav">
                <div class=" fixed">
                    <ul class = "brandNav <?=$status?>">
                        <? $i = 0; foreach ($this->_datas['markaTypes'] as $marka => $types)
                        {
                            $pos = ++$i > ceil(count($this->_datas['markaTypes'])/2) ? ' class = "right"' : '';
                            $hrefMain = $url == '/servis-'.strtolower($marka).'/' ? '' : 'href = "/servis-'.strtolower($marka).'/"';
                            echo '<li class = "subItem"><a '.$hrefMain.'>'.$marka.'</a><ul'.$pos.'>';
                            foreach ($types as $type) {
                              $href = '/'.$this->_datas['markasTypesUrl'][strtolower($marka)][$type].'/';
                              if ($url == $href)
                                  echo '<li><span class="active">'.tools::mb_ucfirst($this->_datas['allTypes'][$type]['type_m']).'</span></li>';
                              else
                                  echo '<li><a href="'.$href.'">'.tools::mb_ucfirst($this->_datas['allTypes'][$type]['type_m']).'</a></li>';
                            }
                            echo '</ul></li>';
                         }
                        ?>
                    </ul>
                </div>
            </div>
        </header>
