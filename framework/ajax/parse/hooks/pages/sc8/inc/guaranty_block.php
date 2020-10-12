<?php

use framework\tools;
use framework\rand_it;
use framework\ajax\parse\hooks\sc;

$feed = $this->_datas['feed'];

$guaranty_1_header = array();
$guaranty_1_header[] = array('Честные цены');

$guaranty_1_txt = array();
$guaranty_1_txt[] = array('Мы не придумываем цены из головы и работаем по фиксированным ценам указанным на сайте. Услуга не подорожает во время ремонта. По ориентировочной стоимости комплектующих вы можете проконсультироваться по телефону у операторов. После проведения диагностических работ и бронированию запчастей на складе аккаунт-менеджер поможет вам окончательно определиться с перечнем необходимых работ и запчастей.');

$guaranty_2_header = array();
$guaranty_2_header[] = array('Доставка');

$guaranty_2_txt = array();
$guaranty_2_txt[] = array('В пределах МКАД действует БЕСПЛАТНАЯ доставка неисправных устройств в сервисный центр. Среднее время выезда курьера 2,5 часа. Стоимость обратной доставки из сервисного центра составляет 500 рублей. Время и расценки на выезд курьера за пределы МКАД согласовывайте с менеджерами компании по телефону: +'.tools::format_phone($this->_datas['phone']));

$guaranty_3_header = array();
$guaranty_3_header[] = array('Сроки ремонта');

$guaranty_3_txt = array();
$guaranty_3_txt[] = array('Среднее время ремонта в нашем сервисе, даже с учетом всех «сложных» (залитых и выгоревших) и редких аппаратов составляет всего лишь 2,5 дня. В рекордные сроки мы обычно меняем аккумуляторы и дисплейные модуля от 30 минут. Получать столь быстрые ремонты нам удается за счет отлаженной логистики с поставщиками комплектующих.');

$guaranty_4_header = array();
$guaranty_4_header[] = array('Диагностика');

$guaranty_4_txt = array();
$guaranty_4_txt[] = array('Стоимость диагностики составляет 0 рублей, кроме случаев заказа этой услуги отдельной. Заказ диагностики без ремонта – 500 рублей. Среднее время диагностики 25-45 минут. В сложных случаях может требоваться комплексное тестирование. Время тестирования всех компонентов аппарата может доходить до 2-3 дней.');
/*
$guaranty_5_header = array();
$guaranty_5_header[] = array('Оригинальные запчасти');

$guaranty_5_txt = array();
$guaranty_5_txt[] = array('При');
$guaranty_5_txt[] = array('ремонте', 'починке');
$guaranty_5_txt[] = array('наши');
$guaranty_5_txt[] = array('мастера', 'специалисты');
$guaranty_5_txt[] = array('используют', 'устонавливают');
$guaranty_5_txt[] = array('только', 'исключительно');
$guaranty_5_txt[] = array('оригинальные');
$guaranty_5_txt[] = array('детали', 'комплектующие');

$guaranty_6_header = array();
$guaranty_6_header[] = array('Выезд на дом');

$guaranty_6_txt = array();
$guaranty_6_txt[] = array('При', 'В случае');
$guaranty_6_txt[] = array('необходимости');
$guaranty_6_txt[] = array('мастер', 'инженер');
$guaranty_6_txt[] = array('может', 'имеет возможность');
$guaranty_6_txt[] = array('приехать к вам');
$guaranty_6_txt[] = array('домой', 'на дом');

$guaranty_7_header = array();
$guaranty_7_header[] = array('Консультация по телефону');

$guaranty_7_txt = array();
$guaranty_7_txt[] = array('Вы можете получить');
$guaranty_7_txt[] = array('консультацию', 'совет');
$guaranty_7_txt[] = array('от', 'у');
$guaranty_7_txt[] = array('наших специалистов по телефону');*/

$guarantyArr = array();

$guarantyArr[] = array('header' => $guaranty_1_header, 'text' => $guaranty_1_txt);
$guarantyArr[] = array('header' => $guaranty_2_header, 'text' => $guaranty_2_txt);
$guarantyArr[] = array('header' => $guaranty_3_header, 'text' => $guaranty_3_txt);
$guarantyArr[] = array('header' => $guaranty_4_header, 'text' => $guaranty_4_txt);
/*$guarantyArr[] = array('header' => $guaranty_5_header, 'text' => $guaranty_5_txt);
$guarantyArr[] = array('header' => $guaranty_6_header, 'text' => $guaranty_6_txt);
$guarantyArr[] = array('header' => $guaranty_7_header, 'text' => $guaranty_7_txt);*/

$guarantyArr = rand_it::randMas($guarantyArr, 4, '', $feed)


?>
<style>
.block-margin {
	padding-right: 15px;
	height: 100%;
}
</style>
<div class="row">
    <?php foreach ($guarantyArr as $k => $guaranty) :; ?>
        <div class="col-sm-6 block-container block-margin">
            <div class="block" style="min-height: 300px;">
                <img style="height: 20px; float: left; line-height: 28px; margin: 4px 7px 4px 0px;" src="/custom/saapservice/img/circle-icon@x2.png" class="icon-1">
				<p class="strong"><?=sc::_createTree($guaranty['header'], $feed); ?></p>
                <p class="muted"><?=sc::_createTree($guaranty['text'], $feed); ?></p>
            </div>
        </div>
        <?php if($k + 1 == count($guarantyArr)) break ; ?>
        <?php if(($k + 1) % 2 === 0) :; ?>
</div>
<div class="row row-flex">
        <?php endif; ?>
    <?php endforeach; ?>
</div>