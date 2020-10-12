<?
use framework\tools;
use framework\ajax\parse\parse;
use framework\pdo;
use framework\rand_it;

$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$region_name = $this->_datas['region']['name'];//Москва
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$metrica = $this->_datas['metrica'];
$all_deall_devices = $this->_datas['all_devices'];

$site_id = $this->_site_id;
$setka_id = $this->_datas['setka_id'];
$marka_id = $this->_datas['marka']['id'];
$setka_name = $this->_datas['setka_name'];

srand($this->_datas['feed']);

$ot = tools::get_rand(array(10,15,20), $this->_datas['feed']);

$predlojenie = array();
$predlojenie[] = array('<p>Мы');
$predlojenie[] = array("понимаем,","знаем,");
$predlojenie[] = array("что ваше устройство","что ваш девайс","что ваш гаджет");
$predlojenie[] = array($marka);
$predlojenie[] = array("неотъемлемая");
$predlojenie[] = array("часть");
$predlojenie[] = array("жизни.");
$predlojenie[] = array("На него завязанны все");
$predlojenie[] = array("коммуникации.","источники связи.");
$predlojenie[] = array("Именно по этой причине ".$servicename." предлагает вам услугу срочного ремонта.");
$predlojenie[] = array('</p><p>Экспресс ремонт у нас это:</p><ul><li>');
$predlojenie[] = array("Диагностика,","Тестирование,","Аппаратное тестирование,","Программное тестирование,","Аппаратная диагностика,","Программная диагностика,");
$predlojenie[] = array("разбор,");
$predlojenie[] = array("замена","ремонт","восстановление");
$predlojenie[] = array("сломаной части","поломанной части","неисправной части");
$predlojenie[] = array('от '.$ot. ' минут до часа.</li><li>');
$predlojenie[] = array("Устранение","Исправление","Восстановление","Ремонт");
$predlojenie[] = array("всех");
$predlojenie[] = array("распространенных","частых","часто встречающихся");
$predlojenie[] = array("поломок.","неисправностей.");
$predlojenie[] = array('</li> <li>Дипломированные');
$predlojenie[] = array("сервисные");
$predlojenie[] = array("инженеры.","специалисты.","мастера.");
$predlojenie[] = array('</li></ul><p>Условия');
$predlojenie[] = array("ремонта");
$predlojenie[] = array('уточняйте по телефону: <a href="tel:+'.$phone.'">'.tools::format_phone($phone).'</a></p>');

$viezd_dostavkd = array();
$viezd_dostavkd_rand = rand(1,2);
if($viezd_dostavkd_rand == 1)
{
    $viezd_dostavkd = array("условия","сроки","стоимость");
}
if($viezd_dostavkd_rand == 2)
{
    $viezd_dostavkd = array("условия","сроки","цена");
}

$all_deall_devices_str = "";
foreach ($all_deall_devices as $items)
{
    $all_deall_devices_str .= $items["type_rm"] . ", ";
}
$all_deall_devices_str = substr("$all_deall_devices_str",0, -2);

$komplektuyshie = array();
$komplektuyshie[] = array("комплектующие для ".$all_deall_devices_str,"запчасти для ".$all_deall_devices_str,"оригинальные запчасти для ".$all_deall_devices_str,"список компектующих для ".$all_deall_devices_str);


$diagnostika = array();
$diagnostika = array("аппаратная","программная","внешняя");
$vremya_raboti = "время восстановления: ". $all_deall_devices_str;

