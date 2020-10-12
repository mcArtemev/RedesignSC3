<?

use framework\tools;

$site_id = $this->_site_id;

if ($this->_mode)
{
    $model_type = $this->_datas['model_type'][3];
}

$model_type_id = $this->_datas['model_type']['id'];

$marka_id = $this->_datas['marka']['id'];

if ($this->_mode == 2)
{
    $model_id = $this->_datas['model']['id'];
    $full_type_name = $model_type['name_re'].' '.$this->_datas['model']['name'];
    $full_name = $this->_datas['model']['name'];
}

if ($this->_mode == 3)
{
    $full_name = $full_type_name = $model_type['name_re'].' '.$this->_datas['marka']['name'];
}

if ($this->_mode == 0)
{
    $full_name = $full_type_name = $this->_datas['marka']['name'];
}

$setka_name = $this->_datas['setka_name'];

$eds = $this->_datas['eds'];
$availables = $this->_datas['availables']; 

$vals = $this->_datas['vals'];

if ($this->_mode)
{
    $complect_name = tools::mb_firstupper($vals['name']);
    $complect_available = $this->_datas['available'];
    $complect_price = tools::format_price($vals['price'], $setka_name);
}
else
{
    $complect_price = tools::format_price($this->_datas['price'], $setka_name);  
}

$services_to_complect = isset($this->_datas['services_to_complect']) ? $this->_datas['services_to_complect'] : array();
$dop_services = isset($this->_datas['dop_services']) ? $this->_datas['dop_services'] : array();
$other_complects = isset($this->_datas['other_complects']) ? $this->_datas['other_complects'] : array();
$region_code = ($this->_datas['region']['code']) ? '-'.$this->_datas['region']['code'] : '';

$accord_image = $this->_datas['accord_image'];
$this->_ret['img'] = 'wp-content/uploads/2015/03/'.$marka_lower.'/'.$accord_image[$this->_datas['orig_model_type']['0']['name']].$region_code.'.png';
$metrica = $this->_datas['metrica'];

srand($this->_datas['feed']);


