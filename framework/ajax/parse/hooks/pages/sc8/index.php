<?php

use framework\tools;
use framework\rand_it;
use framework\ajax\parse\hooks\sc;

srand($this->_datas['feed']);
$procent = rand(96, 99);
$personas = rand(15, 25);
$devices = rand(1300, 1800);
$number = rand(7, 12);

// Get services
$services = $this->getServices($this->device_types_suf);

$servicesOutput = rand_it::randMas(array_merge(
    rand_it::randMas($services['f'], 3, '', tools::gen_feed($this->device_types_suf['f'][0])),
    @rand_it::randMas($services['n'], 3, '', $this->_datas['feed']),
    rand_it::randMas($services['p'], 3, '', tools::gen_feed($this->device_types_suf['p'][0]))
), 8, '', $this->_datas['feed']);

// Get Complect
$complects = array();

foreach ($this->device_types_suf as $suf => $type) {
    if ($suf == 'p') continue;
    $sql = <<<QUERY
      SELECT syns.name, syns.{$suf}_complect_id AS complect_id, costs.prices FROM {$suf}_complect_syns AS syns
      LEFT JOIN {$suf}_complect_costs AS costs ON syns.{$suf}_complect_id = costs.{$suf}_complect_id
QUERY;

    $complectsRaw = $this->dbQuery($sql);

    foreach ($complectsRaw as $complect) {
        $complects[$suf][$complect['complect_id']]['name'][] = sc::_createTree([$complect['name']], $this->_datas['feed']);
        $complects[$suf][$complect['complect_id']]['price'] = sc::_createTree([explode(';', $complect['prices'])], tools::gen_feed($complect['name'][0]));
    }
    unset($sql, $complectsRaw, $complect);
}

unset($suf, $type);

//$complectsOutput = rand_it::randMas(array_merge(
//    rand_it::randMas($complects['n'], 15, '', $this->datas['feed']),
//    rand_it::randMas($complects['f'], 15, '', $this->datas['feed'])
//), 30, '', $this->_datas['feed']);

$complectsAllType = array();

foreach ($complects['n'] as $complect) {
    $complectsAllType[sc::_createTree([$complect['name']], tools::gen_feed($complect['name'][0]))]['name'] = sc::_createTree([$complect['name']], tools::gen_feed($complect['name'][0]));
    $complectsAllType[sc::_createTree([$complect['name']], tools::gen_feed($complect['name'][0]))]['price'] = $complect['price'];
    $complectsAllType[sc::_createTree([$complect['name']], tools::gen_feed($complect['name'][0]))]['instock'] = sc::_createTree([array('В наличии', 'На складе')], tools::gen_feed($complect['name'][0]));
}
unset($complect);
unset($complect);

foreach ($complects['f'] as $complect) {
    $complectsAllType[sc::_createTree([$complect['name']], tools::gen_feed($complect['name'][0]))]['name'] = sc::_createTree([$complect['name']], tools::gen_feed($complect['name'][0]));
    $complectsAllType[sc::_createTree([$complect['name']], tools::gen_feed($complect['name'][0]))]['price'] = $complect['price'];
    $complectsAllType[sc::_createTree([$complect['name']], tools::gen_feed($complect['name'][0]))]['instock'] = sc::_createTree([array('В наличии', 'На складе')], tools::gen_feed($complect['name'][0]));
}
unset($complect);

$complectsOutput = @rand_it::randMas($complectsAllType, 13, '', $this->_datas['feed']);

// Get defects
$defects = array();

foreach ($this->device_types_suf as $suf => $type) {
    $sql = "SELECT name FROM {$suf}_defect_syns";

    $defectsRaw = $this->dbQuery($sql);

    foreach ($defectsRaw as $defect) {
        $defects[sc::_createTree([$defect['name']], $this->_datas['feed'])] = '';
    }
    unset($sql, $defectsRaw, $defect);
}
unset($suf, $type);

$defectsOutput = rand_it::randMas(array_keys($defects), 18, '', $this->_datas['feed']);

