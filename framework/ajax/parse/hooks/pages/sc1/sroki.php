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
$metrica = $this->_datas['metrica'];
//$address = $this->_datas['partner']['address1'];

//srand($this->_datas['feed']);

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";
include ('isDigitalImg.php');
?>

<div class="sr-main sroki-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
             <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
             &nbsp;/&nbsp; 
             <span class="uk-text-muted">Сроки</span>
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
                <h1>Срочный ремонт от <?=$servicename?></h1>
                <ul class="list-blue-marker">
                    <li>Ремонт аппарата от 30 минут</li>
                    <li>Экспресс диагностика устройства от 15 до 40 минут!</li>
                    <li>Доставка оборудования в сервис центр от 1 часа</li>
                    <!--<li>Экстренный выезд специалиста по <?=$region_name_de?></li>-->
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
            <div class="uk-width-large-7-10 sr-content-white">
                <div class="uk-clearfix ">
                    <img src="/wp-content/uploads/2015/03/imgContent-Express-service-2.jpg" class="uk-align-right uk-margin-bottom-remove uk-hidden-small uk-hidden-medium">
                    <p>Обращаем внимание, что в большинстве случаев устранение типовых неисправностей в аппаратах <?=$marka?> осуществляется в режиме экспресс-обслуживания, т.е. в течение 24 часов с момента вашего обращения.</p>
                    <ul class="list-blue-marker var2">
                        <li><a href="/zapchasti/">Оригинальные комплектующие</a></li>
                        <li><a href="/ceny/">Цены на ремонт</a></li>
                    </ul>
                </div>
                <hr>
                <p class="uk-h2">Выезд курьера</p>

                <p>Мы осуществляем выезд курьера на дом или в офис. Это экономит время – курьер будет у вас уже в скором времени!</p>

                <p class="uk-h2">Ремонт в сервисном центре</p>
                <p>Когда характер неисправности требует ремонта в стационарных условиях, мы бесплатно доставляем ваш аппарат в сервисный центр. Доставка осуществляется в течение несколько часов. После доставки ваша техника сразу попадает к специалисту сервисного отдела, который и будет выполнять его ремонт.</p>
                <? if ($isDigital):?>
                    <img src="<?=$imgDigital_SC1?>" width="100%" height="auto">
                <? else:?>
                    <img src="<?=$imgDigital_SC1b?>" width="100%" height="auto">   
                <? endif;?>
                <p>Ремонтные работы в сервисном центре <?=$marka?> осуществляются на профессиональном оборудовании, что позволяет выполнять ремонт высочайшего уровня в самые короткие сроки. В наличии всегда имеется запас комплектующих и запчастей для наиболее востребованных моделей.</p>
            </div>
            <? include __DIR__.'/rightPart2.php'; ?>
        </div>
    </div>
</div>