// Комплектующие М
if ($this->_mode == 2) {
// генереж
    $dat = tools::skl('complect', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'vin');
    $dat_rod = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'rp');
    $dat_dat = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'dat');
    $address = $this->_datas['partner']['address1']; // Адрес
    $region_name = $this->_datas['region']['name'];//Москва

    $syns = $this->_datas['syns'][rand(0, 3)]; // название услуги , 4 варианта
    $model_name = $this->_datas['model']['name'];
    $model_type_re = $this->_datas['model_type'][3]['name_rm'];

    $generate_h2 = array();
    $generate_h2[0][] = array(
        "$syns - стоимость", 
        "$syns - цена", 
        "$syns - цены", 
        "Цена на $dat", 
        "Цена на $dat и работы по замене", 
        "Цена на $dat и работы по ремонту", 
        "Цена на $dat и услуги по замене",
        "Цена на $dat и услуги по ремонту", 
        "Цена на $dat и работы по замене", 
        "Стоимость на $dat",
        "Стоимость на $dat и работы по замене", 
        "Стоимость на $dat и работы по ремонту",
        "Стоимость на $dat и услуги по замене", 
        "Стоимость на $dat и услуги по ремонту", 
        "Стоимость на $dat и работы по замене"
    );
    $generate_h2[0][] = array($model_name, "");
    $generate_h2[1][] = array("Дополнительная информация", "Информация о ремонте", "Информация о ремонте в сервисе", "Информация о ремонте в центре",
        "Информация о ремонте в нашем сервисе", "Информация о ремонте в нашем центре", "Дополнительная информация о ремонте", "Дополнительная информация о ремонте в сервисе",
        "Дополнительная информация о ремонте в центре", "Дополнительная информация о ремонте в нашем сервисе", "Дополнительная информация о ремонте в нашем центре",
        "Информация об услугах", "Информация об услугах сервиса", "Информация об услугах центра", "Информация об услугах в нашего сервиса", "Информация об услугах в нашего центра",
        "Дополнительная информация об услугах", "Дополнительная информация об услугах сервиса", "Дополнительная информация об услугах центра",
        "Дополнительная информация об услугах нашего сервиса", "Дополнительная информация об услугах нашего центра", "Информация о дополнительных услугах",
        "Информация о дополнительных услугах сервиса", "Информация о дополнительных услугах центра", "Информация о дополнительных услугах в нашего сервиса",
        "Информация о дополнительных услугах в нашего центра");
    $generate_h2_a = $this->checkarray($generate_h2[0]);
    $generate_h2_b = $this->checkarray($generate_h2[1]);

    $generate_a = array();
    $generate_a[] = array("Другие", "Самые", "");
    $generate_a[] = array("популярные", "распространенные", "востребованные", "часто востребованные");

    $generate_a_rand = rand(1, 2);
    if ($generate_a_rand == 1) {
        $generate_a[] = array("услуги,", "работы,");
        $generate_a[] = array("которые могут потребоваться", "по ремонту");
    }
    if ($generate_a_rand == 2) {
        $generate_a[] = array("услуги", "работы");
        $generate_a[] = array("по ремонту $model_type_re", "по ремонту $model_type_re $model_name");
    }

    $generate_a_a = $this->checkarray($generate_a);

    $generate_a1 = array();
    $generate_a1[] = array("Другие", "");
    $generate_a1[] = array("популярные", "распространенные", "востребованные", "часто востребованные");
    $generate_a1[] = array("комплектующие", "запчасти", "запасные части", "детали");
    $generate_a1[] = array("$model_type_re", "");
    $generate_a1[] = array("$model_name");

    //$generate_a1_a = $this->checkarray($generate_a1);

    $generate_a2 = array();
    $generate_a2[] = array("Другие", "");
    $generate_a2[] = array("комплектующие,", "запчасти,", "запасные части,", "детали,");
    $generate_a2[] = array("которые");
    $generate_a2[] = array("часто востребованы", "часто приобретаются");
    $generate_a2_rand = rand(1, 2);
    if ($generate_a2_rand == 1) {
        $generate_a2[] = array("при ремонте", "владельцами");
        $generate_a2[] = array("$model_type_re", "");
    }
    if ($generate_a2_rand == 2) {
        $generate_a2[] = array("клиентами");
        $generate_a2[] = array("сервиса", "сервис центра");
    }
    $generate_a2[] = array("$model_name");

    //$generate_a2_a = $this->checkarray($generate_a2);
    $generate_a_a_temporary = rand(1, 2);

    if ($generate_a_a_temporary == 1) {
        $generate_a12 = $this->checkarray($generate_a1);;
    }

    if ($generate_a_a_temporary == 2) {
        $generate_a12 = $this->checkarray($generate_a2);
    }

    // Создаём добавку для Комплектующие М

    $accessories_additive_m = array();
    $accessories_additive_m_title = $this->_datas['add_title'];
    $accessories_additive_m_rand =rand(1,2);
    if($accessories_additive_m_rand == 1)
    {
        $accessories_additive_m[0][] = array("Осуществляем","Производим","Проводим","Выполняем");
        $accessories_additive_m[1][] = array("любые работы:","работы любого уровня сложности:","работы любой сложности:","работы любого типа сложности","работы любого вида сложности:","работы любого вида:",
            "работы любого вида:","работы любой степени сложности:","работы любого характера:","работы любого вида:","работы любого класса:","работы любого типа:","работы любой категории сложности:");
        $accessories_additive_m[1][] = array($accessories_additive_m_title);
        $accessories_additive_m[1][] = array("и оказываем","и производим","и проводим","и выполняем");
        $accessories_additive_m[1][] = array("другие","все другие");
        $accessories_additive_m[1][] = array("ремонтные и диагностические","диагностические и ремонтные");
        $accessories_additive_m[1][] = array("услуги.","сервисных услуг.");
    }
    if($accessories_additive_m_rand == 2)
    {
        $accessories_additive_m[0][] = array("Оказываем","Производим","Проводим","Выполняем");
        $accessories_additive_m[1][] = array("любые услуги:","услуги любого уровня сложности:","услуги любой сложности:","услуги любого типа сложности","услуги любого вида сложности:","услуги любого вида:",
            "услуги любого вида:","услуги любой степени сложности:","услуги любого характера:","услуги любого вида:","услуги любого класса:","услуги любого типа:","услуги любой категории сложности:");
        $accessories_additive_m[1][] = array($accessories_additive_m_title);
        $accessories_additive_m[1][] = array("и осуществляем","и производим","и проводим","и выполняем");
        $accessories_additive_m[1][] = array("другие","все другие");
        $accessories_additive_m[1][] = array("виды ремонтных и диагностических");
        $accessories_additive_m[1][] = array("работ.","сервисных работ.");
    }

    $accessories_additive_m_conclusion = "";
    $accessories_additive_m_conclusion_comparison = $this->checkcolumn($accessories_additive_m[0][0]);

    $accessories_additive_m_rand3 = rand(1,2);
    if($accessories_additive_m_rand3 == 1)
    {


        $accessories_additive_m[2][] = array("За комплектующей", "За запчастью");
        $accessories_additive_m_rand2 = rand(1, 2);
        if ($accessories_additive_m_rand2 == 1) {

            $accessories_additive_m[2][] = array("вы можете");
            $accessories_additive_m[2][] = array("подъехать", "приехать ");
			if (!$this->_datas['partner']['exclude']) {
				$service_additive_m[2][] = array("к нам:","по адресу:","к нам по адресу:");
				$service_additive_m[2][] = array("$region_name, $address.");
			} else {
				$service_additive_m[2][] = array("к нам.");
			}
        }

        if ($accessories_additive_m_rand2 == 2) {
            $accessories_additive_m[2][] = array("подъезжайте", "приезжайте");
			if (!$this->_datas['partner']['exclude']) {
				$service_additive_m[2][] = array("к нам:","по адресу:","к нам по адресу:");
				$service_additive_m[2][] = array("$region_name, $address.");
			} else {
				$service_additive_m[2][] = array("к нам.");
			}
        }
    }

    if($accessories_additive_m_rand3 == 2)
    {
        $dat_upper = tools::mb_firstupper($dat);
		if (!$this->_datas['partner']['exclude']) {
			$accessories_additive_m[2][] = array("$dat_upper вы можете приобрести по адресу: $region_name, $address.");
		} else {
			$accessories_additive_m[2][] = array("$dat_upper вы можете приобрести у нас");
		}
       
    }


    if ($accessories_additive_m_conclusion_comparison == "Производим")
    {
        unset($accessories_additive_m[1][2][array_search("и производим", $accessories_additive_m[1][2])]);
    }
    if ($accessories_additive_m_conclusion_comparison == "Проводим")
    {
        unset($accessories_additive_m[1][2][array_search("и проводим", $accessories_additive_m[1][2])]);
    }
    if ($accessories_additive_m_conclusion_comparison == "Выполняем")
    {
        unset($accessories_additive_m[1][2][array_search("и выполняем", $accessories_additive_m[1][2])]);
    }

    $accessories_additive_m_conclusion .= $accessories_additive_m_conclusion_comparison . " " .  $this->checkarray($accessories_additive_m[1]) . " " . $this->checkarray($accessories_additive_m[2]);

}

