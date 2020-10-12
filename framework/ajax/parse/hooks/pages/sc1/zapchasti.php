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

<div class="sr-main zapchasti-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
             <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
             &nbsp;/&nbsp;
             <span class="uk-text-muted">Запчасти</span>
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
                <h1>Оригинальные комплектующие</h1>
                <ul class="list-blue-marker">
                    <li>Фирменные запчасти <?=$marka?></li>
                    <li>Лицензионный софт</li>
                    <li>Гарантия на обслуживание до 3 лет</li>
                    <li>Более 10000 комплектующих <?=$marka?> в наличии</li>
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
                    <img src="/wp-content/uploads/2015/03/imgContent-Parts-2.jpg" class="uk-align-right uk-margin-bottom-remove uk-hidden-small uk-hidden-medium">
                    <p>На нашем складе в наличие более 10000 единиц комплектующих для ремонта и обслуживания самых востребованных моделей.</p>
                    <ul class="list-blue-marker var2">
                        <li><a href="/ceny/">Цены на услуги</a></li>
                        <li><a href="/sroki/">Время ремонта</a></li>
                    </ul>
                </div>
                <hr>
                <p class="uk-h2">Выезд курьера – бесплатно<span class="reder">*</span></p>

                <p>Большинство услуг по ремонту техники, замене модулей и комплектующих возможно провести только в сервисном центре. Сервисный центр оборудован специальным диагностическим и ремонтным оборудованием, для оказания услуг любой сложности. На складе есть запчасти для большинства популярных моделей техники <?=$marka?>.</p>

                <p class="uk-h2">Комплектующие <?=$marka?></p>
                <p>Обслуживание техники <?=$marka?> мы осуществляем только на основе оригинальных комплектующих, за исключением случаев, когда аналоговая комплектующая устанавливается на устройство по требованию клиента. Аналоговые, неоригинальные комплектующие существенно различаются и по цене, по качеству: во избежание некорректной работы вашего аппарата прежде, чем приобрести ту или иную запчасть, мы рекомендуем проконсультироваться со специалистами <?=$marka?>.</p>

                <p class="uk-h2">Оригинальное ПО</p>
                <p>Сервисный центр <?=$marka?> работает только с оригинальными программными продуктами. Это позволяет настраивать технику на длительную и стабильную работу. Кроме того, это важный аспект безопасности, который защищает ваши файлы и персональные данные от внешних угроз.</p>


                <img src="/wp-content/uploads/2015/03/imgContent-Parts.jpg" width="100%" height="auto">
                <!--<p>Обращаясь в <?=$servicename?>, вам не нужно беспокоиться о приобретении программного обеспечения – все необходимые программы будут с собой у нашего специалиста, который приедет к вам на дом или в офис.</p>-->
				<p>
					<span class="reder">*</span> Выезд курьера - бесплатно. В случае обратной доставки стоимость составляет 500 руб в пределах МКАД. Условия выезда курьеров за МКАД уточняйте у сотрудников компании по телефону: <a href="tel:+<?=$phone?>"><?=$phone_format?></a>
				</p>
			</div>
            <? include __DIR__.'/rightPart2.php'; ?>
        </div>
    </div>
</div>