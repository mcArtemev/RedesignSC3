<?

use framework\tools;

$site_id = $this->_site_id;

if ($this->_mode)
{
    $model_type = $this->_datas['model_type'][3];
}

$model_type_id = $this->_datas['model_type']['id'];

$marka_id = $this->_datas['marka']['id'];

if ($this->_mode == 2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
}

if ($this->_mode == 3)
{
    $full_name = $full_type_name = $model_type['name_re'].' '.$this->_datas['marka']['name'];
}

if ($this->_mode == 0)
{
    $full_name = $full_type_name = $this->_datas['marka']['name'];
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables'];

$vals = $this->_datas['vals'];

if ($this->_mode)
{
    $service_name = tools::mb_firstupper($vals['name']);
    $service_time = tools::format_time($vals['time_min'], $vals['time_max'], $eds[$this->_datas['id']]['ed_time'], $setka_name);
    $service_price = tools::format_price($vals['price'], $setka_name);
}
else
{
    $service_name = tools::mb_firstupper($this->_datas['syns'][3]);
    $service_price = tools::format_price($this->_datas['price'], $setka_name);
}

$complect_to_services = isset($this->_datas['complect_to_services']) ? $this->_datas['complect_to_services'] : array();
$dop_defects = isset($this->_datas['dop_defects']) ? $this->_datas['dop_defects'] : array();
$other_services = isset($this->_datas['other_services']) ? $this->_datas['other_services'] : array();
$region_code = ($this->_datas['region']['code']) ? '-'.$this->_datas['region']['code'] : '';

$accord_image = $this->_datas['accord_image'];
$this->_ret['img'] = 'wp-content/uploads/2015/03/'.$marka_lower.'/'.$accord_image[$this->_datas['orig_model_type']['0']['name']].$region_code.'.png';
$metrica = $this->_datas['metrica'];

srand($this->_datas['feed']);

// Услуги М
if ($this->_mode == 2)
{
    $dat_vin = tools::skl('complect', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'vin');
    $dat = tools::skl('complect', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'vin');
    $dat_rod = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'rp');
    $dat_dat = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'dat');
    $syns = $this->_datas['syns'][rand(0, 3)]; // название услуги , 4 варианта
    $model_name = $this->_datas['model']['name']; // название модели
    $dat_tp = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'tp');
    $model_type = $this->_datas['model_type'][3]['name']; // тип устройства
    $model_type_of = $this->_datas['model_type'][3]['name_rm']; // тип устройства
    $address = $this->_datas['partner']['address1']; // Адрес
    $region_name = $this->_datas['region']['name'];//Москва

    $generate_h2 = array();
    $generate_h2[0][] = array(
        "Стоимость $dat_rod",
        "$syns - стоимость",
        "Стоимость услуг по $dat_dat",
        "Стоимость работ по $dat_dat",
        "$syns - цена",
        "$syns - цены",
        "Цена $dat_rod",
        "Цена на услугу по $dat_dat",
        "Цены $dat_rod",
        "Цены на услугу по $dat_dat",
        "Цена на услуги по $dat_dat"
    );
    $generate_h2[0][] = array($model_name, "");
    $generate_h2[1][] = array("Дополнительная информация", "Информация об услуге", "Дополнительная информация об услуге", "Информация о данной услуге",
        "Дополнительная информация о $model_name");
    $generate_h2[2][] = array("Информация о причинах неисправности,", "Информация о причинах неисправности,", "Информация о причинах появления проблемы,",
        "Информация о причинах данной неисправности,", "Информация о причинах возникновения неисправности,", "Информация о причинах данной проблемы,");
    $generate_h2[2][] = array("связанная с");
    $generate_h2[2][] = array($dat_tp);
    $generate_h2[3][] = array("", "Возможные", "Частые", "Распространенные", "Основные");
    $generate_h2[3][] = array("причины выхода из строя");
    $generate_h2[3][] = array($model_name);
    $generate_h2[4][] = array("Причины неисправности,", "Симптомы неисправности,", "Возможные причины неисправности,", "Частые симптомы неисправности,",
        "Популярные симптомы неисправности,", "Популярные причины неисправности,", "Частые причины неисправности,", "Причины возникновения неисправности,",
        "Симптомы возникновения неисправности,", "Причины появления неисправности,", "Симптомы появления неисправности,", "Причины возникновения проблемы,",
        "Симптомы возникновения проблемы,", "Причины проблемы,", "Симптомы проблемы,", "Возможные причины проблемы,", "Частые симптомы проблемы,",
        "Популярные симптомы проблемы,", "Популярные причины проблемы,", "Частые причины проблемы,", "Причины возникновения проблемы,", "Симптомы возникновения проблемы,",
        "Причины появления проблемы,", "Симптомы появления проблемы,", "Причины данной неисправности,", "Симптомы данной неисправности,", "Возможные причины данной неисправности,",
        "Частые симптомы данной неисправности,", "Популярные симптомы данной неисправности,", "Популярные причины данной неисправности,", "Частые причины данной неисправности,",
        "Причины возникновения данной неисправности,", "Симптомы возникновения данной неисправности,", "Причины появления данной неисправности,", "Симптомы появления данной неисправности,",
        "Причины возникновения данной проблемы,", "Симптомы возникновения данной проблемы,", "Причины данной проблемы,", "Симптомы данной проблемы,", "Возможные причины данной проблемы,",
        "Частые симптомы данной проблемы,", "Популярные симптомы данной проблемы,", "Популярные причины данной проблемы,", "Частые причины данной проблемы,", "Причины возникновения данной проблемы,",
        "Симптомы возникновения данной проблемы,", "Причины появления данной проблемы,", "Симптомы появления данной проблемы,");
    $generate_h2[4][] = array("связанные с");
    $generate_h2[4][] = array($dat_tp);
    $generate_h2[5][] = array("Другие", "Самые", "");
    $generate_h2[5][] = array("популярные", "распространенные", "востребованные", "часто востребованные");
    $generate_h2[5][] = array("услуги", "работы");
    $generate_h2[5][] = array("по ремонту", "по восстановлению работоспособности");
    //$generate_h2[5][] = array("тип устройства", "");
    $generate_h2[5][] = array($model_type_of,"");
    $generate_h2[5][] = array($model_name);

    $generate_h2_1 = $this->checkarray($generate_h2[0]);
    $generate_h2_2 = $this->checkarray($generate_h2[1]);
    $generate_h2_rand = rand(1, 3);

    if ($generate_h2_rand == 1) {
        $generate_h2_3 = $this->checkarray($generate_h2[2]);
    }

    if ($generate_h2_rand == 2) {
        $generate_h2_3 = $this->checkarray($generate_h2[3]);
    }

    if ($generate_h2_rand == 3) {
        $generate_h2_3 = $this->checkarray($generate_h2[4]);
    }

    $generate_h2_4 = $this->checkarray($generate_h2[5]);

    // Создаём добавку для Услуги М
    $service_additive_m = array();
    $service_additive_m_title = $this->_datas['add_title'];
    $service_additive_m_rand =rand(1,2);
    if($service_additive_m_rand == 1)
    {
        $service_additive_m[0][] = array("Осуществляем","Производим","Проводим","Выполняем");
        $service_additive_m[1][] = array("любые работы:","работы любого уровня сложности:","работы любой сложности:","работы любого типа сложности","работы любого вида сложности:","работы любого вида:",
            "работы любого вида:","работы любой степени сложности:","работы любого характера:","работы любого вида:","работы любого класса:","работы любого типа:","работы любой категории сложности:");
        $service_additive_m[1][] = array($service_additive_m_title);
        $service_additive_m[1][] = array("и оказываем","и производим","и проводим","и выполняем");
        $service_additive_m[1][] = array("другие","все другие");
        $service_additive_m[1][] = array("ремонтные и диагностические","диагностические и ремонтные");
        $service_additive_m[1][] = array("услуги.","сервисных услуг.");
    }
    if($service_additive_m_rand == 2)
    {
        $service_additive_m[0][] = array("Оказываем","Производим","Проводим","Выполняем");
        $service_additive_m[1][] = array("любые услуги:","услуги любого уровня сложности:","услуги любой сложности:","услуги любого типа сложности","услуги любого вида сложности:",
            "услуги любого вида:","услуги любого вида:","услуги любой степени сложности:","услуги любого характера:","услуги любого вида:","услуги любого класса:","услуги любого типа:","услуги любой категории сложности:");
        $service_additive_m[1][] = array($service_additive_m_title);
        $service_additive_m[1][] = array("и осуществляем","и производим","и проводим","и выполняем");
        $service_additive_m[1][] = array("другие","все другие");
        $service_additive_m[1][] = array("виды ремонтных и диагностических");
        $service_additive_m[1][] = array("работ.","сервисных работ.");
    }

    $service_additive_m_conclusion = "";
    $service_additive_m_conclusion_comparison = $this->checkcolumn($service_additive_m[0][0]);


    $service_additive_m[2][] = array("Для ремонта","Для обслуживания","Для ремонта и обслуживания","Для обслуживания и ремонта","Для проведения ремонтных работ");
    $service_additive_m[2][] = array("вы можете ");
    $service_additive_m[2][] = array("подъехать","приехать","привозить $model_type","привозить ваш $model_type");
    if (!$this->_datas['partner']['exclude']) {
		$service_additive_m[2][] = array("к нам:","по адресу:","к нам по адресу:");
		$service_additive_m[2][] = array("$region_name, $address.");
	} else {
		$service_additive_m[2][] = array("к нам.");
	}
    if ($service_additive_m_conclusion_comparison == "Производим")
    {
        unset($service_additive_m[1][2][array_search("и производим", $service_additive_m[1][2])]);
    }
    if ($service_additive_m_conclusion_comparison == "Проводим")
    {
        unset($service_additive_m[1][2][array_search("и проводим", $service_additive_m[1][2])]);
    }
    if ($service_additive_m_conclusion_comparison == "Выполняем")
    {
        unset($service_additive_m[1][2][array_search("и выполняем", $service_additive_m[1][2])]);
    }

    $service_additive_m_conclusion .= $service_additive_m_conclusion_comparison . " " .  $this->checkarray($service_additive_m[1]) . " " . $this->checkarray($service_additive_m[2]);

}

