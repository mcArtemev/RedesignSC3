<?php
$isMSK = $this->_datas['region']['geo_region'] === 'MOW' ? true : false;
?>
<header class="secondary order-master">
    <div class="container">
        <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="name" href="/">Главная</a>
                <meta itemprop="position" content="1"/>
            </li>
            <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">Выезд мастера</span>
                <meta itemprop="position" content="2"/>
            </li>
        </ul>
        <!--<a href="/"><p class="back-home">Вернуться на главную страницу</p></a>-->
    </div>
</header>

<div class="master-banner  pt-40 pb-55">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                    <h1><?= $this->_ret['h1'] ?></h1>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-justify"><?= $this->_ret['txt_11']; ?> <?= $this->_ret['txt_12']; ?> Это выгодно и удобно. Выезд в пределах <?=  $isMSK ? 'МКАД' : 'города'; ?> осуществляется <span>бесплатно!</span></p>
                    </div>
                <?php if ($isMSK) :; ?>
                        <div class="col-sm-6">
                            <table class="mti-0 mbi-10" style="margin-left: 40px;">
                                <tr>
                                    <td class="first-col">По <?= $this->_datas['region']['name_pe']; ?></td>
                                    <td class="sec-col">Бесплатно</td>
                                </tr>
                                <tr>
                                    <td class="first-col">Выезд за МКАД до 5км</td>
                                    <td class="sec-col">200 <span>руб.</span></td>
                                </tr>
                                <tr>
                                    <td class="first-col">От 5 до 30 км от МКАД</td>
                                    <td class="sec-col">400 <span>руб.</span></td>
                                </tr>
                                <tr>
                                    <td class="first-col">От 30 км от МКАД</td>
                                    <td class="sec-col">900 <span>руб.</span></td>
                                </tr>
                            </table>
                        </div>
                <?php else :; ?>
                    <div class="col-sm-6" style="margin-bottom: 30px;">
                        <table class="mti-0 mbi-10" style="margin-left: 40px;">
                            <tr>
                                <td class="first-col">По <?= $this->_datas['region']['name_de']; ?></td>
                                <td class="sec-col">Бесплатно</td>
                            </tr>
                            <tr>
                                <td class="first-col">За пределы города не далее 10км</td>
                                <td class="sec-col">150 <span>руб.</span></td>
                            </tr>
                            <tr>
                                <td class="first-col">Дальше 10 км от города не более</td>
                                <td class="sec-col">800 <span>руб.</span></td>
                            </tr>
                        </table>
                    </div>
                <?php endif; ?>
                </div>
                <a href="#" class="btn scroll-btn mti-10">Вызвать мастера</a>

            </div>
        </div>
    </div>
</div>

<div class="master-desc">
    <div class="container">
        <h2><?= $this->_ret['h2']; ?></h2>
        <p class="text-justify mb-30"><?= $this->_ret['txt_21']; ?> <?= $this->_ret['txt_22']; ?>
            <?= $this->_ret['txt_23']; ?> <?= $this->_ret['txt_24']; ?> <?= $this->_ret['txt_25']; ?>
            <?= $this->_ret['txt_26']; ?>
            <?= $this->_ret['txt_27']; ?>
            <?= $this->_ret['txt_28']; ?></p>
        <?php include __DIR__ . '/inc/work_scheme.php'; ?>
    </div>
</div>
