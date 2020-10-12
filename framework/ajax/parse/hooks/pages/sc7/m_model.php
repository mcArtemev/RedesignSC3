<?

use framework\tools;
use framework\pdo;
use framework\ajax\parse\hooks\sc;
use framework\rand_it;

$feed = $this->_datas['feed'];
$site_id = $this->_site_id;
$setka_name = $this->_datas['setka_name'];
$setka_id = $this->_datas['setka_id'];

$marka_id = $this->_datas['marka']['id'];
$model_type_id = $this->_datas['model_type']['id'];
$eds = $this->_datas['eds'];

$model_type_name_rm = $this->_datas['orig_model_type'][0]['name_rm'];

$suffics = $this->_suffics;

$table = $suffics.'_service_to_m_models';
$join_field = $suffics.'_service_syn_id';
$join_table = $suffics.'_service_syns';
$main_table = $suffics.'_services';
$main_field = $suffics.'_service_id';
$cost_table = $suffics.'_service_costs';

$popular = " AND `{$main_table}`.`popular` = 1";
$non_popular = " AND (`{$main_table}`.`popular` = 0 OR `{$main_table}`.`popular` IS NULL)";
$end_sql = ""; //  LIMIT 0,4

$sql = "SELECT `{$table}`.id as 'service_id', `{$join_table}`.`name` as 'name', `{$cost_table}`.* FROM `{$table}`
            INNER JOIN `{$join_table}` ON `{$table}`.`{$join_field}` = `{$join_table}`.`id`
            INNER JOIN `{$main_table}` ON `{$main_table}`.`id` = `{$join_table}`.`{$main_field}`
            INNER JOIN `{$cost_table}` ON `{$main_table}`.`id` = `{$cost_table}`.`{$main_field}`
        WHERE `{$table}`.`site_id`=:site_id AND `{$table}`.`marka_id`=:marka_id AND `{$table}`.`type` = 3 AND `{$cost_table}`.`setka_id`=:setka_id";

$stm = pdo::getPdo()->prepare($sql.$popular.$end_sql);
$stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));
$other_services = $stm->fetchAll(\PDO::FETCH_ASSOC);

if (count($other_services) < 4)
{
    $stm = pdo::getPdo()->prepare($sql.$non_popular." LIMIT ".(4-count($other_services)));
    $stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));

    $other_services = array_merge($other_services, $stm->fetchAll(\PDO::FETCH_ASSOC));
}

srand($this->_datas['feed']);
shuffle($other_services);

//$other_services = array_slice($other_services, 0, 4);


