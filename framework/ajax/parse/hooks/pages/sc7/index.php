<?php

use framework\tools;
use framework\pdo;

$marka = $this->_datas['marka']['name'];  // SONY
$marka_id = $this->_datas['marka']['id'];
$marka_lower = mb_strtolower($marka);
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$marka_lower = mb_strtolower($marka);

$region_name = $this->_datas['region']['name'];//Москва
$region_name_eng = $this->_datas['region']['translit2'];//Moscow
$region_name_pril = $this->_datas['region']['pril_rp'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);

$metrica = $this->_datas['metrica'];
$site_id = $this->_site_id;
$setka_id = $this->_datas['setka_id'];
$setka_name = $this->_datas['setka_name'];

if($marka_lower =='apple'){
    $accord_menu = array('ноутбуков' => 'MacBook', 'смартфонов' => 'iPhone', 'планшетов' => 'iPad', 'моноблоков' => 'iMac');
}

$ustroista_all = "";

foreach ($all_deall_devices as $item)
{
    $ustroista_all .= $item['type_rm'] . ", ";
}
$ustroista_all = substr($ustroista_all,0,-2);


srand($this->_datas['feed']);

$pervii_abzatc = array();
$pervii_abzatc[0][] = array("Миссия","Назначение","Призвание","Основная миссия","Основное назначение","Основное призвание","Главная миссия");
$pervii_abzatc[0][] = array("$region_name_pril");
$pervii_abzatc[0][] = array("сервисного центра"); //"отделения","филиала"
$pervii_abzatc[0][] = array(""); // компании
$pervii_abzatc[0][] = array(mb_strtoupper($marka));
$pervii_abzatc[0][] = array("- это");
$pervii_abzatc[0][] = array("ремонт");
$pervii_abzatc[0][] = array("$ustroista_all");
$pervii_abzatc[0][] = array($marka);
$pervii_abzatc[0][] = array("на понятных","на прозрачных","на известных","на регламентированных","на однозначных","на общепонятных","на удобных","на понятных и прозрачных",
    "на прозрачных и понятных","на известных и понятных","на понятных и известных","на регламентированных и понятных","на понятных и регламентированных","на однозначных и понятных",
    "на понятных и однозначных","на четких и понятных","на понятных и четких","на удобных и прозрачных","на прозрачных и удобных","на известных и удобных","на удобных и известных",
    "на регламентированных и удобных","на удобных и регламентированных","на однозначных и удобных","на удобных и однозначных","на четких и удобных","на удобных и четких",
    "на удобных и понятных","на понятных и удобных");
$pervii_abzatc[0][] = array("условиях:");
$pervii_abzatc[1][] = array("бесплатная диагностика,");
$pervii_abzatc[1][] = array("оригинальные запчасти,","оригинальные комплектующие,","все запчасти оригинальные,","все комплектующие оригинальные,","фирменные запчасти,","фирменные комплектующие,");
$pervii_abzatc[1][] = array("длительная гарантия,","продолжительная гарантия,","долгосрочная гарантия,");
$pervii_abzatc[1][] = array("фиксированные цены,","фиксированная стоимость,","регламентированные цены,","регламентированная стоимость,");
$pervii_abzatc[1][] = array("оптимальные сроки ремонта,","сжатые сроки ремонт,","кратчайшее сроки ремонта,","оптимальное время ремонта,","кратчайшие время ремонта,");


$pervii_abzatc_1_count = count($pervii_abzatc[1]);
$pervii_abzatc_1_out = "";

for ($i = 0;$i < $pervii_abzatc_1_count;$i++)
{
    $pervii_abzatc1_arr = array_rand($pervii_abzatc[1]);
    $pervii_abzatc_1_out .= $this->checkcolumn($pervii_abzatc[1][$pervii_abzatc1_arr]) . " ";
    unset($pervii_abzatc[1][$pervii_abzatc1_arr]);
}
$pervii_abzatc_1_out = substr($pervii_abzatc_1_out,0,-2);


$centr1 = "<div class=\"item\"><div class=\"digits-num\">";
$centr2 = "</div><div class=\"digits-text\">";
$centr3 = "</span></div></div>";


