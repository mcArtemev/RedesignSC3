<?php

use framework\tools;
use framework\pdo;
use framework\rand_it;

srand($this->_datas['feed']);

$region_id = $this->_datas['region_id'];
$page = $this->_datas['page'];

$types_array = [
	"remont-monitorov"     => [10, "display.jpg", "монитор", "monitors", "Наш сервис {выполняет|осуществляет} ремонт мониторов в [city] {быстро|оперативно}, с гарантией, независимо от сложности неисправности. {Опытные|квалифицированные} сотрудники проведут {диагностику|проверку}, определят причину {поломки|неисправности}, устранят ее и вернут работоспособность {технике.|монитору.}"],
	"remont-monoblokov"    => [4, "all-in-one.jpg", "моноблок", "monoblocks", "{Выполняем|предлагаем} профессиональный ремонт моноблока в [city] {любой|разной} сложности. Устраняем {неисправности|поломки} аппаратной и программной части. {Используем|применяем} оригинальные {комплектующие|запчасти}, гарантируем качество и {своевременное|быстрое} {выполнение|исполнение} работ."],
	"remont-noutbukov"     => [1, "laptop.jpg", "ноутбук", "laptops", "Сервисный центр {проводит|выполняет} обслуживание и ремонт ноутбуков. Работы {проводятся|осуществляются} опытными сотрудниками мастерами с высокой {квалификацией|компетенцией}. Устраняем {неисправности|поломки}{оперативно|быстро}, даем гарантию, {возможна|есть} доставка курьером."],
	"remont-planshetov"    => [2, "tablet.jpg", "планшет", "tablets", "Выполняем ремонт планшетов {любых|разных} брендов в [city]. {Проводим|делаем} {диагностику|проверку} и устраняем сложные неисправности. Используем оригинальные {комплектующие|запчасти}, гарантируем качество и {доступные|приемлемые} цены. {Возможен|есть} выезд курьера"],
	"remont-telefonov"     => [3, "phone.jpg", "смартфон", "smartphones", "Выполняем {диагностику|проверку} и устраняем неисправности телефонов {быстро|оперативно}, с гарантией. Наш центр {предлагает|выполняет} профессиональный ремонт смартфонов в [city] по {доступным|приемлемым} ценам. Используем оригинальные {комплектующие|запчасти}. {Есть|возможен} выезд курьера."],
	"remont-proektorov"    => [11, "projector.jpg", "проектор", "projectors", "Сервисный центр {выполняет|осуществляет} ремонт проекторов и {проводит|выполняет} профилактические работы в [city]. {Проводим|делаем} замену ламп, {чиним|ремонтируем} систему охлаждения, оптический блок и {устраняем|чиним} другие {неисправности|поломки}. {Используем|устанавливаем} качественные, оригинальные {комплектующие|запчасти}, {возможна|есть} доставка курьером. "],
	"remont-fotoapparatov" => [15, "photo.jpg", "фотоаппарат", "cameras", "Сервисный центр {предлагает|осуществляет} {квалифицированный|профессиональный} ремонт фотоаппаратов в [city] с гарантией. {Меняем|чиним} поврежденные матрицы, восстанавливаем вспышки, {проводим|выполняем} диагностику. Центр {оснащен|обеспечен} современным оборудованием, {устанавливаем используем} исключительно оригинальные {детали|комплектующие}"],
	"remont-printerov"     => [13, "mfu.jpg", "принтер", "printers", "Наш сервис {предлагает|выполняет} чистку и ремонт принтеров в [city]. {Проводим|выполняем} замену, {диагностику|проверку}, {оперативно|быстро} устраняем {неисправности|поломки}, меняем картриджи, {выполняем|проводим} работы любой степени сложности."],
	"remont-kompyuterov"   => [5, "computer.jpg", "компьютер", "computers", "{Выполняем|проводим} обслуживание и ремонт компьютеров и компьютерного {оборудования|техники} в [city]. Устраняем {неисправности|поломки} аппаратной и программной части, {даем|предоставляем} гарантию на свою работу. {Можно|есть возможность} заказать доставку курьером."],
	"remont-televizorov"   => [7, "tv.jpg", "телевизор", "tvs", "При {неисправности|поломки} телевизора, {обращайтесь|приходите} в наш центр. Мы {проводим|осуществляем} ремонт телевизоров {разных|различных} брендов {любой|разной} степени сложности. {Используем|устанавливаем} оригинальные {комплектующие|запчасти}, гарантируем качество и {соблюдение|выполнение} сроков."]
];

