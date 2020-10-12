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

$defects = array();
foreach ($all_deall_devices as $device)
{
    if (!isset($device['type_id'])) continue;
    
    $suffics = tools::get_suffics($device['type']);
    $select_table = $suffics.'_defect_syns';
    $join_field = $suffics.'_defect_id';
    
    if (pdo::getPdo()->query("SHOW TABLES LIKE '{$select_table}'")->rowCount() > 0)
    {
        $defects = $defects + pdo::getPdo()->query("SELECT `name` FROM (SELECT `name`, `{$join_field}` FROM `{$select_table}` ORDER BY RAND(".$this->_datas['feed'].")) as `subquery` GROUP BY `{$join_field}`")->fetchAll(\PDO::FETCH_ASSOC);
    }
}

$defects = rand_it::randMas($defects, 5, '', $this->_datas['feed']);

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

$srochnii_remont = array();
$srochnii_remont_rand = rand(1,2);
if($srochnii_remont_rand == 1)
{
    $srochnii_remont = array("время","условия");
}
if($srochnii_remont_rand == 2)
{
    $srochnii_remont = array("сроки","условия");
}

$all_deall_devices_str = "";
foreach ($all_deall_devices as $items)
{
    $all_deall_devices_str .= $items["type_rm"] . ", ";
}
$all_deall_devices_str = substr("$all_deall_devices_str",0, -2);

$vremya_raboti = "время восстановления: ". $all_deall_devices_str;

$komplektuyshie = array();
$komplektuyshie[] = array("комплектующие для ".$all_deall_devices_str,"запчасти для ".$all_deall_devices_str,"оригинальные запчасти для ".$all_deall_devices_str,"список компектующих для ".$all_deall_devices_str);

$pervoe_predlojenie = array();
$pervoe_predlojenie[] = array("Основа");
$pervoe_predlojenie[] = array("качественного","любого качественного");
$pervoe_predlojenie[] = array("ремонта -");
$pervoe_predlojenie[] = array("верная","правильная");
$pervoe_predlojenie[] = array("диагностика.");

$vtoroe_predlojenie = array();
$vtoroe_predlojenie[] = array($servicename,"Наш сервисный центр","Наш сервис центр","Наш сервис");
$vtoroe_predlojenie[] = array("проводит все уровни тестирования:");
$vtoroe_predlojenie_arr = array();
$vtoroe_predlojenie_arr = array("программной","аппаратной","внешней");
$vtoroe_predlojenie[] = array($this->rand_arr_str($vtoroe_predlojenie_arr));
$vtoroe_predlojenie[] = array("диагностики.");

$tretie_predlojenie = array();
$tretie_predlojenie[] = array("Только после");
$tretie_predlojenie[] = array("всех необходимых");
$tretie_predlojenie[] = array("операций","действий");
$tretie_predlojenie[] = array("и");
$tretie_predlojenie[] = array("установки","постановки","выдачи");
$tretie_predlojenie[] = array("технического","тех");
$tretie_predlojenie[] = array("заключения");
$tretie_predlojenie[] = array("мастера,","специалиста СЦ,","сервис инженера,");
$tretie_predlojenie[] = array("можно");
$tretie_predlojenie[] = array("определить");
$tretie_predlojenie[] = array("точные сроки","сроки","временные рамки");
$tretie_predlojenie[] = array("и");
$tretie_predlojenie[] = array("стоимость","цену");
$tretie_predlojenie[] = array("проведения");
$tretie_predlojenie[] = array("ремонта.","восстановительных работ.","восстановления.");

if (!empty($this->_datas['hb'])) {
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
                                <li itemprop="name"><a itemprop="url" href="/info/components/">Компоненты</a></li>
                                <li itemprop="name"><a itemprop="url" href="/info/hurry-up-repairs/">Срочные работы</a></li>   
                            </ul>
                        </li>
                    <li itemprop="name"><span>Диагностика</span></li>
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
                        <div class="block-image-url" style="background-image: url('/images/diagnostics/diagn<?=rand(1, 7)?>.png')"></div>
                    </div>
                    <div class="block block-text">
                        <div class="block-inside">
                            <p><?=$this->checkarray($pervoe_predlojenie)?> <?=$this->checkarray($vtoroe_predlojenie)?> <?=$this->checkarray($tretie_predlojenie)?></p>
                        </div>
                    </div>

                    <?php if (empty($this->_datas['hb'])) { ?>

                    <div class="block block-table">
                        <div class="block-inside">
                            <h2>Частые неисправности <?=$marka?></h2>
                            <div class="services-item-table">
                                <? foreach ($defects as $defect):?>
                                <span class="services-item-row">
                                    <span class="services-item-name"><?=tools::mb_firstupper($defect['name'])?></span>
                                    <span class="services-item-value"></span>
                                </span>
                                <?endforeach;?>
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
                    <a href="/info/components/" class="link-block">
                        <div class="link-block-title-strong">Комплектующие</div><?=$this->firstup($this->checkarray($komplektuyshie))?>
                    </a>
                    <a href="/info/delivery/" class="link-block">
                        <div class="link-block-title-strong">Выезд и доставка</div><?=$this->firstup($this->rand_arr_str($viezd_dostavkd))?>
                    </a>
                    <a href="/info/hurry-up-repairs/" class="link-block">
                        <div class="link-block-title-strong">Срочные работы</div><?=$this->firstup($this->rand_arr_str($srochnii_remont))?>
                    </a>
                    <a href="/info/time-to-repair/" class="link-block">
                        <div class="link-block-title-strong">Время ремонта</div><?=$this->firstup($vremya_raboti)?>
                    </a>
                </div>   
            </div>
    </section>
</main>