// Услуги Т
if ($this->_mode == 3)
{
    $dat = tools::skl('complect', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'vin');
    $syns = $this->_datas['syns'][rand(0, 3)]; // название услуги , 4 варианта
    $marka = $this->_datas['marka']['name'];  // SONY
    $ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
    $model_type_re = $this->_datas['model_type'][3]['name_rm'];
    $dat_dat = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'dat');
    $dat_rod = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'rp');
    $dat_tp = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'tp');

    $generate_t_h2 = array();
    $generate_t_h2[0][] = array(
        "Стоимость $dat_rod",
        "$syns - стоимость",
        "Стоимость услуг по $dat_dat",
        "Стоимость работ по $dat_dat",
        "$syns - цена",
        "$syns - цены",
        "Цена $dat_rod",
        "Цена на услугу по $dat_dat",
        "Цены $dat_rod",
        "Цены на услугу по $dat_dat",
        "Цена на услуги по $dat_dat"
    );
    $generate_t_h2[0][] = array($marka,$ru_marka, "");
    $generate_t_h2[1][] = array("Дополнительная информация","Информация об услуге","Дополнительная информация об услуге",
        //"Информация о $model_type_re",
        //"Дополнительная информация о $model_type_re"
    );
    $generate_t_h2[2][] = array("Информация о причинах неисправности,","Информация о причинах неисправности,","Информация о причинах появления проблемы,",
        "Информация о причинах данной неисправности,","Информация о причинах возникновения неисправности,","Информация о причинах данной проблемы,");
    $generate_t_h2[2][] = array("связанная с");
    $generate_t_h2[2][] = array($syns);
    $generate_t_h2[3][] = array("","Возможные","Частые","Распространенные","Основные");
    $generate_t_h2[3][] = array("причины выхода из строя");
    $generate_t_h2[3][] = array($model_type_re,"$model_type_re $marka");
    $generate_t_h2[4][] = array("Причины неисправности,","Симптомы неисправности,","Возможные причины неисправности,","Частые симптомы неисправности,",
        "Популярные симптомы неисправности,","Популярные причины неисправности,","Частые причины неисправности,","Причины возникновения неисправности,",
        "Симптомы возникновения неисправности,","Причины появления неисправности,","Симптомы появления неисправности,","Причины возникновения проблемы,",
        "Симптомы возникновения проблемы,","Причины проблемы,","Симптомы проблемы,","Возможные причины проблемы,","Частые симптомы проблемы,","Популярные симптомы проблемы,",
        "Популярные причины проблемы,","Частые причины проблемы,","Причины возникновения проблемы,","Симптомы возникновения проблемы,","Причины появления проблемы,",
        "Симптомы появления проблемы,","Причины данной неисправности,","Симптомы данной неисправности,","Возможные причины данной неисправности,",
        "Частые симптомы данной неисправности,","Популярные симптомы данной неисправности,","Популярные причины данной неисправности,","Частые причины данной неисправности,",
        "Причины возникновения данной неисправности,","Симптомы возникновения данной неисправности,","Причины появления данной неисправности,","Симптомы появления данной неисправности,",
        "Причины возникновения данной проблемы,","Симптомы возникновения данной проблемы,","Причины данной проблемы,","Симптомы данной проблемы,","Возможные причины данной проблемы,",
        "Частые симптомы данной проблемы,","Популярные симптомы данной проблемы,","Популярные причины данной проблемы,","Частые причины данной проблемы,",
        "Причины возникновения данной проблемы,","Симптомы возникновения данной проблемы,","Причины появления данной проблемы,","Симптомы появления данной проблемы,");
    $generate_t_h2[4][] = array("связанные с");
    $generate_t_h2[4][] = array($dat_tp);
    $generate_t_h2[5][] = array("Другие","Самые","");
    $generate_t_h2[5][] = array("популярные","распространенные","востребованные","часто востребованные");
    $generate_t_h2[5][] = array("услуги","работы");
    $generate_t_h2[5][] = array("по ремонту","по восстановлению работоспособности");
    $generate_t_h2[5][] = array($model_type_re,"");

    $generate_t1 = $this->checkarray($generate_t_h2[0]);
    $generate_t2 = $this->checkarray($generate_t_h2[1]);
    $generate_t_a = rand(1,3);
    if($generate_t_a == 1)
    {
        $generate_t3 = $this->checkarray($generate_t_h2[2]);
    }
    if($generate_t_a == 2)
    {
        $generate_t3 = $this->checkarray($generate_t_h2[3]);
    }
    if($generate_t_a == 3 )
    {
        $generate_t3 = $this->checkarray($generate_t_h2[4]);
    }

    $generate_t4 = $this->checkarray($generate_t_h2[5]);
}

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";

