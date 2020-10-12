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

?>

<div class="sr-main dostavka-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
             <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
             &nbsp;/&nbsp;
             <span class="uk-text-muted">Выезд и доставка</span>
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
                <h1>Доставка и выезд на дом</h1>
                <ul class="list-blue-marker">
                    <li>Выезд курьера по <?=$region_name_de?> на дом или в офис</li>
                    <li>Доставка оборудования в сервисный центр – бесплатно!</li>
                    <!--<li>Опытные выездные инженеры</li>-->
                    <!--<li>Выездное обслуживание в случае незначительных поломок</li>-->
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
                    <img src="/wp-content/uploads/2015/03/imgContent-Delivery-2.jpg" class="uk-align-right uk-margin-bottom-remove uk-hidden-small uk-hidden-medium">
                    <p>Выезд курьера осуществляется в заранее согласованное время.<br><br>Время реагирования курьера от 1 часа.<br><br>Более детальную информацию вы можете получить у наших менеджеров.</p>
                    <ul class="list-blue-marker var2">
                        <li><a href="/diagnostika/">Экспресс диагностика</a></li>
                        <li><a href="/ceny/">Цены на услуги сервиса</a></li>
                    </ul>
                </div>
                <hr>
                <p class="uk-h2">Выезд курьера – бесплатно<span class="reder">*</span></p>

                <p>Большинство услуг по ремонту техники, замене модулей и комплектующих возможно провести только в сервисном центре. Сервисный центр оборудован специальным диагностическим и ремонтным оборудованием, для оказания услуг любой сложности. На складе есть запчасти для большинства популярных моделей техники <?=$marka?>.</p>

                <p class="uk-h2">Доставка в сервисный центр</p>
                <p>Аппаратный ремонт техники мы производим только в стационарных условиях сервисного центра. Ремонт осуществляет на профессиональном оборудовании с соблюдением необходимых стандартов. Для большинства распространенных моделей <?=$marka?> требуемые комплектующие имеются в наличии.</p>


                <img src="/wp-content/uploads/2015/03/imgContent-Delivery.jpg" width="100%" height="auto">
                <p>Вы можете оставить заявку на выезд курьера. Курьер приедет в любую точку <?=$region_name_re?> в оговоренное вами время. Время реагирования курьера – от 1 часа. <br><br>За подробной информацией обращайтесь к нашим менеджерам.</p>
				<p>
					<span class="reder">*</span> Выезд курьера - бесплатно. В случае обратной доставки стоимость составляет 500 руб в пределах <?=(($region_name == 'Москва') ? 'МКАД' : 'города')?>. 
                                Условия выезда курьеров за <?=(($region_name == 'Москва') ? 'МКАД' : 'город')?> уточняйте у сотрудников компании по телефону: 
                                    <a href="tel:+<?=$phone?>"><?=$phone_format?></a>.
				</p>
			</div>
            <? include __DIR__.'/rightPart2.php'; ?>
        </div>
    </div>
</div>
