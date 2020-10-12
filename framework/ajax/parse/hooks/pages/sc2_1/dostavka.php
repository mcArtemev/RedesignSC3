<?
use framework\tools;

$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //

$region_name = $this->_datas['region']['name'];//Москва
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$address = $this->_datas['partner']['address1'];

srand($this->_datas['feed']);

$courier = array();
$courier[] = array("Доставка аппарата в $servicename из любой точки $region_name_re","Доставка техники в $servicename из любой точки $region_name_re",
    "Доставка аппарата в сервис из любой точки $region_name_re","Доставка техники в сервис из любой точки $region_name_re","Доставка аппарата в центр из любой точки $region_name_re",
    "Доставка техники в центр из любой точки $region_name_re","Доставка аппарата в мастерскую из любой точки $region_name_re","Доставка техники в мастерскую из любой точки $region_name_re");
$courier[] = array("Прибытие курьера в офис или на дом","Выезд курьера в офис или на дом","Прибытие курьера на дом или в офис","Выезд курьера на дом или в офис");
$courier[] = array("Экономия вашего времени","Экономим ваше время","Экономим время клиентов","Экономим время клиентов сервиса","Экономим время клиентов центра");
$courier[] = array("Сохранность аппарата при транспортировке","Аккуратная транспортировка","Бережная транспортировка");

$courier_a = "";

while ( 0 < count($courier) )
{
    $courier_in = array_rand($courier, 1);

    $courier_in_in = array_rand($courier[$courier_in], 1);
    $courier_a .= "<li><span>" . $courier[$courier_in][$courier_in_in] . "</span></li>";

    unset($courier[$courier_in]);
    //sort($diagnostics);
}


$courier2 = array();
$courier2 = array("Мы стремимся сделать наше обслуживание совершенным, и с начала 2016 года клиентам $region_name_pril $servicename доступна услуга курьерской доставки. ",
    "Курьер приедет по вашему адресу точно в согласованное время, а вы сэкономите время на поездку в сервис-центр.");

$courier2_a = "<p>" . $this->checkcolumn($courier2) . "</p>";

$simple = array();
$simple = array("Просто и удобно","Удобно и просто","Быстро и удобно","Удобно и быстро","Быстро и просто","Просто и быстро");
$simple_a = $this->checkcolumn($simple);

/*$simple2 = array();
$simple2 = array("Услуга доставки проста и эффективна.","Вам не потребуется выбирать время и добираться в сервис в часы пик.",
    "Кроме того, процедура приема аппарата в ремонт при курьерской доставке происходит непосредственно при передаче устройства курьеру.",
    "С этого момента сохранность вашего $marka гарантируется $ru_servicename.");

$simple2_a = "<p>" . $this->checkcolumn($simple2) . "</p>";*/


?>

    <section class="fixed content-wrapper">
            <div class="content-block">

                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><img src="/bitrix/templates/centre/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span>Выезд курьера</span>
                </section>

                <div class="content-block__top">

                    <div class="info-block">

                        <h1><?=$this->_ret['h1']?></h1>

                        <img src="/bitrix/templates/centre/img/site/large/vyezd-kurera.jpg" width="350" height="110" alt="Выезд курьера" title="Выезд курьера">

                        <ul class="list">
                            <!--
                            <li><span>Доставка аппарата в <?=$servicename?> из любой точки <?=$this->_datas['region']['name_re']?></span></li>
                            <li><span>Прибытие курьера в офис или на дом </span></li>
                            <li><span>Экономия вашего времени</span></li>
                            <li><span>Сохранность аппарата при транспортировке</span></li>
                            -->
                            <?=$courier_a?>
                        </ul>

                        <!--<p>Мы стремимся сделать наше обслуживание совершенным,и с начала 2016 года клиентам <?=$servicename?> доступна услуга курьерской доставки.
                                Курьер приедет по вашему адресу точно в согласованное время, а вы сэкономите время на поездку в сервис-центр.</p>-->
                        <?=$courier2_a?>
                        <a href="/zakaz/"  class="btn btn--fill">Записаться на ремонт</a>

                    </div>

                </div>
                <div class="divider divider--three"></div>

                <div class="content-block__bottom">

                    <div class="info-block">

                        <p><span class="h2"><span><?=$simple_a?><!--Просто и удобно--></span></span></p>
                        <p>Услуга доставки проста и эффективна. Вам не потребуется выбирать время и добираться в сервис в часы пик. Кроме того, процедура приема аппарата в ремонт при курьерской доставке происходит непосредственно при передаче устройства курьеру. С этого момента сохранность вашего устройства гарантируется <?=$ru_servicename?>.</p>
                        <p><img src="/bitrix/templates/centre/img/site/large/delivery-2.jpg" alt="" title="" width="705" height="200"></p>

                    </div>

                </div>

                <a href="/zakaz/"  class="btn btn--fill">Записаться на ремонт</a>

            </div>

            <? include __DIR__.'/aside.php'; ?>

        </section>

        <div class="clear"></div>