$services = array();
$t0 = array();
if (empty($this->_datas['hb']) && empty($this->_datas['hab'])) {
    foreach ($all_deall_devices as $device) {
        if (!isset($device['type_id'])) continue;

        $suffics = tools::get_suffics($device['type']);

        $table = $suffics . '_service_to_m_models';
        $join_field = $suffics . '_service_syn_id';
        $join_table = $suffics . '_service_syns';
        $main_table = $suffics . '_services';
        $main_field = $suffics . '_service_id';
        $cost_table = $suffics . '_service_costs';

        $sql = "SELECT `{$join_table}`.`name` as `name`, `{$main_table}`.`id` as `service_id`, `{$cost_table}`.* FROM `{$table}` 
                INNER JOIN `{$join_table}` ON `{$table}`.`{$join_field}` = `{$join_table}`.`id`
                INNER JOIN `{$main_table}` ON `{$main_table}`.`id` = `{$join_table}`.`{$main_field}`
                INNER JOIN `{$cost_table}` ON `{$main_table}`.`id` = `{$cost_table}`.`{$main_field}` 
            WHERE `{$table}`.`site_id`=:site_id AND `{$table}`.`marka_id`=:marka_id AND `{$table}`.`type` = 3 AND `{$cost_table}`.`setka_id`=:setka_id
                     AND `{$main_table}`.`popular` = 1 ORDER BY RAND()";

        $stm = pdo::getPdo()->prepare($sql);
        $stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));

        foreach ($stm->fetchAll(\PDO::FETCH_ASSOC) as $value) {
            $t = $value;
            $t['model_type_id'] = $device['type_id'];
            $t['name'] = $t['name'] . ' ' . $device['type_re'];
            $t0[] = $t;
        }

        $services = $services + $t0;
    }

    $services = rand_it::randMas($services, 5, '', $this->_datas['feed']);
} elseif(empty($this->_datas['hb']) && !empty($this->_datas['hab'])) {
    include __DIR__.'/data/gadget_price.php';
    if ( !empty($gadget_price[$all_deall_devices[0]['type']]) ) {
        foreach ( $gadget_price[$all_deall_devices[0]['type']] as $value) {
            $services[] = ['price' =>  $value[1], 'name' => $value[0]];
        }
        shuffle($services);
        $services = array_slice($services, 0, (count($services)>=7)?7:count($services));
    }else{
        $services = [
            ['price' =>  '', 'name' => '']
        ];
    }
} else {    
    //$params = unserialize($this->_datas['params']);

    $sql_charset = 'utf8';
    $sql_opt = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $sql_host    = '148.251.19.126';
    $sql_db      = 'cibacrm';
    $sql_user    = 'cibacrm';
    $sql_pass    = 'y0fgdrsVhmgsAVs4vmC4Sm8YAUvV7R6u';
    $sql_dsn     = "mysql:host={$sql_host};dbname={$sql_db};charset={$sql_charset}";

    $this->ciba_pdo = new \PDO($sql_dsn, $sql_user, $sql_pass, $sql_opt);

    $ciba_model_type_name = pdo::getPdo()->query('SELECT `name` FROM `model_types` WHERE `id`='.$this->_datas['params']['model_type_id'])->fetchColumn();
    $ciba_model_type_id = $this->ciba_pdo->query('SELECT `id` FROM `model_types` WHERE `name`="'.$ciba_model_type_name.'" AND `organization_id` IS NULL LIMIT 1')->fetchColumn();

    $query = $this->ciba_pdo->prepare('SELECT `name_prices`.`name`, MIN(`s_prices`.`price`) AS `price` FROM `s_prices` LEFT JOIN `models` ON `s_prices`.`model_id`=`models`.`id` LEFT JOIN `name_prices` ON `s_prices`.`name_price_id`=`name_prices`.`id` WHERE `models`.`model_type_id`=? GROUP BY `s_prices`.`name_price_id` LIMIT 7');
    $query->execute([$ciba_model_type_id]);
    $services = $query->fetchAll();

    foreach ($services as $key => $val) {
        $services[$key]['price'] = $val['price']+(rand(-2,7)*50+rand(0,1)*49);
    }

}
?>

