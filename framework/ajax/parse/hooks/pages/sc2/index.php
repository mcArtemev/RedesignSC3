<?

use framework\tools;
$marka = $this->_datas['marka']['name'];
$ru_marka =  $this->_datas['marka']['ru_name'];
$marka_lower = mb_strtolower($marka);
$servicename = $this->_datas['servicename'];
$ru_servicename = $this->_datas['ru_servicename'];
$feed = $this->_datas['feed'];

$region_name = $this->_datas['region']['name'];

srand($feed);

$vars = array(
    'Ремонт #device '.$marka.' в сервисе '.$ru_servicename.'. Возможен выезд курьера на дом.',
    'Ремонт и обслуживание #device в сервис центре или с выездом курьера '.$servicename.' на дом.',
    'Обслуживание #device в '.$servicename.'. Экспресс ремонт. Доставка по '.$this->_datas['region']['name_de'].'.',
    'Ремонт #device '.$ru_marka.' в сервисном центре '.$servicename.'. Доставка.',
    'Обслуживание #device '.$marka.' в сервисе '.$ru_servicename.'. Срочная диагностика и ремонт.',
    'Ремонт #device в сервисном центре '.$ru_marka.'. Курьерская доставка в пределах '.$this->_datas['region']['name_re'].'.',
);

$accord = $this->_datas['accord'];

$accord_image = $this->_datas['accord_image'];

$header_1 = '';
if ($this->_datas['setka_name'] == 'СЦ-2' && (($marka_lower == 'samsung') || ($marka_lower == 'nikon') || ($marka_lower == 'sony')))
    $header_1 = '2';

$asus_flag = false;

if ($this->_datas['setka_name'] == 'СЦ-2' && $marka_lower == 'asus' && $region_name == 'Москва')
    $asus_flag = true;

