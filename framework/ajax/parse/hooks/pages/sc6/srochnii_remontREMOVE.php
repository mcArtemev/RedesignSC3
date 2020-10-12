<?php
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY

use framework\ajax\parse\hooks\pages\sc6\data\src\type_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$typesIds = type_service::ids($this->_datas['all_devices']);
$services = array_slice(service_service::getPopularForTypes($typesIds, $this->_datas['feed']), 0, 10);
$minTR = service_service::minTimeRepair($typesIds);

?>

<div class="container">
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
        <li class="active">Срочный ремонт</li>
    </ol>
</div>
<main>
    <section class="part-2">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__center part-title__bold" style="font-size: 30px">Срочный ремонт устройств <?=$marka?></h1>
            </div>


                <noindex>
                    <div class="part-col">

                    <div class="part-col__left">
                        <p class="part-txt">Вам повезло стать обладателем техники <?=$marka?>, которая славится по всему миру своей надежностью и всегда популярна. Но если вы заподозрили поломку любимого гаджета, то не нужно расстраиваться. Наши мастера высоко квалифицированы и найдут подход к любому вашему устройству, к каждой модели <?=$marka?>! Мы любим свою работу.</p>
                        <?php if ($minTR !== false) { ?>
                        <div class="part_header">
                            <h2 class="part-title part-title__left part-title__light" style="font-size: 24px;">Срочный ремонт устройств <?=$marka?> - <span>от <?=$minTR?> минут</span>
                            </h2>
                        </div>
                        <?php } ?>
                        <div class="part-img">
                          <img src="/_mod_files/_img/img-12.jpg" alt="">
                        </div>
                        <p class="part-txt">Вам повезло стать обладателем техники <?=$marka?>, которая славится по всему миру своей надежностью и всегда популярна. Но если вы заподозрили поломку любимого гаджета, то не нужно расстраиваться. Наши мастера высоко квалифицированы и найдут подход к любому вашему устройству, к каждой модели <?=$marka?>! Мы любим свою работу.</p>
                        <?php include 'data/inc/popularAll.php'; ?>
                    </div>

                </noindex>



                <div class="part-col__right">
                    <?php include "data/inc/formFeedback.php"; ?>
                    <?php include 'data/inc/infoList.php'; ?>
                </div>
            </div>
        </div>
    </section>
</main>
