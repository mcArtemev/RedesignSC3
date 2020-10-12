<?
use framework\tools;

$marka = $this->_datas['marka']['name'];  // SONY
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ

$region_name = $this->_datas['region']['name'];//Москва
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);
$address = $this->_datas['partner']['address1'];

srand($this->_datas['feed']);

$express = array();
$express[] = array("Срочный ремонт в течение 1-2 часа","Срочный ремонт за 1-2 часа","Экспресс ремонт производится 1-2 часа","Срочный ремонт производится за 1-2 часа",
    "Экспресс  ремонт в течение 1-2 часа","Экспресс ремонт за 1-2 часа");
$express[] = array("Устранение типовых неисправностей за 24 часа","Устранение неисправностей за 24 часа","Устранение всех распространенных неисправностей",
    "Устранение всех типовых неисправностей","Устранение типовых неисправностей за 24 часа","Устранение типовых неисправностей за 24 часа");
$express[] = array("Сертифицированные специалисты","Дипломированные специалисты","Опытные специалисты","Квалифицированные специалисты","Сертифицированные мастера",
    "Дипломированные мастера","Опытные мастера","Квалифицированные мастера");
$express[] = array("Комплектующие на все основные модели – в наличии","Комплектующие на основные модели – в наличии","Комплектующие на все популярные модели – в наличии",
    "Комплектующие на ходовые модели – в наличии","Запасные части на все основные модели – в наличии","Запасные части на основные модели – в наличии",
    "Запасные части на все популярные модели – в наличии","Запасные части на ходовые модели – в наличии","Запчасти на все основные модели – в наличии",
    "Запчасти на основные модели – в наличии","Запчасти на все популярные модели – в наличии","Запчасти на ходовые модели – в наличии");

$express_a = "";

while ( 0 < count($express) )
{
    $express_in = array_rand($express, 1);

    $express_in_in = array_rand($express[$express_in], 1);
    $express_a .= "<li><span>" . $express[$express_in][$express_in_in] . "</span></li>";

    unset($express[$express_in]);
    //sort($diagnostics);
}

$express2 = array();

$express2 = array("Срочное и квалифицированное обслуживание – это то, на что может рассчитывать любой обладатель устройства $ru_marka. В $servicename знают о качестве все, но теперь это еще и вопрос времени.",
    "В $region_name_pril $servicename знают о качестве все, но теперь это еще и вопрос времени.");

$express2_a = "<p>" . $this->checkcolumn($express2) . "</p>";


$expeditious_service = array("Мы знаем, что персональные устройства $marka уже стали неотъемлемой частью жизни своих владельцев, и обходиться без них длительное время некомфортно. Поэтому в $ru_servicename мы не теряем ни минуты, и осуществляем ремонт именно в те сроки, в которые он должен быть выполнен.");

$expeditious_service_a = "";
$expeditious_service_a .=  "<p>" . $this->checkcolumn($expeditious_service) . " ";

/*$expeditious_service2 = array();
$expeditious_service2[] = array("Привозите свой аппарат","Привозите свою технику","Сломанную технику привозите","Сломанные устройства привозите");
$expeditious_service2[] = array("по адресу:","в сервис по адресу:","к нам по адресу:");
$expeditious_service2[] = array("город","");
$expeditious_service2[] = array("$region_name,");
$expeditious_service2[] = array("$address".".");

$expeditious_service_a .= $this->checkarray($expeditious_service2) . "</p>";*/

?>
    
    <section class="fixed content-wrapper">
            <div class="content-block">

                <section class="crumbs">
                    <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="/"><meta itemprop="title" content="Главная"/><img src="/img/home.png" alt="home"/></a></span>
                    <span> / </span>
                    <span>Экспресс ремонт</span>
                </section>

                <div class="content-block__top">

                    <div class="info-block">

                        <h1><?=$this->_ret['h1']?></h1>

                        <img src="/userfiles/site/large/ekspress-remont.jpg" width="350" height="110" alt="Экспресс ремонт" title="Экспресс ремонт">

                        <ul class="list">
                            <!--<li><span>Срочный ремонт в течение 1-2 часа</span></li>
                            <li><span>Устранение типовых неисправностей за 24 часа</span></li>
                            <li><span>Сертифицированные специалисты</span></li>
                            <li><span>Комплектующие на все основные модели – в наличии</span></li>-->
                            <?=$express_a?>
                        </ul>

                        <!--<p>Срочное и квалифицированное обслуживание &ndash; это то, на что может рассчитывать любой обладатель устройства <?=$ru_marka?>. В <?=$servicename?> знают
                                о качестве все, но теперь это еще и вопрос времени.</p>-->
                        <?=$express2_a?>
                        <a href="/order/"  class="btn btn--fill">Записаться на ремонт</a>

                    </div>

                </div>
                <div class="divider divider--three"></div>

                <div class="content-block__bottom">

                    <div class="info-block">

                        <p><span class="h2"><span>Оперативное обслуживание</span></span></p>
                        <!--<p>Мы знаем, что персональные устройства <?=$marka?> уже стали неотъемлемой частью жизни своих владельцев, и обходиться без них длительное время некомфортно. Поэтому в <?=$ru_servicename?> мы не теряем ни минуты, и осуществляем ремонт именно в те сроки, в которые он должен быть выполнен.</p>-->
                        <?=$expeditious_service_a?>
                        <p><img src="/userfiles/site/large/services-2.jpg" alt="" title="" width="705" height="200"></p>
                        <p>С каждым отремонтированным устройством в <?=$servicename?> и с каждой улыбкой наших клиентов, мы понимаем, что делаем свою работу хорошо.</p>

                    </div>

                </div>
                
                <a href="/order/"  class="btn btn--fill">Записаться на ремонт</a>
            </div>
            
            <? include __DIR__.'/aside.php'; ?>

        </section>

        <div class="clear"></div>
