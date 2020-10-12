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

$model_type_name_rm = $gadget['type_rm'];

$all_deall_devices = $this->_datas['all_devices'];


$text = array();

include __DIR__.'/data/gadget_price.php';
if (empty($this->_datas['hab'])) {
    $all_services = array();
    if (isset($gadget_price[$gadget['type']]))
    {
        $all_services = $gadget_price[$gadget['type']];
    } 
}else{
    if(empty($all_services)){
        if (isset($gadget_price[$gadget['type']])){
            foreach($gadget_price[$gadget['type']] as  $value){
                $all_services[] = ['name' => $value[0], 'price' => $value[1]];
            }
        } 
    }
    
}


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

$text1[] = array('любые модели '. $gadget['type_rm'] . ' ' .$this->_datas['marka']['name'].', '.'так как мы имеем доступ к');
$text1[] = array('оригинальным запчастям', 'оригинальным комплектующим', 'комплектующим', 'запчастям');
$text1[] = array('даже');
$text1[] = array('новых', 'редких');
$text1[] = array('устройств.', 'гаджетов.');

$details = array('деталей.', 'запчастей.', 'запасных частей.', 'комплектующих.');

$details_number = rand(0, 3);
$details_str = $details[$details_number];

unset($details[$details_number]);
$details = array_values($details);

    if (isset($this->_datas['admin'])){
        echo "<pre>";
        if (!empty($this->_datas['admin'][0])){
        print_r($this->_datas[$this->_datas['admin'][0]]);
        }else print_r($this->_datas);
        echo "</pre>";
    }
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
        $text1[] = array('модели '.$gadget['type_re']);
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
$blocks[2][] = array('устройство', 'гаджет', $gadget['type']);
$blocks[2][] = array('используя');
$blocks[2][] = array('оригинальные комплектующие</div></div>', 'оригинальные запасные части</div></div>', 'оригинальные запчасти</div></div>');

$blocks[3][] = array('<div class="link-block"><div class="link-block-title-strong"><i class="number">4</i>Вы довольны</div>');
$blocks[3][] = array('<div class="link-block-text">Вы забираете');
$blocks[3][] = array('исправное устройство</div></div>', 'восстановленный гаджет</div></div>', 'исправный '.$gadget['type'].'</div></div>',
                                    'восстановленный '.$gadget['type'].'</div></div>');
                                    
$services = $all_services;

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
			
			?>
            <section class="title-block">
                <div class="container">
                    <div class="grid-12">
                        <h1 style="float: left;"><?=$this->_ret['h1']?></h1>
						<?php  if (count($all_deall_devices) > 1 && empty($this->_datas['hab'])):?>
						    <a class="btn btn-link btn-next" style="float: right; line-height: 29px;" href="/<?='repair-' . $this->_datas['accord_image'][$all_deall_devices[$i]['type']]?>/">
						    Ремонт 
						    <?=$all_deall_devices[$i]['type_rm']?>
						    <?=$marka?></a>
						 <?php endif;?>
					</div>
                </div>
            </section>

            <section class="block-section">
                <div class="container">
                    <div class="grid-12">
                        <div class="block-list">
                            <div class="block block-small block-text-image">
                                <?php if (!empty($this->_datas['hab'])) { ?>
                                    <img src="/images/hab/<?=str_replace(' ', '-',strtolower($marka))?>/<?=mb_strtolower($this->_datas['accord_image'][$model_type_name_ru])?>.png"  width="250"style="max-height: 150px;" >
                                <?php } else { ?>
                                    <img src="/images/sample/<?=str_replace(' ', '-',strtolower($marka))?>big<?=mb_strtolower($this->_datas['accord_image'][$model_type_name_ru])?>.png"  width="250"style="max-height: 150px;" >
                                <?php } ?>
                                <p><?=sc::_createTree($text1, $feed);?><br /><br /><i class="fa fa-fw fa-money"></i>Бесплатная диагностика</p>
                            </div>
                            <!--<div class="block block-small block-image">
                                <div class="block-image-url" style="background-image: url('/images/sample/hub<?=$this->_datas['accord_image'][$gadget['type']];?>.png')"></div>
                            </div>-->
                            <? include __DIR__.'/block-recall.php' ?>
                            <!--<a class = "btn btn-dark btn-mb" data-slideDown = "allServices">Показать все услуги</a><br>-->
                            <?if ($all_services):?>
                            <div class="block block-auto block-full block-table block-service-table">
                                <div class="block-inside">
                                    <h2>Все услуги по ремонту <?=$model_type_name_rm?> <?=$this->_datas['marka']['name']?></h2>
                                    <div class="services-item-table services-item-table-full">
										<a class="services-item-row" style="color: black; font-weight: 500;">
											<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
											<span class="services-item-value">Стоимость<!--, руб--></span>
											<span class="services-item-callback"></span>
										</a>
									<?php if(empty($this->_datas['hab'])):?>
										<? for ($i=0; $i<count($all_services); $i++): ?> 
											<? $value = $all_services[$i];
                                            $value['name'] = $value[0];
                                            $value['price'] = $value[1]; ?>
											<? if ($i == 100): ?>
												</div><div id="part_opt" style = "display: none;" class="services-item-table services-item-table-full">
											<? endif; ?>
											
											<div class="a services-item-row">
												<span class="services-item-name"><?=tools::mb_firstupper($value['name'])?></span>
												<span class="services-item-value"><?=tools::format_price($value['price'], $setka_name);?> руб</span>
												<!--<span class = "services-item-callback"><button href="#callback" class="btn btn-dark" data-toggle="modal">Заказать звонок</button></span>-->
                                                <span class="services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
											</div>
											
											<? if ($i == count($all_services)-1 && count($all_services) > 100): ?>
												</div><div class="services-item-table services-item-table-full"><a class="btn btn-dark btn-mt part_opt" id="toggle_part_opt" style="display: block; text-align: center; margin: 15px auto 0px;">Показать все услуги</a>
											<? endif; ?>
										<? endfor; ?>
									<?php else: ?>
									    
									    <?php foreach ($services as $value):?>

                                            <div class="a services-item-row" >
                                                <span class="services-item-name" ><?= tools::mb_firstupper($value['name']) ?></span>
                                                <span class="services-item-value"><?
                                                    $price=(!empty($gadget_price['плоттер'][$value['name']])) ? $gadget_price['плоттер'][$value['name']] : $value['price'];
                                                // $price = tools::format_price($value['price'], $setka_name); 
                                                echo $price;?> руб</span>
                                                <span class="services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
                                            </div>

                                        <?php endforeach;?>
									    
									<?php endif; ?>	
                                    </div>
                                </div>
                            </div>
                            <?endif;?>
                            <? include __DIR__.'/block-model.php';?>
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