$centr = array();
$centr_0 = rand(3,11);
$centr[0][] = array($centr_0);
$centr[0][] = array(
    mb_substr(tools::declOfNum($centr_0, array("Свободный<span>оператор", "Свободных<span>оператора", "Свободных<span>операторов")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Свободный<span>диспетчер", "Свободных<span>диспетчера", "Свободных<span>диспетчеров")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>call-центра", "Оператора<span>call-центра", "Операторов<span>call-центра")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Диспетчер<span>call-центра", "Диспетчера<span>call-центра", "Диспетчеров<span>call-центра")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>колл-центра", "Оператора<span>колл-центра","Операторов<span>колл-центра" )), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Диспетчер<span>колл-центра", "Диспетчера<span>колл-центра", "Диспетчеров<span>колл-центра")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>свободен", "Оператора<span>свободно", "Операторов<span>свободно")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>в колл-центре", "Оператора<span>в колл-центре", "Операторов<span>в колл-центре")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Оператор<span>в call-центре", "Оператора<span>в call-центре", "Операторов<span>в call-центре")), mb_strlen($centr_0)+1),
    mb_substr(tools::declOfNum($centr_0, array("Не занятый<span>оператор", "Не занятых<span>оператора", "Не занятых<span>операторов")), mb_strlen($centr_0)+1));
$centr_1 = rand(27,44);
$centr[1][] = array($centr_1);
$centr[1][] = array(
    mb_substr(tools::declOfNum($centr_1, array("Заказ<span>в работе", "Заказа<span>в работе", "Заказов<span>в работе")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Устройство<span>в работе", "Устройства<span>в работе", "Устройств<span>в работе")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Аппарат<span>в работе", "Аппарата<span>в работе", "Аппаратов<span>в работе")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Устройство<span>в ремонте", "Устройства<span>в ремонте", "Устройств<span>в ремонте")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Аппарат<span>в ремонте", "Аппарата<span>в ремонте", "Аппаратов<span>в ремонте")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Устройство<span>в лаборатории", "Устройств<span>в лаборатории", "Устройств<span>в лаборатории")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Аппарат<span>в лаборатории", "Аппарата<span>в лаборатории", "Аппаратов<span>в лаборатории")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Ремонтируется<span>устройство", "Ремонтируется<span>устройства", "Ремонтируется<span>устройств")), mb_strlen($centr_1)+1),
    mb_substr(tools::declOfNum($centr_1, array("Ремонтируется<span>аппарат", "Ремонтируется<span>аппарата", "Ремонтируется<span>аппаратов")), mb_strlen($centr_1)+1));
$centr_2 = rand(10,35);
$centr[2][] = array($centr_2);
$centr[2][] = array(
    mb_substr(tools::declOfNum($centr_2, array("Всего<span>инженеров", "Всего<span>инженеров", "Всего<span>инженеров")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Сервисных<span>инженеров", "Сервисных<span>инженера", "Сервисных<span>инженеров")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Мастер<span>", "Мастера<span>", "Мастеров<span>")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Мастер<span>по ремонту", "Мастера<span>по ремонту", "Мастеров<span>по ремонту")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Сервисный<span>мастер", "Сервисных<span>мастера", "Сервисных<span>мастеров")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Ремонтный<span>мастер", "Ремонтных<span>мастера", "Ремонтных<span>мастеров")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Сервисныq<span>специалист", "Сервисных<span>специалиста", "Сервисных<span>специалистов")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Всего<span>мастеров", "Всего<span>мастеров", "Всего<span>мастеров")), mb_strlen($centr_2)+1));

$centr[3][] = array($this->_datas['rand_ustroistva']);
$centr_3 = $this->_datas['rand_ustroistva'];
$centr[3][] = array(
    tools::declOfNum($centr_3, array("Отремонтированое<span>устройство", "Отремонтированных<span>устройств", "Отремонтированных<span>устройств"),false),
    tools::declOfNum($centr_3, array("Отремонтированный<span>аппарат", "Отремонтированных<span>аппарата", "Отремонтированых<span>аппаратов"),false),
    tools::declOfNum($centr_3, array("Устройство<span>отремонтировано", "Устройства<span>отремонтировано", "Устройств<span>отремонтировали"),false),
    tools::declOfNum($centr_3, array("Аппарат<span>отремонтирован", "Аппарата<span>отремонтировано", "Аппаратов<span>отремонтировали"),false)

);



