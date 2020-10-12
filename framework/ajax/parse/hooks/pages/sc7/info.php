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

$all_deall_devices_str = "";
$all_deall_devices_2 = $this->rand_arr(count($all_deall_devices),count($all_deall_devices),$all_deall_devices);
$all_deall_devices_2_count = count($all_deall_devices_2);
for($i=0;$i< $all_deall_devices_2_count; $i++)
{
    if($all_deall_devices_2_count != $i + 2)
    {
        $all_deall_devices_str .= $all_deall_devices_2[$i]["type"] . ", " ;
    }
    else
    {
        $all_deall_devices_str .= $all_deall_devices_2[$i]["type"] . " или " ;
    }
}

$all_deall_devices_str = substr("$all_deall_devices_str",0, -2);
if(count($all_deall_devices) == 1 )
{
    $all_deall_devices_kol_1 = "попадет";

}
if(count($all_deall_devices) > 1 )
{
    $all_deall_devices_kol_1 = "попадут";

}
$prdelojenie = array();
$prdelojenie[] = array('<p>Сервис центр','Сервисный центр');
$prdelojenie[] = array("предлагает");
$prdelojenie[] = array("широкий спектр","большой спектр","широкий выбор","большой выбор");
$prdelojenie[] = array("услуг, как по");
$prdelojenie[] = array("ремонту","восстановлению","починке");
$prdelojenie[] = array("устройств","аппаратов","гаджетов");
$prdelojenie[] = array("бренда ".$marka.",");
$prdelojenie[] = array("так и по  обслуживанию клиентов.");
$prdelojenie[] = array('Специально для вашего удобства '.$marka.' предоставляет дополнительные услуги:</p>');
$prdelojenie_rand = rand(1,2);

if($prdelojenie_rand == 1)
{
    $prdelojenie[] = array('<p>Выезд и доставка -');
    $prdelojenie[] = array("курьер сам приедет за вашим");
    $prdelojenie[] = array("сломанным","нерабочим","неисправным");
    $prdelojenie[] = array("аппаратом.","устройством.");
    $prdelojenie[] = array("После");
    $prdelojenie[] = array("ремонта","восстановления","починки");
    $prdelojenie[] = array("курьер привезет");
    $prdelojenie[] = array("действующий","рабочий");
    $prdelojenie[] = array("аппарат.");

    $prdelojenie[] = array("Срочный ремонт - мы");
    $prdelojenie[] = array("починим","восстановим","отремонтируем");
    $prdelojenie[] = array("ваш");
    $prdelojenie[] = array("нерабочий","сломанный","разбитый","неисправный");
    $prdelojenie[] = array("гаджет","аппарат");
    $prdelojenie[] = array('в экспресс формате.</p><p>');
}

if($prdelojenie_rand == 2)
{
    $prdelojenie[] = array('<p>Срочный ремонт - мы');
    $prdelojenie[] = array("починим","восстановим","отремонтируем");
    $prdelojenie[] = array("ваш");
    $prdelojenie[] = array("нерабочий","сломанный","разбитый","неисправный");
    $prdelojenie[] = array("гаджет","аппарат");
    $prdelojenie[] = array("в экспресс формате.");

    $prdelojenie[] = array("Выезд и доставка -");
    $prdelojenie[] = array("курьер сам приедет за вашим");
    $prdelojenie[] = array("сломанным","нерабочим","неисправным");
    $prdelojenie[] = array("аппаратом.","устройством.");
    $prdelojenie[] = array("После");
    $prdelojenie[] = array("ремонта","восстановления","починки");
    $prdelojenie[] = array("курьер привезет");
    $prdelojenie[] = array("действующий","рабочий");
    $prdelojenie[] = array('аппарат.</p><p>');
}

$prdelojenie[] = array("Можете быть");
$prdelojenie[] = array("уверенными,","спокойны,");
$prdelojenie[] = array("ваш ".$all_deall_devices_str." ".$all_deall_devices_kol_1." в надежные руки - все наши");
$prdelojenie[] = array("мастера","специалисты");
$prdelojenie[] = array('дипломированны.</p>');

$feed = $this->_datas['feed'];

?>

<main>
<section class="breadcrumbs">
            <div class="container">
                <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <ul class="breadcrumbs-inside">
                       <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>  
                       <li itemprop="name"><span>Информация</span></li>
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
                            <p><?=$this->checkarray($prdelojenie)?></p>
                        </div>
                    </div>
                    <div class="block block-big block-diagramm">
                        <div class="block-inside">
                            <div class="diagramm-list-title"><?=$servicename?> цифрами:</div>
                            <canvas id="chart-bar-0" width="530" height="433"></canvas>
                        </div>
                    </div>
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
                        <li><a href="/about/">О компании</a></li>
                        <li><a href="/info/time-to-repair/">Время ремонта</a></li>
                        <li><a href="/info/delivery/">Выезд и доставка</a></li>
                        <li><a href="/info/diagnostics/">Диагностика</a></li>
                        <li><a href="/info/components/">Комплектующие</a></li>
                        <li><a href="/info/hurry-up-repairs/">Срочный ремонт</a></li>  
                    </ul>                    
                </div>
            </div>
    </section>      
    <?
    echo '<div class="label-wrapper" style="display:none">';
    foreach (array("Срочные ремонты", "Отремонтировано устройств", "Выездов сделано", "Диагностик проведено", "Комплектующих заменено") as $key => $label)
    {
        echo '<span style="display:none" class="label" data-val="'.$this->_datas['r'][$key].'">'.$label.'</span>';
    }
    
    echo '<input type="hidden" name="max" value="'.$this->_datas['rand_ustroistva'].'"></div>'; ?>
</main>