<?
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$marka_lower = mb_strtolower($marka);
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
$metrica = $this->_datas['metrica'];
//$address = $this->_datas['partner']['address1'];

//srand($this->_datas['feed']);

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";

?>

<div class="sr-main o-nas-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
             <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
             &nbsp;/&nbsp;
             <span class="uk-text-muted">О компании</span>
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
                <h1><?=$this->_ret['h1']?></h1>

                <p>Компания <?=$servicename?> – сеть сервисных центров по ремонту техники. Региональные филиалы компании
                            есть в областных центрах европейской части России и Зауралья. При первых признаках неполадок и сбоев в работе техники обращайтесь в наше ближайшее представительство.</p>

                <p>На все типы ремонта и новые запчасти распространяется гарантия.</p>

                <p><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="sr-content">
    <div class="uk-container-center uk-container uk-margin-bottom">
        <div class="uk-flex sr-contetnt-block uk-margin-top">
            <div class="uk-width-large-7-10 sr-content-white">
                <div class="uk-clearfix ">
                    <img src="/wp-content/uploads/2015/03/imgContent-O-nas-2.jpg" class="uk-align-right uk-margin-bottom-remove uk-hidden-small uk-hidden-medium">

                    <p>Заказывайте доставку курьером в сервисный центр. Типовой ремонт, обычно, не занимает дольше суток с момента обращения.</p>

                    <?

                    $str_device = array();
                    foreach ($this->_datas['all_devices'] as $device)
                         $str_device[] = $device['type_re'];

                    $str_device = tools::implode_or($str_device, 'или');
                    ?>

                    <p>Наши техэксперты окажут квалифицированную помощь в случае:</p>
                    <ul>
                        <li>поломки <?=$str_device?></li>
                        <li>необходимости замены комплектующих</li>
                        <li>потребности в корпусном ремонте</li>
                        <li>если нужно установить оригинальное ПО</li>
                    </ul>

                    <ul class="list-blue-marker var2">
                        <li><a href="/dostavka/">Выезд курьера и доставка</a></li>
                    </ul>

                </div>
                <hr>
                <p class="uk-h2">Новейшее оборудование</p>

                <p>Детальная диагностика устройств, их разборка и сборка выполняется на оборудованных для этого стендах в стерильных условиях. Верстаки для осмотра и инструмент для извлечения электросхем защищены от накопления статического заряда.</p>

                <?

                $laptop_o_nas = array('acer', 'alcatel', 'apple', 'asus', 'canon', 'dell', 'fly', 'hp',
                    'htc', 'huawei', 'lenovo', 'lg', 'meizu', 'msi', 'nikon', 'nokia', 'samsung',
                        'sony', 'toshiba', 'xiaomi', 'zte');

                if ($this->_datas['setka_name'] == 'СЦ-1' && in_array($marka_lower, $laptop_o_nas) && $this->_datas['region']['name'] == 'Москва'):

                    $numbers = array_merge(range(1, 4), range(6, 7), range(10, 12));
                    srand($this->_datas['feed']);
                    shuffle($numbers);

                    ?>

                    <p class="uk-h2">Наша команда</p>
                    <p>Для Вас старается опытный коллектив из консультантов, менеджеров, техэкспертов и работников службы доставки.</p>

                   <div class="uk-slidenav-position" data-uk-slider>

                        <div class="uk-slider-container">
                            <ul class="uk-slider uk-grid-width-medium-1-3">
                                <?foreach ($numbers as $number):?>
                                    <li><img src="/wp-content/uploads/2015/03/o-nas/foto<?=$number?>-cr.jpg"/></li>
                                <?endforeach;?>
                            </ul>
                        </div>

                        <span class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></span>
                        <span class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></span>
                    </div>

                <?endif;?>

            </div>
            <? include __DIR__.'/rightPart2.php'; ?>
        </div>
    </div>
</div>
