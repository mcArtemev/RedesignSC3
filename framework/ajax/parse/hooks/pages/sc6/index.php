<?php

use framework\tools;
use framework\pdo;
use framework\rand_it;

use framework\ajax\parse\hooks\pages\sc6\data\src\service_service;
use framework\ajax\parse\hooks\pages\sc6\data\src\helpers6;

$marka = $this->_datas['marka']['name'];  // SONY
$marka_lower = mb_strtolower($marka);
$servicename = $this->_datas['servicename']; //SONY Russia
$ru_servicename = $this->_datas['ru_servicename']; //
$ru_marka = $this->_datas['marka']['ru_name']; // СОНИ
$marka_lower = mb_strtolower($marka);

$region_name = $this->_datas['region']['name'];//Москва
$region_name_eng = $this->_datas['region']['translit2'];//Moscow
$region_name_pril = $this->_datas['region']['pril'];//Московского
$region_name_pe = $this->_datas['region']['name_pe'];//в Москве (в Владивостоке)
$region_name_de = $this->_datas['region']['name_de'];//по Москве (Владивостоку)
$region_name_re = $this->_datas['region']['name_re'];//служба Москвы (Владивостока)
$phone = $this->_datas['phone'];
$phone_format = tools::format_phone($phone);

$metrica = $this->_datas['metrica'];

$malfunctions = require_once __DIR__ . '/data/malfunctions.php';

$feed = $this->_datas['feed'];

srand($this->_datas['feed']);
$ustroista_all = "";

// if($marka == "Airwheel" && $this->_datas['region']['name'] =='Тула'){
//         //print_r($this->_datas['all_devices']);
//     //print_r($services);
// }
$all_deall_devices = $this->_datas['all_devices'];
if(count($all_deall_devices) == 0)
{
    $sql =  "SELECT `markas`.`name` as `markasname`, `model_types`.`name` as `type`, `model_types`.`id` as `type_id`,
                `model_types`.`name_m` as `type_m`,`model_types`.`name_rm` as `type_rm`,
                `model_types`.`name_re` as `type_re`  FROM `model_type_to_markas`
      INNER JOIN `markas` ON `markas`.`id` = `model_type_to_markas`.`marka_id` INNER JOIN `model_types` ON `model_types`.`id` = `model_type_to_markas`.`model_type_id` WHERE `markas`.`name` = \"".$marka. "\"" ;
    $all_deall_devices = pdo::getPdo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
}


foreach ($all_deall_devices as $item)
{
    $ustroista_all .= $item['type_m'] . ", ";
}
$ustroista_all = substr($ustroista_all,0,-2);


$h1 = array();
$h1[0][] = array("Сервисный центр");
$h1[1][0] = array("$servicename $region_name","$servicename $region_name_eng");
//флаг
$h1_flag = $this->checkcolumn($h1[1][0]);

$h2 = array();
$h2[] = array("Квалифицированный","Профессиональный","Качественный","Фирменный");
$h2[] = array("ремонт");
$h2[] = array("техники","устройств","");
$h2[] = array($marka);
$h2[] = array("в $region_name_pe");

$abzatc = array();
$abzatc[] = array("Сервисный центр","Сервис центр","Ремонтный центр");
if($h1_flag == "$servicename $region_name")
{
    $abzatc[] = array("$servicename $region_name_eng");
}
if($h1_flag == "$servicename $region_name_eng")
{
    $abzatc[] = array("$servicename $region_name");
}

$abzatc[] = array("осуществляет","проводит","выполняет");
$abzatc[] = array("оперативный","быстрый");
$abzatc[] = array("ремонт");
$abzatc[] = array("$marka,");
$abzatc[] = array("чиним:");
$abzatc[] = array($ustroista_all);
$abzatc[] = array(" - любой ремонт","- ремонт любой сложности","- ремонт любого уровня сложности");
$abzatc[] = array("от чистки","от замены корпусов","от замены динамиков","от замены разъемов","от замены портов","от замены шлейфов","от замены кнопок","от замены гнезд питания",
    "от замены разъемов питания","от замены разъемов зарядки","от замены гнезда питания","от замены гнезда зарядки");