$types_keys = [
	"remont-monitorov",
	"remont-monoblokov",
	"remont-noutbukov",
	"remont-planshetov",
	"remont-telefonov",
	"remont-proektorov",
	"remont-fotoapparatov",
	"remont-printerov",
	"remont-kompyuterov",
	"remont-televizorov"
];

if (!empty($this->_datas['hb'])) {
    foreach ($this->_datas['all_brands'] as $data) {
        $types_keys['remont-plotterov-'.strtolower($data['brand_name'])] = 'remont-plotterov-'.strtolower($data['brand_name']);
        $types_array['remont-plotterov-'.strtolower($data['brand_name'])] = [7, "plotter.jpg", "плоттер", "plotters", "При {неисправности|поломки} плоттера, {обращайтесь|приходите} в наш центр. Мы {проводим|осуществляем} ремонт плоттеров {разных|различных} брендов {любой|разной} степени сложности. {Используем|устанавливаем} оригинальные {комплектующие|запчасти}, гарантируем качество и {соблюдение|выполнение} сроков."];
    }
}
if (empty($this->_datas['hb']) && !empty($this->_datas['hab'])) {
    foreach ($this->_datas['all_brands'] as $data) {
        $types_keys['remont-planshetov-'.strtolower($data['brand_name'])] = 'remont-planshetov-'.strtolower($data['brand_name']);
        $types_array['remont-planshetov-'.strtolower($data['brand_name'])] = [2, "tablet.jpg", "планшет", "tablets", "При {неисправности|поломки} плоттера, {обращайтесь|приходите} в наш центр. Мы {проводим|осуществляем} ремонт плоттеров {разных|различных} брендов {любой|разной} степени сложности. {Используем|устанавливаем} оригинальные {комплектующие|запчасти}, гарантируем качество и {соблюдение|выполнение} сроков."];
    }
}

$sql = "SELECT `markas`.`name` AS `name`, `sites`.`name` AS `site` FROM `markas`
		LEFT JOIN `model_type_to_markas` ON `markas`.`id` = `model_type_to_markas`.`marka_id`
		LEFT JOIN `marka_to_sites` ON `marka_to_sites`.`marka_id` = `markas`.`id`
		LEFT JOIN `sites` ON `sites`.`id` = `marka_to_sites`.`site_id`
	WHERE `sites`.`setka_id`=7 AND `sites`.`region_id`=? AND `model_type_to_markas`.`model_type_id`=?";
	
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array($region_id, $types_array[$page][0]));
$data = $stm->fetchAll(\PDO::FETCH_ASSOC);

$brandsAll = array();
foreach ($data as $brand) {
    $brandsAll[mb_strtolower($brand['name'])]['name'] = $brand['name'];
	$brandsAll[mb_strtolower($brand['name'])]['site'] = $brand['site'];
}

ksort($brandsAll);
if ('/' === $this->_datas['arg_url']) {
    $brandsSliced[] = array_slice($brandsAll, 0, 5);
    $brandsSliced[] = array_slice($brandsAll, 5, 6);
    $brandsSliced[] = array_slice($brandsAll, 11, 5);
} else {
    $brandsSliced[] = $brandsAll;
}

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

$gen = [
	'keys' => [
		'[city]',
	],
	'data' => [
		$region_name_pe,
	]
];

