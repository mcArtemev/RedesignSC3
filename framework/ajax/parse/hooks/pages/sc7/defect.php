<?php

use framework\tools;
use framework\pdo;
use framework\ajax\parse\hooks\sc;
use framework\rand_it;


$site_id = $this->_site_id;
$setka_name = $this->_datas['setka_name'];
$setka_id = $this->_datas['setka_id'];

$marka_id = $this->_datas['marka']['id'];
$model_type_id = $this->_datas['model_type']['id'];
$eds = $this->_datas['eds'];

$other_services = isset($this->_datas['other_services']) ? array_slice($this->_datas['other_services'], 0, 4) : array();
$model_type_name_rm = $this->_datas['orig_model_type'][0]['name_rm'];

$suffics = $this->_suffics;

$suffics = $this->_suffics;

$table = $suffics.'_service_to_m_models';
$join_field = $suffics.'_service_syn_id';
$join_table = $suffics.'_service_syns';
$main_table = $suffics.'_services';
$main_field = $suffics.'_service_id';
$cost_table = $suffics.'_service_costs';

$popular = " AND `{$main_table}`.`popular` = 1";
$non_popular = " AND (`{$main_table}`.`popular` = 0 OR `{$main_table}`.`popular` IS NULL)";
$end_sql = "";

$sql = "SELECT `{$table}`.id as 'service_id', `{$join_table}`.`name` as 'name', `{$cost_table}`.* FROM `{$table}`
            INNER JOIN `{$join_table}` ON `{$table}`.`{$join_field}` = `{$join_table}`.`id`
            INNER JOIN `{$main_table}` ON `{$main_table}`.`id` = `{$join_table}`.`{$main_field}`
            INNER JOIN `{$cost_table}` ON `{$main_table}`.`id` = `{$cost_table}`.`{$main_field}`
        WHERE `{$table}`.`site_id`=:site_id AND `{$table}`.`marka_id`=:marka_id AND `{$table}`.`type` = 3 AND `{$cost_table}`.`setka_id`=:setka_id";

$stm = pdo::getPdo()->prepare($sql.$popular.$end_sql);
$stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));
$other_services = $stm->fetchAll(\PDO::FETCH_ASSOC);

if (count($other_services) < 4)
{
    $stm = pdo::getPdo()->prepare($sql.$non_popular.$end_sql);
    $stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));

    $other_services = array_merge($other_services, $stm->fetchAll(\PDO::FETCH_ASSOC));
}

srand($this->_datas['feed']);
shuffle($other_services);
srand();
//$other_services = array_slice($other_services, 0, 4);

$defects = [];

$stmt = pdo::getPdo()->query("SELECT name, url, model_type_id FROM 7_defects WHERE model_type_id IN ($model_type_id)");
$i=0;
foreach ($stmt->fetchAll() as $def) {
	$defects[$i]['name'] = $def['name'];
	$defects[$i]['url'] = $def['url'];
	$i++;
}

$marka_lower = mb_strtolower($this->_datas['marka']['name']);

$feed = $this->_datas['feed'];

?>

<main>

    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <ul class="breadcrumbs-inside">
                    <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                    <li itemprop="name">
                        <a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/" itemprop="url">
                            Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?>
                        </a>
                    </li>
                    <li itemprop="name"><span><?=$this->_datas['defect']['name']?></span></li>
                </ul>
            </div>
        </div>
    </section>
	<?
	for($j=0; $j<count($defects); $j++) {
		if ($defects[$j]['name'] == $this->_datas['defect']['name']) {
			if ($j == count($defects)-1) {
				$j = 0;
			} else {
				$j++;
			}
			break;
		}
	}

	?>
    <section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h1 style="float: left;"><?=$this->_ret['h1']?></h1>
				<?if (count($defects) > 1):?><a class="btn btn-link btn-next" style="float: right; line-height: 29px;" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/<?=$defects[$j]['url']?>/"><?=$defects[$j]['name']?></a><?endif;?>
            </div>
        </div>
    </section>

    <section class="block-section">
        <div class="container">
            <div class="grid-12">
                <div class="block-list">
                    <div class="block block-small block-text-image">
                        <p><?=$this->_ret['plain']?></p>
                    </div>
                    <? include __DIR__.'/block-recall.php' ?>
					<div class="block block-auto block-full block-table block-service-table">
						<div class="block-inside">
							<h2>Все услуги по ремонту <?=$model_type_name_rm?> <?=$this->_datas['marka']['name']?></h2>
							<div class="services-item-table services-item-table-full">
								<a class="services-item-row" style="color: black; font-weight: 500;">
									<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
									<span class="services-item-value">Стоимость, руб</span>
									<span class="services-item-callback"></span>
								</a>
								<? for ($i=0; $i<count($other_services); $i++): ?> 
									<? $value = $other_services[$i]; ?>
									<?// if ($i == 7/*count($other_services)-1*/): ?>
										<!--</div><div id="part_opt" style = "display: none;" class="services-item-table services-item-table-full">-->
									<? //endif; ?>
									
									<div class="a services-item-row">
										<a class="services-item-name" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));?>/"><?=tools::mb_firstupper($value['name'])?></a>
										<? if ($eds):?><span class="services-item-value"><?=tools::format_price($value['price'], $setka_name);?></span><?endif;?>
										<!--<span class = "services-item-callback"><button href="#callback" class="btn btn-dark" data-toggle="modal">Заказать звонок</button></span>-->
                                        <span class="services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
									</div>
									
									<? //if ($i == count($other_services)-1 && count($other_services) > 7): ?>
										<!--</div><div class="services-item-table services-item-table-full"><a class="btn btn-dark btn-mt part_opt" id="toggle_part_opt" style="display: block; text-align: center; margin: 15px auto 0px;">Показать все услуги</a>-->
									<? //endif; ?>
								<? endfor; ?>
							</div>
						</div>
					</div>
                    <div></div>
                </div>
            </div>
        </div>
		<? include __DIR__.'/block-promo.php' ?>
    </section>

    <section class="link-block-section">
        <div class="container">
            <div class="grid-12">
                <div class="link-block-list">
                      <? foreach ($this->_datas['blocks'] as $block)
                            echo sc::_createTree($block, $feed); ?>
                </div>
            </div>
    </section>

</main>
