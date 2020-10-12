<?

use framework\tools;

$accord = array('ноутбук' => 'remont_noutbukov', 'планшет' => 'remont_planshetov', 'смартфон' => 'remont_telefonov');
$accord_img = array('ноутбук' => 'noutbuk', 'планшет' => 'planshet', 'смартфон' => 'telefon');

$brands =[];
$stmt = $this->dbh->query("SELECT m_models.model_type_id, GROUP_CONCAT(DISTINCT markas.name ORDER BY markas.name ASC SEPARATOR ',') FROM `m_models` JOIN markas ON m_models.marka_id = markas.id  GROUP BY m_models.model_type_id");
foreach ($stmt->fetchAll() as $item) {
  $brands = explode(',', $item[1]);
}

foreach ($this->_datas['add_url'] as $marka => $v)
{
   $brands[]=$marka;
}
$brands=array_unique($brands);
natcasesort($brands);

$city = $this->_datas['region']['name_pe'];
$city1 = $this->_datas['region']['name'];

$url = ($this->_datas['arg_url'] != '/') ? '/'.$this->_datas['arg_url'].'/' : '/';
$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'пн-вс: 10:00 - 20:00';
$analytics = $this->_datas['analytics'];

$address = $this->_datas['region']['name'].', '.$this->_datas['partner']['address1'];

$addresis = $this->_datas['addresis'];

$swap_key = false;

foreach ($addresis as $key => $value)
{
    if ($value['region_name'] == $this->_datas['region']['name'])
    {
        $swap_key = $key;
        break;
    }
}

if ($swap_key !== false)
{
    $t = $addresis[$swap_key];
    unset($addresis[$swap_key]);
    array_unshift($addresis, $t);
}


// генерёж на баннере
$banner = array();
$banner[0][] = array("СЕТЬ");
$banner[0][] = array("СЕРВИСНЫХ ЦЕНТРОВ","СЕРВИС ЦЕНТРОВ","СЕРВИСОВ","ЦЕНТРОВ");
$banner[0][] = array("SUPPORT");
$banner[0][] = array("ПРОВОДИТ РЕМОНТ:");
$banner[1][] = array("смартфонов","планшетов","ноутбуков",'компьютеров', 'принтеров', 'фотоаппаратов', 'моноблоков', 'проекторов', 'телевизоров', 'мониторов', 'электросамокатов', 'холодильников', 'посудомоечных машин', 'стиральных машин');
$banner[1][] = array("смартфонов","планшетов","ноутбуков",'компьютеров', 'принтеров', 'фотоаппаратов', 'моноблоков', 'проекторов', 'телевизоров', 'мониторов', 'электросамокатов', 'холодильников', 'посудомоечных машин', 'стиральных машин');
$banner_rand = 12;

for ($i=0; $i<$banner_rand; $i++)
{
    $ar = array_rand($banner[1][0],1);
    $banner_key[] = $ar;
    unset($banner[1][0][$ar]);
}
$banner_out2 = "";
foreach ($banner_key as $item)
{
    $banner_out2 .= $banner[1][1][$item] . ", ";
}

$banner_out2 = substr($banner_out2,0,-2);
$banner_out =  $this->checkarray($banner[0]);

$banner_dob = array();
$banner_dob[0][] = array("различных","разных");
$banner_dob[0][] = array("брендов","марок");
$banner_dob[1][] = $brands;
                    //array("Acer","Apple","Asus","Dell","HP","HTC","Huawei","Lenovo","Meizu","Samsung","Sony","Toshiba","Xiaomi","Alcatel",'Canon', 'LG','Electrolux','OnePlus', 'Ariston', 'Compaq', 
                    //    'Dexp', 'Epson', 'Fly', 'Fujifilm', 'Hasselblad','Leica', 'MSI', 'Nikon', 'Nokia','Olympus','Panasonic', 'Polaroid', 'Prestigio','Sigma','ZTE',
                   //      'Indesit' ,'Benq', 'Philips', 'iconBit','Digma');
