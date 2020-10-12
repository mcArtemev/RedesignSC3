<?php
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$feed = $this->_datas['feed'];

use framework\ajax\parse\hooks\pages\sc6\data\src\type_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$typesIds = type_service::ids($this->_datas['all_devices']);
$services = array_slice(service_service::getPopularForTypes($typesIds, $this->_datas['feed']), 0, 10);
$minTR = service_service::minTimeRepair($typesIds);

$p1 = [
  ['Срок','Сроки','Период'],
  ['устранения'],
  ['неисправности','поломки'],
  ['определяется','устанавливается'],
  ['индивидуально, в зависимости от сложности поломки.'],

  ['Ориентировочное','Примерное'],
  ['время Вам'],
  ['сообщит','озвучит'],
  ['инженер-приемщик.','менеджер-приемщик.','приемщик.'],

  ['Обозначенный срок включает в себя диагностику и устранение'],
  ['неисправности.','поломки.'],

  ['Если Вы хотите как можно'],
  ['скорее','быстрее','оперативнее'],
  ['получить обратно'],
  ['исправную','отремонтированную'],
  ['технику?'],

  ['Тогда'],
  ['доверьте','поручите'],
  ['ремонт','починку'],
  ['специалистам','профессионалам','мастерам'],
  ['из нашего'],
  ['сервисного центра!','сервис-центра!'],
];
$p1 = self::_createTree($p1, $feed);

$bc = ['быстро', 'качественно'];
helpers6::shuffle($bc, 0, $feed);
$p2 = [
  ['Наши'],
  ['мастера','специалисты','сотрудники'],
  ['являются'],
  ['квалифицированными','опытными','профессиональными'],
  ['инженерами, имеющими высшее образование и опыт работы по'],
  ['специальности','профилю'],
  ['от','не мение'],
  ['2 лет.'],

  ['Все'],
  ['сотрудники','мастера'],
  ['регулярно','постоянно'],
  ['проходят'],
  ['внутреннюю','профессинальную'],
  ['аттестацию,','сертификацию,'],
  ['которая совершенствует','которая оттачивает'],
  ['их'],
  ['имеющиеся профессиональные навыки.','профессиональные навыки.','навыки.'],

  ['Благодаря','По причине'],
  ['высокой'],
  ['квалификации','профессиональности'],
  ['наши'],
  ['специалисты','мастера','инженеры'],
  ['в'],
  ['кратчайший','минимальный'],
  ['срок'],
  ['устраняют','исправят','отремонтируют'],
  ['неисправности','поломки'],
  ['различной','любой'],
  ['степени сложности.'],

  ['Доверьте'],
  ['ремонт','починку','работу'],
  ['опытным инженерам, которые'],
  ['отремонтируют','починят'],
  ['вашу технику '.$bc[0].' и '.$bc[1].'!'],
];
$p2 = self::_createTree($p2, $feed);

?>

<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Время ремонта'],
]); ?>

<main>
    <section class="part-2">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__center part-title__bold" style="font-size: 30px">Время ремонта устройств <?=$marka?></h1>
            </div>


                <noindex>
                    <div class="part-col">
                    <div class="part-col__left">
                        <p class="part-txt"><?=$p1?></p>
                        <?php if ($minTR !== false) { ?>
                        <div class="part_header">
                            <p class="part-title part-title__left part-title__light" style="font-size: 24px;">Срочный ремонт устройств <?=$marka?> - <span>от <?=$minTR?> минут</span>
                            </p>
                        </div>
                        <?php } ?>
                        <div class="part-img">
                          <img src="/_mod_files/_img/img-9.jpg" alt="">
                        </div>
						
						<h2>Сколько времени будут ремонтировать мою технику? </h2>
						<p class="part-txt">
							Мы стремимся, чтобы наши клиенты получали свои отремонтированные аппараты как можно быстрее.
							Предварительные сроки ремонта обозначаются специалистом в процессе согласования ремонта.
							Отлаженная логистика со складами позволяет ремонтировать большую часть техники в день обращения.
						</p>
						

						
						
                        <p class="part-txt"><?=$p2?></p>

                        <?php // include 'data/inc/popularAllTR.php'; ?>
						<div>
							<div class="service-price">
								<div class="service-price__item">
									<table class="simple-example-table">
										<thead>
										<tr>
											<th>Наименование</th>
											<th>Стоимость (руб.)</th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<td></td>
											<td>Бесплатно</td>
										</tr>
										<tr>
											<td></td>
											<td>200 рублей</td>
										</tr>
										<tr>
											<td></td>
											<td>400 рублей</td>
										<tr>
											<td></td>
											<td>от 500 рублей</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
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