<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <ul class="breadcrumbs-inside">
                   <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>  
                        <li class="breadcrumbs-inside-drop">
                            <a href="/info/"><span itemprop="name">Информация</span></a>
                            <span class="breadcrumbs-inside-drop-btn"></span>
                            <ul class="drop">
                                <li itemprop="name"><a itemprop="url" href="/info/time-to-repair/">Время ремонта</a></li>
                                <li itemprop="name"><a itemprop="url" href="/info/delivery/">Выезд и доставка</a></li>  
                                <li itemprop="name"><a itemprop="url" href="/info/diagnostics/">Диагностика</a></li>               
                                <li itemprop="name"><a itemprop="url" href="/info/components/">Компоненты</a></li>
                            </ul>
                        </li>
                    <li itemprop="name"><span>Срочный ремонт</span></li>
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
					<div class="block block-image">
                        <div class="block-image-url" style="background-image: url('/images/sample/hurry-up.jpg')"></div>
                    </div>
                    <div class="block block-text">
                        <div class="block-inside">
                            <?=$this->checkarray($predlojenie)?>
                            <p><strong>Срочный ремонт устройств <?=$marka?></strong> <span>от <?=$ot?> минут</span></p>
                        </div>
                    </div>

                    <? if (empty($this->_datas['hb']) && empty($this->_datas['hab'])) {  ?>

                    <div class="block block-table block-service-table">
                        <div class="block-inside">
                            <h2>Популярные услуги по ремонту <?=$marka?></h2>
                            <div class="services-item-table services-item-table-full services-item-table-2row">
                            
                                 <a class="services-item-row" style="color: black; font-weight: 500;">
					                <span class="services-item-name" style="text-decoration: none;">Название услуги</span>
									<span class="services-item-value">Время ремонта, мин</span>
								</a> 
                                                 
                                  <? foreach ($services as $value):?>
                                    
                                        <div class="a services-item-row">
                                            <a class="services-item-name" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $value['model_type_id'], 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value['service_id'])));?>/" ><?=tools::mb_firstupper($value['name'])?></a>
                                            <span class="services-item-value"><?=tools::format_time($value['time_min'], $value['time_max'], $value['ed_time'], $setka_name);?></span>
                                        </div>
                                        
                                  <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <?} elseif(empty($this->_datas['hb']) && !empty($this->_datas['hab'])) {?>
                    
                        <div class="block block-table block-service-table">
                            <div class="block-inside">
                                <h2>Популярные услуги по ремонту плоттеров</h2>
                                <div class="services-item-table services-item-table-full services-item-table-2row">

                                    <a class="services-item-row" style="color: black; font-weight: 500;">
                                        <span class="services-item-name" style="text-decoration: none;">Название услуги</span>
                                        <span class="services-item-value">Стоимость ремонта, руб</span>
                                    </a>

                                    <? foreach ($services as $value):?>

                                        <div class="a services-item-row">
                                            <span class="services-item-name"><?=tools::mb_firstupper($value['name'])?></span>
                                            <span class="services-item-value"><?=$value['price']?></span>
                                        </div>

                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <? } else { ?>

                        <div class="block block-table block-service-table">
                            <div class="block-inside">
                                <h2>Популярные услуги по ремонту плоттеров</h2>
                                <div class="services-item-table services-item-table-full services-item-table-2row">

                                    <a class="services-item-row" style="color: black; font-weight: 500;">
                                        <span class="services-item-name" style="text-decoration: none;">Название услуги</span>
                                        <span class="services-item-value">Стоимость ремонта, руб</span>
                                    </a>

                                    <? foreach ($services as $value):?>

                                        <div class="a services-item-row">
                                            <span class="services-item-name"><?=tools::mb_firstupper($value['name'])?></span>
                                            <span class="services-item-value"><?=number_format($value['price'], 0, ',', ' ')?></span>
                                        </div>

                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>

                    <? } ?>

					<? include __DIR__.'/form.php'; ?>
					
                </div>
            </div>
        </div>
    </section>
    <section class="link-block-section">
        <div class="container">
            <div class="grid-12">
                <div class="link-block-list perelink">
                    <a href="/info/time-to-repair/" class="link-block">
                        <div class="link-block-title-strong">Время ремонта</div><?=$this->firstup($vremya_raboti)?>
                    </a>
                    <a href="/info/components/" class="link-block">
                        <div class="link-block-title-strong">Комплектующие</div><?=$this->firstup($this->checkarray($komplektuyshie))?>
                    </a>
                    <a href="/info/diagnostics/" class="link-block">
                        <div class="link-block-title-strong">Диагностика</div><?=$this->firstup($this->rand_arr_str($diagnostika))?>
                    </a>
                    <a href="/info/delivery/" class="link-block">
                        <div class="link-block-title-strong">Выезд и доставка</div><?=$this->firstup($this->rand_arr_str($viezd_dostavkd))?>
                    </a>
                </div>   
            </div>
    </section>
</main>