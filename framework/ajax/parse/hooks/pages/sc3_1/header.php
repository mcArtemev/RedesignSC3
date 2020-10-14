<?
use framework\tools;
use framework\pdo;

$metrica = $this->_datas['metrica'];
$mail_counter = $this->_datas['mail_counter'];

if (isset($this->_datas['marka'])) {
  $marka = $this->_datas['marka']['name'];
  $marka_lower = mb_strtolower($marka);
  $_marka_lower = tools::translit($marka, '_');
}
else {
  $marka_lower = 'sony';
}

  $typesId = implode(',', array_column($this->_datas['all_devices_site'], 'type_id'));
  $stmt = $this->dbh->query("SELECT m_models.model_type_id, GROUP_CONCAT(DISTINCT markas.name ORDER BY markas.name ASC SEPARATOR ',') FROM `m_models` JOIN markas ON m_models.marka_id = markas.id  GROUP BY m_models.model_type_id");
  $this->_datas['typeMarkas'] = [];
  foreach ($stmt->fetchAll() as $item) {
    $this->_datas['typeMarkas'][$item[0]] = explode(',', $item[1]);
  }
  $typeMarkas = $this->_datas['typeMarkas'];

$accord = $this->_datas['accord'];

$a_marka = [];
$brands =[];

foreach ($this->_datas['all_devices_site'] as $type)
{
    foreach ($typeMarkas[$type['type_id']] as $brand){
        $a_marka[$accord[$type['type']]][] = $brand;
        $brands[] = $brand;
    }
}

if (isset($this->_datas['add_url']))
{
   foreach ($this->_datas['add_url'] as $marka => $v)
   {
      foreach ($v as $val){
        $a_marka[$val][] = $marka;
        $brands[] = $marka;
      }
   }
}
$brands=array_unique($brands); 

$this->_datas['a_marka'] = $a_marka;

//var_dump($_SERVER['REQUEST_URI']);
//var_dump($this->_datas['marka']['name']);
//print_r($this->_datas['all_devices_site']);

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'пн-вс: 10:00 - 20:00';
$analytics = $this->_datas['analytics'];

$urlHome = in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/']) || !isset($this->_datas['marka']) ? '/' : '/'.$marka_lower.'/';


if($this->_datas['marka']['name'] == 'BenQ'){

}

?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title><?=$this->_ret['title']?></title>
        <meta name="description" content="<?=$this->_ret['description']?>"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/templates/moscow/img/<?=strtr(trim($marka_lower),' ','_')?>/favicon.ico" />
        <!-- <link href="/min/f=/templates/moscow/css/font-awesome.min.css,/templates/moscow/css/jquery.mCustomScrollbar.min.css,/templates/moscow/css/styles.css" rel="stylesheet" type="text/css"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
        <link rel="stylesheet" href="/templates/moscow/css/myStyle.css" type="text/css">
        <link rel="stylesheet" href="/templates/moscow/css/styles.css" type="text/css">        
        <!-- <link rel="stylesheet" href="/templates/moscow/css/stylesOld.css" type="text/css"> -->
        <link rel="stylesheet" href="/templates/moscow/css/owl.theme.default.min.css" type="text/css">
        

        <? if ($analytics):?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?=$analytics?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '<?=$analytics?>');
        </script>
        <?endif;?>
        
        <? $msk = false;
           $spb = false;  
        if ($this->_datas['region']['name'] == 'Москва'): ?>
            <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?162",t.onload=function(){VK.Retargeting.Init("VK-RTRG-415052-3u4YD"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-415052-3u4YD" style="position:fixed; left:-999px;" alt=""/></noscript>
        <? $msk = true;
        endif;
        if ($this->_datas['region']['name'] == 'Санкт-Петербург'): ?>
            <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?162",t.onload=function(){VK.Retargeting.Init("VK-RTRG-415056-hkybd"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-415056-hkybd" style="position:fixed; left:-999px;" alt=""/></noscript>
        <? $spb = true; 
        endif;
        if (!$msk && !$spb):?>
            <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?162",t.onload=function(){VK.Retargeting.Init("VK-RTRG-415057-1Wheg"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-415057-1Wheg" style="position:fixed; left:-999px;" alt=""/></noscript>
        <?endif;?>        
    </head>
    <body>
         <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter<?=$metrica?> = new Ya.Metrika({
                            id:<?=$metrica?>,
                            clickmap:true,
                            trackLinks:true,
                            webvisor:true,
                            accurateTrackBounce:true
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
        <noscript><div><img src="https://mc.yandex.ru/watch/<?=$metrica?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <!-- /Yandex.Metrika counter -->
    <input type = "hidden" name = "max_amount" value = "4">
    <?php if (!empty($this->_datas['piwik'])) { ?>
      <script type="text/javascript">
      var _paq = _paq || [];
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u="/stat/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '<?=$this->_datas['piwik']?>']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
      })();
      </script>
      <noscript><p><img src="/stat/piwik.php?idsite=<?=$this->_datas['piwik']?>&amp;rec=1" style="border:0;" alt="" /></p></noscript>
    <?php } ?>
