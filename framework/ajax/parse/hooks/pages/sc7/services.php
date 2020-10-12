<?php

use framework\tools;
use framework\pdo;
use framework\ajax\parse\hooks\sc;
use framework\rand_it;

$site_id = $this->_site_id;
$setka_name = $this->_datas['setka_name'];
$service_name = tools::mb_firstupper($this->_datas['syns'][3]);
$service_price = isset($this->_datas['price']) ? tools::format_price($this->_datas['price'], $setka_name) : 0;

$eds = $this->_datas['eds'];
$vals = $this->_datas['vals'];
$service_time = ($eds) ? tools::format_time($vals['time_min'], $vals['time_max'], $eds[$this->_datas['id']]['ed_time'], $setka_name) : '';
$marka_id = $this->_datas['marka']['id'];
$model_type_id = $this->_datas['model_type']['id'];

$other_services = isset($this->_datas['other_services']) ? array_slice($this->_datas['other_services'], 0, 4) : array();
$other_services = tools::unique_multidim_array($other_services, 'name');

$suffics = $this->_suffics;

$marka_lower = mb_strtolower($this->_datas['marka']['name']);

$feed = $this->_datas['feed'];

$text1 = array();
srand($feed);

/*
 *  Вывод неисправностей с массива а  /studiof1-test.ru/framework/ajax/parse/hooks/pages/sc7/data
 * */

$db = $suffics . '_service_syns';
$service_id = unserialize($this->_datas['params'])['id'];

$sql = "SELECT name FROM " . $db . " WHERE " . $suffics . "_service_id = " . $service_id;

$stmt = pdo::getPdo()->prepare($sql);
$stmt->execute();
$neispravnost = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$neispravnost_name = tools::mb_ucfirst(array_column($neispravnost, 'name')[0]);

$sql = "SELECT name_m AS name FROM model_types WHERE id = ". $this->_datas['model_type_id'];
$stmt = pdo::getPdo()->prepare($sql);
$stmt->execute();
$model_name = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$model_name = tools::mb_ucfirst(array_column($model_name, 'name')[0]);


$neispravnosti = require __DIR__ . '/data/neispravnosti.php';

if ( array_key_exists( $model_name, $neispravnosti ) ) {
//    echo $model_name . '|';
    if ( array_key_exists( $neispravnost_name, $neispravnosti[$model_name] ) ) {
//        echo $neispravnost_name;
        $neispr_text_raw = $neispravnosti[$model_name][$neispravnost_name];
    } else {
        $text1 = false;
        goto text1;
    }
} else {
    $text1 = false;
    goto text1;
}

$str = str_replace('[brand]', $this->_datas['marka']['name'], $neispr_text_raw);
$str = str_replace('[city]', $this->_datas['region']['name_de'], $str);

$text1 = strReplace( $str, $feed);

function strReplace( &$str , $feed  ) {
    $t_str = '';
    $cb_open = strpos($str, '{');
    $cb_close = strpos($str, '}');

    if ( $cb_open !== false ) {
        $variant = substr($str, $cb_open + 1, $cb_close - $cb_open - 1);
        $variant_arr = explode('|', $variant);

        srand( $feed );
        $random = rand(0, count($variant_arr) - 1);

        $t_str = substr_replace( $str, $variant_arr[$random], $cb_open, $cb_close - $cb_open + 1);
        $str = strReplace( $t_str, $feed );
    }

    return $str;
}

text1:

/*
 *  Вывод неисправностей с массива а  /studiof1-test.ru/framework/ajax/parse/hooks/pages/sc7/data
 * */

