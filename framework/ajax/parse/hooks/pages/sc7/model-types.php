<?

use framework\tools;
use framework\pdo;
use framework\ajax\parse\hooks\sc;
use framework\rand_it;

$feed = $this->_datas['feed'];
$site_id = $this->_site_id;
$setka_name = $this->_datas['setka_name'];
$setka_id = $this->_datas['setka_id'];

//$marka = $this->_datas['marka']['name'];

$marka_id = $this->_datas['marka']['id'];
$model_type_id = $this->_datas['model_type']['id'];
$eds = $this->_datas['eds'];

$model_type_name_rm = $this->_datas['orig_model_type'][0]['name_rm'];
$model_type_name_ru = $this->_datas['orig_model_type'][0]['name'];

$all_deall_devices = $this->_datas['all_devices'];

$suffics = $this->_suffics;

$table = $suffics.'_service_to_m_models';
$join_field = $suffics.'_service_syn_id';
$join_table = $suffics.'_service_syns';
$main_table = $suffics.'_services';
$main_field = $suffics.'_service_id';
$cost_table = $suffics.'_service_costs';

$popular = " AND `{$main_table}`.`popular` = 1";
$non_popular = " AND (`{$main_table}`.`popular` = 0 OR `{$main_table}`.`popular` IS NULL)";
$end_sql = " LIMIT 0,4";

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

    if (isset($this->_datas['admin'])){
        echo "<pre>";
        if (!empty($this->_datas['admin'][0])){
        print_r($this->_datas[$this->_datas['admin'][0]]);
        }else print_r($this->_datas);
        echo "</pre>";
    }
//srand();
$other_services = array_slice($other_services, 0, 4);

$ids = implode(',', array_column($other_services, 'service_id'));

$stm = pdo::getPdo()->prepare($sql." AND `{$table}`.`id` NOT IN ($ids) ".'ORDER BY RAND('.$this->_datas['feed'].')');
$stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));
$all_services = $stm->fetchAll(\PDO::FETCH_ASSOC);

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

$text1[] = array('любые модели '. $this->_datas['orig_model_type'][0]['name_rm'].' '.$this->_datas['marka']['name'].', '.'так как мы имеем доступ к');
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


//if(isset($_GET['ololo']) and $_GET['ololo']=='test'){
   //var_dump('ololo');
//echo '<div style="display:none">'.$sql.'</div>';
?>
        <main>
            <section class="breadcrumbs">
                <div class="container">
                    <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        <ul class="breadcrumbs-inside">
                            <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                            <li itemprop="name"><span>Ремонт <?=$model_type_name_rm?> <?=$this->_datas['marka']['name']?></span></li>
                        </ul>
                    </div>
                </div>
            </section>
			<?$all_deall_devices =array_values($all_deall_devices);
			for($i=0; $i<count($all_deall_devices); $i++) {
				if ($all_deall_devices[$i]['type_rm'] == $model_type_name_rm) {
					if ($i == count($all_deall_devices)-1) {
						$i = 0;
					} else {
						$i++;
					}
					break;
				}
			}
			//var_dump($all_deall_devices);
			?>
            <section class="title-block">
                <div class="container">
                    <div class="grid-12">
                        <h1 style="float: left;"><?=$this->_ret['h1']?></h1>
						<?if (count($all_deall_devices) > 1):?>
						<a class="btn btn-link btn-next" style="float: right; line-height: 29px;" href="/
    						<?= getGaget($this->_datas['add_device_type'], $all_deall_devices[$i]['type'])?>/">
    						    Ремонт <?=$all_deall_devices[$i]['type_rm']?> <?=$marka?>
						</a>
						<?endif;?>
					</div>
                </div>
            </section>

            <section class="block-section">
                <div class="container">
                    <div class="grid-12">
                        <div class="block-list">
                            <div class="block block-small block-text-image">
                                <!--Картинка-->
                                <img src="/images/sample/<?=mb_strtolower($marka)?>big<?=$this->_datas['accord_image'][$model_type_name_ru]?>.png"  width="250"style="max-height: 150px;" >
                                <!--<img src="/images/loading.png" width="250" height="250" style="max-height: 250px;">-->
                                <p><?=sc::_createTree($text1, $feed);?><br /><br /><i class="fa fa-fw fa-money"></i>Бесплатная диагностика</p>
                            </div>
                            <!--<div class="block block-small block-image">
                                <div class="block-image-url" style="background-image: url('/images/sample/hub<?=$this->_datas['accord_image'][$this->_datas['orig_model_type']['0']['name']]?>.png')"></div>
                            </div>-->
                            <? include __DIR__.'/block-recall.php' ?>
                            <!--<a class = "btn btn-dark btn-mb" data-slideDown = "allServices">Показать все услуги</a><br>-->

                            <div class="block block-auto block-full block-table block-service-table">
                                <div class="block-inside">
                                    <h2>Все услуги по ремонту <?=$model_type_name_rm?> <?=$this->_datas['marka']['name']?></h2>
                                    <div class="services-item-table services-item-table-full">
										<a class="services-item-row" style="color: black; font-weight: 500;">
											<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
											<span class="services-item-value">Стоимость, руб</span>
											<span class="services-item-callback"></span>
										</a>
										<? foreach($all_services as $k => $v){
										    if ($v['price']==0 && $k !=0){
											        $temp = $all_services[0];
											        $all_services[0]=$all_services[$k];
											        $all_services[$k]=$temp;
											 }
										}
										for ($i=0; $i<count($all_services); $i++): ?> 
										    <? //if($all_services[$i]['price'] ==0 && $i >0){
										    //    list($all_services[$i], $all_services[0]) = array($all_services[0], $all_services[$i]);
										    
                                            //    //array_splice($all_services[$i],2,0,array_shift($all_services[$i]));
                                            //}?>
											<? $value = $all_services[$i]; ?>
											<? if ($i == 100): ?>
												</div><div id="part_opt" style = "display: none;" class="services-item-table services-item-table-full">
											<? endif;?>
											
											<div class="a services-item-row">
												<a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));?>/" class="services-item-name"><?=tools::mb_firstupper($value['name'])?></a>
												<? if ($eds):?><span class="services-item-value"><?=tools::format_price($value['price'], $setka_name);?></span><?endif;?>
												<!--<span class = "services-item-callback"><button href="#callback" class="btn btn-dark" data-toggle="modal">Заказать звонок</button></span>-->
                                                <span class="services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
											</div>
											
											<? if ($i == count($all_services)-1 && count($all_services) > 100): ?>
												</div><div class="services-item-table services-item-table-full"><a class="btn btn-dark btn-mt part_opt" id="toggle_part_opt" style="display: block; text-align: center; margin: 15px auto 0px;">Показать все услуги</a>
											<? endif; ?>
										<? endfor; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <? include __DIR__.'/block-model.php';?>
                            
                        </div>
					</div>
                </div>
                    
                <? include __DIR__.'/block-promo.php'; ?>
                  
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