?>

    <div class="sr-main target">
        <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
            <div class="uk-container-center uk-container">
                <? if ($this->_mode == 2): ?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model']['name']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span class="uk-text-muted"><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
                <? endif; ?>
                 <? if ($this->_mode == 3): ?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span class="uk-text-muted"><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
                <? endif; ?>
            </div>
        </div>

        <div class="uk-width-medium-1-1 bgcolorwhite uk-visible-small<?=$add_class?>">
            <div class="uk-container-center uk-container">
               <a href="tel:+<?=$phone?>" class="uk-text-muted"><?=$phone_format?></a>
            </div>
        </div>

        <div class="uk-container-center uk-container" itemscope itemtype="http://schema.org/Product">
            <div class="uk-grid uk-margin-remove" data-uk-grid-margin>
                <div class="uk-width-medium-4-10 ">
                    <img itemprop="image" src="/<?=$this->_ret['img']?>" class="uk-margin-top uk-align-center">
                </div>
                <div class="uk-width-medium-6-10 whiteblock ">
                    <h1 itemprop="name"><?=$this->_ret['h1']?></h1>
                    <span itemprop="description">
                      <?php
                        include "text/service.php";
                        $genText = false;
                        if (isset($serviceText) && is_array($serviceText)) {
                          $type = $this->_datas['orig_model_type'][0]['name_m'];
                          $serviceNames = $this->_datas['syns'];
                          $serviceNames[] = @$this->_datas['vals']['min_model']['name'];
                          foreach ($serviceNames as $service) {
                            if (isset($serviceText[$type][$service])) {
                              foreach ($serviceText[$type][$service] as $p) {
                                echo "<p>$p</p>";
                              }
                              $genText = true;
                              break;
                            }
                          }
                        }
                        if (!$genText) {
                          echo $this->_ret['text'];
                        }
                      ?>
                    </span>
                    <p class="textPrice" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <span class="uk-align-left uk-text-large target-price" itemprop="price"><?=$service_price?> руб.</span>
                        <meta itemprop="priceCurrency" content="RUB"/>
                        <span class="uk-align-right"><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="sr-content">
        <div class="uk-container-center uk-container uk-margin-bottom">
            <div class="uk-flex sr-contetnt-block uk-margin-top sr-content-main">
                <div class="uk-width-large-7-10 sr-content-white ">
                    <p class="uk-h2 uk-margin-top">
                        <?
                        if ($this->_mode == 2)
                        {
                            echo $this->firstup(trim($generate_h2_1));
                        }
                        if ($this->_mode == 3)
                        {
                            echo $generate_t1;
                        }
                        ?>

                    </p>
                    <table class="priceTable uk-table uk-table-hover uk-table-striped services">
                        <tbody>
                            <tr class="uk-text-small green">
                                <th>Наименование услуги</th>
                                <th class="uk-text-center">Время ремонта, мин</th>
                                <th class="uk-text-center">Цена, руб</th>
                            </tr>
                                <td><?=$service_name?></td>
                                <td><?=$service_time?></td>
                                <td><?=$service_price?></td>
                            </tr>
                        </tbody>
                    </table>

                    <? if ($complect_to_services):?>
                      <table class="priceTable uk-table uk-table-hover uk-table-striped">
                            <tbody>
                                <tr class="uk-text-small">
                                    <th>Наименование оборудования</th>
                                    <th class="uk-text-center">Статус</th>
                                    <th class="uk-text-center">Цена, руб</th>
                                </tr>
                                <? foreach ($complect_to_services as $value):?>
                                <?
                                 if ($this->_mode == 2)
                                    $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));

                                 if ($this->_mode == 3)
                                    $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'complect', 'id' => $value[$this->_suffics.'_complect_id'])));
                                ?>
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                    <td><?=$availables[$value['available_id']]['name']?></td>
                                    <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                                </tr>
                            <? endforeach;?>
                      </table>
                    <? endif; ?>

                    <? include __DIR__.'/form_new.php'; ?>

                    <p class="uk-h2 uk-margin-medium-top">
                        <?
                        if ($this->_mode == 2)
                        {
                            echo $this->firstup(trim($generate_h2_2));
                        }
                        if ($this->_mode == 3)
                        {
                            echo $this->firstup(trim($generate_t2));
                        }
                        ?>
                    </p>

                    <? if ($dop_defects):?>
                        <? if ($this->_mode == 2) echo '<p>'.$service_additive_m_conclusion.'</p>'; ?>
                        <p class="uk-h3">
                            <?
                            if ($this->_mode == 2)
                            {
                                echo $this->firstup(trim($generate_h2_3));
                            }
                            if ($this->_mode == 3)
                            {
                                echo $this->firstup(trim($generate_t3));
                            }
                            ?>
                        </p>
                        <div class="uk-grid uk-grid-small uk-grid-match popular" data-uk-grid-margin="" data-uk-grid-match="{target:'.uk-panel'}" >
                        <? foreach ($dop_defects as $key => $value):?>
                            <?
                            if ($this->_mode == 2)
                                $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));

                            if ($this->_mode == 3)
                                $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'defect', 'id' => $value[$this->_suffics.'_defect_id'])));
                            ?>
                                <div class="uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2">
                                   <div class="uk-panel uk-panel-box uk-text-center uk-grid-match uk-vertical-align">
                                        <a class="uk-vertical-align-middle" href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a>
                                    </div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    <? endif;?>

                    <? if ($other_services) :?>
                        <p class="uk-h3 uk-margin-medium-top">
                            <?
                            if ($this->_mode == 2)
                            {
                                echo $this->firstup(trim($generate_h2_4));
                            }
                            if ($this->_mode == 3)
                            {
                                echo $this->firstup(trim($generate_t4));
                            }
                            ?>
                        </p>
                        <table class="priceTable uk-table uk-table-hover uk-table-striped services">
                        <tbody>
                            <tr class="uk-text-small">
                                <th>Наименование услуги</th>
                                <th class="uk-text-center">Время ремонта, мин</th>
                                <th class="uk-text-center">Цена, руб</th>
                            </tr>
                            <? foreach ($other_services as $value):?>
                               <tr>
                                    <td><?=tools::mb_firstupper($value['name'])?></td>
                                    <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time'], $setka_name);?></td>
                                    <td><?=tools::format_price($value['price'], $setka_name);?></td>
                               </tr>
                            <? endforeach; ?>
                         </tbody>
                        </table>
                    <? endif; ?>
                    <?
                        if ($this->_mode == 2)
                            $href = tools::search_url($site_id, serialize(array('model_id' => $model_id)));

                        if ($this->_mode == 3)
                            $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)));
                      ?>
                      <div class="uk-panel uk-panel-box uk-text-center">
                            <a href="/<?=$href?>/">Все комплектующие и услуги по ремонту <?=$full_name?></a>
                     </div>
                </div>
                <? include __DIR__.'/right_part_new.php'; ?>
            </div>
        </div>
    </div>