if ( !$text1 ) {

    if (in_array($this->_suffics, array('n', 'p', 'f', 'a'))) {
        $text1[] = array(tools::mb_firstupper($this->_datas['model_type'][3]['name']));
        $text1[] = array($this->_datas['marka']['name'] . ',');
        $text1[] = array('как');
        $text1[] = array('и');
        $text1[] = array('любая', 'другая');
        $text1[] = array('мобильная', 'переносная');
        $text1[] = array('техника', 'аппаратура');
        $text1[] = array('имеет');
        $text1[] = array('высокий', 'более высокий', 'повышенный');
        $text1[] = array('риск', 'шанс');
        $text1[] = array('на');

        $choose = rand(0, 1);
        switch ($choose) {
            case 0:
                $text1[] = array('возникновение поломки.');
                break;
            case 1:
                $text1[] = array('появление');
                $text1[] = array('неисправности.', 'дефекта.');
                break;
        }
    } else {
        $text1[] = array(tools::mb_firstupper($this->_datas['model_type'][3]['name']));
        $text1[] = array($this->_datas['marka']['name'] . ',');
        $text1[] = array('как');
        $text1[] = array('и');

        $choose = rand(0, 2);
        switch ($choose) {
            case 0:
                $text1[] = array('любая');
                $text1[] = array('техника', 'аппаратура');
                break;
            case 1:
                $text1[] = array('любое');
                $text1[] = array('устройство');
                break;
            case 2:
                $text1[] = array('любая другая');
                $text1[] = array('техника', 'аппаратура');
                $text1[] = array('подвержена');
                $text1[] = array('поломкам', 'неисправностям', 'возникновению дефектов');
                $text1[] = array('во время', 'в процессе');
                $text1[] = array('эксплуатации.', 'использования.');
                break;
        }

        if ($choose == 0 || $choose == 1) {
            $text1[] = array('имеет');
            $text1[] = array('шанс на');
            $text1[] = array('поломку.', 'возникновение неисправности.', 'возникновение поломки.', 'появление неисправности.');
        }
    }

    $choose = rand(0, 1);
    switch ($choose) {
        case 0:
            $text1[] = array('Статистика подсказывает,', 'Опыт RUSSUPPORT подсказывает,');
            $text1[] = array('что');
            $text1[] = array(tools::mb_firstlower($this->_datas['syns'][3]));
            $text1[] = array('является');

            $choose_1 = rand(0, 1);
            switch ($choose) {
                case 0:
                    $text1[] = array('одной из самых популярных услуг.');
                    break;
                case 1:
                    $text1[] = array('часто', 'наиболее');
                    $text1[] = array('запрашиваемой услугой.');
                    break;
            }
            break;
        case 1:
            $text1[] = array('Исходя из нашего опыта');
            $text1[] = array('услуга по');
            $text1[] = array(tools::skl('service', $this->_suffics, $this->_datas['syns'][3], 'dat'));
            $text1[] = array('является');

            $choose_1 = rand(0, 1);
            switch ($choose) {
                case 0:
                    $text1[] = array('одной из самых популярных.');
                    break;
                case 1:
                    $text1[] = array('наиболее');
                    $text1[] = array('востребованной.', 'часто встречаемой.');
                    break;
            }

            break;
    }

    $text1[] = array('Наш');
    $text1[] = array('сервисный центр', 'СЦ', 'сервис', 'сервисный центр ' . $this->_datas['marka']['name'] . ' RUSSUPPORT', 'СЦ ' . $this->_datas['marka']['name'] . ' RUSSUPPORT',
        'сервис ' . $this->_datas['marka']['name'] . ' RUSSUPPORT');
    $text1[] = array('ремонтирует', 'восстанавливает');
    $text1[] = array('любые линейки');
    $text1[] = array($this->_datas['model_type'][3]['name_rm']);
    $text1[] = array($this->_datas['marka']['name'] . '.');

    $text1[] = array('Не переживайте,', 'Не волнуйтесь,', 'Не отчаивайтесь,');
    $text1[] = array('мы');
    $text1[] = array('имеем');
    $text1[] = array('большой опыт в решении этого вопроса.', 'большие знания в данном вопросе.');
}

if (empty($i)) $i=0;

?>

        <main>

            <section class="breadcrumbs">
                <div class="container">
                    <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                        <ul class="breadcrumbs-inside">
                            <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                            <li itemprop="name">
                                <a href="/<?=getGaget($this->_datas['add_device_type'], $all_deall_devices[$i]['type'])?>/" itemprop="url">
                                    Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?> <?=$this->_datas['marka']['name']?>
                                </a>
                            </li>
                            <li itemprop="name"><span><?=tools::mb_firstupper($this->_datas['syns'][3])?></span></li>
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
                        
                            <div class="block block-small block-price">
                                <div class="block-inside">
                                    <!--<div class="block-price-title"><?=$service_name?></div>-->
                                    <div class="block-price-list">
                                        <div class="item">
                                            <i class="fa fa-fw fa-money"></i>
                                            <div class="block-service">Цена:  <span><?=$service_price?> руб</span></div>
                                        </div>
                                        <div class="item">
                                            <i class="fa fa-fw fa-clock-o"></i>
                                            <?if ($service_time):?><div class="block-service">Время: <span><?=$service_time?> мин</span></div><?endif;?>
                                        </div>
                                    </div>
                                </div>
                                <? 
                                   $repair_mas = explode('-', $this->_datas['arg_url']);                                 
                                   $repair_mas = array_pop($repair_mas) . '/' . implode('-', $repair_mas); 
                                ?>
                                <img src="/images/repair/<?=$repair_mas?>.jpg"/>
                            </div>                           
                                                   
                            <? include __DIR__.'/block-recall.php' ?>
                            <!--  -->
                            <div class="block block-small block-text-image">
                                <?php if ( is_array( $text1 ) ) :; ?>
                                    <p><?=sc::_createTree($text1, $feed);?></p>
                                <?php else: ?>
                                    <p><?= $text1; ?></p>
                                <?php endif; ?>
                            </div>
                            <!--  -->
                            <div class="block block-small block-table block-service-table">
                                <div class="block-inside">
                                    <h2>Услуги, которые могут потребоваться</h2>
                                     <div class="services-item-table services-item-table-full services-item-table-2row">
                                     
                                        <a class="services-item-row" style="color: black; font-weight: 500;">
											<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
											<span class="services-item-value">Время ремонта<!--, мин--></span>
										</a>           
                                    <? foreach ($other_services as $value):?>

                                    <div class="a services-item-row">
                                        <a class="services-item-name" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));?>/" ><?=tools::mb_firstupper($value['name'])?></a>
                                        <? if ($eds):?><span class="services-item-value"><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time'], $setka_name);?> мин</span><?endif;?>
                                    </div>

                                    <? endforeach; ?>
                                    </div>

                                </div>
                            </div>
                            
                            <? include __DIR__.'/block-model.php' ?>
                            <div></div>
                            
                        </div>
                    </div>
                </div>
                
                <? include __DIR__.'/block-promo.php' ?>
                
            </section>
            
            <section class="link-block-section">
                <div class="container">
                    <div class="grid-12">
                        <div class="link-block-list">
                              <? foreach ($this->_datas['blocks'] as $block)
                                    echo sc::_createTree($block, $feed); ?>
                        </div>
                    </div>
            </section>

        </main>
