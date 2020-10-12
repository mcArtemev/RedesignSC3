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


$diagnostika = array();
$diagnostika = array("аппаратная","программная","внешняя");


$pervoe_predlojenie = array();
$pervoe_predlojenie[] = array("RUSSUPPORT традиционно экономит время каждого клиента. В большинстве случаев типовые");
$pervoe_predlojenie[] = array("неисправности","неполадки");
$pervoe_predlojenie[] = array("в");
$pervoe_predlojenie[] = array("аппаратах","устройствах");
$pervoe_predlojenie[] = array($marka);
$pervoe_predlojenie[] = array("наша команда устраняет в течение максимум 24-х часов с момента обращения. Время восстановления конкретного устройства ".$marka." будет указан в");
$pervoe_predlojenie[] = array("листе","бланке");
$pervoe_predlojenie[] = array("приемки.");

$price_list = [
                ['Восстановление поврежденных файлов',3000],
                ['Аппаратные неисправности',4000],
                ['Копирование восстановленных данных',0],
                ['Обучение работе с ПК',700],
                ['Установка WINDOWS',365],
                ['Настройка принтера',425],
                ['Настройка системы сетевой безопасности',365],    
];
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
                                <li itemprop="name"><a itemprop="url" href="/info/hurry-up-repairs/">Срочные работы</a></li>
                            </ul>
                        </li>
                    <li itemprop="name"><span>Время работ</span></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="title-block">
        <div class="container">
            <div class="grid-12">
                <h1>Время работ</h1>
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
                    <div class="block block-table block-service-table">
                        <div class="block-inside">
                            <h2>Некоторые виды проводимых работ <?=$marka?></h2>
                            <div class="services-item-table services-item-table-full services-item-table-2row">
                                <? foreach($price_list as $value){ ?>
                                <div class="a services-item-row">
                                    <a class="services-item-name"><?=$value[0]?></a>
                                    <span class="services-item-value"><?=$value[1]?></span>
                                </div>
                            <?}?>
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
                    <a href="/info/delivery/" class="link-block">
                        <div class="link-block-title-strong">Выезд и доставка</div><?=$this->firstup($this->rand_arr_str($viezd_dostavkd))?>
                    </a>
                    <a href="/info/components/" class="link-block">
                        <div class="link-block-title-strong">Комплектующие</div>Накопители, цены
                    </a>
                    <a href="/info/diagnostics/" class="link-block">
                        <div class="link-block-title-strong">Диагностика</div><?=$this->firstup($this->rand_arr_str($diagnostika))?>
                    </a>
                    <a href="/info/hurry-up-repairs/" class="link-block">
                        <div class="link-block-title-strong">Срочные работы</div><?=$this->firstup($this->rand_arr_str($srochnii_remont))?>
                    </a>
                 </div>
            </div>
    </section>
</main>