<!-- Top nav menu -->
    <section class="infomenu-container">
        <div class="container">
            <ul class="infomenu">
            
                <li class="infomenu-item"> <a href="<?=$urlHome?>">Главная</a></li>
                <? foreach ($this->_datas['menu_header'] as $key => $value):
                                  if ($url == $key)
                                      echo '<li class="infomenu-item"><span>'.$value.'</span></li>';
                                  else
                                      echo '<li class="infomenu-item"><a href="'.$key.'">'.$value.'</a></li>';
                          endforeach; ?>
            </ul>
        </div>
    </section>
<!-- Header -->
        <header class="header">
            <div class="container">
                <div class="row">
                    <div class="col-auto">
                        <? if ($url != $urlHome) :?>
                            <?if(in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/','/sitemap/','/sitemap_noutbuki/','/sitemap_planshety/' , '/sitemap_telefony/']) || !isset($this->_datas['marka'])):?>
                                <a class="logotype" href="<?=$urlHome?>" style="background: url(/templates/moscow/img/citys/city<?=(($this->_datas['region']['code'] ? '-'.$this->_datas['region']['code'] : ''))?>.png);">
                                    <img src="/templates/moscow/img/support/logotip.png">
                                </a>
                            <?else:?>
                                <a class="logotype" href="<?=$urlHome?>" style="background: url(/templates/moscow/img/citys/city<?=(($this->_datas['region']['code'] ? '-'.$this->_datas['region']['code'] : ''))?>.png);">
                                    <img src="/templates/moscow/img/<?=strtr(trim($marka_lower),' ','_')?>/logotip.png">
                                </a>
                            <? endif;?>
                            
                        <?else:?>
                            <span class="logotype" style="background: url(/templates/moscow/img/citys/city<?=(($this->_datas['region']['code'] ? '-'.$this->_datas['region']['code'] : ''))?>.png);">
                            	<img src="/templates/moscow/img/<?=strtr(trim($marka_lower),' ','_')?>/logotip.png">
                            </span>
                        <?endif;?>
                    </div>
                    <div class="col-md-3 align-self-center"> 
                        <p class="slogan-company">Сервисный центр по ремонту<?=(!in_array($url, ['/o_nas/', '/kontakty/', '/vakansii/', '/dostavka/']) && isset($this->_datas['marka']) ? ' '.$this->_datas['marka']['name'] : '')?> в <?=$this->_datas['region']['name_pe']?></p>
                    </div>
                    <div class="col-auto align-self-center ml-auto">
                        <button class="inputbutton inputbutton-outlinecallBackBtn">Обратный звонок</button>
                    </div>  
                    <div class="col-auto">
                        <a href="tel:+<?=$this->_datas['phone']?>" class="phone"><i class="fa fa-phone icon"></i><span class="mango-phone">
                                    <?=tools::format_phone($this->_datas['phone'])?></span></a>
                        <div class="time">график работы: <?=$time?></div>
                    </div> 
                </div>
            </div>
        </header>
    <!-- Main nav menu -->
            <?php if (in_array($this->_datas['region']['name'], ['Новосибирск', 'Нижний Новгород', 'Екатеринбург', 'Казань', 'Санкт-Петербург', 'Москва'])) { ?>
              <nav class="main-nav">
                  <div class="container">
                      <i class="mobile-menu fa fa-bars"></i>
                      <ul class="topmenu">
                          
                            
                        <? if (isset($a_marka)):?>
                            <?php foreach ($a_marka as $type_name => $b_brands) { 
                                    natcasesort ($b_brands);
                                    if (empty($this->_datas['marka']['name']) || in_array($this->_datas['marka']['name'], $b_brands)) { ?>
                                  
                                        <li>
                                            <a href="/<?=$accord[$device['type']]?>_<?=tools::translit($marka,'_')?>/" class="sb"><?=tools::mb_ucfirst($this->_datas['add_device_type'][$type_name]['type_m'])?></a>
                                            <!-- <ul class="submenu submenuBrand">
                                                <? foreach ($b_brands as $brand):
                                                        $s_path = '/'.$type_name.'_'.mb_strtolower($brand).'/';
                                                        if ($url == $s_path)
                                                            echo '<li class="selected"><span>'.$brand.'</span></li>';
                                                        else
                                                            echo '<li><a href="'.$s_path.'">'.$brand.'</a></li>';
                                                    endforeach; 
                                                ?>
                                            </ul> -->
                                        </li>
                                    
                               
                                    <?php }
                                } 
                            ?>
                        <?endif;?>
                          <li>
                              <a href="#" class="sb">Другое</a>
                              <!-- <ul class="submenu submenuBrand">
                              <? if(!empty($this->_datas['marka']['name'])){
                                  $s_path = '/'.mb_strtolower($this->_datas['marka']['name']).'/ceny/';
                                  if ($url == $s_path)
                                      echo '<li class="selected"><span>'.$this->_datas['marka']['name'].'</span></li>';
                                  else
                                      echo '<li><a href="'.strtr(trim($s_path),' ','_').'">'.$this->_datas['marka']['name'].'</a></li>';
                              }else{
                              natcasesort ($brands);
                              foreach ($brands as $brand):
                                      echo '<li><a href="/'.strtr(trim($brand),' ','_').'/">'.$brand.'</a></li>';
                                  endforeach; 
                                  }?>
                                  
                              </ul> -->
                          </li>
                          
                      </ul>
                  </div>
              </div>
            <?php }  ?>
        </nav>
        
