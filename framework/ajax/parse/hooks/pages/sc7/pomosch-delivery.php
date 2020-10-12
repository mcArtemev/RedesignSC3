<?
use framework\tools;
use framework\ajax\parse\parse;

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

$komplektuyshie = array();
$komplektuyshie[] = array("комплектующие для ".$all_deall_devices_str.",","запчасти для ".$all_deall_devices_str.",","оригинальные запчасти для ".$all_deall_devices_str.",","список компектующих для ".$all_deall_devices_str);

$vremya_raboti = "время восстановления: ". $all_deall_devices_str;

$diagnostika = array();
$diagnostika = array("аппаратная","программная","внешняя");

$dostavka = array();
if($region_name == "Москва")
{
    $dostavka[] = array("По Москве","бесплатно");
    $dostavka[] = array("Выезд за МКАД не далее 5 км","200 рублей");
    $dostavka[] = array("От 5 до 30 км за МКАД","400 рублей");
    $dostavka[] = array("От 30 км за МКАД","от 500 рублей");
}
else
{
    $dostavka[] = array("По ".$region_name_de, "бесплатно");
    $dostavka_cena_rand = rand(1,2);
    if($dostavka_cena_rand == 1)
    {
        $dostavka_cena = "200";
    }
    if($dostavka_cena_rand == 2)
    {
        $dostavka_cena = "250";
    }

    $dostavka[] = array("Выезд за пределы города (не далее 5 км)",$dostavka_cena." рублей");
    $dostavka_cena_rand2 = rand(1,2);
    if($dostavka_cena_rand2 == 1)
    {
        $dostavka_cena2 = "200";
    }
    if($dostavka_cena_rand2 == 2)
    {
        $dostavka_cena2 = "250";
    }
    $dostavka[] = array("От 5 до 30 км за город","от ".$dostavka_cena2." рублей");

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
                                        <li itemprop="name"><a itemprop="url" href="/info/diagnostics/">Диагностика</a></li>
                                        <li itemprop="name"><a itemprop="url" href="/info/components/">Компоненты</a></li>
                                        <li itemprop="name"><a itemprop="url" href="/info/hurry-up-repairs/">Срочные работы</a></li>   
                                    </ul>
                                </li>
                            <li itemprop="name"><span>Выезд и доставка</span></li>
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
                                <div class="block-image-url" style="background-image: url('/images/delivery/delivery<?=rand(1, 6)?>.png')">
							</div>
                            </div>
                            <div class="block block-text">
                                <div class="block-inside">
                                    <?=$description_delivery?>
                                </div>
                            </div>
                             
                            <div class="block block-table">
                                <div class="block-inside">
                                    <h2>Стоимость доставки устройств <?=$marka?></h2>
                                    <div class="services-item-table">
                                        <?foreach ($dostavka as $item):?>
                                        <span class="services-item-row">
                                            <span class="services-item-name"><?=$item[0]?></span>
                                            <span class="services-item-value"><?=$item[1]?></span>
                                        </span>
                                        <?endforeach;?>
                                    </div>
                                </div>
                            </div>
							<? include __DIR__.'/form.php'; ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="link-block-section">
                <div class="container">
                    <div class="grid-12">
                        <div class="link-block-list perelink">
                            <a href="/info/diagnostics/" class="link-block">
                                <div class="link-block-title-strong">Диагностика</div><?=$this->firstup($this->rand_arr_str($diagnostika))?>
                            </a>
                            <a href="/info/hurry-up-repairs/" class="link-block">
                                <div class="link-block-title-strong">Срочные работы</div><?=$this->firstup($this->rand_arr_str($srochnii_remont))?>
                            </a>
                            <a href="/info/components/" class="link-block">
                                <div class="link-block-title-strong">Комплектующие</div>Накопители, цены
                            </a>
                            <a href="/info/time-to-repair/" class="link-block">
                                <div class="link-block-title-strong">Время ремонта</div><?=$this->firstup($vremya_raboti)?>
                            </a>
                        </div>
                    </div>
            </section>
        </main>