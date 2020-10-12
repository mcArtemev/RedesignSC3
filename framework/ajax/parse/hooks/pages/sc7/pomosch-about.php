<?
use framework\tools;
use framework\ajax\parse\parse;
use framework\pdo;
use framework\ajax\parse\hooks\sc;

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

$address = $this->_datas['partner']['address1'];
$address2 = $this->_datas['partner']['address2'];

srand($this->_datas['feed']);

$adr = ($address2) ? $address2 : $address;


$feed = $this->_datas['feed'];
?>

<main>
        <section class="breadcrumbs">
            <div class="container">
                <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <ul class="breadcrumbs-inside">
                       <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>  
                       <li itemprop="name"><span>О компании</span></li>
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
                    <div class="block block-big block-bottom-image">
                        <div class="block-inside">
                            <? if ($region_name != 'Москва') echo '<!--noindex-->'; ?>
                                <p><?=$description_company?></p>
                            <? if ($region_name != 'Москва') echo '<!--/noindex-->'; ?>
                        </div>
                    </div>
                    <div class="block block-big block-diagramm">
                        <div class="block-inside">
                            <div class="diagramm-list-title"><?=$servicename?> цифрами:</div>
                            <canvas id="chart-bar-0" width="530" height="433"></canvas>
                        </div>
                    </div>
                    <a class="btn btn-link" style="float: right;" href="/about/price/">Все услуги по ремонту</a>
                </div>
            </div>
        </div>
    </section>
    <section class="link-block-section">
        <div class="container">
            <div class="grid-12">
                <div class="link-block-list">
                     <? foreach ($this->_datas['blocks'] as $block)
                            echo sc::_createTree($block, $feed); ?>
                </div>
                <div class="block-list center">      
                    <ul class="block-list-links line">
                        <li><a href="/info/">Информация</a></li>
                        <li><a href="/about/action/">Акции</a></li>
                        <li><a href="/about/vacancy/">Вакансии</a></li>
                        <li><a href="/about/contacts/">Контакты</a></li>
                        <li><a href="/about/price/">Услуги и цены</a></li>                       
                    </ul>                    
                </div>
            </div>
    </section>    
    <?
    echo '<div class="label-wrapper" style="display:none">';
    foreach (array("Срочные ремонты", "Восстановлено устройств", "Выездов сделано", "Диагностик проведено", "Данных восстановлено") as $key => $label)
    {
        echo '<span style="display:none" class="label" data-val="'.$this->_datas['r'][$key].'">'.$label.'</span>';
    }
    
    echo '<input type="hidden" name="max" value="'.$this->_datas['rand_ustroistva'].'"></div>'; ?>
</main>