$banner_dob[1][] = $brands;
                    //array("Acer","Apple","Asus","Dell","HP","HTC","Huawei","Lenovo","Meizu","Samsung","Sony","Toshiba","Xiaomi","Alcatel",'Canon','LG','Electrolux','OnePlus', 'Ariston', 'Compaq', 
                   //     'Dexp', 'Epson', 'Fly', 'Fujifilm',  'Hasselblad', 'Leica', 'MSI', 'Nikon', 'Nokia','Olympus','Panasonic', 'Polaroid','Prestigio','Sigma','ZTE', 'Indesit' ,'Benq', 'Philips', 'iconBit','Digma');

$banner_dob_rand = rand(3,6);

for ($i=0; $i<$banner_dob_rand; $i++)
{
    $ar1 = array_rand($banner_dob[1][0],1);
    $banner_dob_key[] = $ar1;
    unset($banner_dob[1][0][$ar]);
}

$banner_dob_out = "";
foreach ($banner_dob_key as $item)
{
    $banner_dob_out .= $banner_dob[1][1][$item] . ", ";
}

$banner_dob_out = substr($banner_dob_out,0,-2);
$banner_dob_description = $this->checkarray($banner[0]) . " " . $banner_out2 . ", " .  $this->checkarray($banner_dob[0]) . " " . $banner_dob_out;

$logo = [
  'Екатеринбург' => 'support-ekb',
  'Казань' => 'support-kzn',
  'Москва' => 'support',
  'Нижний Новгород' => 'support-nnv',
  'Новосибирск' => 'support-nsk',
  'Санкт-Петербург' => 'support-spb',
  'Волгоград' => 'support-vlg',
  'Воронеж' => 'support-vrn',
  'Краснодар' => 'support-krd',
  'Подольск' => 'support-pod',
  'Ростов-на-Дону' => 'support-rnd',
  'Тула' => 'support-tul',
  'Хабаровск' => 'support-hab',
  'Челябинск' => 'support-chl',
];

$counter = 1;

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сеть сервисных центров SUPPORT по ремонту техники в <?=$city?></title>
    <meta name="description" content="<?=$banner_dob_description?>"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/templates/moscow/img/shared/favicon.ico" type="image/x-icon">
    <link href="/templates/moscow/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/templates/moscow/css/styles.css" rel="stylesheet" type="text/css">
    
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
<div class="header-row">
    <div class="toprow">
        <div class="container"><div class="logo"><img src="/templates/moscow/img/shared/<?=$logo[$city1]?>.png"></div>
            <div class="logoname" style="margin-top: 47px">Сервисные центры по ремонту в <?=$city?></div>
            <div class="worktime" style="margin-top: 47px"><div class="time">график работы: <br>пн-вс: 10:00 - 20:00</div>
            </div>
        </div>
    </div>
</div>