$stmt = pdo::getPdo()->prepare("SELECT m_models2.name
FROM m_models2
JOIN m_models2_to_setka ON m_models2.id = m_models2_to_setka.m_model_id
WHERE m_models2_to_setka.setka_id = 7 AND m_models2.model_type_id = ? AND m_models2.marka_id = ? AND id != ?");
$stmt->execute([$model_type_id, $marka_id, $this->_datas['m_model']['id']]);
$m_models = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$stmt = pdo::getPdo()->prepare("SELECT models2.name
FROM models2
JOIN models2_to_setka ON models2.id = models2_to_setka.id_model
JOIN model_type_to_markas ON models2.model_type_mark = model_type_to_markas.id
JOIN models2_to_m_models2 ON models2.id = models2_to_m_models2.model_id
WHERE models2_to_setka.id_setka = 7 AND models2_to_m_models2.m_model_id = ?");
$stmt->execute([$this->_datas['m_model']['id']]);
$models = $stmt->fetchAll(\PDO::FETCH_ASSOC);
//var_dump($this->_datas['m_model']['id']);

$text = array();

srand($feed);
$choose = rand(0, 1);
switch ($choose)
{
    case 0:
        $text1[] = array('Мы');
        $text1[] = array('ремонтируем', 'восстанавливаем');
    break;
    case 1:
        $text1[] = array('RUSSUPPORT');
        $text1[] = array('ремонтирует', 'восстанавливает');
    break;
}

$text1[] = array('любые модели '. $this->_datas['marka']['name'].', '.'так как мы имеем доступ к');
$text1[] = array('оригинальным запчастям', 'оригинальным комплектующим', 'комплектующим', 'запчастям');
$text1[] = array('даже');
$text1[] = array('новых', 'редких');
$text1[] = array('устройств.', 'гаджетов.');

$details = array('деталей.', 'запчастей.', 'запасных частей.', 'комплектующих.');

$details_number = rand(0, 3);
$details_str = $details[$details_number];

unset($details[$details_number]);
$details = array_values($details);

$choose = rand(0, 2);
switch ($choose)
{
    case 0:
        $text1[] = array('Все цены', 'Цены', 'Цены на работы');
        $text1[] = array('зависят от');
        $text1[] = array('услуги', 'услуги, устройства');
        $text1[] = array('и указаны', 'и прописаны', 'и написаны');
        $text1[] = array('без стоимости', 'без учета стоимости');
        $text1[] = array($details_str);

    break;
    case 1:
        $text1[] = array('Цена', 'Цена на работы', 'Цена на услуги', 'Цена работы',
                'Цена', 'Окончательная цена', 'Окончательная цена на работы',
                'Окончательная цена на услуги', 'Окончательная цена работы',
                    'Окончательная цена услуги');
        $text1[] = array('зависит от');
        $text1[] = array('модели '.$this->_datas['orig_model_type'][0]['name_re']);
        $text1[] = array('и указана', 'и написана');
        $text1[] = array('без стоимости', 'без учета стоимости');
        $text1[] = array('необходимых', 'требуемых', '');
        $text1[] = $details;
    break;
    case 2:
        $text1[] = array('Итоговая стоимость ремонта', 'Общая стоимость ремонта', 'Суммарная стоимость ремонта', 'Окончательная стоимость ремонта',
                            'Конечная стоимость ремонта');
        $text1[] = array('складывается из', 'формируется из', 'составляется из');
        $text1[] = array('цен на', 'подсчета цен на');

        $t = array();

        $t1 = array('работы', 'ремонтные работы', 'работы специалиста', 'работы мастера',
                    'работы сервисного инженера', 'работы сервис-инженера', 'ремонтные работы специалиста',
                        'ремонтные работы мастера', 'ремонтные работы сервисного инженера',
                            'ремонтные работы сервис-инженера');
        $t2 = array('запчасти.', 'запасные части.', 'комплектующие.');

        foreach ($t1 as $t1_value)
        {
            foreach ($t2 as $t2_value)
            {
                $t[] = $t1_value.' и '.$t2_value;
                $t[] = $t1_value.' плюс '.$t2_value;
            }
        }

        foreach ($t2 as $t2_value)
        {
            foreach ($t1 as $t1_value)
            {
                $t[] = $t1_value.' и '.$t2_value;
                $t[] = $t1_value.' плюс '.$t2_value;
            }
        }

        $text1[] = $t;
    break;
}

$blocks = array();
$blocks[0][] = array('<div class="link-block"><div class="link-block-title-strong"><i class="number">1</i>Оставляете заявку</div>');
$blocks[0][] = array('<div class="link-block-text">Воспользуйтесь формой или позвоните нам</div></div>');

$blocks[1][] = array('<div class="link-block"><div class="link-block-title-strong"><i class="number">2</i>Проводим диагностику</div>');
$blocks[1][] = array('<div class="link-block-text">Выявляем', '<div class="link-block-text">Находим');
$blocks[1][] = array('неисправность', 'поломку');
$blocks[1][] = array('с помощью');
$blocks[1][] = array('профессионального оборудования</div></div>', 'специализированной техники</div></div>', 'профессионального стенда</div></div>');

$blocks[2][] = array('<div class="link-block"><div class="link-block-title-strong"><i class="number">3</i>Устраняем неисправность</div>');
$blocks[2][] = array('<div class="link-block-text">Восстанавливаем', '<div class="link-block-text">Ремонтируем',
                    '<div class="link-block-text">Чиним');
$blocks[2][] = array('устройство', 'гаджет', $this->_datas['orig_model_type'][0]['name']);
$blocks[2][] = array('используя');
$blocks[2][] = array('оригинальные комплектующие</div></div>', 'оригинальные запасные части</div></div>', 'оригинальные запчасти</div></div>');

$blocks[3][] = array('<div class="link-block"><div class="link-block-title-strong"><i class="number">4</i>Вы довольны</div>');
$blocks[3][] = array('<div class="link-block-text">Вы забираете');
$blocks[3][] = array('исправное устройство</div></div>', 'восстановленный гаджет</div></div>', 'исправный '.$this->_datas['orig_model_type'][0]['name'].'</div></div>',
                                    'восстановленный '.$this->_datas['orig_model_type'][0]['name'].'</div></div>');

$marka_lower = mb_strtolower($this->_datas['marka']['name']);
$accord_menu = array('ноутбуков' => 'MacBook', 'смартфонов' => 'iPhone', 'планшетов' => 'iPad', 'моноблоков' => 'iMac');
if ($marka_lower == 'apple') 
{
    $this->_ret['h1'] = str_replace(array_keys($accord_menu), array_values($accord_menu), $this->_ret['h1']);
}

?>
        <main>
            <section class="breadcrumbs">
                <div class="container">
                    <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        <ul class="breadcrumbs-inside">
                            <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                            <li itemprop="name"><a href = "/repair-<?=$this->_datas['accord_image'][$this->_datas['orig_model_type'][0]['name']]?>/" itemprop="url">Ремонт <?=$model_type_name_rm?> <?=$this->_datas['marka']['name']?></a></li>
                            <li itemprop="name"><span><?=$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name']?></span></li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="title-block">
                <div class="container">
                    <div class="grid-12">
                        <h1><?=$this->_ret['h1']?></h1>
                    </div>
                </div>
            </section>

            <section class="block-section">
                <div class="container">
                    <div class="grid-12">
                        <div class="block-list">
                            <div class="block block-small block-text-image">
                                <p><?=$this->_ret['plain']?></p>
                            </div>
						    <? include __DIR__.'/block-recall.php' ?>
							<div class="block block-auto block-full block-table block-service-table">
								<div class="block-inside">
									<h2>Популярные услуги по ремонту <?=$model_type_name_rm?> <?=$this->_datas['marka']['name'].' '.$this->_datas['m_model']['name']?></h2>
									<div class="services-item-table services-item-table-full">
										<a class="services-item-row" style="color: black; font-weight: 500;">
											<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
											<span class="services-item-value">Стоимость<!--, руб--></span>
											<span class="services-item-callback"></span>
										</a>
										<? for ($i=0; $i<count($other_services); $i++): ?> 
											<? $value = $other_services[$i]; ?>
											<? //if ($i == 7): ?>
												<!--</div><div id="part_opt" style = "display: none;"  class="services-item-table services-item-table-full">-->
											<? //endif; ?>
											
											<div class="a services-item-row">
												<a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));?>/" class="services-item-name"><?=tools::mb_firstupper($value['name'])?></a>
												<? if ($eds):?><span class="services-item-value"><?=tools::format_price($value['price'], $setka_name);?> руб</span><?endif;?>
												<span class = "services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
											</div>
											
											<? //if ($i == count($other_services)-1 && count($other_services) > 7): ?>
												<!--</div><div class="services-item-table services-item-table-full"><a class="btn btn-dark btn-mt part_opt" id="toggle_part_opt" style="display: block; text-align: center; margin: 15px auto 0px;">Показать все услуги</a>-->
											<? //endif; ?>
										<? endfor; ?>
									</div>
								</div>
							</div>
                            <?php if (count($m_models) > 0 || count($models) > 0) { ?>
                            <div class="block block-full block-auto block-model">
                              <?php if (count($m_models) > 0) { ?>
                              <div class="grid-4">
                                <h3>Другие линейки <?=$model_type_name_rm?></h3>
                                <ul class = "listModels">
                                <?php foreach ($m_models as $mm) { ?>
                                  <li><a href = "/repair-<?=$this->_datas['accord_image'][$this->_datas['orig_model_type'][0]['name']]?>/<?=strtolower(preg_replace('/(\s+)/', '-', $this->_datas['marka']['name'].' '.$mm['name']))?>/"><?=$this->_datas['marka']['name'].' '.$mm['name']?></a></li>
                                <?php } ?>
                                </ul>
                              </div>
                              <?php } ?>
                              <?php if (count($models) > 0) { ?>
                              <div class="grid-8">
                                <h3>Модели <?=$model_type_name_rm?></h3>
                                <ul class = "listModels listModelsSplit2">
                                <?php foreach (array_slice($models, 0, 10) as $m) { ?>
                                  <li><a href = "/repair-<?=$this->_datas['accord_image'][$this->_datas['orig_model_type'][0]['name']]?>/<?=strtolower(preg_replace('/(\s+)/', '-', $this->_datas['marka']['name'].' '.$m['name']))?>/"><?=$m['name']?></a></li>
                                <?php } ?>
                                </ul>
                              </div>
                              <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
			    
                <? include __DIR__.'/block-promo.php' ?>
                 
            </section>

            <section class="link-block-section">
                <div class="container">
                    <div class="grid-12">
                        <div class="link-block-list">
                             <? foreach ($blocks as $block)
                                    echo sc::_createTree($block, $feed); ?>
                        </div>
                    </div>
            </section>

        </main>
