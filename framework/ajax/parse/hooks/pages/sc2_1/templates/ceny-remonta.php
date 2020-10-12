<?

use framework\tools;

$marka = $this->_datas['marka']['name'];
$servicename = $this->_datas['servicename'];
$ru_servicename = $this->_datas['ru_servicename'];
$ru_marka = $this->_datas['marka']['ru_name'];
$feed = $this->_datas['feed'];
$region_name_pe = $this->_datas['region']['name_pe'];
srand($feed);
$vars = array('Услуги по ремонту', 'Прайслист по ремонту', 'Сервисное обслуживание', 'Обслуживание');

$setka_name = $this->_datas['setka_name'];

$price = array();
$price[] = array("Выезд курьера по $region_name_pe");
$price[] = array("Бесплатная диагностика");
$price[] = array("Цены на услуги $servicename");
$price[] = array("Сроки выполнения работ");

$price_a = "";
while ( 0 < count($price) )
{
    $price_in = array_rand($price, 1);

    $price_in_in = array_rand($price[$price_in], 1);
    $price_a .= "<li><span>" . $price[$price_in][$price_in_in] . "</span></li>";

    unset($price[$price_in]);

}

$accord = $this->_datas['typeUrl'];
$services = $this->_datas['services'];

?>
    <section class="fixed content-wrapper">
            <div class="content-block">

                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/servis-<?=$marka_lower?>/"><span itemprop="title">Cервис <?=$this->_datas['marka']['name']?></span></a></span>
                    <span> / </span>
                    <span>Цены <?=$marka?></span>
                </section>

                <div class="content-block__top">

                    <div class="info-block">

                        <h1><?=$this->_ret['h1']?></h1>

                        <amp-img src="/bitrix/templates/centre/img/site/large/tseny.jpg" width="350" height="110" alt="Цены" title="Цены">

                        <ul class="list">
                            <!--
                            <li><span>Выезд курьера по <?=$this->_datas['region']['name_pe']?></span></li>
                            <li><span>Бесплатная диагностика</span></li>
                            <li><span>Цены на услуги <?=$servicename?></span></li>
                            <li><span>Сроки выполнения работ</span></li>-->
                            <?=$price_a?>
                        </ul>

                        <a href="/zakaz/?brand=<?=$marka_lower?>"  class="btn btn--fill">Записаться на ремонт</a>

                    </div>

                </div>
                <div class="divider divider--three"></div>

                <div class="content-block__bottom">

                    <div class="info-block">
                        <? foreach ($this->_datas['all_devices'] as $device)
                        {
                          if (isset($services[$device['type_id']])) {
                          $f_name = tools::mb_ucfirst($device['type']).' '.$this->_datas['marka']['name'];
                            $str = $vars[rand(0, count($vars)-1)];
                            ?>
                            <p><span class="h2"><span><?=$str?> <?=$device['type_rm']?> <?=$marka?></span></span></p>
                            <table class="priceTable">
                            <tbody>
                                <tr>
                                    <td>Наименование работ</td>
                                    <td>Время работы, мин.</td>
                                    <td>Цена, р.</td>
                                    <td>&nbsp;</td>
                                </tr>
                        <?php foreach ($services[$device['type_id']] as $service) { ?>
                          <tr>
                              <td><?=($n = tools::mb_firstupper($service['name']))?></td>
                              <td><?=$service['time_repair']?></td>
                              <td><?=tools::format_price($service['cost'], $setka_name)?></td>
                              <!--noindex--><td><a href="/zakaz/?text=<?=urlencode($f_name.', '.$n)?>&brand=<?=$marka_lower?>&type=<?=$device['type']?>" class="order-btn">заказать со скидкой</a></td><!--/noindex-->
                          </tr>
                        <? } } ?>
                      </tbody>
                      </table>
                    <?php } ?>
                    </div>

                </div>

                <a href="/zakaz/?brand=<?=$marka_lower?>"  class="btn btn--fill">Записаться на ремонт</a>

            </div>

            <? include __DIR__.'/aside.php'; ?>

        </section>

        <div class="clear"></div>