$centr_count = count($centr);
$centr_out = "";
for ($i = 0;$i < $centr_count;$i++)
{
    $centr_arr = array_rand($centr);
    $centr_out .= $centr1 . $this->checkcolumn($centr[$centr_arr][0]) . $centr2 .$this->checkcolumn($centr[$centr_arr][1]) . $centr3;
    unset($centr[$centr_arr]);
}
//$centr_out = substr($centr_out,0,-1);

$all_dev_mass_in = array();
$popular_usl = array();
$popular_usl[0][] = array("");
$popular_usl[1][] = array("Услуги");
$popular_usl[1][] = array("по");
$popular_usl[1][] = array("ремонту");

srand($this->_datas['feed']);

include __DIR__.'/data/gadget_price.php';

foreach ($all_deall_devices as $key_0 => $device)
{
    $add_device = false;
    
    if (!isset($device['type_id']))
        $add_device = true;     
    
    if (!$add_device)
    {
        $suffics = tools::get_suffics($device['type']);

        $table = $suffics.'_service_to_m_models';
        $join_field = $suffics.'_service_syn_id';
        $join_table = $suffics.'_service_syns';
        $main_table = $suffics.'_services';
        $main_field = $suffics.'_service_id';
        $cost_table = $suffics.'_service_costs';
    
        $popular = " AND `{$main_table}`.`popular` = 1";
        $non_popular = " AND (`{$main_table}`.`popular` = 0 OR `{$main_table}`.`popular` IS NULL)";
        $end_sql = " ORDER BY RAND(".$this->_datas['feed'].") LIMIT 0,5";
        if(!empty($suffics)){
            
        if(!empty($suffics)){
        $sql = "SELECT `{$join_table}`.`name` as `name`, `{$main_table}`.`id` as `service_id`, `{$cost_table}`.* FROM `{$table}`
                    INNER JOIN `{$join_table}` ON `{$table}`.`{$join_field}` = `{$join_table}`.`id`
                    INNER JOIN `{$main_table}` ON `{$main_table}`.`id` = `{$join_table}`.`{$main_field}`
                    INNER JOIN `{$cost_table}` ON `{$main_table}`.`id` = `{$cost_table}`.`{$main_field}`
                WHERE `{$table}`.`site_id`=:site_id AND `{$table}`.`marka_id`=:marka_id AND `{$table}`.`type` = 3 AND `{$cost_table}`.`setka_id`=:setka_id";
    
        $stm = pdo::getPdo()->prepare($sql.$popular.$end_sql);
        $stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));
    
        $t0 = $stm->fetchAll(\PDO::FETCH_ASSOC);
        }
    
        if (count($t0) < 5)
        {
            $stm = pdo::getPdo()->prepare($sql.$non_popular.$end_sql);
            $stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));
    
            $t0 = array_merge($t0, $stm->fetchAll(\PDO::FETCH_ASSOC));
    
            $t0 = array_slice($t0, 0, 5);
        }
        }
    
        foreach ($t0 as $key => $value)
        {
            $t0[$key]['model_type_id'] = $device['type_id'];
        }

         $sql = "SELECT MIN(`{$cost_table}`.`price`) FROM `{$cost_table}`
                            WHERE `setka_id`=:setka_id
                    AND `price` > 0";
    
         $stm = pdo::getPdo()->prepare($sql);
         $stm->execute(array('setka_id' => $setka_id));
    
         $all_deall_devices[$key_0]['min_price'] = $stm->fetchColumn();

         $services[$device['type_id']] = $t0;
         $use_diagram = true;
    }
    else
    {
        if (isset($gadget_price[$device['type']]))
        {
            $t0 = $gadget_price[$device['type']];
            
            if (count($t0) > 5)
            {
                 $t0 = array_slice($t0, 0, 5);
            }
                
            $services[$device['type']] = $t0;
            
            $min = PHP_INT_MAX;
            foreach ($gadget_price[$device['type']] as $value)
                if ($min > $value[1] && $value[1]) $min = $value[1]; 
            
            $all_deall_devices[$key_0]['min_price'] = $t0; 
        }
        else
        {
            $services[$device['type']] = false; 
        }
    }

    $all_deall_devices[$key_0]['diagram']  = array(rand(300,350),rand(400,500), rand(100,155), rand(350,400), rand(200,250));
    $all_deall_devices[$key_0]['diagram'][] = array_sum($all_deall_devices[$key_0]['diagram']);
}
    if (isset($this->_datas['admin'])){
        echo "<pre>";
        if (!empty($this->_datas['admin'][0])){
        print_r($this->_datas[$this->_datas['admin'][0]]);
        }else print_r($this->_datas);
        echo "</pre>";
    }