$abzatc[] = array("до");
$abzatc[] = array("ремонта плат","ремонта элементов плат","ремонта системных плат","ремонта мультиконтроллеров","ремонта контроллеров","ремонта контроллеров плат","ремонта ШИМ-контроллеров",
    "ремонта PWM-контроллеров","ремонта чипов");
$abzatc[] = array("и");
$abzatc[] = array("перепайки цепей питания.","перепайки цепей питания плат.","перепайки чипов.","перепайки BGA-чипов.","реболла чипов.","реболла BGA-чипов.");

$abzatc_2 = array();
$abzatc_2[0][] = array("Быть клиентом");
$abzatc_2[0][] = array("Экспертов","нашего центра","нашего сервиса","нашего ремонтного центра");
$abzatc_2[0][] = array("выгодно:");
$abzatc_2[1][] = array("фиксированные цены","честные цены","фиксированная стоимость услуг","понятная стоимость услуг","доступная стоимость услуг","фиксированные цены","честные цены");
$abzatc_2[1][] = array("бесплатная экспресс диагностика","бесплатная срочная диагностика","бесплантная диагностика","срочная диагностика","экспресс диагностика","лабораторная диагностика",
    "достоверная диагностика");
$abzatc_2[1][] = array("короткие сроки ремонта","оптимальные сроки ремонта","сжатые сроки ремонт","кратчайшие сроки ремонта","лучшие в городе сроки ремонта",
    "кратчайшие в городе сроки ремонта");
$abzatc_2[1][] = array("гарантии на все работы","гарантии на любой ремонт","гарантии на все услуги","гарантии на услуги и комплектующие","гарантии на комплектующие и услуги",
    "гарантии на все ремонтные работы","длительная гарантия","длительная гарантия на все услуги","длительная гарантия на все работы","длительная гарантия на ремонт",
    "гарантии на лабораторный ремонт");
$abzatc_2[1][] = array("оригинальные запчасти","оригинальные комплектующие","все комплектующие в наличии","фирменные запчасти","фирменные комплектующие");

$abzatc_2_out = $this->checkarray($abzatc_2[0]) ." ";

$abzatc_2_count = count($abzatc_2[1]);
for ($i = 0;$i < $abzatc_2_count;$i++)
{
    $abzatc_2_ar = array_rand($abzatc_2[1]);
    $abzatc_2_out .= $this->checkcolumn($abzatc_2[1][$abzatc_2_ar]) . ", ";
    unset($abzatc_2[1][$abzatc_2_ar]);
}
$abzatc_2_out = substr($abzatc_2_out,0,-2);

/*
<img src="/img/ico-1.png" alt=""><h3>Бесплатная диагностика</h3><!--<span>10 минут</span>--><p>Бесплатная диагностика<br>Вашего устройства в течении<br>десяти минут времени</p>
*/

$typeText = [];

