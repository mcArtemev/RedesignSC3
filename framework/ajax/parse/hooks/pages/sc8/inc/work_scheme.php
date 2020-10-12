<?php

use framework\ajax\parse\hooks\sc;

$feed = $this->_datas['feed'];

$step_1_header = array();
$step_1_header[] = array('Заявка на ремонт');

$step_1_txt = array();
$step_1_txt[] = array('Вы');
$step_1_txt[] = array('оставляете', 'заполняете');
$step_1_txt[] = array('заявку на сайте или');
$step_1_txt[] = array('можете позвонить нам', 'можете связаться с нами');
$step_1_txt[] = array('по');
$step_1_txt[] = array('телефону');

$step_2_header = array();
$step_2_header[] = array('Согласование');

$step_2_txt = array();
$step_2_txt[] = array('Заказчику');
$step_2_txt[] = array('перезванивает наш');
$step_2_txt[] = array('оператор', 'консультант');
$step_2_txt[] = array('и');
$step_2_txt[] = array('уточняет', 'выясняет');
$step_2_txt[] = array('всю');
$step_2_txt[] = array('необходимую', 'нужную', 'важную');
$step_2_txt[] = array('информацию');

$step_3_header = array();
$step_3_header[] = array('Ремонт');

$step_3_txt = array();
$step_3_txt[] = array('Все');
$step_3_txt[] = array('ремонтные работы', 'работы по ремонту');
$step_3_txt[] = array('мы осуществляем в');
$step_3_txt[] = array('рамках', 'пределах');
$step_3_txt[] = array('обговоренного', 'согласованного');
$step_3_txt[] = array('временного');
$step_3_txt[] = array('периода');

$step_4_header = array();
$step_4_header[] = array('Итог');

$step_4_txt = array();
$step_4_txt[] = array('Вы');
$step_4_txt[] = array('получаете качественный ремонт без лишней');
$step_4_txt[] = array('потери', 'траты');
$step_4_txt[] = array('своего');
$step_4_txt[] = array('времени');

$remontArr = array();

$remontArr[] = array('header' => $step_1_header, 'text' => $step_1_txt);
$remontArr[] = array('header' => $step_2_header, 'text' => $step_2_txt);
$remontArr[] = array('header' => $step_3_header, 'text' => $step_3_txt);
$remontArr[] = array('header' => $step_4_header, 'text' => $step_4_txt);

?>
<div class="row row-flex">
    <div class="col-sm-12">
        <div class="block block-1 botsc">
            <div class="row">
				<?php $i = 0; ?>
                <?php foreach ($remontArr as $k => $step) :; ?>
				<?php $i++; ?>
                    <div class="col-sm-3">
						<div class="icon-<?= $k + 1; ?>">
							<div class="img">
								<img src="/custom/saapservice/img/circle-icon@x2.png" style="max-width: 100px;">
								<? if ($i != 4) {echo "<span class='num_schem'>".$i."</span>";} else {echo "<span style='font-size: 60px; margin: -10px 0px 0px 6px;' class='num_schem'>✔</span>";}?>
							</div>
						</div>
                        <p class="strong"><?= sc::_createTree($step['header'], $feed); ?></p>
                        <p><?= sc::_createTree($step['text'], $feed); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>