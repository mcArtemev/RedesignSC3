<?php
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

srand($this->_datas['feed']);

$feed = $this->_datas['feed'];

$all_deall_devices = $this->_datas['all_devices'];

$defects = [];

foreach ($all_deall_devices as $key => $item ) {
    if ($item['type']=='моноколесо') {
        $all_deall_devices[$key]['type_id'] = 24;
    }elseif($item['type']=='сегвей') {
        $all_deall_devices[$key]['type_id'] = 25;
    }elseif($item['type']=='гироскутер') {
        $all_deall_devices[$key]['type_id'] = 22;
    }elseif($item['type']=='электросамокат') {
        $all_deall_devices[$key]['type_id'] = 23;
    }
}

$mtids = implode(',', array_column($all_deall_devices, 'type_id'));

if($mtids !="0"){
    $stmt = pdo::getPdo()->query("SELECT name, url, model_type_id FROM 7_defects WHERE model_type_id IN ($mtids)");


    foreach ($stmt->fetchAll() as $def) {
      $defects[$def[2]][] = [$def[1], $def[0]];
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
                            <li itemprop="name"><a itemprop="url" href="/info/hurry-up-repairs/">Срочный ремонт</a></li>
                        </ul>
                    </li>
                <li itemprop="name"><span>Неисправности</span></li>
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
            <div class="block-list block-list-auto">
                <?foreach ($all_deall_devices as $item) { 
                    if (!isset($item['type_id'])) continue;
                    if (isset($defects[$item['type_id']]) && count($defects[$item['type_id']])) {?>
                <div class="block block-auto block-table">
                    <div class="block-inside">
                        <h3><?=tools::mb_firstupper($item['type'])?></h3>
                        <div class="services-item-table">
                              <? foreach ($defects[$item['type_id']] as $value):?>
                                    <span class="services-item-row">
                                        
                                    <? if (in_array($item['type_id'], [22,23,24,25])): ?>
                                        <span class="services-item-name"><span href = "/repair-<?=$this->_datas['accord_image'][$item['type']]?>/<?=$value[0]?>/"><?=tools::mb_firstupper($value[1])?></span></span>
                                    <? else: ?>    
                                        <span class="services-item-name"><a href = "/repair-<?=$this->_datas['accord_image'][$item['type']]?>/<?=$value[0]?>/"><?=tools::mb_firstupper($value[1])?></a></span>
                                    <? endif; ?>
                                    
                                        <span class="services-item-value"></span>
                                    </span>
                              <? endforeach; ?>
                        </div>
                    </div>
                </div>
              <? }} ?>
            </div>
        </div>
    </div>
</section>
</main>