$suffics = tools::get_suffics($types_array[$page][2]);

// eds
$table_cost = $suffics.'_service_costs';
$j_field = $suffics.'_service_id';

$eds = array();

$sql = "SELECT `{$j_field}`, `ed_time`, `ed_garantee` FROM `{$table_cost}` WHERE `setka_id`=:setka_id";
$stm = pdo::getPdo()->prepare($sql);
$stm->execute(array('setka_id' => $setka_id));
foreach ($stm->fetchAll(\PDO::FETCH_ASSOC) as $ed)
	$eds[$ed[$j_field]] = $ed;


$table = $suffics.'_service_to_m_models';
$join_field = $suffics.'_service_syn_id';
$join_table = $suffics.'_service_syns';
$main_table = $suffics.'_services';
$main_field = $suffics.'_service_id';
$cost_table = $suffics.'_service_costs';

$popular = " AND `{$main_table}`.`popular` = 1 GROUP BY `{$join_table}`.`{$suffics}_service_id`";
$non_popular = " AND (`{$main_table}`.`popular` = 0 OR `{$main_table}`.`popular` IS NULL) GROUP BY `{$join_table}`.`{$suffics}_service_id`";
$end_sql = " LIMIT 0,4";
// GROUP BY `{$join_table}`.`{$suffics}_service_id` HAVING COUNT(*)=1;
$sql = "SELECT `{$table}`.id as 'service_id', `{$join_table}`.`name` as 'name', `{$cost_table}`.* FROM `{$table}`
            INNER JOIN `{$join_table}` ON `{$table}`.`{$join_field}` = `{$join_table}`.`id`
            INNER JOIN `{$main_table}` ON `{$main_table}`.`id` = `{$join_table}`.`{$main_field}`
            INNER JOIN `{$cost_table}` ON `{$main_table}`.`id` = `{$cost_table}`.`{$main_field}`
        WHERE `{$table}`.`type` = 3 AND `{$cost_table}`.`setka_id`=?";

$stmd = pdo::getPdo()->prepare($sql.$popular.$end_sql);
$stmd->execute(array($setka_id));
$other_services = $stmd->fetchAll(\PDO::FETCH_ASSOC);

if (count($other_services) < 4)
{
    $stmd = pdo::getPdo()->prepare($sql.$non_popular." LIMIT ".(4-count($other_services)));
    $stmd->execute(array($setka_id));

    $other_services = array_merge($other_services, $stmd->fetchAll(\PDO::FETCH_ASSOC));
}

srand($this->_datas['feed']);
shuffle($other_services);

$other_services = array_slice($other_services, 0, 4);

$ids = implode(',', array_column($other_services, 'service_id'));
//echo $sql." AND `{$table}`.`id` NOT IN ($ids) ".'GROUP BY `'.$join_table.'`.`'.$suffics.'_service_id` ORDER BY RAND('.$this->_datas['feed'].')';
$stmd = pdo::getPdo()->prepare($sql." AND `{$table}`.`id` NOT IN ($ids) ".'GROUP BY `'.$join_table.'`.`'.$suffics.'_service_id` ORDER BY RAND('.$this->_datas['feed'].')');
$stmd->execute(array($setka_id));
$all_services = $stmd->fetchAll(\PDO::FETCH_ASSOC);

$model_type_name_rm = $this->_datas['type_name_rm'];

if (!empty($this->_datas['hb']) && empty($this->_datas['hab'])) {
    for($i=0; $i<count($types_keys); $i++) {
    	if ($types_keys[$i] == $page) {
    		if (isset($types_keys[$i+1])) {
    			$i++;
    		} else {
    			$i=0;
    		}
    		break;
    	}
    }


    foreach($all_deall_devices as $key => $val) {
    	if ($val['type'] == $types_array[$types_keys[$i]][2])
    		break;
    }
}

