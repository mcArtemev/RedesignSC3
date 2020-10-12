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
// if ($this->_datas['hb'] === false) {
include __DIR__.'/data/gadget_price.php';
// }

foreach ($all_deall_devices as $device)
{
    $add_device = false;
    
    if (!isset($device['type_id']))
        $add_device = true; 
    
    if (!$add_device)
    {
        if ($this->_datas['hab'] === false) {
            $suffics = tools::get_suffics($device['type']);

            $table = $suffics.'_service_to_m_models';
            $join_field = $suffics.'_service_syn_id';
            $join_table = $suffics.'_service_syns';
            $main_table = $suffics.'_services';
            $main_field = $suffics.'_service_id';
            $cost_table = $suffics.'_service_costs';

            $sql = "SELECT `{$join_table}`.`name` as `name`, `{$main_table}`.`id` as `service_id`, `{$cost_table}`.* FROM `{$table}`
                    INNER JOIN `{$join_table}` ON `{$table}`.`{$join_field}` = `{$join_table}`.`id`
                    INNER JOIN `{$main_table}` ON `{$main_table}`.`id` = `{$join_table}`.`{$main_field}`
                    INNER JOIN `{$cost_table}` ON `{$main_table}`.`id` = `{$cost_table}`.`{$main_field}`
                WHERE `{$table}`.`site_id`=:site_id AND `{$table}`.`marka_id`=:marka_id AND `{$table}`.`type` = 3 AND `{$cost_table}`.`setka_id`=:setka_id
                         ORDER BY RAND(".$this->_datas['feed'].")";
                         
// echo '<div style="display:none">'.$sql.'</div>';


            $stm = pdo::getPdo()->prepare($sql);
            $stm->execute(array('site_id' => $site_id, 'marka_id' => $marka_id, 'setka_id' => $setka_id));

            $t0 = array();

            foreach ($stm->fetchAll(\PDO::FETCH_ASSOC) as $value)
            {
                $t = $value;
                $t['model_type_id'] = $device['type_id'];
                $t0[] = $t;
            }
            if (isset($this->_datas['admin'])){
               // var_dump($t0);
                echo ("SELECT `{$join_table}`.`name` as `name`, `{$main_table}`.`id` as `service_id`, `{$cost_table}`.* FROM `{$table}`
                    INNER JOIN `{$join_table}` ON `{$table}`.`{$join_field}` = `{$join_table}`.`id`
                    INNER JOIN `{$main_table}` ON `{$main_table}`.`id` = `{$join_table}`.`{$main_field}`
                    INNER JOIN `{$cost_table}` ON `{$main_table}`.`id` = `{$cost_table}`.`{$main_field}`
                WHERE `{$table}`.`site_id`={$site_id} AND `{$table}`.`marka_id`={$marka_id} AND `{$table}`.`type` = 3 AND `{$cost_table}`.`setka_id`={$setka_id}
                         ORDER BY RAND(".$this->_datas['feed'].")");
                echo "</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>";
                
            }
            $services[$device['type_id']] = $t0;// : rand_it::randMas($t0, 5, '', $this->_datas['feed']);
        }else{
            if (!empty($gadget_price[$device['type']]))
            {
                $services[$device['type']] = $gadget_price[$device['type']];
            }
        }
    }
    else
    {
        if (isset($gadget_price[$device['type']]))
        {
            $services[$device['type']] = $gadget_price[$device['type']];
        }
        else
        {
            $services[$device['type']] = false; 
        }
    }

}

$osnovnoi_text = array();
$osnovnoi_text[] = array("Ремонт","Восстановление","Починка");
$osnovnoi_text[] = array("устройств","техники","аппаратов");
$osnovnoi_text[] = array($marka . " в");
$osnovnoi_text[] = array("нашем сервисном центре","нашем сервисе","сервисном центре ".$servicename,"сервисе ".$servicename);
$osnovnoi_text[] = array("это индивидуальный подход к каждой проблеме.");
$osnovnoi_text[] = array("Каждая операция","Каждое действие");
$osnovnoi_text[] = array("происходит с помощью");
$osnovnoi_text[] = array("профессионального оборудования", "профессиональных стендов");
$osnovnoi_text[] = array("c использованием", "с применением");
$osnovnoi_text[] = array("исключительно", "только");
$osnovnoi_text[] = array("оригинальных", "сертифицированных");
$osnovnoi_text[] = array("запчастей.", "комплектующих.", "запасных частей.");

$osnovnoi_text[] = array("Благодаря этому мы лучший");
$osnovnoi_text[] = array("сервисный центр","сервис","сервис центр");
$osnovnoi_text[] = array("в городе ".$region_name.".");

$kontakti = array();
$kontakti_rand = rand(1,2);
if($kontakti_rand == 1)
{
    $kontakti = array("адрес","время работы","телефон");
}
if($kontakti_rand == 2)
{
    $kontakti = array("расположение офиса","расписание","номер телефона");
}

$uslugi = array();
$uslugi_rand = rand(1,3);
if($uslugi_rand == 1)
{
    $uslugi = array("цены","наименования услуг");
}
if($uslugi_rand == 2)
{
    $uslugi = array("прайслист","названия услуг");
}
if($uslugi_rand == 2)
{
    $uslugi = array("стоимость","перечисление услуг");
}


$all_deall_devices_str = "";
foreach ($all_deall_devices as $items)
{
    $all_deall_devices_str .= $items["type_rm"] . ", ";
}
$all_deall_devices_str = substr("$all_deall_devices_str",0, -2);

$komplektuyshie = array();
$komplektuyshie[] = array("комплектующие для ".$all_deall_devices_str.",","запчасти для ".$all_deall_devices_str.",","оригинальные запчасти для ".$all_deall_devices_str.",","список компектующих для ".$all_deall_devices_str);

$vremya_raboti = "время восстановления: ". $all_deall_devices_str;

$diagnostika = array();
$diagnostika = array("аппаратная","программная","внешняя");

$akcii = array();
$akcii = array("скидки","снижение стоимости","акционные услуги");

$vakansii = array();
$vakansii = array("карьера","работа в успешной компании");

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

if (!empty($this->_datas['hab'])) {
    $services = $all_services;
}

   
    
    
    // if($region_name = $this->_datas['region']['name']=='Новосибирск' && $marka_lower == 'dell' && $this->_datas['hab'] != true){
    //         print_r($services);
    //         var_dump('ololo');
            
    //     }

?>

<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs">
                <ul class="breadcrumbs-inside">
                       <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                            <li class="breadcrumbs-inside-drop">
                                <span itemprop="name"><a itemprop="url" href="/about/">О компании</a></span>
                                <span class="breadcrumbs-inside-drop-btn"></span>
                                <ul class="drop">
                                    <li itemprop="name"><a itemprop="url" href="/about/action/">Акции</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/vacancy/">Вакансии</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/contacts/">Контакты</a></li>
                                </ul>
                            </li>
                        <li itemprop="name"><span>Услуги и цены</span></li>
                </ul>
        </div>
        </div>
    </section>
    <section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h1><?=$this->_ret['h1']?></h1>
                <p class="non-block-text"><?=$this->checkarray($osnovnoi_text)?></p>
            </div>
        </div>
    </section>
    <section class="block-section">
        <div class="container">
            <div class="grid-12">
                <div class="block-list block-list block-list-auto">
                    <?
                            if (isset($this->_datas['admin'])){
                                var_dump($services);
                                echo "<pre>";
                                if (!empty($this->_datas['admin'][0])){
                                print_r($this->_datas[$this->_datas['admin'][0]]);
                                }else print_r($this->_datas);
                                echo "</pre>";
                            }
                    foreach ($all_deall_devices as $k=>$item) :
                    
                          if (isset($services[$item['type']])) 
                                if (!$services[$item['type']])
                                     continue; ?>
                    <div class="block block-table block-auto block-service-table">
                        <div class="block-inside">
                            <h3><?=tools::mb_firstupper($item['type_m'])?></h3>
                            <!--<div class="services-item-table services-item-table-full services-item-table-2row">-->
                            <div class="services-item-table services-item-table-full">
										<a class="services-item-row" style="color: black; font-weight: 500;">
											<span class="services-item-name" style="text-decoration: none;">Название услуги</span>
											<span class="services-item-value">Стоимость</span>
											<?=(empty($this->_datas['hb']))?'':'<span class="services-item-callback"></span>';?>
										</a>
                                  
                                   <!--noindex--!>
         <!--                          <a class="services-item-row" style="color: black; font-weight: 500;">-->
									<!--	<span class="services-item-name" style="text-decoration: none;">Название услуги</span>-->
									<!--	<span class="services-item-value">Стоимость, руб</span>-->
									<!--</a> -->
                                  <!--/noindex--!>   
                                  <? if (isset($item['type_id'])):
                                    if (empty($this->_datas['hab']) && empty($this->_datas['hb'])) {
                                        foreach (array_slice($services[$item['type_id']], 0, 5) as $value):?>

                                            <div class="a services-item-row" itemscope
                                                 itemtype="http://schema.org/Product">
                                                <a href="/<?= tools::search_url($site_id, serialize(array('model_type_id' => $value['model_type_id'], 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value['service_id']))); ?>/"
                                                   class="services-item-name"
                                                   itemprop="name"><?= tools::mb_firstupper($value['name']) ?></a>
                                                <span class="services-item-value"><? $price = tools::format_price($value['price'], $setka_name);
                                                    echo $price; ?> руб</span>
                                                     <!--<span class="services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>-->
                                                <meta itemprop="price" content="<?= $price ?>"/>
                                                <meta itemprop="priceCurrency" content="RUB"/>
                                            </div>

                                        <? endforeach;
                                    } elseif (!empty($this->_datas['hab']) && !empty($this->_datas['hb'])) {
                                        foreach ($services as $value):?>

                                            <div class="a services-item-row" itemscope
                                                 itemtype="http://schema.org/Product">
                                                <span class="services-item-name" itemprop="name"><?= tools::mb_firstupper($value['name']) ?></span>
                                                <span class="services-item-value"><?
                                                    $price=(!empty($gadget_price[$item['type']][$value['name']])) ? $gadget_price[$item['type']][$value['name']] : $price=tools::format_price($value['price'], $setka_name);
                                                // $price = tools::format_price($value['price'], $setka_name); 
                                                echo $price;?> руб</span>
                                                 <span class="services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
                                                <meta itemprop="price" content="<?= $price ?>"/>
                                                <meta itemprop="priceCurrency" content="RUB"/>
                                            </div>

                                        <? endforeach;
                                    } else { 
                                        foreach ($gadget_price[$item['type']] as $value):
                                    ?>
                                        <div class="a services-item-row" itemscope
                                             itemtype="http://schema.org/Product">
                                            <span class="services-item-name" itemprop="name"><?= tools::mb_firstupper($value[0]) ?></span>
                                            <span class="services-item-value"><?
                                                $price=$value[1];
                                            // $price = tools::format_price($value['price'], $setka_name); 
                                            echo $price;?> руб</span>
                                             <span class="services-item-callback"><button href="#callback" class="service-button-callback" data-toggle="modal"><span>Заказать звонок</span></button></span>
                                            <meta itemprop="price" content="<?= $price ?>"/>
                                            <meta itemprop="priceCurrency" content="RUB"/>
                                        </div>
                            <?      
                                        endforeach;
                                    }
                                   else:
                                   foreach (array_slice($services[$item['type']], 0, 5) as $value):?>
                                    <div class="a services-item-row" itemscope itemtype="http://schema.org/Product">
                                            <span class="services-item-name" itemprop="name"><?=tools::mb_firstupper($value[0])?></span>
                                            <span class="services-item-value"><? $price = tools::format_price($value[1], $setka_name); echo $price; ?> руб</span>
                                            <meta itemprop="price" content="<?=$price?>"/><meta itemprop="priceCurrency" content="RUB"/>
                                    </div>
                                    <? endforeach;
                                   endif;?>
                            </div>
                            <?php if (isset($item['type_id'])):?>
                            <?php if (empty($this->_datas['hab']) && count($services[$item['type_id']]) > 5) { ?>
                            <a class="btn btn-dark" data-slidedown="all<?=$k?>" style = "margin-top: 30px;">Показать все услуги</a>
                            <div data-slidedown-block = "all<?=$k?>" style = "display: none;" class="services-item-table services-item-table-full services-item-table-2row">

                              <? foreach (array_slice($services[$item['type_id']], 5) as $value):?>
     
                                    <div class="a services-item-row" itemscope itemtype="http://schema.org/Product">
                                        <a href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $value['model_type_id'], 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value['service_id'])));?>/" class="services-item-name" itemprop="name"><?=tools::mb_firstupper($value['name'])?></a>
                                        <span class="services-item-value"><? $price = tools::format_price($value['price'], $setka_name); echo $price; ?></span>
                                        <meta itemprop="price" content="<?=$price?>"/><meta itemprop="priceCurrency" content="RUB"/>
                                    </div>

                              <? endforeach; ?>
                              
                            </div>
                            <? } ?>
                            <?endif;?>
                            
                            <?php if (!isset($item['type_id'])):?>
                            <?php if (count($services[$item['type']]) > 5) { ?>
                            <a class="btn btn-dark" data-slidedown="all<?=$k?>" style = "margin-top: 30px;">Показать все услуги</a>
                            <div data-slidedown-block = "all<?=$k?>" style = "display: none;" class="services-item-table services-item-table-full services-item-table-2row">

                              <? foreach (array_slice($services[$item['type']], 5) as $value):?>
     
                                    <div class="a services-item-row" itemscope itemtype="http://schema.org/Product">
                                        <span class="services-item-name" itemprop="name"><?=tools::mb_firstupper($value[0])?></span>
                                        <span class="services-item-value"><? $price = tools::format_price($value[1], $setka_name); echo $price; ?></span>
                                        <meta itemprop="price" content="<?=$price?>"/><meta itemprop="priceCurrency" content="RUB"/>
                                    </div>

                              <? endforeach; ?>
                              
                            </div>
                            <? } ?>
                            <?endif;?>
                        </div>
                    </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    </section>
    
     <? if ($region_name == 'Москва'):?>
    <section class="title-block">
        <div class="container">
            <div class="grid-12">
            <p class="non-block-text" style="padding-bottom: 0px;">Диагностика при проведении ремонта бесплатна. Стоимость диагностики при отказе от ремонта или его 
           <?php if(!empty($this->_datas['hab']) && !empty($this->_datas['hb'])): ?>
                  невозможности составляет 499 за плоттер. 
           <?php else :?>  
                невозможности: составляет 499 рублей за смартфон, планшет, компьютер, сервер, принтер или МФУ, 799 рублей за ноутбук, моноблок, монитор,
                телевизор, игровую приставку, смарт-часы и 999 рублей за самокат, фотоаппарат, видеокамеру, проектор, vive и другие виды техники.
            <?php endif;?>    
                При поступлении устройства в сервис производится программная диагностика, которая занимает от 15 до 45 минут. 
                При невозможности выявить причину поломки программным методом, проводится аппаратное тестирование, которое может занимать несколько дней.</p>
            </div>
        </div>
    </section>
    <?endif;?>
               
    <section class="link-block-section">
        <div class="container">
            <div class="grid-12">
                <div class="link-block-list perelink">
                    <a href="/about/action/" class="link-block">
                        <div class="link-block-title-strong">Акции</div><?=$this->firstup($this->rand_arr_str($akcii))?>
                    </a>
                    <a href="/about/vacancy/" class="link-block">
                        <div class="link-block-title-strong">Вакансии</div><?=$this->firstup($this->rand_arr_str($vakansii))?>
                    </a>
                    <a href="/about/contacts/" class="link-block">
                        <div class="link-block-title-strong">Контакты</div><?=$this->firstup($this->rand_arr_str($kontakti))?>
                    </a>
            </div>
            </div>
    </section>
</main>
