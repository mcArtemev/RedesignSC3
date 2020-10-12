<?php

use framework\tools;
use framework\ajax\parse\hooks\sc;

/* Variables and collections */
$feed = $this->_datas['feed'];
$brand_name = $this->_datas['arg_url'];
$typesName = $this->getTypesByBrand($brand_name);
$curBrand = $this->_datas['curBrand'];

$brandsName = isset($brandsName) ? $brandsName : $this->brands;
$salesBrands = array_column($this->_datas['brands_special'], 0);

$brandsAll = array();
foreach ($brandsName as $brand) {
    srand(tools::gen_feed($brand . $this->_datas['region']['geo_region'] . $this->_datas['region']['translit1']));
    $brandsAll[mb_strtolower($brand)]['name'] = $brand;
    if (in_array($brand, $salesBrands))
        $brandsAll[mb_strtolower($brand)]['sale'] = round(rand(5, 30) / 5) * 5;
}
?>
    <header class="secondary main_block">
        <div class="container">
            <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="name" href="/">Главная</a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span itemprop="name"><?= $this->_ret['h1']; ?></span>
                    <meta itemprop="position" content="2"/>
                </li>
            </ul>
            <div class="row">
                <div class="col-sm-5">
                    <div class="brand-logo">
                        <div class="logo__inner logo__inner-mod"
                             style="background-image: url(/custom/saapservice/img/brands/<?= $brand_name; ?>-logo.png);">
						</div>
                        <?php if (isset($brandsAll[$brand_name]['sale'])) :; ?>
                            <span class="discount"><?= $brandsAll[$brand_name]['sale'] ?>%</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-sm-7 brand-top" itemscope itemtype="http://schema.org/Service">
                    <span itemprop="areaServed" itemscope itemtype="http://schema.org/State">
                        <span itemprop="name" content="Сервисный центр <?= $this->_datas['servicename'] . ' в ' . $this->_datas['region']['name_de']; ?>"></span>
                    </span>
                    <h1><?= $this->_ret['h1']; ?></h1>
                    <p class="brand-desc text-justify"><?= $this->_ret['banner_text']; ?></p>
					<p class="motto">Ремонтируем то, что другие сервисы не могут!</p>
                </div>
            </div>
        </div>
    </header>
<? $types = isset($typesName) ? $typesName : $this->device_types; ?>
<div class="main-content">
    <div class="content brand-content">
        <div class="container">
            <div class="row">
                <?php foreach ($types as $t => $type) :; ?>
                        <?php if('/' === $this->_datas['arg_url'] && 'game-console' === $t) continue;?>

                            <a href="/<?= isset($curBrand) ? strtolower($curBrand) . '/' . $t : $t; ?>-service/">

                            <div class="col-sm-6 block">
                                <div class="block__inner" <?= '/' !== $this->_datas['arg_url'] ?  'style="background-color: #fff;"' : ''; ?>>
                                    <p class="cat-title"><?= tools::mb_ucfirst($type[1]); ?></p>
                                    <div class="cat-image">
                                        <!--<img src="/custom/saapservice/img/cat-<?= $t; ?>-blur.png" alt="" class="blur img-responsive">-->
                                        <img src="/custom/saapservice/img/brend_type/<?=$brand_name?>-<?= $t; ?>.png" alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>

                            </a>

                <?php endforeach; ?>
            </div>
            <?php /*include __DIR__ . '/inc/types_block.php';*/ ?>
        </div>
    </div>
</div>
<?php include __DIR__ . "/inc/repair_mesh.php";?>
<section id="scheme">
    <div class="container">
        <h2 style="text-align: center;">Схема работы и преимущества</h2>
        <?php include __DIR__ . "/inc/work_scheme.php";?>
        <?php include __DIR__ . "/inc/guaranty_block.php";?>
    </div>
</section>
<? include __DIR__ . '/modal.php'; ?>