?>
<main>
	<section style="padding-bottom: 0;" class="block-section">
		<div class="container">
			<div class="grid-12">
				<h1 style="display: inline-block;"><?=$this->_ret['h1']?></h1>
				<a class="btn btn-link" style="float: right; line-height: 29px;" href="/<?=$types_keys[$i]?>/">Ремонт <?=$all_deall_devices[$key]['type_rm']?></a>
			</div>
		</div>
	</section>
	 <section class="block-section">  <!--here -->
		<div class="container">
			<div class="grid-12">
				<div class="block-list">
					<div class="block block-small block-text-image">
						<p><?=tools::gen_text($gen['keys'], $gen['data'], $types_array[$page][4])?></p>
					</div>
					<div class="block block-small block-form">
						<button type="button" class="close x_pos">&times;</button>
						<form class="block-form-inside">
							<div class="send">
								<div class="form-title">Оформите заявку на выезд курьера</div>
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
		</div>
	</section>
	<div class="content brand-content">
		<div class="container">
			<div class="row brendh2">
				<h2 class="brand_h">Выберите бренд</h2>
			</div>
			<div class="brend_imgs">
				<div class="row">
					<?php $temp_item = 0; ?>
					<?php foreach ($brandsSliced as $k => $brandsSlice) :; ?>
					<?php foreach ($brandsSlice as $key => $brand) :; ?>
						<div style="float: left; width: 25%;">
							<a href="https://<?=$brand['site']?>/repair-<?=$types_array[$page][3]?>/">
								<div class="brand-logo-sm">
									<div class="logo__inner" style="background-image: url(/images/brands/<?= $key; ?>-logo.png);"></div>
								</div>
							</a>
						</div>
						<?php $temp_item++; ?>
					<?php endforeach; ?>
					<?php if ($k < 2) :; ?>
				</div>
				<div class="row">
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
			<!--<div class="brend_lis">
				<div class="row">
					<?php $temp_item = 0; ?>
					<?php foreach ($brandsSliced as $k => $brandsSlice) :; ?>
					<?php foreach ($brandsSlice as $key => $brand) :; ?>
						<a href="/<?= isset($dev_type_name) ? strtolower($key) . '/' . $dev_type_name . '-service' : strtolower($key); ?>/">
							<?=$key?>
						</a>
						<?php $temp_item++; ?>
					<?php endforeach; ?>
					<?php if ($k < 2) :; ?>
				</div>
				<div class="row">
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>-->
		</div>
	</div>
	<section style="margin-top: 50px;" class="link-block-section">
		<div class="container">
			<div class="grid-12">
				<div class="block-list">
					<div class="block block-auto block-full block-table block-service-table">
						<div class="block-inside">
							<h3>Все услуги по ремонту <?=$model_type_name_rm?></h3>
							<div class="services-item-table services-item-table-full">
								<a class="services-item-row" style="color: black; font-weight: 500;">
									<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
									<span class="services-item-value">Стоимость, руб</span>
									<span class="services-item-callback"></span>
								</a>
								<? for ($i=0; $i<count($all_services); $i++): ?> 
									<? $value = $all_services[$i]; ?>
									<? if ($i == 7): ?>
										</div><div id="part_opt" style = "display: none;" class="services-item-table services-item-table-full">
									<? endif; ?>
									
									<div class="a services-item-row">
										<span class="services-item-name"><?=tools::mb_firstupper($value['name'])?></span>
										<? if ($eds):?><span class="services-item-value"><?=tools::format_price($value['price'], $setka_name);?></span><?endif;?>
										<span class = "services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
									</div>
									
									<? if ($i == count($all_services)-1 && count($all_services) > 7): ?>
										</div><div class="services-item-table services-item-table-full"><a class="btn btn-dark btn-mt part_opt" id="toggle_part_opt" style="display: block; text-align: center; margin: 15px auto 0px;">Показать все услуги</a>
									<? endif; ?>
								<? endfor; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
