<?php

use framework\tools;

use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\model_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$service = $this->_datas['service'];
$feed = $this->_datas['feed'];
$models = model_service::getForTypeMark($this->_datas['model_type']['id'], $this->_datas['marka']['id'], $this->_datas['site_id']);
$otherServices = service_service::getForType($service['type']);

$minCost = $service['cost'];
$minTime = $service['time'];

helpers6::shuffle($models, 0, $feed);

$one = $two = $tree = [];
$rep = false;

foreach ($otherServices as $k=>$v) {
	if ($service['id'] == $v['id']) { $rep = true; continue; }
	if ($v['urlWork'] != 1) {
		$tree[] = $v;
	}
	else if ($rep) {
		$one[] = $v;
	}
	else {
		$two[] = $v;
	}
}

$otherServices = array_merge($one, $two, $tree);

?>

<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [$this->_datas['types_urls'][$this->_datas['model_type']['name']], 'Ремонт '.$this->_datas['model_type']['name_rm']],
	[0, service_service::ucNames(tools::mb_ucfirst(tools::get_rand($service['names'], $this->_datas['feed'])))],
]); ?>

<main class="page-main">

	<section class="part">
		<div class="container">
			<header class="part-header">
				<h1 class="part-title__left"><?=$this->_ret['h1']?></h1>
			</header>


			<div class="row">
				<div class="col-md-7 col-sm-7 ">
					<p class="part-txt"><?=$this->_ret['plain']?></p>
					<div class="block-select">
						<?php include 'data/inc/minCostTime.php'; ?>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-1 col-sm-5">
					<?php include 'data/inc/form.php'; ?>
				</div>
			</div>
		</div>
	</section>

<?php if (count($otherServices) != 0) { ?>
<section class="">
	<div class="container">
		<h2>Другие услуги</h2>
		<div class="service-price">
			<div class="service-price__item">
				<?php $services = array_slice($otherServices, 0, 10); include 'data/inc/tablePrice.php'; ?>
                  <noindex><p style="font-weight: 300;">Цены указаны за работу специалиста без учета стоимости запчастей.<br/>Стоимость диагностики составляет 500 рублей. В случае проведения ремонтных работ диагностика в подарок.<br> В таблице указано среднее время оказания услуги при условии наличия необходимой для ремонта комплектующей.</p></noindex>
			</div>          
		</div>
	</div>
</section>
<?php } ?>

<?php if (count($models) != 0) { ?>
	<section class="part2">
		<div class="container">
			<h2> Чаще всего ремонтируют</h2>
			<div class="row dell-box">
				<?php foreach(array_slice($models, 0, 4) as $model) {
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
			<?php }  ?>
			</div>
		</div>
	</section>
<?php } ?>
