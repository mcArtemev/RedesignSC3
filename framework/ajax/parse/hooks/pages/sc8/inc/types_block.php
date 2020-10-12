<?php

use framework\tools;
use framework\ajax\parse\hooks\sc;

$types = isset($typesName) ? $typesName : $this->device_types;

if ($this->_datas['static'] == '/') {
	unset($types['washing-machine']);
	unset($types['fridge']);
}

$phones_description = array();
$phones_description[] = array('Все виды ремонта смартфонов', 'Ремонт всех видов телефонов', 'Любые виды ремонта смартфонов');

$laptop_description = array();
$laptop_description[] = array('Диагностика и ремонт ноутбуков', 'Ремонт и диагностика ноутбуков', 'Полная диагностика и ремонт');

$tv_description = array();
$tv_description[] = array('Замена любых деталей телевизора', 'Все виды ремонта телевизора');

$fridge_description = array();
$fridge_description[] = array('Выезд мастера и осмотр', 'Диагностика мастером на месте', 'Полная диагностика и ремонт неисправностей');

$washing_machine_description = array();
$washing_machine_description[] = array('Бесплатный выезд специалиста', 'Осмотр мастером на дому', 'Осмотр мастером и последующий ремонт на дому');

$tablet_description = array();
$tablet_description[] = array('Замена экрана и разъемов', 'Замена разъемов, экранов, чипов',  'Замена экрана, плат и другие виды ремонта');

$mb_description = array();
$mb_description[] = array('Любые ремонтные работы', 'Диагностика и ремонт', 'Замена экранов, перегоревших плат и чипов');

$pc_description = array();
$pc_description[] = array('Ремонт и обновление ПО', 'Замена деталей о обновление ПО', 'Ремонт, чистка и обновление программного обеспечения');

$phones_description = sc::_createTree($phones_description, $this->_datas['feed']);
$laptop_description = sc::_createTree($laptop_description, $this->_datas['feed']);
$tv_description = sc::_createTree($tv_description, $this->_datas['feed']);
$fridge_description = sc::_createTree($fridge_description, $this->_datas['feed']);
$washing_machine_description = sc::_createTree($washing_machine_description, $this->_datas['feed']);
$tablet_description = sc::_createTree($tablet_description, $this->_datas['feed']);
$mb_description = sc::_createTree($mb_description, $this->_datas['feed']);
$pc_description = sc::_createTree($pc_description, $this->_datas['feed']);

/*

'fridge' => array('холодильник','холодильники','холодильников'),
'computer' => array('компьютер','компьютеры','компьютеров',),
'game-console' => array('playstation','playstation','playstation'),

 */

?>
<div class="row">
    <!--<div class="col-sm-12">
        <h3>Выберите свой тип устройства</h3>
        <p>Выберите нужный тип устройства, чтобы узнать стоимость ремонта.</p>
    </div>-->
</div>
<div class="row">
    <?php foreach ($types as $t => $type) :; ?>
            <?php if('/' === $this->_datas['arg_url'] && 'game-console' === $t) continue;?>

                <a href="/<?= isset($curBrand) ? strtolower($curBrand) . '/' . $t : $t; ?>-service/">

                <div class="col-sm-6 block">
                    <div class="block__inner" <?= '/' !== $this->_datas['arg_url'] ?  'style="background-color: #fff;"' : ''; ?>>
                        <?php if ('phone' === $t) $t .= 's'; ?>
                        <?php if ('computer' === $t) $t = 'pc'; ?>
                        <?php if ('monobloc' === $t) $t = 'mb'; ?>
                        <p class="cat-title"><?= tools::mb_ucfirst($type[1]); ?></p>
<!--                        <div class="options">-->
<!--                            --><?php //$desc = str_replace('-', '_', $t) . '_description'?>
<!--                            <p class="visible-xs">--><?//= $$desc; ?><!--</p>-->
<!--                        </div>-->
                        <div class="cat-image">
                            <img src="/custom/saapservice/img/cat-<?= $t; ?>-blur.png" alt="" class="blur img-responsive">
                            <img src="/custom/saapservice/img/cat-<?= $t; ?>.png" alt="" class="img-responsive">
                        </div>
                    </div>
                </div>

                </a>

    <?php endforeach; ?>
</div>