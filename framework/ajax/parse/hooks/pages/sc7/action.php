<?php
use framework\tools;
use framework\pdo;
use framework\rand_it;

$servicename = $this->_datas['servicename'];
$marka = $this->_datas['marka']['name'];  // SONY

srand($this->_datas['feed']);

$povtornoeobrashenie = array();
$povtornoeobrashenie[] = array("Вам довелось");
$povtornoeobrashenie[] = array("ремонтировать","восстанавливать");
$povtornoeobrashenie[] = array("устройство","аппарат","технику");
$povtornoeobrashenie[] = array("в сервисном центре","в сервисе","в СЦ");
$povtornoeobrashenie[] = array($servicename . ".");
$povtornoeobrashenie[] = array("Вам понравился");
$povtornoeobrashenie[] = array("подход к делу","подход к задаче","подход к работе");
$povtornoeobrashenie_rand1 = rand(1,2);
if($povtornoeobrashenie_rand1 == 1)
{
    $povtornoeobrashenie[] = array("нашего персонала,","персонала,");
    $povtornoeobrashenie[] = array("его");
}
if($povtornoeobrashenie_rand1 == 2)
{
    $povtornoeobrashenie[] = array("специалистов","наших специалистов");
    $povtornoeobrashenie[] = array("их");
}
$povtornoeobrashenie[] = array("высокая квалификация?","профессионализм?");
if(!empty($this->_datas['hab']) && !empty($this->_datas['hb'])){
    $povtornoeobrashenie[] = array("Приходите к нам вновь - и получите скидку 15% на заправку картриджей");
}else{
    $povtornoeobrashenie[] = array("Приходите  к нам вновь - вам положена скидка за повторное обращение");
    $povtornoeobrashenie[] = array(rand(5,10)."%."); 
}
/*
$besplatnayadiagnostika = array();
$besplatnayadiagnostika[] = array("У вас");
$besplatnayadiagnostika[] = array("сломался","неисправен","поломался");
$besplatnayadiagnostika[] = array("ваш девайс", "ваш гаджет");
$besplatnayadiagnostika[] = array($marka."?");
$besplatnayadiagnostika[] = array("Приносите","Привезите");
$besplatnayadiagnostika[] = array("устройство","аппарат");
$besplatnayadiagnostika[] = array("к нам.");
$besplatnayadiagnostika[] = array("Только");
$besplatnayadiagnostika_rand = rand(1,2);
if($besplatnayadiagnostika_rand == 1)
{
    $besplatnayadiagnostika[] = array("в этом месяце");
}
if($besplatnayadiagnostika_rand == 2)
{
    $besplatnayadiagnostika[] = array("на этой неделе");
}
$besplatnayadiagnostika[] = array("диагностика","тестирование","аппаратная диагностика");
$besplatnayadiagnostika[] = array("бесплатно.");
*/

$besplatnayadiagnostika = array();
$besplatnayadiagnostika[] = array("У вас");
$besplatnayadiagnostika[] = array("сломался","неисправен","поломался");
$besplatnayadiagnostika[] = array("ваш девайс", "ваш гаджет");
$besplatnayadiagnostika[] = array($marka."?");
$besplatnayadiagnostika[] = array("Приносите","Привезите");
$besplatnayadiagnostika[] = array("устройство","аппарат");
$besplatnayadiagnostika[] = array("к нам.");
$besplatnayadiagnostika[] = array("Только");
$besplatnayadiagnostika_rand = rand(1,2);
if($besplatnayadiagnostika_rand == 1)
{
    $besplatnayadiagnostika[] = array("в этом месяце");
}
if($besplatnayadiagnostika_rand == 2)
{
    $besplatnayadiagnostika[] = array("на этой неделе");
}
$besplatnayadiagnostika[] = array("при записи онлайн");
$besplatnayadiagnostika[] = array("скидка 5%.");


$akcii = array();
$akcii = array("скидки","снижение стоимости","акционные услуги");
$vakansii = array();
$vakansii = array("карьера","работа в успешной компании");


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
if($uslugi_rand == 3)
{
    $uslugi = array("стоимость","перечисление услуг");
}

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

?>

<main>
    <section class="breadcrumbs">
        <div class="container">
            <div class="grid-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <ul class="breadcrumbs-inside">
                       <li itemprop="name"><a href="/" itemprop="url">Главная</a></li>
                            <li class="breadcrumbs-inside-drop">
                                <span itemprop="name"><a itemprop="url" href="/about/">О компании</a></span>
                                <span class="breadcrumbs-inside-drop-btn"></span>
                                <ul class="drop">
                                    <li itemprop="name"><a itemprop="url" href="/about/vacancy/">Вакансии</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/contacts/">Контакты</a></li>
                                    <li itemprop="name"><a itemprop="url" href="/about/price/">Услуги и цены</a></li>
                                </ul>
                            </li>
                        <li itemprop="name"><span>Акции</span></li>
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
    <section class="articles actions">
        <div class="container">
            <div class="grid-12">
                <div class="articles-inside">
                    <div class="item">
                        <div class="articles-info">
                            <div class="articles-title">
                                <span>Скидка при повторном обращении</span>
                            </div>
                            <div class="articles-text"><?=$this->checkarray($povtornoeobrashenie)?></div>
                        </div>
                        <div class="articles-image">
                            <img src="/images/action/discount<? $mas = array(); for ($i=1; $i<=6; $i++) $mas[] = $i;
                                    $action = rand_it::randMas($mas, 2, '', $this->_datas['feed']); echo $action[0];?>.png">
                        </div>
                    </div>
                    <div class="item">
                        <div class="articles-info">
                            <div class="articles-title">
                                <?//<span>Бесплатная диагностика</span>?>
                                <span>Скидка при записи онлайн</span>
                            </div>
                            <div class="articles-text"><?=$this->checkarray($besplatnayadiagnostika)?></div>
                        </div>
                        <div class="articles-image">
                            <img src="/images/action/discount<?=$action[1]?>.png">
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-12">
                <div class="link-block-list perelink">
                        <a href="/about/contacts/" class="link-block">
                            <div class="link-block-title-strong">Контакты</div><?=$this->firstup($this->rand_arr_str($kontakti))?>
                        </a>
                        <a href="/about/vacancy/" class="link-block">
                            <div class="link-block-title-strong">Вакансии</div><?=$this->firstup($this->rand_arr_str($vakansii))?>
                        </a>
						<a href="/about/action/" class="link-block">
							<div class="link-block-title-strong">Акции</div><?=$this->firstup($this->rand_arr_str($akcii))?>
						</a>
                </div>
            </div>
        </div>

    </section>
</main>