// Комплектующие Т
if ($this->_mode == 3)
{

    $dat_rod = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'rp');
    $dat_dat = tools::skl('service', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'dat');
    $dat = tools::skl('complect', $this->_suffics, $this->_datas['syns'][rand(0, 3)], 'vin');
    $syns = $this->_datas['syns'][rand(0, 3)]; // название услуги , 4 варианта
    $model_type = $this->_datas['model_type'][3]['name']; // тип устройства
    $model_type_of = $this->_datas['model_type'][3]['name_rm']; // тип устройства
    $marka = $this->_datas['marka']['name'];  // SONY

    $generate_tm3_h2 = array();
    $generate_tm3_h2[0][] = array(
        "$syns - стоимость", 
        "$syns - цена", 
        "$syns - цены", 
        "Цена на $dat", 
        "Цена на $dat и работы по замене", 
        "Цена на $dat и работы по ремонту", 
        "Цена на $dat и услуги по замене",
        "Цена на $dat и услуги по ремонту", 
        "Цена на $dat и работы по замене", 
        "Стоимость на $dat",
        "Стоимость на $dat и работы по замене", 
        "Стоимость на $dat и работы по ремонту",
        "Стоимость на $dat и услуги по замене", 
        "Стоимость на $dat и услуги по ремонту", 
        "Стоимость на $dat и работы по замене"
    );
    $generate_tm3_h2[1][] = array("Дополнительная информация","Информация о ремонте","Информация о ремонте в сервисе","Информация о ремонте в центре",
        "Информация о ремонте в нашем сервисе","Информация о ремонте в нашем центре","Дополнительная информация о ремонте","Дополнительная информация о ремонте в сервисе",
        "Дополнительная информация о ремонте в центре","Дополнительная информация о ремонте в нашем сервисе","Дополнительная информация о ремонте в нашем центре",
        "Информация об услугах","Информация об услугах сервиса","Информация об услугах центра","Информация об услугах в нашего сервиса","Информация об услугах в нашего центра",
        "Дополнительная информация об услугах","Дополнительная информация об услугах сервиса","Дополнительная информация об услугах центра","Дополнительная информация об услугах нашего сервиса",
        "Дополнительная информация об услугах нашего центра","Информация о дополнительных услугах","Информация о дополнительных услугах сервиса",
        "Информация о дополнительных услугах центра","Информация о дополнительных услугах в нашего сервиса","Информация о дополнительных услугах в нашего центра");
    $generate_tm3_a = array();
    $generate_tm3_a[] = array("Другие","Самые","");
    $generate_tm3_a[] = array("популярные","распространенные","востребованные","часто востребованные");
    $generate_tm3_a[] = array("услуги","работы");

    $generate_tm3_a_a = $this->checkcolumn($generate_tm3_a[0]);
    $generate_tm3_a_a2 = $this->checkcolumn($generate_tm3_a[1]);
    $generate_tm3_delivery_a = "";
    $generate_tm3_delivery_a .= $generate_tm3_a_a . " " . $generate_tm3_a_a2 . " " . $this->checkcolumn($generate_tm3_a[2]);

    $generate_tm3_a_temporary = rand(1,2);


    if($generate_tm3_a_temporary == 1)
    {
        $generate_tm3_a[] = array("которые могут потребоваться","по ремонту");
        $generate_tm3_delivery_a .= " " . $this->checkcolumn($generate_tm3_a[3]);
    }
    $generate_tm3_a1 = array();
    $generate_tm3_a1[] = array("Другие","");
    $generate_tm3_a1[] = array("популярные","распространенные","востребованные","часто востребованные");
    $generate_tm3_a1[] = array("комплектующие","запчасти","запасные части","детали");
    $generate_tm3_a1[] = array("для $model_type_of","для $model_type_of $marka", "");

    if($generate_tm3_a_temporary == 2)
    {
        $generate_tm3_a[] = array("по ремонту");
        $generate_tm3_a[] = array($model_type_of,"$model_type_of $marka");
        $generate_tm3_a_a4 = $this->checkcolumn($generate_tm3_a[4]);
        $generate_tm3_delivery_a .= " " . $this->checkcolumn($generate_tm3_a[3]) . " " . $generate_tm3_a_a4;
        unset($generate_tm3_a1[3][array_search($generate_tm3_a_a4, $generate_tm3_a1[3])]);
    }

    $generate_tm3_delivery_a1 = "";

    if ($generate_tm3_a_a == "Другие")
    {
        unset($generate_tm3_a1[0][array_search("Другие", $generate_tm3_a1[0])]);
    }

    unset($generate_tm3_a1[1][array_search($generate_tm3_a_a2, $generate_tm3_a1[1])]);

    $generate_tm3_delivery_a1 .= $this->checkcolumn($generate_tm3_a1[0]) . " " . $this->checkcolumn($generate_tm3_a1[1]) . " " . $this->checkcolumn($generate_tm3_a1[2]) . " " . $this->checkcolumn($generate_tm3_a1[3]);

    $generate_tm3_a2 = array();
    $generate_tm3_a2[] = array("Другие","");
    $generate_tm3_a2[] = array("комплектующие,","запчасти,","запасные части,","детали,");
    $generate_tm3_a2[] = array("которые");
    $generate_tm3_a2[] = array("часто востребованы","часто приобретаются");

    $generate_tm3_delivery_a2 = "";
    $generate_tm3_delivery_a2 .= $this->checkcolumn($generate_tm3_a2[0]) . " " . $this->checkcolumn($generate_tm3_a2[1]) . " " . $this->checkcolumn($generate_tm3_a2[2]) . " " . $this->checkcolumn($generate_tm3_a2[3]) . " ";

    $generate_tm3_a2_temporary = rand(1,4);

    if($generate_tm3_a2_temporary == 1)
    {
        $generate_tm3_a2[] = array("при ремонте");
        $generate_tm3_a2[] = array($model_type_of,"$model_type_of $marka","");


        if($generate_tm3_a_temporary == 2)
        {
            unset($generate_tm3_a2[5][array_search($generate_tm3_a_a4, $generate_tm3_a2[5])]);
        }
        $generate_tm3_delivery_a2 .= $this->checkcolumn($generate_tm3_a2[4]) . " " . $this->checkcolumn($generate_tm3_a2[5]);
    }

    if($generate_tm3_a2_temporary == 2)
    {
        $generate_tm3_a2[] = array("клиентами");
        $generate_tm3_a2[] = array("сервиса","сервис центра","центра","ремонтного центра","ремонтного сервиса","нашего сервиса","нашего сервис центра",
            "нашего центра","нашего ремонтного центра","нашего ремонтного сервиса");
        $generate_tm3_delivery_a2 .= $this->checkcolumn($generate_tm3_a2[4]) . " " . $this->checkcolumn($generate_tm3_a2[5]);
    }

    if($generate_tm3_a2_temporary == 3)
    {
        $generate_tm3_a2[] = array("нашими клиентами");
        $generate_tm3_delivery_a2 .= $this->checkcolumn($generate_tm3_a2[4]);
    }

    if($generate_tm3_a2_temporary == 4)
    {
        $generate_tm3_a2[] = array("владельцами");
        $generate_tm3_a2[] = array("техники","устройств","разных моделей","техники $marka","устройств $marka","разных моделей $marka");
        $generate_tm3_delivery_a2 .= $this->checkcolumn($generate_tm3_a2[4]) . " " . $this->checkcolumn($generate_tm3_a2[5]);
    }

}