?>

        <section class="hello">

            <div class="fixed">
                <h1><?=$this->_ret['h1']?></h1>
                <div class="hello__photo"><img src="/userfiles/site/large/<?=$marka_lower?>-centre<?=$header_1?>.png" width="415" height="221" alt="<?=$servicename?> - сервисный центр <?=$ru_marka?>" title="<?=$servicename?> - сервисный центр <?=$ru_marka?>"></div>
                <div class="hello__info">
                    <? if (!$asus_flag):?>
                        <p>Обслуживайте свою технику в <?=$ru_servicename?>: теперь и в <?=$this->_datas['region']['name_pe']?></p>
                        <p>С нами вы получите не только профессиональный ремонт, но и первоклассный сервис, включая экспресс диагностику и срочный ремонт.</p>
                        <p>Ждем вас в <?=$servicename?>!</p>
                        <a href="/order/"  class="btn btn--fill">Записаться на ремонт</a>
                    <?else:?>
                        <p>Обслуживайте свою технику в <?=$ru_servicename?>: теперь в <?=$this->_datas['region']['name_pe']?>.</p>
                        <p>С нами вы получите не только профессиональный ремонт, но и первоклассный сервис, включая экспресс диагностику и срочный ремонт.</p>
                        <p>Ждем вас!</p>
                        <!--noindex--><a href="/order/"  class="btn btn--fill">Записаться на ремонт</a><!--/noindex-->
                    <?endif;?>
                </div>

            </div>

        </section>

        <section class="experts">

            <div class="wrapper lgray">

                <div class="fixed">

                    <? if (!$asus_flag):?>
                        <span class="h2">Внимательность и аккуратность с каждым устройством <?=$marka?></span><p>Вам повезло стать обладателем техники <?=$marka?>, которая славится по всему миру своей надежностью и всегда популярна.
                        Но если вы заподозрили поломку любимого гаджета, то не нужно расстраиваться. Наши мастера высоко квалифицированы и найдут подход к любому вашему устройству, к каждой модели <?=$marka?>! Мы любим свою работу.</p>
                    <?else:?>
                        <span class="h2">Внимательность и аккуратность с каждым устройством <?=$marka?></span><p>Вам повезло стать обладателем техники <?=$marka?>, которая славится по всему миру своей надежностью и всегда популярна.
                        Но если вы заподозрили поломку любимого гаджета, то не нужно расстраиваться. Наши мастера высоко квалифицированы и найдут подход к любому вашему устройству, к каждой модели <?=$marka?>! Мы проведём все необходимые манипуляции - от диагностики и замены неисправной части, до чистки от пыли,
                        сборки и передачи вам в руки отлично работающего устройства. Мы любим свою работу.</p>
                    <?endif;?>

                    <?
                    $left = '';
                    $right = '';
                    $i = 0;
                    //$this->_datas['all_devices']= array_unique($this->_datas['all_devices']);
                    //var_dump($this->_datas['all_devices']);foreach($ololo as $k => $v){\
            
                    foreach ($this->_datas['all_devices'] as $device)
                    {
                        $name = tools::mb_ucfirst($device['type_m'], 'utf-8', false);

                        $str = '<a href="/'.$accord[$device['type']].'/" class="experts-item-link">
                            <div class="experts-item container">
                                <div class="half">
                                    <img src="/userfiles/clauses/large/'.$accord_image[$device['type']].'-'.$marka_lower.'.png" alt="'.$name.'" title="'.$name.'">
                                </div>
                                <div class="half">
                                    <span>'.$name.'</span>';

                                    if ($asus_flag) $str .= '<!--noindex-->';

                                    $str .= '<p>'. str_replace('#device', $device['type_rm'], $vars[rand(0, count($vars)-1)]).'</p>';

                                    if ($asus_flag) $str .= '<!--/noindex-->';

                                    $str .= '<span class="btn btn--empty">подробнее</span>
                                </div>
                            </div>
                        </a>';

                        if ($i % 2 == 0)
                            $left .= $str;
                        else
                            $right .= $str;
                        $i++;
                    }
                    ?>
                    <div class="half"><?=$left;?></div>

                    <div class="half right"><?=$right;?></div>

                </div>

            </div>

        </section>

        <section class="help">
            <div class="fixed">

                <? if (!$asus_flag):?>
                    <span class="h2"><?=$ru_servicename?> – вы всегда знаете, куда обратиться!</span><p><?=$servicename?> не оставит вас в беде. Мы поможем наладить работу любого вашего гаджета <?=$ru_marka?> в самые короткие сроки! На все оказанные услуги действует фирменная гарантия от <?=$ru_servicename?>. </p>
                    <p>Помните, в мире еще не создано ничего вечного. Поэтому даже такой надежной и высококлассной технике как <?=$ru_marka?> необходимы забота пользователя и профилактика поломок. Если вы заметили неисправность вашего аппарата <?=$marka?>, то смело рассчитывайте на нашу помощь!</p>
                <?else:?>
                    <span class="h2"><?=$ru_servicename?> – вы всегда знаете, куда обратиться!</span><p><?=$servicename?> не оставит вас в беде. Мы поможем наладить работу любого вашего гаджета <?=$ru_marka?> в самые короткие сроки! На все оказанные услуги действует фирменная гарантия.</p>
                    <p>Помните, еще не создано ничего вечного. Поэтому даже такой надежной, высококлассной технике как <?=$ru_marka?> необходимы забота пользователя и профилактика поломок. Если вы заметили неисправность вашего аппарата, то смело рассчитывайте на нашу помощь!</p>
                <?endif;?>

                <img src="/img/woman.png" width="289" height="308" alt="<?=$servicename?> - сервисный центр <?=$ru_marka?>" title="<?=$servicename?> - сервисный центр <?=$ru_marka?>">
            </div>
        </section>

        <section class="prefMain">
        <div class="fixed">
         <div class="block-new">
             <span class="h2">Сервис со знаком качества</span>
             <div class="pref">
                <a href="/delivery/">Выезд курьера</a>
                <p>Курьерская доставка в сервисный центр из любой точки <?=$this->_datas['region']['name_re']?>.</p>
             </div>
             <div class="pref">

                <? if (!$asus_flag):?>
                    <a href="diagnostics/">Диагностика за 15 минут</a>
                    <p>Выявление неисправности устройства в кратчайшие сроки.</p>
                <?else:?>
                    <a href="diagnostics/">Тестирование за 15 минут</a>
                    <p>Выявление неисправности за минимальные сроки.</p>
                <?endif;?>

             </div>
             <div class="pref last">
                    <a href="/services/">Срочный ремонт</a>
                    <? if (!$asus_flag):?>
                        <p>Экспресс ремонт за 1-2 часа. Комплектующие в наличии.</p>
                     <?else:?>
                        <p>Экспресс ремонт за 1-2 часа. Комплектующие на складе сервиса.</p>
                     <?endif;?>
             </div>

            <div class="clear"></div>

            <!--noindex--><a href="/order/"  class="btn btn--fill">Записаться на ремонт</a><!--/noindex-->
          </div>
        </div>
        </section>