/* Text generation */
$servicename = $this->_datas['servicename'];
$city = $this->_datas['region']['name_pe'];
$feed = !empty($this->_datas['feed']) ? $this->_datas['feed'] : tools::gen_feed($this->_datas['arg_url']);
?>

    <header class="backindeximg">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <h1><?= $this->_ret['h1'] ?></h1>
                    <p><?= $this->_ret['banner_txt']; ?></p>
                    <ul>
                        <?php foreach ($this->_ret['$banner_list'] as $li) :; ?>
                            <li><span class="list-circle"></span><?= $li; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-sm-5">
                    <img class="header-phones" src="/custom/saapservice/img/header-phones.png" alt="">
                </div>
            </div>
        </div>
    </header>
	<? /*
    <section id="services">
        <div class="container">
            <div class="service-tabs">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="col-sm-4 text-center active">
                        <a href="#popular" aria-controls="popular" role="tab" data-toggle="tab">
                            <p>Популярные услуги</p>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 394 40"
                                 enable-background="new 0 0 394 40" xml:space="preserve">
                <g>
                    <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" points="372,0 22,0 0,40 394,40"/>
                </g>
                </svg>
                        </a>
                    </li>
                    <li role="presentation" class="col-sm-4 text-center">
                        <a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">
                            <p>Комплектующие</p>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 394 40"
                                 enable-background="new 0 0 394 40" xml:space="preserve">
                <g class="active">
                    <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" points="372,0 22,0 0,40 394,40"/>
                </g>
                </svg>
                        </a>
                    </li>
                    <li role="presentation" class="col-sm-4 text-center">
                        <a href="#malfunctions" aria-controls="malfunctions" role="tab" data-toggle="tab">
                            <p>Неисправности</p>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 394 40"
                                 enable-background="new 0 0 394 40" xml:space="preserve">
                <g class="active">
                    <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" points="372,0 22,0 0,40 394,40"/>
                </g>
                </svg>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="popular">
                        <div class="row mb-30">
                            <div class="col-sm-6">
                                <!--                  <h3>Популярные услуги</h3>-->
                                <p class="desc mt-20 mbi-0">Уточняйте все цены у наших менеджеров</p>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="#getPrice" class="btn btn-gr" data-toggle="modal" data-target="#getPrice" data-type="price">Узнать стоимость ремонта</a>
                            </div>
                        </div>
                        <div class="row" data-op="1">
                            <?php $temp_row = 0; ?>
                            <?php foreach ($servicesOutput as $key => $service) :; ?>
                            <?php $temp_row++; ?>
                            <div class="col-sm-6 card-col">
                                <a href="#getPrice" class="card" data-toggle="modal" data-target="#getPrice" data-type="service">
                                    <p class="card-title"><?= sc::_createTree([$service['name']], $this->_datas['feed']); ?></p>
                                    <p class="card-time">Среднее время исполнения: <?= $service['time']; ?> мин</p>
                                    <p class="card-price">
                                        Стоимость: <span
                                                class="price"><?= (int)$service['price'] !== 0 ? $service['price'] . ' р' : 'бесплатно'; ?></span>
                                    </p>
                                    <p class="order">Записаться на услугу</p>
                                </a>
                            </div>
                            <?php if ($temp_row == 2 && $key !== count($servicesOutput) - 1) :; ?>
                        </div>
                        <div class="row">
                                <?php $temp_row = 0; endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="/about/services-list/" class="btn btn-big">Посмотреть все услуги</a>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="accessories">
                        <!--              <h2>Комплектующие для холодильника Indesite IB 181</h2>-->
                        <div class="row mb-30">
                            <div class="col-sm-6">
                                <!--                  <h3>Популярные услуги</h3>-->
                                <p class="desc mt-20 mbi-0">Уточняйте все цены у наших менеджеров</p>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="#getPrice" class="btn btn-gr" data-toggle="modal" data-target="#getPrice">Узнать стоимость ремонта</a>
                            </div>
                        </div>
                        <div class="table-wrapper">
                            <table class="model-repair">
                                <thead>
                                <tr>
                                    <td>Наименование</td>
                                    <td class="available">Наличие</td>
                                    <td>Стоимость, р</td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($complectsOutput as $complect) :; ?>
                                    <?php if (!$complect) continue; ?>
                                    <tr data-link="#getPrice" data-toggle="modal" data-target="#getPrice"  data-type="complect">
                                        <td class="service-name"><?= $complect['name']; ?></td>
                                        <td class="service-available"><span class="av"><?= $complect['instock']; ?></span></td>
                                        <td class="service-price"><span class="price"><?= $complect['price']; ?></span>
                                        </td>
                                        <td class="service-order">Заказать</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="malfunctions">
                        <!--              <h2>Неисправности холодильника Indesite IB 181</h2>-->
                        <div class="row mb-30">
                            <div class="col-sm-6">
                                <!--                  <h3>Популярные услуги</h3>-->
                                <p class="desc mt-20 mbi-0">Уточняйте все цены у наших менеджеров</p>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="#getPrice" class="btn btn-gr" data-toggle="modal" data-target="#getPrice">Узнать стоимость ремонта</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="mti-0">
                                    <?php foreach (array_slice($defectsOutput, 0, 9) as $defect) :; ?>
                                        <li style="line-height: 2.3"><?= tools::mb_ucfirst($defect, 'UTF-8', false); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="mti-0">
                                    <?php foreach (array_slice($defectsOutput, 9) as $k => $defect) :; ?>
                                        <li style="line-height: 2.3"><?= tools::mb_ucfirst($defect, 'UTF-8', false); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="service-icons">
                <div class="row">
                    <div class="col-sm-3 text-center">
                        <img src="/custom/saapservice/img/circle-icon.png" alt="">
                        <p>Бесплатная<br> диагностика</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <img src="/custom/saapservice/img/circle-icon.png" alt="">
                        <p>Рекорд по скорости<br>ремонта - 6 минут</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <img src="/custom/saapservice/img/circle-icon.png" alt="">
                        <p>Запчасти всегда<br> в наличии</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <img src="/custom/saapservice/img/circle-icon.png" alt="">
                        <p>Работаем без праздников<br> и выходных</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
	*/?>
	<div class="content content-no-padding">
        <div class="container">
            <?php include __DIR__ . '/inc/types_block.php'; ?>
        </div>
    </div>
    <section id="repair" style="margin-top: 25px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 repair-text">
                    <!--<h3>Ремонт любой техники <?= $this->_datas['region']['geo_region'] === 'MOW' ? '<br>в Москве и московской области' : 'в ' . $city . ' и области' ?></h3>-->
                    <h4>Принципы нашей работы</h4>
					<img style="height: 20px; float: left; line-height: 28px; margin-right: 7px;" src="/custom/saapservice/img/circle-icon@x2.png" class="icon-1">
					<p><strong>Честные цены</strong></p>
					<p>Мы не придумываем цены из головы и работаем по фиксированным ценам указанным на сайте. Услуга не подорожает во время ремонта. По ориентировочной стоимости комплектующих вы можете проконсультироваться по телефону у операторов. После проведения диагностических работ и бронированию запчастей на складе аккаунт-менеджер поможет вам окончательно определиться с перечнем необходимых работ и запчастей.</p>
					<img style="height: 20px; float: left; line-height: 28px; margin-right: 7px;" src="/custom/saapservice/img/circle-icon@x2.png" class="icon-1">
					<p><strong>Сроки ремонта</strong></p>
					<p>Среднее время ремонта в нашем сервисе, даже с учетом всех «сложных» (залитых и выгоревших) и редких аппаратов составляет всего лишь 2,5 дня. В рекордные сроки мы обычно меняем аккумуляторы и дисплейные модуля от 30 минут. Получать столь быстрые ремонты нам удается за счет отлаженной логистики с поставщиками комплектующих.</p>
					<img style="height: 20px; float: left; line-height: 28px; margin-right: 7px;" src="/custom/saapservice/img/circle-icon@x2.png" class="icon-1">
					<p><strong>Диагностика</strong></p>
					<p>Стоимость диагностики составляет 0 рублей, кроме случаев заказа этой услуги отдельной. Заказ диагностики без ремонта – 500 рублей. Среднее время диагностики 25-45 минут. В сложных случаях может требоваться комплексное тестирование. Время тестирования всех компонентов аппарата может доходить до 2-3 дней.</p>
                </div>
                <div class="col-sm-6 repair-img">
                    <img src="/custom/saapservice/img/tablet-img.png" alt="" id="rep-tablet">
                    <img src="/custom/saapservice/img/laptop-img.png" alt="" id="rep-laptop">
                    <img src="/custom/saapservice/img/phone-img.png" alt="" id="rep-phone">
                </div>
            </div>
        </div>
    </section>
	<!--<section id="services">
        <div class="container">
            <div class="service-icons">
                <div class="row">
                    <div class="col-sm-3 text-center">
                        <img src="/custom/saapservice/img/circle-icon.png" alt="">
                        <p>Бесплатная<br> диагностика</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <img src="/custom/saapservice/img/circle-icon.png" alt="">
                        <p>Рекорд по скорости<br>ремонта - 6 минут</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <img src="/custom/saapservice/img/circle-icon.png" alt="">
                        <p>Запчасти всегда<br> в наличии</p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <img src="/custom/saapservice/img/circle-icon.png" alt="">
                        <p>Работаем без праздников<br> и выходных</p>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
	
	<style>
		.brand-content {
			background-color: #fff;
		}
	</style>
    <?php include __DIR__ . '/inc/brands_block.php'; ?>

    <!--<div id="map"></div>-->

    <section id="scheme">
        <div class="container">
            <h2 style="text-align: center;">Схема работы и преимущества</h2>
            <?php include __DIR__ . '/inc/work_scheme.php'; ?>
        </div>
    </section>

    <section id="feedback">
        <div class="container">
            <?php include __DIR__ . '/inc/reviews_block.php'; ?>
        </div>
    </section>

<? include __DIR__ . '/modal.php'; ?>