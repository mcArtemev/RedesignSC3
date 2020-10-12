<?
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ

$region_name = $this->_datas['region']['name'];//Москва
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
//$address = $this->_datas['partner']['address1'];

$address = (($this->_datas['partner']['index']) ? '<span itemprop="postalCode" class="postal-code">'.$this->_datas['partner']['index'].'</span>, ' : '') . 
            '<span itemprop="addressLocality" class="locality">'.$this->_datas['region']['name'].'</span>, <span itemprop="streetAddress" class="street-address">'.$this->_datas['partner']['address1'].'</span>';
$metrica = $this->_datas['metrica'];
//srand($this->_datas['feed']);
$time = ($this->_datas['partner']['time']) ? $this->_datas['partner']['time'] : 'Пн-Вс: с 10-00 до 21-00';
$point = $this->_datas['partner']['x'].','.$this->_datas['partner']['y'];

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";


?>

<? if ($this->_datas['realHost'] != $this->_datas['site_name'] || 'canon-russia.net' != $this->_datas['realHost']):?>
    <? if (!$this->_datas['partner']['sid']): ?>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <? endif ;?>
<? endif ;?>

<div class="sr-main">
    <? if (!$this->_datas['partner']['sid']): ?>
        <div id="yandex_map" class="uk-hidden-small"></div>
    <? else: ?>
        <div id="yandex_map" class="uk-hidden-small"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%<?=$this->_datas['partner']['sid']?>&amp;width=100%&amp;height=370&amp;lang=ru_RU&amp;scroll=false"></script></div>
    <? endif ;?>
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
             <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
             &nbsp;/&nbsp;
             <span class="uk-text-muted">Контакты</span>
        </div>
    </div>
    <div class="uk-width-medium-1-1 bgcolorwhite uk-visible-small<?=$add_class?>">
        <div class="uk-container-center uk-container">
           <a href="tel:+<?=$phone?>" class="uk-contrast"><?=$phone_format?></a>
        </div>
    </div>
    <div class="uk-container-center uk-container ">
        <div class="uk-grid uk-margin-remove" data-uk-grid-margin>
            <div class="uk-width-medium-5-10"></div>
            <div class="uk-width-medium-5-10 whiteblock ">
                <h1>Контакты &ndash; свяжитесь с нами</h1>
                <ul class="list-blue-marker">
                    <li>Оперативный режим работы техподдержки</li>
                    <li>365 дней в году - без праздников и выходных</li>
                    <? if (!$this->_datas['sdek']):?>
                        <li>Выезд курьера в любую точку <?=$region_name_re?></li>
                    <?else:?>
                        <li>Удобное месторасположение</li>
                    <?endif;?>
                </ul>
                <p><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/>
                </p>
            </div>
        </div>
    </div>
</div>
<div style="width: 100%;background: #f5f5f5;height: 45px;position:  absolute;margin-top: -45px; "></div>

