<?

use framework\tools;
use framework\rand_it;
use framework\ajax\parse\hooks\sc;

//echo '<div style="display:none">'.print_r($this->_datas, true).'</div>';
$img_link = strtolower($this->_datas['marka']['name']) . '-' . substr($this->_datas['arg_url'], strpos($this->_datas['arg_url'], '/') + 1, strpos($this->_datas['arg_url'], '-') - strpos($this->_datas['arg_url'], '/')-1);

function conv2utf($str) {
	return mb_convert_encoding($str, 'windows-1251', 'utf-8');
}

srand($this->_datas['feed']);
switch (mb_strtolower($this->_datas['orig_model_type'][0]['name'])) {
	case 'смартфон':
		$now_model_id = 0;
		$ModelsOutput = array();
		if (($handle = fopen(__DIR__ . "/data/models_telefonov.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
				if ($data[0] != "Бренд") {
					if (mb_strtolower($data[0]) == mb_strtolower($this->_datas['marka']['name'])) {
						$now_model_id++;
						$ModelsOutput[] = [
							"model_id"  => $now_model_id,
							"model"     => str_replace("&nbsp;", ' ', htmlentities($data[1]))
						];
					}
				}
			}
			fclose($handle);
		}
		$ModelsOutput = array_slice($ModelsOutput, 0, 15);
	break;
	default:
		$now_model_id = 0;
		$ModelsOutput = array();
		if (($handle = fopen(__DIR__ . "/data/models.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
				if ($data[0] != "Модель") {
					if (mb_strtolower($data[2]) == mb_strtolower($this->_datas['orig_model_type'][0]['name']) && mb_strtolower($data[1]) == mb_strtolower($this->_datas['marka']['name'])) {
						$now_model_id++;
						$ModelsOutput[] = [
							"model_id"  => $now_model_id,
							"model"     => $data[0],
							//"brand"   => $data[1],
							//"type"    => $data[2]
						];
					}
				}
			}
			fclose($handle);
		}
	break;
}

$complectsOutput = array();
if (($handle = fopen(__DIR__ . "/data/prices.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 4096, ';')) !== FALSE) {
		if ($data[0] != "Наименование") {
			if ($data[1] == $this->_datas['orig_model_type'][0]['name']) {
				$complectsOutput[] = [
					"name"      => $data[0],
					"time"      => $data[4],
					"price_min" => $data[2],
					"price_max" => $data[3],
					"price"     => (int)(rand(($data[2]/100), ($data[3]/100))*100),
				];
			}
		}
    }
    fclose($handle);
}
?>
    <header class="secondary page-device-type main_block">
        <div class="container">
            <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="name" href="/">Главная</a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span itemprop="name"><?= $this->_ret['h1'] ?></span>
                    <meta itemprop="position" content="2"/>
                </li>
            </ul>
            <div class="row">
                <div class="col-sm-6">
                    <div class="device-image">
                        <img src="/custom/saapservice/img/brend_type/<?= $img_link; ?>.png" alt="">
                    </div>
                </div>
                <div class="col-sm-6 brand-top" itemscope itemtype="http://schema.org/Service">
                    <span itemprop="areaServed" itemscope itemtype="http://schema.org/State">
                        <span itemprop="name" content="Сервисный центр <?= $this->_datas['servicename'] . ' в ' . $this->_datas['region']['name_de']; ?>"></span>
                    </span>
                    <h1><?= $this->_ret['h1'] ?></h1>
                    <p class="brand-desc"><?= $this->_ret['paragraph_1']; ?></p>
					<p class="motto">Ремонтируем то, что другие сервисы не могут!</p>
                </div>
            </div>
        </div>
    </header>
	<section id="services">
		<div class="container">
			<div class="service-tabs">
				<ul class="tabs" role="tablist" style="display: none;">
					<?php foreach ($ModelsOutput as $model) :; ?>
						<li class="tabsli <?php if ($model['model_id'] == 1) echo " active"; ?>" role="presentation"><span href="#m<?=$model['model_id']?>" aria-controls="m<?=$model['model_id']?>" role="tab" data-toggle="tab"><?=$model['model']?></span></li>
					<?php endforeach; ?>
				</ul>
				<select style="display: none;">
					<?php foreach ($ModelsOutput as $model) :; ?>
						<option value="<?=$model['model_id']?>"><?=$model['model']?></option>
					<?php endforeach; ?>
				</select>
				<div class="tab-content">
					<?php foreach ($ModelsOutput as $model) :; ?>
					<div role="tabpanel" class="tab-pane<?php if ($model['model_id'] == 1) echo " active"; ?>" id="m<?=$model['model_id']?>">
						<div class="table-wrapper">
							<table class="model-repair">
								<thead>
									<tr>
										<td>Наименование услуги</td>
										<td>Время</td>
										<td>Цена, руб.</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
								<? /* rand(($complect['price_min']/100), ($complect['price_max']/100))*100; */ ?>
								<?php foreach ($complectsOutput as $complect) :; ?>
									<?php if (!$complect) continue; ?>
									<tr data-link="#getPrice" data-toggle="modal" data-target="#getPrice"  data-type="complect">
										<td class="service-name"><?= $complect['name']; ?></td>
										<td class="service-available"><?= $complect['time']; ?> мин.</td>
										<td class="service-price"><span class="price"><?=$complect['price']?></span></td>
										<td class="service-order"><span class="getsel">Заказать</span></td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<div class="row mb-30" style="padding-top: 25px;">
							<div class="col-sm-8">
								<p style="color: #777; font-size: 14px;" class="mt-20 mbi-0">Стоимость комплектующих уточняйте у менеджеров по телефону: <span style="white-space: nowrap;">+<?= tools::format_phone($this->_datas['phone']) ?></span></p>
							</div>
							<div class="col-sm-4 text-right">
								<a href="#getPrice" class="btn btn-gr" data-toggle="modal" data-target="#getPrice">Узнать стоимость ремонта</a>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<style>
		.slider_img {
			width: 250px;
			height: 310px!important;
		}
		.slide_data {
			position: absolute;
			background-color: rgba(255, 255, 255, 0.75);
			left: 0;
			bottom: 0;
			width: 250px;
			height: 60px;
			text-align:center;
		}
		.thumbnail {
			margin-bottom: 0;
		}
	</style>
    <section id="scheme"  style="padding-bottom: 0;">
        <div class="container">
		<?php
		
		$company = [
			["name" => "Михеев Всеволод", "post" => "Мастер по ремонту телефонов", "img" => "/custom/saapservice/img/company/comand1.jpg"],
			["name" => "Кулаков Данил", "post" => "Мастер по ремонту ноутбуков", "img" => "/custom/saapservice/img/company/comand5.jpg"],
			["name" => "Третьякова Линда", "post" => "Администратор", "img" => "/custom/saapservice/img/company/comand3.jpg"],
			["name" => "Дубинин Святослав", "post" => "Мастер по ремонту планшетов", "img" => "/custom/saapservice/img/company/comand4.jpg"],
			["name" => "Евсеева Полина", "post" => "Администратор", "img" => "/custom/saapservice/img/company/comand6.jpg"],
			["name" => "Овикян Алекс", "post" => "Мастер по ремонту телевизоров", "img" => "/custom/saapservice/img/company/comand2.jpg"],
			["name" => "Тимашева Яна", "post" => "Администратор", "img" => "/custom/saapservice/img/company/comand7.jpg"],
			["name" => "Кимаск Юрий", "post" => "Мастер по ремонту фотоаппаратов", "img" => "/custom/saapservice/img/company/comand8.jpg"],
			["name" => "Гальцева Елена", "post" => "Администратор", "img" => "/custom/saapservice/img/company/comand9.jpg"],
			["name" => "Фомин Илья", "post" => "Мастер по ремонту моноблоков", "img" => "/custom/saapservice/img/company/comand10.jpg"],
			["name" => "Ягудин Олег", "post" => "Мастер по ремонту видеокамер", "img" => "/custom/saapservice/img/company/comand11.jpg"],
			["name" => "Сытников Никита", "post" => "Мастер по ремонту планшетов", "img" => "/custom/saapservice/img/company/comand12.jpg"],
			["name" => "Золотарёв Игорь", "post" => "Мастер по ремонту телефонов", "img" => "/custom/saapservice/img/company/comand13.jpg"],
			["name" => "Корнеев Илья", "post" => "Мастер по ремонту фотоаппаратов", "img" => "/custom/saapservice/img/company/comand14.jpg"],
			["name" => "Косинов Артём", "post" => "Мастер по ремонту телефонов", "img" => "/custom/saapservice/img/company/comand15.jpg"]
		];
		
		shuffle($company);
		
		?>
			<div class="row">
				<div class="col-sm-6 block-container">
					<div class="thumbnail" style="width: 260px; height: 320px; margin-left: auto; margin-right: auto;">
						<div id="carousel" class="carousel slide" data-ride="carousel">
						  <div class="carousel-inner">
							  <?php $i=0; foreach($company as $value) { $i++; ?>
								<div class="item <?php if ($i==1) { echo "active"; } ?>">
									<img src="<?=$value['img']?>" class="slider_img" alt="">
									<div class="slide_data">
										<p class="name mbi-0" style="line-height: 30px;"><strong><?=$value['name']?></strong></p>
										<p class="post" style="font-size: 14px;"><?=$value['post']?></p>
									</div>
								</div>
							  <?php } ?>
						  </div>
						  <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
							<img style="width: 7px; height: 12px; position: absolute; top: 50%; margin-top: -6px; margin-left: -3.5px; left: 50%;" src="/custom/saapservice/img/pagination-arr-left.png"/>
						  </a>
						  <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
							<img style="width: 7px; height: 12px; position: absolute; top: 50%; margin-top: -6px; margin-left: -3.5px; left: 50%;" style="vertical-align: middle;" src="/custom/saapservice/img/pagination-arr-right.png"/>
						  </a>
						</div>
					</div>
				</div>
				<div class="col-sm-6 block-container">
					<h3>Опытные сотрудники</h3>
					<p>
						Обращаясь в наш сервисный центр, вы доверяете свой <?=$this->_datas['orig_model_type'][0]['name']?> <?=$this->_datas['marka']['name']?> профессионалам своего дела. Мастера разбираются в специфике бренда, это позволяет устранить любую неисправность. Сервис предлагает:
						<ul style="list-style-type: disc; margin-left: 40px;">
							<li>Выполнение работ, контролируемое на всех этапах</li>
							<li>Четкое соблюдение сроков ремонта</li>
							<li>Гарантию на работы и поставленные детали</li>
						</ul>
					</p>
				</div>
			</div>
        </div>
    </section>
    <section id="scheme">
        <div class="container">
			<?php include __DIR__ . "/inc/guaranty_block.php";?>
        </div>
    </section>
	<style>
		.content {
			padding-bottom: 20px;
		}
	</style>
	<?php include __DIR__ . "/inc/repair_mesh.php";?>
    <section id="scheme" style="background-color: #fff; margin-top: -40px;">
        <div class="container">
            <h2 style="text-align: center;">Схема работы</h2>
			
            <?php include __DIR__ . "/inc/work_scheme.php";?>

        </div>
    </section>
<? include __DIR__ . '/modal.php'; ?>