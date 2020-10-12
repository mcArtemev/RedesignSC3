<?php

use framework\rand_it;
use framework\tools;
use framework\ajax\parse\hooks\sc;

// Get services
$services = $this->getServices($this->device_types_suf, false);

$servicesOutput['f'] = rand_it::randMas($services['f'], 6, '', tools::gen_feed($this->device_types_suf['f'][0]));
$servicesOutput['n'] = rand_it::randMas($services['n'], 6, '', $this->_datas['feed']);
$servicesOutput['p'] = rand_it::randMas($services['p'], 6, '', tools::gen_feed($this->device_types_suf['p'][0]));

$complectsOutput = array();
if (($handle = fopen(__DIR__ . "/data/prices.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 4096, ';')) !== FALSE) {
		if ($data[0] != "Наименование") {
				switch($data[1]) {
					case 'смартфон':
						$data[1] = 'телефон';
						break;
					default:
						break;
				}
				$complectsOutput[$data[1]][] = [
					"name"      => $data[0],
					"time"      => $data[4],
					"price"     => $data[2]
				];
		}
    }
    fclose($handle);
}

function mb_ucfirst($str) {
    $fc = mb_strtoupper(mb_substr($str, 0, 1));
    return $fc.mb_substr($str, 1);
}

$types = $this->device_types;
?>
<header class="secondary main_block">
    <div class="container">
        <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="name" href="/">Главная</a>
                <meta itemprop="position" content="1"/>
            </li>
            <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">Список услуг</span>
                <meta itemprop="position" content="2"/>
            </li>
        </ul>
        <div class="row">
            <div class="col-sm-12">
                <h1><?= $this->_ret['h1'];?></h1>
                <!--<a href="/"><p class="back-home">Вернуться на главную страницу</p></a>-->
            </div>
        </div>
    </div>
</header>

<div class="services-list" itemscope itemtype="http://schema.org/Service">
    <span itemprop="areaServed" itemscope itemtype="http://schema.org/State">
        <span itemprop="name" content="Сервисный центр <?= $this->_datas['servicename'] . ' в ' . $this->_datas['region']['name_de'];?>"></span>
    </span>
    <?php foreach ($types as $type) :; ?>
		<?php if (isset($complectsOutput[$type[0]])) { ?>
			<div class="services-block" itemprop="hasOfferCatalog" itemscope itemtype="http://schema.org/OfferCatalog">
				<div class="container"itemprop="itemListElement" itemscope itemtype="http://schema.org/OfferCatalog">
					<div class="row">
						<div class="col-sm-6 type-title" style="min-height: 85px">
							<span itemprop="name" content="Услуги по ремонту <?= $type[2]; ?>"></span>
							<h3 style="margin-top: 15px"><?= mb_ucfirst($type[1]); ?></h3><br>
						</div>
						<div class="col-sm-6 text-right">
						</div>
					</div>
					<div class="row">
						<?php foreach ($complectsOutput[$type[0]] as $key => $service ) :; ?>
							<div class="col-sm-6 card-col" itemprop="itemListElement" itemscope itemtype="http://schema.org/OfferCatalog">
								<a href="#getPrice" class="card" data-toggle="modal" data-target="#getPrice"  data-type="service">
									<p class="card-title" itemprop="name"><?=$service['name']?></p>
									<p class="card-time">Среднее время исполнения: <?= $service['time']; ?> мин.</p>
									<p class="card-price">
										Стоимость: от <span class="price"><?= (int)$service['price'] !== 0 ? $service['price'] . ' р.' : 'бесплатно' ; ?></span>
									</p>
									<p class="order">Записаться на услугу</p>
								</a>
							</div>
							<?php if($key === count($complectsOutput[$type[0]]) - 1) break;?>
							<?php if(($key + 1) % 2 === 0)  :;?>
								</div><div class="row">
							<?php endif;?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php } ?>
    <?php endforeach; ?>
</div>
<? include __DIR__.'/modal.php'; ?>