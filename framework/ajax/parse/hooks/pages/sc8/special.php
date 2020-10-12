<?php
use framework\rand_it;
use framework\tools;
    $special_offer = include __DIR__ . '/data/specials.php';

    $special_offer_temp = rand_it::randMas($special_offer, 4, '', $this->_datas['feed']);
?>
<header class="secondary main_block">
    <div class="container">
        <ul class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="name" href="/">Главная</a>
                <meta itemprop="position" content="1"/>
            </li>
            <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">Наши акции</span>
                <meta itemprop="position" content="2"/>
            </li>
        </ul>
        <h1><?= $this->_ret['h1'] ?></h1>
        <!--<a href="/"><p class="back-home">Вернуться на главную страницу</p></a>-->
    </div>
</header>

    <div class="main-content page-actions pbi-0">
      <div class="container">
        <div class="row">
            <?php $temp_row = 0; ?>
            <?php foreach ($special_offer_temp as $offer) :;?>
                <?php $temp_row++?>
              <div class="col-sm-6 actions-row">
                <div class="action-block" style="margin-bottom: 30px">
                  <div class="action-title" style="background-image: url(/custom/saapservice/img/stock/<?= $offer[1]?>.jpg);">
                    <h3 style="min-height: 64px; padding: 0.5em; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,.7); border-radius: 7px;"><?= $offer[0] ;?></h3>
                  </div>
                  <div class="action-text">
                    <p style="min-height: 115px"><?= $offer[2] ;?></p>
                  </div>
                </div>
              </div>
                <?php if($temp_row == 2) :; ?>
                    </div><div class="row">
                <?php $temp_row = 0; endif;?>
            <?php endforeach; ?>
        </div>
      </div>
    </div>