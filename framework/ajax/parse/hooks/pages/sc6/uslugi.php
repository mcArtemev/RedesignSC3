<?php
use framework\tools;
use framework\pdo;

use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$marka = $this->_datas['marka']['name'];  // SONY
$marka_lower = mb_strtolower($marka);
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ

$region_name = $this->_datas['region']['name'];//Москва
$region_name_eng = $this->_datas['region']['translit2'];//Moscow
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);

srand($this->_datas['site_id']);

$uslugi = array();
$uslugi_rand_all = rand(1,2);
if($uslugi_rand_all == 1)
{
    $uslugi[] = array("Распространённые","Часто встречающиеся","Популярные","Рейтинговые");
    $uslugi[] = array("услуги для");
    $uslugi[] = array("техники","устройств","аппаратов");
    $uslugi[] = array("в");
    $uslugi_rand1 = rand(1,2);
    if($uslugi_rand1 == 1)
    {
        $uslugi[] = array("нашей");
        $uslugi[] = array("мастерской.","мастерской RuExpert.");
    }
    if($uslugi_rand1 == 2)
    {
        $uslugi[] = array("нашего");
        $uslugi[] = array("сервисного центра.","сервиса.","СЦ.","сервисного центра RuExpert.","сервиса RuExpert.","СЦ RuExpert.");
    }
}
if($uslugi_rand_all == 2)
{
    $uslugi[] = array("Услуги","Список услуг");
    $uslugi[] = array("к");
    $uslugi[] = array("часто","наиболее часто");
    $uslugi[] = array("встречающимся");
    $uslugi[] = array("поломкам","неисправностям");
    $uslugi[] = array("устройств ".$marka.".","техники ".$marka.".","аппаратов ".$marka.".");
}

$types = [];

foreach ($this->_datas['all_devices'] as $type) {
  $types[$type['type']] = service_service::selectPopular(service_service::getForType($type['type'], $this->_datas['site_id']), $this->_datas['site_id']);
}

helpers6::skShuffle($types, 0, $this->_datas['site_id']);

?>

<?php helpers6::breadcrumbs([
	['/', 'Главная'],
  [0, 'Услуги'],
]); ?>
<main>
    <section class="all-services">
        <div class="container">
            <div class="part_header">
                <h1 class="part-title part-title__center part-title__bold" style="font-size: 30px">Услуги по ремонту устройств <?=$marka?></h1>
            </div>
            <noindex>
                <p class="part-txt">Вам повезло стать обладателем техники <?=$marka?>, которая славится по всему миру своей надежностью и всегда популярна. Но если вы заподозрили поломку любимого гаджета, то не нужно расстраиваться. Наши мастера высоко квалифицированы и найдут подход к любому вашему устройству, к каждой модели <?=$marka?>! Мы любим свою работу.</p>
                <div class="all-services__inner">
                    <? $t = 0;
                      foreach ($types as $typeName => $typeService) {
                      if (count($typeService)) {
                    ?>
                    <div class="all-services__item">
                        <h3><?=$this->firstup($typeName)?></h3>
                        <? /*<p><? srand($this->_datas['site_id']+$t++); echo $this->checkarray($uslugi)?></p> */ ?>
                        <ul class="list-unstyled all-services__list">
                          <?php foreach (array_slice($typeService, 0, 5) as $service) { ?>
                          <li>
                            <?php if ($service['urlWork'] == 1) { ?>
                              <span><a href = "<?=service_service::fullUrl($service['type'], $service['url'])?>"><?=$service['name']?></a></span>
                            <?php } else { ?>
                              <span><?=$service['name']?></span>
                            <?php } ?>
                          </li>
                          <?php } ?>
                        </ul>
						
                        <a href = "/o_kompanii/price_list/#to-<?=service_service::TYPES_TR_NAME[$typeName]?>" class="btn btn-blue">
                            Все услуги
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                    </div>
                    <?php }
                  } ?>
                </div>
            </noindex>
        </div>
    </section>
    <?php srand($this->_datas['feed']); include 'preference.php'; ?>
</main>