<div class="sr-content" style="margin-top: -45px; position: relative;">
    <div class="uk-container-center uk-container uk-margin-bottom">
        <div class="uk-flex sr-contetnt-block uk-margin-top">
            <div class="uk-width-large-7-10 sr-content-white vcard" itemscope itemtype="http://schema.org/Organization">
                <meta itemprop="name" content="<?=$this->_datas['servicename']?>"/>
                <span class="fn org">
                    <span class="value-title" title="<?=$this->_datas['servicename']?>"></span>
                </span> 
                <div class="uk-clearfix ">
                    <img src="/wp-content/uploads/2015/03/imgContent-contacts-2.jpg" class="uk-align-right <?=(($this->_datas['sdek']) ? '' : 'uk-margin-bottom-remove')?> uk-hidden-small uk-hidden-medium">
                    <? if (!$this->_datas['sdek']):?>
                        <p>Обслуживание техники <?=$marka?> осуществляется в сервисном центре или с выездом курьера на дом или в офис.</p>
                    <?else:?>
                        <p class="uk-h2">Не только удобно, но и выгодно</p>
                        <p>Теперь и в <?=$region_name_pe?> вам доступен сервис по ремонту <?=$marka?> от Russia Expert. 
                        Мы заключили соглашение с федеральной службой доставки СДЭК, крупнейшей логистической компанией в России. Благодаря этому вы сможете:</p>
                        <ol class="sdek">
                            <li>оформить заказ в любом из более 1500 пунктов приема заказов (ПВЗ) СДЭК, в том числе в <?=$region_name_pe?>.</li>
                            <li>выполнить ремонт вовремя. Пересылка в Москву из <?=$region_name_re?> занимает в среднем 2-3 дня, 95% комплектующих <?=$marka?> находятся именно на складе в Москве.</li>
                            <li>получить обслуживание <?=$marka?> квалифицированными мастерами Russia Expert в Москве.</li>
                            <li>хорошо сэкономить. Доставка комплектующих в ваш город, а также открытие обособленного филиала сделало бы ремонта вашего <?=$marka?> в 1,5-2 раза дороже, чем в Москве. Пересылка 
                                                из <?=$region_name_re?> в Москву является бесплатной при осуществлении ремонта. 
                                Но даже если вы не будете заказывать ремонт в Russia Expert, 
                                        стоимость пересылки из  <?=$region_name_re?> в Москву в среднем составит 500-700 рублей в зависимости от веса устройства.</li>
                        </ol>
                    <?endif;?>
                    <ul class="list-blue-marker var2">
                        <li><a href="/zapchasti/">Оригинальные комплектующие</a></li>
                        <li><a href="/diagnostika/">Быстрая диагностика</a></li>
                    </ul>
                </div>
                <hr>
                <p>Оставить заказ вы можете удобным для вас способом – по телефону или через форму заявки на сайте. При поступлении заявки наши менеджеры незамедлительно свяжутся с вами и уточнят детали заказа.</p>
                <p class="uk-h2">Контактная информация</p>
                
                <? 
                $laptop_name = false;
                /*$p_mode = $this->_datas['p_mode']; 
                
                $laptop_o_nas = array('acer', 'alcatel', 'apple', 'asus', 'canon', 'dell', 'fly', 'hp',
                        'htc', 'huawei', 'lenovo', 'lg', 'meizu', 'msi', 'nikon', 'nokia', 'samsung',
                            'sony', 'toshiba', 'xiaomi', 'zte');
                            
                if ($this->_datas['setka_name'] == 'СЦ-1' && in_array($marka_lower, $laptop_o_nas) && $this->_datas['region']['name'] == 'Москва')
                    $laptop_name = true;
                    
                    
                if ($laptop_name)
                {
                    $prof = ($p_mode == 'GA');
                }*/
                
                if (in_array($this->_datas['partner_id'], [247, 802, 803]))
                    $laptop_name = true; 
                    
                // echo '<div style="display:none">'.$this->_datas['setka_name'].'</div>';
                ?>
                
                <? if (!$this->_datas['partner']['exclude']): ?>
                    <p>Адрес сервисного центра <?=(($this->_datas['setka_name'] != 'СЦ-1' || $marka_lower != 'samsung') ? $servicename : '')?> в <?=$region_name_pe?>: <br />
                    
                    <? if ($this->_datas['partner']['schema']):?>
                        <!--<img src="<?=$this->_datas['partner']['schema']?>" width="100%" height="auto"/>-->
                    <? endif;?>
                
                    <? 
                    if ($laptop_name):?>
                        <? if (true):?>
                        
                            <strong itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="adr">1. <?=$address?></strong></p>
                            
                            <div class="uk-slidenav-position" data-uk-slider>
        
                                <div class="uk-slider-container">
                                    <ul class="uk-slider uk-grid-width-medium-1-1">
                                        <?for ($i = 1; $i <= 4; $i++):?>
                                            <li><img src="/wp-content/uploads/2015/03/slider2/<?=$i?>.jpg"/></li>
                                        <?endfor;?>
                                    </ul>
                                </div>
        
                                <span class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></span>
                                <span class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></span>
                            </div>
                            
                            <p class="uk-text-large">Как к нам добраться:</p>
                            
                            <p><b>Пешком:</b><br />
                            м Новые Черемушки, ул Профсоюзная д 58, корпус 4, заезд с ул Гарибальди направо перед ТЦ Черемушки, жилой многоэтажный дом из красного кирпича, на первом этаже на углу дома вывеска &quot;Сервисный центр Лаборатория&quot;</p>
                            
                            <?if (!$use_choose_city):?>
                                <p>Телефон горячей линии: <strong itemprop="telephone"><a href="tel:+<?=$phone?>" class="tel"><span class="value-title" title="+7<?=$phone?>"></span><?=$phone_format?></a></strong></p>
                            <?endif;?>
                            
                            <p><strong>2. 127254, Москва, проезд Добролюбова, 6Ас1</strong></p>
                             
                        <?else:?>
                        
                            <strong itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="adr">1. <?=$address?></strong></p>
                            
                            <div class="uk-slidenav-position" data-uk-slider>
        
                                <div class="uk-slider-container">
                                    <ul class="uk-slider uk-grid-width-medium-1-1">
                                        <?for ($i = 1; $i <= 4; $i++):?>
                                            <li><img src="/wp-content/uploads/2015/03/slider2/<?=$i?>.jpg"/></li>
                                        <?endfor;?>
                                    </ul>
                                </div>
        
                                <span class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></span>
                                <span class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></span>
                            </div>
                            
                            <p class="uk-text-large">Как к нам добраться:</p>
                            
                            <p><b>Пешком:</b><br />
                            м Новые Черемушки, ул Профсоюзная д 58, корпус 4, заезд с ул Гарибальди направо перед ТЦ Черемушки, жилой многоэтажный дом из красного кирпича, на первом этаже на углу дома вывеска &quot;Сервисный центр Лаборатория&quot;</p>
                            
                            <?if (!$use_choose_city):?>
                                <p>Телефон горячей линии: <strong itemprop="telephone"><a href="tel:+<?=$phone?>" class="tel"><span class="value-title" title="+7<?=$phone?>"></span><?=$phone_format?></a></strong></p>
                            <?endif;?>
                            
                            <p><strong>2. 129626, Москва, Проспект Мира 102 стр. 12 первый подъезд</strong></p>
                                    
                            <div class="uk-slidenav-position" data-uk-slider>
        
                                <div class="uk-slider-container">
                                    <ul class="uk-slider uk-grid-width-medium-1-1">
                                        <?for ($i = 1; $i <= 4; $i++):?>
                                            <li><img src="/wp-content/uploads/2015/03/slider/<?=$i?>.jpg"/></li>
                                        <?endfor;?>
                                    </ul>
                                </div>
        
                                <span class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></span>
                                <span class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></span>
                            </div>
        					<!--<video width="100%" height="422" style="background-color: #c6c6c6;" class="uk-margin-top" poster="/wp-content/uploads/2015/03/logo.png" preload controls src="/wp-content/uploads/2015/03/video.mp4"></video>-->
                            
                            <p><iframe width="100%" height="422" src="https://www.youtube.com/embed/UXInnnXvrQQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
                            
                            
                            <p class="uk-text-large">Как к нам добраться:</p>
                            
                            <p><b>Пешком:</b><br />
                            Метро Алексеевская, из метро налево по проспекту Мира в сторону центра (против движения транспорта) около 750 метров. Проход к сервису через арку второго строения (через 102 стр2).</p>
                             
                            <p><b>На автомобиле:</b><br />
                            По ходу движения из центра съезд с проспекта Мира сразу после эстакады направо. Вдоль 102 стр2 по обеим сторонам дороги имеются бесплатные парковочные места. Далее на Дроболитейном переулке имеются платные парковки. При движении в центр развернуться можно сразу перед эстакадой через Мурманский проезд.</p>
                            
                        <?endif;?>
                    <?else:?>
                        <strong itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="adr"><?=$address?></strong></p>
                    <?endif;?>
                 <?endif;?>
                <? if ($this->_datas['sdek'])
                {
                    $str = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/sdek/sdek.csv');
                    $rows = explode("||\r\n", $str);
                    
                    $city = mb_strtolower($region_name);
                    $t_city = array();
                    
                    foreach ($rows as $row)
                    {
                        if ($row)
                        {
                            $row = str_replace(array(PHP_EOL, '"'), array(' ', ''), $row);
                            $cols = explode(';', $row);
                            
                            foreach ($cols as $k => $v)
                                $cols[$k] = trim($v);
                                
                            if (mb_strtolower($cols[5]) == $city)
                                $t_city[] = $cols[6].", ".$cols[7];
                        }
                    }
                    
                    if ($t_city)
                    { 
                        echo '<p>Адрес пункта приема заказов:<br/>';
                        
                        for ($i = 0; $i < 7; $i++)
                        {
                            if (!isset($t_city[$i])) break;
                            echo $t_city[$i].'<br/>';
                        }
                        
                        echo '</p>';
                        
//                        $this->_datas['points'] = $this->_points($region_name, $t_city);
                    }
                }
                ?>
                 
                <?if (!$laptop_name && !$use_choose_city):?>
                    <p>Телефон горячей линии: <strong itemprop="telephone"><a href="tel:+<?=$phone?>" class="tel"><span class="value-title" title="+7<?=$phone?>"></span><?=$phone_format?></a></strong></p>
                <?endif;?>
                
				<?php if($this->_datas['region']['name'] == 'Москва') { ?>
				<div class="target-content-block uk-grid uk-padding form-bid">
					<div class="uk-width-large-8-10" style="width: 100%; padding-right: 25px;">
						<p><b>СЛУЖБА КОНТРОЛЯ КАЧЕСТВА</b></p>
						<p>
							Помогите нам стать лучше!<br>
							Оставляйте свои предложения относительно работы сайта, качества обслуживания, клиентского сервиса. Опишите недостатки в работе наших сотрудников и компании в целом.<br>Все пожелания и замечания будут внимательно рассмотрены и приняты к сведению. Спасибо!
						</p>
						<div class="uk-grid uk-margin-bottom">
							<div class="uk-width-medium-1-2">
								<?/*<p class="uk-text-bold uk-h3 textmobile uk-margin-bottom">
									<a href="https://api.whatsapp.com/send?phone=79265640863"><img src="/wp-content/uploads/2015/03/whatsapp-50.png" target="_blank" style="float: left; height: 30px; margin-right: 5px;" /></a>
									<img src="/wp-content/uploads/2015/03/viber-50.png" style="float: left; height: 30px; margin-right: 15px;" />
									<a href="tel:79265640863" style="text-decoration: none; color: #444; line-height: 30px; float: left;">+7 (926) 564-08-63</a>
								</p>*/?>
							</div>
							<div class="uk-width-medium-1-2">
								<p class="textmobile">
									<span><input type="button" style="float: right;" href="#" data-uk-modal="{target:'#popup_qcs'}" class=" uk-button uk-button-success uk-margin-left" onclick="return false;" value="Оставить отзыв"/></span>
								</p>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<? if ($this->_datas['setka_name'] != 'СЦ-1' || $marka_lower != 'samsung'):?>
                <p>Для партнёров: <strong><a class="" href="tel:+74993724999">7 (499) 372-49-99</a></strong></p>
                <? endif;?>
                <p>По вопросам и предложениям: <strong itemprop="email" class="email">support@<?=$this->_datas['site_name']?></strong></p>
                <p>Для корпоративных клиентов: <strong>corp@<?=$this->_datas['site_name']?></strong></p>               
                <p>Руководство: <strong>director@<?=$this->_datas['site_name']?></strong></p>
                <p>&nbsp;</p>
                <p>График работы сервисного центра: <strong class="workhours"><?=$time?></strong></p>
                <?if ((!($this->_datas['setka_name'] == 'СЦ-1' && $marka_lower == 'meizu' && $this->_datas['region']['name'] == 'Москва'))
                    && (!($this->_datas['setka_name'] == 'СЦ-1' && $marka_lower == 'nikon' && $this->_datas['region']['name'] == 'Москва'))):?> 
                <p><a class="url" href="http://<?=$this->_datas['site_name']?>" itemprop="url">Официальный сайт Russia Expert по ремонту <?=$marka?></a></p>
                <?endif;?>
                <span class="geo">
                    <span class="latitude">
                      <span class="value-title" title="<?=$this->_datas['partner']['x']?>"> </span>
                    </span>
                    <span class="longitude">
                      <span class="value-title" title="<?=$this->_datas['partner']['y']?>"> </span>
                    </span>
                </span> 
                <span class="category">
                    <span class="value-title" title="Компьютерный ремонт и услуги"></span>
                </span>
            </div>
            <? include __DIR__.'/rightPart2.php'; ?>
        </div>
    </div>
</div>

<input type="hidden" name="point" value="<?=$point?>">
<input type="hidden" name="zoom" value="<?=$this->_datas['zoom']?>">

<? if (isset($this->_datas['points'])):?>
    <? foreach ($this->_datas['points'] as $points):?>
       <input type="hidden" name="points" value="<?=$points[1].','.$points[0]?>">
    <?endforeach;?>
<?endif;?>