foreach ($this->_datas['all_devices'] as $type) {
  $feedL = $this->_datas['feed']+$type['type_id'];
  srand($feedL);
  switch($type['type']) {
    case 'ноутбук':
      $rand = ['аппаратные', 'программные'];
      shuffle($rand);
      $text = [
        ['Наши'],
        ['инженеры','мастера'],
        ['проведут','сделают'],
        ['диагностику и'],
        ['быстро','оперативно'],
        ['устранят','исправят'],
        [$rand[0].' и '.$rand[1].' неисправности.'],

        ['Гарантия'],
        ['предоставляется','дается'],
        ['на'],
        ['выполненную','произведенную'],
        ['работу и'],
        ['установленные','поставленные'],
        ['комплектующие.'],
      ];
    break;
    case 'планшет':
      $rand = ['заражения вирусами','механических повреждений','неправильных настроек'];
      shuffle($rand);
      $text = [
        ['Неисправности','Неполадки'],
        ['в','при'],
        ['работе планшета'],
        ['возникают','появляются'],
        ['по причине'],
        [$rand[0].', '.$rand[1].' и '.$rand[2].'.'],

        ['Наши'],
        ['инженеры','мастера','специалисты'],
        ['отремонтируют','починят'],
        ['сломавшееся','вышедшее из строя'],
        ['устройство в'],
        ['кратчайший','минимальный'],
        ['срок!'],
      ];
    break;
    case 'смартфон':
      $rand = ['аппаратные', 'программные'];
      shuffle($rand);
      $text = [
        ['Наш сервисный центр'],
        ['оказывает','предоставляет'],
        ['услуги по ремонту смартфонов '.$this->_datas['marka']['name']],

        ['Квалифицированные','Опытные'],
        ['техники','мастера'],
        ['быстро'],
        ['устраняют','исправят'],
        [$rand[0].' и '.$rand[1].' неисправности.'],
      ];
    break;
    case 'игровая приставка':
      $text = [
        ['Ваша','Если Ваша'],
        ['консоль','приставка'],
        ['работает'],
        ['неисправно','некорректно'],
        ['или не включается?'],

        ['Производительность','Качество'],
        ['в играх'],
        ['снизилась','понизилась'],
        ['без'],
        ['видимых','явных'],
        ['причин?'],

        ['Наши'],
        ['инженеры','менеджеры'],
        ['отремонтируют','починят'],
        ['приставку','консоль'],
        ['быстро и качественно!'],
      ];
    break;
    case 'компьютер':
      $rand = ['не запускается', 'зависает без причины'];
      shuffle($rand);
      $text = [
        ['Ваш','Когда Ваш'],
        ['компьютер работает'],
        ['слишком','очень'],
        ['медленно.'],

        ['Система'.$rand[0].' или '.$rand[1].'.'],

        ['Воспользуйтесь'],
        ['услугами','помощью'],
        ['нашего сервисного центра –'],
        ['квалифицированные','опытные'],
        ['мастера','специалисты'],
        ['быстро','оперативно'],
        ['отремонтируют','починят'],
        ['ваш ПК!']
      ];
    break;
    case 'монитор':
      $text = [
        ['На мониторе'],
        ['отсутствует','пропадает'],
        ['картинка?','изображение?'],

        ['Изображение выводится с'],
        ['дефектами?','неточностями?','искажением?'],

        ['Воспользуйтесь нашими услугами –'],
        ['квалифицированные','опытные'],
        ['специалисты','инженеры'],
        ['быстро','оперативно'],
        ['отремонтируют'],
        ['неисправную','вышедшую из строя'],
        ['технику!'],
      ];
    break;
    case 'моноблок':
      $text = [
        ['Наш сервисный центр'],
        ['ремонтирует','чинит'],
        ['моноблоки '.$this->_datas['marka']['name'].' по'],
        ['выгодным','доступным'],
        ['ценам!'],

        ['Квалифицированные','Опытные'],
        ['инженеры','мастера','специалисты'],
        ['проведут диагностику и устранят неисправность в кратчайший срок.'],
      ];
    break;
    case 'принтер':
      $text = [
        ['Принтер не'],
        ['работает','включается'],
        ['или'],
        ['неправильно','некорректно'],
        ['печатает'],
        ['цвета?','изображение?'],

        ['Необходимо','Нужно'],
        ['провести диагностику и устранить'],
        ['источник','причину'],
        ['неисправности','неполадки'],
        ['– наши'],
        ['инженеры','мастера','специалисты'],
        ['быстро','оперативно'],
        ['справятся с этой задачей!'],
      ];
    break;
    case 'проектор':
      $text = [
        ['Вам'],
        ['необходимо','нужно'],
        ['отремонтировать','починить'],
        ['проектор?'],

        ['Наши'],
        ['техники','мастера'],
        ['быстрооперативно','своевременно'],
        ['обнаружат','найдут'],
        ['причину'],
        ['неисправной','неверной'],
        ['работы и в кратчайший срок'],
        ['отремонтируют','восстановят'],
        ['устройство!']
      ];
    break;
    case 'телевизор':
      $rand = ['звук отсутствует', 'изображение искажено', 'подключаемые устройства не распознаются', 'включение происходит с задержкой'];
      shuffle($rand);
      $text = [
        ['Телевизор'],
        ['не включается?','перестал включаться?'],

        [tools::mb_ucfirst($rand[0]).', '.$rand[1].', '.$rand[2].', '.$rand[3].'?'],

        ['Наши'],
        ['инженеры','мастера','специалисты'],
        ['отремонтируют','починят'],
        ['ваш телевизор'],
        ['быстро','оперативно'],
        ['и качественно!'],
      ];
    break;
    case 'фотоаппарат':
      $rand = ['оптики', 'матрицы', 'ультразвукового мотора'];
      shuffle($rand);
      $text = [
        ['Неисправности','Неполадки'],
        ['в','при'],
        ['работе фотоаппарата'],
        ['возникают','появляются'],
        ['по причине'],
        ['повреждения','дефекта'],
        [implode(', ',$rand)],
        ['и других деталей.'],

        ['Наши'],
        ['специалисты','мастера'],
        ['обнаружат','определят'],
        ['неисправность','поломку'],
        ['и'],
        ['отремонтируют','починят'],
        ['фотокамеру в'],
        ['кратчайший','минимальный'],
        ['срок!'],
      ];
    break;
    case 'холодильник':
      $rand = ['износа деталей', 'перепадов напряжения'];
      shuffle($rand);
      $text = [
        ['Холодильники ломаются'],
        ['из-за','по причине'],
        ['нарушения','пренебрежения'],
        ['правил эксплуатации,'],
        [$rand[0].' и '.$rand[1]],
        ['в сети.'],

        ['Воспользуйтесь услугами нашего сервисного центра –'],
        ['доверьте','поручите'],
        ['ремонт'],
        ['профессионалам!','специалистам!'],
      ];
    break;
    case 'сервер':
      $rand = ['нагрузок', 'перепадов напряжения'];
      shuffle($rand);
      $text = [
        ['Зачастую, серверы выходят из строя'],
        ['из-за','по причине'],
        ['частых','регулярных'],
        [$rand[0].' и '.$rand[1]],
        ['во время работы.'],
        ['Обратитесь в наш сервисный центр –'],
        ['доверьте','поручите'],
        ['ремонт'],
        ['профессионалам!','экспертам!'],
      ];
    break;
    default:
      $text = [['']];
  }
  $typeText[$type['type']] = self::_createTree($text, $feedL);
}

