<?
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ

$region_name = $this->_datas['region']['name'];//Москва
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_pril = $this->_datas['region']['pril'];//Московском
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$address = $this->_datas['partner']['address1'];


srand(tools::gen_feed($this->_datas['region']['name']));


$minutes = array("5","10","15");
$minutes_in =  $this->checkcolumn($minutes);
//

srand($this->_datas['feed']);

$diagnostics = array();
$diagnostics[] = array("Экспресс диагностика за $minutes_in минут","Срочная диагностика за $minutes_in минут","Диагностика в экспресс режиме за $minutes_in минут");
$diagnostics_rand = rand(1,2);
if($diagnostics_rand == "1")
{
    $diagnostics[] = array("Программная диагностика устройств", "Программная диагностика техники", "Программная диагностика любых моделей", "Диагностика программной части");
    $diagnostics[] = array("Тестирование аппаратной части", "Тестирование аппаратной части техники", "Тестирование аппаратной части устройств", "Тестирование аппаратной части любых моделей",
        "Аппаратное тестирование устройств", "Аппаратное тестирование техники", "Аппаратное тестирование любых моделей");
}
if($diagnostics_rand == "2")
{
    $diagnostics[] = array("Программное тестирование устройства","Программное тестирование устройств","Программное тестирование техники","Программное тестирование любых моделей",
        "Тестирование программной части");
    $diagnostics[] = array("Диагностика аппаратной части","Диагностика аппаратной части техники","Диагностика аппаратной части устройств",
        "Диагностика аппаратной части любых моделей","Аппаратная диагностика устройств","Аппаратная диагностика техники","Аппаратная диагностика любых моделей");
}
$diagnostics[] = array("Выявление причин неисправности","Выявление причин поломки","Выявление первопричин неисправности","Выявление первопричин поломки",
    "Определение причин неисправности","Определение причин поломки","Определение первопричин неисправности","Определение первопричин поломки",
    "Точное выявление причин неисправности","Точное выявление причин поломки","Точное определение причин неисправности","Точное определение причин поломки");

$diagnostics_a = "";

while ( 0 < count($diagnostics) )
{
    $diagnostics_in = array_rand($diagnostics, 1);

    $diagnostics_in_in = array_rand($diagnostics[$diagnostics_in], 1);
    $diagnostics_a .= "<li><span>" . $diagnostics[$diagnostics_in][$diagnostics_in_in] . "</span></li>";

    unset($diagnostics[$diagnostics_in]);
    //sort($diagnostics);
}

$diagnostics2 = array();
$diagnostics2 = array("Диагностика – обязательная процедура для последующего выполнения ремонтных работ.","Стоимость и сроки обслуживания определяются на основе результатов диагностики в $servicename.");
$diagnostics2_a = "";
$diagnostics2_a .= "<p>" . $this->checkcolumn($diagnostics2) . "<br>";

$diagnostics3 = array();
$diagnostics3[] = array("Все виды тестирований","Программная и аппаратная диагностика","Аппаратная и программная диагностика","Аппаратная диагностика");
$diagnostics3[] = array("проводится","проводится в лаборатории","проводится в мастерской","проводится в лаборатории центра","проводится в мастерской центра",
    "проводится в лаборатории сервиса","проводится в мастерской сервиса","проводится на спецоборудовании");
$diagnostics3[] = array("по адресу:");
$diagnostics3[] = array("город", "");
$diagnostics3[] = array("$region_name, $address.");

$diagnostics2_a .=  $this->checkarray($diagnostics3) . "</p>";

$diagnostics4 = array();
$diagnostics4 = array("Устройства $marka разработаны с использованием самых современных технологий, а значит и их обслуживание является задачей технологической.",
    "В $region_name_pril сервис центре $ru_servicename большинство неисправностей могут определить при первичном осмотре аппарата, но в некоторых случаях этого недостаточно, и требуется проводить полное тестирование.");
$diagnostics4_a = "<p>" . $this->checkcolumn($diagnostics4) . "</p>";
//
?>

        <section class="fixed content-wrapper">
            <div class="content-block">

                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?=$multiMirrorLink?>/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span>Диагностика</span>
                </section>

                <div class="content-block__top">

                    <div class="info-block">

                        <h1><?=$this->_ret['h1']?></h1>

                        <img src="/userfiles/site/large/diagnostika.jpg" width="350" height="110" alt="Диагностика" title="Диагностика">

                        <ul class="list">
                            <!--<li><span>Экспресс диагностика за 15 минут</span></li>
                            <li><span>Программная диагностика устройства</span></li>
                            <li><span>Тестирование аппаратной части</span></li>
                            <li><span>Выявление причин неисправности</span></li>-->
                            <?=$diagnostics_a?>
                        </ul>

                        <!--<p>Диагностика &ndash; обязательная процедура для последующего выполнения ремонтных работ.
                        <br>Стоимость и сроки обслуживания определяются на основе результатов диагностики в <?=$servicename?>.</p>-->
                        <?=$diagnostics2_a?>
                        <a href="<?=$multiMirrorLink?>/order/"  class="btn btn--fill">Записаться на ремонт</a>

                    </div>

                </div>
                <div class="divider divider--three"></div>

                <div class="content-block__bottom">

                    <div class="info-block">

                        <p><span class="h2"><span>Бесплатно в <?=$servicename?></span></span></p>
                        <!--<p>Устройства <?=$marka?> разработаны с использованием самых современных технологий, а значит и их обслуживание является задачей технологической.
                                Специалисты сервисного центра <?=$ru_servicename?> большинство неисправностей могут определить при первичном осмотре аппарата, но в некоторых случаях этого недостаточно, 
                                и требуется проводить полное тестирование.</p>-->
                        <?=$diagnostics4_a?>
                        <p><img src="/userfiles/site/large/diagnostics-2.jpg" alt="" title="" width="705" height="200"></p>
                        <p>Диагностика является ключевым действием при обслуживании аппарата &ndash; именно диагностика дает полное представление о состоянии вашего устройства и методах его ремонта.</p>

                    </div>

                </div>
                
                <a href="<?=$multiMirrorLink?>/order/"  class="btn btn--fill">Записаться на ремонт</a>

            </div>

            <? include __DIR__.'/aside.php'; ?>

        </section>

        <div class="clear"></div>