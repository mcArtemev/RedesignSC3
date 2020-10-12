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

$all_deall_devices = $this->_datas['all_devices'];

$ustroista_all = "";

foreach ($all_deall_devices as $item)
{
    $ustroista_all .= $item['type_rm'] . ", ";
}
$ustroista_all = substr($ustroista_all,0,-2);

srand();
//srand($this->_datas['feed']);

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
$pervii_abzatc[0][] = array("начиная с режущих и заканчивая электростатическими","начиная с электростатических и заканчивая режущими","от режущих до электростатических");
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
$pervii_abzatc[1][] = array("оптимальные сроки ремонта,","сжатые сроки ремонта,","кратчайшие сроки ремонта,");
// $pervii_abzatc[1][] = array("оптимальные сроки ремонта,","сжатые сроки ремонта,","кратчайшие сроки ремонта,","оптимальное время ремонта,","кратчайшее время ремонта,");
// $pervii_abzatc[2][] = array(". При повторном обращении скидка на заправку картриджей,","постаянным клиентам скидка на заправку картриджей.");


$pervii_abzatc_1_count = count($pervii_abzatc[1]);
$pervii_abzatc_1_out = "";

for ($i = 0;$i < $pervii_abzatc_1_count;$i++)
{
    $pervii_abzatc1_arr = array_rand($pervii_abzatc[1]);
    $pervii_abzatc_1_out .= $this->checkcolumn($pervii_abzatc[1][$pervii_abzatc1_arr]) . " ";
    unset($pervii_abzatc[1][$pervii_abzatc1_arr]);
}
$pervii_abzatc_1_out = substr($pervii_abzatc_1_out,0,-2);
// $pervii_abzatc_1_out .= (rand(1,2)==2)?". При повторном обращении предоставляется скидка на заправку картриджей.":". Постаянным клиентам скидка на заправку картриджей.";


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
    mb_substr(tools::declOfNum($centr_2, array("Сервисный<span>специалист", "Сервисных<span>специалиста", "Сервисных<span>специалистов")), mb_strlen($centr_2)+1),
    mb_substr(tools::declOfNum($centr_2, array("Всего<span>мастеров", "Всего<span>мастеров", "Всего<span>мастеров")), mb_strlen($centr_2)+1));

    $this->_datas['rand_ustroistva'] = rand(1152,4985);
    $centr[3][] = array($this->_datas['rand_ustroistva']);
    $centr_3 = $this->_datas['rand_ustroistva'];
    $centr[3][] = array(
    tools::declOfNum($centr_3, array("Отремонтированый<span>".$this->_datas['all_devices'][0]['type'], "Отремонтированных<span>".$this->firstup($this->_datas['all_devices'][0]['type_re']), "Отремонтированных<span>".$this->firstup($this->_datas['all_devices'][0]['type_rm'])),false),
    tools::declOfNum($centr_3, array($this->firstup($this->_datas['all_devices'][0]['type'])."<span>отремонтирован", $this->firstup($this->_datas['all_devices'][0]['type_re'])."<span>отремонтировано", $this->firstup($this->_datas['all_devices'][0]['type_rm'])."<span>отремонтировали"),false)

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
$popular_usl[0][] = array("Популярные","Распространенные");
$popular_usl[1][] = array("услуги","сервисные услуги");
$popular_usl[1][] = array("по");
$popular_usl[1][] = array("ремонту","восстановлению","починке");

srand($this->_datas['feed']);

/*
foreach ($all_deall_devices as $key_0 => $device)
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

    $sql = "SELECT `{$join_table}`.`name` as `name`, `{$main_table}`.`id` as `service_id`, `{$cost_table}`.* FROM `{$table}`
                INNER JOIN `{$join_table}` ON `{$table}`.`{$join_field}` = `{$join_table}`.`id`
                INNER JOIN `{$main_table}` ON `{$main_table}`.`id` = `{$join_table}`.`{$main_field}`
                INNER JOIN `{$cost_table}` ON `{$main_table}`.`id` = `{$cost_table}`.`{$main_field}`
            WHERE `{$table}`.`type` = 3 AND `{$cost_table}`.`setka_id`=:setka_id";

    $stm = pdo::getPdo()->prepare($sql.$popular.$end_sql);
    $stm->execute(array('setka_id' => $setka_id));

    $t0 = $stm->fetchAll(\PDO::FETCH_ASSOC);

    if (count($t0) < 5)
    {
        $stm = pdo::getPdo()->prepare($sql.$non_popular.$end_sql);
        $stm->execute(array('setka_id' => $setka_id));

        $t0 = array_merge($t0, $stm->fetchAll(\PDO::FETCH_ASSOC));

        $t0 = array_slice($t0, 0, 5);
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

    $all_deall_devices[$key_0]['diagram']  = array(rand(300,350),rand(400,500), rand(100,155), rand(350,400), rand(200,250));
    $all_deall_devices[$key_0]['diagram'][] = array_sum($all_deall_devices[$key_0]['diagram']);
}
*/

  include(__DIR__.'/data/gadget_price.php');
  $type = $this->_datas['all_devices'][0]['type'];
 if (isset($gadget_price[$type]))
    {
        $reg = '%[^0-9]{1,10}%';
        $price_device=$gadget_price[$type];
        $new_price_arr = [];
        foreach ($price_device as $key => $value) {
                if (is_string($value[1])){
                    $total = preg_replace($reg,'',$value[1]);
                    $total = intval(str_replace(" ", "",$total));
                    
                    if ($total!=0){
                        $new_price_arr[]=$total;
                    }
                } else {

                    if ($value[1]!=0){
                        $new_price_arr[]=$value[1];
                    }               
            }
        }

        $min_price = min($new_price_arr);

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
					<a href="#callback_order" class="btn btn-border-light" data-toggle="modal">Статус ремонта</a>
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
							<div class="form-btn">
								<div class="btn btn-accent btn-with-input">
									<input type="submit" class="" value="Отправить заявку">
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
			<div class="grid-12">
                <div class="articles-inside">
                <?foreach ($this->_datas['all_brands'] as $data) { 
                    if (mb_strtolower($data['brand_name'])== 'black') continue;
                    ?>
                      <div class="item">
                        <div class="articles-info">
                            <div class="articles-title">
                                <a href="/repair-<?=$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']]?>-<?=str_replace(' ', '-',strtolower($data['brand_name']))?>/">Ремонт <?=$this->_datas['all_devices'][0]['type_rm']?> <?=$data['brand_name']?></a>
                            </div>
                            <div class="articles-text"></div>
                            <div class="articles-price">от <?=$min_price?> руб</div>
                            <a class="btn btn-link" href="/repair-<?=$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']]?>-<?=str_replace(' ', '-',strtolower($data['brand_name']))?>/">Подробнее</a>
                        </div>
                        <div class="articles-image" style="margin: 10px auto;">
                            <a href="/repair-<?=$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']]?>-<?=str_replace(' ', '-',strtolower($data['brand_name']))?>/">
                        <?php if (file_exists('/var/www/www-root/data/www/sc7/images/hab/'.str_replace(' ', '-',strtolower($data['brand_name'])).'/'.$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']].'.png')):?>
                            <img src="/images/hab/<?=str_replace(' ', '-',strtolower($data['brand_name']))?>/<?=$this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']]?>.png">
                        <?php else:?>    
                            <img src="/images/sample/<?=str_replace(' ', '-',strtolower($data['brand_name']))?>big<?=mb_strtolower($this->_datas['accord_image'][$this->_datas['all_devices'][0]['type']])?>.png" >
                        <?php endif;?>    
                            </a>
                        </div>
                    </div>
					<? } ?>
                </div>
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