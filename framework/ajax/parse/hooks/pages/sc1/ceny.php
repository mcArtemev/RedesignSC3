<?
use framework\tools;
use framework\ajax\parse\parse;

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
$metrica = $this->_datas['metrica'];
//$address = $this->_datas['partner']['address1'];

$accord = $this->_datas['accord'];

//srand($this->_datas['feed']);

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";

?>


<div class="sr-main ceny-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
            &nbsp;/&nbsp;
            <span class="uk-text-muted">Цены</span>
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
                <h1>Обслуживание <?=$marka?> &ndash; Цены</h1>
                <ul class="list-blue-marker">
                    <li>Бесплатная диагностика техники</li>
                    <li>Выезд курьера по <?=$region_name_de?></li>
                    <li>Подробный перечень услуг</li>
                    <li>Гарантия на выполненные работы</li>
                </ul>
                <p><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="sr-content">
    <div class="uk-container-center uk-container uk-margin-bottom">
        <div class="uk-flex sr-contetnt-block uk-margin-top">
            <div class="uk-width-large-7-10 sr-content-white ">
                <? foreach ($this->_datas['all_devices'] as $devices)
                { 
                    $parse = new parse(array('site' => $this->_datas['site_name'], 'url' => $accord[$devices['type']])); 
                    $body = unserialize(($parse->getWrapper()->getChildren(0)));
                    preg_match('|(<p class="uk-h2 uk-margin-top">)(.*?)(</p>)|s', $body['body'], $array2);
                    preg_match('|(<table class="priceTable)(.*?)(>)(.*?)(</table>)|s', $body['body'], $array);
                    echo $array2[0];
                    echo $array[0];
                    
                    echo '<hr>';
                }  
                ?>               
                <p><a href="/kontakty/">Адрес центра Russia Expert</a></p>
            </div>
            <? include __DIR__.'/rightPart2.php'; ?>
        </div>
    </div>
</div>

