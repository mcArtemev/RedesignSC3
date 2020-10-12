<?

use framework\ajax\parse\parse;

$marka = $this->_datas['marka']['name'];
$servicename = $this->_datas['servicename'];
$ru_servicename = $this->_datas['ru_servicename'];
$ru_marka = $this->_datas['marka']['ru_name'];
$feed = $this->_datas['feed'];
$region_name_pe = $this->_datas['region']['name_pe'];
srand($feed);
$vars = array('Услуги по ремонту', 'Прайслист по ремонту', 'Сервисное обслуживание', 'Обслуживание');

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

$accord = $this->_datas['accord'];

?>
    <section class="fixed content-wrapper">
            <div class="content-block">

                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span>Цены</span>
                </section>

                <div class="content-block__top">

                    <div class="info-block">

                        <h1>Цены</h1>

                        <img src="/userfiles/site/large/tseny.jpg" width="350" height="110" alt="Цены" title="Цены">

                        <ul class="list">
                            <!--
                            <li><span>Выезд курьера по <?=$this->_datas['region']['name_pe']?></span></li>
                            <li><span>Бесплатная диагностика</span></li>
                            <li><span>Цены на услуги <?=$servicename?></span></li>
                            <li><span>Сроки выполнения работ</span></li>-->
                            <?=$price_a?>
                        </ul>

                        <a href="/order/"  class="btn btn--fill">Записаться на ремонт</a>

                    </div>

                </div>
                <div class="divider divider--three"></div>

                <div class="content-block__bottom">

                    <div class="info-block">
                        <? foreach ($this->_datas['all_devices'] as $devices)
                        {
                            $str = $vars[rand(0, count($vars)-1)];
                            ?>
                            <p><span class="h2"><span><?=$str?> <?=$devices['type_rm']?> <?=$marka?></span></span></p>
                            

                          <? $parse = new parse(array('site' => $this->_datas['site_name'], 'url' => $accord[$devices['type']], 'realHost' => $this->_datas['realHost']));
                             $body = unserialize(($parse->getWrapper()->getChildren(0)));
                             preg_match('|(<table class="priceTable">)(.*?)(</table>)|s', $body['body'], $array);

                             echo $array[0];
                        }
                        ?>
                    </div>

                </div>

                <a href="/order/"  class="btn btn--fill">Записаться на ремонт</a>

            </div>

            <? include __DIR__.'/aside.php'; ?>

        </section>

        <div class="clear"></div>
