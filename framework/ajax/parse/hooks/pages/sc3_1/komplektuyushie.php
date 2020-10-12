<?

use framework\tools;
use framework\rand_it;
use framework\pdo;
use framework\ajax\parse\hooks\sc;

$marka = $this->_datas['marka']['name'];
$marka_ru = $this->_datas['marka']['ru_name'];
$marka_upper = mb_strtoupper($marka);
$marka_lower = mb_strtolower($this->_datas['marka']['name']);

$address = $this->_datas['region']['name'].', '.(($this->_datas['partner']['address2']) ? $this->_datas['partner']['address2'] : $this->_datas['partner']['address1']);

$str = '';

$types = [];
$complects = [];

include __DIR__.'/data/price.php';

foreach ($this->_datas['all_devices'] as $k => $type) {
  if (isset($type['type_id']))   
    $types[$type['type_id']] = $type['type'];
  else
  {
     $complects[$type['type']] = $complect_block[$this->_datas['accord'][$type['type']]];
     $types[(-1) * $k] = $type['type'];
  }
}

if (isset($this->_datas['all_complects']))
{
    foreach ($this->_datas['all_complects'] as $complect) {
      $complects[$types[$complect['model_type_id']]][] = $complect;
    }
}

srand($this->_datas['feed']);
foreach ($complects as $k=>$v) {
  shuffle($complects[$k]);
}
srand();

$texts = array();
$texts[] = array('<p>В нашей ремонтной лаборатории', '<p>В нашей лаборатории', '<p>На нашем локальном складе лаборатории',
            '<p>В нашей ремонтной мастерской', '<p>В нашей мастерской', '<p>На нашем локальном складе, в мастерской');
$texts[] = array('по адресу:');
$texts[] = array($address.',');
$texts[] = array('всегда', 'постоянно', '');
$texts[] = array('есть в наличии', 'есть', 'присутствует');
$texts[] = array('большинство', 'большая часть');
$texts[] = array('популярных', 'распространенных', 'часто используемых', 'часто требующихся', 'часто востребованных',
            'часто необходимых');
$texts[] = array('комплектующих', 'запчастей', 'запасных частей');
$texts[] = array('и');
$texts[] = array('все', 'все необходимые');
$texts[] = array('расходные материалы:', 'все расходники:', 'все расходные материалы:', 'любые расходные материалы:');

$t_array = array();
$t_array[] = array('ШИМы', 'ШИМ контроллеры','PWM контроллеры', 'ШИМ (PWM) контроллеры', 'ШИМ-контроллеры', 'контроллеры PWM');
$t_array[] = array('микросхемы', 'чипы', 'оригинальные чипы', 'оригинальные чипы/микросхемы');
$t_array[] = array('транзисторы', 'диоды/транзисторы',	'конденсаторы, транзисторы', 'конденсаторы, диоды', 'резисторы, транзисторы, конденсаторы',	'резисторы, конденсаторы');
$t_array[] = array('термопаста', 'термопрокладки', 'термоклей',	'термоскотч', 'термоклеи/термопасты', 'термопасты, термопрокладки');
$t_array[] = array('BGA шары для реболла', 'BGA шарики разного диаметра', 'BGA шарики', 'свинцовые BGA шары', 'BGA шарики для реболлла', 'свинцовые BGA шары для реболла');
$t_array[] = array('флюс', 'BGA флюс', 'флюс BGA');
$t_array[] = array('винты', 'наборы винтов', 'болтики', 'запасы винтов');
$t_array[] = array('сокеты', 'сокеты для материнских плат',	'сокеты для плат', 'сокеты материнских плат', 'сокеты плат');
$t_array[] = array('разъемы', 'разъемы питания', 'разъемы, шлейфы',	'шлейфы, разъемы питания', 'разъемы платы, шлейфы',	'шлейфы, разъемы');
$t_array[] = array('штекеры', 'штекеры и шнуры питания', 'оплетки, штекеры', 'спреи', 'спреи, очищающие жидкости',	'штекеры, оплетки, спреи');
$t_array[] = array('процессоры', 'микропроцессоры', 'CPU', 'процессоры (CPU)');
$t_array[] = array('жесткие диски',	'ssd/hdd носители',	'ssd, hdd винчестеры',	'ssd, hdd диски',	'жесткие ssd/hdd диски', 'ssd, hdd диски разных объемов');
$t_array[] = array('оперативная память', 'ОЗУ', 'комплекты ОЗУ', 'оперативная память (ОЗУ)', 'ОЗУ (оперативная память)', 'наборы ОЗУ');