$types = [];


foreach ($this->_datas['all_devices'] as $type) {
    
          $types[$type['type']] = [
            'code' => service_service::TYPES_TR_NAME[$type['type']],
            'names' => $type,
            'services' => service_service::selectPopular(service_service::getForType($type['type'], $this->_datas['site_id']), $this->_datas['site_id']),
          ];
    
}
helpers6::skShuffle($types, 0, $this->_datas['site_id']);
                
// if($marka == "Philips"){
//     print_r($types);
// }
if($marka == "Airwheel" && $this->_datas['region']['name'] =='Тула'){
//         //print_r($this->_datas['all_devices']);
//     $wtf = service_service::getForType($type['type'], $this->_datas['site_id']);
//     echo "<pre><br>";
//     print_r($wtf);
//     //print_r($wtf[0]['names'][0]);
//     echo "</pre></br>";
}

?>
<section class="slogan">
    <div class="container">
        <div class="slogan__inner">

            <div class="slogan-left slogan-left-important" >
                <h1><?=$this->checkarray($h1[0])." ".$marka?></h1>
                <div class="slogan-list">
                    <h3>Мы ремонтируем:</h3>
                    <? $twoColumn = (count($types)>9)? 'twoColumn' :''; 
                        $croppedTypes = cropArrTypes($types);
                    ?>
                    <ul class="slogan-list__inner <?=$twoColumn?>">
                      <? foreach ($croppedTypes as $typeName => $type) { ?>
                        <li><a href = "/<?=$this->_datas['types_urls'][$typeName]?>/"><?=$type['names']['type_m']?></a></li>
                      <? } ?>
                    </ul>
                </div>
            </div>
            <? include 'data/inc/formRequest.php'; ?>

        </div>
    </div>
