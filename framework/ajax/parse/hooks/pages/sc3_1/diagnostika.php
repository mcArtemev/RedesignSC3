<?

use framework\tools;
use framework\rand_it;
use framework\pdo;
use framework\ajax\parse\hooks\sc;

$marka = $this->_datas['marka']['name'];
$marka_ru = $this->_datas['marka']['ru_name'];
$marka_upper = mb_strtoupper($marka);
$marka_lower = mb_strtolower($this->_datas['marka']['name']);

$types = [];
$services = [];

include __DIR__.'/data/price.php';

foreach ($this->_datas['all_devices'] as $k => $type) {
  if (isset($type['type_id']))
    $types[$type['type_id']] = $type['type'];
  else
  {
    $services[$type['type']] = $info_block[$this->_datas['accord'][$type['type']]];
    $types[(-1) * $k] = $type['type'];
  }
}

if (isset($this->_datas['all_services']))
{
    foreach ($this->_datas['all_services'] as $service) {
      $services[$types[$service['model_type_id']]][] = $service;
    }
}

srand($this->_datas['feed']);
foreach ($services as $k=>$v) {
  shuffle($services[$k]);
}
srand();

$texts = array();
$texts[] = array('<p>Диагностика -', '<p>Комплексная диагностика -');
$texts[] = array('важный');
$texts[] = array('этап');
$texts[] = array('ремонта');
$texts[] = array('любого устройства,', 'любого гаджета,', 'любой модели устройства,', 'любой техники,');
$texts[] = array('только');
$texts[] = array('ознакомившись');
$texts[] = array('с причинами');
$texts[] = array('неисправности', 'поломки');
$texts[] = array('и проведя ');
$texts[] = array('техническое', '');
$texts[] = array('программное и аппаратное', 'аппаратное и программное');
$texts[] = array('тестирование');
$texts[] = array('можно');
$texts[] = array('делать оценку');
$texts[] = array('сроков и стоимости', 'стоимости и сроков');
$texts[] = array('ремонта.', 'ремонтных работ.', 'любого ремонта.', 'любых ремонтных работ.');

$texts[] = array('Не имея', 'Не имея на руках');
$texts[] = array('результатов', 'итоговый результат');
$texts[] = array('диагностики', 'диагностики аппарата');
$texts[] = array('нельзя');
$texts[] = array('приступать', 'переходить');
$texts[] = array('к ремонту!</p>');

$texts[] = array('<p><strong>Срочная программная диагностика -', '<p><strong>Программная экспресс диагностика -');
$texts[] = array('от 5', 'от 10', 'от 15');
$texts[] = array('минут</strong>.<br/>');

$texts[] = array('Программное тестирование');
$texts[] = array('может проводиться как ');
$texts[] = array('в лаборатории ', 'в мастерской');
$texts[] = array('сервиса,');
$texts[] = array('так и на выезде.</p>', 'так и у вас на дому.</p>');

$texts[] = array('<p><strong>Срочная аппаратная диагностика -', '<p><strong>Аппаратная экспресс диагностика -');
$texts[] = array('от 20', 'от 25', 'от 30', 'от 45');
$texts[] = array('минут</strong>.<br/>');

$texts[] = array('Аппаратное тестирование');
$texts[] = array('проводиться');
$texts[] = array('исключительно', 'только');
$texts[] = array('в лаборатории', 'в мастерской');
$texts[] = array('сервисного центра', 'сервиса', 'сервис центра');
$texts[] = array('с полной');
$texts[] = array('или частичной');
$texts[] = array('разборкой');
$texts[] = array('аппарата.', 'устройства.');

$texts[] = array('По запросу');
$texts[] = array('владельца');
$texts[] = array('устройства', 'гаджета', 'девайса');
$texts[] = array('матером', 'сервисным инженером');
$texts[] = array('может быть');
$texts[] = array('выдано', 'выписано');
$texts[] = array('техническое заключение');
$texts[] = array('на фирменном бланке');
$texts[] = array('организации.', 'компании.', $this->_datas['servicename'].'.</p>');

$total = array();
$total[] = array('<p>Гарантия на');
$total[] = array('работы', 'услуги', 'проведенные работы', 'ремонтные работы');
$total[] = array('в '.$this->_datas['servicename']);
$total[] = array('до 6 месяцев,');
$total[] = array('на устанавливаемые');
$total[] = array('комплектующие', 'запчасти', 'запасные части');
$total[] = array('до 3 лет</p>');

$feed = $this->_datas['feed'];
$this->_datas['total'] = sc::_createTree($total, $feed);

?>

        <div class="title-row">
            <div class="container">
                <h1><?=$this->_ret['h1']?></h1>
            </div>
        </div>

        <? $banner_img = '/templates/moscow/img/shared/banners/'.$this->_datas['images']['diagnostika'];
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
                <h2>Популярные услуги</h2>
                <div class="tables-wrapper">
                    <?php foreach ($types as $id=>$type) { ?>
                    <div class="tables">
                      <div class="title"><?=tools::mb_ucfirst($type)?></div>
                      <ul class="popularlist">
                        <?php foreach (array_slice($services[$type], 0, 5) as $service) { ?>
                        <?if ($id>0):?>
                            <li><a href = "/<?=$this->urlType($type)?>/<?=$service['url']?>/"><?=$this->randomSyns($service['name'], $service['syns'])?></a></li>
                        <?else:?>
                            <li><span><?=$service[0]?></span></li>
                        <?endif;?>
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
            <li>Срочная диагностика, тех. заключение</li>
        </ul>
