<?
use framework\tools;
use framework\ajax\parse\parse;
use framework\pdo;

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

$setka_id = $this->_datas['setka_id'];
$site_id = $this->_site_id;

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


$pervoe_predlojenie = array();
$pervoe_predlojenie[] = array("RUSSUPPORT традиционно экономит время каждого клиента. В большинстве случаев типовые");
$pervoe_predlojenie[] = array("неисправности","неполадки");
$pervoe_predlojenie[] = array("в");
$pervoe_predlojenie[] = array("аппаратах","устройствах");
$pervoe_predlojenie[] = array($marka);
$pervoe_predlojenie[] = array("наша команда устраняет в течение максимум 24-х часов с момента обращения. Время ремонта конкретного устройства ".$marka." будет указан в");
$pervoe_predlojenie[] = array("листе","бланке");
$pervoe_predlojenie[] = array("приемки.");

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

}elseif(!empty($this->_datas['hab'])){
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
                                <li itemprop="name"><a itemprop="url" href="/info/delivery/">Выезд и доставка</a></li>  
                                <li itemprop="name"><a itemprop="url" href="/info/diagnostics/">Диагностика</a></li>               
                                <li itemprop="name"><a itemprop="url" href="/info/components/">Компоненты</a></li>
                                <li itemprop="name"><a itemprop="url" href="/info/hurry-up-repairs/">Срочный ремонт</a></li>
                            </ul>
                        </li>
                    <li itemprop="name"><span>Время ремонта</span></li>
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
                        <div class="block-image-url" style="background-image: url('/images/sample/time-repair.jpg')">
                        </div>
                    </div>
                    <div class="block block-text">
                        <div class="block-inside">
                            <p><?=$this->checkarray($pervoe_predlojenie)?></p>
                        </div>
                    </div>
                    <? if (empty($this->_datas['hb']) && empty($this->_datas['hab'])) { ?>
                    <div class="block block-table block-service-table">
                        <div class="block-inside">
                            <h2>Время ремонта устройств <?=$marka?></h2>
                            <div class="services-item-table services-item-table-full services-item-table-2row">
                                <?foreach ($all_deall_devices as $key => $item):
                                if (!isset($item['type_id'])) continue;
                                if ($key == 5) break;
                                
                                $suffics = tools::get_suffics($item['type']);
                                
                                $cost_table = $suffics.'_service_costs';
                                $join_field = $suffics.'_service_id';
                                
                                $sql = "SELECT MIN(`time_min`) FROM `{$cost_table}` 
                                        WHERE `setka_id`=:setka_id AND `{$join_field}` != 1";
                                $stm = pdo::getPdo()->prepare($sql);
                                $stm->execute(array('setka_id' => $setka_id));
                                
                                $time = $stm->fetchColumn();
                                ?>
                                <div class="a services-item-row">
                                    <a class="services-item-name" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $item['type_id'], 'marka_id' => $this->_datas['marka']['id'])))?>/" ><?echo $this->firstup($item['type_m']);?></a>
                                    <span class="services-item-value">от <?=$time?> минут</span>
                                </div>
                                <?endforeach;?>
                            </div>
                        </div>
                    </div>
                    <?} elseif(empty($this->_datas['hb']) && !empty($this->_datas['hab'])) {?>
                        <div class="block block-table block-service-table">
                            <div class="block-inside">
                                <h2>Некоторые услуги по ремонту плоттеров</h2>
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
                                <h2>Некоторые услуги по ремонту плоттеров</h2>
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
                    <a href="/info/delivery/" class="link-block">
                        <div class="link-block-title-strong">Выезд и доставка</div><?=$this->firstup($this->rand_arr_str($viezd_dostavkd))?>
                    </a>
                    <a href="/info/components/" class="link-block">
                        <div class="link-block-title-strong">Комплектующие</div><?=$this->firstup($this->checkarray($komplektuyshie))?>
                    </a>
                    <a href="/info/diagnostics/" class="link-block">
                        <div class="link-block-title-strong">Диагностика</div><?=$this->firstup($this->rand_arr_str($diagnostika))?>
                    </a>
                    <a href="/info/hurry-up-repairs/" class="link-block">
                        <div class="link-block-title-strong">Срочный ремонт</div><?=$this->firstup($this->rand_arr_str($srochnii_remont))?>
                    </a>
                 </div>
            </div>
    </section>
</main>