</section>

<main>
    <section class="section-attentiveness">
        <div class="container">
            <div class="part_header">
                <h2 class="part-title part-title__center part-title__light"><?=$this->checkarray($h2)?></h2>
            </div>
            <p class="part-txt"><?=$this->checkarray($abzatc)?> <?=$abzatc_2_out?></p>
            <div class="row dell-box">
    <?php       if(!empty($types)){
                //var_dump($types);
                $types = tools::sortByPriority($types);
                    foreach ($types as $typeName => $type) { 
    ?>
                        <div class="col-md-3 col-sm-6 dell-box__item">
                            <div class="dell-item">
                                <div class="dell-item__img">
                                    <a href="/<?=$this->_datas['types_urls'][$typeName]?>/">
                                    
                                    
                            
                                     <img src="/_mod_files/_img/<?= $marka_lower . '/' . service_service::TYPES_TR_NAME[$typeName];?>.png" alt="">
                               
                                    </a>
                                </div>
                                <div class="dell-item__title text-left">
                                    <a href="/<?=$this->_datas['types_urls'][$typeName]?>/"><?= tools::mb_ucfirst($type['names']['type_m'], 'UTF-8', false);?></a>
                                </div>
                                <div class="dell-item__info text-left">
                                    <?//=$typeText[$typeName]?>
                                </div>
                                <div class="dell-item__btn">
                                    <a href="/<?=$this->_datas['types_urls'][$typeName]?>/" class="btn btn-blue">
                                        Подробнее <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
    <?php           }
                }
    ?>
            </div>
        </div>
    </section>

    <section class="popular-services">
        <div class="part_header">
            <h2>Популярные услуги.</h2>
        </div>
        <div class="container">
            <div class="popular-services__inner">
              <ul class="nav nav-tabs nav-tabs-custom owl-carousel " role="tablist" style="overflow: hidden; font-size: 40px;">
                  <?
                  $firstType = true;
                  foreach ($types as $typeName => $type) {
                  if (count($type['services'])) { ?>
                  <div>
                    <li class="nav-item <?php if ($firstType) {?>active<?php } ?>">
                      <a class="nav-link" href="#<?=$type['code']?>" role="tab" data-toggle="tab" <?php if ($firstType) { $firstType = false;?>aria-expanded="true"<?php } ?>>
                        <?=tools::mb_ucfirst($type['names']['type_m'])?>
                      </a>
                    </li>
                  </div>
                  <?
                  }
                  }
                  unset($firstType);
                  ?>
              </ul>
              <div class="tab-content tab-content-custom">
                  <?
                  $firstType = true;
                  foreach ($types as $typeName => $type) {
                  if (count($type['services'])) { ?>
                  <div role="tabpanel" class="tab-pane fade<?php if ($firstType) { $firstType = false; ?>in active<?php } ?>" id="<?=$type['code']?>">
                      <?php
                        $services = $type['services'];
                        include 'data/inc/tablePrice.php';
                      ?>
                  </div>
                  <?
                }}
                  unset($firstType);?>
              </div>
            </div>
			<noindex><p style="font-weight: 300;">Цены указаны за работу специалиста без учета стоимости запчастей.<br/>Стоимость диагностики составляет 500 рублей. В случае проведения ремонтных работ диагностика в подарок.<br> В таблице указано среднее время оказания услуги при условии наличия необходимой для ремонта комплектующей.</p></noindex>
            <div class="tab-btn">
                <a href = "/o_kompanii/price_list/" class="btn btn-blue">
                    Все услуги
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>
    <?php srand($this->_datas['feed']); include 'preference.php'; ?>
</main>
