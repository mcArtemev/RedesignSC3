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
//if ($this->_datas['site_name']=='tul-bosch.russia-centre.com')var_dump($this->_datas['arg_url']);
include ('isDigitalImg.php');
?>

<div class="sr-main diagnostika-img">
    <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
        <div class="uk-container-center uk-container">
             <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
             &nbsp;/&nbsp;
             <span class="uk-text-muted">Экспресс диагностика</span>
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
                <h1>Экспресс диагностика</h1>
                <ul class="list-blue-marker">
                    <li>Оперативное тестирование техники</li>
                    <? if (!$this->_datas['sdek']):?>
                        <li>Срочная диагностика занимает от 15 до 40 мин</li>
                    <?else:?>
                        <li>Срочная диагностика</li>
                    <?endif;?>
                    <li>Аппаратная или программная диагностика</li>
                    <li>Безопасная процедура тестирования</li>
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
                    <img src="/wp-content/uploads/2015/03/imgContent-Diagnostics-2.jpg" class="uk-align-right uk-margin-bottom-remove uk-hidden-small uk-hidden-medium">
                    <p>Только по результатам диагностики можно выявить причину неисправности и определить сроки и стоимость проведения необходимых ремонтных работ.</p>
                    <ul class="list-blue-marker var2">
                        <li><a href="/zapchasti/">Оригинальные комплектующие</a></li>
                        <li><a href="/ceny/">Цены на ремонт</a></li>
                    </ul>
                </div>
                <hr>
                <p class="uk-h2">Диагностика техники – бесплатно
            
                <span class="reder">*</span></p>

                <p>Перед проведением ремонтных работ специалист выполняет диагностику программными или аппаратными средствами.</p>
                <? if ($isDigital):?>
                    <img src="<?=$imgDigital_SC1?>" width="100%" height="auto">
                <? else:?>
                    <img src="<?=$imgDigital_SC1b?>" width="100%" height="auto">   
                <? endif;?>
                <p>В случае выполнения единичной услуги (установка программ, увеличение оперативной памяти и т.д.), не связанной с выявлением неисправности аппарата, специалист произведет осмотр вашей техники, обозначит стоимость и приступит к выполнению работ.</p>
				<p>
					<span class="reder">*</span>&nbsp;
                    
                    <?if ($this->_datas['region']['name'] == 'Москва' || $this->_datas['region']['name'] == 'Санкт-Петербург' || $this->_datas['region']['name'] == 'Нижний Новгород'):?>
					Стоимость диагностики при отказе от ремонта или его невозможности (руб): телефоны – 500, планшеты – 500, ноутбуки – 1000, другие виды техники – 1000. При поступлении устройства в сервис производится программная диагностика, которая занимает от 15 до 40 минут. При невозможности выявить причину поломки программным методом, проводится аппаратная диагностика, которая в среднем занимает от 1 до 3-х дней.
                    <?else:?>
                    При проведении ремонта диагностика бесплатна. В случае если ремонт не потребуется условия проведения диагностики уточняйте у сотрудников сервисного центра.
                    <?endif;?>				
                </p>
			</div>
            <? include __DIR__.'/rightPart2.php'; ?>
        </div>
    </div>
</div>