<div class="imagerow">
    <div class="container">
        <div class="imagerel" style="height: 100%;"><img src="/templates/moscow/img/shared/banner.png">
            <div class="imageabs">
                <div class="imagetitle indexSite"><?=$banner_out?></div>
                <div class="imagetext"><?=$banner_out2?></div>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="container"><h1>Сервисные центры в <?=$city?></h1>
            <div class="preimlist col1">
                <div class="preimitem" style="width: 100%;">
                    <div class="preimtext">
                        <div class="preimname">
                            <div class="popularrow models" style="margin-bottom: 0px">
                                <div class="container">
                                    <ul class="popularlist">
                                      <?php foreach ($brands as $brand) { ?>
                                        <li style="line-height: 25px"><a href="/<?=mb_strtolower(strtolower(strtr(trim($brand),' ','_')))?>/"><?=$brand?></a></li>
                                      <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="popularrow models">
            <div class="container">
              <h2>Популярные линейки</h2>
              <ul class="popularlist">
               <?php 
                foreach (array_slice($this->_datas['m_models'], 0, 12) as $m) {
                  $url = $this->urlType($m['type'], false, $m['marka']).'/'.$this->translit($this->clearBrandLin($m['name'], $m['marka']));
                  echo '<li><a href = "/'.mb_strtolower($url).'/">'.$this->firstup($m['name']).'</a></li>';
               } ?>
              </ul>
            </div>
        </div>

        <div class="popularrow models">
            <div class="container">
              <h2>Популярные устройства</h2>
              <ul class="popularlist">
               <?php
                foreach (array_slice($this->_datas['models'], 0, 12) as $m) {
                  $url = $this->urlType($m['type'], false, $m['marka']).'/'.$this->translit($this->clearBrandLin($m['name'], $m['marka']));
                  echo '<li><a href = "/'.mb_strtolower($url).'/">'.$this->firstup($m['name']).'</a></li>';
               } ?>
              </ul>
            </div>
        </div>

        <div class="preimrow">
            <div class="container">
                <h2>Преимущества сервиса SUPPORT</h2>
                <div class="preimlist preimlistWoBtn col2">
                    <div class="preimitem">
                        <img class = "preimimage" src="/templates/moscow/img/shared/komplektuyushie.png">
                        <div class="preimtext">
                            <div class="preimname">Качественные комплектующие</div>
                            <div class="preiman">
                                Оригинальные комплектующие всегда в наличии. Возможность персонального дозаказа.
                            </div>
                        </div>
                    </div>
                    <div class="preimitem">
                        <img class = "preimimage" src="/templates/moscow/img/shared/neispravnosti.png">
                        <div class="preimtext">
                            <div class="preimname">Ремонт любых неисправностей</div>
                            <div class="preiman">
                                В наших мастерских производится ремонт любого уровня сложности аппаратов.
                            </div>
                        </div>
                    </div>
                    <div class="preimitem">
                        <img class = "preimimage" src="/templates/moscow/img/shared/diagnostika.png">
                        <div class="preimtext">
                            <div class="preimname">Срочная диагностика, тех. заключение</div>
                            <div class="preiman">
                                Срочная диагностика, не отходя от кассы. Углублённое аппаратное и программное тестирование техники.
                            </div>
                        </div>
                    </div>
                    <div class="preimitem">
                        <img class = "preimimage" src="/templates/moscow/img/shared/dostavka.png">
                        <div class="preimtext">
                            <div class="preimname">Доставка вашей техники </div>
                            <div class="preiman">
                                Чтобы вернуть в строй вашу технику, не обязательно выходить из дома.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text">Мы используем только оригинальные комплектующие, на протяжении нашего сотрудничества вас будет вести личный менеджер, вы всегда будете знать о статусе ремонта, цены в нашем СЦ фиксированные. Будем рады видеть вас среди наших гостей.</div>
            </div>
        </div>

        <div class="planrow">
            <div class="container">
                <h2>План ремонта в нашем сервисе</h2>
                <div class="planrow">
                    <div class="planitem">
                        <div class="planimage">
                            <img src="/templates/moscow/img/shared/plan1.png">
                        </div>
                        <div class="plantext">
                            Вы <strong>приезжаете</strong> к нам в сервисный центр или <strong>вызываете</strong> курьера на дом
                        </div>
                    </div>
                    <div class="planitem">
                        <div class="planimage">
                            <img src="/templates/moscow/img/shared/plan2.png">
                        </div>
                        <div class="plantext">
                            Мы проводим <strong>диагностику</strong> и согласовываем с вами ремонтные работы
                        </div>
                    </div>
                    <div class="planitem">
                        <div class="planimage">
                            <img src="/templates/moscow/img/shared/plan3.png">
                        </div>
                        <div class="plantext">
                            Качественно <strong>ремонтируем</strong> вашу любимую технику и выдаем гарантию
                        </div>
                    </div>
                    <div class="planitem">
                        <div class="planimage">
                            <img src="/templates/moscow/img/shared/plan4.png">
                        </div>
                        <div class="plantext">
                            Вы <strong>наслаждаетесь</strong> своим отремонтированным гаджетом
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footerrow">
            <div class="container">
                <div class="footerflex">
                    <div class="footeritem">
                        <div class="footertitle">Клиентам</div>
                        <ul class="footermenu">
                            <li><a href="/dostavka/">Доставка</a></li>
                            <li><a href="/vakansii/">Вакансии</a></li>
                            <li><a href="/kontakty/">Контакты</a></li>
                        </ul>
                    </div>
                    <div class="footeritem contact-map">
                        <div class="footertitle">контакты</div>
                        <div class="contact-content">
                            <div class="panel-group" id="cnt-accordion">
                              <? $i =0;
                                 foreach ($addresis as $value):
                                    $v = ($value['region_name']) ? $value['region_name'] : 'Москва';
                                    $address = $value['address2'] ? $value['address2'] : $value['address1'];
                                    $urlSite = preg_replace('/^([a-z]+\.)([a-z]+\.support)/', '$2', $value['site']); ?>

                                  <div class="contacttable panel">

                                        <? if ($i): ?>

                                         <div class="contacttitle collapsed" data-toggle="collapse"
                                                data-target="#cnt-<?=$i?>" data-parent="#cnt-accordion" data-x="<?=$value['x']?>" data-y="<?=$value['y']?>"><?=$v?></div>

                                            <div class="collapse" id="cnt-<?=$i?>">
                                                <p><a href="http://<?=$urlSite?>"><?=tools::format_phone($value['phone'])?></a></p>

                                        <? else :?>

                                         <div class="contacttitle" data-toggle="collapse"
                                                data-target="#cnt-<?=$i?>" data-parent="#cnt-accordion" data-x="<?=$value['x']?>" data-y="<?=$value['y']?>"><?=$v?></div>

                                            <div class="collapse in" id="cnt-<?=$i?>">
                                                <p><?=tools::format_phone($value['phone'])?></p>
                                
                                        <? endif; ?>
                                            
                                        </div>
                                  </div>
                              <?  $i++;
                                 endforeach; ?>
                              </div>

                              <div id="cnt-map"></div>
                        </div>
                        <div class="footerpolitics"><a href="/politics.pdf"><img src="/templates/moscow/img/shared/pdf-icon.png">Политика</a></div>
                      </div>
                 </div>
             </div>
          </div>
        </div>

        <script type="text/javascript" async src="/min/f=/templates/moscow/js/jquery.min.js,/templates/moscow/js/bootstrap.min.js,/templates/moscow/js/jquery.maskedinput.js,/templates/moscow/js/main.js,/templates/moscow/js/kontakty.js&123456"></script>
        <script src="//api-maps.yandex.ru/2.0/?load=package.standard,package.geoObjects&amp;lang=ru-RU" type="text/javascript"></script>

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript"> (function (d, w, c) {
                (w[c] = w[c] || []).push(function () {
                    try {
                        w.yaCounter<?=$counter?> = new Ya.Metrika({
                            id: <?=$counter?>,
                            clickmap: true,
                            trackLinks: true,
                            accurateTrackBounce: true
                        });
                    } catch (e) {
                    }
                });
                var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
                    n.parentNode.insertBefore(s, n);
                };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";
                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else {
                    f();
                }
            })(document, window, "yandex_metrika_callbacks"); </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/<?=$counter?>" style="position:absolute; left:-9999px;" alt=""/></div>
        </noscript> <!-- /Yandex.Metrika counter -->
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
        
        <? if (mb_strpos($this->_datas['site_name'], 'peterburg') !== false):?>
            <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?160",t.onload=function(){VK.Retargeting.Init("VK-RTRG-358213-Jztb"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-358213-Jztb" style="position:fixed; left:-999px;" alt=""/></noscript>
        <?endif;?>
        
        </body>
        </html>
