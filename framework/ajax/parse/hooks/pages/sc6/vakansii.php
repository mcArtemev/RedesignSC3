<?php
use framework\tools;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$marka = $this->_datas['marka']['name'];  // SONY

$vacancy = [
	[
		'title' => '{Инженер|Мастер} по ремонту [type_rm] [brand]',
		'brand' => 'apple',
		'charge' => [
			'Консультирование клиентов по вопросам ремонта - физические лица и юридические лица;',
			'Ремонт после попадания жидкостей‚ падения, перепада напряжения;',
			'Устранение неисправностей (замена шлейфов, корпуса, динамиков, микрофонов, камеры, прошивка ios и т.д.)',
			'Диагностика неисправностей, полная разборка и сборка [type_rm] Apple',
			'Ремонт и настройка [type_rm] Apple.',
			'Выезд к клиентам компании для модульного ремонта iPhone',
		],
		'demands' => [
			'Образование в области радиоэлектроники/электротехники;',
			'Опыт модульного ремонта [type_rm] [brand] от 1 года;',
			'Умение проводить ремонт бытовой [type_rm], замену комплектующих, устанавливать новое оборудование',
			'Опыт ремонта на уровне BGA (замена микросхем, восстановление утопленных устройств)',
			'"Шахматный" склад ума, позволяющий думать наперед',
			'Пунктуальность, ответственность‚ стрессоустойчивость, аккуратность, честность и порядочность.',
		],
		'circs' => [
			'Гибкий график работы 5/2 (с выбором выходного дня) или 2/2;',
			'Компенсация проезда и мобильной связи;',
			'Компенсация обучающих курсов [brand];',
			'Коллектив, в котором приятно работать;',
			'Современное оборудованное рабочее;',
			'Возможность материального и карьерного роста внутри компании;',
			'Отработанная логистика заказов (возможность выбирать заказы из программы).',
		],
	],
	[
		'title' => '{Инженер|Мастер} по ремонту [type_rm] [brand]',
		'typeOut' => 'холодильник',
		'charge' => [
			'Консультирование клиентов по вопросам ремонта - физические лица и юридические лица;',
			'Ремонт после попадания жидкостей‚ падения, перепада напряжения;',
			'Диагностика и ремонт сложных неисправностей: ремонт после попадания жидкостей‚ падения, перепада напряжения;',
			'Полная разборка и сборка [type_rm]',
		],
		'demands' => [
			'Образование в области радиоэлектроники/электротехники;',
			'Опыт модульного ремонта [type_rm] [brand] от 1 года;',
			'Умение проводить ремонт бытовой [type_rm], замену комплектующих, устанавливать новое оборудование',
			'"Шахматный" склад ума, позволяющий думать наперед',
			'Опыт ремонта на уровне BGA (замена микросхем, восстановление утопленных устройств)',
			'Пунктуальность, ответственность‚ стрессоустойчивость, аккуратность, честность и порядочность.',
		],
		'circs' => [
			'Гибкий график работы 5/2 (с выбором выходного дня) или 2/2;',
			'Компенсация проезда и мобильной связи;',
			'Компенсация обучающих курсов [brand];',
			'Коллектив, в котором приятно работать;',
			'Современное оборудованное рабочее;',
			'Возможность материального и карьерного роста внутри компании;',
			'Отработанная логистика заказов (возможность выбирать заказы из программы).'
		]
	],
	[
		'title' => '{Инженер|Мастер} по ремонту [type_rm] [brand].',
		'type' => 'холодильник',
		'charge' => [
			'Консультирование клиентов по вопросам ремонта - физические лица и юридические лица;',
			'Умение проводить ремонт бытовой [type_rm], замену комплектующих, устанавливать новое оборудование;',
			'Диагностика и ремонт сложных неисправностей.'
		],
		'demands' => [
			'Профессиональное знание строения [type_rm];',
			'Опыт ремонта [type_rm] [brand] от 1 года;',
			'"Шахматный" склад ума, позволяющий думать наперед;',
			'Пунктуальность, ответственность‚ стрессоустойчивость, аккуратность, честность и порядочность.'
		],
		'circs' => [
			'Гибкий график работы 5/2 (с выбором выходного дня) или 2/2;',
			'Компенсация проезда и мобильной связи;',
			'Компенсация обучающих курсов [brand];',
			'Коллектив, в котором приятно работать;',
			'Современное оборудованное рабочее;',
			'Возможность материального и карьерного роста внутри компании;',
			'Отработанная логистика заказов (возможность выбирать заказы из программы).',
		],
	],

];