$feed = $this->_datas['feed'];
srand($feed);
$t_array = rand_it::randMas($t_array, rand(4, 6), '', $feed);
$count = count($t_array) - 1;

foreach ($t_array as $key => $value)
{
    foreach ($value as $k => $v)
    {
        if ($key != $count)
           $t_array[$key][$k] = $v.';';
        else
           $t_array[$key][$k] = $v.'.';
    }

    $texts[] = $t_array[$key];
}

$texts[] = array('Редкие комплектующие,', 'Редко используемые комплектующие,');
$texts[] = array('которые могут понадобиться в ходе');
$texts[] = array('ремонта', 'ремонтных работ');
$texts[] = array('дозаказываются', 'заказываются');
$texts[] = array('ежедневно -');
$texts[] = array('это');
$texts[] = array('позволяет', 'дает возможность');
$texts[] = array('гарантировать');
$texts[] = array('клиентам');
$texts[] = array('сервиса', 'сервисного центра', 'сервис центра');
$texts[] = array($this->_datas['servicename']);

$choose = rand(0, 1);
switch ($choose)
{
    case 0:
        $texts[] = array('оптимальные', 'лучшие');
        $texts[] = array('сроки доставки');
    break;
    case 1:
        $texts[] = array('оптимальное', 'лучшее');
        $texts[] = array('время доставки');
    break;
}

$texts[] = array('с центрального склада', 'с главного склада');
$texts[] = array('и оперативный ремонт.</p>');

$total = array();
$total[] = array('<p>Гарантия на');
$total[] = array('устанавливаемые');
$total[] = array('в '.$this->_datas['servicename']);
$total[] = array('комплектующие','запчасти','запасные части');
$total[] = array('от 6 месяцев до 3 лет</p>', 'до 3 лет</p>');

$this->_datas['total'] = sc::_createTree($total, $feed);

?>
        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['komplektuyushie'];
        include __DIR__.'/banner.php'; ?>

        <div class="aboutrow">
            <div class="container">
                <div class="abouttext">
                   <?=sc::_createTree($texts, $feed);?>
                </div>
            </div>
        </div>

        <div class="popularrow">
            <div class="container">
                <h2>Популярные комплектующие</h2>
                <div class="tables-wrapper">
                  <?php foreach ($types as $id=>$type) { ?>
                  <div class="tables">
                    <div class="title"><?=tools::mb_ucfirst($type)?></div>
                    <ul class="popularlist">
                      <?php foreach (array_slice($complects[$type], 0, 5) as $complect) { ?>
                      <? if ($id>0):?>
                        <li><a href = "/<?=$this->urlType($type, true)?>/<?=$complect['url']?>/"><?=$this->randomSyns($complect['name'], $complect['syns'])?></a></li>
                      <?else:
                        $complect = (array) $complect;?>
                        <li><span><?=($complect[0])?></span></li>
                      <?endif?>
                      <?php } ?>
                    </ul>
                  </div>
                  <?php } ?>
                </div>
            </div>
        </div>

         <? include __DIR__.'/banner-total.php'; ?>

         <?=$this->_datas['preims']?>

        <ul class="breadcrumb">
            <li><a href="/<?=$marka_lower?>/">Главная</a></li>
            <li>Качественные комплектующие</li>
        </ul>