$use_choose_city = $this->_datas['use_choose_city'];
$add_class = ($use_choose_city) ? " js-choose-city" : "";

?>

    <div class="sr-main target">
        <div class="uk-width-medium-1-1 bgcolorwhite uk-hidden-small breadcrumbs">
            <div class="uk-container-center uk-container">
                <? if ($this->_mode == 2): ?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_id' => $model_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['model']['name']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span class="uk-text-muted"><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
                <? endif; ?>
                 <? if ($this->_mode == 3): ?>
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/" class="uk-icon-home uk-text-muted"><meta itemprop="title" content="Главная"/></a></span>
                    &nbsp;/&nbsp;
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/<?=tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)))?>/"><span itemprop="title">Ремонт <?=$this->_datas['orig_model_type'][0]['name_rm']?></span></a></span>
                    &nbsp;/&nbsp;
                    <span class="uk-text-muted"><?=tools::mb_firstupper($this->_datas['syns'][3])?></span>
                <? endif; ?>
            </div>
        </div>
        
        <div class="uk-width-medium-1-1 bgcolorwhite uk-visible-small<?=$add_class?>">
            <div class="uk-container-center uk-container">
               <a href="tel:+<?=$phone?>" class="uk-text-muted"><?=$phone_format?></a>
            </div>
        </div>        
        
        <div class="uk-container-center uk-container" itemscope itemtype="http://schema.org/Product">
            <div class="uk-grid uk-margin-remove" data-uk-grid-margin>
                <div class="uk-width-medium-4-10 ">
                    <img itemprop="image" src="/<?=$this->_ret['img']?>" class="uk-margin-top uk-align-center">
                </div>
                <div class="uk-width-medium-6-10 whiteblock ">
                    <h1 itemprop="name"><?=$this->_ret['h1']?></h1>
                    <span itemprop="description"><?=$this->_ret['text']?></span>
                    <p class="textPrice" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <span class="uk-align-left uk-text-large target-price" itemprop="price">от <?=$complect_price?> руб.</span>
                        <meta itemprop="priceCurrency" content="RUB"/>
                        <span class="uk-align-right"><input type="button" data-uk-modal="{target:'#popup'}" class=" uk-button  uk-button-large uk-button-success uk-margin-right" onclick="if (typeof window['yaCounter<?=$metrica?>'] !== 'undefined') yaCounter<?=$metrica?>.reachGoal('ORDER'); return false;" value="Записаться на ремонт"/></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
     <div class="sr-content">
        <div class="uk-container-center uk-container uk-margin-bottom">
            <div class="uk-flex sr-contetnt-block uk-margin-top sr-content-main">
                <div class="uk-width-large-7-10 sr-content-white ">
                    <p class="uk-h2 uk-margin-top">
                        <?
                        if ($this->_mode == 2)
                        {
                            echo $generate_h2_a;
                        }
                        if ($this->_mode == 3)
                        {
                            echo $this->firstup(trim($this->checkarray($generate_tm3_h2[0])));
                        }
                        ?>

                    </p>
                    <table class="priceTable uk-table uk-table-hover uk-table-striped">
                        <tbody>
                            <tr class="uk-text-small green">
                                <th>Наименование оборудования</th>
                                <th class="uk-text-center">Статус</th>
                                <th class="uk-text-center">Цена, руб</th>
                            </tr>
                            <tr>
                                <td><?=$complect_name?></td>
                                <td><?=$complect_available?></td>
                                <td>от <?=$complect_price?></td>
                            </tr>
                        </tbody>
                    </table>
                     <? if ($services_to_complect):?>
                        <table class="priceTable uk-table uk-table-hover uk-table-striped services">
                            <tbody>
                                <tr class="uk-text-small">
                                    <th>Наименование услуги</th>
                                    <th class="uk-text-center">Время ремонта, мин</th>
                                    <th class="uk-text-center">Цена, руб</th>
                                </tr>
                                <? foreach ($services_to_complect as $value): ?>
                                <? 
                                 if ($this->_mode == 2) 
                                    $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                                     
                                 if ($this->_mode == 3) 
                                    $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                                ?>
                                    
                                <tr>
                                    <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                    <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time'], $setka_name);?></td>
                                    <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                </tr>
                                <? endforeach;?>
                            </tbody>
                        </table>
                     <? endif; ?>
                     <? include __DIR__.'/form_new.php'; ?>  
                     <p class="uk-h2 uk-margin-medium-top">
                         <?
                         if ($this->_mode == 2)
                         {
                             echo $this->firstup(trim($generate_h2_b));
                         }
                         if ($this->_mode == 3)
                         {
                             echo $this->firstup(trim($this->checkarray($generate_tm3_h2[1])));
                         }
                         ?>
                     </p>
                     <? if ($dop_services):?>
                        <? if ($this->_mode == 2) echo '<p>'.$accessories_additive_m_conclusion.'</p>'; ?>
                        <p class="uk-h3">
                            <?
                            if ($this->_mode == 2)
                            {
                                echo $this->firstup(trim($generate_a_a));
                            }
                            if ($this->_mode == 3)
                            {
                                echo $this->firstup(trim($generate_tm3_delivery_a));
                            }
                            ?>
                        </p>
                        <table class="priceTable uk-table uk-table-hover uk-table-striped services">
                            <tbody>
                                <tr class="uk-text-small">
                                    <th>Наименование услуги</th>
                                    <th class="uk-text-center">Время ремонта, мин</th>
                                    <th class="uk-text-center">Цена, руб</th>
                                </tr>
                                <? foreach ($dop_services as $value): ?>  
                                    <? 
                                    if ($this->_mode == 2) 
                                        $href = tools::search_url($site_id, serialize(array('model_id' => $model_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id']))); 
                                        
                                    if ($this->_mode == 3) 
                                        $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id, 'key' => 'service', 'id' => $value[$this->_suffics.'_service_id'])));
                                    ?>
                                                          
                                    <tr>
                                        <td><a href="/<?=$href?>/"><?=tools::mb_firstupper($value['name'])?></a></td>
                                        <td><?=tools::format_time($value['time_min'], $value['time_max'], $eds[$value[$this->_suffics.'_service_id']]['ed_time'], $setka_name)?></td>
                                        <td><?=tools::format_price($value['price'], $setka_name)?></td>
                                    </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>                            
                     <? endif;?>
                     <? if ($other_complects) :?>
                        <p class="uk-h3 uk-margin-medium-top">
                            <?
                            if ($this->_mode == 2)
                            {
                                echo $this->firstup(trim($generate_a12));
                            }
                            if ($this->_mode == 3)
                            {
                                $generate_tm3_a2_temporary_1_2 = rand(1,2);
                                if($generate_tm3_a2_temporary_1_2 == 1)
                                {
                                    echo $this->firstup(trim($generate_tm3_delivery_a1));

                                }
                                if($generate_tm3_a2_temporary_1_2 == 2)
                                {
                                    echo $this->firstup(trim($generate_tm3_delivery_a2));
                                }
                            }
                            ?>
                        </p>
                        <table class="priceTable uk-table uk-table-hover uk-table-striped">
                            <tbody>
                                <tr class="uk-text-small">
                                    <th>Наименование оборудования</th>
                                    <th class="uk-text-center">Статус</th>
                                    <th class="uk-text-center">Цена, руб</th>
                                </tr>
                                <? foreach ($other_complects as $value):?>
                               <tr>
                                    <td><?=tools::mb_firstupper($value['name'])?></td>
                                    <td><?=$availables[$value['available_id']]['name']?></td>
                                    <td>от <?=tools::format_price($value['price'], $setka_name)?></td>
                               </tr>
                                <? endforeach; ?>
                            </tbody>
                        </table>
                     <? endif;?>   
                      <?
                        if ($this->_mode == 2) 
                            $href = tools::search_url($site_id, serialize(array('model_id' => $model_id))); 
                        
                        if ($this->_mode == 3) 
                            $href = tools::search_url($site_id, serialize(array('model_type_id' => $model_type_id, 'marka_id' => $marka_id)));                      
                      ?>
                      <div class="uk-panel uk-panel-box uk-text-center">
                        <a href="/<?=$href?>/">Все комплектующие и услуги по ремонту <?=$full_name?></a>
                     </div>               
                </div>
                <? include __DIR__.'/right_part_new.php'; ?>  
            </div>
        </div>
     </div>