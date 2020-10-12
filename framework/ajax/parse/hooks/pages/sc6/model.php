<?php

use framework\tools;

use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\model_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$services = service_service::changeCost(service_service::getForType($this->_datas['model_type']['name'], $this->_datas['feed']), $this->_datas['feed']);
$otherModels = model_service::getForTypeMark($this->_datas['model_type']['id'], $this->_datas['marka']['id'], $this->_datas['site_id']);

if (count($services)) {
	$minCost = helpers6::min(array_column($services, 'cost'));
	$minTime = helpers6::min(array_column($services, 'time'));
}

$one = $two = [];
$rep = false;

foreach ($otherModels as $k=>$v) {
	if ($this->_datas['model']['id'] == $v['id']) { $rep = true; continue; }
	if ($this->_datas['model']['id'] != $v['id'] && $rep) {
		$one[] = $v;
	}
	else {
		$two[] = $v;
	}
}

$otherModels = array_merge($one, $two);

?>

<?php helpers6::breadcrumbs([
	['/', 'Главная'],
	[$this->_datas['types_urls'][$this->_datas['model_type']['name']], 'Ремонт '.$this->_datas['model_type']['name_rm']],
	[0, $this->_datas['marka']['name'].' '.$this->_ret['model']['name']],
]); ?>

<main class="page-main">
	<section class="part">
		<div class="container">
			<header class="part-header">
				<h1 class="part-title__left"><?=$this->_ret['h1']?></h1>
			</header>
			<div class="row">
				<div class="col-md-7 col-sm-7">

					<p class="part-txt"><?=$this->_ret['plain']?></p>
					<?php if (count($services)) { ?>
					<ul class="accessories-matrix">
						<li>
							<span>Стоимость</span>
							<p>от <?=$minCost?> рублей</p>
						</li>
						<li>
							<span>Стоимость комплектующих</span>
							<p>от 649 рублей</p>
						</li>
						<li>
							<span>Время замены</span>
							<p>от <?=$minTime?> минут</p>
						</li>
						<li>
							<span>Гарантия</span>
							<p>от 30 дней</p>
						</li>
					</ul>
					<?php } ?>
				</div>
				<div class="col-md-4 col-md-offset-1 col-sm-5">
					<?php include 'data/inc/form.php'; ?>
				</div>
			</div>

		</div>
	</section>

	<?php if (count($services)) { ?>
	<section class="">
		<div class="container">
			<header class="part-title">
				<h3>Услуги по ремонту <?=$this->_datas['model_type']['name_rm']?> <?=$this->_ret['fullName']?></h3>
			</header>
			<div class="service-price">
				<div class="service-price__item">
					<?php
						$maxcount = 10;
						include 'data/inc/tablePrice.php';
					?>
                    <noindex><p style="font-weight: 300;">Цены указаны за работу специалиста без учета стоимости запчастей.<br/>Стоимость диагностики составляет 500 рублей. В случае проведения ремонтных работ диагностика в подарок.<br> В таблице указано среднее время оказания услуги при условии наличия необходимой для ремонта комплектующей.</p></noindex>	
				</div>
			</div>
		
		</div>
	</section>
	<?php } ?>

	<section class="part2">
		<div class="container">
			<header class="part-header">
				<h2 class="part-title__left">Другие модели</h2>
			</header>
			<div class="row dell-box">
				<?php foreach(array_slice($otherModels, 0, 4) as $model) {
					$urlModel = '/'.$this->_datas['types_urls'][$this->_datas['model_type']['name']].'/'.model_service::renderUrl($model['name']).'/';
					$img = '/_mod_files/_img/models/'.service_service::TYPES_TR_NAME[$this->_datas['model_type']['name']].'/'.
					mb_strtolower($this->_datas['marka']['name']).'/'.model_service::renderUrl($model['name']).'.jpg';
					?>
				<div class="col-md-3 col-sm-6 dell-box__item">
					<div class="dell-price">
						<div class="dell-price__img">
							<img src="<?=$img?>" alt="">
						</div>
						<div class="dell-price__title text-left">
							<a href="<?=$urlModel?>"><?=$this->_datas['marka']['name'].' '.$model['name']?></a>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</section>

	<?php srand($this->_datas['feed']); include 'preference.php'; ?>
</main>