?>
<main>
    <section class="showcase showcase-top">
        <div class="container showcase-inside">
            <div class="grid-6">
                <div class="showcase-info">
                    <h1 class="showcase-title"><?=$this->_ret['h1']?></h1>
                    <div class="showcase-text">
                        <p><?=$this->checkarray($pervii_abzatc[0])?> <?=$pervii_abzatc_1_out?></p>
                    </div>
                    <button href="#callback_order" class="btn btn-border-light" data-toggle="modal">Статус ремонта</button>
                </div>
            </div>
            <div class="grid-5">
                <div class="block-form block-rel">
                    <button type="button" class="close x_pos">&times;</button>
                    <form class="block-form-inside">
                             <div class="send">
                            <div class="form-title">Заявка на ремонт</div>
                            <div class="form-input">
                                <input type="text" class="phone inputform" placeholder="Телефон">
                                <i class="fa fa-question-circle"></i>
                                <div class="input-tooltip">Обязательное поле</div>
                            </div>
                            <div class="form-input">
                                <input type="text" class="name inputform" placeholder="Имя">
                            </div>
                            <!--<div class="form-input">
                                <select class="select-type" data-placeholder="">
                                    <option></option>
                                    <?foreach ($all_deall_devices as $item) :?>
                                    <option><?echo $this->firstup($item['type']);?></option>
                                    <?endforeach;?>
                                </select>
                            </div>-->
                            <div class="form-btn">
                                <div class="btn btn-accent btn-with-input">
                                    <input type="submit" class="" value="Перезвоните мне">
                                </div>
                            </div>
                        </div>
                        <div class="success">
							<div class="block-text">
								<img src="/templates/russupport/img/success-512.png" style="width: 30%;" />
								<p>Спасибо за заявку,<br />мы свяжемся с вами в течении 15-30 минут.</p>
							</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="digits">
        <div class="container">
            <div class="grid-12">
                <div class="digits-inside">
                    <?=$centr_out?>
                </div>
            </div>
        </div>
    </section>

    <section class="articles">
        <div class="container">
          <!--
            <div class="grid-12">
                <div class="articles-inside">
                <?foreach ($all_deall_devices as $all_deall_device):?>
                      <div class="item">
                        <div class="articles-info">
                            <div class="articles-title">
                                <a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $all_deall_device['type_id'], 'marka_id' => $marka_id)))?>/">Ремонт <?=$all_deall_device["type_rm"]?> <?=$marka?></a>
                            </div>
                            <div class="articles-text"></div>
                            <div class="articles-price">Стоимость обслуживания от <?=$all_deall_device['min_price']?> руб</div>
                            <a class="btn btn-link" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $all_deall_device['type_id'], 'marka_id' => $marka_id)))?>/">Подробнее</a>
                        </div>
                        <div class="articles-image">
                            <img src="/images/sample/<?=mb_strtolower($marka)?>big<?=$this->_datas['accord_image'][$all_deall_device["type"]]?>.jpg">
                        </div>
                    </div>
                <?endforeach;?>
                </div>
            </div>
            -->
            
            <?
            
            $count = count($this->_datas['all_devices']);
           // var_dump($this->_datas['all_devices']);
            // echo '<div style="display:none">'.$count.'</div>';
            switch ($count)
            {
                case 1:
                   $width = 1;
                break;
                case 2:
                   $width = 2;
                break;
                case 3:
                   $width = 3;
                break; 
                case 4:
                   $width = 4;
                break;
                case 5:
                   $width[0] = 3;
				   $width[1] = 2;
                break;
                case 6:
                   $width[0] = 3;
				   $width[1] = 3;
                break;
				case 7:
				   $width[0] = 4;
                   $width[1] = 3;
                break;
				case 8:
				   $width[0] = 4;
                   $width[1] = 4;
                break;
                case 9:
                   $width[0] = 3;
                   $width[1] = 3;
                   $width[2] = 3;
                break;
                case 10:
                   $width[0] = 4;
                   $width[1] = 3;
				   $width[2] = 3;
                break;
                case 11:
                   $width[0] = 4;
                   $width[1] = 4;
				   $width[2] = 3;
				   //$width[3] = 2;
                break;
            }
            
            if (is_array($width)) {
				$i = 0;
				$j = 0;
				$exwidth = $width[$j];
			} else {
				$exwidth = $width;
			}
            ?>
            
            <div class="articles-inside">
                <div class="item-row">
                <?
                //var_dump($all_deall_devices);
                foreach (tools::sortByPriority($all_deall_devices) as $all_deall_device):
                    
                    if (is_array($width)) {
    					if ($width[$j] === $i) {
    						$i = 0;
    						$j++;
    						$exwidth = $width[$j];
                            echo '</div><div class="item-row">';
    					}
    					$i++;
    				}
                    
                    $href = 'repair-' . $this->_datas['accord_image'][$all_deall_device["type"]]; 
                
                ?>
                    <div class="item grid-<?=(12 / $exwidth)?> item-index">
                        
                        <div class="articles-image">
                            <a href="/<?=$href?>/"><img src="/images/sample/<?=mb_strtolower($marka)?>big<?=$this->_datas['accord_image'][$all_deall_device["type"]]?>.png"/></a>
                        </div>
                        <div class="articles-info">
                            <div class="articles-title">
                                <? $name = (isset($accord_menu[$all_deall_device['type_rm']]) ? $accord_menu[$all_deall_device['type_rm']] : mb_strtolower($all_deall_device['type_rm'])); 
                                echo '<div style="display:none">'.$all_deall_device['type_rm'].'</div>';
                                ?>
                                <a href="/<?=$href?>/">Ремонт <?=$name?></a>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
                </div>
            </div>
            
        </div>
        
    </section>
    
    <section class="showcase showcase-bottom">
        <div class="container showcase-inside">
        
            <? //include __DIR__.'/block-promo.php' ?>
        
            <div class="grid-6">
                <div class="showcase-info block-promo">
                    <p class="block-promo-title">ДАРИМ 1000 рублей</p>
                    <p class="block-promo-title">Получить промокод на ремонт ПРОСТО!</p>
                    <p class="block-promo-title-text">1. Получите промокод SMS сообщением<br />
                    2. Сообщите промокод при сдаче устройства в сервис/курьеру<br />
                    3. Оплачивайте до 1000 рублей полностью с помощью промокода*<br />
                    * - оплачивать промокодом можно не более 20% от суммы ремонта</p>
                </div>
            </div>
            <div class="grid-5">
                <div class="block-form block-rel">
                    <button type="button" class="close x_pos">&times;</button>
                    <form class="block-form-inside">
                        <div class="send">
                            <div class="form-title">Получить SMS с промокодом</div>
                            <div class="form-input">
                                <input type="text" class="phone inputform"  placeholder="Телефон">
                                <i class="fa fa-question-circle"></i>
                                <div class="input-tooltip">Обязательное поле</div>
                            </div>
                            <!--<div class="form-input">
                                <input type="text" class="name inputform" placeholder="Имя">
                            </div>-->
                            <div class="form-btn">
                                <div class="btn btn-accent btn-with-input">
                                    <input type="submit" value="Отправьте мне SMS">
                                </div>
                            </div>
                        </div>
                        <div class="success">
							<div class="block-text">
								<img src="/templates/russupport/img/success-512.png" style="width: 30%;" />
								<p>Спасибо за заявку,<br />мы свяжемся с вами в течении 15-30 минут.</p>
							</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <section class="services">
        <div class="container">
            <div class="services-list">
              
                    <div id="accordion">

                            <?foreach ($all_deall_devices as $key => $item):
                            
                            if (isset($services[$item['type']])) 
                                if (!$services[$item['type']])
                                     continue;
                                     
                            $suffics = tools::get_suffics($item['type']);
                            ?>
                            <div class="services-item panel">
                                  <a class="services-item-title<?=(($key>1) ? " collapsed":"");?>" data-toggle="collapse" data-parent="#accordion" href="#accordeon-<?=$suffics?>">
                                     <?
                                        $popular_usl1 = $popular_usl;
                                        $popular_usl1_rand =  $this->checkcolumn($popular_usl1[0][0]);
                                        if($popular_usl1_rand == "Распространенные")
                                        {
                                            unset($popular_usl1[1][0][1]);
                                            unset($popular_usl1[1][2][1]);
                                        }
                                        ?>
                                        <?=$popular_usl1_rand?> <?=$this->checkarray($popular_usl1[1])?> <?=$item["type_rm"]?>

                                    </a>
                                  <div class="collapse<?=(($key<=1) ? " in":"");?> panel-p" id="accordeon-<?=$suffics?>">
                                        <div class="services-item-table label-wrapper services-item-table-full services-item-table-2row">
                                             <? if (isset($item['type_id'])): 
                                              foreach ($services[$item['type_id']] as $k => $value):?>

                                                <div class="a services-item-row">
                                                    <a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $value['model_type_id'], 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value['service_id'])));?>/" class="services-item-name label" data-val="<?=$item['diagram'][$k]?>"><?=tools::mb_firstupper($value['name'])?></a>
                                                    <span class="services-item-value"><?=tools::format_price($value['price'], $setka_name);?> руб</span>
                                                </div>

                                            <? endforeach; 
                                            else:
                                               foreach ($services[$item['type']] as $k => $value):?>
                                                
                                                <div class="a services-item-row">
                                                    <span class="services-item-name label" data-val="<?=$item['diagram'][$k]?>"><?=tools::mb_firstupper($value[0])?></span>
                                                    <span class="services-item-value"><?=tools::format_price($value[1], $setka_name);?> руб</span>
                                                </div>
                                                
                                            <? endforeach;                                               
                                            endif;?>
                                           
                                         <? unset($item['diagram'][5]);?>                                         
                                        </div>
                                        <input type="hidden" name="max" value="<?=max($item['diagram'])?>"/>
                                    </div>
                            </div>
                            <?endforeach;?>
                    </div>
                    <a class="btn btn-link" style="float: right;" href="/about/price/">Все услуги по ремонту</a>
                </div>
            <!--<div class="grid-12">
                <? 
                //var_dump($all_deall_devices);
                foreach ($all_deall_devices as $key => $item):?>
                <div class="block-diagramm non-visible">
                    <?
                    $okazano = array();
                    $okazano_rand = rand(1,4);
                    if($okazano_rand == 1)
                    {
                        $okazano[0][] = array("Оказано услуг");
                        $okazano[0][] = array("по ремонту");
                    }
                    if($okazano_rand == 2)
                    {
                        $okazano[0][] = array("Отремонтировано","Восстановленно");
                    }
                    if($okazano_rand == 3)
                    {
                        $okazano[0][] = array("Произведено ремонтов");
                    }
                    if($okazano_rand == 4)
                    {
                        $okazano[0][] = array("Заменено");
                        $okazano[0][] = array("комплектующих","запчастей");
                    }
                    $okazano[1][] = array("Итого:","Всего:","В итоге:","В сумме:","В общей сложности:","В общем:");
                    $okazano[2][] = tools::declOfNum($item['diagram'][5],array('устройство','устройства','устройств'), false);
                    $okazano[2][] = tools::declOfNum($item['diagram'][5],array('девайс','девайса','девайсов'), false);
                    $okazano[2][] = tools::declOfNum($item['diagram'][5],array('гаджетов','гаджета','гаджетов'), false);
                    $okazano[2][] = tools::declOfNum($item['diagram'][5],array('аппарат','аппарата','аппаратов'), false);
                    $ar_r_key = array_rand($okazano[2],1);
                    $okazano_str = "";
                    $okazano_str = $this->checkarray($okazano[0]);
                    ?>
                    <div class="diagramm-list-title"><?=$okazano_str?> <?=$item['type_rm']?> <?=$marka?> за год:</div>
                    <canvas id="chart-bar-<?=$key?>" width="530" height="440"></canvas>
                    <div class="diagramm-list-summ"><?=$this->checkcolumn($okazano[1][0])?> <span><?=$item['diagram'][5]?></span> <?=$okazano[2][$ar_r_key]?></div>
                </div>
                <?endforeach;?>-->
                <!--<div class="services-list">
                    <div id="accordion">

                            <?foreach ($all_deall_devices as $key => $item):
                            
                            if (isset($services[$item['type']])) 
                                if (!$services[$item['type']])
                                     continue;
                                     
                            $suffics = tools::get_suffics($item['type']);
                            ?>
                            <div class="services-item panel">
                                  <a class="services-item-title<?=(($key) ? " collapsed":"");?>" data-toggle="collapse" data-parent="#accordion" href="#accordeon-<?=$suffics?>">
                                     <?
                                        $popular_usl1 = $popular_usl;
                                        $popular_usl1_rand =  $this->checkcolumn($popular_usl1[0][0]);
                                        if($popular_usl1_rand == "Распространенные")
                                        {
                                            unset($popular_usl1[1][0][1]);
                                            unset($popular_usl1[1][2][1]);
                                        }
                                        ?>
                                        <?=$popular_usl1_rand?> <?=$this->checkarray($popular_usl1[1])?> <?=$item["type_rm"]?>

                                    </a>
                                  <div class="collapse<?=((!$key) ? " in":"");?> panel-p" id="accordeon-<?=$suffics?>">
                                        <div class="services-item-table label-wrapper services-item-table-full services-item-table-2row">
                                             <? if (isset($item['type_id'])): 
                                              foreach ($services[$item['type_id']] as $k => $value):?>

                                                <div class="a services-item-row">
                                                    <a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $value['model_type_id'], 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value['service_id'])));?>/" class="services-item-name label" data-val="<?=$item['diagram'][$k]?>"><?=tools::mb_firstupper($value['name'])?></a>
                                                    <span class="services-item-value"><?=tools::format_price($value['price'], $setka_name);?> руб</span>
                                                </div>

                                            <? endforeach; 
                                            else:
                                               foreach ($services[$item['type']] as $k => $value):?>
                                                
                                                <div class="a services-item-row">
                                                    <span class="services-item-name label" data-val="<?=$item['diagram'][$k]?>"><?=tools::mb_firstupper($value[0])?></span>
                                                    <span class="services-item-value"><?=tools::format_price($value[1], $setka_name);?> руб</span>
                                                </div>
                                                
                                            <? endforeach;                                               
                                            endif;?>
                                           
                                         <? unset($item['diagram'][5]);?>                                         
                                        </div>
                                        <input type="hidden" name="max" value="<?=max($item['diagram'])?>"/>
                                    </div>
                            </div>
                            <?endforeach;?>
                    </div>
                    <a class="btn btn-link" style="float: right;" href="/about/price/">Все услуги по ремонту</a>
                </div>-->
            </div>
        </div>
    </section>
    <div class="modal fade" id="callback_order" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close x_pos" data-dismiss="modal">&times;</button>
                <div class="modal-header">
                    <div class="modal-title">Введите номер заказа</div>
                </div>
                <div class="modal-body">
                    <div class="block-form">
                        <form class="block-form-inside">
                            <div class="send">
                                <div class="form-input">
                                    <input type="text" id="order_id" class="phone inputform" placeholder="Номер заказа *">
                                    <i class="fa fa-question-circle"></i>
                                    <div class="input-tooltip">Обязательное поле</div>
                                </div>
                                <div class="form-btn">
                                    <div class="btn btn-accent btn-with-input">
                                        <input type="submit" class="" value="Проверить">
                                    </div>
                                </div>
                            </div>
                            <div class="success">
                                <p class="block-text">Извините,<br />заказ не найден.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