$vac = [];

$brand = $this->_datas['marka']['name'];
$types = $this->_datas['all_devices'];


$replace = [
	'[brand]' => $brand,
	'[type_rm]' => 'техники',
];

srand($this->_datas['feed']);

if ($brand == 'Apple') {
	foreach ($types as $i => $t) {
			$replace['[type_rm]'] = $t['type_rm'];
			$vac[] = helpers6::repl($vacancy[0], $replace);
	}
}
else {
	foreach ($types as $i => $t) {
			if (!in_array($t['type'], ['холодильник']))
				$v = $vacancy[1];
			else
				$v = $vacancy[2];
			$replace['[type_rm]'] = $t['type_rm'];
			$vac[] = helpers6::repl($v, $replace);
	}
}

helpers6::shuffle($vac, 0, $this->_datas['feed']);

/*foreach ($vacancy as $v) {
	$add = true;

	if (isset($v['brand']) && $brand != $v['brand'])
		$add = false;

	if (isset($v['type']) && !in_array(implode(',',$v['type']), $types))
		$add = false;

	if (isset($v['typeOut']) && in_array(implode(',',$v['typeOut']), $types))
		$add = false;

	if ($add)
		$vac[] = $v;
}

$vacancy = [];

$count = count($vac);*/

$pay = $this->_datas['region']['name'] == 'Москва' ? [50,80] : [40,60];

?>


<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Вакансии'],
]); ?>
<main>
    <section class="section-vacancies">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__center part-title__bold"  style="font-size: 30px">Актуальные вакансии сервисного центра <?=$marka?></h1>
            </div>


            <noindex>

                <div class="part-col">
                    <div class="part-col__left">
                        <?/*<p class="part-txt">Вам повезло стать обладателем [type_rm] <?=$marka?>, которая славится по всему миру своей надежностью и всегда популярна. Но если вы заподозрили поломку любимого гаджета, то не нужно расстраиваться. Наши мастера высоко квалифицированы и найдут подход к любому вашему устройству, к каждой модели <?=$marka?>! Мы любим свою работу.</p>*/?>
												<div class="">
														<p class="part-city">
																г. <?=$this->_datas['region']['name']?> <span>(<?=$this->_datas['partner']['address1']?>)</span>
														</p>

														<?php foreach (array_slice($vac, 0, 2) as $i => $v) { srand($this->_datas['feed']+$i); ?>
														<div class="master-block">
																<h2 class="master-block__title"><?=$v['title']?></h2>
																<p>
																		<span>Опыт работы:</span> от 2 лет
																</p>
																<p>
																		<span>Обязанности:</span>
																</p>
																<ul class="master-block__inner">
																		<?php foreach ($v['charge'] as $charge) { ?>
																		<li><?=$charge?></li>
																		<?php } ?>
																</ul>
																<p>
																		<span>Требования:</span>
																</p>
																<ul class="master-block__inner">
																		<?php foreach ($v['demands'] as $dem) { ?>
																		<li><?=$dem?></li>
																		<?php } ?>
																</ul>
																<p>
																		<span>Обязанности:</span>
																</p>
																<ul class="master-block__inner">
																		<?php foreach ($v['circs'] as $circ) { ?>
																		<li><?=$circ?></li>
																		<?php } ?>
																</ul>
																<p>
																		<span>График работы:</span> <?=($this->_datas['partner']['time'] === null ? "Пн-Вс, с 9:00 до 18:00" : $this->_datas['partner']['time'])?>
																</p>
																<p>
																		<span>Зарплата:</span> от <?=floor(rand($pay[0], $pay[1])/5)*5?> 000 руб.
																</p>
														</div>
														<?php } ?>
												</div>
                    </div>
										<div class="part-col__right">
		                    <?php include "data/inc/formFeedback.php"; ?>
		                    <?php include 'data/inc/infoList.php'; ?>
		                </div>
                </div>


            </noindex>
        </div>
    </section>
</main>
