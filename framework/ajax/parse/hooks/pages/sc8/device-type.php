<?php

use framework\ajax\parse\hooks\sc;

/* Variables and collections */
$feed = $this->_datas['feed'];
$devices_types = $this->device_types;
$dev_type_name = $this->_datas['dev_type_name'];
$brandsName = $this->getBrandsByType($dev_type_name);
echo '<div style="display:none">'.print_r($this->_datas, true).'</div>';
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
                        <img src="/custom/saapservice/img/products/<?= $dev_type_name; ?>.png" alt="">
                    </div>
                </div>
                <div class="col-sm-6 brand-top" itemscope itemtype="http://schema.org/Service">
                    <span itemprop="areaServed" itemscope itemtype="http://schema.org/State">
                        <span itemprop="name" content="Сервисный центр <?= $this->_datas['servicename'] . ' в ' . $this->_datas['region']['name_de']; ?>"></span>
                    </span>
                    <h1><?= $this->_ret['h1'] ?></h1>
                    <p class="brand-desc text-justify"><?= $this->_ret['banner_text']; ?></p>
					<p class="motto">Ремонтируем то, что другие сервисы не могут!</p>
                </div>
            </div>
        </div>
    </header>

<div class="main-content">
    <?php include __DIR__ . '/inc/brands_block.php'; ?>
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